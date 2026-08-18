<?php

namespace Vendor\Cms\Support;

use Illuminate\Support\Facades\Log;

/**
 * Socle des grilles de template remplies avec les données de l'établissement.
 *
 * Deux grilles existent aujourd'hui — les produits ([[TemplateProducts]]) et
 * les rayons ([[TemplateCategories]]) — et elles partagent tout le mécanisme
 * délicat : repérer la grille dans une chaîne de 150 Ko, isoler son contenu,
 * cloner la carte modèle, réinsérer sans abîmer le reste. Ce socle porte ce
 * mécanisme une seule fois ; les sous-classes ne décrivent que ce qui les
 * distingue (attribut déclencheur, données à charger, remplissage d'une carte).
 *
 * ─────────────────────────────────────────────────────────────────────────
 * POURQUOI UN DOM *LOCAL* ET NON SUR TOUTE LA PAGE
 * ─────────────────────────────────────────────────────────────────────────
 *
 * DOMDocument ne connaît que HTML 4 : sur ces templates — SVG en ligne,
 * attributs booléens, scripts — il réécrit le document à la sérialisation et
 * casse le balisage. C'est la raison pour laquelle TemplateDataBinder s'en
 * tient aux expressions régulières.
 *
 * Cloner une carte et la remplir champ par champ demande pourtant un vrai
 * arbre. Le compromis : un scanner de balises repère la grille dans la chaîne,
 * et SEUL son contenu — quelques kilo-octets de cartes, sans script ni SVG —
 * passe par DOMDocument. Le reste du template n'est jamais re-sérialisé.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * REPLI
 * ─────────────────────────────────────────────────────────────────────────
 *
 * Sans donnée à afficher, la grille est laissée telle quelle : un template
 * installé sur un catalogue vide garde une page de démonstration présentable
 * plutôt qu'un trou.
 */
abstract class TemplateGrid
{
    /** Attribut qui marque la grille, ex. « data-gx-products ». */
    abstract protected function marqueur(): string;

    /** Attribut qui marque la carte modèle, ex. « data-gx-product ». */
    abstract protected function marqueurCarte(): string;

    /**
     * Données à afficher. Une collection vide laisse la grille intacte.
     *
     * @return \Illuminate\Support\Collection
     */
    abstract protected function elements(int $limite, array $options);

    /** Remplit une carte clonée avec un élément. */
    abstract protected function remplirCarte(
        \DOMDocument $doc,
        \DOMXPath $xpath,
        \DOMElement $carte,
        $element,
        array $options
    ): void;

    protected function __construct(protected readonly int $etablissementId)
    {
    }

    public static function hydrate(string $html, ?int $etablissementId): string
    {
        $instance = new static(0);

        // Sortie immédiate : la plupart des pages n'ont pas la grille
        // concernée, inutile de payer un scan pour elles.
        if ($etablissementId === null || strpos($html, $instance->marqueur()) === false) {
            return $html;
        }

        try {
            return (new static((int) $etablissementId))->parcourir($html);
        } catch (\Throwable $e) {
            // Une page affichée avec ses données de démonstration vaut mieux
            // qu'une page cassée.
            Log::warning(static::class . ' : hydratation abandonnée — ' . $e->getMessage(), [
                'etablissement_id' => $etablissementId,
            ]);

            return $html;
        }
    }

    /**
     * Parcourt la chaîne, repère chaque grille marquée et remplace son
     * contenu. Aucune autre partie du template n'est touchée.
     */
    protected function parcourir(string $html): string
    {
        // Balise ouvrante portant l'attribut, quel que soit l'ordre des autres.
        $ouvrante = '/<(?<tag>[a-zA-Z][\w:-]*)(?<attrs>\s[^>]*?)?\s'
            . preg_quote($this->marqueur(), '/')
            . '(?:\s|=|>)/i';

        $sortie = '';
        $reste = $html;

        while (preg_match($ouvrante, $reste, $m, PREG_OFFSET_CAPTURE)) {
            $debutBalise = $m[0][1];
            $tag = $m['tag'][0];

            $finOuvrante = strpos($reste, '>', $debutBalise);
            if ($finOuvrante === false) {
                break;                      // balise tronquée : on s'arrête là
            }
            $finOuvrante++;

            $fermeture = $this->trouverFermeture($reste, $tag, $finOuvrante);
            if ($fermeture === null) {
                // Pas de balise fermante : on avance pour ne pas boucler.
                $sortie .= substr($reste, 0, $finOuvrante);
                $reste = substr($reste, $finOuvrante);
                continue;
            }

            [$debutFermante, $finFermante] = $fermeture;

            $balise = substr($reste, $debutBalise, $finOuvrante - $debutBalise);
            $interieur = substr($reste, $finOuvrante, $debutFermante - $finOuvrante);

            // Échec cloisonné à LA section. Les sections sont indépendantes
            // (l'une est automatique, l'autre à sélection manuelle) : qu'une
            // requête échoue ne doit pas priver la page entière de ses données.
            // La section fautive garde sa démonstration, les autres s'hydratent.
            try {
                $nouveau = $this->remplirGrille($balise, $interieur);
            } catch (\Throwable $e) {
                Log::warning(static::class . ' : section ignorée — ' . $e->getMessage(), [
                    'etablissement_id' => $this->etablissementId,
                ]);
                $nouveau = $interieur;
            }

            $sortie .= substr($reste, 0, $finOuvrante) . $nouveau;
            $sortie .= substr($reste, $debutFermante, $finFermante - $debutFermante);
            $reste = substr($reste, $finFermante);
        }

        return $sortie . $reste;
    }

