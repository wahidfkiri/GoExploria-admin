{{-- ═══════════════════════════════════════════════════════════════════════
     Biens immobiliers de l'établissement, remis au template.

     POURQUOI PAR JAVASCRIPT ET NON EN HTML RENDU CÔTÉ SERVEUR

     Le template porte déjà six biens de démonstration écrits en dur dans son
     balisage — c'est ce que l'éditeur affiche et laisse modifier, et c'est ce
     qui reste visible tant que l'établissement n'a rien saisi. Remplacer ce
     balisage côté serveur reviendrait à publier un contenu que l'utilisateur
     ne retrouverait pas dans l'éditeur.

     Le template reçoit donc les biens réels comme DONNÉES et reconstruit sa
     grille lui-même — exactement comme il le faisait avec son fichier data.js
     d'origine, dont ce bloc reprend le format à l'identique. Sa recherche, ses
     filtres et sa fiche de bien fonctionnent alors sur les vraies annonces
     sans qu'une seule ligne de son script change.

     Rien n'est émis si l'établissement n'a aucun bien : le template garde
     alors sa démonstration, et sa recherche filtre ces cartes-là.
     ═══════════════════════════════════════════════════════════════════════ --}}
@php
    $gxImmoPayload = null;

    try {
        if (isset($etablissement)
            && class_exists(\Vendor\Cms\Models\Property::class)
            && \Illuminate\Support\Facades\Schema::connection('cms')->hasTable('cms_properties')) {

            $gxImmoBiens = \Vendor\Cms\Models\Property::forEtablissement($etablissement->id)
                ->visible()
                ->with('agent')
                ->orderBy('position')
                ->orderByDesc('id')
                ->limit(200)          // garde-fou : la grille est cliente
                ->get();

            if ($gxImmoBiens->isNotEmpty()) {
                $gxImmoAgents = $gxImmoBiens
                    ->pluck('agent')
                    ->filter()
                    ->unique('id')
                    ->values()
                    ->map(fn ($a) => $a->toApiArray());

                $gxImmoPayload = [
                    'properties' => $gxImmoBiens->map(fn ($p) => $p->toApiArray())->values(),
                    'agents'     => $gxImmoAgents,
                ];
            }
        }
    } catch (\Throwable $e) {
        // Un site qui affiche la démonstration vaut mieux qu'un site en erreur.
        \Illuminate\Support\Facades\Log::warning('gx-immo-data : ' . $e->getMessage());
        $gxImmoPayload = null;
    }
@endphp

@if($gxImmoPayload)
    <script>
        /* Le script du template lit window.GX_IMMO au démarrage. Ce bloc doit
           donc précéder son exécution : il est inclus avant le contenu de
           page, où vit le <script> du template. */
        window.GX_IMMO = @json($gxImmoPayload);
    </script>
@endif
