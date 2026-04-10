{{-- resources/views/page-with-iframe.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Page avec iframe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Colonne gauche - Espace pub (4 colonnes) -->
            <div class="col-4" style="background: #f5f5f5; padding: 20px; height: 100vh; overflow-y: auto;">
                <h3>Espace Publicitaire</h3>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>Offre spéciale</h5>
                        <p>Profitez de -20%</p>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>Nouveau produit</h5>
                        <p>Découvrez notre catalogue</p>
                    </div>
                </div>
            </div>
            
            <!-- Colonne droite - iframe (8 colonnes) -->
            <div class="col-8" style="padding: 0; height: 100vh;">
                <iframe 
                    src="{{ route('theme.iframe', ['etablissementId' => $etablissement->id, 'slug' => 'home']) }}" 
                    style="width: 100%; height: 100%; border: none;"
                    title="Theme Preview">
                </iframe>
            </div>
        </div>
    </div>
</body>
</html>