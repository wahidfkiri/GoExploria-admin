document.addEventListener("DOMContentLoaded", function () {
    initHeroMediaSlider();
    initGallerySwiper();
    initTestimonialSwiper();
    initMobileMenu();
    initBackToTop();
    initStickyHeader();
    initAnchorScroll();
});

function initHeroMediaSlider() {
    const slides = Array.from(document.querySelectorAll(".mah-slide"));
    if (!slides.length) {
        return;
    }

    const thumbs = Array.from(document.querySelectorAll(".mah-thumb"));
    const delay = 8000;
    let current = 0;
    let timer = null;

    const setVideoState = (slide, isActive) => {
        const video = slide.querySelector("video.mah-media");
        if (video) {
            if (isActive) {
                video.play().catch(() => {});
            } else {
                video.pause();
            }
        }
    };

    const activate = (index) => {
        current = (index + slides.length) % slides.length;

        slides.forEach((slide, i) => {
            const isActive = i === current;
            slide.classList.toggle("is-active", isActive);
            setVideoState(slide, isActive);
        });

        thumbs.forEach((thumb, i) => {
            thumb.classList.toggle("is-active", i === current);
        });
    };

    const next = () => activate(current + 1);

    const start = () => {
        stop();
        timer = window.setInterval(next, delay);
    };

    const stop = () => {
        if (timer) {
            window.clearInterval(timer);
            timer = null;
        }
    };

    thumbs.forEach((thumb) => {
        thumb.addEventListener("click", () => {
            const idx = Number.parseInt(thumb.getAttribute("data-target") || "0", 10);
            activate(Number.isNaN(idx) ? 0 : idx);
            start();
        });
    });

    const hero = document.getElementById("hero-slider-media");
    if (hero) {
        hero.addEventListener("mouseenter", stop);
        hero.addEventListener("mouseleave", start);
        hero.addEventListener("touchstart", stop, { passive: true });
        hero.addEventListener("touchend", start, { passive: true });
    }

    document.addEventListener("visibilitychange", () => {
        if (document.hidden) {
            stop();
        } else {
            start();
        }
    });

    activate(0);
    start();
}

function initGallerySwiper() {
    const element = document.querySelector(".gallerySwiper");
    if (!element || typeof Swiper === "undefined") {
        return;
    }

    new Swiper(".gallerySwiper", {
        slidesPerView: 1,
        spaceBetween: 20,
        pagination: {
            el: ".gallerySwiper .swiper-pagination",
            clickable: true
        },
        breakpoints: {
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 }
        }
    });
}

function initTestimonialSwiper() {
    const element = document.querySelector(".testimonialSwiper");
    if (!element || typeof Swiper === "undefined") {
        return;
    }

    new Swiper(".testimonialSwiper", {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 24,
        pagination: {
            el: ".testimonialSwiper .swiper-pagination",
            clickable: true
        },
        breakpoints: {
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 }
        }
    });
}

function initMobileMenu() {
    const mobileBtn = document.getElementById("mobile-menu");
    const navLinks = document.getElementById("nav-links");
    if (!mobileBtn || !navLinks) {
        return;
    }

    mobileBtn.addEventListener("click", function () {
        navLinks.classList.toggle("active");
    });

    navLinks.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", function () {
            navLinks.classList.remove("active");
        });
    });

    window.addEventListener("resize", function () {
        if (window.innerWidth > 900) {
            navLinks.classList.remove("active");
        }
    });
}

function initBackToTop() {
    const backToTopBtn = document.getElementById("backToTop");
    if (!backToTopBtn) {
        return;
    }

    window.addEventListener("scroll", function () {
        if (window.scrollY > 300) {
            backToTopBtn.classList.add("show");
        } else {
            backToTopBtn.classList.remove("show");
        }
    });

    backToTopBtn.addEventListener("click", function () {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });
}

function initStickyHeader() {
    const navbar = document.querySelector(".navbar");
    if (!navbar) {
        return;
    }

    let lastScroll = 0;
    window.addEventListener("scroll", function () {
        const current = window.pageYOffset || document.documentElement.scrollTop;
        if (current > lastScroll && current > 90) {
            navbar.style.transform = "translateY(-100%)";
        } else {
            navbar.style.transform = "translateY(0)";
        }
        lastScroll = current <= 0 ? 0 : current;
    });
}

function initAnchorScroll() {
    const navLinks = document.getElementById("nav-links");
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            const href = this.getAttribute("href");
            if (!href || href === "#") {
                return;
            }

            const target = document.querySelector(href);
            if (!target) {
                return;
            }

            e.preventDefault();

            const y = target.getBoundingClientRect().top + window.scrollY - 88;
            window.scrollTo({ top: y, behavior: "smooth" });

            if (navLinks && navLinks.classList.contains("active")) {
                navLinks.classList.remove("active");
            }
        });
    });
}
