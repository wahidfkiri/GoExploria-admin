@php
use App\Models\Category;
use App\Models\CategorieType;

$tr = static function (string $text): string {
    $locale = app()->getLocale();
    if ($locale === 'fr') {
        return $text;
    }

    static $maps = [];
    if (! array_key_exists($locale, $maps)) {
        $path = lang_path($locale . DIRECTORY_SEPARATOR . 'home-v2-components-map.php');
        $maps[$locale] = is_file($path) ? (require $path) : [];
    }

    return $maps[$locale][$text] ?? $text;
};

$tourismeType  = CategorieType::where('name', 'like', '%tourisme%')->orWhere('name', 'like', '%Tourisme%')->first();
$businessType  = CategorieType::where('name', 'like', '%business%')->orWhere('name', 'like', '%Business%')->first();

$activitiesQuery = function($q) {
    $q->where('is_active', true)->orderBy('name');
};

$tourismeCats = $tourismeType
    ? $tourismeType->categories()->with(['activities' => $activitiesQuery])->where('is_active', true)->orderBy('name')->get()
    : collect();

$businessCats = $businessType
    ? $businessType->categories()->with(['activities' => $activitiesQuery])->where('is_active', true)->orderBy('name')->get()
    : collect();
@endphp

{{-- ── PANEL TOURISME ── --}}
<div class="cat-mega-panel" id="catMegaPanelTourisme" role="dialog" aria-label="{{ $tr('Catégories Tourisme') }}">
    <div class="cat-mega-left">
        <div class="cat-mega-header">
            <div class="cat-mega-header-icon"><i class="fas fa-map-marked-alt"></i></div>
            <span class="cat-mega-header-title">{{ $tr('Activités Tourisme') }}</span>
        </div>
        @forelse($tourismeCats as $index => $cat)
            <a href="{{ route('category.show', $cat->slug ?? $cat->id) }}"
               class="cat-mega-cat-item {{ $index === 0 ? 'active' : '' }}"
               data-cat-id="t{{ $cat->id }}"
               data-cat-href="{{ route('category.show', $cat->slug ?? $cat->id) }}"
               onclick="catMegaSelect(event, this, 'tourisme')">
                <span>{{ $cat->name }}</span>
                <span class="cat-mega-cat-count">{{ $cat->activities->count() }}</span>
            </a>
        @empty
            <div class="cat-mega-empty">{{ $tr('Aucune catégorie active') }}</div>
        @endforelse
    </div>
    <div class="cat-mega-right">
        <div class="cat-mega-right-inner" id="catMegaRightInnerTourisme">
            @forelse($tourismeCats as $index => $cat)
                <div class="cat-mega-activities {{ $index === 0 ? 'visible' : '' }}"
                     id="cat-acts-t{{ $cat->id }}">
                    @forelse($cat->activities as $act)
                        <a href="{{ route('activity.show', $act->slug ?? $act->id) }}" class="cat-mega-act-link">
                            <span class="cat-mega-act-dot"></span>{{ $act->name }}
                        </a>
                    @empty
                        <div class="cat-mega-empty">{{ $tr('Aucune activité') }}</div>
                    @endforelse
                </div>
            @empty
            @endforelse
        </div>
        @if($tourismeCats->isNotEmpty())
        <div class="cat-mega-footer">
            <a href="{{ route('category.show', $tourismeCats->first()->slug ?? $tourismeCats->first()->id) }}"
               class="cat-mega-view-all" id="catMegaViewAllTourisme">
                {{ $tr('Voir toutes les activités') }} <i class="fas fa-arrow-right" style="font-size:9px;margin-left:2px"></i>
            </a>
            <a href="{{ route('categories.index') }}" class="cat-mega-view-all-cats">{{ $tr('Toutes les catégories') }}</a>
        </div>
        @endif
    </div>
</div>

