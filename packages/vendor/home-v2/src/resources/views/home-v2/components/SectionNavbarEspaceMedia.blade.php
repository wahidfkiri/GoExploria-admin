{{-- Barre de navigation horizontale — liens vers les principales sections --}}
<nav class="snb-bar" data-snb-media-nav="1" aria-label="{{ __('home-v2.sections_nav.aria') }}">
    <div class="snb-inner">
        <ul class="snb-links">
            <li>
                <a href="#business-tourism" class="snb-link">
                    <i class="fas fa-briefcase"></i>
                    <span>ESPACES TOURISME ET BUSINESS</span>
                </a>
            </li>
            <li>
                <a href="#geo-carte-videos" class="snb-link">
                    <i class="fas fa-globe"></i>
                    <span>ESPACE GÉO-CARTE-VIDÉOS</span>
                </a>
            </li>
            <li>
                <a href="#vp-chaine" class="snb-link">
                    <i class="fas fa-film"></i>
                    <span>ESPACES CHAÎNE VIDÉOS</span>
                </a>
            </li>
            <li>
                <a href="#my-tube" class="snb-link">
                    <i class="fas fa-videos"></i>
                    <span>ESPACES MY-TUBE</span>
                </a>
            </li>
            <li>
                <a href="#go-tik-tok" class="snb-link">
                    <i class="fas fa-tiktok"></i>
                    <span>ESPACES GO-TIK-TOK</span>
                </a>
            </li>
            <li>
                <a href="#photos" class="snb-link">
                    <i class="fas fa-camera"></i>
                    <span>ESPACES PHOTOS</span>
                </a>
            </li>
            <li>
                <a href="#slideshow" class="snb-link">
                    <i class="fas fa-images"></i>
                    <span>ESPACES SLIDE-SHOW MULTIPLES</span>
                </a>
            </li>
            <li>
                <a href="#section-vedettes" class="snb-link">
                    <i class="fas fa-language"></i>
                    <span>ESPACES MULTILINGUES</span>
                </a>
            </li>
            <li>
                <a href="#reseaux-sociaux" class="snb-link">
                    <i class="fas fa-share-alt"></i>
                    <span>ESPACES RÉSEAUX SOCIAUX</span>
                </a>
            </li>
            <li>
                <a href="#avis-clients" class="snb-link">
                    <i class="fas fa-star"></i>
                    <span>ESPACES AVIS CLIENTS</span>
                </a>
            </li>
            <li>
                <a href="#espace-templates" class="snb-link">
                    <i class="fas fa-layer-group"></i>
                    <span>ESPACES TEMPLATES</span>
                </a>
            </li>
            <li>
                <a href="#espace-mail-marketing" class="snb-link">
                    <i class="fas fa-envelope"></i>
                    <span>ESPACES MAIL MARKETING</span>
                </a>
            </li>
            <li>
                <a href="#espace-chat" class="snb-link">
                    <i class="fas fa-comments"></i>
                    <span>ESPACES MODULE CHAT</span>
                </a>
            </li>
            <li>
                <a href="#espace-blog" class="snb-link">
                    <i class="fas fa-rss"></i>
                    <span>ESPACES BLOG</span>
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
    [data-snb-media-nav] .snb-links {
        scroll-behavior: smooth;
    }

    [data-snb-media-nav] .snb-scroll-controls {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-left: 10px;
        flex-shrink: 0;
    }

    [data-snb-media-nav] .snb-scroll-btn {
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

    [data-snb-media-nav] .snb-scroll-btn:hover {
        background: #d4af37;
        color: #fff;
        border-color: #d4af37;
    }

    @media (max-width: 768px) {
        [data-snb-media-nav] .snb-scroll-controls {
            gap: 4px;
            margin-left: 6px;
        }

        [data-snb-media-nav] .snb-scroll-btn {
            width: 28px;
            height: 28px;
        }
    }
</style>

<script>
    (function () {
        const navs = document.querySelectorAll('nav[data-snb-media-nav]');
        if (!navs.length) return;

        const initNav = (nav) => {
            if (nav.dataset.snbMediaInit === '1') return;
            nav.dataset.snbMediaInit = '1';

            const links = Array.from(nav.querySelectorAll('.snb-link[href^="#"]'));
            const linksRow = nav.querySelector('.snb-links');
            const leftBtn = nav.querySelector('.snb-scroll-left');
            const rightBtn = nav.querySelector('.snb-scroll-right');
            if (!links.length || !linksRow) return;

            const centerLink = (link) => {
                const targetLeft = link.offsetLeft - (linksRow.clientWidth / 2) + (link.clientWidth / 2);
                const maxLeft = linksRow.scrollWidth - linksRow.clientWidth;
                const nextLeft = Math.max(0, Math.min(targetLeft, maxLeft));
                linksRow.scrollTo({ left: nextLeft, behavior: 'smooth' });
            };

            const setActive = (link, shouldCenter = true) => {
                links.forEach((item) => item.classList.remove('active'));
                link.classList.add('active');
                if (shouldCenter) centerLink(link);
            };

            links.forEach((link) => {
                link.addEventListener('click', function () {
                    setActive(link, true);
                });
            });

            const activateFromHash = (shouldCenter = false) => {
                const hash = window.location.hash;
                const found = links.find((link) => link.getAttribute('href') === hash);
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
            let autoTimer = null;
            let autoPaused = false;

            const scrollByStep = (direction) => {
                linksRow.scrollBy({ left: direction * step, behavior: 'smooth' });
            };

            const autoTick = () => {
                if (autoPaused) return;
                const maxLeft = linksRow.scrollWidth - linksRow.clientWidth;
                if (maxLeft <= 0) return;
                const next = linksRow.scrollLeft + autoSpeed;
                linksRow.scrollLeft = next >= maxLeft ? 0 : next;
            };

            const startAuto = () => {
                if (autoTimer) return;
                autoTimer = setInterval(autoTick, 16);
            };

            const stopAuto = () => {
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
        };

        navs.forEach(initNav);
    })();
</script>
