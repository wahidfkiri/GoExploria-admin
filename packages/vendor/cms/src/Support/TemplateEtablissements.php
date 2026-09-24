<?php

namespace Vendor\Cms\Support;

use App\Models\Activity;
use App\Models\Etablissement;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Grille « Établissements » d'une page d'ACTIVITÉ : les établissements qui
 * proposent cette activité (table de liaison `activity_etablissement`), avec
 * des filtres par catégorie.
 *
 * Même mécanique que [[TemplateActivities]] et [[TemplateNearby]] : une
 * grille `data-gx-etablissements`, des cartes modèles `data-gx-etablissement`,
 * des champs `data-gx-field` (image, name, category, city, desc, link).
 * Options de la grille :
 *
 *   data-gx-etablissements-limit     nombre de cartes (défaut : cartes livrées)
 *   data-gx-etablissements-category  restreint à une catégorie (son slug)
 *
 * ─────────────────────────────────────────────────────────────────────────
 * CE QUI LE DISTINGUE DES AUTRES GRILLES
 * ─────────────────────────────────────────────────────────────────────────
 * 1. Le pivot n'est pas l'établissement mais l'ACTIVITÉ : `hydrateActivite()`
 *    remplace `hydrate()`, et l'identifiant porté par le socle est celui de
 *    l'activité (voir `activityId()`).
 *
 * 2. LES FILTRES SONT CONSTRUITS DEPUIS LA BASE. Les catégories d'un
 *    établissement sont celles des activités qu'il propose : une liste figée
 *    dans le gabarit se périmerait au premier rattachement. Le conteneur
 *    `data-gx-etablissements-filtres` est donc reconstruit après la grille,
 *    à partir des SEULES catégories réellement présentes — pas de bouton qui
 *    ne renvoie rien. Chaque carte porte ses catégories dans `data-categorie`
 *    (slugs séparés par des espaces, un établissement pouvant relever de
 *    plusieurs), ce que le script du gabarit compare.
 *
 * 3. REPLI, comme partout : sans établissement rattaché, la grille et ses
 *    filtres gardent leur démonstration — une section d'exemple vaut mieux
 *    qu'un trou sur un site en ligne.
 */
class TemplateEtablissements extends TemplateGrid
{
    /** Catégories des éléments affichés, pour reconstruire les filtres. */
    protected array $categoriesVues = [];

    /**
     * Contexte DESTINATION : ['type' => 'ville', 'id' => 12].
     *
     * Renseigné par hydrateDestination(). Quand il l'est, la grille liste les
     * établissements situés dans cette destination au lieu de ceux qui
     * proposent une activité.
     */
    protected ?array $destination = null;

    /**
     * Chaîne des destinations, telle que la porte
     * App\Models\EtablissementDestination côté administration (elle n'existe
     * pas dans ce projet).
     *
     * `parents` liste les colonnes menant à un niveau supérieur : ⚠ les
     * niveaux intermédiaires sont SAUTABLES — une ville peut pendre de son
     * secteur, de sa région, de sa province ou de son pays. Descendre par la
     * seule colonne « officielle » manquerait les villes rattachées plus haut,
     * et la section afficherait un « à proximité » incomplet.
     */
    protected const CHAINE = [
        'continent'      => ['table' => 'continents',      'parents' => []],
        'country'        => ['table' => 'countries',       'parents' => ['continent_id' => 'continent']],
        'province'       => ['table' => 'provinces',       'parents' => ['country_id' => 'country']],
        'region'         => ['table' => 'regions',         'parents' => ['province_id' => 'province']],
        'secteur'        => ['table' => 'secteurs',        'parents' => ['region_id' => 'region']],
        'ville'          => ['table' => 'villes',          'parents' => [
            'secteur_id' => 'secteur', 'region_id' => 'region', 'province_id' => 'province', 'country_id' => 'country',
        ]],
        'arrondissement' => ['table' => 'arrondissements', 'parents' => ['ville_id' => 'ville']],
        'quartier'       => ['table' => 'quartiers',       'parents' => [
            'arrondissement_id' => 'arrondissement', 'ville_id' => 'ville',
        ]],
    ];

    /** Le site public nomme les villes « city » ; la table de liaison, « ville ». */
    protected const TYPES_SITE = [
        'city' => 'ville', 'cities' => 'ville', 'villes' => 'ville',
        'continents' => 'continent', 'countries' => 'country', 'provinces' => 'province',
        'regions' => 'region', 'secteurs' => 'secteur',
        'arrondissements' => 'arrondissement', 'quartiers' => 'quartier',
    ];

