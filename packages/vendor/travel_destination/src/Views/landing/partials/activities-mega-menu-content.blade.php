{{-- ==========================================================================
     CONTENU du méga-menu « Activités » (onglets + volets).
     Servi par TravelDestinationController@activitiesMenu ; inséré dans le
     panneau du header des pages destination ET dans la barre de raccourcis.

     HIÉRARCHIE (demande du 2026-10-02) :
       onglet = TYPE de catégorie → dans le volet, chaque CATÉGORIE (titre
       cliquable vers sa page, qui liste ses sites web) → sous elle, ses
       ACTIVITÉS.

       - « Autres » regroupe les catégories sans type actif ;
       - « Sans catégorie » les activités orphelines ;
       - « Toutes les activités » (A→Z) reste en dernier onglet, pour chercher
         une activité sans connaître sa catégorie.

     Chemins RELATIFS partout : le HTML est mis en cache et partagé, une URL
     absolue y figerait le domaine de la requête qui a rempli le cache.
     ========================================================================== --}}
@php
    use Illuminate\Support\Str;

    $actifs = fn ($q) => $q->where('is_active', true);

    // Types actifs → catégories actives → activités actives.
    $gxTypes = \App\Models\CategorieType::query()
        ->where('is_active', true)
        ->with(['categories' => function ($q) {
            $q->where('is_active', true)->orderBy('name')
              ->with(['activities' => function ($a) {
                  $a->where('is_active', true)
                    ->whereNotNull('slug')->where('slug', '!=', '')
                    ->orderBy('name');
              }]);
        }])
        ->orderBy('name')
        ->get();

    $idsTypes = $gxTypes->pluck('id')->all();

    // Catégories sans type actif, mais qui portent des activités.
    $gxAutres = \App\Models\Category::query()
        ->where('is_active', true)
        ->where(fn ($q) => $q->whereNull('categorie_type_id')->orWhereNotIn('categorie_type_id', $idsTypes ?: [0]))
        ->whereHas('activities', fn ($a) => $a->where('is_active', true))
        ->with(['activities' => function ($a) {
            $a->where('is_active', true)
              ->whereNotNull('slug')->where('slug', '!=', '')
              ->orderBy('name');
        }])
        ->orderBy('name')
        ->get();

    // Activités sans catégorie active.
    $idsCategories = $gxTypes->flatMap->categories->pluck('id')
        ->merge($gxAutres->pluck('id'))->unique()->all();

    $gxOrphelines = \App\Models\Activity::query()
        ->where('is_active', true)
        ->whereNotNull('slug')->where('slug', '!=', '')
        ->where(fn ($q) => $q->whereNull('categorie_id')->orWhereNotIn('categorie_id', $idsCategories ?: [0]))
        ->orderBy('name')
        ->get();

    // Index A→Z : É, À… rangés avec E, A ; chiffres et signes sous « # ».
    $gxToutes = $gxTypes->flatMap->categories->flatMap->activities
        ->merge($gxAutres->flatMap->activities)
        ->merge($gxOrphelines)
        ->unique('id')
        ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);

    $gxLettres = $gxToutes->groupBy(function ($a) {
        $l = strtoupper(substr(Str::ascii(trim((string) $a->name)), 0, 1));
        return ctype_alpha($l) ? $l : '#';
    })->sortKeys();

    $gxActivite = static fn ($a) => '/activity/' . $a->slug;
    $gxCategorieLien = static function ($c) {
        if (! \Illuminate\Support\Facades\Route::has('category.show')) {
            return null;
        }
        $slug = trim((string) ($c->slug ?? ''));
        return route('category.show', $slug !== '' ? $slug : $c->id, false);
    };

    // Volets : un par type, puis « Autres », puis « Sans catégorie ».
    $gxVolets = collect();
    foreach ($gxTypes as $type) {
        $categories = $type->categories->filter(fn ($c) => $c->activities->isNotEmpty())->values();
        if ($categories->isEmpty()) {
            continue;
        }
        $gxVolets->push([
            'id'          => 'type-' . $type->id,
            'titre'       => $type->name,
            'categories'  => $categories,
            'activites'   => collect(),
            'nombre'      => $categories->sum(fn ($c) => $c->activities->count()),
        ]);
    }
    if ($gxAutres->isNotEmpty()) {
        $gxVolets->push([
            'id'         => 'type-autres',
            'titre'      => 'Autres catégories',
            'categories' => $gxAutres,
            'activites'  => collect(),
            'nombre'     => $gxAutres->sum(fn ($c) => $c->activities->count()),
        ]);
    }
    if ($gxOrphelines->isNotEmpty()) {
        $gxVolets->push([
            'id'         => 'type-sans-categorie',
            'titre'      => 'Sans catégorie',
            'categories' => collect(),
            'activites'  => $gxOrphelines,
            'nombre'     => $gxOrphelines->count(),
        ]);
    }
