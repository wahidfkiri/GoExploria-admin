{{-- =================================================================
     ACTIVITÉS MEGA MENU — déclenché par le bloc PLAN N GO / « Activités »
     de la search-bar-v2 (Hero de la page d'accueil).

     Contenu 100 % dynamique : table `activities` (actives) regroupées
     par `categories` (actives) — nom + image + lien vers la landing
     page de l'activité (/activity/{slug}).
     ================================================================= --}}

@php(ob_start());@endphp
@php
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

    // Catégories actives ayant au moins une activité active
    $gxactCategories = \App\Models\Category::query()
        ->where('is_active', true)
        ->whereHas('activities', function ($q) {
            $q->where('is_active', true);
        })
        ->with(['activities' => function ($q) {
            $q->where('is_active', true)->orderBy('name');
        }])
        ->orderBy('name')
        ->get();

    $gxactTotal = $gxactCategories->sum(function ($cat) {
        return $cat->activities->count();
    });
@endphp

<div class="gxact-mega" id="activitesMegaPanel" role="dialog" aria-label="{{ $tr('Activités') }}" aria-hidden="true">

    {{-- ── En-tête ── --}}
    <div class="gxact-head">
        <img src="{{ asset('plan-n-go.png') }}" alt="PLAN N GO" class="gxact-head-logo" loading="lazy">
        <div class="gxact-head-text">
            <span class="gxact-head-title">{{ $tr('Activités') }}</span>
            @if($gxactTotal > 0)
                <span class="gxact-head-sub">{{ $gxactTotal }} {{ $tr('activités') }} &middot; {{ $gxactCategories->count() }} {{ $tr('catégories') }}</span>
            @endif
        </div>
        <a href="{{ route('categories.index') }}" class="gxact-head-link">
            {{ $tr('Toutes les catégories') }} <i class="fas fa-arrow-right" aria-hidden="true"></i>
        </a>
        <button type="button" class="gxact-close" aria-label="{{ $tr('Fermer') }}">
            <i class="fas fa-xmark" aria-hidden="true"></i>
        </button>
    </div>

    @if($gxactCategories->isEmpty())
        <div class="gxact-empty">{{ $tr('Aucune activité disponible pour le moment.') }}</div>
    @else
        {{-- ── Catégories (chips) ── --}}
        <div class="gxact-chips" role="tablist">
            @foreach($gxactCategories as $index => $gxactCat)
                <button type="button"
                        role="tab"
                        class="gxact-chip {{ $index === 0 ? 'active' : '' }}"
                        aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                        aria-controls="gxact-pane-{{ $gxactCat->id }}"
                        data-gxact-pane="gxact-pane-{{ $gxactCat->id }}">
                    {{ $gxactCat->name }}
                    <span class="gxact-chip-count">{{ $gxactCat->activities->count() }}</span>
                </button>
            @endforeach
        </div>

        {{-- ── Activités de la catégorie sélectionnée ── --}}
        <div class="gxact-panes">
            @foreach($gxactCategories as $index => $gxactCat)
                <div class="gxact-pane {{ $index === 0 ? 'visible' : '' }}"
                     id="gxact-pane-{{ $gxactCat->id }}"
                     role="tabpanel">
                    <div class="gxact-grid">
                        @foreach($gxactCat->activities as $gxactAct)
                            <a class="gxact-card"
                               href="{{ route('activity.show', $gxactAct->slug ?: $gxactAct->id) }}"
                               title="{{ $gxactAct->name }}">
                                <span class="gxact-card-media">
                                    @if($gxactAct->image_url)
                                        <img src="{{ $gxactAct->image_url }}" alt="{{ $gxactAct->name }}" loading="lazy">
                                    @else
                                        <span class="gxact-card-ph"><i class="fas fa-mountain-sun" aria-hidden="true"></i></span>
                                    @endif
                                </span>
                                <span class="gxact-card-overlay"></span>
                                <span class="gxact-card-info">
                                    <span class="gxact-card-cat">{{ $gxactCat->name }}</span>
                                    <span class="gxact-card-name">{{ $gxactAct->name }}</span>
                                </span>
                                <span class="gxact-card-go"><i class="fas fa-arrow-right" aria-hidden="true"></i></span>
                            </a>
                        @endforeach
                    </div>

                    <div class="gxact-pane-foot">
                        <a href="{{ route('category.show', $gxactCat->slug ?: $gxactCat->id) }}" class="gxact-pane-link">
                            {{ $tr('Voir la catégorie') }} : {{ $gxactCat->name }}
                            <i class="fas fa-chevron-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
/* =========================================================
   ACTIVITÉS MEGA MENU — thème sombre « glass » aligné sur le
   Hero (search-bar-v2) + accent orange du logo PLAN N GO.
   ========================================================= */
.gxact-mega {
    --gxact-accent: #f7941e;
    --gxact-accent-soft: rgba(247, 148, 30, .16);
    --gxact-line: rgba(255, 255, 255, .10);
    --gxact-text: #f2f6fc;
    --gxact-muted: #93a4bd;

    position: fixed;
    width: 940px;
    max-width: calc(100vw - 24px);
    background: linear-gradient(180deg, rgba(9, 20, 40, .97) 0%, rgba(5, 13, 28, .98) 100%);
    -webkit-backdrop-filter: blur(18px);
    backdrop-filter: blur(18px);
    border: 1px solid var(--gxact-line);
    border-radius: 20px;
    box-shadow: 0 30px 80px rgba(0, 0, 0, .55);
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px) scale(.985);
    transition: opacity .24s ease, transform .24s ease, visibility .24s;
    z-index: 10500;
    overflow: hidden;
    color: var(--gxact-text);
    font-family: 'Montserrat', 'Arial', sans-serif;
    display: flex;
    flex-direction: column;
}
.gxact-mega.open { opacity: 1; visibility: visible; transform: translateY(0) scale(1); }

