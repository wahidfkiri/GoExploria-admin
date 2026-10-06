{{-- ==========================================================================
     MÉGA-MENU « ACTIVITÉS DE CETTE DESTINATION »

     Ouvert par le bouton « Voir les activités » de la bannière, sur toutes les
     pages de destination (continent, pays, province, région, secteur, ville,
     arrondissement, quartier) — la page composée dans l'éditeur (gabarit
     « Carnet d'Atlas ») comme la page classique.

     Contenu, groupé à DEUX niveaux :
       - un groupe par DESTINATION : celle qui est affichée, puis CHACUNE de
         ses destinations descendantes, à TOUS les niveaux inférieurs (un pays
         montre ses provinces, leurs régions, leurs secteurs et villes, et
         jusqu'aux arrondissements et quartiers) ;
       - dans chaque groupe, les activités rangées par CATÉGORIE.
     Le titre d'une destination mène à sa page, celui d'une catégorie à la
     sienne, chaque activité à la sienne.

     Chaque ligne porte son VISUEL quand il existe (colonne `image` des
     destinations et des activités, `icon` des catégories). Sans visuel, une
     pastille porte l'initiale : jamais d'image cassée, jamais de trou dans
     l'alignement.

     Les données viennent de Vendor\TravelDestination\Support\ActivitesParDestination,
     passé par le contrôleur sous $activitesParDestination.

     ⚠ Repli : si cette variable manque (vue appelée hors du contrôleur), on
     reconstruit un groupe unique depuis $destinationActivities — le menu reste
     affiché, sans ses destinations descendantes.

     Sans JavaScript, le bouton garde son comportement d'origine : il descend
     à la section « Activités » de la page.

     Variables : $entity, $activitesParDestination, $destinationActivities,
     $filArianeNiveaux.
     ========================================================================== --}}
@php
    /* Adresse d'un visuel enregistré. ⚠ La colonne ne contient pas toujours la
       même chose : les écrans des continents et des pays y écrivent une adresse
       complète, l'espace destination un chemin relatif au disque public. */
    $gxMedia = function ($valeur) {
        $valeur = trim((string) ($valeur ?? ''));

        if ($valeur === '') { return null; }

        return \Illuminate\Support\Str::startsWith($valeur, ['http://', 'https://', '//', '/'])
            ? $valeur
            : asset('storage/' . ltrim($valeur, '/'));
    };

    $gxDonnees = $activitesParDestination ?? null;

    if (! is_array($gxDonnees)) {
        /* Repli : un seul groupe, celui de la destination affichée.
           ⚠ Les catégories sont chargées AVANT tout tri : après `sortBy`, la
           collection n'est plus une collection Eloquent et `loadMissing`
           n'existe plus — la page tombait en erreur. */
        $gxSource = $destinationActivities ?? collect();

        if ($gxSource instanceof \Illuminate\Database\Eloquent\Collection) {
            $gxSource->loadMissing('categoryRelation');
        }

        $gxActs = collect($gxSource)->filter(fn ($a) => ! empty($a->slug));

        $gxCategories = $gxActs
            ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->groupBy(fn ($a) => $a->categoryRelation->id ?? 0)
            ->map(function ($items, $id) use ($gxMedia) {
                $categorie = $id ? $items->first()->categoryRelation : null;
                $cle = trim((string) ($categorie->slug ?? '')) ?: (string) ($categorie->id ?? '');
                $icone = trim((string) ($categorie->icon ?? ''));
                $fichier = $icone !== '' && (str_contains($icone, '/') || preg_match('/\.(png|jpe?g|gif|webp|avif|svg)$/i', $icone));

                return [
                    'nom' => $categorie->name ?? 'Autres activités',
                    'lien' => $cle === '' ? null : '/categories/' . rawurlencode($cle),
                    'image' => $fichier ? $gxMedia($icone) : null,
                    'icone' => $fichier || $icone === '' ? null : $icone,
                    'activites' => $items->map(fn ($a) => [
                        'nom' => (string) $a->name,
                        'url' => '/activity/' . $a->slug,
                        'image' => $gxMedia($a->image ?? null),
                    ])->values()->all(),
                ];
            })
            ->sortBy(fn ($g) => ($g['nom'] === 'Autres activités' ? '~' : '') . mb_strtolower($g['nom']))
            ->values()
            ->all();

        $gxDonnees = [
            'total' => $gxActs->count(),
            'groupes' => $gxActs->isEmpty() ? [] : [[
                'nom' => (string) $entity->name,
                'url' => null,
                'image' => $gxMedia($entity->image ?? null),
                'niveau' => 'Destination',
                'courante' => true,
                'nombre' => $gxActs->count(),
                'categories' => $gxCategories,
            ]],
        ];
    }

    /* Chaque catégorie replie sa liste : le bouton doit désigner la liste
       qu'il ouvre (aria-controls), d'où un identifiant par bloc. */
    $gxBlocNo = 0;

    $gxGroupes = collect($gxDonnees['groupes'] ?? []);
    $gxTotal = (int) ($gxDonnees['total'] ?? 0);

    /* Pastille de repli : l'initiale, quand il n'y a pas d'image. */
    $gxInitiale = fn ($texte) => mb_strtoupper(mb_substr(trim((string) $texte), 0, 1)) ?: '•';

    // Autres destinations : frères du niveau affiché, puis niveau inférieur.
    // Elles complètent les groupes ci-dessus, qui ne listent que celles qui
    // PORTENT des activités.
    $gxNiveaux = collect($filArianeNiveaux ?? []);
    $gxCourant = $gxNiveaux->firstWhere('courant', true);
    $gxEnfants = $gxNiveaux->first(fn ($n) => ! empty($n['suivant']) && ! empty($n['options']));

    $gxFreres = collect($gxCourant['options'] ?? [])->reject(fn ($o) => ! empty($o['actuel']))->values();
    $gxDescendants = collect($gxEnfants['options'] ?? [])->values();
@endphp

@if($gxGroupes->isNotEmpty())
<div class="gxactdest" id="gxActDest" role="dialog" aria-label="Activités de {{ $entity->name }}" aria-hidden="true">
    <div class="gxactdest__inner">
        <div class="gxactdest__top">
            <p class="gxactdest__kicker">
                <i class="fas fa-person-hiking" aria-hidden="true"></i>
                Activités — {{ $entity->name }} <em>{{ $gxTotal }}</em>
            </p>
            <button type="button" class="gxactdest__close" data-gxactdest-close aria-label="Fermer">
                <i class="fas fa-xmark" aria-hidden="true"></i>
            </button>
        </div>

        <div class="gxactdest__corps">
            <div class="gxactdest__cats">
                @foreach($gxGroupes as $groupe)
                    <section class="gxactdest__dgroupe">
                        <h3 class="gxactdest__dtitre">
                            <span class="gxactdest__vignette gxactdest__vignette--dest" aria-hidden="true">
                                @if(! empty($groupe['image']))
                                    <img src="{{ $groupe['image'] }}" alt="" loading="lazy">
                                @else
                                    <span class="gxactdest__initiale">{{ $gxInitiale($groupe['nom']) }}</span>
                                @endif
                            </span>
                            <span class="gxactdest__dnom">
                                @if(! empty($groupe['url']))
                                    <a href="{{ $groupe['url'] }}">{{ $groupe['nom'] }}</a>
                                @else
                                    <span>{{ $groupe['nom'] }}</span>
                                @endif
                                <span class="gxactdest__dniveau">
                                    {{ $groupe['niveau'] ?? 'Destination' }}
                                    @if(! empty($groupe['courante']))
                                        <span class="gxactdest__ici">Ici</span>
                                    @endif
                                </span>
                            </span>
                            <em>{{ $groupe['nombre'] }}</em>
                        </h3>

                        @foreach($groupe['categories'] as $categorie)
                            @php($gxListeId = 'gxactdest-liste-' . (++$gxBlocNo))
                            <div class="gxactdest__bloc">
                                <h4 class="gxactdest__titre">
                                    <span class="gxactdest__vignette gxactdest__vignette--cat" aria-hidden="true">
                                        @if(! empty($categorie['image']))
                                            <img src="{{ $categorie['image'] }}" alt="" loading="lazy">
                                        @elseif(! empty($categorie['icone']))
                                            <i class="{{ $categorie['icone'] }}"></i>
                                        @else
                                            <span class="gxactdest__initiale">{{ $gxInitiale($categorie['nom']) }}</span>
                                        @endif
                                    </span>
                                    @if($categorie['lien'])
                                        <a href="{{ $categorie['lien'] }}">{{ $categorie['nom'] }}</a>
                                    @else
                                        {{ $categorie['nom'] }}
                                    @endif
                                    <em>{{ count($categorie['activites']) }}</em>
                                    {{-- Ouvre/ferme la liste. `hidden` est retiré par le
                                         script : sans JS le bouton ne servirait à rien et
                                         les listes restent dépliées. --}}
                                    <button type="button" class="gxactdest__bascule"
                                            data-gxactdest-bascule
                                            aria-expanded="true" aria-controls="{{ $gxListeId }}"
                                            aria-label="Afficher les activités : {{ $categorie['nom'] }}"
                                            hidden>
                                        <i class="fas fa-chevron-down" aria-hidden="true"></i>
                                    </button>
                                </h4>
                                <ul class="gxactdest__liste" id="{{ $gxListeId }}">
                                    @foreach($categorie['activites'] as $activite)
                                        <li>
                                            <a href="{{ $activite['url'] }}">
                                                <span class="gxactdest__vignette gxactdest__vignette--act" aria-hidden="true">
                                                    @if(! empty($activite['image']))
                                                        <img src="{{ $activite['image'] }}" alt="" loading="lazy">
                                                    @else
                                                        <span class="gxactdest__initiale">{{ $gxInitiale($activite['nom']) }}</span>
                                                    @endif
                                                </span>
                                                <span class="gxactdest__anom">{{ $activite['nom'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </section>
                @endforeach
            </div>

            @if($gxFreres->isNotEmpty() || $gxDescendants->isNotEmpty())
                <aside class="gxactdest__dest">
                    @if($gxDescendants->isNotEmpty())
                        <h4 class="gxactdest__titre">Explorer {{ $entity->name }}</h4>
                        <div class="gxactdest__puces">
                            @foreach($gxDescendants as $option)
                                <a href="{{ $option['url'] }}">{{ $option['label'] }}</a>
                            @endforeach
                        </div>
                    @endif

                    @if($gxFreres->isNotEmpty())
                        <h4 class="gxactdest__titre">Autres destinations</h4>
                        <div class="gxactdest__puces">
                            @foreach($gxFreres as $option)
                                <a href="{{ $option['url'] }}">{{ $option['label'] }}</a>
                            @endforeach
                        </div>
                    @endif
                </aside>
            @endif
        </div>
    </div>
</div>

<style>
    .gxactdest {
        --gxa-ink: #0f172a; --gxa-muted: #64748b; --gxa-line: #e5e7eb;
        --gxa-soft: #f6f7f9; --gxa-gold: #d4af37; --gxa-gold-ink: #8a6d10;
        position: fixed; left: 0; right: 0; top: var(--gx-entete-plateforme, 96px);
        z-index: 10160; max-height: calc(100vh - var(--gx-entete-plateforme, 96px));
        overflow: hidden; display: flex;
        background: #fff; color: var(--gxa-ink);
        border-top: 3px solid var(--gxa-gold);
        box-shadow: 0 24px 60px rgba(2, 6, 23, .3);
        font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        opacity: 0; visibility: hidden; transform: translateY(-8px);
        transition: opacity .2s ease, transform .2s ease, visibility .2s;
    }
    .gxactdest.is-open { opacity: 1; visibility: visible; transform: none; }
    .gxactdest__inner {
        width: min(1320px, 100%); margin: 0 auto;
        padding: 18px clamp(16px, 3vw, 36px) 22px;
        display: flex; flex-direction: column; min-height: 0;
    }
    .gxactdest__top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
    .gxactdest__kicker {
        margin: 0; display: inline-flex; align-items: center; gap: 8px;
        font-size: 11px; font-weight: 800; letter-spacing: .16em; text-transform: uppercase;
        color: var(--gxa-gold-ink);
    }
    .gxactdest__kicker em {
        font-style: normal; font-size: 11px; padding: 1px 8px; border-radius: 999px;
        background: var(--gxa-gold); color: #0a1628; letter-spacing: 0;
    }
    .gxactdest__close {
        width: 36px; height: 36px; border-radius: 50%; border: 1px solid var(--gxa-line);
        background: #fff; color: var(--gxa-ink); cursor: pointer; display: grid; place-items: center; font-size: 16px;
    }
    .gxactdest__close:hover { background: var(--gxa-soft); }

    .gxactdest__corps { display: flex; gap: 28px; min-height: 0; flex: 1 1 auto; }
    .gxactdest__cats {
        flex: 1 1 auto; min-width: 0; overflow-y: auto; padding-right: 4px;
        max-height: calc(100vh - var(--gx-entete-plateforme, 96px) - 110px);
        columns: 3 250px; column-gap: 30px;
    }
    .gxactdest__bloc { break-inside: avoid; margin: 0 0 20px; }
    .gxactdest__titre {
        display: flex; align-items: center; gap: 8px; margin: 0 0 6px;
        padding-bottom: 5px; border-bottom: 2px solid var(--gxa-gold);
        font-size: 15px; font-weight: 800; line-height: 1.25;
    }
    .gxactdest__titre a { color: var(--gxa-ink); text-decoration: none; }
    .gxactdest__titre a:hover { color: var(--gxa-gold-ink); text-decoration: underline; }
    .gxactdest__titre em {
        flex: 0 0 auto; margin-left: auto; font-style: normal; font-size: 11px; font-weight: 700;
        padding: 1px 7px; border-radius: 999px; background: var(--gxa-soft); color: var(--gxa-muted);
    }
    /* Bouton de repli d'une catégorie : il suit la pastille de comptage,
       à l'extrémité droite du titre. Le chevron pivote à l'ouverture. */
    .gxactdest__bascule {
        flex: 0 0 auto; width: 24px; height: 24px; padding: 0; margin-left: 4px;
        display: grid; place-items: center; cursor: pointer;
        border: 1px solid var(--gxa-line); border-radius: 8px; background: #fff;
        color: var(--gxa-muted); font-size: 10px; line-height: 1;
        transition: background .18s ease, color .18s ease, border-color .18s ease;
    }
    .gxactdest__bascule:hover { background: var(--gxa-soft); color: var(--gxa-gold-ink); border-color: var(--gxa-gold); }
    .gxactdest__bascule:focus-visible { outline: 2px solid var(--gxa-gold); outline-offset: 2px; }
    .gxactdest__bascule i { display: block; transition: transform .18s ease; }
    .gxactdest__bascule[aria-expanded="true"] i { transform: rotate(180deg); }

    .gxactdest__liste { list-style: none; margin: 0; padding: 0; }
    .gxactdest__liste[hidden] { display: none; }
    .gxactdest__liste a {
        display: block; padding: 3px 0; font-size: 13px; font-weight: 500; line-height: 1.35;
        color: #334155; text-decoration: none;
    }
    .gxactdest__liste a:hover { color: var(--gxa-gold-ink); text-decoration: underline; }

    .gxactdest__dest {
        flex: 0 0 270px; padding-left: 24px; border-left: 1px solid var(--gxa-line);
        overflow-y: auto; max-height: calc(100vh - var(--gx-entete-plateforme, 96px) - 110px);
    }
    .gxactdest__puces { display: flex; flex-wrap: wrap; gap: 8px; margin: 0 0 20px; }
    .gxactdest__puces a {
        padding: 6px 12px; border-radius: 999px; background: var(--gxa-soft);
        color: var(--gxa-ink); text-decoration: none; font-size: 12.5px; font-weight: 600;
    }
    .gxactdest__puces a:hover { background: #0a1628; color: #fff; }

    /* ── VIGNETTES ───────────────────────────────────────────────────────
       Destination, catégorie et activité portent la même pastille, à trois
       tailles. Elle est TOUJOURS présente, image ou non : sans elle, les
       lignes sans visuel se décaleraient de la largeur d'une image. */
    .gxactdest__vignette {
        flex: 0 0 auto; display: grid; place-items: center; overflow: hidden;
        background: var(--gxa-soft); color: var(--gxa-gold-ink);
        border: 1px solid var(--gxa-line); border-radius: 10px;
    }
    .gxactdest__vignette img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .gxactdest__initiale { font-weight: 800; line-height: 1; }
    .gxactdest__vignette--dest { width: 40px; height: 40px; border-radius: 12px; }
    .gxactdest__vignette--dest .gxactdest__initiale { font-size: 15px; }
    .gxactdest__vignette--cat { width: 24px; height: 24px; border-radius: 8px; font-size: 11px; }
    .gxactdest__vignette--cat .gxactdest__initiale { font-size: 11px; }
    .gxactdest__vignette--act { width: 30px; height: 30px; border-radius: 8px; }
    .gxactdest__vignette--act .gxactdest__initiale { font-size: 11px; color: var(--gxa-muted); }

    /* Groupe de DESTINATION : il tient d'un seul tenant dans la mise en
       colonnes, sinon ses catégories se retrouveraient séparées de leur
       titre. */
    .gxactdest__dgroupe { break-inside: avoid; margin: 0 0 26px; }
    .gxactdest__dtitre {
        display: flex; align-items: center; gap: 10px; margin: 0 0 12px;
        font-size: 12px; font-weight: 800; letter-spacing: .1em; text-transform: uppercase;
        color: var(--gxa-gold-ink);
    }
    .gxactdest__dnom { min-width: 0; display: flex; flex-direction: column; gap: 2px; }
    .gxactdest__dnom a, .gxactdest__dnom > span { color: inherit; text-decoration: none; }
    .gxactdest__dnom a:hover { text-decoration: underline; }
    .gxactdest__dniveau {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 9.5px; font-weight: 700; letter-spacing: .08em;
        color: var(--gxa-muted); text-transform: uppercase;
    }
    .gxactdest__ici {
        font-size: 9.5px; font-weight: 800; letter-spacing: .08em;
        padding: 2px 7px; border-radius: 999px; background: var(--gxa-gold); color: #0a1628;
    }
    .gxactdest__dtitre em {
        flex: 0 0 auto; margin-left: auto; font-style: normal; font-size: 11px; font-weight: 700;
        padding: 1px 7px; border-radius: 999px; background: var(--gxa-soft); color: var(--gxa-muted);
    }
    .gxactdest__dgroupe .gxactdest__bloc { margin-left: 2px; }

    /* Les lignes d'activité deviennent des vignettes : l'alignement se fait
       sur la pastille, pas sur la ligne de texte. */
    .gxactdest__liste a { display: flex; align-items: center; gap: 8px; }
    .gxactdest__anom { min-width: 0; }

    @media (max-width: 992px) {
        .gxactdest {
            top: 0; max-height: none; height: 100vh; height: 100dvh;
            padding-bottom: 76px; border-top: 0; z-index: 10400;
        }
        .gxactdest__inner { padding: 14px 14px 0; }
        .gxactdest__corps { flex-direction: column; gap: 14px; overflow-y: auto; }
        .gxactdest__cats { columns: 1; max-height: none; overflow: visible; }
        .gxactdest__dest { flex: 0 0 auto; padding-left: 0; border-left: 0; border-top: 1px solid var(--gxa-line); padding-top: 14px; max-height: none; }
    }
    @media (prefers-reduced-motion: reduce) { .gxactdest { transition: none; } }
</style>

<script>
(function () {
    function init() {
        var panneau = document.getElementById('gxActDest');
        if (!panneau || panneau.dataset.gxactdestPret === '1') { return; }
        panneau.dataset.gxactdestPret = '1';

        function ouvrir() {
            if (typeof window.goCloseOtherMega === 'function') { window.goCloseOtherMega(panneau); }
            panneau.classList.add('is-open');
            panneau.setAttribute('aria-hidden', 'false');
            if (window.innerWidth <= 992) { document.documentElement.style.overflow = 'hidden'; }
        }

        function fermer() {
            panneau.classList.remove('is-open');
            panneau.setAttribute('aria-hidden', 'true');
            document.documentElement.style.overflow = '';
        }

        /* Le bouton de la bannière est un lien d'ancre (#activites) : sans JS
           il descend à la section « Activités », avec JS il ouvre ce panneau.
           On ne touche QU'aux liens de la bannière — ceux du pied de page et
           du sommaire gardent leur défilement. */
        document.addEventListener('click', function (e) {
            var lien = e.target.closest ? e.target.closest('a[href$="#activites"], [data-gx-activites-menu]') : null;
            if (!lien) { return; }
            if (! lien.hasAttribute('data-gx-activites-menu') && ! lien.closest('.hero, [class*="hero"]')) { return; }

            e.preventDefault();
            e.stopPropagation();
            panneau.classList.contains('is-open') ? fermer() : ouvrir();
        }, true);

        /* ── Catégories repliées par défaut ──────────────────────────────
           Le panneau peut aligner des dizaines d'activités : on n'affiche
           d'abord que les titres de catégorie, chacun dépliable. Le repli se
           fait ICI et non dans le HTML pour que la page reste lisible sans
           JS — et il ne se voit pas, le panneau étant masqué jusqu'au clic. */
        panneau.querySelectorAll('[data-gxactdest-bascule]').forEach(function (bouton) {
            var liste = document.getElementById(bouton.getAttribute('aria-controls'));
            if (! liste) { return; }

            bouton.hidden = false;
            liste.hidden = true;
            bouton.setAttribute('aria-expanded', 'false');

            bouton.addEventListener('click', function (e) {
                // Le titre porte le lien vers la page de la catégorie : le
                // clic sur le chevron ne doit pas le suivre.
                e.preventDefault();
                e.stopPropagation();

                var ouvert = bouton.getAttribute('aria-expanded') === 'true';
                bouton.setAttribute('aria-expanded', ouvert ? 'false' : 'true');
                liste.hidden = ouvert;
            });
        });

        panneau.querySelectorAll('[data-gxactdest-close]').forEach(function (b) {
            b.addEventListener('click', fermer);
        });
        document.addEventListener('click', function (e) {
            if (panneau.classList.contains('is-open') && !panneau.contains(e.target)) { fermer(); }
        });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { fermer(); } });

        window.goMegaClosers = window.goMegaClosers || [];
        window.goMegaClosers.push(function (sauf) { if (sauf !== panneau) { fermer(); } });
    }

    if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', init); }
    else { init(); }
})();
</script>
@endif
