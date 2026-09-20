{{-- ══════════════════════════════════════════════════════════════════════
     EN-TÊTE DE LA PLATEFORME — celui de la page d'accueil (`/`), prêt à être
     posé sur une page qui n'appartient pas au gabarit de l'accueil.

     Rend les composants CANONIQUES (VerticalMenu + Header du package welcome)
     pour garder exactement le même design et le même comportement que `/` :
     mega-menus, menu vertical, sélecteur de langue, recherche, panier.

     Pourquoi ce fichier plutôt qu'un @include direct des deux composants :
     ceux-ci ne portent pas leurs feuilles de style ni leurs scripts. Sur la
     page d'accueil, tout arrive par `welcome.bundle.css` et la liste de
     `<script>` de welcome-home/index. Ailleurs, il faut les apporter — et
     surtout PAS le bundle entier, qui embarque le hero et les 40 sections de
     l'accueil.

     Les feuilles listées ici sont celles du header et de ses menus,
     strictement — même sélection que le shell d'intégration des sites
     d'établissement (cms::web.embed.platform-shell), qui résout le même
     problème pour l'iframe.

     ⚠ `styles.css` porte une règle universelle `*{margin:0;padding:0}`. Sa
     spécificité (0,0,0) est plus faible que celle de n'importe quel sélecteur
     de type : mesuré sur les deux pages d'activité, l'ajout de ces feuilles
     ne déplace aucun élément existant. Ne pas la retirer pour autant : le
     header en dépend.

     L'en-tête est `position: fixed` et transparent en haut de page (il prend
     un fond de verre au défilement, via la classe `hdr-scrolled` posée par
     son propre script). Il se superpose donc au visuel d'ouverture de la page
     hôte, comme sur l'accueil : la page ne doit PAS réserver d'espace.
     ══════════════════════════════════════════════════════════════════════ --}}
@php
    // Cache-busting sur la date des fichiers, comme partout ailleurs.
    $gxAsset = static function (string $chemin): string {
        return asset($chemin) . '?v=' . (@filemtime(public_path($chemin)) ?: '1');
    };

    $gxHeaderStyles = [
        'css/welcome/styles.css',
        'css/welcome/navigation.css',
        'css/welcome/vertical-menu.css',
        'css/welcome/vertical-menu-videos.css',
        'css/welcome/vertical-destinations-mega.css',
        'css/welcome/mega-menu.css',
        'css/welcome/categories-mega-menu.css',
        'css/welcome/destinations-mega-menu-modern.css',
        'css/welcome/destinations-search.css',
        'css/welcome/search-bar.css',
        'css/welcome/videos-dropdown.css',
        'css/welcome/services-mega-menu-v2.css',
        // En dernier : c'est lui qui rend l'en-tête transparent en haut de
        // page et lui donne son verre sombre au défilement, comme sur `/`.
        // Ses autres règles sont préfixées `.go-home-hero` / `.go-hero-*`,
        // des classes propres au visuel d'ouverture de l'accueil : elles ne
        // peuvent rien atteindre sur une page hôte.
        //
        // Son voisin `welcome-responsive.css` est volontairement ÉCARTÉ : il
        // porte des règles génériques (`.container`, `.row`, `body`,
        // `img, video`) qui déborderaient sur la page hôte — `.container` est
        // celui de Bootstrap dans les gabarits.
        'css/welcome/welcome-premium.css',
    ];

    // Ordre significatif : menu-api-service alimente mega-menu-service, dont
    // dépendent les menus. C'est celui de la page d'accueil.
    $gxHeaderScripts = [
        'js/welcome/navigation.js',
        'js/welcome/menu-api-service.js',
        'js/welcome/mega-menu-service.js',
        'js/welcome/vertical-menu-dynamic.js',
        'js/welcome/vertical-menu.js',
        'js/welcome/vertical-destinations-mega.js',
        'js/welcome/mega-menu.js',
        'js/welcome/destinations-mega-menu.js',
        'js/welcome/destinations-search.js',
        'js/welcome/search-bar.js',
        'js/welcome/videos-dropdown.js',
    ];
@endphp