/* Liseré d'accent en haut du panneau */
.gxact-mega::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--gxact-accent), #ffc46b 45%, transparent 100%);
}

/* ── En-tête ── */
.gxact-head {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px 20px 14px;
    border-bottom: 1px solid var(--gxact-line);
    flex: 0 0 auto;
}
.gxact-head-logo {
    height: 30px;
    width: auto;
    display: block;
    flex: 0 0 auto;
    filter: drop-shadow(0 4px 10px rgba(0, 0, 0, .5));
}
.gxact-head-text { display: flex; flex-direction: column; gap: 2px; min-width: 0; margin-right: auto; }
.gxact-head-title {
    font-size: 15px;
    font-weight: 800;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: #fff;
}
.gxact-head-sub { font-size: 11px; font-weight: 600; color: var(--gxact-muted); }
.gxact-head-link {
    flex: 0 0 auto;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 14px;
    border-radius: 999px;
    border: 1px solid rgba(247, 148, 30, .45);
    background: var(--gxact-accent-soft);
    font-size: 11.5px;
    font-weight: 800;
    letter-spacing: .04em;
    color: #ffc46b;
    text-decoration: none;
    white-space: nowrap;
    transition: background .2s ease, color .2s ease, border-color .2s ease;
}
.gxact-head-link:hover { background: var(--gxact-accent); border-color: var(--gxact-accent); color: #0a1628; }
.gxact-head-link i { font-size: 9px; }
.gxact-close {
    flex: 0 0 auto;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1px solid var(--gxact-line);
    background: rgba(255, 255, 255, .05);
    color: var(--gxact-muted);
    cursor: pointer;
    font-size: 14px;
    line-height: 1;
    transition: background .2s ease, color .2s ease;
}
.gxact-close:hover { background: rgba(255, 255, 255, .13); color: #fff; }

.gxact-empty { padding: 34px 20px; text-align: center; font-size: 13px; color: var(--gxact-muted); }

/* ── Chips de catégories ── */
.gxact-chips {
    display: flex;
    flex-wrap: nowrap;
    gap: 8px;
    padding: 14px 20px;
    overflow-x: auto;
    overflow-y: hidden;
    border-bottom: 1px solid var(--gxact-line);
    flex: 0 0 auto;
    scrollbar-width: thin;
    scrollbar-color: rgba(255, 255, 255, .18) transparent;
}
.gxact-chips::-webkit-scrollbar { height: 5px; }
.gxact-chips::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, .18); border-radius: 99px; }
.gxact-chip {
    flex: 0 0 auto;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 14px;
    border-radius: 999px;
    border: 1px solid var(--gxact-line);
    background: rgba(255, 255, 255, .04);
    color: #cbd6e6;
    font-family: inherit;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
    cursor: pointer;
    transition: background .18s ease, color .18s ease, border-color .18s ease, transform .18s ease;
}
.gxact-chip:hover { background: rgba(255, 255, 255, .09); color: #fff; transform: translateY(-1px); }
.gxact-chip.active {
    background: var(--gxact-accent);
    border-color: var(--gxact-accent);
    color: #0a1628;
    box-shadow: 0 6px 18px rgba(247, 148, 30, .32);
}
.gxact-chip-count {
    min-width: 20px;
    padding: 1px 6px;
    border-radius: 999px;
    background: rgba(255, 255, 255, .12);
    font-size: 10px;
    font-weight: 800;
    text-align: center;
}
.gxact-chip.active .gxact-chip-count { background: rgba(10, 22, 40, .22); }

/* ── Panneaux ── */
.gxact-panes {
    flex: 1 1 auto;
    min-height: 0;
    padding: 18px 20px 20px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: rgba(255, 255, 255, .18) transparent;
}
.gxact-panes::-webkit-scrollbar { width: 6px; }
.gxact-panes::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, .18); border-radius: 99px; }
.gxact-pane { display: none; }
.gxact-pane.visible { display: block; animation: gxactFade .28s ease both; }
@keyframes gxactFade { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: none; } }

