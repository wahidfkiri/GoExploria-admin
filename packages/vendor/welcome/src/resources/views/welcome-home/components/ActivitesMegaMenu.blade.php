{{-- =================================================================
     ACTIVITÉS MEGA MENU — déclenché par le bloc « Activités » de la
     search-bar-v2 (Hero de la page d'accueil).

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

    <div class="gxact-mega-head">
        <div class="gxact-mega-head-title">
            <span class="gxact-mega-head-icon"><i class="fas fa-compass" aria-hidden="true"></i></span>
            <span>{{ $tr('Activités') }}</span>
            @if($gxactTotal > 0)
                <small>{{ $gxactTotal }} {{ $tr('activités') }} &middot; {{ $gxactCategories->count() }} {{ $tr('catégories') }}</small>
            @endif
        </div>
        <a href="{{ route('categories.index') }}" class="gxact-mega-head-link">
            {{ $tr('Toutes les catégories') }} <i class="fas fa-arrow-right" aria-hidden="true"></i>
        </a>
    </div>

    @if($gxactCategories->isEmpty())
        <div class="gxact-mega-empty">{{ $tr('Aucune activité disponible pour le moment.') }}</div>
    @else
        <div class="gxact-mega-body">

            {{-- Colonne gauche : catégories --}}
            <div class="gxact-mega-cats">
                @foreach($gxactCategories as $index => $gxactCat)
                    <button type="button"
                            class="gxact-cat {{ $index === 0 ? 'active' : '' }}"
                            data-gxact-pane="gxact-pane-{{ $gxactCat->id }}">
                        <span class="gxact-cat-name">{{ $gxactCat->name }}</span>
                        <span class="gxact-cat-count">{{ $gxactCat->activities->count() }}</span>
                    </button>
                @endforeach
            </div>

            {{-- Colonne droite : activités de la catégorie sélectionnée --}}
            <div class="gxact-mega-panes">
                @foreach($gxactCategories as $index => $gxactCat)
                    <div class="gxact-pane {{ $index === 0 ? 'visible' : '' }}" id="gxact-pane-{{ $gxactCat->id }}">
                        <div class="gxact-pane-head">
                            <h4 class="gxact-pane-title">{{ $gxactCat->name }}</h4>
                            <a href="{{ route('category.show', $gxactCat->slug ?: $gxactCat->id) }}" class="gxact-pane-link">
                                {{ $tr('Voir la catégorie') }} <i class="fas fa-chevron-right" aria-hidden="true"></i>
                            </a>
                        </div>

                        <div class="gxact-grid">
                            @foreach($gxactCat->activities as $gxactAct)
                                <a class="gxact-card"
                                   href="{{ route('activity.show', $gxactAct->slug ?: $gxactAct->id) }}"
                                   title="{{ $gxactAct->name }}">
                                    <span class="gxact-card-media">
                                        @if($gxactAct->image_url)
                                            <img src="{{ $gxactAct->image_url }}" alt="{{ $gxactAct->name }}" loading="lazy">
                                        @else
                                            <span class="gxact-card-placeholder"><i class="fas fa-mountain-sun" aria-hidden="true"></i></span>
                                        @endif
                                    </span>
                                    <span class="gxact-card-body">
                                        <span class="gxact-card-name">{{ $gxactAct->name }}</span>
                                        <span class="gxact-card-cat">{{ $gxactCat->name }}</span>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    @endif
</div>

<style>
.gxact-mega {
    position: fixed;
    width: 880px;
    max-width: calc(100vw - 24px);
    background: #ffffff;
    border: 1px solid rgba(10, 22, 40, .08);
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, .30);
    opacity: 0;
    visibility: hidden;
    transform: translateY(8px);
    transition: opacity .22s ease, transform .22s ease, visibility .22s;
    z-index: 10500;
    overflow: hidden;
    font-family: 'Montserrat', 'Arial', sans-serif;
}
.gxact-mega.open { opacity: 1; visibility: visible; transform: translateY(0); }

/* ── En-tête ── */
.gxact-mega-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 12px 18px;
    border-bottom: 1px solid rgba(10, 22, 40, .08);
    background: #f7f9fc;
}
.gxact-mega-head-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    font-weight: 800;
    color: #0a1628;
    text-transform: uppercase;
    letter-spacing: .06em;
}
.gxact-mega-head-title small {
    font-size: 11px;
    font-weight: 600;
    color: #6b7280;
    text-transform: none;
    letter-spacing: 0;
}
.gxact-mega-head-icon {
    width: 28px;
    height: 28px;
    flex: 0 0 28px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #1a72cc;
    color: #fff;
    font-size: 13px;
}
.gxact-mega-head-link {
    font-size: 12px;
    font-weight: 700;
    color: #1a72cc;
    text-decoration: none;
    white-space: nowrap;
}
.gxact-mega-head-link:hover { text-decoration: underline; }

.gxact-mega-empty {
    padding: 26px 20px;
    text-align: center;
    font-size: 13px;
    color: #6b7280;
}

/* ── Corps : 2 colonnes ── */
.gxact-mega-body { display: flex; flex-direction: row; align-items: stretch; }

