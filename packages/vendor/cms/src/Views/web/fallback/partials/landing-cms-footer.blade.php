@if(isset($etablissement) && function_exists('get_cms_footer_html'))
    {!! get_cms_footer_html($etablissement->id) !!}
@endif
