<script>
(function () {
    const pcConfig = {!! \Illuminate\Support\Js::from($pcConfig) !!};

    if (window.Swiper) {
        new Swiper('.pc-hero-swiper', {
            loop: true,
            effect: 'fade',
            speed: 900,
            autoplay: { delay: 5200, disableOnInteraction: false },
            pagination: { el: '.pc-hero-swiper .swiper-pagination', clickable: true },
            navigation: { nextEl: '.pc-hero-next', prevEl: '.pc-hero-prev' }
        });

        new Swiper('.pc-reviews-swiper', {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 24,
            autoplay: { delay: 4200, disableOnInteraction: false },
            breakpoints: { 760: { slidesPerView: 2 }, 1100: { slidesPerView: 3 } }
        });
    }

    const nav = document.getElementById('pcNav');
    window.addEventListener('scroll', () => nav && nav.classList.toggle('pc-scrolled', window.scrollY > 60));

    const hamburger = document.getElementById('pcHamburger');
    const mobileMenu = document.getElementById('pcMobileMenu');
    hamburger && hamburger.addEventListener('click', () => mobileMenu && mobileMenu.classList.toggle('pc-open'));
    mobileMenu && mobileMenu.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => mobileMenu.classList.remove('pc-open')));

    const lightbox = document.getElementById('pcLightbox');
    const lightboxImg = document.getElementById('pcLightboxImg');
    const lightboxClose = document.getElementById('pcLightboxClose');
    document.querySelectorAll('[data-pc-img]').forEach((item) => {
        item.addEventListener('click', () => {
            if (!lightbox || !lightboxImg) return;
            lightboxImg.src = item.getAttribute('data-pc-img') || '';
            lightbox.classList.add('pc-open');
        });
    });
    const closeLightbox = () => lightbox && lightbox.classList.remove('pc-open');
    lightboxClose && lightboxClose.addEventListener('click', closeLightbox);
    lightbox && lightbox.addEventListener('click', (event) => { if (event.target === lightbox) closeLightbox(); });

    const revealEls = document.querySelectorAll('.pc-reveal');
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => { if (entry.isIntersecting) entry.target.classList.add('pc-visible'); });
        }, { threshold: 0.12 });
        revealEls.forEach((el) => observer.observe(el));
    } else {
        revealEls.forEach((el) => el.classList.add('pc-visible'));
    }

    document.querySelectorAll('.pc-social-tab').forEach((button) => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.pc-social-tab').forEach((tab) => tab.classList.remove('pc-active'));
            button.classList.add('pc-active');
        });
    });

    if (window.L && document.getElementById('pcMap')) {
        const map = L.map('pcMap', { scrollWheelZoom: false, zoomControl: true }).setView([pcConfig.lat, pcConfig.lng], 4);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap' }).addTo(map);
        const icon = L.divIcon({
            className: 'pc-map-marker',
            html: '<div style="width:44px;height:44px;border-radius:50%;background:#8B6F4E;color:#fff;display:grid;place-items:center;border:3px solid #fff;box-shadow:0 8px 24px rgba(0,0,0,.28)"><i class="fa-solid fa-building"></i></div>',
            iconSize: [44, 44],
            iconAnchor: [22, 44],
            popupAnchor: [0, -44]
        });
        const popupHtml = [
            '<div style="width:320px;max-width:78vw;font-family:DM Sans,sans-serif;">',
                '<strong style="display:block;margin-bottom:6px;color:#1A1A1A;font-size:15px;">' + pcConfig.siteName + '</strong>',
                '<span style="display:block;margin-bottom:10px;color:#7A7670;font-size:12px;line-height:1.45;">' + pcConfig.address + '</span>',
                '<iframe style="width:100%;height:180px;border:0;border-radius:10px;display:block;" src="https://www.youtube.com/embed/MfAAJgCzOAs?autoplay=1&mute=1&playsinline=1&rel=0&modestbranding=1" title="Vidéo localisation" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>',
            '</div>'
        ].join('');

        L.marker([pcConfig.lat, pcConfig.lng], { icon }).addTo(map).bindPopup(popupHtml, {
            maxWidth: 340,
            className: 'pc-video-popup'
        });
        setTimeout(() => map.invalidateSize(), 400);
    }
})();
</script>

