@if(isset($etablissement) && function_exists('get_cms_footer_html'))
    {!! get_cms_footer_html($etablissement->id) !!}
@endif

{{-- Bouton flottant « Contactez-nous » + drawer de contact (AJAX → base CMS) --}}
@includeWhen(isset($etablissement), 'cms::web.fallback.partials.landing-contact-widget')
