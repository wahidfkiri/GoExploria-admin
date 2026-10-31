<?php

namespace Vendor\Cms\Support;

use Vendor\Cms\Models\Property;

/**
 * Remplit les sections « forfaits » d'un template CMS avec les vrais forfaits
 * de l'établissement (espace entreprise → Immobilier).
 *
 * ─────────────────────────────────────────────────────────────────────────
 * POURQUOI UNE GRILLE SERVEUR, ET PAS `data-im-grid`
 * ─────────────────────────────────────────────────────────────────────────
 *
 * Les gabarits reliés au module Immobilier (Horizon, Voyago, Sylva…) portent
 * une grille `data-im-grid` remplie EN JAVASCRIPT par le script DU GABARIT, à
 * partir de `window.GX_IMMO`. Deux conditions s'y cachent :
 *
 *   · `window.GX_IMMO` n'est émis que si la page contient l'un des wrappers
 *     listés dans `$gxEnveloppesImmo` (partial `gx-immo-data`) ;
 *   · le remplissage est écrit dans CHAQUE gabarit — il n'existe aucun
 *     hydrateur partagé.
 *
 * Une section posée depuis le panneau « Sections » peut atterrir dans
 * n'importe quel gabarit : les deux conditions lui échappent, et sa grille
 * resterait sur sa démonstration sans qu'aucun message ne le signale.
 *
 * D'où cette grille SERVEUR, sur le même socle que [[TemplateProducts]] et
 * [[TemplateActivities]] : elle marche dans tout gabarit, sans JavaScript,
 * sans liste blanche à tenir à jour, et le remplissage a lieu AU RENDU —
 * ajouter un forfait dans l'espace entreprise suffit à mettre le site à jour.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * CE QU'EST UN FORFAIT
 * ─────────────────────────────────────────────────────────────────────────
 *
 * Le module Immobilier ne connaît qu'un seul objet, le « bien ». Un forfait
 * s'y reconnaît à son type ou à son titre — « forfait », « séjour »,
 * « escapade », « circuit »… Même vocabulaire que le gabarit Horizon, pour
 * qu'un bien tombe dans la même case partout.
 *
 * ⚠ « automobile », pas « auto » : le mot nu attraperait « forfait automne ».
 * Un bien qui parle d'un véhicule est écarté — il n'a rien à faire dans une
 * grille de forfaits.
 *
 * Attributs reconnus sur le conteneur :
 *   data-gx-forfaits            active la section (valeur ignorée)
 *   data-gx-forfaits-limit      nombre max de forfaits (déf. : nb de cartes)
 *   data-gx-forfaits-category   filtre sur le type du bien
 *   data-gx-forfaits-sort       price | price-desc | recent (déf. : position)
 *   data-gx-forfaits-currency   symbole monétaire de repli
 *
 * Champs reconnus sur les descendants de la carte (`data-gx-field`) :
 *   image, name, price, unit, desc, duration, capacity, level, type, city,
 *   reference, link
 *
 * ⚠ Un champ sans valeur ne laisse pas la donnée de démonstration en place :
 * elle mentirait. Le nœud est retiré — et avec lui toute sa ligne s'il est
 * placé dans un élément marqué `data-gx-row`, pour ne pas laisser une
 * étiquette « Durée » suivie du vide.
 */
class TemplateForfaits extends TemplateGrid
{
    /** Ce qui désigne un forfait, dans le type ou le titre du bien. */
    private const MOTS_FORFAIT = '/forfait|s[ée]jour|escapade|circuit|itin[ée]raire|package|exp[ée]dition|croisi[èe]re|weekend|week-end|randonn[ée]e|excursion/iu';

    /** Ce qui désigne un véhicule : jamais un forfait. */
    private const MOTS_VEHICULE = '/voiture|v[ée]hicule|automobile|\bvus\b|\bsuv\b|berline|camionnette|fourgonnette|minivan|\b4x4\b|caravane|\bvr\b/iu';

    protected function marqueur(): string
    {
        return 'data-gx-forfaits';
    }

    protected function marqueurCarte(): string
    {
        return 'data-gx-forfait';
    }

    /** @return \Illuminate\Support\Collection<int,Property> */
    protected function elements(int $limite, array $options)
    {
        $query = Property::query()
            ->forEtablissement($this->etablissementId)
            ->visible();

        if (($options['category'] ?? '') !== '') {
            $query->where('type', 'like', '%' . $options['category'] . '%');
        }

        match ($options['sort'] ?? '') {
            'price' => $query->orderBy('price'),
            'price-desc' => $query->orderByDesc('price'),
            'recent' => $query->orderByDesc('id'),
            default => $query->orderBy('position')->orderByDesc('id'),
        };

        // Le tri des forfaits se fait en base, mais le filtrage par
        // vocabulaire doit se faire en PHP : il porte sur deux colonnes à la
        // fois et sur des variantes accentuées qu'un LIKE ne saurait pas
        // rapprocher. On charge donc un peu large, puis on coupe.
        return $query->limit(max(1, $limite) * 4 + 20)->get()
            ->filter(fn (Property $bien) => $this->estForfait($bien))
            ->take(max(1, $limite))
            ->values();
    }

