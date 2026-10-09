{{-- =================================================================
     CONTENU du méga-menu « Activités » — colonne des catégories et
     grilles d'activités.

     Séparé de son enveloppe (ActivitesMegaMenu) parce qu'il pèse 760 Ko
     dans la page d'accueil : un tiers de la réponse HTML pour un menu que
     la plupart des visiteurs n'ouvrent jamais. Il est désormais servi par
     `welcome.menu.activites` et chargé au premier besoin.

     La traduction est appliquée par le contrôleur, sur le HTML rendu : la
     vue est rendue seule (`view()->render()`), hors de toute page, et le
     tampon de sortie qu'utilise l'enveloppe n'a pas sa place ici.

     ⚠ Adresses RELATIVES (`route(..., false)`) : ce HTML est mis en cache
     côté serveur et partagé entre les visiteurs. En absolu, Laravel y
     écrirait l'hôte configuré du serveur, pas celui de la requête.
     ================================================================= --}}

@php
    $tr = static function (string $text): string {
        $locale = app()->getLocale();
        if ($locale === 'fr') {
            return $text;
        }

        static $maps = [];
        if (! array_key_exists($locale, $maps)) {
            $path = lang_path($locale . DIRECTORY_SEPARATOR . 'home-v2-components-map.php');
            $maps[$locale] = is_file($path) ? (require $path) : [];
        }

        return $maps[$locale][$text] ?? $text;
    };

    // Catégories actives ayant au moins une activité active
    $gxactCategories = \App\Models\Category::query()
        ->where('is_active', true)
        ->whereHas('activities', function ($q) {
            $q->where('is_active', true);
        })
        ->with(['activities' => function ($q) {
            $q->where('is_active', true)->orderBy('name');
        }])
        ->orderBy('name')
        ->get();
@endphp

@if($gxactCategories->isEmpty())
    <div class="gxact-empty">{{ $tr('Aucune activité disponible pour le moment.') }}</div>
@else
    <div class="gxact-body">

        {{-- ── Colonne gauche : catégories ── --}}
        <div class="gxact-cats" role="tablist" aria-label="{{ $tr('Catégories') }}">
            @foreach($gxactCategories as $index => $gxactCat)
                <button type="button"
                        role="tab"
                        class="gxact-cat {{ $index === 0 ? 'active' : '' }}"
                        aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                        aria-controls="gxact-pane-{{ $gxactCat->id }}"
                        data-gxact-pane="gxact-pane-{{ $gxactCat->id }}">
                    <span class="gxact-cat-name">{{ $gxactCat->name }}</span>
                    <i class="fas fa-chevron-right" aria-hidden="true"></i>
                </button>
            @endforeach

            <a href="{{ route('categories.index', [], false) }}" class="gxact-cats-all">
                {{ $tr('Toutes les catégories') }}
            </a>
        </div>

        {{-- ── Colonne droite : activités de la catégorie sélectionnée ── --}}
        <div class="gxact-panes">
            @foreach($gxactCategories as $index => $gxactCat)
                <div class="gxact-pane {{ $index === 0 ? 'visible' : '' }}"
                     id="gxact-pane-{{ $gxactCat->id }}"
                     role="tabpanel">

                    <h3 class="gxact-pane-title">{{ $tr('Explorer') }} {{ $gxactCat->name }}</h3>

                    <div class="gxact-grid">
                        @foreach($gxactCat->activities as $gxactAct)
                            <a class="gxact-card"
                               href="{{ route('activity.show', $gxactAct->slug ?: $gxactAct->id, false) }}"
                               title="{{ $gxactAct->name }}">
                                <span class="gxact-card-media">
                                    @if($gxactAct->image_url)
                                        <img src="{{ $gxactAct->image_url }}" alt="{{ $gxactAct->name }}" loading="lazy">
                                    @else
                                        <span class="gxact-card-ph"><i class="fas fa-mountain-sun" aria-hidden="true"></i></span>
                                    @endif
                                </span>
                                <span class="gxact-card-name">{{ $gxactAct->name }}</span>
                            </a>
                        @endforeach
                    </div>

                    <a href="{{ route('category.show', $gxactCat->slug ?: $gxactCat->id, false) }}" class="gxact-pane-link">
                        {{ $tr('Voir toutes les activités') }} <i class="fas fa-chevron-right" aria-hidden="true"></i>
                    </a>
                </div>
            @endforeach
        </div>

    </div>
@endif

