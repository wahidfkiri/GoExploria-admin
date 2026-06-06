@php
    $siteName = get_site_name($etablissement->id);
    $siteNameDisplay = trim((string) $siteName);
    if ($siteNameDisplay === '') {
        $siteNameDisplay = trim((string) ($etablissement->name ?? ''));
    }
    if ($siteNameDisplay === '') {
        $siteNameDisplay = 'GoExploria Business';
    }
    $siteDescription = $etablissement->getSetting('site_description', null, 'general')
        ?: get_site_description($etablissement->id)
        ?: 'Landing activité Immobilier & Construction.';
    $heroPrimaryCtaText = $etablissement->getSetting('hero_cta_text', null, 'landing')
        ?: $etablissement->getSetting('cta_text', null, 'general');
    $heroPrimaryCtaUrl = $etablissement->getSetting('hero_cta_url', null, 'landing')
        ?: ($devisUrl ?? route('devis'));
    $heroSecondaryCtaText = $etablissement->getSetting('hero_secondary_cta_text', null, 'landing');
    $heroSecondaryCtaUrl = $etablissement->getSetting('hero_secondary_cta_url', null, 'landing');
    $heroEyebrow = $etablissement->getSetting('hero_eyebrow', null, 'landing')
        ?: ($etablissement->other_activity_label ?? $siteNameDisplay);

    $logoUrl = get_logo_url($etablissement->id);
    $hasWideLogo = !empty(trim((string) $logoUrl));
    $phone = '(418) 525-7748';
    $email = 'info@goexploriabusiness.com';
    $address = $etablissement->getSetting('address', null, 'company')
        ?: $etablissement->getSetting('address', null, 'general')
        ?: 'Québec, Canada';
    $hours = $etablissement->getSetting('opening_hours', [], 'company');
    $workingHours = normalize_cms_opening_hours($hours, [
        ['day' => 'Lun-Ven', 'hours' => '8h00 - 17h00'],
        ['day' => 'Samedi', 'hours' => 'Sur rendez-vous'],
    ]);
    $mapAddress = '220 Rue Olivier, Issoudun, QC G0S 1L0, Canada';
    $mapLat = 46.5467987;
    $mapLng = -71.6160686;
    $mapVideoEmbedUrl = 'https://www.youtube.com/embed/arobhFZJRE4?autoplay=1&mute=1&playsinline=1&rel=0';

    $devisLink = $devisUrl ?? route('devis');
    $phoneHref = preg_replace('/[^\d\+]/', '', (string) $phone);
    $socialLinks = $socialLinks ?? get_establishment_social_links($etablissement);
    $cmsLandingProducts = collect();
    try {
        if (
            isset($etablissement)
            && !empty($etablissement->id)
            && class_exists(\App\Models\Product::class)
            && \Illuminate\Support\Facades\Schema::hasTable('products')
        ) {
            $cmsLandingProducts = \App\Models\Product::query()
                ->with(['category:id,name', 'family:id,name'])
                ->where('etablissement_id', $etablissement->id)
                ->where('is_available_for_sale', true)
                ->latest('updated_at')
                ->limit(8)
                ->get();
        }
    } catch (\Throwable $e) {
        $cmsLandingProducts = collect();
    }
    $cmsHasLiveProducts = $cmsLandingProducts->isNotEmpty();

    $fallbackHeroSlides = collect([
        [
            'type' => 'image',
            'media_url' => 'https://prestigeboisrond.ca/wp-content/uploads/2025/09/DSC06735-HDR.jpg',
            'thumb' => 'https://prestigeboisrond.ca/wp-content/uploads/2025/09/DSC06735-HDR.jpg',
            'title' => $siteNameDisplay,
            'subtitle' => $siteDescription,
            'button_text' => $heroPrimaryCtaText,
            'button_url' => $heroPrimaryCtaUrl,
            'video_type' => null,
            'video_embed_url' => null,
        ],
        [
            'type' => 'image',
            'media_url' => 'https://prestigeboisrond.ca/wp-content/uploads/2025/09/DJI_0237.jpg',
            'thumb' => 'https://prestigeboisrond.ca/wp-content/uploads/2025/09/DJI_0237.jpg',
            'title' => $siteNameDisplay,
            'subtitle' => $siteDescription,
            'button_text' => $heroPrimaryCtaText,
            'button_url' => $heroPrimaryCtaUrl,
            'video_type' => null,
            'video_embed_url' => null,
        ],
        [
            'type' => 'image',
            'media_url' => 'https://prestigeboisrond.ca/wp-content/uploads/2025/09/SaveInsta.App_327015499_693241832530188_5777615420000727358_n.jpg',
            'thumb' => 'https://prestigeboisrond.ca/wp-content/uploads/2025/09/SaveInsta.App_327015499_693241832530188_5777615420000727358_n.jpg',
            'title' => $siteNameDisplay,
            'subtitle' => $siteDescription,
            'button_text' => $heroPrimaryCtaText,
            'button_url' => $heroPrimaryCtaUrl,
            'video_type' => null,
            'video_embed_url' => null,
        ],
    ]);

    // Priority: cms_sliders (same intent as landing-boids logic), then provided $sliders payload.
    $extractIframeSrc = static function (?string $value): ?string {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }
        if (preg_match('/<iframe[^>]*src=["\']([^"\']+)["\'][^>]*>/i', $value, $m)) {
            return trim((string) ($m[1] ?? '')) ?: null;
        }
        return null;
    };

    $toVideoMeta = static function (?string $rawUrl) use ($extractIframeSrc): array {
        $value = trim((string) $rawUrl);
        if ($value === '') {
            return [null, null];
        }

        $iframeSrc = $extractIframeSrc($value);
        if ($iframeSrc) {
            return ['iframe', $iframeSrc];
        }

        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/|live\/|embed\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/i', $value, $m)) {
            return ['youtube', 'https://www.youtube.com/embed/' . $m[1]];
        }

        if (preg_match('/vimeo\.com\/(?:.*\/)?(\d+)/i', $value, $m) || preg_match('/player\.vimeo\.com\/video\/(\d+)/i', $value, $m)) {
            return ['vimeo', 'https://player.vimeo.com/video/' . $m[1]];
        }

        return ['upload', $value];
    };

    $cmsSliderItems = collect(get_slider_items($etablissement->id ?? null))
        ->filter(fn ($item) => (bool) data_get($item, 'is_active', true))
        ->map(function ($item, $index) use ($toVideoMeta, $siteNameDisplay, $siteDescription, $heroPrimaryCtaText, $heroPrimaryCtaUrl) {
            $type = strtolower((string) data_get($item, 'type', 'image')) === 'video' ? 'video' : 'image';
            $rawUrl = trim((string) data_get($item, 'url', ''));
            [$videoType, $videoEmbed] = $toVideoMeta($rawUrl);
            $mediaUrl = $type === 'video' ? $videoEmbed : $rawUrl;

            return [
                'type' => $type,
                'media_url' => $mediaUrl,
                'thumb' => $type === 'video' && $videoType === 'youtube' && preg_match('/embed\/([A-Za-z0-9_-]{11})/i', (string) $videoEmbed, $m)
                    ? 'https://i.ytimg.com/vi/' . $m[1] . '/hqdefault.jpg'
                    : $rawUrl,
                'title' => data_get($item, 'title') ?: $siteNameDisplay,
                'subtitle' => data_get($item, 'subtitle') ?: $siteDescription,
                'button_text' => data_get($item, 'button_text') ?: $heroPrimaryCtaText,
                'button_url' => data_get($item, 'button_link') ?: $heroPrimaryCtaUrl,
                'video_type' => $type === 'video' ? $videoType : null,
                'video_embed_url' => $type === 'video' ? $videoEmbed : null,
                'order' => (int) data_get($item, 'order', $index + 1),
            ];
        })
        ->filter(fn ($slide) => !empty($slide['media_url']))
        ->sortBy('order')
        ->values();

    $heroSlides = ($cmsSliderItems->isNotEmpty() ? $cmsSliderItems : collect($sliders ?? []))
        ->map(function ($slide) use ($toVideoMeta, $siteNameDisplay, $siteDescription, $heroPrimaryCtaText, $heroPrimaryCtaUrl) {
            $type = strtolower((string) data_get($slide, 'type', 'image')) === 'video' ? 'video' : 'image';

            if ($type === 'video') {
                $candidateVideo = data_get($slide, 'video_embed_url') ?: data_get($slide, 'video_url') ?: data_get($slide, 'url');
                [$videoType, $videoEmbed] = $toVideoMeta((string) $candidateVideo);
                $mediaUrl = $videoEmbed;
            } else {
                $videoType = null;
                $videoEmbed = null;
                $mediaUrl = data_get($slide, 'image_url') ?: data_get($slide, 'image_path') ?: data_get($slide, 'url');
            }

            return [
                'type' => $type,
                'media_url' => $mediaUrl,
                'thumb' => data_get($slide, 'thumbnail_url') ?: data_get($slide, 'thumbnail_path') ?: data_get($slide, 'image_url') ?: data_get($slide, 'image_path') ?: $mediaUrl,
                'title' => data_get($slide, 'name') ?: data_get($slide, 'title') ?: $siteNameDisplay,
                'subtitle' => data_get($slide, 'description') ?: data_get($slide, 'subtitle') ?: $siteDescription,
                'button_text' => data_get($slide, 'button_text') ?: $heroPrimaryCtaText,
                'button_url' => data_get($slide, 'button_url') ?: data_get($slide, 'button_link') ?: $heroPrimaryCtaUrl,
                'video_type' => $videoType,
                'video_embed_url' => $videoEmbed,
                'order' => (int) data_get($slide, 'order', 0),
            ];
        })
        ->filter(fn ($slide) => !empty($slide['media_url']))
        ->sortBy('order')
        ->values();

    if ($heroSlides->isEmpty()) {
        $heroSlides = $fallbackHeroSlides;
    }

    $fallbackGallery = collect([
        ['thumbnail' => 'https://prestigeboisrond.ca/wp-content/uploads/2025/09/DSC06735-HDR.jpg', 'name' => 'Réalisation Prestige'],
        ['thumbnail' => 'https://prestigeboisrond.ca/wp-content/uploads/2025/09/SaveInsta.App_327015499_693241832530188_5777615420000727358_n.jpg', 'name' => 'Chalet Scandinave'],
        ['thumbnail' => 'https://prestigeboisrond.ca/wp-content/uploads/2025/09/DJI_0237.jpg', 'name' => 'Vue Aérienne'],
        ['thumbnail' => 'https://prestigeboisrond.ca/wp-content/uploads/2025/09/IMG-20250628-WA0010.jpg', 'name' => 'Construction Signature'],
        ['thumbnail' => 'https://prestigeboisrond.ca/wp-content/uploads/2025/09/Gestion-complete-par-nos-experts-image-.jpg', 'name' => 'Gestion Experte'],
        ['thumbnail' => 'https://prestigeboisrond.ca/wp-content/uploads/2025/09/Client-auto-constructeur-image.jpg', 'name' => 'Auto-construction'],
    ]);

    $galleryItems = collect($mainGalleryMedia ?? [])
        ->map(function ($item) {
            return [
                'thumbnail' => data_get($item, 'thumbnail') ?: data_get($item, 'url'),
                'name' => data_get($item, 'name') ?: 'Média',
            ];
        })
        ->filter(fn ($item) => !empty($item['thumbnail']))
        ->take(16)
        ->values();

    if ($galleryItems->isEmpty()) {
        $galleryItems = collect($galleryMedia ?? [])
            ->map(function ($item) {
                return [
                    'thumbnail' => data_get($item, 'thumbnail') ?: data_get($item, 'url'),
                    'name' => data_get($item, 'name') ?: 'Média',
                ];
            })
            ->filter(fn ($item) => !empty($item['thumbnail']))
            ->take(16)
            ->values();
    }

    if ($galleryItems->isEmpty()) {
        $galleryItems = $fallbackGallery;
    }

    $galleryCats = ['prestige', 'scandinave', 'contemporain'];
    $socialFallback = $galleryItems->take(8)->values();
    $socialImages = [
        'instagram' => collect($instagramGalleryMedia ?? [])->filter(fn ($item) => !empty($item['thumbnail']))->pluck('thumbnail')->take(8)->values(),
        'facebook' => collect($facebookGalleryMedia ?? [])->filter(fn ($item) => !empty($item['thumbnail']))->pluck('thumbnail')->take(8)->values(),
        'pinterest' => collect($pinterestGalleryMedia ?? [])->filter(fn ($item) => !empty($item['thumbnail']))->pluck('thumbnail')->take(8)->values(),
    ];
    foreach ($socialImages as $platform => $images) {
        if ($images->isEmpty()) {
            $socialImages[$platform] = $socialFallback->pluck('thumbnail')->values();
        }
    }
    $heroStats = collect($etablissement->getSetting('hero_stats', [], 'landing'))
        ->map(function ($stat) {
            return [
                'value' => data_get($stat, 'value') ?: data_get($stat, 'number'),
                'label' => data_get($stat, 'label') ?: data_get($stat, 'title'),
            ];
        })
        ->filter(fn ($stat) => !empty($stat['value']) && !empty($stat['label']))
        ->take(3)
        ->values();
