<?php

namespace Vendor\Cms\Support;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Vendor\Cms\Models\BlogPost;

/**
 * Retire du site les parties qui n'ont rien à montrer.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * LE PROBLÈME
 * ─────────────────────────────────────────────────────────────────────────
 *
 * Les grilles dynamiques ([[TemplateProducts]], [[TemplatePosts]]…) suivent
 * une règle de socle : sans donnée réelle, elles GARDENT leurs cartes de
 * démonstration. C'est ce qu'il faut dans l'éditeur — l'utilisateur doit voir
 * et pouvoir modifier quelque chose — mais pas sur le site publié, où un
 * établissement sans boutique affichait « Terrine de campagne, 14,00 $ » et
 * un établissement sans article affichait un blog inventé.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * LE CONTRAT
 * ─────────────────────────────────────────────────────────────────────────
 *
 * N'importe quel élément peut déclarer ce dont il dépend :
 *
 *     <section data-gx-requiert="produits"> … </section>
 *     <a href="#hz-blog" data-gx-requiert="blog">Blog</a>
 *
 * Au rendu, si l'établissement n'a aucune donnée de ce type, l'élément est
 * retiré — section comme entrée de menu. Plusieurs dépendances se séparent
 * par une virgule ; l'élément part dès que l'UNE d'elles est vide.
 *
 * Clés reconnues :
 *   produits  — au moins un produit publié et en vente (onglet E-commerce)
 *   blog      — au moins un article publié et daté (onglet Blog)
 *
 * ⚠ CE BLOC NE TOURNE QUE SUR LE SITE PUBLIÉ. Dans l'éditeur, les sections
 * doivent rester visibles et modifiables, sinon l'utilisateur ne pourrait
 * plus toucher à un blog qu'il n'a pas encore rempli. L'appelant ne
 * l'invoque donc qu'au rendu public.
 *
 * ⚠ ON NE SUPPRIME JAMAIS SUR UNE ERREUR. Si le comptage échoue (table
 * absente, base indisponible), la dépendance est considérée comme satisfaite
 * et la page reste complète : un site qui montre une démonstration vaut mieux
 * qu'un site amputé.
 */
class TemplateConditions
{
    /** Résultats de comptage, pour ne pas interroger deux fois par rendu. */
    private array $cache = [];

    private function __construct(private readonly int $etablissementId)
    {
    }

    public static function appliquer(string $html, ?int $etablissementId): string
    {
        if ($etablissementId === null || ! str_contains($html, 'data-gx-requiert')) {
            return $html;
        }

        try {
            return (new self((int) $etablissementId))->parcourir($html);
        } catch (\Throwable $e) {
            Log::warning('TemplateConditions : ' . $e->getMessage());

            return $html;
        }
    }

    /**
     * ⚠ CHIRURGIE DE CHAÎNE, PAS DE RECONSTRUCTION DOM.
     *
     * Charger la page dans `DOMDocument` puis la réécrire avec `saveHTML()`
     * reformate tout : sur le gabarit par défaut, l'aller-retour change
     * 30 Ko d'indentation et lève 239 avertissements libxml, qui ne connaît
     * ni `<section>` ni `<video>`. Les comptes de balises survivent, mais
     * réécrire 500 Ko de page à chaque affichage pour en retirer deux
     * sections est un risque sans contrepartie.
     *
     * On repère donc chaque élément marqué dans la CHAÎNE, on cherche sa
     * balise fermante en comptant l'imbrication, et on coupe. Le reste du
     * document sort octet pour octet tel qu'il est entré.
     */
    private function parcourir(string $html): string
    {
        // Les commentaires sont neutralisés le temps du repérage : un
        // `data-gx-requiert` cité dans un commentaire n'est pas un élément.
        $masque = preg_replace_callback(
            '/<!--.*?-->/s',
            fn ($m) => str_repeat(' ', strlen($m[0])),
            $html
        );

        $coupes = [];
        $curseur = 0;

        while (($pos = strpos($masque, 'data-gx-requiert', $curseur)) !== false) {
            $curseur = $pos + 16;

            $ouvrante = $this->debutDeBalise($masque, $pos);
            if ($ouvrante === null) {
                continue;
            }

            [$debut, $tag] = $ouvrante;
            $finOuvrante = $this->finDeBalise($masque, $debut);

            // La valeur de l'attribut, lue dans la balise ouvrante elle-même.
            $balise = substr($masque, $debut, $finOuvrante - $debut);
            if (! preg_match('/\bdata-gx-requiert\s*=\s*"([^"]*)"/i', $balise, $m)) {
                continue;
            }

            if ($this->satisfait($m[1])) {
                continue;
            }

            $fin = $this->finDElement($masque, $tag, $debut, $finOuvrante);
            if ($fin === null) {
                continue;
            }

            $coupes[] = [$debut, $fin];
            $curseur = $fin;
        }

        if ($coupes === []) {
            return $html;
        }

        // De la fin vers le début : les positions déjà calculées restent
        // valides. Les coupes ne se chevauchent pas, le curseur ayant sauté
        // au-delà de chaque élément retiré.
        foreach (array_reverse($coupes) as [$debut, $fin]) {
            $html = substr($html, 0, $debut) . substr($html, $fin);
        }

        return $html;
    }