    /** Nombre d'identifiants retenus par niveau en descendant la chaîne. */
    protected const PLAFOND_NIVEAU = 5000;

    /**
     * Hydrate la page d'une DESTINATION : les établissements situés dedans,
     * du niveau lui-même jusqu'aux quartiers.
     *
     * @param string $type Niveau ('ville', 'city', 'region'…)
     */
    public static function hydrateDestination(string $html, string $type, ?int $destinationId): string
    {
        $instance = new static(0);
        $type = self::TYPES_SITE[$type] ?? $type;

        if ($destinationId === null
            || ! isset(self::CHAINE[$type])
            || strpos($html, $instance->marqueur()) === false) {
            return $html;
        }

        try {
            $instance = new static(0);
            $instance->destination = ['type' => $type, 'id' => (int) $destinationId];

            return $instance->poserFiltres($instance->parcourir($html));
        } catch (\Throwable $e) {
            Log::warning(static::class . ' : hydratation abandonnée — ' . $e->getMessage(), [
                'destination' => $type . '#' . $destinationId,
            ]);

            return $html;
        }
    }

    /**
     * Hydrate une page d'activité.
     *
     * `hydrate()` du socle prend un établissement : ce point d'entrée le
     * remplace pour ne pas laisser croire qu'on peut appeler l'un pour
     * l'autre.
     */
    public static function hydrateActivite(string $html, ?int $activityId): string
    {
        $instance = new static(0);

        if ($activityId === null || strpos($html, $instance->marqueur()) === false) {
            return $html;
        }

        try {
            $instance = new static((int) $activityId);

            return $instance->poserFiltres($instance->parcourir($html));
        } catch (\Throwable $e) {
            Log::warning(static::class . ' : hydratation abandonnée — ' . $e->getMessage(), [
                'activity_id' => $activityId,
            ]);

            return $html;
        }
    }

    /** L'identifiant porté par le socle est celui de l'activité. */
    protected function activityId(): int
    {
        return $this->etablissementId;
    }

    protected function marqueur(): string
    {
        return 'data-gx-etablissements';
    }

    protected function marqueurCarte(): string
    {
        return 'data-gx-etablissement';
    }

    /**
     * Établissements actifs qui proposent l'activité, dans l'ordre choisi à
     * l'espace activité (colonne `order` du pivot).
     *
     * @return Collection<int, array{etablissement: Etablissement, categories: array, ville: string, image: ?string, lien: string}>
     */
    protected function elements(int $limite, array $options)
    {
        return $this->destination === null
            ? $this->elementsDeLActivite($limite, $options)
            : $this->elementsDeLaDestination($limite, $options);
    }

    /**
     * Établissements situés dans la destination — elle-même et tout ce qui
     * pend en dessous : la page d'une région liste aussi les établissements de
     * ses villes et de leurs quartiers, ce qu'on attend d'un « à proximité ».
     *
     * @return Collection<int, array<string, mixed>>
     */
    protected function elementsDeLaDestination(int $limite, array $options)
    {
        $paires = $this->pairesDescendantes($this->destination['type'], $this->destination['id']);

        if ($paires === []) {
            return collect();
        }

        $ids = \Illuminate\Support\Facades\DB::table('etablissement_destinations')
            ->where(function ($q) use ($paires) {
                foreach ($paires as $type => $valeurs) {
                    $q->orWhere(fn ($sous) => $sous->where('destination_type', $type)->whereIn('destination_id', $valeurs));
                }
            })
            ->distinct()
            ->limit(500)
            ->pluck('etablissement_id');

        if ($ids->isEmpty()) {
            return collect();
        }

        $etablissements = Etablissement::query()
            ->whereIn('id', $ids)
            ->where('is_active', true)
            ->with(['activities' => fn ($q) => $q->select('activities.id', 'activities.name', 'activities.categorie_id')->with('categoryRelation:id,name')])
            ->orderBy('name')
            ->limit(120)
            ->get();

        return $this->lignes($etablissements, $limite, $options);
    }

