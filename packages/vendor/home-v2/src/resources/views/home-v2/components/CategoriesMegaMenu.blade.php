@php
use App\Models\Category;
$catMenuItems = Category::with(['activities' => function($q) {
    $q->where('is_active', true)->orderBy('name');
}])->where('is_active', true)->orderBy('name')->get();
@endphp

{{-- ── Categories Mega Menu Panel (position:fixed, positionné par JS) ── --}}
<div class="cat-mega-panel" id="catMegaPanel" role="dialog" aria-label="Catégories et activités">

    {{-- Left: categories list --}}
    <div class="cat-mega-left">
        <div class="cat-mega-header">
            <div class="cat-mega-header-icon"><i class="fas fa-tag"></i></div>
            <span class="cat-mega-header-title">Catégories</span>
        </div>

        @forelse($catMenuItems as $index => $cat)
            <a href="{{ route('category.show', $cat->slug ?? $cat->id) }}"
               class="cat-mega-cat-item {{ $index === 0 ? 'active' : '' }}"
               data-cat-id="{{ $cat->id }}"
               data-cat-href="{{ route('category.show', $cat->slug ?? $cat->id) }}"
               onclick="catMegaSelect(event, this)">
                <span>{{ $cat->name }}</span>
                <span class="cat-mega-cat-count">{{ $cat->activities->count() }}</span>
            </a>
        @empty
            <div class="cat-mega-empty">Aucune catégorie active</div>
        @endforelse
    </div>

    {{-- Right: activities per category --}}
    <div class="cat-mega-right">
        <div class="cat-mega-right-inner" id="catMegaRightInner">
            @forelse($catMenuItems as $index => $cat)
                <div class="cat-mega-activities {{ $index === 0 ? 'visible' : '' }}"
                     id="cat-acts-{{ $cat->id }}">
                    @forelse($cat->activities as $act)
                        <a href="{{ route('activity.show', $act->slug ?? $act->id) }}"
                           class="cat-mega-act-link">
                            <span class="cat-mega-act-dot"></span>
                            {{ $act->name }}
                        </a>
                    @empty
                        <div class="cat-mega-empty">Aucune activité pour cette catégorie</div>
                    @endforelse
                </div>
            @empty
            @endforelse
        </div>

        {{-- Footer --}}
        @if($catMenuItems->isNotEmpty())
        <div class="cat-mega-footer">
            <a href="{{ route('category.show', $catMenuItems->first()->slug ?? $catMenuItems->first()->id) }}"
               class="cat-mega-view-all"
               id="catMegaViewAll">
                Voir toutes les activités <i class="fas fa-arrow-right" style="font-size:9px;margin-left:2px"></i>
            </a>
            <a href="{{ route('categories.index') }}" class="cat-mega-view-all-cats">
                Toutes les catégories
            </a>
        </div>
        @endif
    </div>
</div>

<script>
(function () {
    var panel    = document.getElementById('catMegaPanel');
    var trigger  = document.getElementById('catMegaTrigger');
    if (!panel || !trigger) return;

    var closeTimer;

    /* ── Positionnement fixed sous/au-dessus du trigger ── */
    function positionPanel() {
        /* Sur mobile ≤768px, le CSS gère le positionnement via !important (top:12vh, left:12px, right:12px).
           On n'applique aucun style inline pour ne pas interférer. */
        if (window.innerWidth <= 768) return;

        var rect   = trigger.getBoundingClientRect();
        var viewW  = window.innerWidth;
        var viewH  = window.innerHeight;

        /* Largeur du panel (déjà visible en visibility:hidden → offsetWidth ok) */
        var panelW = panel.offsetWidth || 680;

        /* Position horizontale centrée sur le trigger */
        var left = rect.left + rect.width / 2 - panelW / 2;
        if (left + panelW > viewW - 12) left = viewW - panelW - 12;
        if (left < 12) left = 12;

        /* Espace disponible en dessous et au-dessus */
        var spaceBelow = viewH - rect.bottom - 10;
        var spaceAbove = rect.top - 80; /* 80 = hauteur header */

        /* Hauteur prévisionnelle du panel */
        var panelH = panel.offsetHeight || (viewW <= 768 ? viewH * 0.65 : 400);

        var top;
        if (spaceBelow >= Math.min(panelH, 260)) {
            /* Suffisamment d'espace en dessous : afficher sous le trigger */
            top = rect.bottom + 10;
        } else if (spaceAbove >= Math.min(panelH, 260)) {
            /* Pas de place en dessous → afficher AU-DESSUS du trigger */
            top = rect.top - Math.min(panelH, spaceAbove) - 10;
        } else {
            /* Cas extrême (petit écran) : ancrer sous le header */
            top = 80;
        }

        /* Limiter la hauteur max au viewport disponible depuis ce top */
        panel.style.maxHeight = (viewH - top - 16) + 'px';
        panel.style.left = left + 'px';
        panel.style.top  = top  + 'px';
    }

    function openPanel() {
        clearTimeout(closeTimer);
        positionPanel();
        panel.classList.add('open');
    }

    function closePanel() {
        closeTimer = setTimeout(function () {
            panel.classList.remove('open');
        }, 120);
    }

    /* Hover desktop uniquement (≥769px) — sur mobile, le tap simulé déclenche
       mouseleave juste après click et fermerait le panel immédiatement */
    if (window.innerWidth > 768) {
        trigger.addEventListener('mouseenter', openPanel);
        trigger.addEventListener('mouseleave', closePanel);
        panel.addEventListener('mouseenter', function () { clearTimeout(closeTimer); });
        panel.addEventListener('mouseleave', closePanel);
    }

    /* Clic mobile : toggle */
    trigger.addEventListener('click', function (e) {
        e.stopPropagation();
        if (panel.classList.contains('open')) {
            panel.classList.remove('open');
        } else {
            openPanel();
        }
    });

    /* Fermer si clic à l'extérieur */
    document.addEventListener('click', function (e) {
        if (!panel.contains(e.target) && !trigger.contains(e.target)) {
            panel.classList.remove('open');
        }
    });

    /* Fermer sur Escape */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') panel.classList.remove('open');
    });

    /* Repositionner au resize */
    window.addEventListener('resize', function () {
        if (panel.classList.contains('open')) positionPanel();
    });
})();

/* Sélection d'une catégorie */
function catMegaSelect(e, el) {
    e.preventDefault();

    document.querySelectorAll('.cat-mega-cat-item').forEach(function (i) {
        i.classList.remove('active');
    });
    el.classList.add('active');

    document.querySelectorAll('.cat-mega-activities').forEach(function (a) {
        a.classList.remove('visible');
    });

    var catId = el.dataset.catId;
    var acts  = document.getElementById('cat-acts-' + catId);
    if (acts) acts.classList.add('visible');

    var viewAll = document.getElementById('catMegaViewAll');
    if (viewAll && el.dataset.catHref) {
        viewAll.href = el.dataset.catHref;
    }
}
</script>