    /**
     * Remonte de la position d'un attribut au `<` de sa balise ouvrante.
     *
     * @return array{0:int,1:string}|null  [position, nom de la balise]
     */
    private function debutDeBalise(string $html, int $positionAttribut): ?array
    {
        $debut = strrpos(substr($html, 0, $positionAttribut), '<');

        if ($debut === false) {
            return null;
        }

        if (! preg_match('/^<([a-z][a-z0-9]*)\b/i', substr($html, $debut, 24), $m)) {
            return null;
        }

        return [$debut, strtolower($m[1])];
    }

    /** Fin de la balise ouvrante : le premier `>` hors guillemets. */
    private function finDeBalise(string $html, int $debut): int
    {
        $i = $debut;
        $quote = null;
        $n = strlen($html);

        while ($i < $n) {
            $c = $html[$i];

            if ($quote !== null) {
                if ($c === $quote) {
                    $quote = null;
                }
            } elseif ($c === '"' || $c === "'") {
                $quote = $c;
            } elseif ($c === '>') {
                return $i + 1;
            }

            $i++;
        }

        return $n;
    }

    /** Position juste après la fermeture de l'élément, imbrication comprise. */
    private function finDElement(string $html, string $tag, int $debut, int $finOuvrante): ?int
    {
        // Élément vide : il se termine avec sa balise ouvrante.
        static $vides = ['img', 'br', 'hr', 'input', 'meta', 'link', 'source', 'track', 'area', 'col', 'embed'];

        if (in_array($tag, $vides, true)
            || rtrim(substr($html, $finOuvrante - 2, 2), '>') === '/') {
            return $finOuvrante;
        }

        $profondeur = 1;
        $curseur = $finOuvrante;

        while (preg_match('~<(?<slash>/?)' . preg_quote($tag, '~') . '\b~i',
                          $html, $m, PREG_OFFSET_CAPTURE, $curseur)) {
            $position = $m[0][1];
            $fin = $this->finDeBalise($html, $position);

            if ($m['slash'][0] === '/') {
                if (--$profondeur === 0) {
                    return $fin;
                }
            } elseif (rtrim(substr($html, $fin - 2, 2), '>') !== '/') {
                $profondeur++;
            }

            $curseur = $fin;
        }

        // Fermeture introuvable : on ne coupe rien plutôt que de tronquer
        // la page jusqu'à la fin.
        return null;
    }

    /** Toutes les dépendances listées sont-elles satisfaites ? */
    private function satisfait(string $liste): bool
    {
        foreach (preg_split('/\s*,\s*/', trim($liste)) as $cle) {
            $cle = mb_strtolower(trim($cle));

            if ($cle === '') {
                continue;
            }

            if (! $this->possede($cle)) {
                return false;
            }
        }

        return true;
    }

    private function possede(string $cle): bool
    {
        if (array_key_exists($cle, $this->cache)) {
            return $this->cache[$cle];
        }

        try {
            $this->cache[$cle] = match ($cle) {
                'produits' => $this->compteProduits() > 0,
                'blog'     => $this->compteArticles() > 0,
                // Une clé inconnue ne doit rien faire disparaître : on la
                // considère satisfaite plutôt que d'amputer la page sur une
                // faute de frappe.
                default    => true,
            };
        } catch (\Throwable $e) {
            Log::warning('TemplateConditions[' . $cle . '] : ' . $e->getMessage());
            $this->cache[$cle] = true;
        }

        return $this->cache[$cle];
    }

    /** Mêmes filtres que [[TemplateProducts]] : ce que le site peut vendre. */
    private function compteProduits(): int
    {
        if (! class_exists(Product::class)) {
            throw new \RuntimeException('modèle Product absent');
        }

        return Product::query()
            ->where('etablissement_id', $this->etablissementId)
            ->where('is_public', true)
            ->where('is_available_for_sale', true)
            ->count();
    }

    /** Mêmes filtres que [[TemplatePosts]] : ce qui est réellement publié. */
    private function compteArticles(): int
    {
        if (! Schema::connection('cms')->hasTable('cms_blog_posts')) {
            throw new \RuntimeException('table cms_blog_posts absente');
        }

        return BlogPost::query()
            ->where('etablissement_id', $this->etablissementId)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->count();
    }
}