@endphp

<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $siteName }} | Immobilier & Construction</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
<link rel="stylesheet" href="{{ asset('css/home-v2/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu.css') }}">
<link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu-videos.css') }}">
<link rel="stylesheet" href="{{ asset('css/home-v2/hero.css') }}">
<link rel="stylesheet" href="{{ asset('css/home-v2/navigation.css') }}">
<link rel="stylesheet" href="{{ asset('css/home-v2/carousel.css') }}">
<link rel="stylesheet" href="{{ asset('css/home-v2/vertical-destinations-mega.css') }}">
<link rel="stylesheet" href="{{ asset('css/home-v2/mega-menu.css') }}">
<link rel="stylesheet" href="{{ asset('css/home-v2/services-mega-menu-v2.css') }}">
<link rel="stylesheet" href="{{ asset('css/home-v2/destinations-mega-menu-modern.css') }}">
<link rel="stylesheet" href="{{ asset('css/home-v2/destinations-search.css') }}">
<link rel="stylesheet" href="{{ asset('css/home-v2/search-bar.css') }}">
<link rel="stylesheet" href="{{ asset('css/home-v2/categories-mega-menu.css') }}">
<link rel="stylesheet" href="{{ asset('css/home-v2/videos-dropdown.css') }}">
<link rel="stylesheet" href="{{ asset('css/home-v2/slideshows.css') }}">
<link rel="stylesheet" href="{{ asset('css/home-v2/media-slideshow.css') }}">
<link rel="stylesheet" href="{{ asset('css/home-v2/products-vedette.css') }}">
<link rel="stylesheet" href="{{ asset('css/home-v2/restaurant-header.css') }}">
<link rel="stylesheet" href="{{ asset('css/home-v2/footer.css') }}">
<style>
/* ====================== DESIGN TOKENS ====================== */
:root {
  --global-header-offset: 108px;
  --template-header-height: 78px;
  --hero-top-offset: 186px;
  --gold:         #C9A84C;
  --gold-light:   #E8C97A;
  --gold-pale:    rgba(201,168,76,0.12);
  --dark:         #080808;
  --dark-2:       #0F0F0F;
  --dark-3:       #161616;
  --dark-4:       #1E1E1E;
  --dark-5:       #252525;
  --light:        #F8F4EE;
  --light-2:      #EDE5D5;
  --text-dark:    #0D0D0D;
  --text-light:   #F5F0E8;
  --text-muted:   #7A7470;
  --wood:         #7A4F2B;
  --wood-light:   #9E6B40;
  --green:        #2C4234;
  --radius:       2px;
  --ease:         cubic-bezier(0.25,0.46,0.45,0.94);
  --transition:   0.4s var(--ease);
  --font-serif:   'Cormorant Garamond', Georgia, serif;
  --font-sans:    'Outfit', sans-serif;
}
[data-theme="dark"] {
  --bg:        var(--dark);
  --bg-2:      var(--dark-2);
  --bg-3:      var(--dark-3);
  --text:      var(--text-light);
  --card-bg:   var(--dark-4);
  --border:    rgba(255,255,255,0.06);
  --nav-bg:    rgba(8,8,8,0.94);
}
[data-theme="light"] {
  --bg:        var(--light);
  --bg-2:      var(--light-2);
  --bg-3:      #fff;
  --text:      var(--text-dark);
  --card-bg:   #fff;
  --border:    rgba(0,0,0,0.07);
  --nav-bg:    rgba(248,244,238,0.96);
}

/* ====================== RESET ====================== */
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box;}
html{scroll-behavior:smooth;font-size:16px;}
body{font-family:var(--font-sans);background:var(--bg);color:var(--text);transition:background .5s,color .5s;overflow-x:hidden;width:100%;}
.header-v2{transform:translateY(0)!important;}
h1,h2,h3,h4{font-family:var(--font-serif);}
a{text-decoration:none;color:inherit;}
img{max-width:100%;display:block;}
::-webkit-scrollbar{width:5px;}
::-webkit-scrollbar-track{background:var(--dark-2);}
::-webkit-scrollbar-thumb{background:var(--gold);border-radius:3px;}

/* ====================== CURSOR ====================== */
.cursor{width:8px;height:8px;border-radius:50%;background:var(--gold);position:fixed;pointer-events:none;z-index:99999;transform:translate(-50%,-50%);transition:width .3s,height .3s;}
.cursor-ring{width:32px;height:32px;border-radius:50%;border:1px solid rgba(201,168,76,.5);position:fixed;pointer-events:none;z-index:99998;transform:translate(-50%,-50%);transition:all .12s ease-out;}
@media(max-width:768px){.cursor,.cursor-ring{display:none;}}

/* keep local template navbar visible under global header */
#navbar,.mobile-nav{display:block;}

