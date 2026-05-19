@php(ob_start());@endphp
@php
    $sectionId = $sectionId ?? 'property-specialized-section';
    $eyebrow = $eyebrow ?? 'Espaces spécialisés';
    $title = $title ?? 'Immobilier au Québec';
    $subtitle = $subtitle ?? 'Découvrez une sélection de propriétés, chalets et projets touristiques pensés pour vos ambitions.';
    $ctaUrl = $ctaUrl ?? route('pages.chalet-rental-detail');
    $ctaText = $ctaText ?? 'En savoir plus';
    $cards = $cards ?? [];
@endphp

<section class="immo-v2-section immo-specialized-section" id="{{ $sectionId }}">
    <style>
        .immo-specialized-section {
            scroll-margin-top: 130px;
            padding-top: 42px;
        }

        .immo-specialized-section .immo-specialized-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 999px;
            background: #fff4ed;
            color: #e65216;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            box-shadow: 0 10px 24px rgba(230, 82, 22, .12);
        }

        .immo-specialized-section .immo-v2-grid {
            align-items: stretch;
        }

        .immo-specialized-section .immo-v2-card {
            min-height: 100%;
        }

        .immo-specialized-section .immo-specialized-actions {
            display: flex;
            justify-content: center;
            margin-top: 28px;
        }

        .immo-specialized-section .immo-specialized-cta {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 13px 26px;
            border-radius: 999px;
            background: linear-gradient(135deg, #e65216, #ff8b4a);
            color: #fff;
            font-weight: 900;
            text-decoration: none;
            box-shadow: 0 16px 32px rgba(230, 82, 22, .24);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .immo-specialized-section .immo-specialized-cta:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 20px 38px rgba(230, 82, 22, .3);
        }

        @media (max-width: 767px) {
            .immo-specialized-section {
                padding-top: 28px;
            }
        }
    </style>

    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="{{ route('pages.chalet-rental-detail') }}" class="resto-accord-btn" title="GoExploria">
                    <div class="logo-wrapper">
                        <img src="{{ asset('logo.png') }}" alt="GoExploria">
                    </div>
                    <span class="resto-accord-btn-label">GoExploria</span>
                    <span class="resto-accord-btn-cta">
                        <i class="fas fa-external-link-alt"></i> Visiter
                    </span>
                </a>
            </div>

            <div class="resto-header-center">
                <span class="immo-specialized-kicker">
                    <i class="fas fa-map-marker-alt"></i> {{ $eyebrow }}
                </span>
                <h1 class="resto-header-title">{{ $title }}</h1>
                <p class="resto-header-subtitle">{{ $subtitle }}</p>
            </div>

            <div class="resto-header-logo-right">
                <a href="{{ $ctaUrl }}" title="{{ $ctaText }}" target="_blank" rel="noopener noreferrer">
                    <img class="bt-next-level-image" src="{{ asset('images/Next-level.png') }}" alt="Next Level" loading="lazy">
                </a>
            </div>
        </div>

        <div class="resto-header-destinations-bar">
            <div class="resto-dest-row">
                <div class="resto-dest-icon-box">
                    <img src="{{ asset('REDI.png') }}" alt="Destinations">
                    <span>Destinations</span>
                </div>

                <div class="resto-dest-breadcrumb vp-dest-breadcrumb">
                    <select id="{{ $sectionId }}-continent-select" class="vp-dest-select" aria-label="Continent">
                        <option value="amerique-nord">Amérique du Nord</option>
                        <option value="europe">Europe</option>
                        <option value="afrique">Afrique</option>
                        <option value="asie">Asie</option>
                        <option value="amerique-sud">Amérique du Sud</option>
                        <option value="oceanie">Océanie</option>
                    </select>
                    <span class="resto-dest-sep">/</span>
                    <select id="{{ $sectionId }}-country-select" class="vp-dest-select" aria-label="Pays">
                        <option value="canada">Canada</option>
                    </select>
                    <span class="resto-dest-sep">/</span>
                    <select id="{{ $sectionId }}-province-select" class="vp-dest-select" aria-label="Province">
                        <option value="quebec">Québec</option>
                        <option value="ontario">Ontario</option>
                        <option value="alberta">Alberta</option>
                        <option value="colombie-britannique">Colombie-Britannique</option>
                        <option value="nouvelle-ecosse">Nouvelle-Écosse</option>
                    </select>
                    <span class="resto-dest-sep">/</span>
                    <select id="{{ $sectionId }}-region-select" class="vp-dest-select" aria-label="Région">
                        <option value="region-de-quebec">Région de Québec</option>
                        <option value="montreal-metro">Montréal Métro</option>
                        <option value="laurentides">Laurentides</option>
                        <option value="charlevoix">Charlevoix</option>
                        <option value="mont-tremblant">Mont-Tremblant</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="immo-v2-container">
        <div class="immo-v2-grid">
            @foreach($cards as $card)
                <article class="immo-v2-card">
                    <div class="immo-v2-card-img">
                        <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" loading="lazy">
                        <span class="immo-v2-img-badge">{{ $card['badge'] }}</span>
                    </div>
                    <div class="immo-v2-card-content">
                        <div class="immo-v2-price">{{ $card['price'] }}</div>
                        <h3 class="immo-v2-card-title">{{ $card['title'] }}</h3>
                        <div class="immo-v2-location"><i class="fas fa-map-pin"></i> {{ $card['location'] }}</div>
                        <div class="immo-v2-features">
                            @foreach($card['features'] as $feature)
                                <span class="immo-v2-feature-item"><i class="{{ $feature['icon'] }}"></i> {{ $feature['label'] }}</span>
                            @endforeach
                        </div>
                        <a href="{{ $card['url'] }}" class="immo-v2-btn">{{ $card['button'] ?? 'Voir le détail' }} <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="immo-specialized-actions">
            <a href="{{ $ctaUrl }}" class="immo-specialized-cta" target="_blank" rel="noopener noreferrer">
                {{ $ctaText }} <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp
