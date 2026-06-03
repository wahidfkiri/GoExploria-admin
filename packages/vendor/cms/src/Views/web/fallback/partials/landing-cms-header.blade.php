@if(isset($etablissement) && function_exists('get_cms_header_html'))
    {!! get_cms_header_html($etablissement->id) !!}
@endif
