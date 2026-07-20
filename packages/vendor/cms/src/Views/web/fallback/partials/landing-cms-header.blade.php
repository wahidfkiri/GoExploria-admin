@php
    // $forceCmsHeaderFooter (optionnel) : rend le header d'établissement même si le
    // toggle header_enabled est désactivé (utilisé par les pages CMS autonomes).
    $cmsHeaderHtml = '';
    if (isset($etablissement)) {
        if (($forceCmsHeaderFooter ?? false) && function_exists('get_cms_header_footer_html')) {
            $cmsHeaderHtml = trim((string) get_cms_header_footer_html($etablissement->id, \Vendor\Cms\Models\HeaderFooter::TYPE_HEADER));
        } elseif (function_exists('get_cms_header_html')) {
            $cmsHeaderHtml = trim((string) get_cms_header_html($etablissement->id));
        }
    }
@endphp

@if($cmsHeaderHtml !== '')
    @once
        <style>
            :root {
                --cms-global-header-offset: 0px;
            }

            .cms-establishment-header-shell {
                --cms-establishment-header-height: 0px;
                position: relative;
                z-index: 9990;
            }

            .cms-establishment-header-fixed {
                position: fixed;
                top: var(--cms-global-header-offset, 0px);
                left: 0;
                right: 0;
                width: 100%;
                z-index: 9990;
            }

            .cms-establishment-header-spacer {
                height: var(--cms-establishment-header-height, 0px);
                min-height: var(--cms-establishment-header-height, 0px);
                pointer-events: none;
            }
        </style>

        <script>
            (function () {
                window.__cmsHFscriptRan = true;
                let ticking = false;

                function updateCmsEstablishmentHeader() {
                    const globalHeader = document.querySelector('.header-v2');
                    const globalHeight = globalHeader ? Math.ceil(globalHeader.getBoundingClientRect().height) : 0;
                    document.documentElement.style.setProperty('--cms-global-header-offset', globalHeight + 'px');

                    document.querySelectorAll('.cms-establishment-header-shell').forEach(function (shell) {
                        const fixedHeader = shell.querySelector('.cms-establishment-header-fixed');
                        const headerHeight = fixedHeader ? Math.ceil(fixedHeader.getBoundingClientRect().height) : 0;
                        shell.style.setProperty('--cms-establishment-header-height', headerHeight + 'px');
                    });

                    ticking = false;
                }

                function requestHeaderUpdate() {
                    if (ticking) {
                        return;
                    }

                    ticking = true;
                    window.requestAnimationFrame(updateCmsEstablishmentHeader);
                }

                function bootCmsHeaderSizing() {
                    window.__cmsHFbootRan = true;
                    // Appel DIRECT (pas via requestAnimationFrame) : rAF est suspendu pour un
                    // onglet non-visible, ce qui laissait l'offset bloqué à 0. Les calculs
                    // ponctuels (boot/load/resize/observer) doivent donc être synchrones.
                    updateCmsEstablishmentHeader();

                    if ('ResizeObserver' in window) {
                        const observer = new ResizeObserver(updateCmsEstablishmentHeader);
                        const globalHeader = document.querySelector('.header-v2');
                        if (globalHeader) {
                            observer.observe(globalHeader);
                        }

                        document.querySelectorAll('.cms-establishment-header-fixed').forEach(function (header) {
                            observer.observe(header);
                        });
                    }

                    // Filet de sécurité : quelques passes après le boot (polices / layout tardifs).
                    let passes = 0;
                    const iv = setInterval(function () {
                        updateCmsEstablishmentHeader();
                        if (++passes >= 12) clearInterval(iv);
                    }, 150);
                }

                // Exécute immédiatement si le DOM est déjà prêt (script parsé/injecté après
                // DOMContentLoaded) — corrige le cas où l'offset restait bloqué à 0.
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', bootCmsHeaderSizing);
                } else {
                    bootCmsHeaderSizing();
                }

                window.addEventListener('load', updateCmsEstablishmentHeader);
                window.addEventListener('resize', updateCmsEstablishmentHeader);
                window.addEventListener('scroll', requestHeaderUpdate, { passive: true });
            })();
        </script>

        {{-- ================================================================
             Correctif défensif menu mobile (2 headers : global + CMS DB).
             Centralisé ici → s'applique à toutes les landing pages.
             ================================================================ --}}
        <style>
            /* (b) Le header CMS reste SOUS le header global (10060) et ne
               couvre jamais le burger global. */
            .cms-establishment-header-fixed { z-index: 9990; }

            /* (b2) Le CONTENU du header d'établissement ne doit pas se positionner
               lui-même (position:fixed/sticky + top/z-index) : sinon il s'échappe
               du shell et se colle en haut, DERRIÈRE le header global. Le shell
               (.cms-establishment-header-fixed) gère déjà le placement fixe sous
               le header global ; le contenu doit simplement s'y insérer en flux. */
            .cms-establishment-header-fixed > * {
                position: static !important;
                top: auto !important;
                bottom: auto !important;
                left: auto !important;
                right: auto !important;
                z-index: auto !important;
                width: 100% !important;
                box-sizing: border-box;
            }

            /* (c) Repli mobile pour le menu du header CMS : sa navigation est
               masquée par défaut et révélée quand notre burger est activé.
               Ne s'applique QUE si un burger + une nav ont été détectés
               (l'élément reçoit l'attribut data-cms-hf-nav). */
            @media (max-width: 992px) {
                .cms-establishment-header-fixed [data-cms-hf-nav] { display: none; }
                .cms-establishment-header-fixed[data-cms-hf-open="true"] [data-cms-hf-nav] {
                    display: block;
                }
            }
        </style>

        <script>
            (function () {
                /* (a) Filet de sécurité : ouverture/fermeture du MENU VERTICAL GLOBAL.
                   Les contrôleurs officiels (vertical-menu.js / -dynamic.js) font
                   stopPropagation() sur le burger : s'ils sont bien liés, ce handler
                   délégué ne reçoit jamais l'événement. Il n'agit donc QUE si, à cause
                   du double-chargement de scripts, aucun contrôleur n'a pu se lier. */
                function setGlobalMenu(open) {
                    var menu = document.getElementById('verticalMenuV2');
                    var overlay = document.getElementById('verticalMenuOverlay');
                    if (!menu) return;
                    menu.classList.toggle('active', open);
                    if (overlay) overlay.classList.toggle('active', open);
                    document.body.style.overflow = open ? 'hidden' : '';
                }

                document.addEventListener('click', function (e) {
                    if (e.target.closest('#openVerticalMenu, .vertical-menu-v2-trigger')) {
                        setGlobalMenu(true);
                        return;
                    }
                    if (e.target.closest('#closeVerticalMenu, #verticalMenuOverlay')) {
                        setGlobalMenu(false);
                    }
                }, false);

                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') setGlobalMenu(false);
                });

                /* (c) Menu burger du HEADER CMS (contenu construit dans l'éditeur).
                   Détection générique d'un déclencheur + d'une nav, puis toggle
                   d'un état sur le header. N'agit que si les deux sont trouvés. */
                function pick(root, selectors) {
                    for (var i = 0; i < selectors.length; i++) {
                        var el = root.querySelector(selectors[i]);
                        if (el) return el;
                    }
                    return null;
                }

                function initCmsHeaderMenus() {
                    document.querySelectorAll('.cms-establishment-header-fixed').forEach(function (header) {
                        if (header.dataset.cmsHfWired === '1') return;

                        var toggle = pick(header, [
                            '.navbar-toggler', '.menu-toggle', '.hamburger', '.burger',
                            '.nav-toggle', '.menu-btn', '[data-toggle="menu"]',
                            'button[aria-label*="menu" i]', 'button[aria-label*="Menu"]',
                            'button .fa-bars', '.fa-bars'
                        ]);
                        // Si le "burger" est une icône, remonter au bouton/lien parent.
                        if (toggle && (toggle.classList.contains('fa-bars'))) {
                            toggle = toggle.closest('button, a') || toggle;
                        }

                        var nav = pick(header, [
                            '.navbar-collapse', '.nav-menu', '.mobile-menu', '.menu-list',
                            'nav ul', 'ul[role="menu"]', 'nav'
                        ]);

                        if (!toggle || !nav) return; // header simple sans menu : on ne touche à rien

                        header.dataset.cmsHfWired = '1';
                        if (!nav.hasAttribute('data-cms-hf-nav')) nav.setAttribute('data-cms-hf-nav', '');
                        header.setAttribute('data-cms-hf-open', 'false');

                        toggle.addEventListener('click', function (e) {
                            e.preventDefault();
                            var open = header.getAttribute('data-cms-hf-open') !== 'true';
                            header.setAttribute('data-cms-hf-open', open ? 'true' : 'false');
                            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                        });
                    });
                }

                if (document.readyState !== 'loading') {
                    initCmsHeaderMenus();
                } else {
                    document.addEventListener('DOMContentLoaded', initCmsHeaderMenus);
                }
                window.addEventListener('load', initCmsHeaderMenus);
            })();
        </script>
    @endonce

    <div class="cms-establishment-header-shell">
        <div class="cms-establishment-header-fixed">
            {!! $cmsHeaderHtml !!}
        </div>
        <div class="cms-establishment-header-spacer" aria-hidden="true"></div>
    </div>
@endif
