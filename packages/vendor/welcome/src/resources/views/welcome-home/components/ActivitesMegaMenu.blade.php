{{-- =================================================================
     ACTIVITÉS MEGA MENU — déclenché par le bloc « Activités » de la
     search-bar-v2 (Hero de la page d'accueil).

     Contenu 100 % dynamique : table `activities` (actives) regroupées
     par `categories` (actives) — nom + image + lien vers la landing
     page de l'activité (/activity/{slug}).

     UI : thème clair, colonne de catégories à gauche, grille de tuiles
     « image + libellé dessous » à droite.
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
@endphp

<div class="gxact-mega" id="activitesMegaPanel" role="dialog" aria-label="{{ $tr('Activités') }}" aria-hidden="true">

    @if($gxactCategories->isEmpty())
        <div class="gxact-empty">{{ $tr('Aucune activité disponible pour le moment.') }}</div>
    @else
        <div class="gxact-body">

            {{-- ── Colonne gauche : catégories ── --}}
            <div class="gxact-cats" role="tablist" aria-label="{{ $tr('Catégories') }}">
                @foreach($gxactCategories as $index => $gxactCat)
                    <button type="button"
                            role="tab"
                            class="gxact-cat {{ $index === 0 ? 'active' : '' }}"
                            aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                            aria-controls="gxact-pane-{{ $gxactCat->id }}"
                            data-gxact-pane="gxact-pane-{{ $gxactCat->id }}">
                        <span class="gxact-cat-name">{{ $gxactCat->name }}</span>
                        <i class="fas fa-chevron-right" aria-hidden="true"></i>
                    </button>
                @endforeach

                <a href="{{ route('categories.index') }}" class="gxact-cats-all">
                    {{ $tr('Toutes les catégories') }}
                </a>
            </div>

            {{-- ── Colonne droite : activités de la catégorie sélectionnée ── --}}
            <div class="gxact-panes">
                @foreach($gxactCategories as $index => $gxactCat)
                    <div class="gxact-pane {{ $index === 0 ? 'visible' : '' }}"
                         id="gxact-pane-{{ $gxactCat->id }}"
                         role="tabpanel">

                        <h3 class="gxact-pane-title">{{ $tr('Explorer') }} {{ $gxactCat->name }}</h3>

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
                                    <span class="gxact-card-name">{{ $gxactAct->name }}</span>
                                </a>
                            @endforeach
                        </div>

                        <a href="{{ route('category.show', $gxactCat->slug ?: $gxactCat->id) }}" class="gxact-pane-link">
                            {{ $tr('Voir toutes les activités') }} <i class="fas fa-chevron-right" aria-hidden="true"></i>
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    @endif
</div>

<style>
/* =========================================================
   ACTIVITÉS MEGA MENU — thème clair
   ========================================================= */
.gxact-mega {
    --gxact-ink: #0f1111;
    --gxact-muted: #565959;
    --gxact-line: #e3e6e6;
    --gxact-tile: #f1f3f4;
    --gxact-link: #007185;
    --gxact-hover: #f5f7f7;

    position: fixed;
    width: 900px;
    max-width: calc(100vw - 24px);
    background: #ffffff;
    border: 1px solid #d5d9d9;
    border-radius: 8px;
    box-shadow: 0 14px 38px rgba(15, 17, 17, .22);
    opacity: 0;
    visibility: hidden;
    transform: translateY(6px);
    transition: opacity .18s ease, transform .18s ease, visibility .18s;
    z-index: 10500;
    overflow: hidden;
    color: var(--gxact-ink);
    font-family: 'Montserrat', Arial, sans-serif;
    display: flex;
    flex-direction: column;
}
.gxact-mega.open { opacity: 1; visibility: visible; transform: translateY(0); }

.gxact-empty { padding: 34px 20px; text-align: center; font-size: 14px; color: var(--gxact-muted); }

.gxact-body { display: flex; flex-direction: row; align-items: stretch; min-height: 0; }

/* ── Colonne gauche : catégories ── */
.gxact-cats {
    width: 246px;
    flex: 0 0 246px;
    border-right: 1px solid var(--gxact-line);
    padding: 12px 0;
    overflow-y: auto;
}
.gxact-cat {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    width: 100%;
    padding: 10px 18px;
    border: 0;
    border-left: 3px solid transparent;
    background: transparent;
    cursor: pointer;
    text-align: left;
    font-family: inherit;
    font-size: 14px;
    font-weight: 500;
    line-height: 1.35;
    color: var(--gxact-ink);
    transition: background .15s ease, border-color .15s ease;
}
.gxact-cat i { font-size: 10px; color: #9aa0a6; flex: 0 0 auto; }
.gxact-cat:hover { background: var(--gxact-hover); }
.gxact-cat.active {
    background: var(--gxact-hover);
    border-left-color: var(--gxact-link);
    font-weight: 700;
}
.gxact-cat.active i { color: var(--gxact-link); }
.gxact-cat-name { flex: 1 1 auto; min-width: 0; }

.gxact-cats-all {
    display: block;
    margin: 10px 18px 2px;
    padding-top: 12px;
    border-top: 1px solid var(--gxact-line);
    font-size: 13px;
    font-weight: 600;
    color: var(--gxact-link);
    text-decoration: none;
}
.gxact-cats-all:hover { text-decoration: underline; }

/* ── Colonne droite : activités ── */
.gxact-panes {
    flex: 1 1 auto;
    min-width: 0;
    padding: 20px 24px 22px;
    overflow-y: auto;
}
.gxact-pane { display: none; }
.gxact-pane.visible { display: block; }

.gxact-pane-title {
    margin: 0 0 16px;
    font-size: 20px;
    font-weight: 700;
    line-height: 1.25;
    color: var(--gxact-ink);
}

.gxact-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 20px 20px;
}
.gxact-card { display: block; text-decoration: none; color: var(--gxact-ink); }
.gxact-card-media {
    display: block;
    position: relative;
    width: 100%;
    aspect-ratio: 1 / 1;
    border-radius: 10px;
    background: var(--gxact-tile);
    overflow: hidden;
}
.gxact-card-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .3s ease;
}
.gxact-card:hover .gxact-card-media img { transform: scale(1.04); }
.gxact-card-ph {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #b6bcc0;
    font-size: 30px;
}
.gxact-card-name {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-top: 10px;
    font-size: 15px;
    font-weight: 500;
    line-height: 1.3;
    color: var(--gxact-ink);
}
.gxact-card:hover .gxact-card-name { color: var(--gxact-link); text-decoration: underline; }

.gxact-pane-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 20px;
    font-size: 13px;
    font-weight: 600;
    color: var(--gxact-link);
    text-decoration: none;
}
.gxact-pane-link:hover { text-decoration: underline; }
.gxact-pane-link i { font-size: 9px; }

/* ── Responsive ── */
@media (max-width: 900px) {
    .gxact-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .gxact-cats { width: 200px; flex: 0 0 200px; }
}
@media (max-width: 768px) {
    .gxact-mega {
        left: 12px !important;
        right: 12px;
        width: auto;
        max-width: none;
    }
    .gxact-body { flex-direction: column; }
    .gxact-cats {
        width: 100%;
        flex: 0 0 auto;
        display: flex;
        flex-direction: row;
        gap: 4px;
        border-right: 0;
        border-bottom: 1px solid var(--gxact-line);
        padding: 8px 10px;
        overflow-x: auto;
        overflow-y: hidden;
    }
    .gxact-cat {
        width: auto;
        flex: 0 0 auto;
        white-space: nowrap;
        border-left: 0;
        border-bottom: 3px solid transparent;
        padding: 8px 12px;
    }
    .gxact-cat i { display: none; }
    .gxact-cat.active { border-left: 0; border-bottom-color: var(--gxact-link); }
    .gxact-cats-all { flex: 0 0 auto; margin: 0; padding: 8px 12px; border-top: 0; white-space: nowrap; }
    .gxact-panes { padding: 16px; }
    .gxact-pane-title { font-size: 17px; margin-bottom: 12px; }
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
                panel.style.top  = (rect.bottom + 8) + 'px';
                panel.style.maxHeight = (viewH - rect.bottom - 24) + 'px';
                return;
            }

            var viewW  = window.innerWidth;
            var panelW = panel.offsetWidth || 900;
            /* Le déclencheur est à droite de la barre : on aligne le panneau
               sur son bord droit, puis on le recadre dans le viewport. */
            var left = rect.right - panelW;
            if (left + panelW > viewW - 12) left = viewW - panelW - 12;
            if (left < 12) left = 12;

            var top = rect.bottom + 8;
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

        /* Bascule de catégorie — au survol comme au clic (façon mega-menu) */
        panel.querySelectorAll('.gxact-cat').forEach(function (btn) {
            function select() {
                var pane = document.getElementById(btn.dataset.gxactPane);
                if (!pane) return;
                panel.querySelectorAll('.gxact-cat').forEach(function (b) {
                    b.classList.remove('active');
                    b.setAttribute('aria-selected', 'false');
                });
                panel.querySelectorAll('.gxact-pane').forEach(function (p) { p.classList.remove('visible'); });
                btn.classList.add('active');
                btn.setAttribute('aria-selected', 'true');
                pane.classList.add('visible');
            }
            btn.addEventListener('click', select);
            btn.addEventListener('mouseenter', select);
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