    private function estForfait(Property $bien): bool
    {
        $texte = trim(((string) $bien->type) . ' ' . ((string) $bien->title));

        if ($texte === '' || preg_match(self::MOTS_VEHICULE, $texte)) {
            return false;
        }

        return (bool) preg_match(self::MOTS_FORFAIT, $texte);
    }

    protected function remplirCarte(
        \DOMDocument $doc,
        \DOMXPath $xpath,
        \DOMElement $carte,
        $bien,
        array $options
    ): void {
        $carte->setAttribute('data-gx-forfait-id', (string) $bien->id);

        $valeurs = [
            'name'      => trim((string) $bien->title),
            'price'     => $this->prix($bien, $options),
            'unit'      => $this->unite($bien),
            'desc'      => $this->description($bien),
            'duration'  => $this->duree($bien),
            'capacity'  => $bien->capacity ? $bien->capacity . ' personne' . ($bien->capacity > 1 ? 's' : '') : '',
            'level'     => trim((string) $bien->standing),
            'type'      => trim((string) $bien->type),
            'city'      => trim((string) $bien->city),
            'reference' => trim((string) $bien->reference),
        ];

        foreach ($this->champs($xpath, $carte) as $noeud) {
            $champ = $noeud->getAttribute('data-gx-field');

            if ($champ === 'image') {
                $this->poserImage($noeud, $bien->vignette(), $valeurs['name']);
                continue;
            }

            if ($champ === 'link') {
                // Le module n'expose pas de page par forfait : le lien mène à
                // la section elle-même, où le visiteur trouve la demande de
                // réservation. On garde donc l'ancre du gabarit.
                continue;
            }

            if (! array_key_exists($champ, $valeurs)) {
                continue;
            }

            if ($valeurs[$champ] === '') {
                $this->retirerLigne($noeud);
                continue;
            }

            $this->poserTexte($doc, $noeud, $valeurs[$champ]);
        }
    }

    /**
     * Retire le champ, et avec lui la ligne qui le porte : une étiquette
     * « Durée » au-dessus du vide est pire que pas de ligne du tout.
     */
    private function retirerLigne(\DOMElement $noeud): void
    {
        $courant = $noeud;

        for ($i = 0; $i < 4 && $courant->parentNode instanceof \DOMElement; $i++) {
            $parent = $courant->parentNode;
            if ($parent->hasAttribute('data-gx-row')) {
                $this->retirer($parent);

                return;
            }
            $courant = $parent;
        }

        $this->retirer($noeud);
    }

    /** « à partir de » reste dans le gabarit : ici, seulement le montant. */
    private function prix(Property $bien, array $options): string
    {
        if (trim((string) $bien->price_label) !== '') {
            return trim((string) $bien->price_label);
        }

        $montant = (float) ($bien->nightly_price ?: $bien->price);
        if ($montant <= 0) {
            return '';
        }

        $symbole = trim((string) $bien->currency) ?: (string) ($options['currency'] ?? '$');

        return number_format($montant, 0, ',', ' ') . ' ' . $symbole;
    }

    private function unite(Property $bien): string
    {
        if ($bien->nightly_price && (float) $bien->nightly_price > 0) {
            return 'par nuit';
        }

        return $bien->price && (float) $bien->price > 0 ? 'par forfait' : '';
    }

    private function duree(Property $bien): string
    {
        $min = $bien->min_nights !== null ? (int) $bien->min_nights : 0;
        $max = $bien->max_nights !== null ? (int) $bien->max_nights : 0;

        if ($min > 0 && $max > $min) {
            return $min . ' à ' . $max . ' nuits';
        }

        if ($min > 0) {
            return $min . ' nuit' . ($min > 1 ? 's' : '');
        }

        return '';
    }

    private function description(Property $bien): string
    {
        $texte = trim(preg_replace('/\s+/u', ' ', strip_tags((string) $bien->description)));

        if ($texte === '') {
            return '';
        }

        // La carte est courte : au-delà, on coupe sur un mot entier.
        if (mb_strlen($texte) <= 160) {
            return $texte;
        }

        $coupe = mb_substr($texte, 0, 160);
        $espace = mb_strrpos($coupe, ' ');

        return rtrim($espace ? mb_substr($coupe, 0, $espace) : $coupe, " ,;.") . '…';
    }
}
