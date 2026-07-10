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

{{-- Mega Menu Component pour Destinations --}}
<div class="destinations-mega-menu" id="destinationsMegaMenu">
    {{-- Loader --}}
    <div class="destinations-mega-loader" id="destinationsLoader">
        <div class="destinations-spinner"></div>
        <p>{{ $tr('Chargement des destinations...') }}</p>
    </div>

    {{-- Contenu principal --}}
    <div class="destinations-mega-menu-grid" id="destinationsGrid" style="display: none;">
        {{-- Les colonnes seront générées dynamiquement par JavaScript --}}
    </div>

    {{-- Message si aucune destination --}}
    <div class="destinations-mega-menu-empty" id="destinationsEmpty" style="display: none;">
        <p>{{ $tr('Aucune destination disponible pour le moment.') }}</p>
    </div>
</div>
