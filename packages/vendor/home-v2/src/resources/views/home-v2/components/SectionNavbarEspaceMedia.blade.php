{{-- Barre de navigation horizontale — liens vers les principales sections --}}
<nav class="snb-bar" id="sectionsNavBarEspaceMedia" aria-label="{{ __('home-v2.sections_nav.aria') }}">
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
    </div>
</nav>

<style>
    #sectionsNavBarEspaceMedia .snb-links {
        scroll-behavior: smooth;
    }
</style>

<script>
    (function () {
        const nav = document.getElementById('sectionsNavBarEspaceMedia');
        if (!nav) return;

        const links = Array.from(nav.querySelectorAll('.snb-link[href^="#"]'));
        const linksRow = nav.querySelector('.snb-links');
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
    })();
</script>
