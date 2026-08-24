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

    // La requête ne part que si la page EST un template immobilier : sa classe
    // d'enveloppe en est la signature (§3 des règles templates, qui impose ce
    // préfixe sur chaque sélecteur). Sans ce garde-fou, tout site —
    // restaurant, garage — paierait une requête inutile à chaque affichage.
    //
    // ⚠ UNE ENVELOPPE PAR TEMPLATE IMMOBILIER : `immo-tpl` pour NadiImmo,
    // `resid-tpl` pour « Résidence — location d'appartements ». Tout nouveau
    // gabarit de cette famille DOIT être ajouté ici, sinon window.GX_IMMO
    // n'est jamais émis et le site reste bloqué sur les biens de
    // démonstration — sans la moindre erreur pour le signaler. Les autres
    // greffes (formulaire de demande, calendrier, média de la fiche) se
    // branchent, elles, sur `data-im-detail` et n'ont rien à déclarer.
    $gxEnveloppesImmo = ['immo-tpl', 'resid-tpl'];

    $gxEstTemplateImmo = \Illuminate\Support\Str::contains(
        collect($cmsPageSections ?? [])->map(fn ($p) => (string) data_get($p, 'content'))->implode(''),
        $gxEnveloppesImmo
    );

    try {
        if ($gxEstTemplateImmo
            && isset($etablissement)
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
                // Nombre d'annonces par négociateur, compté sur les biens déjà
                // chargés : le template l'affiche sur sa fiche, et une requête
                // de plus pour un chiffre qu'on a sous la main serait du gâchis.
                $gxImmoParAgent = $gxImmoBiens->groupBy('agent_id')->map->count();

                $gxImmoAgents = $gxImmoBiens
                    ->pluck('agent')
                    ->filter()
                    ->unique('id')
                    ->values()
                    ->map(function ($a) use ($gxImmoParAgent) {
                        $a->properties_count = $gxImmoParAgent[$a->id] ?? 0;

                        return $a->toApiArray();
                    });

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
