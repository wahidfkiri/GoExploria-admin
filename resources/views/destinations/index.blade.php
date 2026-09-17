{{--
    Page /destinations : l'index des destinations.

    Cette vue manquait alors que DestinationPageController::index() la rendait :
    la page renvoyait une erreur 500, et le lien « Destinations » du menu du site
    était donc cassé.

    Le contenu vient de la base (continents actifs et leurs pays), pas d'une
    liste écrite en dur : ajouter un pays dans l'admin le fait apparaître ici.
    Les liens reprennent les routes existantes `destinations.continent` et
    `destinations.country`, dont le résolveur accepte le nom « slugifié ».
--}}
@extends('landing.layout')

@section('title', 'Destinations - Go Exploria Business')
@section('description', 'Parcourez toutes les destinations de Go Exploria Business, continent par continent.')

@section('styles')
<style>
    .dest-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 28px; }
    .dest-card {
        background: #fff; border-radius: 16px; overflow: hidden;
        box-shadow: 0 6px 24px rgba(0, 0, 0, .08); display: flex; flex-direction: column;
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .dest-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0, 0, 0, .12); }
    .dest-cover { position: relative; display: block; height: 180px; background: #e9eef5; overflow: hidden; }
    .dest-cover img { width: 100%; height: 100%; object-fit: cover; }
    .dest-cover-fallback { display: grid; place-items: center; height: 100%; font-size: 2.6rem; color: #9fb0c4; }
    .dest-cover-title {
        position: absolute; inset: auto 0 0 0; padding: 26px 18px 14px; color: #fff;
        font-size: 1.25rem; font-weight: 700; text-shadow: 0 1px 4px rgba(0, 0, 0, .6);
        background: linear-gradient(transparent, rgba(0, 0, 0, .65));
    }
    .dest-body { padding: 18px; flex: 1; display: flex; flex-direction: column; gap: 12px; }
    .dest-desc { color: #5b6b7c; font-size: .92rem; margin: 0; }
    .dest-countries { display: flex; flex-wrap: wrap; gap: 8px; margin: 0; padding: 0; list-style: none; }
    .dest-countries a {
        display: inline-block; padding: 5px 12px; border-radius: 999px; font-size: .85rem;
        background: #f1f5fa; color: #2a4c6d; text-decoration: none; transition: background .15s ease;
    }
    .dest-countries a:hover { background: #dbe7f3; }
    .dest-more { font-size: .85rem; color: #7b8a99; align-self: center; }
    .dest-foot { margin-top: auto; padding-top: 6px; }
    .dest-empty { text-align: center; padding: 48px 16px; color: #6b7c8d; }
    .dest-empty i { font-size: 2.4rem; display: block; margin-bottom: 12px; opacity: .5; }
</style>
@endsection

@section('content')
<section class="landing-hero">
    <div class="container landing-hero-content text-center">
        <div class="hero-icon"><i class="fas fa-globe-americas"></i></div>
        <h1>Destinations</h1>
        <p>Explorez nos destinations, continent par continent</p>
        @if($continents->isNotEmpty())
            <a href="#liste" class="btn btn-cta"><i class="fas fa-map-marked-alt me-2"></i>Découvrir</a>
        @endif
    </div>
</section>

<section class="landing-section" id="liste">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Où souhaitez-vous aller&nbsp;?</h2>
            <p class="section-subtitle">Choisissez un continent ou un pays pour voir les entreprises et activités sur place</p>
        </div>

        @if($continents->isEmpty())
            <div class="dest-empty">
                <i class="fas fa-compass"></i>
                Aucune destination n'est publiée pour le moment.
            </div>
        @else
            <div class="dest-grid">
                @foreach($continents as $continent)
                    @php
                        $continentUrl = route('destinations.continent', ['slug' => Str::slug($continent->name)]);
                        $image = $continent->image
                            ? (Str::startsWith($continent->image, 'http') ? $continent->image : asset('storage/' . $continent->image))
                            : null;
                        // getAllContinents(true) précharge les pays actifs.
                        $countries = $continent->relationLoaded('countries') ? $continent->countries : collect();
                    @endphp

                    <article class="dest-card">
                        <a href="{{ $continentUrl }}" class="dest-cover" aria-label="{{ $continent->name }}">
                            @if($image)
                                <img src="{{ $image }}" alt="{{ $continent->name }}" loading="lazy">
                            @else
                                <span class="dest-cover-fallback"><i class="fas fa-earth-americas"></i></span>
                            @endif
                            <span class="dest-cover-title">{{ $continent->name }}</span>
                        </a>

                        <div class="dest-body">
                            @if($continent->description)
                                <p class="dest-desc">{{ Str::limit(strip_tags($continent->description), 130) }}</p>
                            @endif

                            @if($countries->isNotEmpty())
                                <ul class="dest-countries">
                                    @foreach($countries->take(8) as $country)
                                        <li>
                                            <a href="{{ route('destinations.country', ['slug' => Str::slug($country->name)]) }}">
                                                {{ $country->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                    @if($countries->count() > 8)
                                        <li class="dest-more">+{{ $countries->count() - 8 }} autres</li>
                                    @endif
                                </ul>
                            @endif

                            <div class="dest-foot">
                                <a href="{{ $continentUrl }}" class="btn btn-cta">
                                    <i class="fas fa-arrow-right me-2"></i>Explorer {{ $continent->name }}
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