/* ====================== NAVBAR ====================== */
#navbar{position:fixed;top:var(--global-header-offset);left:0;right:0;z-index:9990;background:var(--nav-bg);backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px);border-bottom:1px solid var(--border);transition:background .3s ease,border-color .3s ease,box-shadow .3s ease,color .3s ease;}
.nav-inner{max-width:1440px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;padding:0 2.5rem;height:78px;}
.logo{display:flex;align-items:center;gap:14px;min-width:0;}
.logo-wide{display:block;width:200px;max-width:200px;height:auto;max-height:none;object-fit:contain;}
.logo-text{font-family:var(--font-serif);font-size:1.15rem;font-weight:600;line-height:1.15;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:300px;}
.logo-text span{display:block;font-size:0.6rem;font-family:var(--font-sans);font-weight:500;letter-spacing:3.5px;text-transform:uppercase;color:var(--gold);margin-top:1px;}
.nav-links{display:flex;list-style:none;align-items:center;}
.nav-links>li{position:relative;}
.nav-links>li>a{padding:.5rem 1rem;display:block;font-size:.78rem;font-weight:500;letter-spacing:.8px;text-transform:uppercase;opacity:.75;transition:opacity .2s,color .2s;}
.nav-links>li>a:hover,.nav-links>li>a.active{opacity:1;color:var(--gold);}
.nav-links>li:hover .dropdown{opacity:1;visibility:visible;transform:translateY(0);}
.dropdown{position:absolute;top:calc(100% + 8px);left:0;min-width:230px;background:var(--card-bg);border:1px solid var(--border);border-top:2px solid var(--gold);box-shadow:0 24px 60px rgba(0,0,0,.4);padding:.5rem 0;opacity:0;visibility:hidden;transform:translateY(12px);transition:var(--transition);list-style:none;}
.dropdown li a{display:block;padding:.55rem 1.3rem;font-size:.8rem;opacity:.75;border-left:2px solid transparent;transition:.2s;}
.dropdown li a:hover{opacity:1;border-left-color:var(--gold);color:var(--gold);padding-left:1.6rem;}
.nav-actions{display:flex;align-items:center;gap:1rem;}
.btn-nav-cta{background:var(--gold);color:#fff;padding:.5rem 1.4rem;font-size:.75rem;font-weight:600;letter-spacing:1.2px;text-transform:uppercase;border:1px solid var(--gold);transition:var(--transition);}
.btn-nav-cta:hover{background:transparent;color:var(--gold);}
.theme-btn{width:34px;height:34px;border-radius:50%;border:1px solid var(--border);background:transparent;color:var(--text);cursor:pointer;font-size:13px;display:flex;align-items:center;justify-content:center;transition:var(--transition);}
.theme-btn:hover{border-color:var(--gold);color:var(--gold);}
.hamburger{display:none;flex-direction:column;gap:5px;cursor:pointer;padding:5px;}
.hamburger span{width:22px;height:2px;background:var(--text);transition:.3s;display:block;}

/* ====================== MOBILE NAV ====================== */
.mobile-nav{display:none;position:fixed;top:calc(var(--global-header-offset) + var(--template-header-height));left:0;right:0;bottom:0;z-index:9989;background:var(--dark-2);padding:2rem 2rem 2rem;overflow-y:auto;}
.mobile-nav.open{display:block;}
.mobile-nav-links{list-style:none;}
.mobile-nav-links>li{border-bottom:1px solid var(--border);}
.mobile-nav-links>li>a{display:block;padding:1rem 0;font-size:.95rem;font-weight:500;}

/* ====================== BUTTONS ====================== */
.btn-primary{background:var(--gold);color:#fff;padding:.85rem 2.2rem;font-size:.78rem;font-weight:600;letter-spacing:1.2px;text-transform:uppercase;border:1px solid var(--gold);display:inline-block;transition:var(--transition);cursor:pointer;}
.btn-primary:hover{background:transparent;color:var(--gold);}
.btn-outline{background:transparent;color:var(--text);padding:.85rem 2.2rem;font-size:.78rem;font-weight:500;letter-spacing:1.2px;text-transform:uppercase;border:1px solid var(--border);display:inline-block;transition:var(--transition);cursor:pointer;}
.btn-outline:hover{border-color:var(--gold);color:var(--gold);}
.btn-ghost{background:transparent;color:#fff;padding:.85rem 2.2rem;font-size:.78rem;font-weight:500;letter-spacing:1px;text-transform:uppercase;border:1px solid rgba(255,255,255,.35);display:inline-block;transition:var(--transition);}
.btn-ghost:hover{border-color:var(--gold);color:var(--gold);}

/* ====================== SECTION BASICS ====================== */
section{padding:6rem 2.5rem;}
.container{max-width:1340px;margin:0 auto;}
.sec-eyebrow{display:inline-flex;align-items:center;gap:12px;font-size:.65rem;letter-spacing:4px;text-transform:uppercase;color:var(--gold);margin-bottom:1rem;}
.sec-eyebrow::before{content:'';width:28px;height:1px;background:var(--gold);}
.sec-title{font-size:clamp(2rem,4vw,3.4rem);line-height:1.08;margin-bottom:1.2rem;}
.sec-sub{font-size:.95rem;color:var(--text-muted);line-height:1.75;max-width:580px;}
.text-gold{color:var(--gold);}
.reveal{opacity:0;transform:translateY(36px);transition:opacity .75s ease,transform .75s ease;}
.reveal.visible{opacity:1;transform:translateY(0);}
.delay-1{transition-delay:.1s;}.delay-2{transition-delay:.2s;}.delay-3{transition-delay:.3s;}.delay-4{transition-delay:.4s;}

/* ====================== HERO ====================== */
.hero-media{position:absolute;inset:0;z-index:0;overflow:hidden;}
.hero-media img,.hero-media video{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;}
.hero-media iframe{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:177.78vh;height:56.25vw;min-width:100%;min-height:100%;border:0;pointer-events:none;}

#hero{height:calc(100vh - var(--hero-top-offset));min-height:620px;position:relative;overflow:hidden;margin-top:var(--hero-top-offset);padding:0;}
.hero-swiper{width:100%;height:100%;}
.hero-slide{position:relative;display:flex;align-items:center;}
.hero-slide::before{content:'';position:absolute;inset:0;background:linear-gradient(120deg,rgba(0,0,0,.72) 0%,rgba(0,0,0,.18) 55%,rgba(0,0,0,.38) 100%);z-index:1;}
.hero-slide img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transform:scale(1.07);animation:heroZoom 9s ease-out forwards;}
@keyframes heroZoom{to{transform:scale(1);}}
.hero-content{position:relative;z-index:2;max-width:680px;padding:0 2.5rem;margin-left:9%;}
.hero-eyebrow{display:inline-flex;align-items:center;gap:12px;font-size:.65rem;letter-spacing:4px;text-transform:uppercase;color:var(--gold);margin-bottom:1.8rem;opacity:0;animation:fadeUp .8s .3s forwards;}
.hero-eyebrow::before{content:'';width:28px;height:1px;background:var(--gold);}
.hero-content h1{font-size:clamp(2.8rem,5.5vw,5.2rem);color:#fff;line-height:1.04;margin-bottom:1.6rem;opacity:0;animation:fadeUp .8s .5s forwards;}
.hero-content h1 em{color:var(--gold);font-style:italic;}
.hero-content p{font-size:1.05rem;color:rgba(255,255,255,.78);line-height:1.75;margin-bottom:2.8rem;opacity:0;animation:fadeUp .8s .7s forwards;}
.hero-btns{display:flex;gap:1rem;flex-wrap:wrap;opacity:0;animation:fadeUp .8s .9s forwards;}
@keyframes fadeUp{from{opacity:0;transform:translateY(28px)}to{opacity:1;transform:translateY(0)}}

/* Hero bottom stats */
.hero-stats{position:absolute;bottom:2.5rem;right:7%;z-index:3;display:flex;gap:3rem;}
.hero-stat .num{font-family:var(--font-serif);font-size:2.4rem;color:var(--gold);line-height:1;display:block;}
.hero-stat .lbl{font-size:.6rem;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.55);margin-top:4px;display:block;}
.hero-scroll{position:absolute;bottom:2rem;left:50%;transform:translateX(-50%);z-index:3;display:flex;flex-direction:column;align-items:center;gap:6px;color:rgba(255,255,255,.45);font-size:.6rem;letter-spacing:2px;text-transform:uppercase;animation:bounce 2s infinite;}
.hero-scroll i{font-size:16px;color:var(--gold);}
@keyframes bounce{0%,100%{transform:translateX(-50%) translateY(0)}50%{transform:translateX(-50%) translateY(8px)}}

/* Swiper pagination */
.swiper-pagination-bullet{background:rgba(255,255,255,.35)!important;opacity:1!important;width:6px!important;height:6px!important;}
.swiper-pagination-bullet-active{background:var(--gold)!important;width:22px!important;border-radius:3px!important;}

/* ====================== HERO SELECTOR (VERTICAL, RIGHT SIDE) ====================== */
.hero-selector{
  position:absolute;
  right:0;
  top:50%;
  transform:translateY(-50%);
  z-index:10;
  display:flex;
  flex-direction:column;
  gap:0;
  width:260px;
}

.hsel-card{
  position:relative;
  cursor:pointer;
  overflow:hidden;
  transition:var(--transition);
  border-left:3px solid transparent;
  background:rgba(8,8,8,.72);
  backdrop-filter:blur(20px);
  -webkit-backdrop-filter:blur(20px);
  display:flex;
  flex-direction:column;
  border-bottom:1px solid rgba(255,255,255,.05);
}
.hsel-card:last-child{border-bottom:none;}
.hsel-card.active{border-left-color:var(--gold);background:rgba(8,8,8,.88);}
.hsel-card:hover{background:rgba(20,16,10,.9);}

/* Thumbnail image */
.hsel-thumb{
  width:100%;
  height:90px;
  overflow:hidden;
  position:relative;
  flex-shrink:0;
}
.hsel-thumb img{
  width:100%;height:100%;object-fit:cover;
  transition:transform .7s var(--ease);
  filter:brightness(.55) saturate(.8);
}
.hsel-card.active .hsel-thumb img{filter:brightness(.75) saturate(1);}
.hsel-card:hover .hsel-thumb img{transform:scale(1.08);filter:brightness(.7) saturate(1);}
/* Gold shimmer overlay on active */
.hsel-thumb::after{
  content:'';position:absolute;inset:0;
  background:linear-gradient(180deg,transparent 40%,rgba(201,168,76,.18) 100%);
  opacity:0;transition:.4s;
}
.hsel-card.active .hsel-thumb::after,.hsel-card:hover .hsel-thumb::after{opacity:1;}

/* Slide number badge on thumb */
.hsel-num{
  position:absolute;top:8px;left:10px;
  font-size:.58rem;letter-spacing:2px;text-transform:uppercase;
  color:var(--gold);font-family:var(--font-sans);font-weight:700;
  background:rgba(0,0,0,.5);padding:2px 7px;border-radius:1px;
  z-index:1;
}
/* Active indicator bar on thumb */
.hsel-progress{
  position:absolute;bottom:0;left:0;height:2px;
  background:var(--gold);width:0%;
  transition:none;z-index:2;
}
.hsel-card.active .hsel-progress{
  animation:hselProgress 6s linear forwards;
}
@keyframes hselProgress{from{width:0%}to{width:100%}}

/* Text body */
.hsel-body{
  padding:.85rem 1.1rem .9rem;
  display:flex;align-items:center;gap:10px;
}
.hsel-icon{
  width:30px;height:30px;border-radius:50%;
  border:1px solid rgba(201,168,76,.4);
  display:flex;align-items:center;justify-content:center;
  color:var(--gold);font-size:.78rem;flex-shrink:0;
  transition:.3s;
}
.hsel-card.active .hsel-icon,.hsel-card:hover .hsel-icon{background:var(--gold);border-color:var(--gold);color:#fff;}
.hsel-info{flex:1;min-width:0;}
.hsel-tag{font-size:.55rem;letter-spacing:2px;text-transform:uppercase;color:var(--gold);display:block;margin-bottom:2px;font-weight:600;}
.hsel-info h4{font-family:var(--font-sans);font-size:.8rem;font-weight:600;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.hsel-info p{font-size:.65rem;color:rgba(255,255,255,.45);}
.hsel-arrow{color:var(--gold);font-size:.65rem;flex-shrink:0;opacity:0;transition:.3s;transform:translateX(-4px);}
.hsel-card:hover .hsel-arrow,.hsel-card.active .hsel-arrow{opacity:1;transform:translateX(0);}

@media(max-width:1200px){
  .hero-selector{width:220px;}
  .hsel-thumb{height:72px;}
}
@media(max-width:900px){
  .hero-selector{
    width:100%;right:auto;top:auto;bottom:0;
    transform:none;
    flex-direction:row;
  }
  .hsel-card{flex:1;}
  .hsel-thumb{height:58px;}
  .hsel-info p{display:none;}
  .hsel-arrow{display:none;}
}
@media(max-width:580px){
  .hsel-num{display:none;}
  .hsel-thumb{height:44px;}
  .hsel-body{padding:.55rem .7rem;}
  .hsel-info h4{font-size:.7rem;}
}

/* ====================== STATS BAR ====================== */
#stats{background:var(--gold);padding:3.5rem 2.5rem;}
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:2rem;max-width:1100px;margin:0 auto;text-align:center;}
.stat-item .num{font-family:var(--font-serif);font-size:3.2rem;color:#fff;line-height:1;display:block;}
.stat-item .lbl{color:rgba(255,255,255,.8);font-size:.65rem;letter-spacing:2.5px;text-transform:uppercase;margin-top:6px;display:block;}

/* ====================== ABOUT ====================== */
#about{background:var(--bg-2);}
.about-grid{display:grid;grid-template-columns:1fr 1fr;gap:6rem;align-items:center;}
.about-img-wrap{position:relative;}
.about-img-main{width:100%;height:560px;object-fit:cover;}
.about-badge{position:absolute;bottom:-2rem;right:-2rem;background:var(--gold);padding:2.2rem;text-align:center;min-width:160px;}
.about-badge .big{font-family:var(--font-serif);font-size:3rem;color:#fff;display:block;line-height:1;}
.about-badge .small{font-size:.65rem;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.8);}
.about-feats{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-top:2.5rem;}
.feat-item{display:flex;align-items:flex-start;gap:12px;padding:1.2rem;background:var(--bg-3);border:1px solid var(--border);border-left:3px solid var(--gold);}
.feat-item i{color:var(--gold);font-size:1.1rem;margin-top:2px;flex-shrink:0;}
.feat-item h4{font-family:var(--font-sans);font-size:.82rem;font-weight:600;margin-bottom:3px;}
.feat-item p{font-size:.76rem;color:var(--text-muted);line-height:1.5;}

/* ====================== PRODUCTS ====================== */
#products{background:var(--bg);}
.products-hdr{display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:3rem;}
.products-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:2px;}
.product-card{position:relative;overflow:hidden;cursor:pointer;aspect-ratio:3/4;background:var(--dark-3);}
.product-card:first-child{grid-row:span 2;aspect-ratio:auto;}
.product-card img{width:100%;height:100%;object-fit:cover;transition:transform .7s var(--ease);}
.product-card:hover img{transform:scale(1.07);}
.product-overlay{position:absolute;inset:0;background:linear-gradient(0deg,rgba(0,0,0,.88) 0%,rgba(0,0,0,0) 55%);display:flex;flex-direction:column;justify-content:flex-end;padding:2rem;transition:var(--transition);}
.product-card:hover .product-overlay{background:linear-gradient(0deg,rgba(0,0,0,.92) 0%,rgba(0,0,0,.18) 65%);}
.product-tag{display:inline-block;background:var(--gold);padding:3px 10px;font-size:.6rem;letter-spacing:2px;text-transform:uppercase;color:#fff;margin-bottom:.5rem;width:fit-content;}
.product-overlay h3{color:#fff;font-size:1.4rem;margin-bottom:.3rem;}
.product-overlay p{color:rgba(255,255,255,.65);font-size:.8rem;margin-bottom:1rem;}
.product-link{display:inline-flex;align-items:center;gap:8px;color:var(--gold);font-size:.72rem;letter-spacing:1px;text-transform:uppercase;font-weight:600;transform:translateY(10px);opacity:0;transition:var(--transition);}
.product-card:hover .product-link{transform:translateY(0);opacity:1;}
.product-link i{transition:transform .3s;}
.product-link:hover i{transform:translateX(5px);}

/* ====================== VIDEO ====================== */
#video-section{background:var(--dark);padding:5rem 2.5rem;text-align:center;}
.video-wrap{position:relative;max-width:920px;margin:2.5rem auto 0;overflow:hidden;}
.video-thumb{width:100%;display:block;filter:brightness(.55);}
.video-play{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:82px;height:82px;border-radius:50%;background:var(--gold);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:1.6rem;color:#fff;transition:var(--transition);box-shadow:0 0 0 16px rgba(201,168,76,.18);}
.video-play:hover{transform:translate(-50%,-50%) scale(1.1);box-shadow:0 0 0 22px rgba(201,168,76,.26);}

/* ====================== GALLERY ====================== */
#gallery{background:var(--bg-2);padding-bottom:3rem;}
.gallery-filter{display:flex;gap:.5rem;margin-bottom:2.5rem;flex-wrap:wrap;}
.filter-btn{padding:.45rem 1.2rem;font-size:.73rem;letter-spacing:1px;text-transform:uppercase;font-family:var(--font-sans);border:1px solid var(--border);background:transparent;color:var(--text);cursor:pointer;transition:var(--transition);}
.filter-btn.active,.filter-btn:hover{background:var(--gold);border-color:var(--gold);color:#fff;}
.gallery-grid{columns:4;gap:4px;}
.gallery-item{break-inside:avoid;margin-bottom:4px;overflow:hidden;position:relative;cursor:pointer;}
.gallery-item img{width:100%;display:block;transition:transform .5s;filter:brightness(.88);}
.gallery-item:hover img{transform:scale(1.05);filter:brightness(1);}
.gitem-ov{position:absolute;inset:0;background:rgba(201,168,76,0);display:flex;align-items:center;justify-content:center;transition:.4s;}
.gallery-item:hover .gitem-ov{background:rgba(201,168,76,.22);}
.gitem-ov i{font-size:1.8rem;color:#fff;opacity:0;transform:scale(0);transition:.3s;}
.gallery-item:hover .gitem-ov i{opacity:1;transform:scale(1);}

/* LIGHTBOX */
#lightbox{display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.96);align-items:center;justify-content:center;}
#lightbox.open{display:flex;}
#lightbox img{max-width:90vw;max-height:85vh;object-fit:contain;}
#lb-close{position:absolute;top:1.5rem;right:1.5rem;width:44px;height:44px;border-radius:50%;background:var(--gold);color:#fff;border:none;cursor:pointer;font-size:1.1rem;display:flex;align-items:center;justify-content:center;}
#lb-prev,#lb-next{position:absolute;top:50%;transform:translateY(-50%);width:50px;height:50px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);color:#fff;font-size:1.2rem;cursor:pointer;border-radius:50%;display:flex;align-items:center;justify-content:center;transition:.3s;}
#lb-prev:hover,#lb-next:hover{background:var(--gold);border-color:var(--gold);}
#lb-prev{left:2rem;}#lb-next{right:2rem;}

/* ====================== SERVICES ====================== */
#services{background:var(--bg);}
.services-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5px;margin-top:3rem;}
.svc-card{background:var(--card-bg);border:1px solid var(--border);padding:2.5rem 2rem;position:relative;overflow:hidden;transition:var(--transition);}
.svc-card::after{content:'';position:absolute;bottom:0;left:0;width:0;height:2px;background:var(--gold);transition:width .4s;}
.svc-card:hover{transform:translateY(-4px);box-shadow:0 22px 55px rgba(0,0,0,.3);}
.svc-card:hover::after{width:100%;}
.svc-icon{width:54px;height:54px;border-radius:50%;border:1px solid var(--gold);display:flex;align-items:center;justify-content:center;margin-bottom:1.5rem;color:var(--gold);font-size:1.3rem;transition:var(--transition);}
.svc-card:hover .svc-icon{background:var(--gold);color:#fff;}
.svc-card h3{font-size:1.08rem;margin-bottom:.7rem;}
.svc-card p{font-size:.83rem;color:var(--text-muted);line-height:1.7;margin-bottom:1.2rem;}
.svc-link{font-size:.72rem;letter-spacing:1px;text-transform:uppercase;color:var(--gold);font-weight:600;display:inline-flex;align-items:center;gap:6px;}
.svc-link i{transition:transform .3s;}
.svc-link:hover i{transform:translateX(5px);}

/* ====================== PROCESS ====================== */
#process{background:var(--bg-2);}
.process-steps{display:grid;grid-template-columns:repeat(5,1fr);margin-top:3rem;position:relative;}
.process-steps::before{content:'';position:absolute;top:43px;left:10%;right:10%;height:1px;background:linear-gradient(90deg,transparent,var(--gold),transparent);z-index:0;}
.proc-step{text-align:center;padding:2rem 1rem;position:relative;z-index:1;}
.proc-num{width:54px;height:54px;border-radius:50%;background:var(--gold);color:#fff;display:flex;align-items:center;justify-content:center;font-family:var(--font-serif);font-size:1.2rem;font-weight:700;margin:0 auto 1.2rem;box-shadow:0 0 0 8px var(--bg-2);}
.proc-step h3{font-family:var(--font-sans);font-size:.88rem;font-weight:600;margin-bottom:.5rem;}
.proc-step p{font-size:.76rem;color:var(--text-muted);line-height:1.5;}

/* ====================== TESTIMONIALS ====================== */
#testimonials{background:var(--dark);position:relative;overflow:hidden;padding:6rem 2.5rem;}
[data-theme="light"] #testimonials{background:var(--light-2);}
#testimonials::before{content:'"';position:absolute;top:-2rem;left:4%;z-index:0;font-family:var(--font-serif);font-size:18rem;color:var(--gold);opacity:.04;line-height:1;}
.testimonials-swiper{position:relative;z-index:1;}
.testi-slide{padding:1rem 2.5rem;}
.testi-card{background:var(--card-bg);border:1px solid var(--border);padding:2.5rem;}
.testi-stars{color:var(--gold);font-size:.85rem;margin-bottom:1.2rem;letter-spacing:2px;}
.testi-card p{font-size:.95rem;line-height:1.8;color:var(--text-muted);font-style:italic;margin-bottom:1.5rem;}
.testi-author{display:flex;align-items:center;gap:12px;}
.testi-avatar{width:46px;height:46px;border-radius:50%;background:var(--gold);display:flex;align-items:center;justify-content:center;font-family:var(--font-serif);color:#fff;font-size:1.05rem;}
.testi-author h4{font-family:var(--font-sans);font-size:.88rem;font-weight:600;}
.testi-author span{font-size:.72rem;color:var(--text-muted);}

/* ====================== SOCIAL FEED ====================== */
#social-feed{background:var(--bg-2);padding:4rem 2.5rem;}
.social-tabs{display:flex;gap:1rem;margin-bottom:2rem;}
.social-tab{padding:.45rem 1.4rem;border-radius:50px;border:1px solid var(--border);background:transparent;color:var(--text);cursor:pointer;font-family:var(--font-sans);font-size:.8rem;font-weight:500;transition:var(--transition);display:flex;align-items:center;gap:8px;}
.social-tab.active{background:var(--gold);border-color:var(--gold);color:#fff;}
.social-post{background:var(--card-bg);border:1px solid var(--border);overflow:hidden;cursor:pointer;}
.social-post-img{aspect-ratio:1;overflow:hidden;}
.social-post-img img{width:100%;height:100%;object-fit:cover;transition:transform .5s;}
.social-post:hover .social-post-img img{transform:scale(1.06);}
.social-post-info{padding:1rem;}
.social-post-info .platform{font-size:.68rem;color:var(--gold);font-weight:600;letter-spacing:1px;margin-bottom:.4rem;}
.social-post-info p{font-size:.8rem;color:var(--text-muted);line-height:1.5;}

/* ====================== MAP ====================== */
#map-section{background:var(--bg);padding:5rem 2.5rem;}
.map-wrap{display:grid;grid-template-columns:1fr 2fr;gap:3.5rem;align-items:start;}
.map-info h2{font-size:2rem;margin-bottom:1rem;}
.map-info p{color:var(--text-muted);font-size:.88rem;line-height:1.75;margin-bottom:2rem;}
.map-details{display:flex;flex-direction:column;gap:1rem;}
.map-detail{display:flex;gap:12px;align-items:flex-start;}
.map-detail i{color:var(--gold);font-size:.95rem;margin-top:3px;flex-shrink:0;}
.map-detail span{font-size:.83rem;color:var(--text-muted);line-height:1.6;}
#map-container{height:500px;overflow:hidden;border:1px solid var(--border);position:relative;}
.map-video-ov{position:absolute;bottom:1rem;right:1rem;background:rgba(0,0,0,.82);border:1px solid var(--gold);padding:.75rem 1rem;cursor:pointer;color:#fff;display:flex;align-items:center;gap:8px;font-size:.76rem;transition:.3s;}
.map-video-ov:hover{background:var(--gold);}
.map-video-ov i{color:var(--gold);}
.map-video-ov:hover i{color:#fff;}
.lf-marker-wrap{width:38px;height:38px;border-radius:999px;background:linear-gradient(135deg,#2faa4a 0%,#1e7c35 100%);display:flex;align-items:center;justify-content:center;box-shadow:0 10px 26px rgba(0,0,0,.35);border:2px solid rgba(255,255,255,.38);}
.lf-marker-wrap i{color:#fff;font-size:17px;}
.leaflet-popup-content-wrapper{border-radius:10px;}
.leaflet-popup-content{margin:12px;}

/* ====================== BLOG ====================== */
#blog{background:var(--bg-2);}
#cms-pages-content{background:var(--bg-2);}
.cms-page-block{background:var(--card-bg);border:1px solid var(--border);padding:clamp(1.5rem,4vw,3rem);margin-bottom:1.5rem;}
.cms-page-content{color:var(--text-muted);line-height:1.8;}
.cms-page-content :where(h1,h2,h3,h4,h5,h6){color:var(--text);line-height:1.15;margin:0 0 1rem;}
.cms-page-content :where(p,ul,ol,blockquote,figure){margin:0 0 1rem;}
.cms-page-content :where(img,video,iframe){max-width:100%;border-radius:4px;}
.blog-grid{display:grid;grid-template-columns:2fr 1fr 1fr;gap:2px;margin-top:3rem;}
.blog-card{background:var(--card-bg);overflow:hidden;border:1px solid var(--border);}
.blog-card-img{overflow:hidden;}
.blog-card-img img{width:100%;transition:transform .5s;}
.blog-card:hover .blog-card-img img{transform:scale(1.05);}
.blog-card-body{padding:1.5rem;}
.blog-meta{display:flex;gap:1rem;margin-bottom:.8rem;}
.blog-meta span{font-size:.68rem;color:var(--text-muted);letter-spacing:1px;text-transform:uppercase;}
.blog-meta .cat{color:var(--gold);font-weight:600;}
.blog-card h3{font-size:1.08rem;margin-bottom:.6rem;line-height:1.3;}
.blog-card p{font-size:.8rem;color:var(--text-muted);line-height:1.6;margin-bottom:1rem;}
.blog-more{font-size:.7rem;letter-spacing:1px;text-transform:uppercase;color:var(--gold);font-weight:600;display:inline-flex;align-items:center;gap:6px;}
.blog-more i{transition:transform .3s;}
.blog-more:hover i{transform:translateX(5px);}
.blog-card.featured .blog-card-img img{height:300px;object-fit:cover;}
.blog-card:not(.featured) .blog-card-img img{height:175px;object-fit:cover;}

/* ====================== CTA BANNER ====================== */
#cta-banner{position:relative;overflow:hidden;background:var(--dark);padding:5.5rem 2.5rem;}
.cta-bg{position:absolute;inset:0;z-index:0;background-image:url('https://prestigeboisrond.ca/wp-content/uploads/2025/07/bg-dji.jpg');background-size:cover;background-position:center;opacity:.2;}
.cta-inner{position:relative;z-index:1;text-align:center;max-width:720px;margin:0 auto;}
.cta-inner h2{font-size:clamp(2rem,4vw,3.6rem);color:#fff;margin-bottom:1rem;}
.cta-inner p{color:rgba(255,255,255,.68);font-size:.98rem;margin-bottom:2.5rem;}
.cta-btns{display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;}

/* ====================== CONTACT ====================== */
#contact{background:var(--bg);}
.contact-grid{display:grid;grid-template-columns:1fr 1fr;gap:5rem;}
.form-group{margin-bottom:1.5rem;}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;}
.form-group label{display:block;font-size:.68rem;letter-spacing:1px;text-transform:uppercase;font-weight:600;margin-bottom:6px;color:var(--gold);}
.form-group input,.form-group textarea,.form-group select{width:100%;background:var(--card-bg);border:1px solid var(--border);color:var(--text);padding:.82rem 1rem;font-family:var(--font-sans);font-size:.88rem;transition:border-color .3s;outline:none;}
.form-group input:focus,.form-group textarea:focus,.form-group select:focus{border-color:var(--gold);}
.form-group textarea{resize:vertical;min-height:130px;}
.form-group select option{background:var(--dark-3);}
.contact-card{background:var(--card-bg);border:1px solid var(--border);border-left:3px solid var(--gold);padding:1.5rem;margin-bottom:1rem;display:flex;gap:1rem;align-items:flex-start;}
.contact-card i{color:var(--gold);font-size:1.1rem;margin-top:2px;}
.contact-card h4{font-family:var(--font-sans);font-size:.83rem;font-weight:600;margin-bottom:3px;}
.contact-card p{font-size:.8rem;color:var(--text-muted);}
.social-links{display:flex;gap:.8rem;margin-top:2rem;}
.social-link{width:42px;height:42px;border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--text);font-size:.95rem;transition:var(--transition);}
.social-link:hover{background:var(--gold);border-color:var(--gold);color:#fff;}

/* ====================== FOOTER ====================== */
footer{background:#050505;color:rgba(255,255,255,.55);padding:4.5rem 2.5rem 2rem;}
.footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:3rem;max-width:1340px;margin:0 auto;}
.footer-brand .logo-text{color:#fff;margin-bottom:1rem;}
.footer-brand p{font-size:.83rem;line-height:1.75;margin-bottom:1.5rem;}
.footer-col h4{color:#fff;font-family:var(--font-sans);font-size:.78rem;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;margin-bottom:1.2rem;}
.footer-col ul{list-style:none;}
.footer-col ul li{margin-bottom:.6rem;}
.footer-col ul li a{font-size:.8rem;transition:color .2s;}
.footer-col ul li a:hover{color:var(--gold);}
.footer-bottom{border-top:1px solid rgba(255,255,255,.04);margin-top:3rem;padding-top:1.5rem;max-width:1340px;margin-left:auto;margin-right:auto;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;}
.footer-bottom p{font-size:.75rem;}
.footer-bottom-links{display:flex;gap:1.5rem;}
.footer-bottom-links a{font-size:.75rem;transition:color .2s;}
.footer-bottom-links a:hover{color:var(--gold);}

/* ====================== RESPONSIVE ====================== */
@media(max-width:1100px){
  .footer-grid{grid-template-columns:1fr 1fr;}
  .about-grid{grid-template-columns:1fr;gap:3rem;}
  .contact-grid{grid-template-columns:1fr;}
  .map-wrap{grid-template-columns:1fr;}
  .services-grid{grid-template-columns:1fr 1fr;}
  .blog-grid{grid-template-columns:1fr 1fr;}
}
@media(max-width:768px){
  .nav-links,.btn-nav-cta{display:none;}
  .hamburger{display:flex;}
  .theme-btn{display:none;}
  .nav-inner{
    padding:0 1rem;
    justify-content:center;
    position:relative;
    width:100%;
  }
  .logo{
    width:100%;
    justify-content:center;
    margin:0 auto;
  }
  .logo-wide{
    width:min(200px,70vw);
    max-width:200px;
  }
  .nav-actions{
    position:absolute;
    right:1rem;
    top:50%;
    transform:translateY(-50%);
    margin:0;
  }
  .hero-content{
    margin:0 auto;
    padding:0 1.5rem;
    max-width:680px;
    text-align:center;
  }
  .hero-eyebrow{
    justify-content:center;
  }
  .hero-btns{
    justify-content:center;
  }
  section{padding:4rem 1.5rem;}
  .products-grid{grid-template-columns:1fr;}
  .gallery-grid{columns:2;}
  .hero-stats{display:none;}
  .stats-grid{grid-template-columns:1fr 1fr;}
  .form-row{grid-template-columns:1fr;}
  .process-steps{grid-template-columns:1fr;}
  .process-steps::before{display:none;}
  #hero{
    margin-top:var(--hero-top-offset);
    height:calc(100vh - var(--hero-top-offset));
    min-height:560px;
  }
}
</style>
</head>
<body>

@include('home-v2.components.Header')

<div class="cursor" id="cursor"></div>
<div class="cursor-ring" id="cursorRing"></div>

<!-- LIGHTBOX -->
<div id="lightbox">
  <button id="lb-close"><i class="fa fa-times"></i></button>
  <button id="lb-prev"><i class="fa fa-chevron-left"></i></button>
  <img id="lb-img" src="" alt="">
  <button id="lb-next"><i class="fa fa-chevron-right"></i></button>
</div>

<!-- VIDEO MODAL -->
<div id="videoModal" style="display:none;position:fixed;inset:0;z-index:9000;background:rgba(0,0,0,.96);align-items:center;justify-content:center;">
  <button onclick="closeVideo()" style="position:absolute;top:1.5rem;right:1.5rem;background:var(--gold);border:none;color:#fff;width:44px;height:44px;border-radius:50%;font-size:1.1rem;cursor:pointer;display:flex;align-items:center;justify-content:center;"><i class="fa fa-times"></i></button>
  <iframe id="videoFrame" width="900" height="506" src="" frameborder="0" allow="autoplay;encrypted-media" allowfullscreen style="max-width:95vw;max-height:85vh;border:1px solid var(--border)"></iframe>
</div>

<!-- NAVBAR -->
<nav id="navbar">
  <div class="nav-inner">
    <div class="logo">
      @if($hasWideLogo)
        <img class="logo-wide" src="{{ $logoUrl }}" alt="{{ $siteNameDisplay }}">
      @else
        <div class="logo-text">{{ $siteNameDisplay }} <span>{{ $siteDescription }}</span></div>
      @endif
    </div>
    <ul class="nav-links">
      <li>
        <a href="#products">Maisons & Chalets ▾</a>
        <ul class="dropdown">
          <li><a href="#products">Tous nos modèles</a></li>
          <li><a href="#products">Série Prestige</a></li>
          <li><a href="#products">Série Scandinave</a></li>
          <li><a href="#products">Série Contemporaine</a></li>
          <li><a href="#products">Maison en bois rond</a></li>
          <li><a href="#products">Chalet en bois rond</a></li>
        </ul>
      </li>
      <li>
        <a href="#services">Services ▾</a>
        <ul class="dropdown">
          <li><a href="#services">Plans</a></li>
          <li><a href="#services">Soutien technique</a></li>
          <li><a href="#services">Auto-construction</a></li>
          <li><a href="#services">Surveillance de chantier</a></li>
          <li><a href="#services">Ajouts et rénovations</a></li>
          <li><a href="#services">Transport</a></li>
        </ul>
      </li>
      <li><a href="#gallery">Réalisations</a></li>
      <li><a href="#about">À propos</a></li>
      <li><a href="#blog">Blogue</a></li>
      <li><a href="#contact">Contact</a></li>
    </ul>
    <div class="nav-actions">
      <button class="theme-btn" id="themeToggle" title="Changer de thème"><i class="fa fa-sun" id="themeIcon"></i></button>
      <a href="{{ $devisLink }}" class="btn-nav-cta" target="_blank" rel="noopener noreferrer">Soumission gratuite</a>
      <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
    </div>
  </div>
</nav>

<!-- MOBILE NAV -->
<div class="mobile-nav" id="mobileNav">
  <ul class="mobile-nav-links">
    <li><a href="#products" onclick="closeMobileNav()">Maisons & Chalets</a></li>
    <li><a href="#services" onclick="closeMobileNav()">Services</a></li>
    <li><a href="#gallery" onclick="closeMobileNav()">Réalisations</a></li>
    <li><a href="#about" onclick="closeMobileNav()">À propos</a></li>
    <li><a href="#blog" onclick="closeMobileNav()">Blogue</a></li>
    <li><a href="#contact" onclick="closeMobileNav()">Contact</a></li>
    <li><a href="{{ $devisLink }}" target="_blank" rel="noopener noreferrer" onclick="closeMobileNav()" style="color:var(--gold);font-weight:600">Soumission gratuite</a></li>
  </ul>
</div>

<!-- ==================== HERO ==================== -->
    @include('cms::web.fallback.partials.landing-cms-header')
@if(is_slider_enabled($etablissement->id))
@if(has_slider($etablissement->id))
{!! get_slider_html($etablissement->id) !!}
@else
<section id="hero">
  <div class="swiper hero-swiper" id="heroSwiper">
    <div class="swiper-wrapper">
      @foreach($heroSlides as $index => $slide)
        <div class="swiper-slide hero-slide">
          <div class="hero-media">
            @if(($slide['type'] ?? 'image') === 'video')
              @if(($slide['video_type'] ?? '') === 'upload')
                <video autoplay muted loop playsinline preload="metadata" poster="{{ $slide['thumb'] ?? $slide['media_url'] }}">
                  <source src="{{ $slide['video_embed_url'] ?? $slide['media_url'] }}">
                </video>
              @else
                <iframe src="{{ ($slide['video_embed_url'] ?? $slide['media_url']) . (str_contains((string) ($slide['video_embed_url'] ?? $slide['media_url']), '?') ? '&' : '?') . 'autoplay=1&mute=1&loop=1&background=1&controls=0' }}" title="Slide vidéo" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
              @endif
            @else
              <img src="{{ $slide['media_url'] }}" alt="{{ $slide['title'] }}">
            @endif
          </div>
          <div class="hero-content">
            <div class="hero-eyebrow">{{ $heroEyebrow }}</div>
            <h1>{{ $slide['title'] }}</h1>
            <p>{{ $slide['subtitle'] }}</p>
            <div class="hero-btns">
              @if(!empty($slide['button_text']) && !empty($slide['button_url']))
                <a href="{{ $slide['button_url'] }}" class="btn-primary" target="_blank" rel="noopener noreferrer">{{ $slide['button_text'] }}</a>
              @endif
              @if(!empty($heroSecondaryCtaText) && !empty($heroSecondaryCtaUrl))
                <a href="{{ $heroSecondaryCtaUrl }}" class="btn-ghost">{{ $heroSecondaryCtaText }}</a>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="swiper-pagination" style="bottom:1.5rem;left:5%;width:auto;text-align:left;z-index:4;"></div>

    @if($heroStats->isNotEmpty())
      <div class="hero-stats">
        @foreach($heroStats as $stat)
          <div class="hero-stat"><span class="num">{{ $stat['value'] }}</span><span class="lbl">{{ $stat['label'] }}</span></div>
        @endforeach
      </div>
    @endif

    <div class="hero-scroll"><i class="fa fa-chevron-down"></i><span>Défiler</span></div>

    <div class="hero-selector" id="heroSelector">
      @foreach($heroSlides as $index => $slide)
        <div class="hsel-card {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}" onclick="heroSelectCard(this,{{ $index }})">
          <div class="hsel-thumb">
            <img src="{{ $slide['thumb'] ?? $slide['media_url'] }}" alt="Slide {{ $index + 1 }}">
            <span class="hsel-num">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
            <div class="hsel-progress"></div>
          </div>
          <div class="hsel-body">
            <div class="hsel-icon"><i class="fa {{ ['fa-crown','fa-layer-group','fa-snowflake','fa-gem','fa-star'][$index % 5] }}"></i></div>
            <div class="hsel-info">
              <span class="hsel-tag">Slide {{ $index + 1 }}</span>
              <h4>{{ $slide['title'] }}</h4>
              <p>{{ \Illuminate\Support\Str::limit($slide['subtitle'], 60) }}</p>
            </div>
            <i class="fa fa-arrow-right hsel-arrow"></i>
          </div>
        </div>
      @endforeach
    </div>

  </div>
</section>
@endif
@endif

@if(collect($cmsPageSections ?? [])->isNotEmpty())
<section id="cms-pages-content">
  <div class="container">
    @foreach(collect($cmsPageSections) as $cmsPage)
      <article class="cms-page-block reveal" id="cms-page-{{ \Illuminate\Support\Str::slug(data_get($cmsPage, 'slug') ?: data_get($cmsPage, 'title') ?: $loop->iteration) }}">
        <div class="cms-page-content">
          {!! data_get($cmsPage, 'content') !!}
        </div>
      </article>
    @endforeach
  </div>
</section>
@endif

<!-- STATS -->
<section id="stats">
  <div class="stats-grid">
    <div class="stat-item reveal"><span class="num">100+</span><span class="lbl">Réalisations complétées</span></div>
    <div class="stat-item reveal delay-1"><span class="num">25+</span><span class="lbl">Années d'expertise</span></div>
    <div class="stat-item reveal delay-2"><span class="num">3</span><span class="lbl">Séries exclusives</span></div>
    <div class="stat-item reveal delay-3"><span class="num">∞</span><span class="lbl">Possibilités sur mesure</span></div>
  </div>
</section>

<!-- ABOUT -->
<section id="about">
  <div class="container">
    <div class="about-grid">
      <div class="about-img-wrap reveal">
        <img src="https://prestigeboisrond.ca/wp-content/uploads/2025/09/DSC06735-HDR.jpg" alt="Maison bois rond Prestige" class="about-img-main">
        <div class="about-badge"><span class="big">25+</span><span class="small">Années d'excellence</span></div>
      </div>
      <div class="reveal delay-1">
        <div class="sec-eyebrow">Notre histoire</div>
        <h2 class="sec-title">Une <em style="font-style:italic;color:var(--gold)">passion</em> pour le bois massif</h2>
        <p style="color:var(--text-muted);line-height:1.85;margin-bottom:1.5rem">Chez Prestige Bois Rond, chaque maison et chalet que nous concevons est l\'expression d'une passion profonde pour le bois massif et d'un engagement constant envers l'excellence artisanale.</p>
        <p style="color:var(--text-muted);line-height:1.85;margin-bottom:2rem">Fondée au Québec, notre entreprise accompagne ses clients de la conception jusqu'à la livraison, en offrant un service personnalisé et un savoir-faire exceptionnel reconnu à travers la province.</p>
        <div class="about-feats">
          <div class="feat-item"><i class="fa fa-leaf"></i><div><h4>Matériaux durables</h4><p>Bois massif sélectionné pour sa qualité et sa durabilité.</p></div></div>
          <div class="feat-item"><i class="fa fa-tools"></i><div><h4>Artisanat expert</h4><p>Chaque pièce usinée avec précision par nos artisans.</p></div></div>
          <div class="feat-item"><i class="fa fa-snowflake"></i><div><h4>Normes énergétiques</h4><p>Conformes aux plus hautes normes d'efficacité.</p></div></div>
          <div class="feat-item"><i class="fa fa-handshake"></i><div><h4>Accompagnement complet</h4><p>De la conception jusqu'à la livraison, avec vous.</p></div></div>
        </div>
        <div style="margin-top:2.5rem"><a href="#contact" class="btn-primary">Parlez-nous de votre projet</a></div>
      </div>
    </div>
  </div>
</section>

<!-- PRODUCTS -->
@if(!empty($showFallbackProducts) && !$cmsHasLiveProducts)
<section id="products">
  <div class="container">
    <div class="products-hdr reveal">
      <div>
        <div class="sec-eyebrow">Nos collections</div>
        <h2 class="sec-title">Produits <span class="text-gold">Vedette</span></h2>
      </div>
      <a href="#gallery" class="btn-outline" style="border-color:var(--gold);color:var(--gold)">Voir tout</a>
    </div>
    <div class="products-grid">
      <div class="product-card reveal">
        <img src="https://prestigeboisrond.ca/wp-content/uploads/2025/09/DSC06735-HDR.jpg" alt="Série Prestige">
        <div class="product-overlay">
          <span class="product-tag">Série Prestige</span>
          <h3>Luxe & Durabilité</h3>
          <p>Habitations en bois rond alliant luxe, confort et savoir-faire exceptionnel.</p>
          <a href="#" class="product-link">Découvrir <i class="fa fa-arrow-right"></i></a>
        </div>
      </div>
      <div class="product-card reveal delay-1">
        <img src="https://prestigeboisrond.ca/wp-content/uploads/2025/09/SaveInsta.App_327015499_693241832530188_5777615420000727358_n.jpg" alt="Série Scandinave">
        <div class="product-overlay">
          <span class="product-tag">Série Scandinave</span>
          <h3>Charme Nordique</h3>
          <p>Alliant charme rustique et design épuré, fabriqués avec passion.</p>
          <a href="#" class="product-link">Explorer <i class="fa fa-arrow-right"></i></a>
        </div>
      </div>
      <div class="product-card reveal delay-2">
        <img src="https://prestigeboisrond.ca/wp-content/uploads/2025/09/DJI_0237.jpg" alt="Série Contemporaine">
        <div class="product-overlay">
          <span class="product-tag">Série Contemporaine</span>
          <h3>Hybride Moderne</h3>
          <p>Un mariage parfait entre design moderne et charme du bois rond.</p>
          <a href="#" class="product-link">Découvrir <i class="fa fa-arrow-right"></i></a>
        </div>
      </div>
      <div class="product-card reveal delay-3">
        <img src="https://prestigeboisrond.ca/wp-content/uploads/2025/09/IMG-20250628-WA0010.jpg" alt="Ajouts et rénovations">
        <div class="product-overlay">
          <span class="product-tag">Services</span>
          <h3>Ajouts & Rénovations</h3>
          <p>Agrandissements et rénovations en bois massif adaptés à vos besoins.</p>
          <a href="#" class="product-link">En savoir plus <i class="fa fa-arrow-right"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>
@endif

@include('cms::web.fallback.partials.establishment-products', [
  'etablissement' => $etablissement,
  'devisLink' => $devisLink,
  'cmsProductsTitle' => "Produits à vendre de l'établissement",
  'cmsProductsSubtitle' => "Maisons, chalets, services ou offres configurés dans le catalogue de cet établissement.",
  'cmsProductsSectionId' => 'products',
])

<!-- VIDEO -->
<section id="video-section">
  <div class="container">
    <div class="sec-eyebrow" style="justify-content:center">Notre univers</div>
    <h2 class="sec-title" style="text-align:center;margin-bottom:.5rem">Visitez nos <span class="text-gold">réalisations</span></h2>
    <p style="text-align:center;color:var(--text-muted);margin-bottom:0">Découvrez l'artisanat et la passion derrière chaque projet Prestige Bois Rond.</p>
    <div class="video-wrap reveal">
      <img src="https://prestigeboisrond.ca/wp-content/uploads/2025/07/bg-dji.jpg" alt="Vidéo" class="video-thumb">
      <button class="video-play" onclick="openVideo()"><i class="fa fa-play"></i></button>
    </div>
  </div>
</section>

<!-- GALLERY -->
<section id="gallery">
  <div class="container">
    <div class="sec-eyebrow reveal">Galerie photos</div>
    <h2 class="sec-title reveal">Nos <span class="text-gold">Réalisations</span></h2>
    <p class="sec-sub reveal" style="margin-bottom:2rem">Parcourez notre galerie et laissez-vous inspirer par l\'authenticité et la beauté de nos constructions.</p>
    <div class="gallery-filter reveal">
      <button class="filter-btn active" data-filter="all">Tout</button>
      <button class="filter-btn" data-filter="prestige">Prestige</button>
      <button class="filter-btn" data-filter="scandinave">Scandinave</button>
      <button class="filter-btn" data-filter="contemporain">Contemporain</button>
    </div>
    <div class="gallery-grid" id="galleryGrid">
      @foreach($galleryItems as $index => $item)
        <div class="gallery-item" data-cat="{{ $galleryCats[$index % count($galleryCats)] }}">
          <img src="{{ $item['thumbnail'] }}" alt="{{ $item['name'] }}" loading="lazy">
          <div class="gitem-ov"><i class="fa fa-expand"></i></div>
        </div>
      @endforeach
    </div>
    <div style="text-align:center;margin-top:2.5rem"><a href="{{ $devisLink }}" target="_blank" rel="noopener noreferrer" class="btn-primary">Voir toutes nos réalisations</a></div>
  </div>
</section>

<!-- SERVICES -->
<section id="services">
  <div class="container">
    <div class="sec-eyebrow reveal">Ce que nous offrons</div>
    <h2 class="sec-title reveal">Nos <span class="text-gold">Services</span></h2>
    <p class="sec-sub reveal">Un accompagnement complet du début à la fin de votre projet.</p>
    <div class="services-grid">
      <div class="svc-card reveal"><div class="svc-icon"><i class="fa fa-drafting-compass"></i></div><h3>Plans & Conception</h3><p>Nos architectes et techniciens créent des plans sur mesure adaptés à votre terrain, votre style et votre budget.</p><a href="#" class="svc-link">En savoir plus <i class="fa fa-arrow-right"></i></a></div>
      <div class="svc-card reveal delay-1"><div class="svc-icon"><i class="fa fa-hard-hat"></i></div><h3>Surveillance de chantier</h3><p>Notre équipe supervise chaque étape de votre construction pour garantir qualité et conformité aux normes.</p><a href="#" class="svc-link">En savoir plus <i class="fa fa-arrow-right"></i></a></div>
      <div class="svc-card reveal delay-2"><div class="svc-icon"><i class="fa fa-hammer"></i></div><h3>Auto-construction</h3><p>Envie de participer à la construction de votre rêve ? Nous vous fournissons les kits, documents et l'assistance nécessaires.</p><a href="#" class="svc-link">En savoir plus <i class="fa fa-arrow-right"></i></a></div>
      <div class="svc-card reveal"><div class="svc-icon"><i class="fa fa-home"></i></div><h3>Ajouts & Rénovations</h3><p>Peu importe l'ampleur de vos rénovations en bois massif, nous avons la solution adaptée à vos besoins.</p><a href="#" class="svc-link">En savoir plus <i class="fa fa-arrow-right"></i></a></div>
      <div class="svc-card reveal delay-1"><div class="svc-icon"><i class="fa fa-truck"></i></div><h3>Transport</h3><p>Ne vous cassez pas la tête — nous nous occupons de la livraison de votre structure partout au Québec.</p><a href="#" class="svc-link">En savoir plus <i class="fa fa-arrow-right"></i></a></div>
      <div class="svc-card reveal delay-2"><div class="svc-icon"><i class="fa fa-headset"></i></div><h3>Soutien technique</h3><p>Notre équipe d'experts est disponible pour répondre à toutes vos questions techniques tout au long du projet.</p><a href="#" class="svc-link">En savoir plus <i class="fa fa-arrow-right"></i></a></div>
    </div>
  </div>
</section>

<!-- PROCESS -->
<section id="process">
  <div class="container">
    <div class="sec-eyebrow reveal" style="justify-content:center">Étapes du projet</div>
    <h2 class="sec-title reveal" style="text-align:center">Comment ça <span class="text-gold">fonctionne</span></h2>
    <div class="process-steps">
      <div class="proc-step reveal"><div class="proc-num">1</div><h3>Consultation</h3><p>Discussion de vos besoins, budget et style de vie pour définir votre projet idéal.</p></div>
      <div class="proc-step reveal delay-1"><div class="proc-num">2</div><h3>Conception</h3><p>Élaboration des plans et soumission personnalisée selon vos spécifications.</p></div>
      <div class="proc-step reveal delay-2"><div class="proc-num">3</div><h3>Fabrication</h3><p>Usinage précis de votre structure en bois rond dans nos installations au Québec.</p></div>
      <div class="proc-step reveal delay-3"><div class="proc-num">4</div><h3>Livraison</h3><p>Transport et livraison de votre kit directement sur votre terrain.</p></div>
      <div class="proc-step reveal delay-4"><div class="proc-num">5</div><h3>Emménagement</h3><p>Votre maison de rêve est prête. Bienvenue dans votre nouveau chez-vous!</p></div>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section id="testimonials">
  <div class="container">
    <div class="sec-eyebrow reveal" style="justify-content:center">Avis clients</div>
    <h2 class="sec-title reveal" style="text-align:center">Ce que nos clients <span class="text-gold">disent</span></h2>
    <div class="swiper testimonials-swiper" style="margin-top:3rem;padding:1rem 0 3rem">
      <div class="swiper-wrapper">
        <div class="swiper-slide testi-slide"><div class="testi-card"><div class="testi-stars">★★★★★</div><p>"Prestige Bois Rond a réalisé le chalet de nos rêves. Du premier contact jusqu'à la livraison, l'équipe a été professionnelle, à l'écoute et d'une précision remarquable. Le résultat dépasse toutes nos attentes."</p><div class="testi-author"><div class="testi-avatar">ML</div><div><h4>Marie-Lise Tremblay</h4><span>Laurentides, Québec • Série Prestige</span></div></div></div></div>
        <div class="swiper-slide testi-slide"><div class="testi-card"><div class="testi-stars">★★★★★</div><p>"Nous avons opté pour l'auto-construction avec le soutien de Prestige Bois Rond. L'accompagnement était exceptionnel! Ils ont répondu à chacune de nos questions avec patience et expertise. Notre maison est magnifique!"</p><div class="testi-author"><div class="testi-avatar">PL</div><div><h4>Pierre & Lucie Bergeron</h4><span>Lanaudière, Québec • Auto-construction</span></div></div></div></div>
        <div class="swiper-slide testi-slide"><div class="testi-card"><div class="testi-stars">★★★★★</div><p>"La qualité du bois et le soin apporté à chaque détail est impressionnant. Notre chalet scandinave est une pure merveille — chaleureux l'hiver, frais l'été. On recommande Prestige Bois Rond à 100%!"</p><div class="testi-author"><div class="testi-avatar">JF</div><div><h4>Jean-François Côté</h4><span>Estrie, Québec • Série Scandinave</span></div></div></div></div>
        <div class="swiper-slide testi-slide"><div class="testi-card"><div class="testi-stars">★★★★★</div><p>"Notre maison contemporaine hybride est à la fois moderne et chaleureuse. Le service après-vente est également irréprochable. Une équipe passionnée et compétente de bout en bout."</p><div class="testi-author"><div class="testi-avatar">SB</div><div><h4>Sophie Beaumont</h4><span>Charlevoix, Québec • Série Contemporaine</span></div></div></div></div>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
</section>

<!-- SOCIAL FEED -->
<section id="social-feed">
  <div class="container">
    <div class="sec-eyebrow reveal">Suivez-nous</div>
    <h2 class="sec-title reveal">Nos <span class="text-gold">Médias Sociaux</span></h2>
    <div class="social-tabs reveal" style="margin-top:1.5rem">
      <button class="social-tab active" data-social="instagram"><i class="fab fa-instagram"></i> Instagram</button>
      <button class="social-tab" data-social="facebook"><i class="fab fa-facebook"></i> Facebook</button>
      <button class="social-tab" data-social="pinterest"><i class="fab fa-pinterest"></i> Pinterest</button>
    </div>
    <div class="swiper social-swiper" style="margin-top:1.5rem;padding-bottom:3rem">
      <div class="swiper-wrapper" id="socialFeed"></div>
      <div class="swiper-pagination"></div>
    </div>
    @if(!empty($socialLinks))
      <div style="text-align:center;margin-top:1rem">
        @foreach($socialLinks as $link)
          <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer" class="{{ $loop->first ? 'btn-primary' : 'btn-outline' }}" style="{{ $loop->first ? 'margin-right:1rem' : 'border-color:var(--gold);color:var(--gold);margin-right:1rem' }}"><i class="{{ $link['icon'] }}"></i> {{ $link['label'] }}</a>
        @endforeach
      </div>
    @endif
  </div>
</section>

<!-- MAP -->
@include('cms::web.fallback.partials.landing-map-video-points')

<!-- BLOG -->
@if(is_blog_enabled($etablissement->id))
<section id="blog">
  <div class="container">
    <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:3rem">
      <div><div class="sec-eyebrow reveal">Actualités</div><h2 class="sec-title reveal">Blogue & <span class="text-gold">Nouvelles</span></h2></div>
      <a href="#" class="btn-outline reveal" style="border-color:var(--gold);color:var(--gold)">Tous les articles</a>
    </div>
    @php
      $constructionBlogFallback = collect([
        ['title' => "Les avantages du bois rond massif : pourquoi c'est le meilleur choix pour votre chalet", 'excerpt' => 'Découvrez pourquoi de plus en plus de Québécois choisissent le bois rond pour leur résidence secondaire ou principale.', 'image' => 'https://prestigeboisrond.ca/wp-content/uploads/2025/09/DSC06735-HDR.jpg', 'tag' => 'Construction', 'date' => '15 avril 2025', 'reading_time' => 4, 'url' => '#blog'],
        ['title' => "Série Scandinave : l'art de vivre nordique au Québec", 'excerpt' => 'Notre nouvelle série scandinave apporte le meilleur du design nordique.', 'image' => 'https://prestigeboisrond.ca/wp-content/uploads/2025/09/SaveInsta.App_327015499_693241832530188_5777615420000727358_n.jpg', 'tag' => 'Design', 'date' => '2 mars 2025', 'reading_time' => 3, 'url' => '#blog'],
        ['title' => "Auto-construction : guide complet pour réussir votre projet", 'excerpt' => "Tout ce que vous devez savoir avant de vous lancer dans l'auto-construction.", 'image' => 'https://prestigeboisrond.ca/wp-content/uploads/2025/09/DJI_0237.jpg', 'tag' => 'Conseils', 'date' => '18 fév 2025', 'reading_time' => 5, 'url' => '#blog'],
      ]);
      $constructionBlogs = collect($blogPosts ?? [])->take(3)->values()->map(function ($post, $index) use ($constructionBlogFallback) {
        $fallback = $constructionBlogFallback->get($index, $constructionBlogFallback->first());
        return [
          'title' => data_get($post, 'title') ?: data_get($fallback, 'title'),
          'excerpt' => data_get($post, 'excerpt') ?: data_get($fallback, 'excerpt'),
          'image' => data_get($post, 'image') ?: data_get($fallback, 'image'),
          'tag' => data_get($post, 'tag') ?: data_get($fallback, 'tag'),
          'date' => data_get($post, 'date') ?: data_get($fallback, 'date'),
          'url' => data_get($post, 'url') ?: '#blog',
        ];
      });
      if ($constructionBlogs->isEmpty()) {
        $constructionBlogs = $constructionBlogFallback;
      }
    @endphp
    <div class="blog-grid">
      @foreach($constructionBlogs as $blog)
        @php
          $blogUrl = data_get($blog, 'url') ?: '#blog';
          $isExternalBlogUrl = !\Illuminate\Support\Str::startsWith($blogUrl, '#');
          $blogTargetAttrs = $isExternalBlogUrl ? ' target="_blank" rel="noopener noreferrer"' : '';
        @endphp
        <div class="blog-card{{ $loop->first ? ' featured' : '' }} reveal{{ $loop->iteration === 2 ? ' delay-1' : ($loop->iteration === 3 ? ' delay-2' : '') }}">
          <div class="blog-card-img"><img src="{{ data_get($blog, 'image') }}" alt="{{ data_get($blog, 'title') }}"></div>
          <div class="blog-card-body">
            <div class="blog-meta"><span class="cat">{{ data_get($blog, 'tag') }}</span><span>{{ data_get($blog, 'date') }}</span></div>
            <h3>{{ data_get($blog, 'title') }}</h3>
            <p>{{ data_get($blog, 'excerpt') }}</p>
            <a href="{{ $blogUrl }}" class="blog-more"{!! $blogTargetAttrs !!}>Lire l'article <i class="fa fa-arrow-right"></i></a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- CTA BANNER -->
<section id="cta-banner">
  <div class="cta-bg"></div>
  <div class="cta-inner reveal">
    <div class="sec-eyebrow" style="justify-content:center;color:#fff;opacity:.7">Passez à l'action</div>
    <h2>Bâtissez votre projet<br>de <em style="color:var(--gold);font-style:italic">rêve</em> avec nous</h2>
    <p>Des projets pour tous les budgets. Accompagnement sur-mesure du début à la fin. Contactez-nous dès aujourd'hui.</p>
    <div class="cta-btns">
      <a href="{{ $devisLink }}" target="_blank" rel="noopener noreferrer" class="btn-primary">Obtenir une soumission gratuite</a>
      <a href="tel:{{ $phoneHref }}" class="btn-ghost">{{ $phone }}</a>
    </div>
  </div>
</section>

<!-- CONTACT -->
@include('cms::web.fallback.partials.landing-working-hours')

<section id="contact">
  <div class="container">
    <div class="contact-grid">
      <div class="reveal">
        <div class="sec-eyebrow">Contactez-nous</div>
        <h2 style="font-family:var(--font-serif);font-size:2.2rem;margin-bottom:.5rem">Parlez-nous de votre <span class="text-gold">projet</span></h2>
        <p style="color:var(--text-muted);font-size:.88rem;margin-bottom:2rem">Remplissez le formulaire ci-dessous et notre équipe vous contactera dans les 24 heures.</p>
        <form method="POST" action="{{ route('cms.company.contact.send', ['etablissementId' => $etablissement->id]) }}" data-cms-contact-form data-cms-form-name="landing_immobilier_construction">
          @csrf
          <div class="form-row">
            <div class="form-group"><label>Prénom</label><input type="text" name="first_name" placeholder="Votre prénom" required></div>
            <div class="form-group"><label>Nom</label><input type="text" name="last_name" placeholder="Votre nom" required></div>
          </div>
          <div class="form-row">
            <div class="form-group"><label>Courriel</label><input type="email" name="email" placeholder="votre@email.com" required></div>
            <div class="form-group"><label>Téléphone</label><input type="tel" name="phone" placeholder="(438) 000-0000"></div>
          </div>
          <div class="form-group">
            <label>Série d'intérêt</label>
            <select name="service"><option value="">Sélectionnez une série</option><option>Série Prestige</option><option>Série Scandinave</option><option>Série Contemporaine (Hybride)</option><option>Ajouts & Rénovations</option><option>Autre</option></select>
          </div>
          <div class="form-group"><label>Message</label><textarea name="message" placeholder="Décrivez votre projet : superficie souhaitée, terrain, budget approximatif..." required></textarea></div>
          <button type="submit" class="btn-primary" style="width:100%;padding:1rem;font-size:.85rem;border:none;cursor:pointer">Envoyer ma demande <i class="fa fa-arrow-right" style="margin-left:8px"></i></button>
        </form>
      </div>
      <div class="reveal delay-1">
        <h3 style="font-family:var(--font-serif);font-size:1.5rem;margin-bottom:1.5rem">Informations de contact</h3>
        <div class="contact-card"><i class="fa fa-phone-alt"></i><div><h4>Téléphone</h4><p><a href="tel:{{ $phoneHref }}" style="color:var(--gold)">{{ $phone }}</a></p></div></div>
        <div class="contact-card"><i class="fa fa-envelope"></i><div><h4>Courriel</h4><p><a href="mailto:{{ $email }}" style="color:var(--gold)">{{ $email }}</a></p></div></div>
        <div class="contact-card"><i class="fa fa-map-marker-alt"></i><div><h4>Localisation</h4><p>{{ $address }}</p></div></div>
        <div class="contact-card"><i class="fa fa-clock"></i><div><h4>Heures d'ouverture</h4><p>@foreach($workingHours as $row){{ !empty($row['day']) ? $row['day'] . ' : ' : '' }}{{ $row['hours'] ?? '' }}@if(!$loop->last)<br>@endif @endforeach</p></div></div>
        @if(!empty($socialLinks))
        <div style="margin-top:2rem">
          <h4 style="font-family:var(--font-sans);font-size:.75rem;letter-spacing:2.5px;text-transform:uppercase;margin-bottom:1rem;color:var(--gold)">Suivez-nous</h4>
          <div class="social-links">
            @foreach($socialLinks as $link)
              <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="{{ $link['label'] }}"><i class="{{ $link['icon'] }}"></i></a>
            @endforeach
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</section>
@include('cms::web.fallback.partials.landing-media-slideshow')
@include('cms::web.fallback.partials.landing-contact-ajax')

<!-- FOOTER -->
@include('cms::web.fallback.partials.landing-cms-footer')
<footer>
  <div class="footer-grid">
    <div class="footer-brand">
      <div class="logo" style="margin-bottom:1rem">
        @if($hasWideLogo)
          <img class="logo-wide" src="{{ $logoUrl }}" alt="{{ $siteNameDisplay }}">
        @else
          <div class="logo-text" style="color:#fff">{{ $siteNameDisplay }} <span>{{ $address }}</span></div>
        @endif
      </div>
      <p>Chaque maison et chalet que nous concevons est l\'expression d'une passion pour le bois massif et d'un engagement constant envers l'excellence artisanale.</p>
      <div style="display:grid;gap:.55rem;margin:1rem 0 1.2rem;color:rgba(255,255,255,.72);font-size:.86rem">
        <a href="tel:{{ $phoneHref }}" style="display:inline-flex;align-items:center;gap:.65rem;color:var(--gold)">
          <i class="fa fa-phone-alt"></i> {{ $phone }}
        </a>
        <a href="mailto:{{ $email }}" style="display:inline-flex;align-items:center;gap:.65rem;color:var(--gold)">
          <i class="fa fa-envelope"></i> {{ $email }}
        </a>
      </div>
      @if(!empty($socialLinks))
        <div class="social-links">
          @foreach($socialLinks as $link)
            <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="{{ $link['label'] }}"><i class="{{ $link['icon'] }}"></i></a>
          @endforeach
        </div>
      @endif
    </div>
    <div class="footer-col"><h4>Maisons & Chalets</h4><ul><li><a href="#">Tous nos modèles</a></li><li><a href="#">Série Prestige</a></li><li><a href="#">Série Scandinave</a></li><li><a href="#">Série Contemporaine</a></li><li><a href="#">Maison en bois rond</a></li><li><a href="#">Chalet en bois rond</a></li></ul></div>
    <div class="footer-col"><h4>Services</h4><ul><li><a href="#">Plans</a></li><li><a href="#">Soutien technique</a></li><li><a href="#">Auto-construction</a></li><li><a href="#">Surveillance chantier</a></li><li><a href="#">Ajouts & rénovations</a></li><li><a href="#">Transport</a></li></ul></div>
    <div class="footer-col"><h4>À propos</h4><ul><li><a href="#">Notre histoire</a></li><li><a href="#">Avantages</a></li><li><a href="#">Normes énergétiques</a></li><li><a href="#">Réalisations</a></li><li><a href="#">Blogue</a></li><li><a href="#">FAQ</a></li><li><a href="#">Contact</a></li></ul></div>
  </div>
  <div class="footer-bottom">
    <p>© {{ date('Y') }} {{ $siteNameDisplay }}. Tous droits réservés.</p>
    <div class="footer-bottom-links"><a href="#">Confidentialité</a><a href="#">Conditions</a><a href="#">Plan du site</a></div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="{{ asset('js/home-v2/carousel.js') }}"></script>
<script src="{{ asset('js/home-v2/navigation.js') }}"></script>
<script src="{{ asset('js/home-v2/menu-api-service.js') }}"></script>
<script src="{{ asset('js/home-v2/mega-menu-service.js') }}"></script>
<script src="{{ asset('js/home-v2/vertical-menu-dynamic.js') }}"></script>
<script src="{{ asset('js/home-v2/vertical-menu.js') }}"></script>
<script src="{{ asset('js/home-v2/vertical-destinations-mega.js') }}"></script>
<script src="{{ asset('js/home-v2/mega-menu.js') }}"></script>
<script src="{{ asset('js/home-v2/destinations-mega-menu.js') }}"></script>
<script src="{{ asset('js/home-v2/destinations-search.js') }}"></script>
<script src="{{ asset('js/home-v2/search-bar.js') }}"></script>
<script src="{{ asset('js/home-v2/videos-dropdown.js') }}"></script>
<script src="{{ asset('js/home-v2/slideshows.js') }}"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
/* ============ STACKED HEADERS OFFSET ============ */
function syncHeaderStackOffsets() {
  const globalHeader = document.querySelector('.header-v2');
  const templateNavbar = document.getElementById('navbar');
  const globalHeight = globalHeader ? Math.max(0, Math.ceil(globalHeader.offsetHeight || 0)) : 0;
  const navbarHeight = templateNavbar ? Math.ceil(templateNavbar.offsetHeight || 78) : 78;
  const heroOffset = globalHeight + navbarHeight;

  document.documentElement.style.setProperty('--global-header-offset', `${globalHeight}px`);
  document.documentElement.style.setProperty('--template-header-height', `${navbarHeight}px`);
  document.documentElement.style.setProperty('--hero-top-offset', `${heroOffset}px`);
}

syncHeaderStackOffsets();
window.addEventListener('DOMContentLoaded', syncHeaderStackOffsets);
window.addEventListener('load', syncHeaderStackOffsets);
window.addEventListener('resize', syncHeaderStackOffsets);
if ('ResizeObserver' in window) {
  const globalHeader = document.querySelector('.header-v2');
  const templateNavbar = document.getElementById('navbar');
  const headerResizeObserver = new ResizeObserver(syncHeaderStackOffsets);
  if (globalHeader) headerResizeObserver.observe(globalHeader);
  if (templateNavbar) headerResizeObserver.observe(templateNavbar);
}

/* ============ THEME ============ */
const themeToggle = document.getElementById('themeToggle');
const themeIcon   = document.getElementById('themeIcon');
let isDark = true;
themeToggle.addEventListener('click', () => {
  isDark = !isDark;
  document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
  themeIcon.className = isDark ? 'fa fa-sun' : 'fa fa-moon';
});

/* ============ CURSOR ============ */
const cursor = document.getElementById('cursor');
const cursorRing = document.getElementById('cursorRing');
let mx=0,my=0,fx=0,fy=0;
document.addEventListener('mousemove', e => { mx=e.clientX; my=e.clientY; });
function animCursor(){
  cursor.style.left=mx+'px'; cursor.style.top=my+'px';
  fx+=(mx-fx)*.1; fy+=(my-fy)*.1;
  cursorRing.style.left=fx+'px'; cursorRing.style.top=fy+'px';
  requestAnimationFrame(animCursor);
}
animCursor();
document.querySelectorAll('a,button,.product-card,.gallery-item,.hsel-card').forEach(el=>{
  el.addEventListener('mouseenter',()=>{cursor.style.width='16px';cursor.style.height='16px';cursorRing.style.width='52px';cursorRing.style.height='52px';});
  el.addEventListener('mouseleave',()=>{cursor.style.width='8px';cursor.style.height='8px';cursorRing.style.width='32px';cursorRing.style.height='32px';});
});

/* ============ HERO SWIPER ============ */
const heroSwiperEl = document.querySelector('#heroSwiper');
const heroSwiper = heroSwiperEl ? new Swiper('#heroSwiper', {
  loop: true, speed: 1200,
  autoplay: { delay: 6000, disableOnInteraction: false },
  effect: 'fade',
  fadeEffect: { crossFade: true },
  pagination: { el: '.hero-swiper .swiper-pagination', clickable: true },
  on: {
    slideChange() {
      const realIdx = this.realIndex;
      syncHeroSelector(realIdx);
    }
  }
}) : null;

/* ============ HERO SELECTOR ============ */
function heroSelectCard(card, slideIdx) {
  document.querySelectorAll('.hsel-card').forEach(c => c.classList.remove('active'));
  card.classList.add('active');
  if (heroSwiper) {
    heroSwiper.slideToLoop(slideIdx, 800);
  }
}

function syncHeroSelector(realIdx) {
  document.querySelectorAll('.hsel-card').forEach(c => {
    const si = parseInt(c.dataset.slide);
    c.classList.toggle('active', si === realIdx);
  });
}

/* ============ TESTIMONIALS SWIPER ============ */
new Swiper('.testimonials-swiper', {
  loop: true, speed: 800,
  autoplay: { delay: 5000 },
  slidesPerView: 1, spaceBetween: 24,
  breakpoints: { 768: { slidesPerView: 2 }, 1200: { slidesPerView: 3 } },
  pagination: { el: '.testimonials-swiper .swiper-pagination', clickable: true }
});

/* ============ SOCIAL FEED ============ */
const socialImages = @json($socialImages);
const socialCaptions = [
  'Notre dernière réalisation en Série Prestige — l\'art du bois rond au sommet 🏡 #PrestigeBoisRond',
  'Chalet scandinave livré cette semaine! Merci à nos clients pour leur confiance ❤️ #BoisRond',
  'Vue de drone sur notre plus récente construction contemporaine #Québec #Chalet',
  'Avant/Après: transformation magnifique avec nos services d\'ajout et rénovation 🔨',
  'Notre équipe d\'experts sur le chantier — la qualité avant tout! #Artisanat',
  'Auto-construction réussie! Nos clients ont bâti leur rêve avec notre soutien 💪',
];
const socialPlat = {
  instagram: { label: 'Instagram', icon: 'fab fa-instagram' },
  facebook:  { label: 'Facebook',  icon: 'fab fa-facebook'  },
  pinterest: { label: 'Pinterest', icon: 'fab fa-pinterest' },
};
let socialSwiperInst;
function renderSocialFeed(platform) {
  const feed = document.getElementById('socialFeed');
  const images = socialImages[platform] || socialImages.instagram || [];
  feed.innerHTML = images.map((img, i) => `
    <div class="swiper-slide">
      <div class="social-post">
        <div class="social-post-img"><img src="${img}" alt="Post social" loading="lazy"></div>
        <div class="social-post-info">
          <div class="platform"><i class="${socialPlat[platform].icon}"></i> ${socialPlat[platform].label}</div>
          <p>${socialCaptions[i % socialCaptions.length]}</p>
        </div>
      </div>
    </div>
  `).join('');
  if (socialSwiperInst) socialSwiperInst.destroy(true, true);
  socialSwiperInst = new Swiper('.social-swiper', {
    loop: false, speed: 700,
    slidesPerView: 2, spaceBetween: 16,
    autoplay: { delay: 4000 },
    breakpoints: { 768: { slidesPerView: 3 }, 1024: { slidesPerView: 4 } },
    pagination: { el: '.social-swiper .swiper-pagination', clickable: true }
  });
}
renderSocialFeed('instagram');
document.querySelectorAll('.social-tab').forEach(tab => {
  tab.addEventListener('click', () => {
    document.querySelectorAll('.social-tab').forEach(t => t.classList.remove('active'));
    tab.classList.add('active');
    renderSocialFeed(tab.dataset.social);
  });
});

/* ============ GALLERY FILTER ============ */
document.querySelectorAll('.filter-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const filter = btn.dataset.filter;
    document.querySelectorAll('.gallery-item').forEach(item => {
      const show = filter === 'all' || item.dataset.cat === filter;
      item.style.opacity = show ? '1' : '0';
      item.style.display = show ? 'block' : 'none';
    });
  });
});

/* ============ LIGHTBOX ============ */
const galleryImgs = Array.from(document.querySelectorAll('.gallery-item img')).map(i => i.src);
let lbIdx = 0;
document.querySelectorAll('.gallery-item').forEach((item, idx) => {
  item.addEventListener('click', () => {
    lbIdx = idx;
    document.getElementById('lb-img').src = galleryImgs[idx];
    document.getElementById('lightbox').classList.add('open');
    document.body.style.overflow = 'hidden';
  });
});
document.getElementById('lb-close').onclick = () => { document.getElementById('lightbox').classList.remove('open'); document.body.style.overflow = ''; };
document.getElementById('lb-prev').onclick = () => { lbIdx=(lbIdx-1+galleryImgs.length)%galleryImgs.length; document.getElementById('lb-img').src=galleryImgs[lbIdx]; };
document.getElementById('lb-next').onclick = () => { lbIdx=(lbIdx+1)%galleryImgs.length; document.getElementById('lb-img').src=galleryImgs[lbIdx]; };
document.getElementById('lightbox').addEventListener('click', e => { if(e.target===document.getElementById('lightbox')){ document.getElementById('lightbox').classList.remove('open'); document.body.style.overflow=''; } });

/* ============ VIDEO ============ */
function openVideo(){
  document.getElementById('videoFrame').src='https://www.youtube.com/embed/2AOSbHozuzY?autoplay=1';
  document.getElementById('videoModal').style.display='flex';
  document.body.style.overflow='hidden';
}
function closeVideo(){
  document.getElementById('videoFrame').src='';
  document.getElementById('videoModal').style.display='none';
  document.body.style.overflow='';
}

/* ============ LEAFLET MAP ============ */
let immoMap = null;
let immoMapMarker = null;

function initImmoMap() {
  if (!window.L || !document.getElementById('immoLeafletMap') || immoMap) return;

  const lat = {{ $mapLat }};
  const lng = {{ $mapLng }};
  const exactAddress = @json($mapAddress);

  immoMap = L.map('immoLeafletMap', {
    zoomControl: true,
    scrollWheelZoom: false
  }).setView([lat, lng], 15);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(immoMap);

  const markerIcon = L.divIcon({
    className: 'lf-marker',
    html: '<div class="lf-marker-wrap"><i class="fas fa-seedling"></i></div>',
    iconSize: [38, 38],
    iconAnchor: [19, 36]
  });

  const mapVideoHtml = `
    <div style="width:320px;max-width:100%;">
      <div style="font-weight:700;margin-bottom:8px;">{{ addslashes($siteNameDisplay) }}</div>
      <div style="font-size:12px;color:#666;margin-bottom:10px;">${exactAddress}</div>
      <iframe
        width="320"
        height="180"
        src="{{ $mapVideoEmbedUrl }}"
        title="Vidéo sur la carte"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen
        style="display:block;width:100%;border-radius:8px;">
      </iframe>
    </div>
  `;

  immoMapMarker = L.marker([lat, lng], { icon: markerIcon })
    .addTo(immoMap)
    .bindPopup(mapVideoHtml, { maxWidth: 360, minWidth: 260 });

  setTimeout(() => immoMap.invalidateSize(), 250);
}

function openMapVideoPopup() {
  if (!immoMap || !immoMapMarker) return;
  immoMap.setView(immoMapMarker.getLatLng(), 16, { animate: true });
  immoMapMarker.openPopup();
}

/* ============ MOBILE NAV ============ */
const hamburger = document.getElementById('hamburger');
const mobileNav = document.getElementById('mobileNav');
let mobileOpen = false;
hamburger.addEventListener('click', () => {
  mobileOpen = !mobileOpen;
  mobileNav.classList.toggle('open', mobileOpen);
  document.body.style.overflow = mobileOpen ? 'hidden' : '';
});
function closeMobileNav(){ mobileOpen=false; mobileNav.classList.remove('open'); document.body.style.overflow=''; }

/* ============ SCROLL REVEAL ============ */
const revealObs = new IntersectionObserver(entries => {
  entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => revealObs.observe(el));

/* ============ NAVBAR SCROLL ============ */
window.addEventListener('scroll', () => {
  document.getElementById('navbar').style.boxShadow = window.scrollY > 50 ? '0 5px 30px rgba(0,0,0,.35)' : 'none';
});

/* ============ CONTACT FORM ============ */
function handleSubmit(e){
  e.preventDefault();
  const btn = e.target.querySelector('button[type=submit]');
  btn.textContent = '✓ Message envoyé! Nous vous contacterons bientôt.';
  btn.style.background = '#2C4234'; btn.style.borderColor = '#2C4234';
  setTimeout(() => { btn.textContent = 'Envoyer ma demande'; btn.style.background = ''; btn.style.borderColor = ''; e.target.reset(); }, 4000);
}

/* ============ COUNTER ANIMATION ============ */
function animCounter(el, target){
  let c=0; const step=target/60;
  const t=setInterval(()=>{c+=step; if(c>=target){el.textContent=target+'+';clearInterval(t);}else{el.textContent=Math.floor(c)+'+';}},30);
}
const statsObs = new IntersectionObserver(entries=>{
  entries.forEach(e=>{
    if(e.isIntersecting){
      e.target.querySelectorAll('.num').forEach(n=>{
        if(n.textContent.includes('100'))animCounter(n,100);
        else if(n.textContent.includes('25'))animCounter(n,25);
      });
      statsObs.unobserve(e.target);
    }
  });
},{threshold:.5});
const statsSection=document.getElementById('stats');
if(statsSection)statsObs.observe(statsSection);
window.addEventListener('load', initImmoMap);
</script>
    @include('cms::web.fallback.partials.landing-cart-drawer')
    @include('cms::web.fallback.partials.landing-back-to-top')
</body>
</html>