/* ── Grille des activités ── */
.gxact-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 14px;
}
.gxact-card {
    position: relative;
    display: block;
    aspect-ratio: 4 / 3;
    border-radius: 14px;
    overflow: hidden;
    text-decoration: none;
    border: 1px solid var(--gxact-line);
    background: #0f1d33;
    transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
}
.gxact-card:hover {
    transform: translateY(-3px);
    border-color: rgba(247, 148, 30, .6);
    box-shadow: 0 16px 34px rgba(0, 0, 0, .5);
}
.gxact-card-media { position: absolute; inset: 0; display: block; }
.gxact-card-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .45s ease;
}
.gxact-card:hover .gxact-card-media img { transform: scale(1.08); }
.gxact-card-ph {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #17304f 0%, #0a1628 100%);
    color: rgba(247, 148, 30, .75);
    font-size: 26px;
}
.gxact-card-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(5, 13, 28, 0) 34%, rgba(5, 13, 28, .88) 100%);
    transition: background .22s ease;
}
.gxact-card:hover .gxact-card-overlay {
    background: linear-gradient(180deg, rgba(5, 13, 28, .12) 0%, rgba(5, 13, 28, .93) 100%);
}
.gxact-card-info {
    position: absolute;
    left: 0; right: 0; bottom: 0;
    display: block;
    padding: 10px 11px 11px;
}
.gxact-card-cat {
    display: block;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: #ffb648;
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.gxact-card-name {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    font-size: 12.5px;
    font-weight: 700;
    line-height: 1.32;
    color: #fff;
}
.gxact-card-go {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--gxact-accent);
    color: #0a1628;
    font-size: 11px;
    opacity: 0;
    transform: translateY(-6px);
    transition: opacity .22s ease, transform .22s ease;
}
.gxact-card:hover .gxact-card-go { opacity: 1; transform: translateY(0); }

