{{-- Site d'un établissement désactivé depuis l'admin (SiteEtablissementActif). --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>Site indisponible{{ $nomEtablissement !== '' ? ' — ' . $nomEtablissement : '' }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; min-height: 100vh; display: grid; place-items: center; padding: 24px;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0); color: #0f172a;
        }
        .carte {
            max-width: 520px; width: 100%; background: #fff; border-radius: 18px; padding: 40px 32px;
            text-align: center; box-shadow: 0 20px 50px rgba(15, 23, 42, .08);
        }
        .icone {
            width: 72px; height: 72px; margin: 0 auto 20px; border-radius: 50%; background: #fef3c7;
            display: grid; place-items: center; font-size: 34px;
        }
        h1 { font-size: 22px; margin: 0 0 10px; }
        p { color: #475569; line-height: 1.6; margin: 0 0 24px; }
        a {
            display: inline-block; padding: 10px 20px; border-radius: 10px; background: #2563eb; color: #fff;
            text-decoration: none; font-weight: 600;
        }
        a:hover { background: #1d4ed8; }
    </style>
</head>
<body>
    <main class="carte">
        <div class="icone" aria-hidden="true">🔧</div>
        <h1>{{ $nomEtablissement !== '' ? $nomEtablissement : 'Ce site' }} est momentanément indisponible</h1>
        <p>Le site de cet établissement n'est pas accessible pour le moment. Revenez un peu plus tard.</p>
        <a href="{{ url('/') }}">Découvrir GoExploria</a>
    </main>
</body>
</html>
