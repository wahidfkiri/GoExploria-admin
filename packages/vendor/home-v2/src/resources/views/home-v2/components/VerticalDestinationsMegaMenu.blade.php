@php(ob_start());@endphp
{{-- Mega Menu Destinations pour le Menu Vertical --}}
<div class="vmenu-destinations-mega" id="verticalDestinationsMega">
    {{-- Header du Mega Menu --}}
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

    {{-- Contenu du Mega Menu --}}
    <div class="vmenu-destinations-mega-content">
        {{-- Loader --}}
        <div class="vmenu-destinations-mega-loader" id="vDestinationsLoader">
            <div class="vmenu-destinations-spinner"></div>
            <p>Chargement des destinations...</p>
        </div>

        {{-- Grille des destinations --}}
        <div class="vmenu-destinations-mega-grid" id="vDestinationsGrid" style="display: none;">
            {{-- Les destinations seront chargées dynamiquement ici --}}
        </div>

        {{-- État vide --}}
        <div class="vmenu-destinations-mega-empty" id="vDestinationsEmpty" style="display: none;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            <p>Aucune destination disponible</p>
        </div>
    </div>
</div>
@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp
