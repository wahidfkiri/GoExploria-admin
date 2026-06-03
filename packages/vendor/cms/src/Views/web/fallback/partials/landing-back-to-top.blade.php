@once
    <style>
        .cms-back-to-top {
            position: fixed;
            left: 24px;
            bottom: calc(24px + env(safe-area-inset-bottom, 0px));
            z-index: 9998;
            width: 46px;
            height: 46px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #111827;
            background: #f2b705;
            border: 1px solid rgba(255, 255, 255, .5);
            border-radius: 50%;
            box-shadow: 0 14px 34px rgba(0, 0, 0, .28);
            opacity: 0;
            pointer-events: none;
            transform: translateY(14px);
            transition: opacity .22s ease, transform .22s ease, background .22s ease;
        }

        .cms-back-to-top.is-visible {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
        }

        .cms-back-to-top:hover,
        .cms-back-to-top:focus {
            color: #111827;
            background: #ffd84a;
            text-decoration: none;
            outline: none;
        }

        .cms-back-to-top svg {
            width: 20px;
            height: 20px;
            display: block;
        }

        @media (max-width: 640px) {
            .cms-back-to-top {
                left: 16px;
                bottom: calc(84px + env(safe-area-inset-bottom, 0px));
                width: 42px;
                height: 42px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const button = document.querySelector('[data-cms-back-to-top]');
            if (!button) return;

            function syncBackToTop() {
                button.classList.toggle('is-visible', window.scrollY > 420);
            }

            button.addEventListener('click', function (event) {
                event.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            syncBackToTop();
            window.addEventListener('scroll', syncBackToTop, { passive: true });
        });
    </script>
@endonce

<a href="#top" class="cms-back-to-top" data-cms-back-to-top aria-label="Retour en haut" title="Retour en haut">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M12 19V5"></path>
        <path d="M5 12l7-7 7 7"></path>
    </svg>
</a>
