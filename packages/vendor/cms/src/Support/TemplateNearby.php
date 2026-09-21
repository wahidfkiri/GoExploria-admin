<?php

namespace Vendor\Cms\Support;

use App\Models\Etablissement;
use App\Models\MapPoint;
use App\Models\Ville;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Grille « À proximité » d'un template CMS : les lieux de la carte GoExploria
 * — restaurants, hébergements, événements, activités… — situés autour de
 * l'établissement, du plus proche au plus lointain.
 *
 * Même mécanique que [[TemplateActivities]] : une grille `data-gx-nearby`, une
 * carte modèle `data-gx-nearby-card`, des champs `data-gx-field` (image, name,
 * category, city, distance, link). Options de la grille :
 *
 *   data-gx-nearby-limit    nombre de lieux (défaut : nombre de cartes livrées)
 *   data-gx-nearby-radius   rayon de recherche en km (défaut 30, 1 à 200)
 *   data-gx-nearby-category restreint à un groupe (resto, hebergement…)
 *
 * CENTRE DE LA RECHERCHE — l'établissement n'a pas de coordonnées en propre :
 *   1. la moyenne de SES points de carte (onglet « Géo Maps Vidéos ») ;
 *   2. sinon, les coordonnées de sa ville (`ville_id`).
 * Sans centre, ou sans lieu dans le rayon, la grille garde sa démonstration
 * ([[TemplateGrid]]) plutôt que d'afficher une section vide.
 *
 * FILTRES — chaque carte reçoit `data-categorie`, la clé de son GROUPE
 * (resto, hebergement, evenement, activite, culture, nature, shopping,
 * autre), déduite de la catégorie du point. Les boutons de filtre du gabarit
 * comparent cette clé : une catégorie saisie « Bistro » ou « Hôtel » tombe
 * ainsi d'elle-même dans le bon filtre, sans liste à tenir à jour ailleurs.
 */
class TemplateNearby extends TemplateGrid
{
    /** Rayon par défaut, en kilomètres. */
    public const RAYON = 30;

    /**
     * Groupes de filtres, dans l'ORDRE d'essai : « Parc aventure » doit tomber
     * dans les activités avant que « parc » ne l'envoie à la nature.
     */
    public const GROUPES = [
        'resto'       => '/restaurant|resto|\bbar\b|caf[ée]|bistro|brasserie|cuisine|gastronom|boulanger|traiteur|\bpub\b|pizz|table/iu',
        'hebergement' => '/h[ôo]tel|h[ée]bergement|chalet|g[îi]te|auberge|camping|motel|appartement|r[ée]sidence|\bb&b\b|lodge|chambre|villa|location/iu',
        'evenement'   => '/[ée]v[ée]nement|festival|concert|spectacle|salon|soir[ée]e|agenda|f[êe]te/iu',
        'activite'    => '/activit[ée]|loisir|sport|aventure|plein air|randonn[ée]e|famille|excursion|tourisme|v[ée]lo|ski|kayak/iu',
        'culture'     => '/culture|mus[ée]e|patrimoine|histoire|\bart\b|th[ée][âa]tre|galerie|mus[ée]um/iu',
        'nature'      => '/nature|plage|\blac\b|montagne|for[êe]t|jardin|parc|belv[ée]d[èe]re|rivi[èe]re/iu',
        'shopping'    => '/shopping|boutique|commerce|march[ée]|magasin|artisan/iu',
    ];

    protected function marqueur(): string
    {
        return 'data-gx-nearby';
    }

    protected function marqueurCarte(): string
    {
        return 'data-gx-nearby-card';
    }

    /** Ajoute le rayon aux options communes (limite, catégorie…). */
    protected function options(string $balise): array
    {
        $options = parent::options($balise);

        $rayon = self::RAYON;
        if (preg_match('/\sdata-gx-nearby-radius\s*=\s*("([^"]*)"|\'([^\']*)\')/i', $balise, $m)) {
            $lu = (float) str_replace(',', '.', trim($m[2] ?? $m[3] ?? ''));
            if ($lu > 0) {
                $rayon = $lu;
            }
        }
        $options['radius'] = max(1.0, min(200.0, $rayon));

        return $options;
    }