.gxact-mega-cats {
    width: 250px;
    flex: 0 0 250px;
    background: #f7f9fc;
    border-right: 1px solid rgba(10, 22, 40, .08);
    padding: 10px 0;
    max-height: 460px;
    overflow-y: auto;
}
.gxact-cat {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    width: 100%;
    padding: 9px 18px;
    border: 0;
    background: transparent;
    cursor: pointer;
    text-align: left;
    font-family: inherit;
    font-size: 13px;
    font-weight: 600;
    color: #0a1628;
    border-left: 3px solid transparent;
    transition: background .18s ease, color .18s ease, border-color .18s ease;
}
.gxact-cat:hover { background: rgba(26, 114, 204, .07); }
.gxact-cat.active {
    background: #ffffff;
    color: #1a72cc;
    border-left-color: #1a72cc;
    font-weight: 800;
}
.gxact-cat-name { flex: 1 1 auto; min-width: 0; }
.gxact-cat-count {
    flex: 0 0 auto;
    min-width: 22px;
    padding: 1px 7px;
    border-radius: 999px;
    background: rgba(10, 22, 40, .08);
    font-size: 10px;
    font-weight: 800;
    color: #4b5563;
    text-align: center;
}
.gxact-cat.active .gxact-cat-count { background: #1a72cc; color: #fff; }

.gxact-mega-panes {
    flex: 1 1 auto;
    min-width: 0;
    padding: 14px 18px 18px;
    max-height: 460px;
    overflow-y: auto;
}
.gxact-pane { display: none; }
.gxact-pane.visible { display: block; }

.gxact-pane-head {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 12px;
}
.gxact-pane-title {
    margin: 0;
    font-size: 13px;
    font-weight: 800;
    color: #0a1628;
    text-transform: uppercase;
    letter-spacing: .05em;
}
.gxact-pane-link {
    font-size: 11px;
    font-weight: 700;
    color: #1a72cc;
    text-decoration: none;
    white-space: nowrap;
}
.gxact-pane-link:hover { text-decoration: underline; }

/* ── Grille des activités ── */
.gxact-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 12px;
}
.gxact-card {
    display: flex;
    flex-direction: column;
    text-decoration: none;
    border: 1px solid rgba(10, 22, 40, .08);
    border-radius: 12px;
    overflow: hidden;
    background: #fff;
    transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
}
.gxact-card:hover {
    transform: translateY(-2px);
    border-color: rgba(26, 114, 204, .45);
    box-shadow: 0 10px 22px rgba(10, 22, 40, .14);
}
.gxact-card-media {
    display: block;
    position: relative;
    width: 100%;
    aspect-ratio: 16 / 10;
    background: #eef2f7;
    overflow: hidden;
}
.gxact-card-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .3s ease;
}
.gxact-card:hover .gxact-card-media img { transform: scale(1.06); }
.gxact-card-placeholder {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #1a72cc 0%, #0a1628 100%);
    color: rgba(255, 255, 255, .8);
    font-size: 22px;
}
.gxact-card-body { display: block; padding: 8px 10px 10px; }
.gxact-card-name {
    display: block;
    font-size: 12px;
    font-weight: 700;
    line-height: 1.35;
    color: #0a1628;
}
.gxact-card-cat {
    display: block;
    margin-top: 2px;
    font-size: 10px;
    font-weight: 600;
    color: #6b7280;
}

@media (max-width: 900px) {
    .gxact-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
@media (max-width: 768px) {
    .gxact-mega {
        position: fixed;
        left: 12px !important;
        right: 12px;
        width: auto;
        max-width: none;
    }
    .gxact-mega-body { flex-direction: column; }
    .gxact-mega-cats {
        width: 100%;
        flex: 0 0 auto;
        max-height: none;
        border-right: 0;
        border-bottom: 1px solid rgba(10, 22, 40, .08);
        padding: 6px 0;
        display: flex;
        flex-direction: row;
        overflow-x: auto;
        overflow-y: hidden;
    }
    .gxact-cat {
        width: auto;
        flex: 0 0 auto;
        white-space: nowrap;
        border-left: 0;
        border-bottom: 3px solid transparent;
        padding: 8px 14px;
    }
    .gxact-cat.active { border-left: 0; border-bottom-color: #1a72cc; }
    .gxact-mega-panes { max-height: 55vh; padding: 12px; }
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
            if (window.innerWidth <= 768) {
                panel.style.top = (trigger.getBoundingClientRect().bottom + 10) + 'px';
                panel.style.left = '';
                panel.style.maxHeight = '';
                return;
            }
            var rect   = trigger.getBoundingClientRect();
            var viewW  = window.innerWidth;
            var viewH  = window.innerHeight;
            var panelW = panel.offsetWidth || 880;
            /* Le déclencheur est à droite de la barre : on aligne le panneau
               sur son bord droit, puis on le recadre dans le viewport. */
            var left = rect.right - panelW;
            if (left + panelW > viewW - 12) left = viewW - panelW - 12;
            if (left < 12) left = 12;

            var top = rect.bottom + 10;
            if (top > viewH - 160) top = Math.max(80, viewH - 160);

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
        panel.querySelectorAll('.gxact-cat').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var pane = document.getElementById(btn.dataset.gxactPane);
                if (!pane) return;
                panel.querySelectorAll('.gxact-cat').forEach(function (b) { b.classList.remove('active'); });
                panel.querySelectorAll('.gxact-pane').forEach(function (p) { p.classList.remove('visible'); });
                btn.classList.add('active');
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
