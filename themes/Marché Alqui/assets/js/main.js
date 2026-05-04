/**
 * Main JavaScript for Marché Alqui Theme
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize Hero Swiper (if exists)
    const heroSwiperElement = document.querySelector('.heroSwiper');
    if (heroSwiperElement) {
        const heroSwiper = new Swiper('.heroSwiper', {
            loop: true,
            autoplay: { 
                delay: 5500, 
                disableOnInteraction: false 
            },
            pagination: { 
                el: '.swiper-pagination', 
                clickable: true 
            },
            navigation: { 
                nextEl: '.swiper-button-next', 
                prevEl: '.swiper-button-prev' 
            },
            effect: 'slide'
        });
    }
    
    // Initialize Gallery Swiper (if exists)
    const gallerySwiperElement = document.querySelector('.gallerySwiper');
    if (gallerySwiperElement) {
        const gallerySwiper = new Swiper('.gallerySwiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            pagination: { el: '.swiper-pagination', clickable: true },
            breakpoints: { 
                768: { slidesPerView: 2 }, 
                1024: { slidesPerView: 3 } 
            }
        });
    }
    
    // Initialize Testimonial Swiper (if exists)
    const testimonialSwiperElement = document.querySelector('.testimonialSwiper');
    if (testimonialSwiperElement) {
        const testimonialSwiper = new Swiper('.testimonialSwiper', {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 24,
            pagination: { el: '.swiper-pagination', clickable: true },
            breakpoints: { 
                768: { slidesPerView: 2 }, 
                1024: { slidesPerView: 3 } 
            }
        });
    }
    
    // Back to Top Button
    const backToTopBtn = document.getElementById('backToTop');
    if (backToTopBtn) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        });
        
        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
    
    // Mobile menu toggle
    const mobileBtn = document.getElementById('mobile-menu');
    const navLinks = document.getElementById('nav-links');
    if (mobileBtn && navLinks) {
        mobileBtn.addEventListener('click', function() {
            navLinks.classList.toggle('active');
        });
    }
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href && href !== '#' && href.startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    // Close mobile menu if open
                    if (navLinks && navLinks.classList.contains('active')) {
                        navLinks.classList.remove('active');
                    }
                }
            }
        });
    });
    
    // Sticky header effect (hide on scroll down, show on scroll up)
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        let lastScroll = 0;
        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;
            if (currentScroll > lastScroll && currentScroll > 100) {
                navbar.style.transform = 'translateY(-100%)';
            } else {
                navbar.style.transform = 'translateY(0)';
            }
            lastScroll = currentScroll;
        });
    }
});