    /**
     * Lieux actifs dans le rayon, hors ceux de l'établissement lui-même, du
     * plus proche au plus lointain.
     *
     * @return Collection<int, array{point: MapPoint, distance: float, groupe: string, categorie: ?string}>
     */
    protected function elements(int $limite, array $options)
    {
        $centre = $this->centre();
        if ($centre === null) {
            return collect();                // démonstration conservée
        }

        [$lat, $lng] = $centre;
        $rayon = (float) ($options['radius'] ?? self::RAYON);
        $dLat = $rayon / 111;
        $dLng = $rayon / (111 * max(0.01, cos(deg2rad($lat))));
        $maintenant = now();

        $requete = MapPoint::query()
            ->where('is_active', true)
            ->whereNotNull('latitude')->whereNotNull('longitude')
            ->whereBetween('latitude', [$lat - $dLat, $lat + $dLat])
            ->whereBetween('longitude', [$lng - $dLng, $lng + $dLng])
            ->where(fn ($q) => $q->whereNull('etablissement_id')->orWhere('etablissement_id', '!=', $this->etablissementId))
            // Un lieu programmé (événement daté) n'apparaît que dans sa fenêtre.
            ->where(fn ($q) => $q->whereNull('display_start_date')->orWhere('display_start_date', '<=', $maintenant))
            ->where(fn ($q) => $q->whereNull('display_end_date')->orWhere('display_end_date', '>=', $maintenant))
            ->limit(300);

        if (method_exists(MapPoint::class, 'mapCategory')) {
            $requete->with('mapCategory');
        }

        $groupeVoulu = trim((string) ($options['category'] ?? ''));

        return $requete->get()
            ->map(function (MapPoint $point) use ($lat, $lng) {
                $categorie = $this->nomCategorie($point);

                return [
                    'point'     => $point,
                    'distance'  => $this->distanceKm($lat, $lng, (float) $point->latitude, (float) $point->longitude),
                    'categorie' => $categorie,
                    'groupe'    => self::groupe($categorie . ' ' . $point->type . ' ' . $point->title),
                ];
            })
            ->filter(fn ($l) => $l['distance'] <= $rayon)
            ->filter(fn ($l) => $groupeVoulu === '' || $l['groupe'] === $groupeVoulu)
            ->sortBy('distance')
            ->take($limite)
            ->values();
    }

    protected function remplirCarte(
        \DOMDocument $doc,
        \DOMXPath $xpath,
        \DOMElement $carte,
        $lieu,
        array $options
    ): void {
        /** @var MapPoint $point */
        $point = $lieu['point'];
        $lien = $this->lien($point);

        $carte->setAttribute('data-gx-nearby-id', (string) $point->id);
        // Clé de groupe lue par les boutons de filtre du gabarit.
        $carte->setAttribute('data-categorie', $lieu['groupe']);

        foreach ($this->champs($xpath, $carte) as $noeud) {
            switch ($noeud->getAttribute('data-gx-field')) {
                case 'image':
                    $this->poserImage($noeud, $this->image($point) ?? self::visuelNeutre(), (string) $point->title);
                    break;

                case 'name':
                    $this->poserTexte($doc, $noeud, (string) $point->title);
                    break;

                case 'category':
                    $lieu['categorie'] === null
                        ? $this->retirer($noeud)
                        : $this->poserTexte($doc, $noeud, $lieu['categorie']);
                    break;

                case 'city':
                    $ville = trim((string) $point->ville);
                    $ville === '' ? $this->retirer($noeud) : $this->poserTexte($doc, $noeud, $ville);
                    break;

                case 'distance':
                    $this->poserTexte($doc, $noeud, self::distanceLisible($lieu['distance']));
                    break;

                case 'desc':
                    $this->poserTexte($doc, $noeud, Str::limit(trim(strip_tags((string) $point->description)), 110));
                    break;

                case 'link':
                    $noeud->setAttribute('href', $lien);
                    break;
            }
        }

        // Carte entièrement cliquable ; un lien sortant s'ouvre à côté.
        if ($carte->tagName === 'a') {
            $carte->setAttribute('href', $lien);
            if (Str::startsWith($lien, ['http://', 'https://'])) {
                $carte->setAttribute('target', '_blank');
                $carte->setAttribute('rel', 'noopener');
            }
        }
    }