    /**
     * Identifiants de la destination et de toutes ses descendantes, par
     * niveau : ['region' => [7], 'ville' => [12, 13], …].
     *
     * @return array<string, array<int, int>>
     */
    protected function pairesDescendantes(string $type, int $id): array
    {
        $paires = [$type => [$id]];
        $depart = false;

        foreach (self::CHAINE as $niveau => $definition) {
            if ($niveau === $type) {
                $depart = true;
                continue;
            }

            if (! $depart || $definition['parents'] === []) {
                continue;               // au-dessus du départ : hors sujet
            }

            $trouves = [];

            foreach ($definition['parents'] as $colonne => $typeParent) {
                if (empty($paires[$typeParent])) {
                    continue;
                }

                try {
                    if (! Schema::hasColumn($definition['table'], $colonne)) {
                        continue;
                    }

                    $trouves = array_merge($trouves, \Illuminate\Support\Facades\DB::table($definition['table'])
                        ->whereIn($colonne, $paires[$typeParent])
                        ->limit(self::PLAFOND_NIVEAU)
                        ->pluck('id')
                        ->all());
                } catch (\Throwable $e) {
                    Log::warning(static::class . ' : niveau ignoré (' . $niveau . ') — ' . $e->getMessage());
                }
            }

            $trouves = array_values(array_unique(array_map('intval', $trouves)));

            if ($trouves !== []) {
                $paires[$niveau] = array_slice($trouves, 0, self::PLAFOND_NIVEAU);
            }
        }

        return $paires;
    }

    /** Établissements qui proposent l'activité. */
    protected function elementsDeLActivite(int $limite, array $options)
    {
        $activite = Activity::query()->find($this->activityId(), ['id', 'name', 'categorie_id']);

        if (! $activite) {
            return collect();
        }

        $requete = $activite->etablissements()
            ->where('etablissements.is_active', true)
            ->with(['activities' => fn ($q) => $q->select('activities.id', 'activities.name', 'activities.categorie_id')->with('categoryRelation:id,name')]);

        // `is_active` et `order` ont été ajoutés au pivot après coup : sans
        // cette garde, une base qui n'a pas encore reçu la migration ferait
        // échouer la requête — et la section retomberait sur sa démo.
        //
        // ⚠ JAMAIS `when(…, fn ($q) => $q->wherePivot(…))` : la fermeture ne
        // reçoit pas la relation mais le constructeur de requête, qui ne
        // connaît pas `wherePivot` et le prend pour un `where` dynamique sur
        // une colonne « pivot ». MySQL refuserait la requête ; SQLite la
        // traite en silence et ne rend plus AUCUNE ligne. La condition se
        // pose donc sur la relation elle-même.
        if ($this->pivotComplet()) {
            $requete->wherePivot('is_active', true)->orderBy('activity_etablissement.order');
        }

        $etablissements = $requete
            ->orderBy('etablissements.name')
            ->limit(120)
            ->get();

        return $this->lignes($etablissements, $limite, $options);
    }

    /**
     * Met en forme les établissements trouvés — commun aux deux contextes
     * (activité et destination) : visuels en deux requêtes groupées, filtre
     * par catégorie, plafond, et mémorisation des catégories pour les boutons.
     *
     * @param  \Illuminate\Support\Collection<int, Etablissement>  $etablissements
     * @return Collection<int, array<string, mixed>>
     */
    protected function lignes($etablissements, int $limite, array $options): Collection
    {
        if ($etablissements->isEmpty()) {
            return collect();
        }

        $visuels = $this->visuels($etablissements->pluck('id')->all());
        $voulue = Str::slug(trim((string) ($options['category'] ?? '')));

        $lignes = $etablissements
            ->map(function (Etablissement $etablissement) use ($visuels) {
                return [
                    'etablissement' => $etablissement,
                    'categories'    => $this->categories($etablissement),
                    'ville'         => trim((string) $etablissement->ville),
                    'image'         => $visuels[$etablissement->id] ?? null,
                    'lien'          => $this->lien($etablissement),
                ];
            })
            ->filter(fn (array $l) => $voulue === '' || in_array($voulue, array_column($l['categories'], 'slug'), true))
            ->take($limite)
            ->values();

        // Mémorisé pour les filtres : seules les catégories AFFICHÉES doivent
        // devenir des boutons.
        foreach ($lignes as $ligne) {
            foreach ($ligne['categories'] as $categorie) {
                $this->categoriesVues[$categorie['slug']] = $categorie['nom'];
            }
        }

        return $lignes;
    }

