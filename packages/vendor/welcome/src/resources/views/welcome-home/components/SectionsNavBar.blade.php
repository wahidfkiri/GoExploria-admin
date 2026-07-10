{{-- Barre de navigation horizontale — liens vers les principales sections --}}
<nav class="snb-bar" data-snb-main-nav="1" aria-label="{{ __('home-v2.sections_nav.aria') }}">
    <div class="snb-inner">
        <ul class="snb-links">
            <li>
                <a href="#section-medias" class="snb-link">
                    <i class="fas fa-photo-video"></i>
                    <span>{{ __('home-v2.sections_nav.medias') }}</span>
                </a>
            </li>
            <li>
                <a href="#section-next-level" class="snb-link">
                    <i class="fas fa-level-up-alt"></i>
                    <span>{{ __('home-v2.sections_nav.next_level') }}</span>
                </a>
            </li>
            <li>
                <a href="#section-restaurants" class="snb-link">
                    <i class="fas fa-utensils"></i>
                    <span>{{ __('home-v2.sections_nav.restaurants') }}</span>
                </a>
            </li>
            <li>
                <a href="#section-vedettes" class="snb-link">
                    <i class="fas fa-star"></i>
                    <span>{{ __('home-v2.sections_nav.featured') }}</span>
                </a>
            </li>
            <li>
                <a href="#section-voyages" class="snb-link">
                    <i class="fas fa-plane-departure"></i>
                    <span>{{ __('home-v2.sections_nav.travel') }}</span>
                </a>
            </li>
            <li>
                <a href="#section-marketplace" class="snb-link">
                    <i class="fas fa-shopping-cart"></i>
                    <span>{{ __('home-v2.sections_nav.marketplace') }}</span>
                </a>
            </li>
            <li>
                <a href="#section-specialises" class="snb-link">
                    <i class="fas fa-shopping-cart"></i>
                    <span>GO EXPLORIA Espace Spécialisé</span>
                </a>
            </li>
            <li>
                <a href="#section-a-la-une" class="snb-link">
                    <i class="fas fa-newspaper"></i>
                    <span>ZONE GO EXPLORIA INFO</span>
                </a>
            </li>
        </ul>
        <div class="snb-scroll-controls" aria-label="Navigation horizontale">
            <button type="button" class="snb-scroll-btn snb-scroll-left" aria-label="Defiler vers la gauche">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button type="button" class="snb-scroll-btn snb-scroll-right" aria-label="Defiler vers la droite">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</nav>

<style>
    [data-snb-main-nav] .snb-links {
        scroll-behavior: smooth;
    }

    [data-snb-main-nav] .snb-scroll-controls {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-left: 10px;
        flex-shrink: 0;
    }

    [data-snb-main-nav] .snb-scroll-btn {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 1px solid rgba(212, 175, 55, 0.45);
        background: #fff;
        color: #1a2942;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all .2s ease;
    }

    [data-snb-main-nav] .snb-scroll-btn:hover {
        background: #d4af37;
        color: #fff;
        border-color: #d4af37;
    }

    @media (max-width: 768px) {
        [data-snb-main-nav] .snb-scroll-controls {
            gap: 4px;
            margin-left: 6px;
        }

        [data-snb-main-nav] .snb-scroll-btn {
            width: 28px;
            height: 28px;
        }
    }
</style>