@endphp

@if($gxToutes->isEmpty())
  <p class="gxmenu__empty">Aucune activité disponible pour le moment.</p>
@else
  <div class="gxmenu__tabs" role="tablist" aria-label="Types de catégories">
    @foreach($gxVolets as $i => $volet)
      <button type="button" class="gxmenu__tab {{ $i === 0 ? 'is-active' : '' }}" role="tab"
              aria-selected="{{ $i === 0 ? 'true' : 'false' }}" data-gxmenu-pane="gxact-{{ $volet['id'] }}">
        <span>{{ $volet['titre'] }}</span><em>{{ $volet['nombre'] }}</em>
      </button>
    @endforeach
    <button type="button" class="gxmenu__tab" role="tab" aria-selected="false" data-gxmenu-pane="gxact-toutes">
      <span>Toutes les activités</span><em>{{ $gxToutes->count() }}</em>
    </button>
  </div>

  <div class="gxmenu__panes">
    @foreach($gxVolets as $i => $volet)
      <section class="gxmenu__pane" id="gxact-{{ $volet['id'] }}" role="tabpanel" @if($i !== 0) hidden @endif>
        <h3 class="gxmenu__title">{{ $volet['titre'] }}</h3>

        @if($volet['categories']->isNotEmpty())
          <div class="gxmenu-cat__grille">
            @foreach($volet['categories'] as $categorie)
              <div class="gxmenu-cat__bloc">
                <h4 class="gxmenu-cat__titre">
                  @if($lien = $gxCategorieLien($categorie))
                    <a href="{{ $lien }}">{{ $categorie->name }}</a>
                  @else
                    {{ $categorie->name }}
                  @endif
                  <em>{{ $categorie->activities->count() }}</em>
                </h4>
                <ul class="gxmenu-cat__liste">
                  @foreach($categorie->activities as $activite)
                    <li><a href="{{ $gxActivite($activite) }}">{{ $activite->name }}</a></li>
                  @endforeach
                </ul>
              </div>
            @endforeach
          </div>
        @else
          <div class="gxmenu-cat__grille">
            <div class="gxmenu-cat__bloc">
              <ul class="gxmenu-cat__liste">
                @foreach($volet['activites'] as $activite)
                  <li><a href="{{ $gxActivite($activite) }}">{{ $activite->name }}</a></li>
                @endforeach
              </ul>
            </div>
          </div>
        @endif
      </section>
    @endforeach

    <section class="gxmenu__pane" id="gxact-toutes" role="tabpanel" hidden>
      <h3 class="gxmenu__title">Toutes les activités <small>de A à Z</small></h3>
      <div class="gxmenu__az">
        @foreach($gxLettres as $lettre => $activites)
          <div class="gxmenu__letter">
            <h4>{{ $lettre }}</h4>
            <ul>
              @foreach($activites as $activite)
                <li><a href="{{ $gxActivite($activite) }}">{{ $activite->name }}</a></li>
              @endforeach
            </ul>
          </div>
        @endforeach
      </div>
    </section>
  </div>
@endif