    /**
     * Retourne [début, fin] de la balise fermante correspondante, en tenant
     * compte de l'imbrication de balises de même nom.
     *
     * @return array{0:int,1:int}|null
     */
    protected function trouverFermeture(string $html, string $tag, int $depuis): ?array
    {
        $motif = '/<(?<slash>\/?)' . preg_quote($tag, '/') . '\b[^>]*>/i';
        $profondeur = 1;
        $position = $depuis;

        while (preg_match($motif, $html, $m, PREG_OFFSET_CAPTURE, $position)) {
            $debut = $m[0][1];
            $fin = $debut + strlen($m[0][0]);

            if ($m['slash'][0] === '/') {
                if (--$profondeur === 0) {
                    return [$debut, $fin];
                }
            } elseif (substr(rtrim($m[0][0], '>'), -1) !== '/') {
                $profondeur++;      // <div ... /> ne compte pas comme ouverture
            }

            $position = $fin;
        }

        return null;
    }

    /**
     * Reconstruit l'intérieur d'une grille. Retourne l'original si aucune carte
     * modèle n'est trouvée ou s'il n'y a rien à afficher.
     */
    protected function remplirGrille(string $baliseOuvrante, string $interieur): string
    {
        $options = $this->options($baliseOuvrante);

        $charge = $this->charger($interieur);
        if ($charge === null) {
            return $interieur;
        }

        [$doc, $racine] = $charge;
        $xpath = new \DOMXPath($doc);

        $cartes = $this->cartes($xpath, $racine);
        if ($cartes === []) {
            return $interieur;
        }

        $limite = $options['limit'] > 0 ? $options['limit'] : count($cartes);
        $elements = $this->elements($limite, $options);

        if ($elements->isEmpty()) {
            return $interieur;              // rien à afficher : on garde la démo
        }

        $modele = $cartes[0];
        $formatRang = $this->formatRang($xpath, $modele);

        // Les clones sont insérés AVANT le modèle puis les cartes d'origine
        // sont retirées : l'ordre est respecté sans avoir à manipuler
        // nextSibling pendant qu'on modifie l'arbre.
        $rang = 0;
        foreach ($elements as $element) {
            $rang++;
            $clone = $modele->cloneNode(true);
            $modele->parentNode->insertBefore($clone, $modele);
            $this->remplirCarte($doc, $xpath, $clone, $element, $options);
            $this->numeroter($xpath, $clone, $rang, $formatRang);
        }

        foreach ($cartes as $ancienne) {
            if ($ancienne->parentNode) {
                $ancienne->parentNode->removeChild($ancienne);
            }
        }

        $out = '';
        foreach ($racine->childNodes as $enfant) {
            $out .= $doc->saveHTML($enfant);
        }

        return $out;
    }

    /**
     * Repère la façon dont le gabarit numérote ses cartes.
     *
     * Certaines listes affichent un rang décoratif (« 01 », « A »). Cloner la
     * carte modèle le recopierait à l'identique sur toutes les lignes : la
     * liste afficherait cinq fois « 01 ». On relève donc le format une seule
     * fois, sur le modèle, pour le reproduire ensuite.
     *
     * @return array{type:string,taille:int}|null
     */
    protected function formatRang(\DOMXPath $xpath, \DOMElement $modele): ?array
    {
        $noeuds = $xpath->query('.//*[@data-gx-field="index"]', $modele);
        if (! $noeuds || $noeuds->length === 0) {
            return null;
        }

        $texte = trim($noeuds->item(0)->textContent);

        if (preg_match('/^\d+$/', $texte)) {
            return ['type' => 'chiffre', 'taille' => strlen($texte)];
        }

        if (preg_match('/^[A-Za-z]$/', $texte)) {
            return ['type' => 'lettre', 'taille' => (int) (ctype_upper($texte))];
        }

        return null;
    }

    /** Écrit le rang de la carte dans son champ `index`, s'il y en a un. */
    protected function numeroter(\DOMXPath $xpath, \DOMElement $carte, int $rang, ?array $format): void
    {
        if ($format === null) {
            return;
        }

        $noeuds = $xpath->query('.//*[@data-gx-field="index"]', $carte);
        if (! $noeuds || $noeuds->length === 0) {
            return;
        }

        if ($format['type'] === 'lettre') {
            // Au-delà de Z on repart à A : mieux vaut un doublon discret qu'un
            // caractère hors alphabet.
            $lettre = chr(ord('A') + (($rang - 1) % 26));
            $valeur = $format['taille'] ? $lettre : strtolower($lettre);
        } else {
            $valeur = str_pad((string) $rang, $format['taille'], '0', STR_PAD_LEFT);
        }

        $noeuds->item(0)->textContent = $valeur;
    }