<script>
    (function () {
        const initAll = function () {
            const navs = document.querySelectorAll('nav[data-snb-main-nav]');
            if (!navs.length) return;

            navs.forEach(function (nav) {
                if (nav.dataset.snbMainInit === '1') return;
                nav.dataset.snbMainInit = '1';

                let links = Array.from(nav.querySelectorAll('.snb-link[href^="#"]'));
                const linksRow = nav.querySelector('.snb-links');
                const leftBtn = nav.querySelector('.snb-scroll-left');
                const rightBtn = nav.querySelector('.snb-scroll-right');
                if (!links.length || !linksRow) return;

                const setupInfiniteLoop = function () {
                    if (linksRow.dataset.snbLoopReady === '1') return;
                    if (links.length <= 1) return;

                    Array.from(linksRow.children).forEach(function (child) {
                        const clone = child.cloneNode(true);
                        clone.dataset.snbClone = '1';
                        clone.setAttribute('aria-hidden', 'true');
                        clone.querySelectorAll('a, button').forEach(function (item) {
                            item.setAttribute('tabindex', '-1');
                        });
                        linksRow.appendChild(clone);
                    });

                    linksRow.dataset.snbLoopReady = '1';
                    links = Array.from(nav.querySelectorAll('.snb-link[href^="#"]'));
                };

                setupInfiniteLoop();

                const centerLink = function (link) {
                    const targetLeft = link.offsetLeft - (linksRow.clientWidth / 2) + (link.clientWidth / 2);
                    const maxLeft = linksRow.scrollWidth - linksRow.clientWidth;
                    const nextLeft = Math.max(0, Math.min(targetLeft, maxLeft));
                    linksRow.scrollTo({ left: nextLeft, behavior: 'smooth' });
                };

                const setActive = function (link, shouldCenter = true) {
                    links.forEach(function (item) { item.classList.remove('active'); });
                    link.classList.add('active');
                    if (shouldCenter) centerLink(link);
                };

                links.forEach(function (link) {
                    link.addEventListener('click', function () {
                        setActive(link, true);
                    });
                });

                const activateFromHash = function (shouldCenter = false) {
                    const hash = window.location.hash;
                    const found = links.find(function (link) { return link.getAttribute('href') === hash; });
                    if (found) {
                        setActive(found, shouldCenter);
                        return true;
                    }
                    return false;
                };

                if (!activateFromHash(false)) {
                    setActive(links[0], false);
                }

                window.addEventListener('hashchange', function () {
                    activateFromHash(true);
                });

                const step = 320;
                const autoSpeed = 1.4;
                const edgeEpsilon = 2;
                let autoTimer = null;
                let autoPaused = false;

                const hasInfiniteLoop = function () {
                    return linksRow.dataset.snbLoopReady === '1';
                };

                const getCycleWidth = function () {
                    return hasInfiniteLoop() ? (linksRow.scrollWidth / 2) : 0;
                };

                const normalizeLoopPosition = function () {
                    if (!hasInfiniteLoop()) return;
                    const cycleWidth = getCycleWidth();
                    if (cycleWidth <= 0) return;

                    if (linksRow.scrollLeft >= cycleWidth) {
                        linksRow.scrollLeft = linksRow.scrollLeft - cycleWidth;
                    } else if (linksRow.scrollLeft < 0) {
                        linksRow.scrollLeft = linksRow.scrollLeft + cycleWidth;
                    }
                };

                const scrollByStep = function (direction) {
                    if (hasInfiniteLoop()) {
                        const cycleWidth = getCycleWidth();
                        if (cycleWidth <= 0) return;

                        if (direction < 0 && linksRow.scrollLeft <= step) {
                            linksRow.scrollLeft = linksRow.scrollLeft + cycleWidth;
                        }

                        linksRow.scrollTo({
                            left: linksRow.scrollLeft + (direction * step),
                            behavior: 'smooth'
                        });
                        setTimeout(normalizeLoopPosition, 420);
                        return;
                    }

                    const maxLeft = linksRow.scrollWidth - linksRow.clientWidth;
                    if (maxLeft <= 0) return;

                    const current = linksRow.scrollLeft;

                    if (direction > 0) {
                        if (current >= maxLeft - edgeEpsilon) {
                            linksRow.scrollTo({ left: 0, behavior: 'auto' });
                            return;
                        }
                        linksRow.scrollTo({ left: Math.min(current + step, maxLeft), behavior: 'smooth' });
                        return;
                    }

                    if (current <= edgeEpsilon) {
                        linksRow.scrollTo({ left: maxLeft, behavior: 'auto' });
                        return;
                    }

                    linksRow.scrollTo({ left: Math.max(current - step, 0), behavior: 'smooth' });
                };

                const autoTick = function () {
                    if (autoPaused) return;
                    if (hasInfiniteLoop()) {
                        const cycleWidth = getCycleWidth();
                        if (cycleWidth <= 0) return;
                        linksRow.scrollLeft = linksRow.scrollLeft + autoSpeed;
                        if (linksRow.scrollLeft >= cycleWidth) {
                            linksRow.scrollLeft = linksRow.scrollLeft - cycleWidth;
                        }
                        return;
                    }

                    const maxLeft = linksRow.scrollWidth - linksRow.clientWidth;
                    if (maxLeft <= 0) return;
                    const next = linksRow.scrollLeft + autoSpeed;
                    if (next >= maxLeft - edgeEpsilon) {
                        linksRow.scrollLeft = 0;
                        return;
                    }
                    linksRow.scrollLeft = next;
                };

                const startAuto = function () {
                    if (autoTimer) return;
                    autoTimer = setInterval(autoTick, 16);
                };

                const stopAuto = function () {
                    if (!autoTimer) return;
                    clearInterval(autoTimer);
                    autoTimer = null;
                };

                if (leftBtn) {
                    leftBtn.addEventListener('click', function () {
                        scrollByStep(-1);
                    });
                }

                if (rightBtn) {
                    rightBtn.addEventListener('click', function () {
                        scrollByStep(1);
                    });
                }

                nav.addEventListener('mouseenter', function () { autoPaused = true; });
                nav.addEventListener('mouseleave', function () { autoPaused = false; });
                nav.addEventListener('focusin', function () { autoPaused = true; });
                nav.addEventListener('focusout', function () { autoPaused = false; });

                startAuto();
                document.addEventListener('visibilitychange', function () {
                    if (document.hidden) {
                        stopAuto();
                    } else {
                        startAuto();
                    }
                });
            });
        };

        if (!window.__snbMainNavBooted) {
            window.__snbMainNavBooted = true;
            window.__initSnbMainNav = initAll;

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initAll);
            } else {
                initAll();
            }

            window.addEventListener('load', initAll);
            setTimeout(initAll, 0);
            setTimeout(initAll, 300);
        } else if (typeof window.__initSnbMainNav === 'function') {
            window.__initSnbMainNav();
        }
    })();
</script>
