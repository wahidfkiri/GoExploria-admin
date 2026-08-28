@php(ob_start());@endphp
@php
    use App\Models\Continent;
    use Illuminate\Support\Str;

    $staticContinents = Continent::with(['countries' => function ($q) {
        $q->active()->orderBy('name')->with(['provinces' => function ($p) {
            // Uniquement les provinces ACTIVES (status = 1).
            $p->active()->orderBy('name');
        }]);
    }])->active()->orderBy('name')->get();
@endphp
<div class="vmenu-destinations-mega" id="verticalDestinationsMega">
    <div class="vmenu-destinations-mega-header">
        <h3 class="vmenu-destinations-mega-title">
            <svg class="vmenu-destinations-mega-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="2" y1="12" x2="22" y2="12"></line>
                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
            </svg>
            Explorez le Monde
        </h3>
        <button class="vmenu-destinations-mega-close" id="closeVerticalDestinationsMega" aria-label="Fermer">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="vmenu-destinations-mega-content">
        @if($staticContinents->isNotEmpty())
        <div class="vmenu-destinations-mega-grid" id="vDestinationsGrid">
            @foreach($staticContinents as $continent)
            @php
                $continentImage = $continent->image
                    ? (Str::startsWith($continent->image, 'http') ? $continent->image : asset('storage/' . $continent->image))
                    : 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=400';
                $continentUrl = url('/travel-destination/continent/' . Str::slug($continent->name));
            @endphp
            <div class="vmenu-dest-section" data-id="{{ $continent->id }}" data-type="continent">
                <div class="vmenu-dest-section-header" data-toggle>
                    <img src="{{ $continentImage }}" alt="{{ $continent->name }}" class="vmenu-dest-section-image" loading="lazy">
                    <div class="vmenu-dest-section-info">
                        <h4 class="vmenu-dest-section-name">
                            <a href="{{ $continentUrl }}" class="vmenu-dest-name-link">{{ $continent->name }}</a>
                        </h4>
                        <p class="vmenu-dest-section-count">{{ $continent->countries->count() }} pays</p>
                    </div>
                    <svg class="vmenu-dest-section-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>
                <div class="vmenu-dest-section-content">
                    <div class="vmenu-dest-section-list">
                        @foreach($continent->countries as $country)
                        @php
                            $countryImage = $country->image
                                ? (Str::startsWith($country->image, 'http') ? $country->image : asset('storage/' . $country->image))
                                : 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=400';
                            $countryUrl = url('/travel-destination/country/' . Str::slug($country->name));
                            $countryProvinces = $country->provinces->take(10);
                        @endphp
                        <div class="vmenu-dest-subsection" data-type="country">
                            <div class="vmenu-dest-subsection-header" data-toggle>
                                <img src="{{ $countryImage }}" alt="{{ $country->name }}" class="vmenu-dest-subsection-image" loading="lazy">
                                <div class="vmenu-dest-section-info">
                                    <h5 class="vmenu-dest-subsection-name">
                                        <a href="{{ $countryUrl }}" class="vmenu-dest-name-link">{{ $country->name }}</a>
                                    </h5>
                                    @if($countryProvinces->isNotEmpty())
                                    <p class="vmenu-dest-section-count">{{ $countryProvinces->count() }} provinces</p>
                                    @endif
                                </div>
                                @if($countryProvinces->isNotEmpty())
                                <svg class="vmenu-dest-section-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                                @endif
                            </div>
                            @if($countryProvinces->isNotEmpty())
                            <div class="vmenu-dest-subsection-content">
                                <div class="vmenu-dest-subsection-list">
                                    @foreach($countryProvinces as $province)
                                    @php
                                        $provinceImage = $province->image
                                            ? (Str::startsWith($province->image, 'http') ? $province->image : asset('storage/' . $province->image))
                                            : 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400';
                                        $provinceUrl = url('/travel-destination/province/' . Str::slug($province->name));
                                    @endphp
                                    <a href="{{ $provinceUrl }}" class="vmenu-dest-item vmenu-dest-item--sub">
                                        <img src="{{ $provinceImage }}" alt="{{ $province->name }}" class="vmenu-dest-item-image" loading="lazy">
                                        <span class="vmenu-dest-item-name">{{ $province->name }}</span>
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="vmenu-destinations-mega-empty">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            <p>Aucune destination disponible</p>
        </div>
        @endif
    </div>
</div>
@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp
