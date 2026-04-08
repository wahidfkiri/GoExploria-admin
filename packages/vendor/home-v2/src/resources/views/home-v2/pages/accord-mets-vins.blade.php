<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="GoExploria — Aventure Accords Mets & Vins : menus, carousel, sélection de vins, réservation">
    <title>Accord Mets & Vins — GoExploria</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/home-v2/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/menu-accord-mets-vins.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/resto-template-wrapper.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/resa-modal.css') }}">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Montserrat', sans-serif;
            background: #f5f5f5;
            color: #0a1628;
            overflow-x: hidden;
        }

        /* ---- Barre de navigation retour ---- */
        .amv-page-topnav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 32px;
            background: #0a1628;
            gap: 16px;
            flex-wrap: wrap;
            position: sticky;
            top: 0;
            z-index: 9999;
            box-shadow: 0 2px 16px rgba(0,0,0,0.35);
        }

        .amv-page-topnav-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: color 0.2s ease;
        }

        .amv-page-topnav-back:hover { color: #f26522; }

        .amv-page-topnav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .amv-page-topnav-brand img {
            height: 36px;
            width: auto;
        }

        .amv-page-topnav-brand-name {
            font-size: 14px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #ffffff;
        }

        .amv-page-topnav-brand-name span {
            color: #f26522;
        }

        .amv-page-topnav-cta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            background: linear-gradient(135deg, #e84c10, #f26522);
            color: #ffffff;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .amv-page-topnav-cta:hover {
            background: linear-gradient(135deg, #d44010, #e55a1a);
            transform: translateY(-1px);
            box-shadow: 0 5px 18px rgba(242,101,34,0.45);
        }

        @media (max-width: 640px) {
            .amv-page-topnav { padding: 10px 16px; }
            .amv-page-topnav-brand-name { display: none; }
        }
    </style>
</head>
<body>
    {{-- Contenu principal : template Accord Mets & Vins --}}
    @include('home-v2.components.RestoTemplateWrapper')

    {{-- Modal réservation global --}}
    @include('home-v2.components.ResaModal')

</body>
</html>
