@once
{{-- Chargeur + initialiseur Swiper injecté sur le front quand une page contient
     du markup Swiper. Les templates ne contiennent AUCUN <script> (donc rien que
     GrapesJS puisse casser) : ils fournissent uniquement le markup .swiper /
     .swiper-slide + des data-attributs d'options. L'init se fait ici, côté front. --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
(function () {
    function intAttr(el, name, def) {
        var v = parseInt(el.getAttribute(name), 10);
        return isNaN(v) ? def : v;
    }
    function initHero(el) {
        if (el.__swiper || !window.Swiper) return;
        var slides = el.querySelectorAll('.swiper-slide').length;
        el.__swiper = new Swiper(el, {
            loop: slides > 1,
            speed: 800,
            effect: el.getAttribute('data-swiper-effect') || 'slide',
            autoplay: { delay: intAttr(el, 'data-swiper-delay', 6000), disableOnInteraction: false },
            pagination: { el: el.querySelector('.swiper-pagination'), clickable: true },
            navigation: {
                nextEl: el.querySelector('.swiper-button-next'),
                prevEl: el.querySelector('.swiper-button-prev')
            },
            on: {
                slideChange: function () {
                    // (re)lancer les vidéos de la slide active
                    el.querySelectorAll('video').forEach(function (v) { try { v.pause(); } catch (e) {} });
                    var active = el.querySelector('.swiper-slide-active video');
                    if (active) { try { active.currentTime = 0; active.play(); } catch (e) {} }
                }
            }
        });
    }
    function initGallery(el) {
        if (el.__swiper || !window.Swiper) return;
        el.__swiper = new Swiper(el, {
            loop: false,
            slidesPerView: 1.15,
            spaceBetween: 14,
            pagination: { el: el.querySelector('.swiper-pagination'), clickable: true },
            navigation: {
                nextEl: el.querySelector('.swiper-button-next'),
                prevEl: el.querySelector('.swiper-button-prev')
            },
            breakpoints: { 640: { slidesPerView: 2.2 }, 992: { slidesPerView: 3.2 } }
        });
    }
    function initLightbox() {
        if (window.__cmsLightboxBound) return;
        window.__cmsLightboxBound = true;
        var box = document.createElement('div');
        box.className = 'cms-lightbox';
        box.innerHTML = '<button class="cms-lightbox-close" aria-label="Fermer">&times;</button><img alt="">';
        box.style.cssText = 'position:fixed;inset:0;z-index:100000;display:none;align-items:center;justify-content:center;background:rgba(5,8,15,.92);padding:24px';
        document.body.appendChild(box);
        var img = box.querySelector('img');
        img.style.cssText = 'max-width:94vw;max-height:90vh;border-radius:12px;box-shadow:0 30px 90px rgba(0,0,0,.6)';
        var close = box.querySelector('.cms-lightbox-close');
        close.style.cssText = 'position:absolute;top:18px;right:26px;background:transparent;border:0;color:#fff;font-size:40px;line-height:1;cursor:pointer';
        function hide() { box.style.display = 'none'; }
        box.addEventListener('click', function (e) { if (e.target === box || e.target === close) hide(); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') hide(); });
        document.addEventListener('click', function (e) {
            var t = e.target.closest('[data-lightbox]');
            if (!t) return;
            e.preventDefault();
            var src = t.getAttribute('data-lightbox') || (t.tagName === 'IMG' ? t.src : (t.querySelector('img') ? t.querySelector('img').src : ''));
            if (!src) return;
            img.src = src;
            box.style.display = 'flex';
        });
    }
    function initAll() {
        if (!window.Swiper) return;
        document.querySelectorAll('[data-swiper-hero]').forEach(initHero);
        document.querySelectorAll('[data-swiper-gallery]').forEach(initGallery);
        initLightbox();
    }
    if (document.readyState !== 'loading') initAll();
    else document.addEventListener('DOMContentLoaded', initAll);
    window.addEventListener('load', initAll);
})();
</script>
@endonce
