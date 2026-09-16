{{-- ==========================================================================
     CONTENU du méga-menu « Activités » (onglets + volets).
     Servi par TravelDestinationController@activitiesMenu, inséré dans
     `.td-actmega__body` à la première ouverture (voir activities-mega-menu).

     - « Toutes les activités » : liste A→Z en texte (pas d'images : c'est
       l'onglet ouvert par défaut, il doit rester léger).
     - un onglet par catégorie active, en vignettes (image + nom) ;
     - « Autres » pour les activités sans catégorie active.
     ========================================================================== --}}
@php
    use Illuminate\Support\Str;

    $tdActAll = \App\Models\Activity::query()
        ->where('is_active', true)
        ->whereNotNull('slug')
        ->where('slug', '!=', '')
        ->with('categoryRelation')
        ->orderBy('name')
        ->get();

    $tdActGroups = $tdActAll
        ->groupBy(fn ($a) => ($a->categoryRelation && $a->categoryRelation->is_active) ? $a->categoryRelation->id : 0)
        ->map(function ($items, $catId) {
            $cat = $catId ? $items->first()->categoryRelation : null;

            return [
                'id'    => $catId ?: 'autres',
                'name'  => $cat?->name ?? 'Autres',
                'slug'  => $cat?->slug,
                'items' => $items,
            ];
        })
        // Catégories par nom, « Autres » en dernier.
        ->sortBy(fn ($g) => ($g['id'] === 'autres' ? '~' : '') . mb_strtolower($g['name']))
        ->values();

    // Index alphabétique : É, À… rangés avec E, A ; chiffres et signes sous « # ».
    $tdActLetters = $tdActAll
        ->groupBy(function ($a) {
            $l = strtoupper(substr(Str::ascii(trim((string) $a->name)), 0, 1));
            return ctype_alpha($l) ? $l : '#';
        })
        ->sortKeys();

    $tdActUrl = static fn ($a) => url('/activity/' . $a->slug);
    $tdCategoryRoute = \Illuminate\Support\Facades\Route::has('category.show');
@endphp

@if($tdActAll->isEmpty())
  <p class="td-actmega__empty">Aucune activité disponible pour le moment.</p>
@else
  <div class="td-actmega__tabs" role="tablist" aria-label="Catégories d'activités">
    <button type="button" class="td-actmega__tab is-active" role="tab" aria-selected="true" data-td-pane="td-actpane-all">
      <span>Toutes les activités</span><em>{{ $tdActAll->count() }}</em>
    </button>
    @foreach($tdActGroups as $g)
      <button type="button" class="td-actmega__tab" role="tab" aria-selected="false" data-td-pane="td-actpane-{{ $g['id'] }}">
        <span>{{ $g['name'] }}</span><em>{{ $g['items']->count() }}</em>
      </button>
    @endforeach
  </div>

  <div class="td-actmega__panes">
    <section class="td-actmega__pane" id="td-actpane-all" role="tabpanel">
      <h3 class="td-actmega__title">Toutes les activités <small>de A à Z</small></h3>
      <div class="td-actmega__az">
        @foreach($tdActLetters as $lettre => $items)
          <div class="td-actmega__letter">
            <h4>{{ $lettre }}</h4>
            <ul>
              @foreach($items as $a)
                <li><a href="{{ $tdActUrl($a) }}">{{ $a->name }}</a></li>
              @endforeach
            </ul>
          </div>
        @endforeach
      </div>
    </section>

    @foreach($tdActGroups as $g)
      <section class="td-actmega__pane" id="td-actpane-{{ $g['id'] }}" role="tabpanel" hidden>
        <div class="td-actmega__head">
          <h3 class="td-actmega__title">{{ $g['name'] }}</h3>
          @if($g['slug'] && $tdCategoryRoute)
            <a class="td-actmega__more" href="{{ route('category.show', $g['slug']) }}">Voir la catégorie <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
          @endif
        </div>
        <div class="td-actmega__grid">
          @foreach($g['items'] as $a)
            <a class="td-actmega__card" href="{{ $tdActUrl($a) }}">
              <span class="td-actmega__media">
                @if($a->image_url)
                  <img src="{{ $a->image_url }}" alt="" loading="lazy" decoding="async">
                @else
                  <span class="td-actmega__ph"><i class="fas fa-person-hiking" aria-hidden="true"></i></span>
                @endif
              </span>
              <span class="td-actmega__name">{{ $a->name }}</span>
            </a>
          @endforeach
        </div>
      </section>
    @endforeach
  </div>
@endif