{{-- ── PANEL BUSINESS ── --}}
<div class="cat-mega-panel" id="catMegaPanelBusiness" role="dialog" aria-label="{{ $tr('Catégories Business') }}">
    <div class="cat-mega-left">
        <div class="cat-mega-header">
            <div class="cat-mega-header-icon"><i class="fas fa-briefcase"></i></div>
            <span class="cat-mega-header-title">{{ $tr('Activités Business') }}</span>
        </div>
        @forelse($businessCats as $index => $cat)
            <a href="{{ route('category.show', $cat->slug ?? $cat->id) }}"
               class="cat-mega-cat-item {{ $index === 0 ? 'active' : '' }}"
               data-cat-id="b{{ $cat->id }}"
               data-cat-href="{{ route('category.show', $cat->slug ?? $cat->id) }}"
               onclick="catMegaSelect(event, this, 'business')">
                <span>{{ $cat->name }}</span>
                <span class="cat-mega-cat-count">{{ $cat->activities->count() }}</span>
            </a>
        @empty
            <div class="cat-mega-empty">{{ $tr('Aucune catégorie active') }}</div>
        @endforelse
    </div>
    <div class="cat-mega-right">
        <div class="cat-mega-right-inner" id="catMegaRightInnerBusiness">
            @forelse($businessCats as $index => $cat)
                <div class="cat-mega-activities {{ $index === 0 ? 'visible' : '' }}"
                     id="cat-acts-b{{ $cat->id }}">
                    @forelse($cat->activities as $act)
                        <a href="{{ route('activity.show', $act->slug ?? $act->id) }}" class="cat-mega-act-link">
                            <span class="cat-mega-act-dot"></span>{{ $act->name }}
                        </a>
                    @empty
                        <div class="cat-mega-empty">{{ $tr('Aucune activité') }}</div>
                    @endforelse
                </div>
            @empty
            @endforelse
        </div>
        @if($businessCats->isNotEmpty())
        <div class="cat-mega-footer">
            <a href="{{ route('category.show', $businessCats->first()->slug ?? $businessCats->first()->id) }}"
               class="cat-mega-view-all" id="catMegaViewAllBusiness">
                {{ $tr('Voir toutes les activités') }} <i class="fas fa-arrow-right" style="font-size:9px;margin-left:2px"></i>
            </a>
            <a href="{{ route('categories.index') }}" class="cat-mega-view-all-cats">{{ $tr('Toutes les catégories') }}</a>
        </div>
        @endif
    </div>
</div>

<script>
/* Fonction partagée de positionnement et gestion des panels */
function initCatMegaPanel(triggerId, panelId, viewAllId) {
    var panel   = document.getElementById(panelId);
    var trigger = document.getElementById(triggerId);
    if (!panel || !trigger) return;

    var closeTimer;

    function positionPanel() {
        if (window.innerWidth <= 768) return;
        var rect   = trigger.getBoundingClientRect();
        var viewW  = window.innerWidth;
        var viewH  = window.innerHeight;
        var panelW = panel ? (panel.offsetWidth || 680) : 680;
        var left   = rect.left + rect.width / 2 - panelW / 2;
        if (left + panelW > viewW - 12) left = viewW - panelW - 12;
        if (left < 12) left = 12;
        var spaceBelow = viewH - rect.bottom - 10;
        var spaceAbove = rect.top - 80;
        var panelH = panel.offsetHeight || 400;
        var top;
        if (spaceBelow >= Math.min(panelH, 260)) {
            top = rect.bottom + 10;
        } else if (spaceAbove >= Math.min(panelH, 260)) {
            top = rect.top - Math.min(panelH, spaceAbove) - 10;
        } else {
            top = 80;
        }
        panel.style.maxHeight = (viewH - top - 16) + 'px';
        panel.style.left = left + 'px';
        panel.style.top  = top  + 'px';
    }

    function openPanel() {
        /* Fermer tous les autres panels */
        document.querySelectorAll('.cat-mega-panel.open').forEach(function(p) {
            if (p !== panel) p.classList.remove('open');
        });
        clearTimeout(closeTimer);
        positionPanel();
        panel.classList.add('open');
    }

    function closePanel() {
        closeTimer = setTimeout(function() { panel.classList.remove('open'); }, 120);
    }

    trigger.addEventListener('click', function(e) {
        e.stopPropagation();
        panel.classList.contains('open') ? panel.classList.remove('open') : openPanel();
    });

    document.addEventListener('click', function(e) {
        if (!panel.contains(e.target) && !trigger.contains(e.target)) {
            panel.classList.remove('open');
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') panel.classList.remove('open');
    });

    window.addEventListener('resize', function() {
        if (panel.classList.contains('open')) positionPanel();
    });
}

/* Initialisation des deux panels */
initCatMegaPanel('catMegaTriggerTourisme', 'catMegaPanelTourisme', 'catMegaViewAllTourisme');
initCatMegaPanel('catMegaTriggerBusiness', 'catMegaPanelBusiness', 'catMegaViewAllBusiness');

/* Sélection d'une catégorie dans un panel donné */
function catMegaSelect(e, el, type) {
    e.preventDefault();
    var panel = document.getElementById('catMegaPanel' + (type === 'tourisme' ? 'Tourisme' : 'Business'));
    if (!panel) return;

    panel.querySelectorAll('.cat-mega-cat-item').forEach(function(i) { i.classList.remove('active'); });
    el.classList.add('active');
    panel.querySelectorAll('.cat-mega-activities').forEach(function(a) { a.classList.remove('visible'); });

    var acts = document.getElementById('cat-acts-' + el.dataset.catId);
    if (acts) acts.classList.add('visible');

    var viewAll = document.getElementById('catMegaViewAll' + (type === 'tourisme' ? 'Tourisme' : 'Business'));
    if (viewAll && el.dataset.catHref) viewAll.href = el.dataset.catHref;
}
</script>
