{{-- =================================================================
     HERO QUICK MEGA MENUS — 6 panels dynamiques
     Même logique que CategoriesMegaMenu (iT / iB) :
       where('name', 'like', '%mot%') sur CategorieType
       → categories() actives → activities() actives.
     ================================================================= --}}

@php(ob_start());@endphp
@php
    use App\Models\CategorieType;

    $hqmConfig = [
        [
            'keyword' => 'marketplace',
            'trigger' => 'quickLinkMP',
            'panel'   => 'hqmMP',
            'icon'    => 'fas fa-shopping-cart',
            'title'   => 'Marketplace',
        ],
        [
            'keyword' => 'entreprise',
            'trigger' => 'quickLinkEE',
            'panel'   => 'hqmEE',
            'icon'    => 'fas fa-building',
            'title'   => 'Espace Entreprise',
        ],
        [
            'keyword' => 'destination',
            'trigger' => 'quickLinkED',
            'panel'   => 'hqmED',
            'icon'    => 'fas fa-map-marked-alt',
            'title'   => 'Espace Destination',
        ],
        [
            'keyword' => 'véhicule',
            'trigger' => 'quickLinkCar',
            'panel'   => 'hqmCar',
            'icon'    => 'fas fa-car-side',
            'title'   => 'Location Véhicule',
        ],
        [
            'keyword' => 'avion',
            'trigger' => 'quickLinkPlane',
            'panel'   => 'hqmPlane',
            'icon'    => 'fas fa-plane-departure',
            'title'   => 'Billets Avion',
        ],
        [
            'keyword' => 'plan',
            'trigger' => 'planNGoTrigger',
            'panel'   => 'hqmPlanNGo',
            'icon'    => 'fas fa-route',
            'title'   => 'Plan & GO',
        ],
    ];

    $activitiesQuery = function ($q) {
        $q->where('is_active', true)->orderBy('name');
    };

    // Pour chaque panel, récupérer le CategorieType correspondant par mot-clé
    $hqmPanels = [];
    foreach ($hqmConfig as $panel) {
        $kw = $panel['keyword'];
        $type = CategorieType::where(function ($q) use ($kw) {
                $q->where('name', 'like', '%' . $kw . '%')
                  ->orWhere('name', 'like', '%' . ucfirst($kw) . '%');
            })
            ->first();

        $panel['cats'] = $type
            ? $type->categories()->with(['activities' => $activitiesQuery])
                   ->where('is_active', true)->orderBy('name')->get()
            : collect();

        $hqmPanels[] = $panel;
    }

    // Pré-calculé pour @json() (évite un array_map inline qui fait planter le parser Blade)
    $hqmJsInit = array_map(function ($p) {
        return [
            'trigger' => $p['trigger'],
            'panel'   => $p['panel'],
            'viewAll' => $p['panel'] . '-viewAll',
        ];
    }, $hqmConfig);
@endphp

@foreach($hqmPanels as $panel)
    <div class="cat-mega-panel hqm-panel" id="{{ $panel['panel'] }}" role="dialog" aria-label="{{ $panel['title'] }}">
        <div class="cat-mega-left">
            <div class="cat-mega-header">
                <div class="cat-mega-header-icon"><i class="{{ $panel['icon'] }}"></i></div>
                <span class="cat-mega-header-title">{{ $panel['title'] }}</span>
            </div>
            @forelse($panel['cats'] as $index => $cat)
                <a href="{{ route('category.show', $cat->slug ?? $cat->id) }}"
                   class="cat-mega-cat-item {{ $index === 0 ? 'active' : '' }}"
                   data-cat-id="{{ $panel['panel'] }}-{{ $cat->id }}"
                   data-cat-href="{{ route('category.show', $cat->slug ?? $cat->id) }}"
                   onclick="hqmSelect(event, this, '{{ $panel['panel'] }}')">
                    <span>{{ $cat->name }}</span>
                    @if($cat->activities->isNotEmpty())
                        <span class="cat-mega-cat-arrow"><i class="fas fa-chevron-right"></i></span>
                    @endif
                </a>
            @empty
                <div class="cat-mega-empty">Aucune catégorie active</div>
            @endforelse
        </div>
        <div class="cat-mega-right">
            <div class="cat-mega-right-inner" id="{{ $panel['panel'] }}-inner">
                @foreach($panel['cats'] as $index => $cat)
                    <ul class="cat-mega-activities {{ $index === 0 ? 'visible' : '' }}"
                        id="cat-acts-{{ $panel['panel'] }}-{{ $cat->id }}">
                        @forelse($cat->activities as $act)
                            <li>
                                <a href="{{ route('activity.show', $act->slug ?? $act->id) }}" class="cat-mega-act-link">
                                    <span class="cat-mega-act-dot"></span>{{ $act->name }}
                                </a>
                            </li>
                        @empty
                            <li class="cat-mega-empty">Aucune activité</li>
                        @endforelse
                    </ul>
                @endforeach
            </div>
            @if($panel['cats']->isNotEmpty())
                <div class="cat-mega-footer">
                    <a href="{{ route('category.show', $panel['cats']->first()->slug ?? $panel['cats']->first()->id) }}"
                       class="cat-mega-view-all" id="{{ $panel['panel'] }}-viewAll">
                        Voir toutes les activités <i class="fas fa-arrow-right" style="font-size:9px;margin-left:2px"></i>
                    </a>
                    <a href="{{ route('categories.index') }}" class="cat-mega-view-all-cats">Toutes les catégories</a>
                </div>
            @endif
        </div>
    </div>
@endforeach

<script>
/* Réutilise initCatMegaPanel() défini dans CategoriesMegaMenu */
(function () {
    function bootHqm() {
        if (typeof window.initCatMegaPanel !== 'function') {
            return setTimeout(bootHqm, 60);
        }
        var panels = @json($hqmJsInit);
        panels.forEach(function (p) {
            if (document.getElementById(p.trigger) && document.getElementById(p.panel)) {
                window.initCatMegaPanel(p.trigger, p.panel, p.viewAll);
            }
        });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bootHqm);
    } else {
        bootHqm();
    }
})();

function hqmSelect(e, el, panelId) {
    if (el.closest('.vmenu-inline-panel')) return;
    e.preventDefault();
    e.stopPropagation();
    var panel = el.closest('.cat-mega-panel') || document.getElementById(panelId);
    if (!panel) return;
    var acts = panel.querySelector('#cat-acts-' + el.dataset.catId);
    /* État courant : la catégorie est-elle déjà ouverte ? */
    var isOpen = el.classList.contains('active') && acts && acts.classList.contains('visible');
    panel.querySelectorAll('.cat-mega-cat-item').forEach(function (i) { i.classList.remove('active'); });
    panel.querySelectorAll('.cat-mega-activities').forEach(function (a) { a.classList.remove('visible'); });
    /* Toggle : un second clic sur la même catégorie referme sa liste */
    if (isOpen) return;
    el.classList.add('active');
    if (acts) acts.classList.add('visible');
    var viewAll = panel.querySelector('#' + panelId + '-viewAll');
    if (viewAll && el.dataset.catHref) viewAll.href = el.dataset.catHref;
}
</script>
@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp
