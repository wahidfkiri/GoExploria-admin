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
@endphp

{{-- Multilingual Grid Component (VOTRE ESPACE ENTREPRISE MULTILINGUES) --}}
<section class="multilingual-v2-section" id="multilingue">

    {{-- ============================================================
         ENTÊTE STANDARD — ESPACE MULTILINGUE
         ============================================================ --}}
    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="#" class="resto-accord-btn" title="{{ $tr('GoExploria') }}">
                    <div class="logo-wrapper">
                        <img src="{{ asset('logo.png') }}" alt="{{ $tr('GoExploria') }}">
                    </div>
                    <span class="resto-accord-btn-label">{{ $tr('GoExploria') }}</span>
                    <span class="resto-accord-btn-cta">
                        <i class="fas fa-external-link-alt"></i> {{ $tr('Visiter') }}
                    </span>
                </a>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $tr('VOTRE ESPACE ENTREPRISE MULTILINGUES') }}</h1>
                <p class="resto-header-subtitle">
                    {{ $tr('Choisissez votre langue préférée afin de pénétrer les marchés internationaux et offrir une expérience de shopping exclusive.') }}
                </p></div>
            <div class="resto-header-logo-right">
                
                <a href="{{url('page-multilingue')}}" title="{{ $tr('En savoir plus') }}" target="_blank" rel="noopener noreferrer">
                    <!-- <i class="fas fa-circle-info"></i>
                    <span>Go Next Level</span> -->
                    <img
                    class="bt-next-level-image"
                    src="{{ asset('images/Next-level.png') }}"
                    alt="{{ $tr('Next Level') }}"
                    loading="lazy"
                >
                </a>
            </div>
        </div>
            @include('home-v2.components.SectionNavbarEspaceMedia')
        <div class="resto-header-destinations-bar">
            <div class="resto-dest-row">
    <div class="resto-dest-icon-box">
        <img src="{{ asset('REDI.png') }}" alt="Destinations">
        <span>Destinations</span>
    </div>

    <div class="resto-dest-breadcrumb vp-dest-breadcrumb">
        <select id="vp-continent-select" class="vp-dest-select" aria-label="Continent">
            <option value="amerique-nord">Amérique du Nord</option>
            <option value="europe">Europe</option>
            <option value="afrique">Afrique</option>
            <option value="asie">Asie</option>
            <option value="amerique-sud">Amérique du Sud</option>
            <option value="oceanie">Océanie</option>
        </select>
        <span class="resto-dest-sep">/</span>
        <select id="vp-country-select" class="vp-dest-select" aria-label="Pays">
            <option value="canada">Canada</option>
        </select>
        <span class="resto-dest-sep">/</span>
        <select id="vp-province-select" class="vp-dest-select" aria-label="Province">
            <option value="quebec">Québec</option>
            <option value="ontario">Ontario</option>
            <option value="alberta">Alberta</option>
            <option value="colombie-britannique">Colombie-Britannique</option>
            <option value="nouvelle-ecosse">Nouvelle-Écosse</option>
        </select>
        <span class="resto-dest-sep">/</span>
        <select id="vp-region-select" class="vp-dest-select" aria-label="Région">
            <option value="region-de-quebec">Région de Québec</option>
            <option value="montreal-metro">Montréal Métro</option>
            <option value="mauricie">Mauricie</option>
            <option value="gaspesie">Gaspésie</option>
            <option value="saguenay">Saguenay</option>
        </select>
    </div>