/* ── Pied de panneau ── */
.gxact-pane-foot { margin-top: 16px; padding-top: 13px; border-top: 1px solid var(--gxact-line); }
.gxact-pane-link {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 12px;
    font-weight: 700;
    color: #ffb648;
    text-decoration: none;
}
.gxact-pane-link:hover { color: #fff; }
.gxact-pane-link i { font-size: 9px; }

/* ── Responsive ── */
@media (max-width: 1100px) {
    .gxact-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
}
@media (max-width: 820px) {
    .gxact-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
@media (max-width: 768px) {
    .gxact-mega {
        left: 12px !important;
        right: 12px;
        width: auto;
        max-width: none;
        border-radius: 16px;
    }
    .gxact-head { padding: 12px 14px 11px; gap: 10px; flex-wrap: wrap; }
    .gxact-head-logo { height: 24px; }
    .gxact-head-title { font-size: 13px; }
    .gxact-head-link { order: 3; width: 100%; justify-content: center; }
    .gxact-chips { padding: 10px 14px; }
    .gxact-panes { padding: 14px; }
}
@media (max-width: 420px) {
    .gxact-grid { grid-template-columns: 1fr; }
}
</style>

<script>
(function () {
    function initActivitesMega() {
        var panel   = document.getElementById('activitesMegaPanel');
        var trigger = document.getElementById('activitesMegaTrigger');
        if (!panel || !trigger) return;
        if (trigger.dataset.gxactBound === '1') return;
        trigger.dataset.gxactBound = '1';

        function positionPanel() {
            var rect  = trigger.getBoundingClientRect();
            var viewH = window.innerHeight;

            if (window.innerWidth <= 768) {
                panel.style.left = '';
                panel.style.top  = (rect.bottom + 10) + 'px';
                panel.style.maxHeight = (viewH - rect.bottom - 24) + 'px';
                return;
            }

            var viewW  = window.innerWidth;
            var panelW = panel.offsetWidth || 940;
            /* Le déclencheur est à droite de la barre : on aligne le panneau
               sur son bord droit, puis on le recadre dans le viewport. */
            var left = rect.right - panelW;
            if (left + panelW > viewW - 12) left = viewW - panelW - 12;
            if (left < 12) left = 12;

            var top = rect.bottom + 12;
            if (top > viewH - 200) top = Math.max(80, viewH - 200);

            panel.style.left = left + 'px';
            panel.style.top  = top + 'px';
            panel.style.maxHeight = (viewH - top - 16) + 'px';
        }

        function closePanel() {
            panel.classList.remove('open');
            panel.setAttribute('aria-hidden', 'true');
            trigger.setAttribute('aria-expanded', 'false');
        }

        function openPanel() {
            /* Un seul mega-menu ouvert à la fois (coordination globale du site) */
            if (typeof window.goCloseOtherMega === 'function') {
                window.goCloseOtherMega(panel);
            }
            positionPanel();
            panel.classList.add('open');
            panel.setAttribute('aria-hidden', 'false');
            trigger.setAttribute('aria-expanded', 'true');
        }

        /* Les autres mega-menus ferment celui-ci */
        window.goMegaClosers = window.goMegaClosers || [];
        window.goMegaClosers.push(function (exceptEl) {
            if (exceptEl !== panel) closePanel();
        });

        trigger.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            panel.classList.contains('open') ? closePanel() : openPanel();
        });

        trigger.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                panel.classList.contains('open') ? closePanel() : openPanel();
            }
        });

        var closeBtn = panel.querySelector('.gxact-close');
        if (closeBtn) closeBtn.addEventListener('click', closePanel);

        document.addEventListener('click', function (e) {
            if (!panel.classList.contains('open')) return;
            if (!panel.contains(e.target) && !trigger.contains(e.target)) closePanel();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closePanel();
        });

        window.addEventListener('resize', function () {
            if (panel.classList.contains('open')) positionPanel();
        }, { passive: true });

        /* Bascule de catégorie */
        panel.querySelectorAll('.gxact-chip').forEach(function (chip) {
            chip.addEventListener('click', function () {
                var pane = document.getElementById(chip.dataset.gxactPane);
                if (!pane) return;
                panel.querySelectorAll('.gxact-chip').forEach(function (c) {
                    c.classList.remove('active');
                    c.setAttribute('aria-selected', 'false');
                });
                panel.querySelectorAll('.gxact-pane').forEach(function (p) { p.classList.remove('visible'); });
                chip.classList.add('active');
                chip.setAttribute('aria-selected', 'true');
                pane.classList.add('visible');
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initActivitesMega);
    } else {
        initActivitesMega();
    }
})();
</script>
@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp
