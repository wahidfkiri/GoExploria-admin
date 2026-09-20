{{-- ==========================================================================
     CONTENU du méga-menu « Destinations » de la barre latérale.
     Servi par TravelDestinationController@destinationsMenu, inséré dans le
     panneau à la première ouverture (voir welcome-home/partials/side-rail).

     Un onglet par continent actif ; dans le volet, chaque pays actif avec ses
     provinces. Tous les libellés mènent à la page de destination.
     ========================================================================== --}}
@php
    $gxContinents = \App\Models\Continent::query()
        ->active()
        ->with([
            'countries' => fn ($q) => $q->active()->orderBy('name')
                ->with(['provinces' => fn ($p) => $p->active()->orderBy('name')]),
        ])
        ->orderBy('name')
        ->get();

    $gxDestUrl = static function (string $type, $slug) {
        return $slug ? route('travel-destination.show', ['type' => $type, 'slug' => $slug]) : null;
    };
@endphp

@if($gxContinents->isEmpty())
  <p class="gxmenu__empty">Aucune destination disponible pour le moment.</p>
@else
  <div class="gxmenu__tabs" role="tablist" aria-label="Continents">
    @foreach($gxContinents as $i => $continent)
      <button type="button" class="gxmenu__tab {{ $i === 0 ? 'is-active' : '' }}" role="tab"
              aria-selected="{{ $i === 0 ? 'true' : 'false' }}" data-gxmenu-pane="gxrail-dest-{{ $continent->id }}">
        <span>{{ $continent->name }}</span><em>{{ $continent->countries->count() }}</em>
      </button>
    @endforeach
  </div>

  <div class="gxmenu__panes">
    @foreach($gxContinents as $i => $continent)
      <section class="gxmenu__pane" id="gxrail-dest-{{ $continent->id }}" role="tabpanel" @if($i !== 0) hidden @endif>
        <div class="gxmenu__head">
          <h3 class="gxmenu__title">{{ $continent->name }}</h3>
          @if($url = $gxDestUrl('continent', $continent->slug))
            <a class="gxmenu__more" href="{{ $url }}">Voir le continent <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
          @endif
        </div>

        @if($continent->countries->isEmpty())
          <p class="gxmenu__empty">Aucun pays publié pour ce continent.</p>
        @else
          <div class="gxmenu-dest__grid">
            @foreach($continent->countries as $country)
              <div class="gxmenu-dest__country">
                <h4>
                  @if($url = $gxDestUrl('country', $country->slug))
                    <a href="{{ $url }}">{{ $country->name }}</a>
                  @else
                    {{ $country->name }}
                  @endif
                </h4>
                @if($country->provinces->isNotEmpty())
                  <ul class="gxmenu-dest__list">
                    @foreach($country->provinces as $province)
                      <li>
                        @if($url = $gxDestUrl('province', $province->slug))
                          <a href="{{ $url }}">{{ $province->name }}</a>
                        @else
                          {{ $province->name }}
                        @endif
                      </li>
                    @endforeach
                  </ul>
                @endif
              </div>
            @endforeach
          </div>
        @endif
      </section>
    @endforeach
  </div>
@endif
