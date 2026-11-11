<?php

namespace Vendor\Cms\Support;

use Vendor\Cms\Models\BlogPost;

/**
 * Remplit les sections « blog » d'un template CMS avec les vrais articles de
 * l'établissement (espace entreprise → onglet Blog).
 *
 * ─────────────────────────────────────────────────────────────────────────
 * MÊME SOCLE QUE LES AUTRES GRILLES
 * ─────────────────────────────────────────────────────────────────────────
 *
 * Comme [[TemplateProducts]] ou [[TemplateForfaits]], la grille est remplie
 * AU RENDU, côté serveur : publier un article dans l'espace entreprise suffit
 * à mettre le site à jour, sans repasser par l'éditeur. La première carte du
 * balisage sert de gabarit — elle est clonée autant de fois qu'il y a
 * d'articles, puis remplie champ par champ.
 *
 * ⚠ Une grille sans article garde ses cartes de démonstration : c'est la
 * règle du socle, et c'est ce qu'il faut dans l'éditeur, où l'utilisateur doit
 * voir et pouvoir modifier quelque chose. Sur le SITE, en revanche, une
 * section de blog sans article n'a rien à dire : c'est
 * [[TemplateConditions]] qui la retire, sur le repère `data-gx-requiert`.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * CE QU'EST UN ARTICLE PUBLIÉ
 * ─────────────────────────────────────────────────────────────────────────
 *
 * `status = published` ET une date de publication échue. Un article
 * programmé pour la semaine prochaine ne doit pas apparaître aujourd'hui, et
 * un brouillon jamais.
 *
 * Attributs reconnus sur le conteneur :
 *   data-gx-posts              active la section (valeur ignorée)
 *   data-gx-posts-limit        nombre max d'articles (déf. : nb de cartes)
 *   data-gx-posts-tag          ne garder que les articles portant ce mot-clé
 *   data-gx-posts-featured     « 1 » : uniquement les articles mis en avant
 *   data-gx-posts-sort         recent | ancien (déf. : recent)
 *
 * Champs reconnus sur les descendants de la carte (`data-gx-field`) :
 *   image, name, desc, date, tag, author, link
 *
 * ⚠ Un champ sans valeur ne garde pas la donnée de démonstration : elle
 * mentirait. Le nœud est retiré.
 */
class TemplatePosts extends TemplateGrid
{
    /** Sites multilingues : champs traduits (ContenusTraduisibles). */
    protected function typeTraduction(): ?string
    {
        return 'article';
    }

    protected function marqueur(): string
    {
        return 'data-gx-posts';
    }

    protected function marqueurCarte(): string
    {
        return 'data-gx-post';
    }

    /** @return \Illuminate\Support\Collection<int,BlogPost> */
    protected function elements(int $limite, array $options)
    {
        $query = BlogPost::query()
            ->where('etablissement_id', $this->etablissementId)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());

        if (($options['featured'] ?? '') === '1') {
            $query->where('is_featured', true);
        }

        match ($options['sort'] ?? '') {
            'ancien' => $query->orderBy('published_at'),
            default  => $query->orderByDesc('published_at')->orderByDesc('id'),
        };

        // Le filtre par mot-clé porte sur une colonne JSON : on charge un peu
        // large puis on coupe en PHP, pour rester lisible et portable d'un
        // moteur de base à l'autre.
        $tag = trim((string) ($options['tag'] ?? ''));
        if ($tag === '') {
            return $query->limit(max(1, $limite))->get();
        }

        return $query->limit(max(1, $limite) * 4 + 20)->get()
            ->filter(function (BlogPost $post) use ($tag) {
                foreach ((array) $post->tags as $t) {
                    if (mb_strtolower(trim((string) $t)) === mb_strtolower($tag)) {
                        return true;
                    }
                }

                return false;
            })
            ->take(max(1, $limite))
            ->values();
    }

    protected function remplirCarte(
        \DOMDocument $doc,
        \DOMXPath $xpath,
        \DOMElement $carte,
        $post,
        array $options
    ): void {
        $carte->setAttribute('data-gx-post-id', (string) $post->id);

        $lien = $this->lien($post);

        $valeurs = [
            'name'   => trim((string) $post->title),
            'desc'   => $this->extrait($post),
            'date'   => $post->published_at?->translatedFormat('j F Y') ?? '',
            'tag'    => $this->premierMotCle($post),
            'author' => trim((string) ($post->user->name ?? '')),
        ];

        foreach ($this->champs($xpath, $carte) as $noeud) {
            $champ = $noeud->getAttribute('data-gx-field');

            if ($champ === 'image') {
                $this->poserImage($noeud, $this->image($post), $valeurs['name']);
                continue;
            }

            if ($champ === 'link') {
                $noeud->setAttribute('href', $lien);
                continue;
            }

            if (! array_key_exists($champ, $valeurs)) {
                continue;
            }

            if ($valeurs[$champ] === '') {
                $this->retirer($noeud);
                continue;
            }

            $this->poserTexte($doc, $noeud, $valeurs[$champ]);
        }

        // Une carte entièrement cliquable : fréquent sur les gabarits de blog,
        // où le visuel et le titre mènent au même article.
        if ($carte->nodeName === 'a' && $carte->hasAttribute('href')) {
            $carte->setAttribute('href', $lien);
        }
    }

    /** L'adresse publique de l'article, sur le site de l'établissement. */
    private function lien(BlogPost $post): string
    {
        $slug = trim((string) $post->slug);

        if ($slug === '') {
            return '#';
        }

        try {
            return route('cms.company.blog.show', [
                'etablissementId' => $post->etablissement_id ?: $this->etablissementId,
                'slug'            => $slug,
            ]);
        } catch (\Throwable $e) {
            // Mieux vaut une carte sans lien qu'une page en erreur.
            return '#';
        }
    }

    private function image(BlogPost $post): string
    {
        $chemin = trim((string) ($post->featured_image ?: $post->og_image_url));

        if ($chemin === '') {
            return '';
        }

        if (preg_match('~^(https?:)?//~', $chemin) || str_starts_with($chemin, 'data:')) {
            return $chemin;
        }

        // ⚠ Les médias sont déposés par l'ADMIN : un chemin relatif résolu par
        // `asset()` viserait le site public et finirait en 404. Même remède
        // que pour les points de la carte.
        $base = rtrim((string) config('ads.admin_url', ''), '/');
        $relatif = ltrim($chemin, '/');

        if (! str_starts_with($relatif, 'storage/')) {
            $relatif = 'storage/' . $relatif;
        }

        return $base !== '' ? $base . '/' . $relatif : asset($relatif);
    }

    private function extrait(BlogPost $post): string
    {
        $texte = trim((string) $post->excerpt);

        if ($texte === '') {
            $texte = trim(preg_replace('/\s+/u', ' ', strip_tags((string) $post->content)));
        }

        if ($texte === '' || mb_strlen($texte) <= 170) {
            return $texte;
        }

        $coupe  = mb_substr($texte, 0, 170);
        $espace = mb_strrpos($coupe, ' ');

        return rtrim($espace ? mb_substr($coupe, 0, $espace) : $coupe, " ,;.") . '…';
    }

    private function premierMotCle(BlogPost $post): string
    {
        foreach ((array) $post->tags as $t) {
            $t = trim((string) $t);
            if ($t !== '') {
                return $t;
            }
        }

        return '';
    }
}
