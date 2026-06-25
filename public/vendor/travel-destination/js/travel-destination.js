(function() {
  'use strict';

  const $ = (sel, ctx) => (ctx || document).querySelector(sel);
  const $$ = (sel, ctx) => [...(ctx || document).querySelectorAll(sel)];
  const on = (el, ev, fn) => el && el.addEventListener(ev, fn);

  /* Theme Toggle */
  (function initTheme() {
    const html = document.documentElement;
    const btn = $('#themeToggle');
    if (!btn) return;
    const stored = localStorage.getItem('wl-theme');
    const system = window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark';
    html.setAttribute('data-theme', stored || system);
    on(btn, 'click', () => {
      const cur = html.getAttribute('data-theme');
      const next = cur === 'dark' ? 'light' : 'dark';
      html.setAttribute('data-theme', next);
      localStorage.setItem('wl-theme', next);
    });
  })();

  /* Sticky Navbar */
  (function initNavbar() {
    const nav = $('#navbar');
    if (!nav) return;
    const fn = () => nav.classList.toggle('scrolled', window.scrollY > 60);
    window.addEventListener('scroll', fn, { passive: true });
    fn();
  })();

  /* Mobile Menu */
  (function initMobileMenu() {
    const hamburger = $('#hamburger');
    const menu = $('#mobileMenu');
    if (!hamburger || !menu) return;
    let open = false;
    function toggle() {
      open = !open;
      hamburger.classList.toggle('open', open);
      menu.classList.toggle('open', open);
      hamburger.setAttribute('aria-expanded', open);
      menu.setAttribute('aria-hidden', !open);
      document.body.style.overflow = open ? 'hidden' : '';
    }
    function close() { if (open) { open = false; hamburger.classList.remove('open'); menu.classList.remove('open'); hamburger.setAttribute('aria-expanded', false); menu.setAttribute('aria-hidden', true); document.body.style.overflow = ''; } }
    on(hamburger, 'click', toggle);
    $$('.mobile-menu__link', menu).forEach(l => on(l, 'click', close));
    on(document, 'click', e => { if (open && !menu.contains(e.target) && !hamburger.contains(e.target)) close(); });
    on(document, 'keydown', e => { if (e.key === 'Escape') close(); });
  })();

  /* Search Overlay */
  (function initSearch() {
    const openBtn = $('#navSearchBtn');
    const overlay = $('#searchOverlay');
    const closeBtn = $('#closeSearch');
    const input = $('.search-overlay__input', overlay);
    if (!overlay) return;
    function open() { overlay.classList.add('open'); overlay.setAttribute('aria-hidden', false); document.body.style.overflow = 'hidden'; setTimeout(() => input && input.focus(), 300); }
    function close() { overlay.classList.remove('open'); overlay.setAttribute('aria-hidden', true); document.body.style.overflow = ''; }
    on(openBtn, 'click', open);
    on(closeBtn, 'click', close);
    on(document, 'keydown', e => { if (e.key === 'Escape') close(); });
    $$('.search-tag', overlay).forEach(tag => { on(tag, 'click', () => { if (input) { input.value = tag.textContent; input.focus(); } }); });
  })();

  /* Hero Swiper */
  (function initHeroSwiper() {
    var el = document.querySelector('.hero-swiper');
    if (!el) return;
    var heroSwiper = new Swiper('.hero-swiper', {
      loop: true, speed: 1000,
      autoplay: { delay: 8000, disableOnInteraction: false },
      effect: 'fade', fadeEffect: { crossFade: true },
      pagination: { el: '.hero-pagination', clickable: true },
      navigation: { prevEl: '.hero-prev', nextEl: '.hero-next' },
      keyboard: { enabled: true },
      on: {
        slideChange: function () {
          var prev = this.slides[this.previousIndex];
          var curr = this.slides[this.activeIndex];
          var vids = prev ? prev.querySelectorAll('video, iframe') : [];
          vids.forEach(function (v) { if (v.tagName === 'VIDEO') { v.pause(); } else if (v.tagName === 'IFRAME') { v.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*'); } });
          var curVids = curr ? curr.querySelectorAll('video, iframe') : [];
          curVids.forEach(function (v) { if (v.tagName === 'VIDEO') { v.play().catch(function () {}); } else if (v.tagName === 'IFRAME') { v.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*'); } });
          (curr ? curr.querySelectorAll('.hero__video-toggle') : []).forEach(function (btn) { btn.innerHTML = '&#10074;&#10074;'; btn.setAttribute('data-paused', '0'); });
        },
      },
    });
  })();

  /* Testimonials Swiper */
  (function initTestimonialsSwiper() {
    if (!document.querySelector('.testimonials-swiper')) return;
    new Swiper('.testimonials-swiper', {
      slidesPerView: 1, spaceBetween: 24, grabCursor: true,
      autoplay: { delay: 5500, disableOnInteraction: false },
      pagination: { el: '.test-pagination', clickable: true },
      breakpoints: { 640: { slidesPerView: 1.2 }, 900: { slidesPerView: 2 }, 1200: { slidesPerView: 3 } },
    });
  })();

  /* Scroll Reveal */
  (function initScrollReveal() {
    const els = $$('.reveal-up, .reveal-fade');
    if (!els.length) return;
    const obs = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const siblings = [...entry.target.parentElement.children].filter(el => el.classList.contains('reveal-up') || el.classList.contains('reveal-fade'));
          const idx = siblings.indexOf(entry.target);
          entry.target.style.transitionDelay = `${idx * 0.08}s`;
          entry.target.classList.add('revealed');
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    els.forEach(el => obs.observe(el));
  })();

  /* Counters */
  (function initCounters() {
    const counters = $$('.counter');
    if (!counters.length) return;
    const obs = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const el = entry.target;
          const target = parseInt(el.getAttribute('data-target'), 10) || 0;
          const duration = 2000, steps = 60;
          let frame = 0;
          const timer = setInterval(() => {
            frame++;
            const ease = 1 - Math.pow(1 - frame / steps, 3);
            const val = Math.min(Math.round(target * ease), target);
            el.textContent = val.toLocaleString();
            if (frame >= steps) { el.textContent = target.toLocaleString(); clearInterval(timer); }
          }, duration / steps);
          obs.unobserve(el);
        }
      });
    }, { threshold: 0.5 });
    counters.forEach(c => obs.observe(c));
  })();

  /* FAQ Accordion */
  (function initFAQ() {
    $$('.faq-item').forEach(item => {
      const q = $('.faq-question', item);
      const a = $('.faq-answer', item);
      if (!q || !a) return;
      on(q, 'click', () => {
        const isOpen = q.getAttribute('aria-expanded') === 'true';
        $$('.faq-item').forEach(other => {
          $('.faq-question', other)?.setAttribute('aria-expanded', 'false');
          $('.faq-answer', other)?.classList.remove('open');
        });
        q.setAttribute('aria-expanded', !isOpen);
        a.classList.toggle('open', !isOpen);
      });
    });
  })();

  /* Gallery Filter */
  (function initGallery() {
    const btns = $$('.filter-btn');
    const items = $$('.masonry-item');
    btns.forEach(btn => {
      on(btn, 'click', () => {
        btns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const filter = btn.getAttribute('data-filter');
        items.forEach(item => {
          const cat = item.getAttribute('data-category');
          if (filter === 'all' || cat === filter) {
            item.classList.remove('hidden');
            item.style.animation = 'fadeIn 0.4s ease forwards';
          } else {
            item.classList.add('hidden');
          }
        });
      });
    });
  })();

  /* Lightbox */
  (function initLightbox() {
    const lb = $('#lightbox');
    const img = $('#lightboxImg');
    const close = $('#lightboxClose');
    const prev = $('#lightboxPrev');
    const next = $('#lightboxNext');
    if (!lb) return;
    const triggers = $$('.lightbox-trigger');
    let idx = 0;
    const images = triggers.map(t => t.getAttribute('data-img'));
    function openAt(i) { idx = (i + images.length) % images.length; img.src = images[idx]; img.alt = 'Gallery image ' + (idx + 1); lb.removeAttribute('hidden'); document.body.style.overflow = 'hidden'; }
    function closeLb() { lb.setAttribute('hidden', ''); img.src = ''; document.body.style.overflow = ''; }
    triggers.forEach((t, i) => on(t, 'click', () => openAt(i)));
    on(prev, 'click', () => openAt(idx - 1));
    on(next, 'click', () => openAt(idx + 1));
    on(close, 'click', closeLb);
    on(document, 'keydown', e => { if (lb.hasAttribute('hidden')) return; if (e.key === 'ArrowLeft') openAt(idx - 1); if (e.key === 'ArrowRight') openAt(idx + 1); if (e.key === 'Escape') closeLb(); });
    on(lb, 'click', e => { if (e.target === lb) closeLb(); });
  })();

  /* Video Popup */
  (function initVideoPopup() {
    const popup = $('#videoPopup');
    const video = $('.video-popup__video', popup);
    const closeBtn = $('#videoClose');
    const backdrop = $('#videoBackdrop');
    if (!popup || !video) return;
    function open(src) {
      if (src && /youtube|youtu\.be/i.test(src)) { window.open(src, '_blank'); return; }
      const s = video.querySelector('source'); if (s) { s.src = src; video.load(); } popup.removeAttribute('hidden'); document.body.style.overflow = 'hidden'; setTimeout(() => video.play().catch(() => {}), 300);
    }
    function closeV() { video.pause(); video.currentTime = 0; popup.setAttribute('hidden', ''); document.body.style.overflow = ''; }
    $$('.hero__slide--video').forEach(function (slide) {
      var iframe = slide.querySelector('iframe.hero__video-bg');
      var vid = slide.querySelector('video.hero__video-bg');
      var src = iframe ? iframe.src : (vid ? vid.currentSrc || vid.querySelector('source')?.src || vid.src : null);
    });
    on(closeBtn, 'click', closeV);
    on(backdrop, 'click', closeV);
    on(document, 'keydown', e => { if (e.key === 'Escape' && !popup.hasAttribute('hidden')) closeV(); });
  })();

  /* Back to Top */
  (function initBackToTop() {
    const btn = $('#backToTop');
    if (!btn) return;
    window.addEventListener('scroll', () => { btn.classList.toggle('visible', window.scrollY > 600); }, { passive: true });
    on(btn, 'click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
  })();

  /* Smooth Scroll */
  (function initSmoothScroll() {
    on(document, 'click', e => {
      const link = e.target.closest('a[href^="#"]');
      if (!link) return;
      const id = link.getAttribute('href');
      if (id === '#') { e.preventDefault(); window.scrollTo({ top: 0, behavior: 'smooth' }); return; }
      const target = document.querySelector(id);
      if (!target) return;
      e.preventDefault();
      const top = target.getBoundingClientRect().top + window.scrollY - 92;
      window.scrollTo({ top, behavior: 'smooth' });
    });
  })();

})();