    protected function remplirCarte(
        \DOMDocument $doc,
        \DOMXPath $xpath,
        \DOMElement $carte,
        $ligne,
        array $options
    ): void {
        /** @var Etablissement $etablissement */
        $etablissement = $ligne['etablissement'];

        $carte->setAttribute('data-gx-etablissement-id', (string) $etablissement->id);
        $carte->setAttribute('data-categorie', implode(' ', array_column($ligne['categories'], 'slug')));

        foreach ($this->champs($xpath, $carte) as $noeud) {
            switch ($noeud->getAttribute('data-gx-field')) {
                case 'image':
                    $this->poserImage($noeud, $ligne['image'] ?? TemplateNearby::visuelNeutre(), (string) $etablissement->name);
                    break;

                case 'name':
                    $this->poserTexte($doc, $noeud, (string) $etablissement->name);
                    break;

                case 'category':
                    $ligne['categories'] === []
                        ? $this->retirer($noeud)
                        : $this->poserTexte($doc, $noeud, $ligne['categories'][0]['nom']);
                    break;

                case 'city':
                    $ligne['ville'] === ''
                        ? $this->retirer($noeud)
                        : $this->poserTexte($doc, $noeud, $ligne['ville']);
                    break;

                case 'desc':
                    $this->poserTexte($doc, $noeud, $this->resume($etablissement, $ligne));
                    break;

                case 'link':
                    $noeud->setAttribute('href', $ligne['lien']);
                    break;
            }
        }

        if ($carte->tagName === 'a') {
            $carte->setAttribute('href', $ligne['lien']);
        }
    }

    // =====================================================================
    // Filtres
    // =====================================================================

    /**
     * Reconstruit les boutons de filtre à partir des catégories affichées.
     *
     * Le conteneur `data-gx-etablissements-filtres` livre deux boutons au
     * moins : le premier (« Tous ») est conservé tel quel, le second sert de
     * MODÈLE — il est cloné une fois par catégorie. C'est le même procédé que
     * la carte modèle d'une grille : le gabarit garde la main sur l'allure,
     * le site n'écrit que le texte et la valeur.
     *
     * Sans catégorie (aucun établissement rattaché, ou hydratation sautée),
     * le conteneur est laissé intact : la démonstration reste présentable.
     */
    protected function poserFiltres(string $html): string
    {
        if ($this->categoriesVues === [] || strpos($html, 'data-gx-etablissements-filtres') === false) {
            return $html;
        }

        $ouvrante = '/<(?<tag>[a-zA-Z][\w:-]*)(?<attrs>\s[^>]*?)?\sdata-gx-etablissements-filtres(?:\s|=|>)/i';

        if (! preg_match($ouvrante, $html, $m, PREG_OFFSET_CAPTURE)) {
            return $html;
        }

        $debut = $m[0][1];
        $finOuvrante = strpos($html, '>', $debut);

        if ($finOuvrante === false) {
            return $html;
        }
        $finOuvrante++;

        $fermeture = $this->trouverFermeture($html, $m['tag'][0], $finOuvrante);

        if ($fermeture === null) {
            return $html;
        }

        [$debutFermante, $finFermante] = $fermeture;
        $interieur = substr($html, $finOuvrante, $debutFermante - $finOuvrante);

        try {
            $nouveau = $this->reconstruireFiltres($interieur);
        } catch (\Throwable $e) {
            Log::warning(static::class . ' : filtres laissés en l\'état — ' . $e->getMessage());

            return $html;
        }

        return substr($html, 0, $finOuvrante) . $nouveau . substr($html, $debutFermante);
    }

    protected function reconstruireFiltres(string $interieur): string
    {
        $charge = $this->charger($interieur);

        if ($charge === null) {
            return $interieur;
        }

        [$doc, $racine] = $charge;

        $boutons = [];
        foreach ($racine->childNodes as $enfant) {
            if ($enfant instanceof \DOMElement) {
                $boutons[] = $enfant;
            }
        }

        if (count($boutons) < 2) {
            return $interieur;              // rien à cloner : on garde la démo
        }

        $tous = $boutons[0];
        $modele = $boutons[1];

        // « Tous » garde sa place et redevient le filtre actif.
        $tous->setAttribute('data-plx-filtre', '*');

        asort($this->categoriesVues, SORT_NATURAL | SORT_FLAG_CASE);

        foreach ($this->categoriesVues as $slug => $nom) {
            $clone = $modele->cloneNode(true);
            // Deux attributs pour un seul rôle : les gabarits d'activité
            // (Plexify) lisent `data-plx-filtre`, celui des destinations
            // (Carnet d'Atlas) lit `data-gx-filtre`. Les poser tous les deux
            // évite de renommer l'un des deux scripts — et donc de casser les
            // pages déjà enregistrées qui portent l'ancien nom.
            $clone->setAttribute('data-plx-filtre', $slug);
            $clone->setAttribute('data-gx-filtre', $slug);
            $this->poserTexte($doc, $clone, $nom);
            $modele->parentNode->insertBefore($clone, $modele);
        }

        foreach (array_slice($boutons, 1) as $ancien) {
            if ($ancien->parentNode) {
                $ancien->parentNode->removeChild($ancien);
            }
        }

        $out = '';
        foreach ($racine->childNodes as $enfant) {
            $out .= $doc->saveHTML($enfant);
        }

        return $out;
    }

