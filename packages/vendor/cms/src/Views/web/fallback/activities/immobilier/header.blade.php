@php
    $brandName = trim((string) ($etablissement->name ?? 'GO EXPLORIA BUSINESS'));
    $devisLink = $devisUrl ?? route('devis');
@endphp

<style>
    .fb-header {
        position: sticky;
        top: 0;
        z-index: 10050;
        background: #050505;
        color: #fff;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.25);
    }

    .fb-header-wrap {
        max-width: 1600px;
        margin: 0 auto;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
    }

    .fb-brand {
        min-width: 0;
        display: grid;
        gap: 2px;
        text-decoration: none;
        color: #fff;
    }

    .fb-brand-top {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 1.3px;
        color: #f3932b;
        text-transform: uppercase;
    }

    .fb-brand-name {
        font-size: 1.16rem;
        font-weight: 900;
        letter-spacing: 0.2px;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 560px;
    }

    .fb-nav {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .fb-link {
        text-decoration: none;
        color: #e5ecf8;
        border: 1px solid rgba(255, 255, 255, 0.16);
        background: rgba(255, 255, 255, 0.03);
        padding: 8px 12px;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 800;
        transition: all 0.2s ease;
    }

    .fb-link:hover {
        color: #fff;
        border-color: #f3932b;
        background: rgba(243, 147, 43, 0.16);
    }

    .fb-cta {
        text-decoration: none;
        color: #fff;
        background: linear-gradient(135deg, #eb7b1e, #d0432f);
        border: 1px solid transparent;
        padding: 9px 14px;
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 900;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 8px 18px rgba(235, 123, 30, 0.28);
    }

    .fb-mobile-toggle {
        display: none;
        width: 40px;
        height: 40px;
        border: 1px solid rgba(255, 255, 255, 0.26);
        border-radius: 10px;
        background: transparent;
        color: #fff;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    @media (max-width: 1040px) {
        .fb-header-wrap {
            flex-wrap: wrap;
        }

        .fb-mobile-toggle {
            display: inline-flex;
            margin-left: auto;
        }

        .fb-nav {
            display: none;
            width: 100%;
            justify-content: flex-start;
            padding-top: 8px;
        }

        .fb-nav.is-open {
            display: flex;
        }

        .fb-brand-name {
            max-width: 100%;
            font-size: 1.02rem;
        }
    }
</style>

<header class="fb-header">
    <div class="fb-header-wrap">
        <a href="#section-hero" class="fb-brand">
            <span class="fb-brand-top">Go Exploria Business</span>
            <span class="fb-brand-name">{{ $brandName }}</span>
        </a>

        <button class="fb-mobile-toggle" id="fbHeaderToggle" type="button" aria-label="Menu">
            <i class="fas fa-bars"></i>
        </button>

        <nav class="fb-nav" id="fbHeaderNav" aria-label="Navigation principale">
            <a class="fb-link" href="#section-hero">Hero</a>
            <a class="fb-link" href="#section-events">Evenements</a>
            <a class="fb-link" href="#section-destinations">Destinations</a>
            <a class="fb-link" href="#section-reviews">Avis</a>
            <a class="fb-link" href="#section-gallery">Gallerie</a>
            <a class="fb-link" href="#section-contact-map">Contact</a>
            <a class="fb-link" href="#section-plans">Plans</a>
            <a class="fb-cta" href="{{ $devisLink }}" target="_blank" rel="noopener noreferrer">
                <i class="fas fa-file-signature"></i>
                Demander un devis
            </a>
        </nav>
    </div>
</header>

<script>
    (function () {
        const toggle = document.getElementById('fbHeaderToggle');
        const nav = document.getElementById('fbHeaderNav');
        if (!toggle || !nav) return;

        toggle.addEventListener('click', function () {
            nav.classList.toggle('is-open');
        });

        nav.querySelectorAll('a').forEach(function (a) {
            a.addEventListener('click', function () {
                nav.classList.remove('is-open');
            });
        });
    })();
</script>
