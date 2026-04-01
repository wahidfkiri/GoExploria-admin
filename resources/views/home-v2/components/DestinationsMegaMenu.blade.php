{{-- Mega Menu Component pour Destinations --}}
<div class="destinations-mega-menu" id="destinationsMegaMenu">
    {{-- Loader --}}
    <div class="destinations-mega-loader" id="destinationsLoader">
        <div class="destinations-spinner"></div>
        <p>Chargement des destinations...</p>
    </div>

    {{-- Contenu principal --}}
    <div class="destinations-mega-menu-grid" id="destinationsGrid" style="display: none;">
        {{-- Les colonnes seront générées dynamiquement par JavaScript --}}
    </div>

    {{-- Message si aucune destination --}}
    <div class="destinations-mega-menu-empty" id="destinationsEmpty" style="display: none;">
        <p>Aucune destination disponible pour le moment.</p>
    </div>
</div>