    // =====================================================================

    /**
     * Catégories d'un établissement : celles des activités qu'il propose.
     *
     * @return array<int, array{slug: string, nom: string}>
     */
    protected function categories(Etablissement $etablissement): array
    {
        $categories = [];

        foreach ($etablissement->activities as $activite) {
            $nom = trim((string) ($activite->categoryRelation->name ?? ''));
            $slug = Str::slug($nom);

            if ($nom !== '' && $slug !== '' && ! isset($categories[$slug])) {
                $categories[$slug] = ['slug' => $slug, 'nom' => $nom];
            }
        }

        return array_values($categories);
    }

    /**
     * Visuel de chaque établissement : sa première image de médiathèque,
     * sinon le logo de son site. Une seule requête pour toute la grille —
     * une par carte multiplierait les allers-retours sur la connexion « cms ».
     *
     * @param  array<int, int>  $ids
     * @return array<int, string>
     */
    protected function visuels(array $ids): array
    {
        $visuels = [];

        try {
            if (Schema::connection('cms')->hasTable('cms_media')) {
                $medias = \Vendor\Cms\Models\Media::query()
                    ->whereIn('etablissement_id', $ids)
                    ->where('type', 'image')
                    ->orderBy('id')
                    ->get(['etablissement_id', 'path']);

                foreach ($medias as $media) {
                    $chemin = trim((string) $media->path);
                    if ($chemin !== '' && ! isset($visuels[$media->etablissement_id])) {
                        $visuels[$media->etablissement_id] = $this->url($chemin);
                    }
                }
            }

            if (Schema::connection('cms')->hasTable('cms_settings')) {
                $manquants = array_values(array_diff($ids, array_keys($visuels)));

                if ($manquants !== []) {
                    $logos = \Vendor\Cms\Models\Setting::query()
                        ->whereIn('etablissement_id', $manquants)
                        ->where('key', 'site_logo')
                        ->get(['etablissement_id', 'value']);

                    foreach ($logos as $reglage) {
                        $valeur = trim((string) $reglage->value);
                        if ($valeur !== '') {
                            $visuels[$reglage->etablissement_id] = $this->url($valeur);
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            // Base « cms » indisponible : les cartes prendront le visuel
            // neutre, la section reste affichée.
            Log::warning(static::class . ' : visuels indisponibles — ' . $e->getMessage());
        }

        return $visuels;
    }

    protected function url(string $chemin): string
    {
        return Str::startsWith($chemin, ['http://', 'https://', '//', 'data:'])
            ? $chemin
            : asset('storage/' . ltrim($chemin, '/'));
    }

    /** Le pivot porte-t-il ses colonnes de réglage ? (mémorisé) */
    protected function pivotComplet(): bool
    {
        static $complet = null;

        if ($complet === null) {
            try {
                $complet = Schema::hasColumn('activity_etablissement', 'is_active')
                    && Schema::hasColumn('activity_etablissement', 'order');
            } catch (\Throwable $e) {
                $complet = false;
            }
        }

        return $complet;
    }

    /**
     * Page publique de l'établissement.
     *
     * L'établissement « racine » publie sur « / », les autres sous
     * /company/{id}/{slug} — même règle que le tableau de bord du CMS.
     */
    protected function lien(Etablissement $etablissement): string
    {
        $racine = (int) config('cms.root_etablissement_id');

        if ($racine > 0 && $racine === (int) $etablissement->id) {
            return '/';
        }

        $slug = trim((string) ($etablissement->slug ?: Str::slug((string) $etablissement->name)));

        return '/company/' . $etablissement->id . ($slug !== '' ? '/' . $slug : '');
    }

    /** Une ligne de présentation : la ville et les activités proposées. */
    protected function resume(Etablissement $etablissement, array $ligne): string
    {
        $activites = $etablissement->activities
            ->pluck('name')
            ->filter()
            ->take(3)
            ->implode(', ');

        $morceaux = array_filter([
            $ligne['ville'] !== '' ? $ligne['ville'] : null,
            $activites !== '' ? $activites : null,
        ]);

        return $morceaux === []
            ? (string) $etablissement->lname
            : Str::limit(implode(' · ', $morceaux), 110);
    }
}