    /** @return array{0:\DOMDocument,1:\DOMElement}|null */
    protected function charger(string $fragment): ?array
    {
        $doc = new \DOMDocument('1.0', 'UTF-8');

        $precedent = libxml_use_internal_errors(true);
        $ok = $doc->loadHTML(
            '<?xml encoding="utf-8"?><div id="gx-grid">' . $fragment . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();
        libxml_use_internal_errors($precedent);

        if (! $ok) {
            return null;
        }

        $racine = $doc->getElementById('gx-grid');

        return $racine ? [$doc, $racine] : null;
    }

    /** @return array{limit:int,category:string,sort:string,currency:string,pick:string} */
    protected function options(string $balise): array
    {
        $lire = function (string $suffixe) use ($balise): string {
            $motif = '/\s' . preg_quote($this->marqueur() . $suffixe, '/')
                . '\s*=\s*("([^"]*)"|\'([^\']*)\')/i';

            if (preg_match($motif, $balise, $m)) {
                return trim($m[2] ?? $m[3] ?? '');
            }

            return '';
        };

        $limite = (int) $lire('-limit');

        return [
            'limit' => $limite > 0 ? min(48, $limite) : 0,
            'category' => $lire('-category'),
            'sort' => $lire('-sort'),
            'currency' => $lire('-currency') ?: ProductPresenter::SYMBOLE,
            // Section « à la carte » : le commerçant coche lui-même les produits
            // qui la composent depuis son espace. Vide = remplissage
            // automatique, comportement d'origine.
            'pick' => $lire('-pick'),
        ];
    }

    /**
     * Cartes modèles : les descendants marqués, sinon les enfants directs
     * (grille non annotée).
     *
     * @return \DOMElement[]
     */
    protected function cartes(\DOMXPath $xpath, \DOMElement $racine): array
    {
        $cartes = [];

        $marquees = $xpath->query('.//*[@' . $this->marqueurCarte() . ']', $racine);
        if ($marquees !== false && $marquees->length > 0) {
            foreach ($marquees as $noeud) {
                if (! $this->aUnParentMarque($noeud, $racine)) {
                    $cartes[] = $noeud;
                }
            }

            return $cartes;
        }

        foreach ($racine->childNodes as $enfant) {
            if ($enfant instanceof \DOMElement) {
                $cartes[] = $enfant;
            }
        }

        return $cartes;
    }

    protected function aUnParentMarque(\DOMNode $noeud, \DOMElement $limite): bool
    {
        for ($p = $noeud->parentNode; $p && $p !== $limite; $p = $p->parentNode) {
            if ($p instanceof \DOMElement && $p->hasAttribute($this->marqueurCarte())) {
                return true;
            }
        }

        return false;
    }

    /**
     * Champs `data-gx-field` d'une carte, copiés dans un tableau : supprimer un
     * nœud pendant l'itération sur une DOMNodeList vivante ferait sauter
     * l'élément suivant.
     *
     * @return \DOMElement[]
     */
    protected function champs(\DOMXPath $xpath, \DOMElement $carte): array
    {
        $trouves = $xpath->query('.//*[@data-gx-field]', $carte);
        if ($trouves === false) {
            return [];
        }

        $noeuds = [];
        foreach ($trouves as $noeud) {
            if ($noeud instanceof \DOMElement) {
                $noeuds[] = $noeud;
            }
        }

        return $noeuds;
    }

    protected function poserTexte(\DOMDocument $doc, \DOMElement $noeud, string $valeur): void
    {
        while ($noeud->firstChild) {
            $noeud->removeChild($noeud->firstChild);
        }

        $noeud->appendChild($doc->createTextNode($valeur));
    }

    protected function poserImage(\DOMElement $noeud, ?string $url, string $alt): void
    {
        if ($url === null) {
            return;                         // pas de photo : on garde la démo
        }

        if (strtolower($noeud->nodeName) === 'img') {
            $noeud->setAttribute('src', $url);
            $noeud->setAttribute('alt', $alt);
            $noeud->setAttribute('loading', 'lazy');

            // Un srcset hérité du gabarit gagnerait sur src : la photo réelle
            // ne s'afficherait jamais.
            $noeud->removeAttribute('srcset');
            $noeud->removeAttribute('sizes');

            return;
        }

        $style = preg_replace('/background-image\s*:[^;]*;?/i', '', $noeud->getAttribute('style'));
        $noeud->setAttribute(
            'style',
            trim(trim((string) $style, ' ;') . ';background-image:url(\'' . $url . '\');', ';') . ';'
        );
    }

    protected function retirer(\DOMElement $noeud): void
    {
        if ($noeud->parentNode) {
            $noeud->parentNode->removeChild($noeud);
        }
    }
}
