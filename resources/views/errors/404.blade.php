{{-- ═══════════════════════════════════════════════════════════════════════
     PAGE 404 — GoExploria Business.

     Remplace la page d'erreur par défaut de Laravel (« Not Found », en
     anglais, sans identité). Laravel prend automatiquement cette vue dès
     qu'elle existe : rien à déclarer ailleurs.

     Volontairement AUTONOME : aucune mise en page héritée, aucun asset
     compilé, tous les styles en ligne. Une page d'erreur doit s'afficher même
     quand ce qui l'entoure est cassé — un `@extends` sur un gabarit qui
     interroge la base transformerait une 404 en 500.

     Les deux seules dépendances externes sont les blocs publicitaires, et
     elles sont sûres : `components/ads-cards` et `components/ads-popup`
     enveloppent leurs requêtes dans un `try/catch` qui retombe sur une
     collection vide, et ne rendent rien s'il n'y a pas d'annonce.

     L'objet `$exception` fourni par Laravel n'est PAS affiché : il porte le
     chemin demandé et la trace, qui n'ont rien à faire sous les yeux d'un
     visiteur.
     ═══════════════════════════════════════════════════════════════════════ --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, follow">

    <title>Page introuvable — GoExploria Business</title>
    <meta name="description" content="La page demandée n'existe pas ou a été déplacée.">

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" href="{{ asset('favicon-32x32.png') }}" type="image/png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    {{-- Font Awesome : les flèches du carrousel d'annonces sont des <i class="fas …">. --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Palette de la plateforme (css/welcome/styles.css), recopiée ici :
           la page ne charge aucune feuille du site, par principe. */
        :root {
            --navy-dark: #0a1628;
            --navy-primary: #1a2942;
            --accent-gold: #d4af37;
            --accent-yellow: #ffd700;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f5f7fa;
            color: #0f172a;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Bandeau principal ─────────────────────────────────────────── */
        .gx404 {
            position: relative;
            overflow: hidden;
            padding: clamp(48px, 9vh, 96px) clamp(20px, 5vw, 48px) clamp(56px, 10vh, 104px);
            background: var(--navy-dark);
            color: #fff;
            text-align: center;
        }

        /* Deux halos très doux : de la profondeur sans image à charger. */
        .gx404::before,
        .gx404::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }
        .gx404::before {
            width: 620px; height: 620px;
            top: -320px; left: -180px;
            background: radial-gradient(circle, rgba(212, 175, 55, .16), transparent 68%);
        }
        .gx404::after {
            width: 560px; height: 560px;
            right: -220px; bottom: -300px;
            background: radial-gradient(circle, rgba(61, 90, 128, .38), transparent 68%);
        }

        .gx404__inner {
            position: relative;
            z-index: 1;
            max-width: 720px;
            margin: 0 auto;
        }

        .gx404__logo {
            display: inline-block;
            width: clamp(170px, 26vw, 230px);
            height: auto;
            margin-bottom: clamp(28px, 5vh, 48px);
        }

        /* Le nombre : gros, mais en retrait — c'est le message qui compte. */
        .gx404__code {
            font-size: clamp(92px, 20vw, 168px);
            font-weight: 900;
            line-height: .9;
            letter-spacing: -.04em;
            background: linear-gradient(135deg, var(--accent-yellow), var(--accent-gold) 55%, #a8842a);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 18px;
        }

        .gx404__title {
            font-size: clamp(21px, 3.4vw, 30px);
            font-weight: 800;
            line-height: 1.25;
            margin-bottom: 14px;
        }

        .gx404__text {
            font-size: clamp(14px, 1.8vw, 16px);
            line-height: 1.75;
            color: rgba(255, 255, 255, .72);
            max-width: 32em;
            margin: 0 auto clamp(28px, 5vh, 40px);
        }

        .gx404__actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            justify-content: center;
        }

        .gx404__btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 30px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease, color .2s ease;
        }
        .gx404__btn i { font-size: 13px; }

        .gx404__btn--or {
            background: linear-gradient(135deg, var(--accent-yellow), var(--accent-gold));
            color: var(--navy-dark);
            box-shadow: 0 10px 26px rgba(212, 175, 55, .3);
        }
        .gx404__btn--or:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 32px rgba(212, 175, 55, .42);
        }

        .gx404__btn--ligne {
            border: 1.5px solid rgba(255, 255, 255, .34);
            color: #fff;
        }
        .gx404__btn--ligne:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, .1);
            border-color: rgba(255, 255, 255, .6);
        }

        /* ── Bande claire : les annonces ───────────────────────────────────
           `components/ads-cards` est dessiné pour un fond clair (titres
           #0f172a, cartes blanches) : il lui faut sa propre bande, pas le
           bandeau marine. */
        .gx404__annonces {
            padding: clamp(36px, 6vh, 64px) 0 clamp(24px, 4vh, 48px);
            background: #f5f7fa;
        }

        @media (prefers-reduced-motion: reduce) {
            .gx404__btn { transition: none; }
            .gx404__btn:hover { transform: none; }
        }
    </style>
</head>
<body>

<main class="gx404">
    <div class="gx404__inner">
        <a href="{{ url('/') }}" aria-label="GoExploria Business — accueil">
            <img src="{{ asset('logo.png') }}" alt="GoExploria Business" class="gx404__logo">
        </a>

        <p class="gx404__code">404</p>

        <h1 class="gx404__title">Cette page n'existe pas</h1>

        <p class="gx404__text">
            Le lien est peut-être périmé, ou l'adresse comporte une faute de frappe.
            Le reste du site, lui, est toujours là : destinations, activités,
            établissements et forfaits vous attendent.
        </p>

        <div class="gx404__actions">
            <a href="{{ url('/') }}" class="gx404__btn gx404__btn--or">
                <i class="fas fa-house" aria-hidden="true"></i>
                Retour à l'accueil
            </a>

            {{-- `Route::has` plutôt qu'un `route()` direct : sur une page
                 d'erreur, une route absente lèverait une exception — et une
                 exception pendant le rendu d'une 404 donne une 500. --}}
            <a href="{{ \Illuminate\Support\Facades\Route::has('contact') ? route('contact') : url('/contact') }}"
               class="gx404__btn gx404__btn--ligne">
                <i class="fas fa-envelope" aria-hidden="true"></i>
                Nous contacter
            </a>
        </div>
    </div>
</main>

{{-- ── ANNONCES ───────────────────────────────────────────────────────────
     Les blocs de l'Ads Manager, comme sur le reste du site.

     Aucun `adContext` n'est transmis, et c'est délibéré : ce paramètre
     restreint les annonces à celles dont `display_locations` contient le
     contexte de la page. Inventer un contexte « 404 » que personne n'a
     configuré côté admin reviendrait à n'afficher que les annonces sans
     restriction — autant ne pas filtrer du tout et servir la campagne en
     cours.

     Les deux composants ne rendent rien quand aucune annonce n'est active :
     la page reste alors le bandeau seul. --}}
<div class="gx404__annonces">
    @include('components.ads-cards')
</div>

@include('components.ads-popup')

</body>
</html>
