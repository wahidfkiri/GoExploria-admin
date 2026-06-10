@php
    $siteName = trim((string) (get_site_name($etablissement->id) ?: ($etablissement->name ?? 'Restaurant')));
    $siteDescription = trim((string) (
        $etablissement->getSetting('description', null, 'general')
        ?: $etablissement->getSetting('site_description', null, 'general')
        ?: get_site_description($etablissement->id)
        ?: ''
    ));
    $logoUrl = $brandLogoUrl ?? get_logo_url($etablissement->id);
    $address = trim((string) ($etablissement->adresse ?? $etablissement->address ?? $etablissement->ville ?? ''));
    $email = trim((string) ($etablissement->email ?? $etablissement->contact_email ?? ''));
    $phone = trim((string) ($etablissement->telephone ?? $etablissement->phone ?? ''));
    $phoneHref = preg_replace('/\s+/', '', $phone);
    $devisLink = $devisUrl ?? route('devis');
    $hours = $etablissement->getSetting('opening_hours', [], 'company');
    $workingHours = normalize_cms_opening_hours($hours, $workingHours ?? []);
    $socialLinks = collect($socialLinks ?? get_establishment_social_links($etablissement))->filter(fn ($link) => !empty(data_get($link, 'url')))->values();

    $assetUrl = static function ($path) {
        if (empty($path)) return null;
        if (is_array($path)) $path = data_get($path, 'url') ?: data_get($path, 'thumbnail') ?: data_get($path, 'path') ?: data_get($path, 0);
        $path = trim((string) $path);
        if ($path === '') return null;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '//'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, ['/storage/'])) return asset(ltrim($path, '/'));
        if (\Illuminate\Support\Str::startsWith($path, ['storage/'])) return asset($path);
        if (\Illuminate\Support\Str::startsWith($path, ['/'])) return asset(ltrim($path, '/'));
        return asset('storage/' . ltrim($path, '/'));
    };

    $gallery = collect($mainGalleryMedia ?? []);
    if ($gallery->isEmpty()) $gallery = collect($galleryMedia ?? []);
    if ($gallery->isEmpty()) $gallery = collect($allGalleryMedia ?? []);
    $heroImage = $assetUrl(data_get($gallery->first(), 'thumbnail') ?: data_get($gallery->first(), 'url'))
        ?: 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=1800&q=85&auto=format&fit=crop';

    $youtubeIdFromUrl = static function ($value) {
        $value = trim((string) $value);
        if ($value === '') return null;
        if (preg_match('/<iframe[^>]+src=["\']([^"\']+)["\']/i', $value, $match)) $value = $match[1];
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/|live\/|embed\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/i', $value, $match)) return $match[1];
        return null;
    };

    $heroSlides = collect(get_slider_items($etablissement->id))->map(function ($slider) use ($assetUrl, $youtubeIdFromUrl) {
        $rawUrl = data_get($slider, 'url') ?: data_get($slider, 'image_url') ?: data_get($slider, 'image_path') ?: data_get($slider, 'video_url');
        $media = $assetUrl($rawUrl);
        $youtubeId = $youtubeIdFromUrl($media ?: $rawUrl);
        return [
            'type' => strtolower((string) (data_get($slider, 'type') ?: 'image')),
            'url' => $media,
            'embed' => $youtubeId ? 'https://www.youtube.com/embed/' . $youtubeId . '?autoplay=1&mute=1&muted=1&loop=1&playlist=' . $youtubeId . '&controls=0&rel=0&modestbranding=1&playsinline=1' : null,
            'title' => trim((string) (data_get($slider, 'title') ?: '')),
            'subtitle' => trim((string) (data_get($slider, 'subtitle') ?: data_get($slider, 'description') ?: '')),
            'button_text' => trim((string) (data_get($slider, 'button_text') ?: '')),
            'button_url' => trim((string) (data_get($slider, 'button_link') ?: data_get($slider, 'button_url') ?: '')),
            'order' => (int) data_get($slider, 'order', 0),
        ];
    })->filter(fn ($slide) => !empty($slide['url']) || !empty($slide['embed']))->sortBy('order')->values();

    $cmsLandingProducts = collect();
    try {
        if (class_exists(\App\Models\Product::class) && \Illuminate\Support\Facades\Schema::hasTable('products')) {
            $cmsLandingProducts = \App\Models\Product::query()
                ->with(['category:id,name', 'family:id,name'])
                ->where('etablissement_id', $etablissement->id)
                ->where('is_available_for_sale', true)
                ->where('is_public', true)
                ->latest('updated_at')
                ->limit(12)
                ->get();
        }
    } catch (\Throwable $e) {
        $cmsLandingProducts = collect();
    }

    $productPrice = static function ($product) {
        $value = $product->price_ttc ?? $product->price_ht ?? null;
        if ($value === null || $value === '') return 'Sur demande';
        return number_format((float) $value, 2, ',', ' ') . ' $';
    };

    $blogCards = collect($blogPosts ?? [])->filter(fn ($post) => trim((string) data_get($post, 'title')) !== '')->take(3)->values();
    $blogSectionTitle = function_exists('get_blog_section_title') ? get_blog_section_title($etablissement->id) : '';
    $blogSectionTitle = trim((string) $blogSectionTitle) !== '' ? $blogSectionTitle : 'Actualites du restaurant';
    $productSectionTitle = function_exists('get_ecommerce_section_title') ? get_ecommerce_section_title($etablissement->id) : '';
    $productSectionTitle = trim((string) $productSectionTitle) !== '' ? $productSectionTitle : 'Nos produits disponibles';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($siteDescription), 155) }}">
    <title>{{ $siteName }} | Restaurant</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home-v2/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/services-mega-menu-v2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/footer.css') }}">
    <style>
        :root{--cream:#faf7f2;--warm-white:#fff9f4;--ink:#1a1410;--ink-soft:#3d3228;--gold:#b8924a;--gold-light:#d4aa6a;--terracotta:#c0614a;--sage:#7a9070;--border:#e8e0d4;--section-alt:#f4ede3;--shadow:0 4px 40px rgba(26,20,16,.08);--font-display:'Cormorant Garamond',serif;--font-body:'DM Sans',sans-serif}
        *{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;font-family:var(--font-body);background:var(--cream);color:var(--ink);overflow-x:hidden}a{text-decoration:none;color:inherit}img,video,iframe{max-width:100%}.restaurant-page{background:var(--cream)}.restaurant-container{width:min(1180px,calc(100% - 40px));margin:auto}
        .rest-hero{position:relative;min-height:92vh;display:flex;align-items:center;overflow:hidden;padding:150px 0 90px}.rest-hero-bg{position:absolute;inset:0;background-size:cover;background-position:center}.rest-hero-bg:after{content:"";position:absolute;inset:0;background:linear-gradient(105deg,rgba(250,247,242,.94) 38%,rgba(250,247,242,.34) 100%)}.rest-hero-bg iframe{position:absolute;inset:50% auto auto 50%;width:177.78vh;height:56.25vw;min-width:100%;min-height:100%;transform:translate(-50%,-50%);border:0;pointer-events:none}.rest-hero-bg video,.rest-hero-bg img{width:100%;height:100%;object-fit:cover}.rest-hero-content{position:relative;z-index:2;max-width:680px}.rest-kicker{display:inline-flex;align-items:center;gap:.7rem;font-size:.75rem;font-weight:700;letter-spacing:.2em;text-transform:uppercase;color:var(--gold);margin-bottom:1.4rem}.rest-kicker:before{content:"";width:32px;height:1px;background:var(--gold)}.rest-h1{font-family:var(--font-display);font-size:clamp(3.2rem,6vw,6rem);font-weight:300;line-height:1.05;margin:0 0 1.4rem}.rest-h1 em{font-style:italic;color:var(--gold)}.rest-desc{font-size:1.05rem;font-weight:300;color:var(--ink-soft);line-height:1.75;max-width:500px;margin:0 0 2.2rem}.rest-actions{display:flex;gap:1rem;flex-wrap:wrap}.rest-btn{display:inline-flex;align-items:center;gap:.6rem;background:var(--ink);color:var(--cream);padding:.9rem 2rem;font-size:.82rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;border:0;cursor:pointer;transition:.25s}.rest-btn:hover{background:var(--gold);transform:translateY(-1px)}
        .rest-section{padding:6rem 0}.rest-section.alt{background:var(--section-alt)}.rest-head{display:flex;justify-content:space-between;align-items:end;gap:2rem;margin-bottom:3rem}.rest-tag{display:inline-flex;align-items:center;gap:.7rem;font-size:.72rem;font-weight:700;letter-spacing:.2em;text-transform:uppercase;color:var(--gold);margin-bottom:1rem}.rest-tag:before{content:"";width:24px;height:1px;background:var(--gold)}.rest-title{font-family:var(--font-display);font-size:clamp(2.2rem,4vw,3.4rem);font-weight:300;line-height:1.12;margin:0}.rest-sub{color:var(--ink-soft);line-height:1.75;max-width:520px;margin:.7rem 0 0}
        .rest-products{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:2px}.rest-product{background:var(--warm-white);display:grid;grid-template-columns:110px 1fr auto;gap:1.2rem;align-items:flex-start;padding:1.5rem;border:1px solid var(--border);transition:box-shadow .25s}.rest-product:hover{box-shadow:var(--shadow)}.rest-product-img{width:110px;height:110px;object-fit:cover;background:var(--section-alt)}.rest-product h3{font-family:var(--font-display);font-size:1.25rem;margin:.1rem 0 .35rem}.rest-product p{font-size:.86rem;color:var(--ink-soft);line-height:1.55;margin:0}.rest-price{font-family:var(--font-display);font-size:1.15rem;font-weight:600;color:var(--gold);white-space:nowrap}.rest-order{grid-column:2/-1;width:max-content;margin-top:.8rem;border:1px solid var(--ink);background:transparent;color:var(--ink);padding:.55rem 1rem;font-size:.72rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;cursor:pointer}.rest-order:hover{background:var(--ink);color:var(--cream)}
        .rest-blog-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1.5rem}.rest-blog{background:var(--warm-white);border:1px solid var(--border);overflow:hidden;transition:.25s}.rest-blog:hover{box-shadow:var(--shadow);transform:translateY(-4px)}.rest-blog-img{height:230px;background:var(--section-alt)}.rest-blog-img img{width:100%;height:100%;object-fit:cover}.rest-blog-body{padding:1.5rem}.rest-date{font-size:.72rem;letter-spacing:.15em;text-transform:uppercase;color:var(--gold);margin-bottom:.7rem}.rest-blog h3{font-family:var(--font-display);font-size:1.45rem;line-height:1.15;margin:0 0 .6rem}.rest-blog p{font-size:.9rem;color:var(--ink-soft);line-height:1.65;margin:0}.rest-more{display:inline-flex;gap:.45rem;align-items:center;margin-top:1rem;color:var(--gold);font-size:.78rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase}
        .rest-contact{background:var(--ink);color:var(--cream)}.rest-contact .rest-title{color:var(--cream)}.rest-contact .rest-sub{color:rgba(255,255,255,.66)}.rest-contact-grid{display:grid;grid-template-columns:.9fr 1.1fr;gap:4rem}.rest-info{display:grid;gap:1rem;margin-top:1.5rem}.rest-info-item{display:flex;gap:.8rem;color:rgba(255,255,255,.68);line-height:1.55}.rest-info-item i{color:var(--gold-light);margin-top:.15rem}.rest-social{display:flex;gap:.7rem;flex-wrap:wrap;margin-top:1.5rem}.rest-social a{width:42px;height:42px;border:1px solid rgba(255,255,255,.18);display:grid;place-items:center;color:var(--gold-light)}.rest-social a:hover{background:var(--gold);color:#fff}.rest-form{display:grid;gap:1rem}.rest-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem}.rest-field label{display:block;font-size:.72rem;letter-spacing:.15em;text-transform:uppercase;color:rgba(255,255,255,.55);margin-bottom:.45rem}.rest-field input,.rest-field select,.rest-field textarea{width:100%;padding:.9rem 1rem;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.18);color:var(--cream);font:inherit;outline:none}.rest-field select option{background:var(--ink)}.rest-field textarea{min-height:120px;resize:vertical}.rest-submit{width:max-content;background:var(--gold);color:#fff;border:0;padding:.9rem 1.8rem;font-size:.78rem;font-weight:900;letter-spacing:.12em;text-transform:uppercase;cursor:pointer}.rest-submit:hover{background:var(--gold-light)}
        .rest-footer{padding:2rem 0;background:#0f0b08;color:rgba(255,255,255,.58)}.rest-footer .restaurant-container{display:flex;justify-content:space-between;gap:1rem;flex-wrap:wrap}.rest-footer strong{color:#fff}
        @media(max-width:920px){.rest-head,.rest-contact-grid{display:block}.rest-blog-grid{grid-template-columns:1fr}.rest-row{grid-template-columns:1fr}.rest-hero{min-height:760px}.rest-products{grid-template-columns:1fr}.rest-product{grid-template-columns:90px 1fr}.rest-price{grid-column:2}.rest-order{grid-column:2}.rest-product-img{width:90px;height:90px}}
    </style>
</head>
<body>
    @include('home-v2.components.Header')
    @include('cms::web.fallback.partials.landing-cms-header')

    <main class="restaurant-page">
        @if(is_slider_enabled($etablissement->id) && has_slider($etablissement->id))
            {!! get_slider_html($etablissement->id) !!}
        @else
            @php($hero = $heroSlides->first())
            <section class="rest-hero" id="top">
                <div class="rest-hero-bg" style="background-image:url('{{ $hero['url'] ?? $heroImage }}')">
                    @if(!empty($hero['embed']))
                        <iframe src="{{ $hero['embed'] }}" title="{{ $hero['title'] ?: $siteName }}" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
                    @elseif(!empty($hero['url']) && ($hero['type'] ?? 'image') === 'video')
                        <video src="{{ $hero['url'] }}" autoplay muted loop playsinline></video>
                    @elseif(!empty($hero['url']))
                        <img src="{{ $hero['url'] }}" alt="{{ $hero['title'] ?: $siteName }}">
                    @endif
                </div>
                <div class="restaurant-container">
                    <div class="rest-hero-content">
                        <div class="rest-kicker">Restaurant</div>
                        <h1 class="rest-h1">{{ $hero['title'] ?: $siteName }}</h1>
                        @if($hero['subtitle'] ?? $siteDescription)
                            <p class="rest-desc">{{ $hero['subtitle'] ?: $siteDescription }}</p>
                        @endif
                        <div class="rest-actions">
                            @if(!empty($hero['button_text']) && !empty($hero['button_url']))
                                <a class="rest-btn" href="{{ $hero['button_url'] }}" target="_blank" rel="noopener noreferrer">{{ $hero['button_text'] }} <i class="fa-solid fa-arrow-right"></i></a>
                            @else
                                <a class="rest-btn" href="#contact">Contacter <i class="fa-solid fa-arrow-right"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if($cmsLandingProducts->isNotEmpty())
            <section class="rest-section alt" id="produits">
                <div class="restaurant-container">
                    <div class="rest-head">
                        <div>
                            <div class="rest-tag">Carte & produits</div>
                            <h2 class="rest-title">{{ $productSectionTitle }}</h2>
                        </div>
                        <p class="rest-sub">Produits publics et disponibles ajoutes pour cet etablissement.</p>
                    </div>
                    <div class="rest-products">
                        @foreach($cmsLandingProducts as $product)
                            @php
                                $image = $assetUrl($product->main_image ?: data_get($product->gallery_images, 0)) ?: $heroImage;
                                $label = optional($product->category)->name ?: optional($product->family)->name ?: 'Restaurant';
                                $productLink = $devisLink . (str_contains($devisLink, '?') ? '&' : '?') . http_build_query(['etablissement_id' => $etablissement->id, 'product_id' => $product->id]);
                            @endphp
                            <article class="rest-product">
                                <img class="rest-product-img" src="{{ $image }}" alt="{{ $product->name }}">
                                <div>
                                    <div class="rest-date">{{ $label }}</div>
                                    <h3>{{ $product->name }}</h3>
                                    @if($product->description)<p>{{ \Illuminate\Support\Str::limit(strip_tags((string) $product->description), 120) }}</p>@endif
                                    <button
                                        class="rest-order"
                                        type="button"
                                        data-cms-cart-add
                                        data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->name }}"
                                        data-product-price="{{ $product->price_ttc ?? $product->price_ht ?? 0 }}"
                                        data-product-image="{{ $image }}"
                                        data-product-url="{{ $productLink }}"
                                        data-etablissement-id="{{ $etablissement->id }}"
                                        data-etablissement-name="{{ $siteName }}"
                                    >Commander</button>
                                </div>
                                <div class="rest-price">{{ $productPrice($product) }}</div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @if(is_blog_enabled($etablissement->id) && $blogCards->isNotEmpty())
            <section class="rest-section" id="blog">
                <div class="restaurant-container">
                    <div class="rest-head">
                        <div>
                            <div class="rest-tag">Blog</div>
                            <h2 class="rest-title">{{ $blogSectionTitle }}</h2>
                        </div>
                    </div>
                    <div class="rest-blog-grid">
                        @foreach($blogCards as $post)
                            @php
                                $blogUrl = data_get($post, 'url') ?: '#blog';
                                $isExternalBlogUrl = !\Illuminate\Support\Str::startsWith($blogUrl, '#');
                                $blogTargetAttrs = $isExternalBlogUrl ? ' target="_blank" rel="noopener noreferrer"' : '';
                                $blogImage = data_get($post, 'image') ?: $heroImage;
                            @endphp
                            <a class="rest-blog" href="{{ $blogUrl }}"{!! $blogTargetAttrs !!}>
                                <div class="rest-blog-img"><img src="{{ $blogImage }}" alt="{{ data_get($post, 'title') }}"></div>
                                <div class="rest-blog-body">
                                    <div class="rest-date">{{ data_get($post, 'date') ?: 'Blog' }}</div>
                                    <h3>{{ data_get($post, 'title') }}</h3>
                                    @if(data_get($post, 'excerpt'))<p>{{ \Illuminate\Support\Str::limit(strip_tags((string) data_get($post, 'excerpt')), 130) }}</p>@endif
                                    <span class="rest-more">Lire la suite <i class="fa-solid fa-arrow-right"></i></span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section class="rest-section rest-contact" id="contact">
            <div class="restaurant-container rest-contact-grid">
                <div>
                    <div class="rest-tag">Contact</div>
                    <h2 class="rest-title">Reserver ou demander une information</h2>
                    <p class="rest-sub">Votre message est enregistre dans les contacts CMS.</p>
                    <div class="rest-info">
                        @if($phone)<div class="rest-info-item"><i class="fa-solid fa-phone"></i><a href="tel:{{ $phoneHref }}">{{ $phone }}</a></div>@endif
                        @if($email)<div class="rest-info-item"><i class="fa-solid fa-envelope"></i><a href="mailto:{{ $email }}">{{ $email }}</a></div>@endif
                        @if($address)<div class="rest-info-item"><i class="fa-solid fa-location-dot"></i><span>{{ $address }}</span></div>@endif
                        @if(!empty($workingHours))
                            <div class="rest-info-item"><i class="fa-solid fa-clock"></i><span>@foreach($workingHours as $row){{ !empty($row['day']) ? $row['day'] . ' : ' : '' }}{{ $row['hours'] ?? '' }}@if(!$loop->last)<br>@endif @endforeach</span></div>
                        @endif
                    </div>
                    @if($socialLinks->isNotEmpty())
                        <div class="rest-social">
                            @foreach($socialLinks as $link)
                                <a href="{{ data_get($link, 'url') }}" target="_blank" rel="noopener noreferrer" aria-label="{{ data_get($link, 'label') }}"><i class="{{ data_get($link, 'icon') ?: 'fa-solid fa-share-nodes' }}"></i></a>
                            @endforeach
                        </div>
                    @endif
                </div>
                <form class="rest-form" method="POST" action="{{ route('cms.company.contact.send', ['etablissementId' => $etablissement->id]) }}" data-cms-contact-form data-cms-form-name="landing_restaurant">
                    @csrf
                    <div class="rest-row">
                        <div class="rest-field"><label>Prenom</label><input name="first_name" type="text" required></div>
                        <div class="rest-field"><label>Nom</label><input name="last_name" type="text"></div>
                    </div>
                    <div class="rest-row">
                        <div class="rest-field"><label>Courriel</label><input name="email" type="email" required></div>
                        <div class="rest-field"><label>Telephone</label><input name="phone" type="tel"></div>
                    </div>
                    <div class="rest-row">
                        <div class="rest-field"><label>Demande</label><select name="service"><option>Reservation</option><option>Information</option><option>Commande</option><option>Evenement prive</option><option>Autre</option></select></div>
                        <div class="rest-field"><label>Date souhaitee</label><input name="date" type="date"></div>
                    </div>
                    <div class="rest-field"><label>Message</label><textarea name="message" required></textarea></div>
                    <button class="rest-submit" type="submit">Envoyer <i class="fa-solid fa-paper-plane"></i></button>
                </form>
            </div>
        </section>
    </main>

    @include('cms::web.fallback.partials.landing-cms-footer')
    <footer class="rest-footer">
        <div class="restaurant-container">
            <strong>{{ $siteName }}</strong>
            <span>&copy; {{ date('Y') }} - Restaurant</span>
        </div>
    </footer>

    @include('cms::web.fallback.partials.landing-contact-ajax')
    @include('cms::web.fallback.partials.landing-cart-drawer')
    @include('cms::web.fallback.partials.landing-back-to-top')
</body>
</html>