{{-- Police et icônes du header. Les pages hôtes chargent souvent déjà Font
     Awesome ; un second <link> vers la même URL ne coûte rien (cache). --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@foreach($gxHeaderStyles as $gxStyle)
    <link rel="stylesheet" href="{{ $gxAsset($gxStyle) }}">
@endforeach

{{-- ── PALETTE ISOLÉE ────────────────────────────────────────────────────
     Les feuilles du header lisent leurs couleurs dans des variables CSS
     déclarées sur `:root`. Une page hôte qui déclare les MÊMES noms les
     détourne : le gabarit Plexify pose `:root{--white: var(--title)}`, où
     `--title` vaut #111111. Résultat mesuré sur la page d'une activité :
     les liens du header, écrits `color: var(--white)`, sortaient en noir sur
     fond marine — illisibles.

     Redéclarer la palette SUR les racines du header règle le conflit à la
     source : une variable se résout en remontant l'arbre, la déclaration la
     plus proche gagne, quoi que fasse le `:root` de la page.

     Les valeurs sont celles de css/welcome/styles.css et vertical-menu.css :
     toute modification là-bas doit être reportée ici. --}}
<style>
    .gx-platform-header,
    .gx-platform-header .header-v2,
    .gx-platform-header .vertical-menu-v2,
    .gx-platform-header .vertical-menu-v2-overlay,
    .mega-menu-v2-overlay-mobile {
        --white: #ffffff;
        --navy-dark: #0a1628;
        --navy-primary: #1a2942;
        --navy-medium: #2a3f5f;
        --navy-light: #3d5a80;
        --accent-gold: #d4af37;
        --accent-yellow: #ffd700;
        --gray-light: #f8f9fa;
        --gray-medium: #e9ecef;
        --overlay-dark: rgba(10, 22, 40, 0.7);
        --overlay-medium: rgba(10, 22, 40, 0.5);

        --bosse-border: #e0e0e0;
        --bosse-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        --bosse-bg: #ffffff;
        --bosse-accent: #d32f2f;
        --bosse-radius: 16px;

        --vm-bg: #ffffff;
        --vm-bg-alt: #f8f9fa;
        --vm-border: #e9ecef;
        --vm-dark: #1a2942;
        --vm-gold: #d4af37;
        --vm-gold-border: rgba(212, 175, 55, 0.3);
        --vm-gold-light: rgba(212, 175, 55, 0.1);
        --vm-muted: #6c757d;
        --vm-radius: 8px;
        --vm-text: #000000;
        --vm-transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ── FOND NOIR ─────────────────────────────────────────────────────
       La barre reste noire, au repos comme au défilement.

       Les sélecteurs reprennent MOT POUR MOT ceux de welcome-premium.css
       (transparence en haut de page, verre sombre au défilement) : à
       spécificité égale, c'est la déclaration la plus tardive qui gagne, et
       ce bloc est écrit après les <link>. Les recopier est donc volontaire —
       une version raccourcie perdrait l'arbitrage. */
    .header-v2,
    .header-v2 .header-nav,
    .header-v2 .header-top,
    body:not(.hdr-scrolled):not(.hdr-search-open) .header-v2,
    body:not(.hdr-scrolled):not(.hdr-search-open) .header-v2 .header-nav,
    body:not(.hdr-scrolled):not(.hdr-search-open) .header-v2 .header-top,
    body:not(.hdr-scrolled):not(.hdr-search-open) .header-v2.scrolled,
    body:not(.hdr-scrolled):not(.hdr-search-open) .header-v2.scrolled .header-nav,
    body.hdr-scrolled .header-v2,
    body.hdr-scrolled .header-v2 .header-nav,
    body.hdr-scrolled .header-v2.scrolled .header-nav,
    body.hdr-search-open .header-v2,
    body.hdr-search-open .header-v2 .header-nav {
        background: #000000 !important;
        background-color: #000000 !important;
        -webkit-backdrop-filter: none !important;
        backdrop-filter: none !important;
    }

    /* Liens et icônes : blanc franc. Le bleuté d'origine (#eaf0fb) était
       calculé pour se poser sur une photo, pas sur du noir plein.

       « Next Level » est écarté : c'est une pastille dorée à texte sombre,
       lisible telle quelle — la repeindre en blanc la rendrait illisible. */
    .gx-platform-header .header-v2 .nav-menu > li > a:not(.nav-nextlevel-link),
    .gx-platform-header .header-v2 .nav-icon,
    .gx-platform-header .header-v2 .hdr-search-toggle,
    .gx-platform-header .header-v2 .lang-btn {
        color: #ffffff !important;
    }

    .gx-platform-header .header-v2 .nav-menu > li > a:not(.nav-nextlevel-link):hover {
        color: var(--accent-gold) !important;
    }

    /* « Next Level » : sa pastille dorée est prévue pour un texte sombre, mais
       welcome-premium.css repeint TOUS les liens du menu avec un sélecteur
       plus spécifique — le texte y ressortait bleu clair sur or. On lui rend
       la couleur voulue par le composant. */
    .gx-platform-header .header-v2 .nav-menu > li > a.nav-nextlevel-link,
    .gx-platform-header .header-v2 .nav-menu > li > a.nav-nextlevel-link:hover {
        color: #0a1628 !important;
    }

    .gx-platform-header .header-v2 .menu-toggle span {
        background: #ffffff !important;
    }

    /* ── IMMUNITÉ CONTRE LE GABARIT HÔTE ───────────────────────────────
       `.header-nav` n'est pas un nom réservé : les gabarits Plexify s'en
       servent pour LEUR tiroir de menu mobile, et le déclarent ainsi sous
       991 px —

           .header-nav { position: fixed; top: 0; width: 60px;
                         height: 100vh !important; background: #fff; }

       Cette règle attrapait aussi le `<nav class="header-nav">` du header de
       la plateforme : mesuré à 375 px, la barre devenait une colonne noire de
       60 px de large sur toute la hauteur de l'écran, à gauche du contenu.

       On lui rend donc son comportement de barre. Le tiroir du gabarit, lui,
       n'est pas touché : le sélecteur est ancré sur `.gx-platform-header`. */
    @media (max-width: 991px) {
        .gx-platform-header .header-v2 .header-nav {
            position: relative !important;
            top: auto !important;
            width: auto !important;
            height: auto !important;
            overflow: visible !important;
            z-index: auto !important;
            transition: none !important;
        }
    }
</style>

{{-- Le conteneur ne sert QU'à porter la palette : pas de transform ni de
     filtre, qui feraient de lui le bloc conteneur des éléments `fixed` du
     header et le décrocheraient de la fenêtre. --}}
<div class="gx-platform-header">
    @include('welcome-home.components.VerticalMenu')
    @include('welcome-home.components.Header')
</div>

{{-- Barre de raccourcis (droite) : langue, recherche, favoris, activités,
     destinations, panier, carte. Hors du conteneur de palette : ses panneaux
     sont `fixed` et elle porte ses propres couleurs. --}}
@include('welcome-home.partials.side-rail')

@foreach($gxHeaderScripts as $gxScript)
    <script defer src="{{ $gxAsset($gxScript) }}"></script>
@endforeach