</div>
        </div>
    </div>

    {{-- ============================================================
         CONTENU PRINCIPAL
         ============================================================ --}}
    <div class="mlg-container">

            {{-- Grille des Langues --}}
            <div class="lang-grid-container">
                
                {{-- Français (PRINCIPALE) --}}
                <div class="lang-card">
                    <span class="lang-status-badge principale">{{ $tr('PRINCIPALE') }}</span>
                    <div class="flag-circle">
                        <img src="https://flagcdn.com/w160/fr.png" alt="{{ $tr('Drapeau Français') }}">
                    </div>
                    <h3>{{ $tr('Français') }}</h3>
                    <p>{{ $tr('Langue originale. Contenu complet et support client en français.') }}</p>
                    <button class="lang-select-btn selected">
                        <i class="fas fa-check"></i> {{ $tr('Sélectionné') }}
                    </button>
                </div>

                {{-- Anglais (POPULAIRE) --}}
                <div class="lang-card">
                    <span class="lang-status-badge populaire">{{ $tr('POPULAIRE') }}</span>
                    <div class="flag-circle">
                        <img src="https://flagcdn.com/w160/gb.png" alt="{{ $tr('Drapeau Anglais') }}">
                    </div>
                    <h3>{{ $tr('ANGLAIS') }}</h3>
                    <p>{{ $tr('International version. Full content and customer support.') }}</p>
                    <button class="lang-select-btn">
                        <i class="fas fa-globe"></i> {{ $tr('Select') }}
                    </button>
                </div>

                {{-- Espagnol (NOUVEAU) --}}
                <div class="lang-card">
                    <span class="lang-status-badge nouveau">{{ $tr('NOUVEAU') }}</span>
                    <div class="flag-circle">
                        <img src="https://flagcdn.com/w160/es.png" alt="{{ $tr('Drapeau Espagnol') }}">
                    </div>
                    <h3>{{ $tr('Español') }}</h3>
                    <p>{{ $tr('Versión internacional. Contenido completo y soporte.') }}</p>
                    <button class="lang-select-btn">
                        <i class="fas fa-globe"></i> {{ $tr('Seleccionar') }}
                    </button>
                </div>

                {{-- Allemand (PROCHAINE) --}}
                <div class="lang-card">
                    <span class="lang-status-badge prochaine">{{ $tr('PROCHAINE') }}</span>
                    <div class="flag-circle">
                        <img src="https://flagcdn.com/w160/de.png" alt="{{ $tr('Drapeau Allemand') }}">
                    </div>
                    <h3>{{ $tr('ALLEMAND') }}</h3>
                    <p>{{ $tr('Internationale Version. Vollständiger Inhalt.') }}</p>
                    <button class="lang-select-btn">
                        <i class="fas fa-globe"></i> {{ $tr('Auswählen') }}
                    </button>
                </div>

            </div>

            {{-- Footer Note SEO / CDN --}}
            <div class="enterprise-footer-note">
                <div class="note-box">
                    <i class="fas fa-globe-americas"></i>
                    <span>{{ $tr('🌐 Votre ESPACE ENTREPRISE inclut LE SEO GOOGLE / CDN + 4/8/12 jusqu\'à 25 langues disponibles') }}</span>
                </div>
            </div>

            {{-- Deuxième Ligne de Langues Optionnelles (Chinois, Hindi, Portugais, Arabe) --}}
            {{-- Caché par défaut ou affiché selon besoin - Ici je le mets en 2ème grille pour la démo --}}
            <div class="lang-grid-container" style="margin-top: 50px; opacity: 0.85;">
                
                {{-- Chinois Mandarin --}}
                <div class="lang-card">
                    <span class="lang-status-badge principale">{{ $tr('PRINCIPALE') }}</span>
                    <div class="flag-circle"><img src="https://flagcdn.com/w160/cn.png" alt="{{ $tr('Drapeau Chinois') }}"></div>
                    <h3>{{ $tr('CHINOIS MANDARIN') }}</h3>
                    <p>{{ $tr('Langue stratégique pour le marché asiatique. Support partiel.') }}</p>
                    <button class="lang-select-btn"><i class="fas fa-globe"></i> {{ $tr('Send') }}</button>
                </div>

                {{-- Hindi Inde --}}
                <div class="lang-card">
                    <span class="lang-status-badge populaire">{{ $tr('POPULAIRE') }}</span>
                    <div class="flag-circle"><img src="https://flagcdn.com/w160/in.png" alt="{{ $tr('Drapeau Hindi') }}"></div>
                    <h3>{{ $tr('HINDI INDE') }}</h3>
                    <p>{{ $tr('International version. Full content and support.') }}</p>
                    <button class="lang-select-btn"><i class="fas fa-globe"></i> {{ $tr('Send') }}</button>
                </div>

                {{-- Portugais --}}
                <div class="lang-card">
                    <span class="lang-status-badge nouveau">{{ $tr('NOUVEAU') }}</span>
                    <div class="flag-circle"><img src="https://flagcdn.com/w160/pt.png" alt="{{ $tr('Drapeau Portugal') }}"></div>
                    <h3>{{ $tr('PORTUGAIS') }}</h3>
                    <p>{{ $tr('Versión internacional. Contenido completo y soporte.') }}</p>
                    <button class="lang-select-btn"><i class="fas fa-globe"></i> {{ $tr('Send') }}</button>
                </div>

                {{-- Arabe --}}
                <div class="lang-card">
                    <span class="lang-status-badge prochaine">{{ $tr('PROCHAINE') }}</span>
                    <div class="flag-circle"><img src="https://flagcdn.com/w160/sa.png" alt="{{ $tr('Drapeau Arabie') }}"></div>
                    <h3>{{ $tr('ARABE') }}</h3>
                    <p>{{ $tr('Internationale Version. Vollständiger Inhalt.') }}</p>
                    <button class="lang-select-btn"><i class="fas fa-globe"></i> {{ $tr('Send') }}</button>
                </div>

            </div>

    </div>{{-- /mlg-container --}}
</section>