    /**
     * Centre de la recherche : points de l'établissement, sinon sa ville.
     *
     * @return array{0: float, 1: float}|null
     */
    protected function centre(): ?array
    {
        $propres = MapPoint::query()
            ->where('etablissement_id', $this->etablissementId)
            ->where('is_active', true)
            ->whereNotNull('latitude')->whereNotNull('longitude')
            ->get(['latitude', 'longitude']);

        if ($propres->isNotEmpty()) {
            return [(float) $propres->avg('latitude'), (float) $propres->avg('longitude')];
        }

        $villeId = Etablissement::query()->whereKey($this->etablissementId)->value('ville_id');
        if ($villeId) {
            $ville = Ville::query()->find($villeId, ['id', 'latitude', 'longitude']);
            if ($ville && $ville->latitude !== null && $ville->longitude !== null
                && ((float) $ville->latitude !== 0.0 || (float) $ville->longitude !== 0.0)) {
                return [(float) $ville->latitude, (float) $ville->longitude];
            }
        }

        return null;
    }

    /** Clé de groupe d'une catégorie libre. */
    public static function groupe(string $texte): string
    {
        foreach (self::GROUPES as $cle => $motif) {
            if (preg_match($motif, $texte)) {
                return $cle;
            }
        }

        return 'autre';
    }

    /** « à 850 m », « à 2,4 km », « à 18 km ». */
    public static function distanceLisible(float $km): string
    {
        // Arrondi aux 50 m D'ABORD : 999,98 m devenait « à 1000 m » au lieu de
        // « à 1,0 km » — l'arrondi franchissait le seuil après le choix d'unité.
        $metres = (int) (round($km * 1000 / 50) * 50);
        if ($metres < 1000) {
            return 'à ' . max(50, $metres) . ' m';
        }
        $km = $metres / 1000;

        return $km < 10
            ? 'à ' . number_format($km, 1, ',', ' ') . ' km'
            : 'à ' . (int) round($km) . ' km';
    }

    protected function distanceKm(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $r = 6371.0;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;

        return $r * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

    private function nomCategorie(MapPoint $point): ?string
    {
        $nom = null;
        if ($point->relationLoaded('mapCategory') && $point->mapCategory) {
            $nom = $point->mapCategory->name ?? null;
        }
        $nom = trim((string) ($nom ?: $point->category));

        return $nom === '' ? null : $nom;
    }

    /**
     * Destination d'une carte : la page détail du lieu s'il en a une, sinon
     * le site de l'établissement qui l'a publié, sinon l'itinéraire Google.
     */
    private function lien(MapPoint $point): string
    {
        $details = trim((string) $point->details_url);
        if ($point->has_details_page && $details !== '') {
            return $details;
        }

        if ($point->etablissement_id) {
            return '/company/' . (int) $point->etablissement_id;
        }

        return 'https://www.google.com/maps/search/?api=1&query='
            . rawurlencode((float) $point->latitude . ',' . (float) $point->longitude);
    }

    /** Visuel du lieu : son image principale, sinon la vignette de sa vidéo. */
    private function image(MapPoint $point): ?string
    {
        $chemin = trim((string) $point->main_image);
        if ($chemin !== '') {
            return Str::startsWith($chemin, ['http://', 'https://', '//', 'data:'])
                ? $chemin
                : asset('storage/' . ltrim($chemin, '/'));
        }

        $youtube = trim((string) $point->youtube_id);
        if ($youtube !== '') {
            return 'https://i.ytimg.com/vi/' . rawurlencode($youtube) . '/hqdefault.jpg';
        }

        return null;
    }

    /**
     * Visuel neutre pour un lieu sans image : garder la photo de démonstration
     * montrerait un restaurant sur la fiche d'un musée.
     */
    public static function visuelNeutre(): string
    {
        $svg = "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 260'>"
            . "<defs><linearGradient id='g' x1='0' y1='0' x2='1' y2='1'>"
            . "<stop offset='0' stop-color='#dfe8fb'/><stop offset='1' stop-color='#f6e7df'/></linearGradient></defs>"
            . "<rect width='400' height='260' fill='url(#g)'/>"
            . "<path d='M200 70c-27 0-48 21-48 47 0 35 48 83 48 83s48-48 48-83c0-26-21-47-48-47zm0 66a19 19 0 1 1 0-38 19 19 0 0 1 0 38z' fill='#2459e0' opacity='.55'/></svg>";

        return 'data:image/svg+xml,' . rawurlencode($svg);
    }
}
