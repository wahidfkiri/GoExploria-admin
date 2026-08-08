@php
    use Illuminate\Support\Str;

    $siteName = $etablissement->nom ?? $etablissement->name ?? 'Go Exploria Business';
    $meta = (array) (is_array($page->meta ?? null) ? $page->meta : []);
    $title = trim((string) ($meta['seo_title'] ?? $page->title ?? 'Page'));
    $description = trim((string) ($meta['seo_description'] ?? ''));
    $ogImage = trim((string) ($meta['og_image'] ?? ''));
    $canonicalUrl = url()->current();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | {{ $siteName }}</title>
    @if($description !== '')
        <meta name="description" content="{{ $description }}">
    @endif
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <meta property="og:title" content="{{ $title }}">
    @if($description !== '')
        <meta property="og:description" content="{{ $description }}">
    @endif
    @if($ogImage !== '')
        <meta property="og:image" content="{{ $ogImage }}">
    @endif

    {{-- Bootstrap 5 + Font Awesome pour le rendu des contenus éditeur (GrapesJS / VvvebJS) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *{box-sizing:border-box}
        body{margin:0;overflow-x:hidden;font-family:Inter,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif}
        img,video,iframe{max-width:100%}
        .cms-page-main{min-height:40vh}
    </style>
</head>
<body>
    {{-- Header de l'établissement (cms_header_footers). Rien n'est affiché si null :
         aucun header global n'est utilisé comme fallback. --}}
    @include('cms::web.fallback.partials.landing-cms-header', ['forceCmsHeaderFooter' => true])

    <main class="cms-page-main">
        {!! $content !!}
    </main>

    {{-- Activités proposées par l'établissement, rattachées depuis l'onglet
         « Activités » du tableau de bord. Dernière section avant le pied
         de page. --}}
    @include('cms::web.fallback.partials.gx-activities')

    {{-- Footer de l'établissement (cms_header_footers). Rien n'est affiché si null. --}}
    @include('cms::web.fallback.partials.landing-cms-footer', ['forceCmsHeaderFooter' => true])

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @include('cms::web.fallback.partials.gx-galleries')
    @include('cms::web.fallback.partials.gx-announcements')
</body>
</html>
