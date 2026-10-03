{{-- ==========================================================================
     MÉGA-MENU « ACTIVITÉS DE CETTE DESTINATION »

     Ouvert par le bouton « Voir les activités » de la bannière (sur toutes les
     pages de destination : continent, pays, province, région, secteur, ville,
     arrondissement, quartier).

     Contenu :
       - les activités RATTACHÉES à la destination affichée, groupées par
         catégorie — titre de catégorie cliquable vers sa page ;
       - « Autres destinations » : les destinations frères du même niveau et,
         quand elles existent, celles du niveau inférieur (données déjà
         calculées pour le fil d'Ariane).

     Sans JavaScript, le bouton garde son comportement d'origine : il descend
     à la section « Activités » de la page.

     Variables : $entity, $destinationActivities, $filArianeNiveaux.
     ========================================================================== --}}
@php
    $gxSource = $destinationActivities ?? collect();

    /* ⚠ Les catégories sont chargées AVANT tout tri : après `sortBy`, la
       collection n'est plus une collection Eloquent et `load()` n'existe
       plus — la page tombait en erreur. Une seule requête pour toutes les
       activités, au lieu d'une par activité. */
    if ($gxSource instanceof \Illuminate\Database\Eloquent\Collection) {
        $gxSource->loadMissing('categoryRelation');
    }

    $gxActs = collect($gxSource)
        ->filter(fn ($a) => ! empty($a->slug))
        ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);

    $gxGroupes = $gxActs
        ->groupBy(fn ($a) => $a->categoryRelation?->id ?: 0)
        ->map(function ($items, $id) {
            $categorie = $id ? $items->first()->categoryRelation : null;

            return [
                'nom'   => $categorie?->name ?? 'Autres activités',
                'lien'  => ($categorie && \Illuminate\Support\Facades\Route::has('category.show'))
                    ? route('category.show', trim((string) $categorie->slug) !== '' ? $categorie->slug : $categorie->id, false)
                    : null,
                'items' => $items,
            ];
        })
        ->sortBy(fn ($g) => ($g['nom'] === 'Autres activités' ? '~' : '') . mb_strtolower($g['nom']))
        ->values();

    // Autres destinations : frères du niveau affiché, puis niveau inférieur.
    $gxNiveaux = collect($filArianeNiveaux ?? []);
    $gxCourant = $gxNiveaux->firstWhere('courant', true);
    $gxEnfants = $gxNiveaux->first(fn ($n) => ! empty($n['suivant']) && ! empty($n['options']));

    $gxFreres = collect($gxCourant['options'] ?? [])->reject(fn ($o) => ! empty($o['actuel']))->values();
    $gxDescendants = collect($gxEnfants['options'] ?? [])->values();
@endphp

@if($gxActs->isNotEmpty())
<div class="gxactdest" id="gxActDest" role="dialog" aria-label="Activités de {{ $entity->name }}" aria-hidden="true">
    <div class="gxactdest__inner">
        <div class="gxactdest__top">
            <p class="gxactdest__kicker">
                <i class="fas fa-person-hiking" aria-hidden="true"></i>
                Activités — {{ $entity->name }} <em>{{ $gxActs->count() }}</em>
            </p>
            <button type="button" class="gxactdest__close" data-gxactdest-close aria-label="Fermer">
                <i class="fas fa-xmark" aria-hidden="true"></i>
            </button>
        </div>

        <div class="gxactdest__corps">
            <div class="gxactdest__cats">
                @foreach($gxGroupes as $groupe)
                    <div class="gxactdest__bloc">
                        <h4 class="gxactdest__titre">
                            @if($groupe['lien'])
                                <a href="{{ $groupe['lien'] }}">{{ $groupe['nom'] }}</a>
                            @else
                                {{ $groupe['nom'] }}
                            @endif
                            <em>{{ $groupe['items']->count() }}</em>
                        </h4>
                        <ul class="gxactdest__liste">
                            @foreach($groupe['items'] as $activite)
                                <li><a href="/activity/{{ $activite->slug }}">{{ $activite->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
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
        display: flex; align-items: baseline; gap: 8px; margin: 0 0 6px;
        padding-bottom: 5px; border-bottom: 2px solid var(--gxa-gold);
        font-size: 15px; font-weight: 800; line-height: 1.25;
    }
    .gxactdest__titre a { color: var(--gxa-ink); text-decoration: none; }
    .gxactdest__titre a:hover { color: var(--gxa-gold-ink); text-decoration: underline; }
    .gxactdest__titre em {
        flex: 0 0 auto; margin-left: auto; font-style: normal; font-size: 11px; font-weight: 700;
        padding: 1px 7px; border-radius: 999px; background: var(--gxa-soft); color: var(--gxa-muted);
    }
    .gxactdest__liste { list-style: none; margin: 0; padding: 0; }
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
