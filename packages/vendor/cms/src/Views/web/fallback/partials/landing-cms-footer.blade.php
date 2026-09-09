@php
    // $forceCmsHeaderFooter (optionnel) : rend le footer d'établissement même si le
    // toggle footer_enabled n'a jamais été activé — une page CMS autonome n'a
    // aucun autre pied. Un refus EXPLICITE reste respecté.
    $cmsFooterHtml = '';
    $cmsFooterRefuse = function_exists('cms_region_refusee')
        && isset($etablissement)
        && cms_region_refusee($etablissement->id, 'footer');

    if (isset($etablissement) && !$cmsFooterRefuse) {
        if (($forceCmsHeaderFooter ?? false) && function_exists('get_cms_header_footer_html')) {
            $cmsFooterHtml = (string) get_cms_header_footer_html($etablissement->id, \Vendor\Cms\Models\HeaderFooter::TYPE_FOOTER);
        } elseif (function_exists('get_cms_footer_html')) {
            $cmsFooterHtml = (string) get_cms_footer_html($etablissement->id);
        }
    }
@endphp

@if(trim($cmsFooterHtml) !== '')
    {!! $cmsFooterHtml !!}
@endif

{{-- Bouton flottant « Contactez-nous » + drawer de contact (AJAX → base CMS).

     Pas en mode « embed » : le site y est rendu dans une iframe sans
     défilement propre, où `position: fixed` se cale sur la boîte de l'iframe
     et non sur l'écran. Le shell parent le rend à sa place. --}}
@includeWhen(isset($etablissement) && ! ($embedInPlatform ?? false),
             'cms::web.fallback.partials.landing-contact-widget')
