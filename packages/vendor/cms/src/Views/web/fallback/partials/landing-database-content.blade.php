@php
    $landingDatabaseSections = collect($cmsPageSections ?? [])
        ->filter(fn ($section) => trim((string) data_get($section, 'content')) !== '')
        ->values();
@endphp

@if($landingDatabaseSections->isNotEmpty())
    <section class="cms-db-content" id="contenu">
        <?php foreach ($landingDatabaseSections as $index => $cmsPage): ?>
            <div class="cms-db-content-item" id="cms-page-{{ \Illuminate\Support\Str::slug(data_get($cmsPage, 'slug') ?: data_get($cmsPage, 'title') ?: ($index + 1)) }}">
                {!! data_get($cmsPage, 'content') !!}
            </div>
        <?php endforeach; ?>
    </section>
@endif
