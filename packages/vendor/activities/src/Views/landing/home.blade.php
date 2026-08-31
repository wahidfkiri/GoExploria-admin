{{-- ═══════════════════════════════════════════════════════════════════════
     Landing « Espace Activités » — /activity

     Quatre sections : hero (Swiper), carte interactive, filtres, grille.

     La carte n'est pas réécrite : `geo-map::index` porte déjà les marqueurs
     dynamiques, l'interaction liste ↔ marqueur et l'onglet « Activité ». On
     l'inclut tel quel, sans contexte de destination (il se replie sur null et
     charge tous les lieux).

     Les activités n'ayant pas de coordonnées propres, ce sont les
     établissements qui les proposent qui les situent : d'où le compteur de
     lieux sur chaque carte et le renvoi vers la carte.
     ═══════════════════════════════════════════════════════════════════════ --}}
@php
    $titreSeo = "Espace Activités — Découvrez les activités à vivre";
    $descSeo  = "Randonnée, kayak, ski, gastronomie, culture… Explorez les activités disponibles et les lieux où les pratiquer.";
    $imgDefaut = 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=1600&q=80';

    $urlImage = static function (?string $chemin) use ($imgDefaut) {
        $chemin = trim((string) $chemin);
        if ($chemin === '') { return $imgDefaut; }
        return \Illuminate\Support\Str::startsWith($chemin, ['http://', 'https://', '//'])
            ? $chemin
            : asset('storage/' . ltrim($chemin, '/'));
    };
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $titreSeo }}</title>
    <meta name="description" content="{{ $descSeo }}">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph : la première activité illustrée sert de vignette. --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $titreSeo }}">
    <meta property="og:description" content="{{ $descSeo }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $urlImage(optional($heroSlides->first())->image) }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <style>
        :root {
            --ea-fond:      #ffffff;
            --ea-fond-doux: #f6f8fb;
            --ea-encre:     #0f172a;
            --ea-gris:      #64748b;
            --ea-bord:      #e5e9f0;
            --ea-accent:    #0f766e;
            --ea-accent-vif:#0d9488;
            --ea-rayon:     18px;
            --ea-ombre:     0 4px 16px rgba(15, 23, 42, .06);
            --ea-ombre-fort:0 18px 40px rgba(15, 23, 42, .14);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--ea-fond);
            color: var(--ea-encre);
            line-height: 1.6;
            /* Aucun débordement horizontal, quelle que soit la largeur. */
            overflow-x: hidden;
        }

        img { max-width: 100%; display: block; }

        .ea-shell { max-width: 1320px; margin: 0 auto; padding: 0 clamp(16px, 3vw, 32px); }

        h1, h2, h3 { font-family: 'Montserrat', sans-serif; line-height: 1.2; }

        /* ── Hero ─────────────────────────────────────────────────────── */
        .ea-hero { position: relative; height: clamp(460px, 78vh, 760px); background: #0f172a; }
        .ea-hero .swiper { width: 100%; height: 100%; }
        .ea-hero-slide { position: relative; width: 100%; height: 100%; overflow: hidden; }
        .ea-hero-slide img,
        .ea-hero-slide video {
            width: 100%; height: 100%; object-fit: cover;
            /* Zoom lent : donne de la vie sans distraire. */
            animation: ea-zoom 14s ease-out forwards;
        }
        @keyframes ea-zoom { from { transform: scale(1.06); } to { transform: scale(1); } }
        @media (prefers-reduced-motion: reduce) {
            .ea-hero-slide img, .ea-hero-slide video { animation: none; }
        }
        .ea-hero-voile {
            position: absolute; inset: 0;
            background: linear-gradient(180deg, rgba(15,23,42,.30) 0%, rgba(15,23,42,.52) 55%, rgba(15,23,42,.80) 100%);
        }
        .ea-hero-texte {
            position: absolute; inset: 0; display: flex; flex-direction: column;
            align-items: center; justify-content: center; text-align: center;
            padding: 0 clamp(16px, 5vw, 64px); color: #fff; z-index: 2;
        }
        .ea-hero-etiquette {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,.14); border: 1px solid rgba(255,255,255,.28);
            backdrop-filter: blur(4px); border-radius: 999px;
            padding: 6px 16px; font-size: .78rem; font-weight: 700;
            letter-spacing: .08em; text-transform: uppercase; margin-bottom: 20px;
        }
        .ea-hero-texte h1 { font-size: clamp(2rem, 5.2vw, 3.9rem); font-weight: 800; max-width: 18ch; }
        .ea-hero-texte p {
            margin-top: 16px; font-size: clamp(1rem, 1.6vw, 1.22rem);
            max-width: 60ch; color: rgba(255,255,255,.88);
        }
        .ea-hero-actions { display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; margin-top: 30px; }
        .ea-btn {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 13px 28px; border-radius: 999px; border: 0; cursor: pointer;
            font-family: inherit; font-size: .96rem; font-weight: 700;
            text-decoration: none; transition: transform .2s, box-shadow .2s, background .2s;
        }
        .ea-btn-plein { background: var(--ea-accent); color: #fff; }
        .ea-btn-plein:hover { background: var(--ea-accent-vif); transform: translateY(-2px); box-shadow: var(--ea-ombre-fort); }
        .ea-btn-clair { background: rgba(255,255,255,.16); color: #fff; border: 1px solid rgba(255,255,255,.4); }
        .ea-btn-clair:hover { background: rgba(255,255,255,.26); transform: translateY(-2px); }
        .ea-hero .swiper-pagination-bullet { background: #fff; opacity: .45; width: 9px; height: 9px; }
        .ea-hero .swiper-pagination-bullet-active { opacity: 1; width: 28px; border-radius: 999px; }
        .ea-hero .swiper-button-prev, .ea-hero .swiper-button-next {
            width: 46px; height: 46px; border-radius: 50%; color: #fff;
            background: rgba(15,23,42,.42); border: 1px solid rgba(255,255,255,.3);
            transition: background .2s;
        }
        .ea-hero .swiper-button-prev:hover, .ea-hero .swiper-button-next:hover { background: rgba(15,23,42,.7); }
        .ea-hero .swiper-button-prev::after, .ea-hero .swiper-button-next::after { font-size: 15px; font-weight: 700; }
        @media (max-width: 640px) {
            .ea-hero .swiper-button-prev, .ea-hero .swiper-button-next { display: none; }
        }

        /* Hero sans média : dégradé sobre plutôt qu'un cadre vide. */
        .ea-hero--nu { background: linear-gradient(135deg, #0f766e, #0f172a); }

        /* ── Sections ─────────────────────────────────────────────────── */
        .ea-section { padding: clamp(48px, 7vw, 88px) 0; }
        .ea-section--doux { background: var(--ea-fond-doux); }
        .ea-entete { max-width: 62ch; margin-bottom: 34px; }
        .ea-surtitre {
            font-size: .76rem; font-weight: 800; letter-spacing: .12em;
            text-transform: uppercase; color: var(--ea-accent); margin-bottom: 10px;
        }
        .ea-entete h2 { font-size: clamp(1.55rem, 3.1vw, 2.3rem); font-weight: 800; }
        .ea-entete p { color: var(--ea-gris); margin-top: 12px; font-size: 1.02rem; }

        /* ── Filtres ──────────────────────────────────────────────────── */
        .ea-barre-filtres {
            display: flex; flex-wrap: wrap; gap: 14px; align-items: center;
            justify-content: space-between; margin-bottom: 28px;
        }
        .ea-puces { display: flex; flex-wrap: wrap; gap: 9px; }
        .ea-puce {
            border: 1px solid var(--ea-bord); background: #fff; color: var(--ea-encre);
            border-radius: 999px; padding: 9px 18px; font-size: .88rem; font-weight: 600;
            cursor: pointer; font-family: inherit; transition: all .18s;
        }
        .ea-puce:hover { border-color: var(--ea-accent); color: var(--ea-accent); }
        .ea-puce[aria-pressed="true"] { background: var(--ea-accent); border-color: var(--ea-accent); color: #fff; }
        .ea-recherche { position: relative; min-width: 260px; flex: 1 1 260px; max-width: 380px; }
        .ea-recherche i {
            position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
            color: var(--ea-gris); font-size: .9rem; pointer-events: none;
        }
        .ea-recherche input {
            width: 100%; padding: 12px 16px 12px 42px; border-radius: 999px;
            border: 1px solid var(--ea-bord); background: #fff; font-family: inherit;
            font-size: .93rem; color: var(--ea-encre); transition: border-color .2s, box-shadow .2s;
        }
        .ea-recherche input:focus {
            outline: none; border-color: var(--ea-accent);
            box-shadow: 0 0 0 3px rgba(15,118,110,.14);
        }

        /* ── Grille ───────────────────────────────────────────────────── */
        /* 4 colonnes en desktop, 2 en tablette, 1 en mobile. */
        .ea-grille { display: grid; grid-template-columns: repeat(4, 1fr); gap: 22px; }
        @media (max-width: 1100px) { .ea-grille { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 640px)  { .ea-grille { grid-template-columns: 1fr; } }

        .ea-carte {
            background: #fff; border: 1px solid var(--ea-bord); border-radius: var(--ea-rayon);
            overflow: hidden; display: flex; flex-direction: column;
            box-shadow: var(--ea-ombre); transition: transform .22s, box-shadow .22s, border-color .22s;
        }
        .ea-carte:hover { transform: translateY(-5px); box-shadow: var(--ea-ombre-fort); border-color: #cbd5e1; }
        .ea-carte.is-hidden { display: none; }
        .ea-carte-media { position: relative; aspect-ratio: 4 / 3; background: #eef2f7; overflow: hidden; }
        .ea-carte-media img { width: 100%; height: 100%; object-fit: cover; transition: transform .45s ease; }
        .ea-carte:hover .ea-carte-media img { transform: scale(1.06); }
        .ea-carte-cat {
            position: absolute; top: 12px; left: 12px; z-index: 2;
            background: rgba(255,255,255,.94); color: var(--ea-encre);
            border-radius: 999px; padding: 5px 13px;
            font-size: .7rem; font-weight: 800; letter-spacing: .05em; text-transform: uppercase;
        }
        .ea-carte-corps { padding: 18px 18px 20px; display: flex; flex-direction: column; flex: 1; }
        .ea-carte-corps h3 { font-size: 1.06rem; font-weight: 700; margin-bottom: 8px; }
        .ea-carte-desc {
            color: var(--ea-gris); font-size: .9rem; margin-bottom: 14px;
            display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
        }
        .ea-carte-lieux {
            display: inline-flex; align-items: center; gap: 7px;
            color: var(--ea-gris); font-size: .84rem; margin-bottom: 16px;
        }
        .ea-carte-lieux i { color: var(--ea-accent); }
        .ea-carte-pied { margin-top: auto; display: flex; gap: 10px; align-items: center; }
        .ea-lien {
            display: inline-flex; align-items: center; gap: 8px;
            color: var(--ea-accent); font-weight: 700; font-size: .9rem;
            text-decoration: none; transition: gap .2s;
        }
        .ea-lien:hover { gap: 13px; }
        .ea-voir-carte {
            margin-left: auto; border: 1px solid var(--ea-bord); background: #fff;
            width: 36px; height: 36px; border-radius: 50%; cursor: pointer;
            color: var(--ea-gris); transition: all .2s;
        }
        .ea-voir-carte:hover { border-color: var(--ea-accent); color: var(--ea-accent); background: #f0fdfa; }

        /* ── États ────────────────────────────────────────────────────── */
        .ea-vide {
            grid-column: 1 / -1; text-align: center; padding: 64px 20px;
            border: 1px dashed var(--ea-bord); border-radius: var(--ea-rayon); background: #fff;
        }
        .ea-vide i { font-size: 2.6rem; color: #cbd5e1; margin-bottom: 14px; }
        .ea-vide h3 { font-size: 1.2rem; margin-bottom: 6px; }
        .ea-vide p { color: var(--ea-gris); }

        /* ── Appel final ──────────────────────────────────────────────── */
        .ea-cta {
            background: linear-gradient(135deg, var(--ea-accent), #0f172a);
            color: #fff; border-radius: 24px; padding: clamp(34px, 5vw, 60px);
            text-align: center; margin: 0 0 clamp(48px, 7vw, 88px);
        }
        .ea-cta h2 { font-size: clamp(1.5rem, 3vw, 2.15rem); font-weight: 800; }
        .ea-cta p { color: rgba(255,255,255,.86); margin: 12px auto 26px; max-width: 58ch; }
        .ea-cta .ea-btn-plein { background: #fff; color: var(--ea-accent); }
        .ea-cta .ea-btn-plein:hover { background: #ecfdf5; }
    </style>
</head>
<body>

{{-- ═══ 1. HERO ════════════════════════════════════════════════════════ --}}
<header class="ea-hero {{ $heroSlides->isEmpty() ? 'ea-hero--nu' : '' }}">
    @if($heroSlides->isNotEmpty())
        <div class="swiper" id="eaHeroSwiper">
            <div class="swiper-wrapper">
                @foreach($heroSlides as $slide)
                    <div class="swiper-slide">
                        <div class="ea-hero-slide">
                            {{-- Le premier visuel est chargé sans délai, les suivants
                                 paresseusement : c'est lui que le visiteur voit. --}}
                            <img src="{{ $urlImage($slide->image) }}"
                                 alt="{{ $slide->name }}"
                                 loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                                 fetchpriority="{{ $loop->first ? 'high' : 'low' }}">
                            <div class="ea-hero-voile"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
            <button class="swiper-button-prev" type="button" aria-label="Visuel précédent"></button>
            <button class="swiper-button-next" type="button" aria-label="Visuel suivant"></button>
        </div>
    @endif

    <div class="ea-hero-texte">
        <span class="ea-hero-etiquette"><i class="fas fa-compass"></i> Espace Activités</span>
        <h1>Découvrez les meilleures activités à vivre</h1>
        <p>Randonnée, kayak, ski, gastronomie, culture… Explorez ce qui vous attend et les lieux où en profiter.</p>
        <div class="ea-hero-actions">
            <a href="#ea-activites" class="ea-btn ea-btn-plein">
                Découvrir les activités <i class="fas fa-arrow-right"></i>
            </a>
            <a href="#ea-carte" class="ea-btn ea-btn-clair">
                <i class="fas fa-map-location-dot"></i> Voir sur la carte
            </a>
        </div>
    </div>
</header>

{{-- ═══ 2. CARTE ═══════════════════════════════════════════════════════ --}}
<section class="ea-section" id="ea-carte">
    <div class="ea-shell">
        <div class="ea-entete">
            <div class="ea-surtitre">Où en profiter</div>
            <h2>Les lieux sur la carte</h2>
            <p>
                Une activité se pratique dans un lieu : la carte affiche les établissements
                qui les proposent. Utilisez l'onglet « Activité » pour ne garder qu'eux,
                et cliquez un marqueur pour en savoir plus.
            </p>
        </div>
    </div>

    {{-- Carte réutilisée telle quelle : marqueurs, interaction liste ↔ marqueur
         et onglets d'espace y sont déjà implémentés. --}}
    @include('geo-map::index')
</section>

{{-- ═══ 3. FILTRES + 4. GRILLE ═════════════════════════════════════════ --}}
<section class="ea-section ea-section--doux" id="ea-activites">
    <div class="ea-shell">
        <div class="ea-entete">
            <div class="ea-surtitre">Toutes les activités</div>
            <h2>Trouvez votre prochaine sortie</h2>
            <p>Filtrez par catégorie ou cherchez directement ce qui vous intéresse.</p>
        </div>

        @if($activities->isNotEmpty())
            <div class="ea-barre-filtres">
                <div class="ea-puces" id="eaFiltres" role="group" aria-label="Filtrer par catégorie">
                    <button type="button" class="ea-puce" data-categorie="all" aria-pressed="true">
                        Toutes <span aria-hidden="true">({{ $activities->count() }})</span>
                    </button>
                    @foreach($categories as $categorie)
                        <button type="button" class="ea-puce" data-categorie="{{ $categorie->id }}" aria-pressed="false">
                            {{ $categorie->name }}
                        </button>
                    @endforeach
                </div>

                <div class="ea-recherche">
                    <i class="fas fa-magnifying-glass"></i>
                    <label class="visually-hidden" for="eaRecherche" style="position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0)">
                        Rechercher une activité
                    </label>
                    <input type="search" id="eaRecherche" placeholder="Rechercher une activité…" autocomplete="off">
                </div>
            </div>
        @endif

        <div class="ea-grille" id="eaGrille">
            @forelse($activities as $activity)
                <article class="ea-carte"
                         data-categorie="{{ $activity->categorie_id }}"
                         data-nom="{{ \Illuminate\Support\Str::lower($activity->name . ' ' . ($activity->categoryRelation->name ?? '')) }}">
                    <div class="ea-carte-media">
                        @if($activity->categoryRelation)
                            <span class="ea-carte-cat">{{ $activity->categoryRelation->name }}</span>
                        @endif
                        <img src="{{ $urlImage($activity->image) }}" alt="{{ $activity->name }}" loading="lazy">
                    </div>
                    <div class="ea-carte-corps">
                        <h3>{{ $activity->name }}</h3>
                        <p class="ea-carte-desc">
                            {{ \Illuminate\Support\Str::limit(strip_tags((string) $activity->description) ?: 'Découvrez cette activité.', 110) }}
                        </p>

                        @if($activity->active_etablissements_count > 0)
                            <span class="ea-carte-lieux">
                                <i class="fas fa-location-dot"></i>
                                {{ $activity->active_etablissements_count }}
                                {{ \Illuminate\Support\Str::plural('lieu', $activity->active_etablissements_count) }}
                                où la pratiquer
                            </span>
                        @endif

                        <div class="ea-carte-pied">
                            <a class="ea-lien" href="{{ route('landing.activity.show', $activity->slug) }}">
                                Découvrir <i class="fas fa-arrow-right"></i>
                            </a>
                            <button type="button" class="ea-voir-carte" data-vers-carte
                                    title="Voir les lieux sur la carte" aria-label="Voir les lieux sur la carte">
                                <i class="fas fa-map-location-dot"></i>
                            </button>
                        </div>
                    </div>
                </article>
            @empty
                <div class="ea-vide">
                    <i class="fas fa-mountain-sun"></i>
                    <h3>Aucune activité disponible pour le moment.</h3>
                    <p>Revenez bientôt : de nouvelles activités sont ajoutées régulièrement.</p>
                </div>
            @endforelse

            {{-- Affiché par le filtre quand aucune activité ne correspond. --}}
            <div class="ea-vide" id="eaAucunResultat" style="display:none">
                <i class="fas fa-magnifying-glass"></i>
                <h3>Aucune activité ne correspond</h3>
                <p>Essayez une autre catégorie ou un autre mot-clé.</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══ 5. APPEL FINAL ═════════════════════════════════════════════════ --}}
<div class="ea-shell">
    <section class="ea-cta">
        <h2>Une envie précise&nbsp;?</h2>
        <p>Parcourez la carte pour repérer les lieux autour de vous, ou explorez les activités par catégorie.</p>
        <a href="#ea-carte" class="ea-btn ea-btn-plein"><i class="fas fa-map-location-dot"></i> Ouvrir la carte</a>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
(function () {
    'use strict';

    /* ── Hero ──────────────────────────────────────────────────────────
       Le diaporama n'existe que s'il y a des visuels ; sans lui, le hero
       garde son dégradé et son texte. */
    var hero = document.getElementById('eaHeroSwiper');
    if (hero && typeof Swiper !== 'undefined') {
        var nb = hero.querySelectorAll('.swiper-slide').length;
        new Swiper(hero, {
            loop: nb > 1,
            speed: 900,
            effect: 'fade',
            fadeEffect: { crossFade: true },
            autoplay: nb > 1 ? { delay: 6000, disableOnInteraction: false } : false,
            pagination: { el: hero.querySelector('.swiper-pagination'), clickable: true },
            navigation: {
                prevEl: hero.querySelector('.swiper-button-prev'),
                nextEl: hero.querySelector('.swiper-button-next')
            },
            a11y: { enabled: true }
        });
    }

    /* ── Filtres et recherche ──────────────────────────────────────────
       Filtrage côté client : les activités sont déjà toutes rendues, un
       aller-retour serveur n'apporterait rien et coûterait une latence. */
    var grille = document.getElementById('eaGrille');
    if (!grille) { return; }

    var cartes = Array.prototype.slice.call(grille.querySelectorAll('.ea-carte'));
    var puces = Array.prototype.slice.call(document.querySelectorAll('.ea-puce'));
    var recherche = document.getElementById('eaRecherche');
    var aucun = document.getElementById('eaAucunResultat');
    var categorieActive = 'all';

    function appliquer() {
        var q = recherche ? recherche.value.trim().toLowerCase() : '';
        var visibles = 0;

        cartes.forEach(function (carte) {
            var okCat = categorieActive === 'all'
                || carte.getAttribute('data-categorie') === categorieActive;
            var okTexte = !q || (carte.getAttribute('data-nom') || '').indexOf(q) !== -1;
            var garde = okCat && okTexte;

            carte.classList.toggle('is-hidden', !garde);
            if (garde) { visibles++; }
        });

        if (aucun) { aucun.style.display = visibles === 0 ? '' : 'none'; }
    }

    puces.forEach(function (puce) {
        puce.addEventListener('click', function () {
            categorieActive = puce.getAttribute('data-categorie');
            puces.forEach(function (p) { p.setAttribute('aria-pressed', String(p === puce)); });
            appliquer();
        });
    });

    if (recherche) {
        // Léger différé : évite de refiltrer à chaque frappe.
        var minuteur = null;
        recherche.addEventListener('input', function () {
            clearTimeout(minuteur);
            minuteur = setTimeout(appliquer, 150);
        });
    }

    /* ── Renvoi vers la carte ──────────────────────────────────────────
       On ne pilote pas l'intérieur de geo-map : on remonte à la carte et
       on active son onglet « Activité », qui fait déjà le reste. */
    document.querySelectorAll('[data-vers-carte]').forEach(function (bouton) {
        bouton.addEventListener('click', function () {
            var section = document.getElementById('ea-carte');
            if (section) { section.scrollIntoView({ behavior: 'smooth', block: 'start' }); }

            var onglet = document.querySelector('.resto-tab-btn[data-espace="activite"]');
            if (onglet) { setTimeout(function () { onglet.click(); }, 450); }
        });
    });
})();
</script>
</body>
</html>
