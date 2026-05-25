@php
    $siteName = get_site_name($etablissement->id) ?: ($etablissement->name ?? 'Go Exploria Next Level');
    $siteDescription = $etablissement->getSetting('description', null, 'general')
        ?: $etablissement->getSetting('site_description', null, 'general')
        ?: get_site_description($etablissement->id)
        ?: 'Des expériences de voyage uniques et inoubliables pour passer au niveau supérieur.';

    $mediaUrl = static function ($path) {
        if (empty($path)) return null;
        if (is_array($path)) $path = data_get($path, 'url') ?: data_get($path, 'thumbnail') ?: data_get($path, 0);
        $path = trim((string) $path);
        if ($path === '') return null;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '//'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, ['/storage/'])) return asset(ltrim($path, '/'));
        if (\Illuminate\Support\Str::startsWith($path, ['storage/'])) return asset($path);
        if (\Illuminate\Support\Str::startsWith($path, ['/'])) return asset(ltrim($path, '/'));
        return asset('storage/' . ltrim($path, '/'));
    };

    $heroEmbedUrl = static function ($value) {
        $raw = trim((string) $value);
        if ($raw === '') return null;
        if (preg_match('/<iframe[^>]+src=["\']([^"\']+)["\']/i', $raw, $match)) {
            $raw = trim((string) $match[1]);
        }
        $videoId = null;
        $host = (string) parse_url($raw, PHP_URL_HOST);
        $path = (string) parse_url($raw, PHP_URL_PATH);
        if (str_contains($host, 'youtu.be')) {
            $videoId = trim($path, '/');
        } elseif (str_contains($host, 'youtube.com')) {
            parse_str((string) parse_url($raw, PHP_URL_QUERY), $query);
            if (!empty($query['v'])) $videoId = (string) $query['v'];
            elseif (preg_match('#/(embed|shorts)/([^/?]+)#', $path, $match)) $videoId = $match[2];
        }
        if ($videoId) {
            return 'https://www.youtube.com/embed/' . $videoId . '?autoplay=1&mute=1&muted=1&loop=1&playlist=' . $videoId . '&controls=0&rel=0&modestbranding=1&playsinline=1';
        }
        if (str_contains($host, 'youtube.com') || str_contains($host, 'vimeo.com')) {
            return $raw . (str_contains($raw, '?') ? '&' : '?') . 'autoplay=1&mute=1&muted=1&loop=1&controls=0&rel=0&playsinline=1';
        }
        return $raw;
    };

    $heroSlides = collect($sliders ?? [])->map(function ($slider) use ($mediaUrl, $heroEmbedUrl, $siteName, $siteDescription) {
        $type = strtolower((string) data_get($slider, 'type', 'image'));
        $url = $mediaUrl(data_get($slider, 'image_url') ?: data_get($slider, 'thumbnail_url') ?: data_get($slider, 'video_url') ?: data_get($slider, 'url') ?: data_get($slider, 'image_path'));
        $embed = $heroEmbedUrl(data_get($slider, 'video_embed_url') ?: data_get($slider, 'embed') ?: ($type === 'iframe' ? data_get($slider, 'url') : null));
        return [
            'type' => $type,
            'url' => $url,
            'embed' => $embed,
            'title' => data_get($slider, 'title') ?: 'EXPLORE LE MONDE AUTREMENT',
            'subtitle' => data_get($slider, 'subtitle') ?: data_get($slider, 'description') ?: $siteDescription,
            'button_text' => data_get($slider, 'button_text') ?: 'Nos Voyages',
            'button_url' => data_get($slider, 'button_url') ?: data_get($slider, 'button_link') ?: '#services',
        ];
    })->filter(fn ($slide) => !empty($slide['url']) || !empty($slide['embed']))->values();

    if ($heroSlides->isEmpty()) {
        $heroSlides = collect([
            ['type' => 'image', 'url' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=1920&q=80', 'embed' => null, 'title' => 'EXPLORE LE MONDE AUTREMENT', 'subtitle' => 'Des expériences de voyage uniques et inoubliables, conçues pour les esprits curieux qui cherchent à repousser leurs limites.', 'button_text' => 'Nos Voyages', 'button_url' => '#services'],
            ['type' => 'image', 'url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1920&q=80', 'embed' => null, 'title' => 'ATTEINS TON NEXT LEVEL', 'subtitle' => 'Trekking en altitude, camps de base, randonnées alpines. Chaque sommet est une nouvelle victoire sur soi-même.', 'button_text' => 'Demander un devis', 'button_url' => '#contact'],
            ['type' => 'image', 'url' => 'https://images.unsplash.com/photo-1530789253388-582c481c54b0?w=1920&q=80', 'embed' => null, 'title' => 'VIS DES ÉMOTIONS RARES', 'subtitle' => 'Bivouacs sous les étoiles, dunes infinies, rencontres authentiques. Des moments qui marquent une vie entière.', 'button_text' => 'Découvrir', 'button_url' => '#services'],
        ]);
    }

    $youtubeIdFromUrl = static function ($value) {
        $raw = trim((string) $value);
        if ($raw === '') return null;
        if (preg_match('/<iframe[^>]+src=["\']([^"\']+)["\']/i', $raw, $match)) {
            $raw = trim((string) $match[1]);
        }
        $host = (string) parse_url($raw, PHP_URL_HOST);
        $path = (string) parse_url($raw, PHP_URL_PATH);
        if (str_contains($host, 'youtu.be')) return trim($path, '/');
        if (str_contains($host, 'youtube.com')) {
            parse_str((string) parse_url($raw, PHP_URL_QUERY), $query);
            if (!empty($query['v'])) return (string) $query['v'];
            if (preg_match('#/(embed|shorts)/([^/?]+)#', $path, $match)) return $match[2];
        }
        return null;
    };

    $mapQuery = collect();
    try {
        if (class_exists(\App\Models\MapPoint::class) && \Illuminate\Support\Facades\Schema::hasTable('map_points')) {
            $baseMapQuery = \App\Models\MapPoint::with(['videos'])
                ->active()
                ->whereNotNull('latitude')
                ->whereNotNull('longitude');

            $mapQuery = (clone $baseMapQuery)
                ->where('etablissement_id', $etablissement->id)
                ->limit(80)
                ->get();

            if ($mapQuery->isEmpty()) {
                $mapQuery = $baseMapQuery
                    ->orderByDesc('is_featured')
                    ->latest('updated_at')
                    ->limit(80)
                    ->get();
            }
        }
    } catch (\Throwable $e) {
        $mapQuery = collect();
    }

    $nextLevelMapPoints = $mapQuery->map(function ($point) use ($youtubeIdFromUrl) {
        $video = optional($point->videos->first());
        $youtubeId = $point->youtube_id ?: $video->youtube_id ?: $youtubeIdFromUrl($point->youtube_url ?: $video->youtube_url);
        $youtubeId = $youtubeId ?: 'MfAAJgCzOAs';

        return [
            'title' => $point->title ?: 'Point Go Exploria',
            'description' => \Illuminate\Support\Str::limit(strip_tags((string) $point->description), 160),
            'category' => strtolower((string) ($point->category ?: 'autre')),
            'lat' => (float) $point->latitude,
            'lng' => (float) $point->longitude,
            'address' => $point->adresse ?: trim(collect([$point->ville, $point->code_postal])->filter()->implode(' ')) ?: 'Québec, Canada',
            'video_embed' => 'https://www.youtube.com/embed/' . $youtubeId . '?autoplay=1&mute=1&muted=1&playsinline=1&rel=0&modestbranding=1',
        ];
    })->values();

    if ($nextLevelMapPoints->isEmpty()) {
        $nextLevelMapPoints = collect([
            [
                'title' => 'Go Exploria — Québec',
                'description' => 'Découvrez nos points d’intérêt et expériences vidéo.',
                'category' => 'tourism',
                'lat' => 46.8139,
                'lng' => -71.2080,
                'address' => 'Québec, Canada',
                'video_embed' => 'https://www.youtube.com/embed/MfAAJgCzOAs?autoplay=1&mute=1&muted=1&playsinline=1&rel=0&modestbranding=1',
            ],
        ]);
    }

    $heroTitleParts = static function ($title) {
        $words = preg_split('/\s+/', trim((string) $title));
        if (!$words || count($words) < 2) return e($title);
        $last = array_pop($words);
        return e(implode(' ', $words)) . ' <span class="gold">' . e($last) . '</span>';
    };
@endphp<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($siteDescription), 155) }}">
<title>{{ $siteName }} | Next Level</title>
<link rel="canonical" href="{{ url()->current() }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,700;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<style>

:root {
  --gold: #C9A84C;
  --gold-light: #E8C876;
  --dark: #0a0a0a;
  --dark2: #111111;
  --dark3: #1a1a1a;
  --dark4: #242424;
  --text: #f0ede6;
  --muted: #888;
  --accent: #2ed8a8;
  --radius: 16px;
  --transition: all 0.45s cubic-bezier(0.23, 1, 0.32, 1);
}
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
html { scroll-behavior: smooth; }
body { background: var(--dark); color: var(--text); font-family: 'Outfit', sans-serif; overflow-x: hidden; }

/* ─── SCROLLBAR ─── */
::-webkit-scrollbar { width: 4px; }
::-webkit-scrollbar-track { background: var(--dark); }
::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 2px; }

/* ─── NAVBAR ─── */
nav {
  position: fixed; top: 0; width: 100%; z-index: 999;
  padding: 18px 40px;
  display: flex; align-items: center; justify-content: space-between;
  background: linear-gradient(to bottom, rgba(0,0,0,0.85) 0%, transparent 100%);
  backdrop-filter: blur(0px);
  transition: var(--transition);
}
nav.scrolled {
  background: rgba(10,10,10,0.95);
  backdrop-filter: blur(20px);
  padding: 12px 40px;
  border-bottom: 1px solid rgba(201,168,76,0.15);
}
.nav-logo { display: flex; flex-direction: column; line-height: 1; }
.nav-logo span:first-child { font-family: 'Bebas Neue'; font-size: 28px; color: var(--gold); letter-spacing: 3px; }
.nav-logo span:last-child { font-size: 10px; letter-spacing: 8px; color: var(--text); opacity: 0.6; text-transform: uppercase; }
.nav-links { display: flex; gap: 32px; list-style: none; }
.nav-links a { color: var(--text); text-decoration: none; font-size: 13px; letter-spacing: 2px; text-transform: uppercase; opacity: 0.75; transition: var(--transition); position: relative; }
.nav-links a::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 1px; background: var(--gold); transition: var(--transition); }
.nav-links a:hover { opacity: 1; color: var(--gold); }
.nav-links a:hover::after { width: 100%; }
.nav-cta { background: var(--gold); color: var(--dark); padding: 10px 24px; border-radius: 50px; font-size: 13px; font-weight: 600; letter-spacing: 1px; text-decoration: none; transition: var(--transition); }
.nav-cta:hover { background: var(--gold-light); transform: translateY(-2px); box-shadow: 0 8px 30px rgba(201,168,76,0.4); }
.hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; }
.hamburger span { width: 26px; height: 2px; background: var(--text); transition: var(--transition); }
.mobile-menu { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100vh; background: var(--dark); z-index: 998; flex-direction: column; align-items: center; justify-content: center; gap: 32px; }
.mobile-menu.open { display: flex; }
.mobile-menu a { color: var(--text); text-decoration: none; font-size: 24px; font-family: 'Bebas Neue'; letter-spacing: 4px; transition: var(--transition); }
.mobile-menu a:hover { color: var(--gold); }

/* ─── HERO ─── */
#hero { position: relative; height: 100vh; overflow: hidden; }
.hero-swiper { width: 100%; height: 100%; }
.hero-swiper .swiper-slide { position: relative; overflow: hidden; }
.hero-slide-bg {
  position: absolute; inset: 0;
  background-size: cover; background-position: center;
  transform: scale(1.08);
  transition: transform 8s ease;
}
.swiper-slide-active .hero-slide-bg { transform: scale(1); }
.hero-slide-bg video { width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; }
.hero-overlay { position: absolute; inset: 0; background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 60%, rgba(0,0,0,0.5) 100%); }
.hero-content {
  position: absolute; bottom: 15%; left: 8%; z-index: 10;
  max-width: 700px;
}
.hero-tag { display: inline-block; background: rgba(201,168,76,0.2); border: 1px solid var(--gold); color: var(--gold); font-size: 11px; letter-spacing: 4px; text-transform: uppercase; padding: 6px 16px; border-radius: 50px; margin-bottom: 20px; }
.hero-title { font-family: 'Bebas Neue'; font-size: clamp(60px, 10vw, 120px); line-height: 0.9; color: var(--text); text-shadow: 0 4px 40px rgba(0,0,0,0.5); }
.hero-title .gold { color: var(--gold); }
.hero-sub { font-size: 16px; color: rgba(255,255,255,0.7); margin: 20px 0 36px; max-width: 480px; line-height: 1.7; font-weight: 300; }
.hero-btns { display: flex; gap: 16px; flex-wrap: wrap; }
.btn-primary { background: var(--gold); color: var(--dark); padding: 14px 32px; border-radius: 50px; font-weight: 700; font-size: 14px; letter-spacing: 1px; text-decoration: none; transition: var(--transition); display: inline-flex; align-items: center; gap: 8px; }
.btn-primary:hover { background: var(--gold-light); transform: translateY(-3px); box-shadow: 0 12px 40px rgba(201,168,76,0.5); }
.btn-outline { border: 1px solid rgba(255,255,255,0.5); color: var(--text); padding: 14px 32px; border-radius: 50px; font-size: 14px; letter-spacing: 1px; text-decoration: none; transition: var(--transition); display: inline-flex; align-items: center; gap: 8px; }
.btn-outline:hover { border-color: var(--gold); color: var(--gold); transform: translateY(-3px); }
.hero-stats { position: absolute; bottom: 12%; right: 8%; z-index: 10; display: flex; gap: 40px; }
.stat { text-align: center; }
.stat-num { font-family: 'Bebas Neue'; font-size: 42px; color: var(--gold); line-height: 1; }
.stat-label { font-size: 11px; letter-spacing: 2px; opacity: 0.6; text-transform: uppercase; margin-top: 4px; }
.hero-swiper .swiper-pagination-bullet { background: var(--gold); opacity: 0.4; width: 6px; height: 6px; }
.hero-swiper .swiper-pagination-bullet-active { opacity: 1; width: 24px; border-radius: 3px; }
.scroll-hint { position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); z-index: 10; display: flex; flex-direction: column; align-items: center; gap: 8px; }
.scroll-hint span { font-size: 10px; letter-spacing: 3px; opacity: 0.5; text-transform: uppercase; }
.scroll-line { width: 1px; height: 50px; background: linear-gradient(to bottom, var(--gold), transparent); animation: scrollpulse 2s ease-in-out infinite; }
@keyframes scrollpulse { 0%,100%{opacity:0.3;transform:scaleY(1)} 50%{opacity:1;transform:scaleY(0.6)} }

/* ─── SECTIONS COMMON ─── */
section { padding: 100px 40px; }
.section-label { font-size: 11px; letter-spacing: 5px; color: var(--gold); text-transform: uppercase; margin-bottom: 12px; }
.section-title { font-family: 'Bebas Neue'; font-size: clamp(36px, 6vw, 72px); line-height: 1; margin-bottom: 20px; }
.section-title span { color: var(--gold); }
.section-sub { font-size: 15px; color: var(--muted); max-width: 560px; line-height: 1.8; margin-bottom: 60px; }
.container { max-width: 1400px; margin: 0 auto; }

/* ─── MARQUEE ─── */
.marquee-wrap { background: var(--gold); overflow: hidden; padding: 16px 0; }
.marquee-track { display: flex; gap: 0; animation: marquee 20s linear infinite; white-space: nowrap; }
.marquee-item { font-family: 'Bebas Neue'; font-size: 20px; color: var(--dark); letter-spacing: 4px; padding: 0 40px; opacity: 0.8; }
.marquee-dot { color: var(--dark); opacity: 0.4; }
@keyframes marquee { from{transform:translateX(0)} to{transform:translateX(-50%)} }

/* ─── SERVICES ─── */
#services { background: var(--dark2); }
.services-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; }
.service-card {
  background: var(--dark3);
  border: 1px solid rgba(201,168,76,0.1);
  border-radius: var(--radius);
  padding: 40px 36px;
  position: relative; overflow: hidden;
  transition: var(--transition);
  cursor: pointer;
}
.service-card::before {
  content: ''; position: absolute; inset: 0;
  background: linear-gradient(135deg, rgba(201,168,76,0.08), transparent);
  opacity: 0; transition: var(--transition);
}
.service-card:hover { transform: translateY(-8px); border-color: rgba(201,168,76,0.4); box-shadow: 0 20px 60px rgba(0,0,0,0.4); }
.service-card:hover::before { opacity: 1; }
.service-icon { width: 56px; height: 56px; background: rgba(201,168,76,0.1); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 26px; margin-bottom: 24px; transition: var(--transition); }
.service-card:hover .service-icon { background: var(--gold); transform: rotate(-5deg) scale(1.1); }
.service-num { font-family: 'Bebas Neue'; font-size: 13px; letter-spacing: 3px; color: var(--gold); opacity: 0.5; margin-bottom: 8px; }
.service-card h3 { font-family: 'Bebas Neue'; font-size: 26px; letter-spacing: 2px; margin-bottom: 12px; }
.service-card p { font-size: 14px; color: var(--muted); line-height: 1.8; }
.service-arrow { position: absolute; bottom: 28px; right: 28px; width: 36px; height: 36px; border: 1px solid rgba(201,168,76,0.3); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; transition: var(--transition); }
.service-card:hover .service-arrow { background: var(--gold); color: var(--dark); border-color: var(--gold); transform: rotate(45deg); }

/* ─── GALLERY ─── */
#gallery { background: var(--dark); }
.gallery-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  grid-template-rows: repeat(3, 220px);
  gap: 12px;
}
.gallery-item {
  border-radius: 12px;
  overflow: hidden;
  position: relative;
  cursor: pointer;
}
.gallery-item:nth-child(1) { grid-column: span 2; grid-row: span 2; }
.gallery-item:nth-child(5) { grid-column: span 2; }
.gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s cubic-bezier(0.23,1,0.32,1); }
.gallery-item:hover img { transform: scale(1.08); }
.gallery-item-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.7), transparent); opacity: 0; transition: var(--transition); display: flex; align-items: flex-end; padding: 20px; }
.gallery-item:hover .gallery-item-overlay { opacity: 1; }
.gallery-item-overlay span { font-family: 'Bebas Neue'; font-size: 18px; letter-spacing: 2px; color: var(--text); }

/* ─── TESTIMONIALS ─── */
#testimonials { background: var(--dark3); overflow: hidden; }
.testimonials-wrap { display: flex; justify-content: space-between; align-items: flex-start; gap: 80px; }
.testi-left { flex: 0 0 340px; }
.testi-score { display: flex; align-items: baseline; gap: 8px; margin-bottom: 8px; }
.testi-score strong { font-family: 'Bebas Neue'; font-size: 80px; color: var(--gold); line-height: 1; }
.testi-score span { font-size: 20px; color: var(--muted); }
.stars { color: var(--gold); font-size: 22px; letter-spacing: 3px; margin-bottom: 12px; }
.testi-count { font-size: 13px; color: var(--muted); letter-spacing: 1px; }
.testi-platforms { display: flex; gap: 12px; margin-top: 28px; flex-wrap: wrap; }
.platform-badge { background: var(--dark4); border: 1px solid rgba(255,255,255,0.08); border-radius: 50px; padding: 8px 16px; font-size: 12px; letter-spacing: 1px; display: flex; align-items: center; gap: 8px; }
.testi-right { flex: 1; }
.testi-swiper { overflow: hidden; }
.testi-card { background: var(--dark4); border: 1px solid rgba(201,168,76,0.1); border-radius: var(--radius); padding: 36px; height: auto; }
.testi-quote { font-size: 40px; color: var(--gold); line-height: 1; margin-bottom: 16px; font-family: 'Playfair Display'; }
.testi-text { font-size: 15px; line-height: 1.9; color: rgba(255,255,255,0.8); margin-bottom: 28px; font-style: italic; }
.testi-author { display: flex; align-items: center; gap: 16px; }
.testi-avatar { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid var(--gold); }
.testi-name { font-weight: 600; font-size: 15px; }
.testi-dest { font-size: 12px; color: var(--gold); letter-spacing: 1px; margin-top: 2px; }
.testi-stars { font-size: 13px; color: var(--gold); margin-bottom: 4px; }
.testi-swiper .swiper-pagination-bullet { background: var(--gold); }
.testi-swiper .swiper-pagination-bullet-active { background: var(--gold); opacity: 1; }

/* ─── SOCIAL FEED ─── */
#social { background: var(--dark2); }
.social-tabs { display: flex; gap: 0; margin-bottom: 40px; border: 1px solid rgba(255,255,255,0.08); border-radius: 50px; width: fit-content; overflow: hidden; }
.social-tab { padding: 10px 24px; font-size: 13px; letter-spacing: 2px; text-transform: uppercase; cursor: pointer; transition: var(--transition); border: none; background: transparent; color: var(--muted); display: flex; align-items: center; gap: 8px; }
.social-tab.active, .social-tab:hover { background: var(--gold); color: var(--dark); font-weight: 600; }
.social-feed-swiper { overflow: hidden; padding-bottom: 50px !important; }
.social-post { border-radius: 12px; overflow: hidden; position: relative; aspect-ratio: 1; cursor: pointer; }
.social-post img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
.social-post:hover img { transform: scale(1.08); }
.social-post-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.6); opacity: 0; transition: var(--transition); display: flex; align-items: center; justify-content: center; gap: 20px; }
.social-post:hover .social-post-overlay { opacity: 1; }
.social-stat { display: flex; align-items: center; gap: 6px; font-size: 15px; font-weight: 600; }
.social-handle { display: flex; align-items: center; gap: 12px; margin-bottom: 32px; }
.social-handle-icon { width: 44px; height: 44px; background: var(--gold); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; }
.social-handle-text strong { font-size: 15px; }
.social-handle-text span { font-size: 12px; color: var(--muted); display: block; margin-top: 2px; }

/* ─── BLOG ─── */
#blog { background: var(--dark); }
.blog-grid { display: grid; grid-template-columns: 1.5fr 1fr 1fr; gap: 24px; }
.blog-card { border-radius: var(--radius); overflow: hidden; background: var(--dark3); border: 1px solid rgba(255,255,255,0.05); transition: var(--transition); cursor: pointer; }
.blog-card:hover { transform: translateY(-6px); box-shadow: 0 20px 50px rgba(0,0,0,0.5); border-color: rgba(201,168,76,0.2); }
.blog-card.featured { grid-row: span 2; }
.blog-img { aspect-ratio: 16/9; overflow: hidden; position: relative; }
.blog-card.featured .blog-img { aspect-ratio: auto; height: 320px; }
.blog-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
.blog-card:hover .blog-img img { transform: scale(1.05); }
.blog-tag { position: absolute; top: 14px; left: 14px; background: var(--gold); color: var(--dark); font-size: 10px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 4px 12px; border-radius: 50px; }
.blog-body { padding: 24px; }
.blog-meta { display: flex; gap: 16px; font-size: 11px; color: var(--muted); letter-spacing: 1px; text-transform: uppercase; margin-bottom: 10px; }
.blog-card h3 { font-family: 'Bebas Neue'; font-size: clamp(18px, 2.5vw, 26px); letter-spacing: 1px; line-height: 1.2; margin-bottom: 10px; transition: var(--transition); }
.blog-card:hover h3 { color: var(--gold); }
.blog-card p { font-size: 13px; color: var(--muted); line-height: 1.8; }
.blog-read { display: inline-flex; align-items: center; gap: 8px; color: var(--gold); font-size: 12px; letter-spacing: 2px; text-transform: uppercase; margin-top: 16px; text-decoration: none; transition: var(--transition); }
.blog-read:hover { gap: 14px; }

/* ─── CONTACT ─── */
#contact { background: var(--dark2); }
.contact-grid { display: grid; grid-template-columns: 1fr 1.2fr; gap: 80px; align-items: start; }
.contact-info h3 { font-family: 'Bebas Neue'; font-size: 32px; letter-spacing: 2px; margin-bottom: 24px; }
.contact-item { display: flex; align-items: flex-start; gap: 16px; margin-bottom: 24px; }
.contact-icon { width: 44px; height: 44px; background: rgba(201,168,76,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; transition: var(--transition); }
.contact-item:hover .contact-icon { background: var(--gold); }
.contact-item strong { font-size: 13px; letter-spacing: 1px; text-transform: uppercase; color: var(--gold); display: block; margin-bottom: 2px; }
.contact-item span { font-size: 14px; color: var(--muted); }
.contact-socials { display: flex; gap: 12px; margin-top: 32px; }
.social-btn { width: 44px; height: 44px; border: 1px solid rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 17px; text-decoration: none; color: var(--text); transition: var(--transition); }
.social-btn:hover { background: var(--gold); border-color: var(--gold); color: var(--dark); transform: translateY(-3px); }
.contact-form { display: flex; flex-direction: column; gap: 16px; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-group { display: flex; flex-direction: column; gap: 8px; }
.form-group label { font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: var(--muted); }
.form-group input, .form-group select, .form-group textarea {
  background: var(--dark3); border: 1px solid rgba(255,255,255,0.08); color: var(--text);
  padding: 14px 16px; border-radius: 10px; font-family: 'Outfit', sans-serif; font-size: 14px;
  transition: var(--transition); outline: none; resize: none;
}
.form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: var(--gold); background: rgba(201,168,76,0.05); box-shadow: 0 0 0 3px rgba(201,168,76,0.1); }
.form-group select option { background: var(--dark3); }
.btn-submit { background: var(--gold); color: var(--dark); border: none; padding: 16px 40px; border-radius: 50px; font-family: 'Outfit', sans-serif; font-size: 15px; font-weight: 700; letter-spacing: 1px; cursor: pointer; transition: var(--transition); display: flex; align-items: center; justify-content: center; gap: 10px; }
.btn-submit:hover { background: var(--gold-light); transform: translateY(-3px); box-shadow: 0 12px 40px rgba(201,168,76,0.4); }

/* ─── MAP ─── */
#map-section { height: 500px; position: relative; overflow: hidden; }
.next-level-map { width: 100%; height: 100%; min-height: 500px; background: var(--dark2); }
.next-level-map .leaflet-tile-pane { filter: invert(90%) hue-rotate(200deg) saturate(0.8); }
.next-level-marker-wrap { width: 26px; height: 26px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); display: grid; place-items: center; color: var(--dark); border: 2px solid rgba(255,255,255,0.9); box-shadow: 0 8px 22px rgba(0,0,0,0.38); }
.next-level-marker-wrap span { transform: rotate(45deg); font-size: 13px; line-height: 1; }
.next-level-popup { width: 330px; max-width: 78vw; font-family: 'Outfit', sans-serif; color: #111; }
.next-level-popup strong { display: block; font-size: 16px; margin-bottom: 5px; }
.next-level-popup small { display: inline-flex; margin-bottom: 8px; padding: 4px 10px; border-radius: 999px; background: #C9A84C; color: #0a0a0a; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; }
.next-level-popup p { color: #555; line-height: 1.45; margin: 0 0 10px; }
.next-level-popup iframe { width: 100%; height: 185px; border: 0; border-radius: 10px; display: block; }
.map-overlay { position: absolute; top: 40px; left: 40px; background: var(--dark); border: 1px solid rgba(201,168,76,0.2); border-radius: var(--radius); padding: 24px 28px; box-shadow: 0 20px 60px rgba(0,0,0,0.5); }
.map-overlay h4 { font-family: 'Bebas Neue'; font-size: 22px; letter-spacing: 2px; color: var(--gold); margin-bottom: 8px; }
.map-overlay p { font-size: 13px; color: var(--muted); line-height: 1.6; }

/* ─── FOOTER ─── */
footer { background: #050505; padding: 80px 40px 40px; border-top: 1px solid rgba(201,168,76,0.1); }
.footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 60px; margin-bottom: 60px; }
.footer-brand p { font-size: 14px; color: var(--muted); line-height: 1.9; margin: 16px 0 24px; max-width: 280px; }
.footer-logo { font-family: 'Bebas Neue'; font-size: 32px; color: var(--gold); letter-spacing: 3px; }
.footer-col h4 { font-family: 'Bebas Neue'; font-size: 16px; letter-spacing: 3px; color: var(--gold); margin-bottom: 20px; }
.footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 10px; }
.footer-col ul li a { color: var(--muted); text-decoration: none; font-size: 14px; transition: var(--transition); }
.footer-col ul li a:hover { color: var(--gold); padding-left: 6px; }
.footer-bottom { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 28px; flex-wrap: wrap; gap: 16px; }
.footer-bottom p { font-size: 13px; color: var(--muted); }
.footer-bottom-links { display: flex; gap: 24px; }
.footer-bottom-links a { font-size: 13px; color: var(--muted); text-decoration: none; transition: var(--transition); }
.footer-bottom-links a:hover { color: var(--gold); }
.footer-newsletter { display: flex; gap: 0; margin-top: 8px; }
.footer-newsletter input { flex: 1; background: var(--dark3); border: 1px solid rgba(255,255,255,0.08); border-right: none; color: var(--text); padding: 12px 16px; border-radius: 8px 0 0 8px; font-family: 'Outfit', sans-serif; font-size: 13px; outline: none; }
.footer-newsletter input:focus { border-color: var(--gold); }
.footer-newsletter button { background: var(--gold); border: none; color: var(--dark); padding: 12px 16px; border-radius: 0 8px 8px 0; font-size: 16px; cursor: pointer; transition: var(--transition); }
.footer-newsletter button:hover { background: var(--gold-light); }

/* ─── ANIMATIONS ─── */
.reveal { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
.reveal.visible { opacity: 1; transform: translateY(0); }
.reveal-left { opacity: 0; transform: translateX(-30px); transition: opacity 0.7s ease, transform 0.7s ease; }
.reveal-left.visible { opacity: 1; transform: translateX(0); }
.reveal-right { opacity: 0; transform: translateX(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
.reveal-right.visible { opacity: 1; transform: translateX(0); }
.delay-1 { transition-delay: 0.15s; }
.delay-2 { transition-delay: 0.3s; }
.delay-3 { transition-delay: 0.45s; }
.delay-4 { transition-delay: 0.6s; }

/* ─── FLOATING CTA ─── */
.float-cta { position: fixed; bottom: 30px; right: 30px; z-index: 990; background: #25D366; color: #07140c; width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 21px; font-weight: 800; box-shadow: 0 8px 30px rgba(37,211,102,0.45); transition: var(--transition); text-decoration: none; }
.float-cta:hover { transform: scale(1.15) rotate(-10deg); box-shadow: 0 12px 50px rgba(37,211,102,0.65); }

/* ─── RESPONSIVE ─── */
@media (max-width: 1024px) {
  .gallery-grid { grid-template-columns: repeat(2, 1fr); grid-template-rows: auto; }
  .gallery-item:nth-child(1) { grid-column: span 2; grid-row: span 1; }
  .gallery-item:nth-child(5) { grid-column: span 1; }
  .blog-grid { grid-template-columns: 1fr 1fr; }
  .blog-card.featured { grid-column: span 2; }
  .footer-grid { grid-template-columns: 1fr 1fr; gap: 40px; }
  .testimonials-wrap { flex-direction: column; gap: 40px; }
  .testi-left { flex: none; width: 100%; }
  .contact-grid { grid-template-columns: 1fr; gap: 60px; }
}
@media (max-width: 768px) {
  nav { padding: 16px 20px; }
  nav.scrolled { padding: 12px 20px; }
  .nav-links, .nav-cta { display: none; }
  .hamburger { display: flex; }
  section { padding: 70px 20px; }
  .hero-stats { display: none; }
  .hero-content { left: 20px; right: 20px; bottom: 20%; }
  .gallery-grid { grid-template-columns: 1fr 1fr; grid-template-rows: auto; }
  .gallery-item:nth-child(1) { grid-column: span 2; }
  .blog-grid { grid-template-columns: 1fr; }
  .blog-card.featured { grid-column: span 1; }
  .footer-grid { grid-template-columns: 1fr; }
  .form-row { grid-template-columns: 1fr; }
  .footer-bottom { flex-direction: column; text-align: center; }
  .map-overlay { display: none; }
}

.hero-slide-bg iframe { width: 100%; height: 100%; border: 0; position: absolute; inset: 0; object-fit: cover; pointer-events: none; }
</style>
</head><body>

<!-- NAVBAR -->
<nav id="navbar">
  <a href="#" class="nav-logo">
    <span>Go Exploria</span>
    <span>Next Level</span>
  </a>
  <ul class="nav-links">
    <li><a href="#services">Services</a></li>
    <li><a href="#gallery">Galerie</a></li>
    <li><a href="#testimonials">Avis</a></li>
    <li><a href="#social">Social</a></li>
    <li><a href="#blog">Blog</a></li>
    <li><a href="#contact">Contact</a></li>
  </ul>
  <a href="#contact" class="nav-cta">Demander un devis</a>
  <div class="hamburger" id="hamburger">
    <span></span><span></span><span></span>
  </div>
</nav>

<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobileMenu">
  <a href="#services" onclick="closeMobile()">Services</a>
  <a href="#gallery" onclick="closeMobile()">Galerie</a>
  <a href="#testimonials" onclick="closeMobile()">Avis</a>
  <a href="#social" onclick="closeMobile()">Social</a>
  <a href="#blog" onclick="closeMobile()">Blog</a>
  <a href="#contact" onclick="closeMobile()">Contact</a>
</div>

<!-- HERO -->
<section id="hero">
  <div class="swiper hero-swiper">
    <div class="swiper-wrapper">
      @foreach($heroSlides as $slide)
        <div class="swiper-slide">
          <div class="hero-slide-bg" @if(empty($slide['embed']) && (($slide['type'] ?? 'image') !== 'video')) style="background-image:url('{{ $slide['url'] }}')" @endif>
            @if(!empty($slide['embed']))
              <iframe src="{{ $slide['embed'] }}" title="{{ $slide['title'] }}" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
            @elseif(($slide['type'] ?? 'image') === 'video')
              <video src="{{ $slide['url'] }}" autoplay muted loop playsinline></video>
            @endif
          </div>
          <div class="hero-overlay"></div>
          <div class="hero-content">
            <div class="hero-tag">✦ Aventure & Découverte</div>
            <h1 class="hero-title">{!! $heroTitleParts($slide['title']) !!}</h1>
            <p class="hero-sub">{{ $slide['subtitle'] }}</p>
            <div class="hero-btns">
              <a href="{{ $slide['button_url'] ?: '#services' }}" class="btn-primary">{{ $slide['button_text'] ?: 'Nos Voyages' }} →</a>
              <a href="#gallery" class="btn-outline">▶ Voir la Galerie</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="swiper-pagination"></div>
  </div>
  <div class="hero-stats">
    <div class="stat"><div class="stat-num">1200+</div><div class="stat-label">Voyageurs</div></div>
    <div class="stat"><div class="stat-num">48</div><div class="stat-label">Destinations</div></div>
    <div class="stat"><div class="stat-num">98%</div><div class="stat-label">Satisfaction</div></div>
  </div>
  <div class="scroll-hint"><span>Scroll</span><div class="scroll-line"></div></div>
</section>
<!-- MARQUEE -->
<div class="marquee-wrap">
  <div class="marquee-track">
    <span class="marquee-item">Aventure</span><span class="marquee-dot">✦</span>
    <span class="marquee-item">Exploration</span><span class="marquee-dot">✦</span>
    <span class="marquee-item">Next Level</span><span class="marquee-dot">✦</span>
    <span class="marquee-item">Trekking</span><span class="marquee-dot">✦</span>
    <span class="marquee-item">Désert</span><span class="marquee-dot">✦</span>
    <span class="marquee-item">Montagne</span><span class="marquee-dot">✦</span>
    <span class="marquee-item">Culture</span><span class="marquee-dot">✦</span>
    <span class="marquee-item">Liberté</span><span class="marquee-dot">✦</span>
    <span class="marquee-item">Aventure</span><span class="marquee-dot">✦</span>
    <span class="marquee-item">Exploration</span><span class="marquee-dot">✦</span>
    <span class="marquee-item">Next Level</span><span class="marquee-dot">✦</span>
    <span class="marquee-item">Trekking</span><span class="marquee-dot">✦</span>
    <span class="marquee-item">Désert</span><span class="marquee-dot">✦</span>
    <span class="marquee-item">Montagne</span><span class="marquee-dot">✦</span>
    <span class="marquee-item">Culture</span><span class="marquee-dot">✦</span>
    <span class="marquee-item">Liberté</span><span class="marquee-dot">✦</span>
  </div>
</div>

<!-- SERVICES -->
<section id="services">
  <div class="container">
    <p class="section-label reveal">Ce que nous offrons</p>
    <h2 class="section-title reveal delay-1">NOS <span>SERVICES</span></h2>
    <p class="section-sub reveal delay-2">Des expériences soigneusement conçues pour chaque type d'aventurier. Du débutant passionné au voyageur aguerri.</p>
    <div class="services-grid">
      <div class="service-card reveal">
        <div class="service-icon">🏔️</div>
        <div class="service-num">01</div>
        <h3>Trekking & Randonnée</h3>
        <p>Des circuits de randonnée guidés dans les plus beaux massifs du monde. Équipement fourni, guides certifiés, sécurité maximale.</p>
        <div class="service-arrow">→</div>
      </div>
      <div class="service-card reveal delay-1">
        <div class="service-icon">🏜️</div>
        <div class="service-num">02</div>
        <h3>Expéditions Désert</h3>
        <p>Bivouacs sahariens, traversées de dunes, rencontres nomades. Une immersion totale dans le silence et la majesté du désert.</p>
        <div class="service-arrow">→</div>
      </div>
      <div class="service-card reveal delay-2">
        <div class="service-icon">🌊</div>
        <div class="service-num">03</div>
        <h3>Aventures Nautiques</h3>
        <p>Plongée, kayak de mer, voile. Explorez les profondeurs marines et les côtes sauvages avec nos experts certifiés.</p>
        <div class="service-arrow">→</div>
      </div>
      <div class="service-card reveal delay-3">
        <div class="service-icon">🎒</div>
        <div class="service-num">04</div>
        <h3>Voyages Sur Mesure</h3>
        <p>Chaque voyage est unique. Nous concevons votre itinéraire personnalisé selon vos désirs, votre budget et vos rêves.</p>
        <div class="service-arrow">→</div>
      </div>
      <div class="service-card reveal">
        <div class="service-icon">📸</div>
        <div class="service-num">05</div>
        <h3>Photo & Vidéo Tours</h3>
        <p>Voyages photographiques avec des artistes professionnels. Ramenez des images sublimes de vos aventures inoubliables.</p>
        <div class="service-arrow">→</div>
      </div>
      <div class="service-card reveal delay-1">
        <div class="service-icon">🧘</div>
        <div class="service-num">06</div>
        <h3>Retraites Bien-être</h3>
        <p>Yoga en montagne, méditation au lever du soleil, detox digitale. Reconnectez-vous à l'essentiel dans des lieux magiques.</p>
        <div class="service-arrow">→</div>
      </div>
    </div>
  </div>
</section>

<!-- GALLERY -->
<section id="gallery">
  <div class="container">
    <p class="section-label reveal">Nos Destinations</p>
    <h2 class="section-title reveal delay-1">GALERIE <span>PHOTOS</span></h2>
    <p class="section-sub reveal delay-2">Plongez dans l'univers visuel de Go Exploria. Chaque image raconte une histoire, chaque lieu est une invitation.</p>
    <div class="gallery-grid reveal">
      <div class="gallery-item"><img src="https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=800&q=80" alt="Sahara"><div class="gallery-item-overlay"><span>Sahara Marocain</span></div></div>
      <div class="gallery-item"><img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=600&q=80" alt="Alpes"><div class="gallery-item-overlay"><span>Alpes Suisses</span></div></div>
      <div class="gallery-item"><img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=600&q=80" alt="Plage"><div class="gallery-item-overlay"><span>Maldives</span></div></div>
      <div class="gallery-item"><img src="https://images.unsplash.com/photo-1523482580672-f109ba8cb9be?w=600&q=80" alt="Australie"><div class="gallery-item-overlay"><span>Outback Australien</span></div></div>
      <div class="gallery-item"><img src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?w=800&q=80" alt="Fjords"><div class="gallery-item-overlay"><span>Fjords Norvégiens</span></div></div>
      <div class="gallery-item"><img src="https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?w=600&q=80" alt="Grèce"><div class="gallery-item-overlay"><span>Santorin</span></div></div>
      <div class="gallery-item"><img src="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=600&q=80" alt="Asie"><div class="gallery-item-overlay"><span>Bali</span></div></div>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section id="testimonials">
  <div class="container">
    <p class="section-label reveal">Ce qu'ils disent</p>
    <h2 class="section-title reveal delay-1">AVIS <span>CLIENTS</span></h2>
    <div class="testimonials-wrap">
      <div class="testi-left reveal-left">
        <div class="testi-score">
          <strong>4.9</strong><span>/ 5</span>
        </div>
        <div class="stars">★★★★★</div>
        <p class="testi-count">Basé sur 486 avis vérifiés</p>
        <div class="testi-platforms">
          <div class="platform-badge">🌍 TripAdvisor <strong style="color:var(--gold)">5★</strong></div>
          <div class="platform-badge">📘 Facebook <strong style="color:var(--gold)">4.9</strong></div>
          <div class="platform-badge">🗺️ Google <strong style="color:var(--gold)">4.8</strong></div>
        </div>
      </div>
      <div class="testi-right reveal-right">
        <div class="swiper testi-swiper">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="testi-card">
                <div class="testi-stars">★★★★★</div>
                <div class="testi-quote">"</div>
                <p class="testi-text">Une expérience absolument extraordinaire! Le trek au Maroc était parfaitement organisé. Les guides sont passionnés et très professionnels. Je recommande Go Exploria les yeux fermés.</p>
                <div class="testi-author">
                  <img class="testi-avatar" src="https://i.pravatar.cc/100?img=25" alt="Sophie">
                  <div>
                    <div class="testi-name">Sophie M.</div>
                    <div class="testi-dest">Trek Sahara — Maroc</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="testi-card">
                <div class="testi-stars">★★★★★</div>
                <div class="testi-quote">"</div>
                <p class="testi-text">Le voyage sur mesure que l'équipe a conçu pour nous était au-delà de mes espérances. Chaque détail était pensé. C'est ça le "Next Level" — on le comprend vraiment sur place!</p>
                <div class="testi-author">
                  <img class="testi-avatar" src="https://i.pravatar.cc/100?img=12" alt="Karim">
                  <div>
                    <div class="testi-name">Karim B.</div>
                    <div class="testi-dest">Voyage Personnalisé — Jordanie</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="testi-card">
                <div class="testi-stars">★★★★★</div>
                <div class="testi-quote">"</div>
                <p class="testi-text">La retraite bien-être en montagne était une révélation. Yoga au lever du soleil, cuisine locale, paysages à couper le souffle. Je reviens l'année prochaine sans hésitation!</p>
                <div class="testi-author">
                  <img class="testi-avatar" src="https://i.pravatar.cc/100?img=48" alt="Layla">
                  <div>
                    <div class="testi-name">Layla K.</div>
                    <div class="testi-dest">Retraite Bien-être — Atlas</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="testi-card">
                <div class="testi-stars">★★★★★</div>
                <div class="testi-quote">"</div>
                <p class="testi-text">Mon fils et moi avons fait l'expédition désert. C'était magique, les étoiles au-dessus du bivouac... Impossible à oublier. Merci Go Exploria pour ce cadeau de vie.</p>
                <div class="testi-author">
                  <img class="testi-avatar" src="https://i.pravatar.cc/100?img=36" alt="Pierre">
                  <div>
                    <div class="testi-name">Pierre D.</div>
                    <div class="testi-dest">Expédition Désert — Tunisie</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-pagination" style="bottom: -40px;"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SOCIAL FEED -->
<section id="social">
  <div class="container">
    <p class="section-label reveal">Suivez-nous</p>
    <h2 class="section-title reveal delay-1">NOS <span>RÉSEAUX</span></h2>
    <p class="section-sub reveal delay-2">Rejoignez notre communauté de voyageurs et partagez vos aventures avec le hashtag #GoExploriaNextLevel</p>
    <div class="social-tabs reveal delay-3">
      <button class="social-tab active" onclick="switchFeed(this,'instagram')">📸 Instagram</button>
      <button class="social-tab" onclick="switchFeed(this,'facebook')">📘 Facebook</button>
      <button class="social-tab" onclick="switchFeed(this,'pinterest')">📌 Pinterest</button>
    </div>
    <div id="instagram-feed">
      <div class="social-handle reveal">
        <div class="social-handle-icon">📸</div>
        <div class="social-handle-text">
          <strong>@GoExploriaNextLevel</strong>
          <span>12.4K abonnés · 340 publications</span>
        </div>
      </div>
      <div class="swiper social-feed-swiper">
        <div class="swiper-wrapper" id="insta-grid">
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
    <div id="facebook-feed" style="display:none">
      <div class="social-handle reveal">
        <div class="social-handle-icon">📘</div>
        <div class="social-handle-text">
          <strong>Go Exploria Next Level</strong>
          <span>8.2K J'aime · 8.7K abonnés</span>
        </div>
      </div>
      <div class="swiper social-feed-swiper">
        <div class="swiper-wrapper" id="fb-grid"></div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
    <div id="pinterest-feed" style="display:none">
      <div class="social-handle reveal">
        <div class="social-handle-icon">📌</div>
        <div class="social-handle-text">
          <strong>GoExploriaTravel</strong>
          <span>3.1K abonnés · 24 tableaux</span>
        </div>
      </div>
      <div class="swiper social-feed-swiper">
        <div class="swiper-wrapper" id="pin-grid"></div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </div>
</section>

<!-- BLOG -->
<section id="blog">
  <div class="container">
    <p class="section-label reveal">Inspirations & Conseils</p>
    <h2 class="section-title reveal delay-1">NOTRE <span>BLOG</span></h2>
    <p class="section-sub reveal delay-2">Des articles pour inspirer vos prochains voyages, des conseils pratiques et des récits d'aventures vécues.</p>
    <div class="blog-grid">
      <div class="blog-card featured reveal">
        <div class="blog-img">
          <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?w=900&q=80" alt="Blog 1">
          <span class="blog-tag">À La Une</span>
        </div>
        <div class="blog-body">
          <div class="blog-meta"><span>12 Jan 2025</span><span>·</span><span>8 min de lecture</span></div>
          <h3>10 Secrets Pour Préparer Un Trek Au Sahara Sans Stress</h3>
          <p>Tout ce que vous devez savoir avant de partir en expédition désert : équipement, hydratation, budget, et les erreurs à éviter absolument.</p>
          <a href="#" class="blog-read">Lire l'article →</a>
        </div>
      </div>
      <div class="blog-card reveal delay-1">
        <div class="blog-img">
          <img src="https://images.unsplash.com/photo-1492571350019-22de08371fd3?w=600&q=80" alt="Blog 2">
          <span class="blog-tag">Trekking</span>
        </div>
        <div class="blog-body">
          <div class="blog-meta"><span>5 Fév 2025</span><span>·</span><span>5 min</span></div>
          <h3>Les 5 Randonnées Incontournables Du Maghreb</h3>
          <a href="#" class="blog-read">Lire →</a>
        </div>
      </div>
      <div class="blog-card reveal delay-2">
        <div class="blog-img">
          <img src="https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?w=600&q=80" alt="Blog 3">
          <span class="blog-tag">Bien-être</span>
        </div>
        <div class="blog-body">
          <div class="blog-meta"><span>20 Fév 2025</span><span>·</span><span>4 min</span></div>
          <h3>Pourquoi Le Voyage Transforme Votre Mental</h3>
          <a href="#" class="blog-read">Lire →</a>
        </div>
      </div>
      <div class="blog-card reveal">
        <div class="blog-img">
          <img src="https://images.unsplash.com/photo-1506197603052-3cc9c3a201bd?w=600&q=80" alt="Blog 4">
          <span class="blog-tag">Culture</span>
        </div>
        <div class="blog-body">
          <div class="blog-meta"><span>3 Mar 2025</span><span>·</span><span>6 min</span></div>
          <h3>Immersion Berbère : Vivre Avec Les Nomades Du Désert</h3>
          <a href="#" class="blog-read">Lire →</a>
        </div>
      </div>
      <div class="blog-card reveal delay-1">
        <div class="blog-img">
          <img src="https://images.unsplash.com/photo-1503220317375-aaad61436b1b?w=600&q=80" alt="Blog 5">
          <span class="blog-tag">Conseil</span>
        </div>
        <div class="blog-body">
          <div class="blog-meta"><span>15 Mar 2025</span><span>·</span><span>3 min</span></div>
          <h3>Budget Voyage : Voyager Mieux Pour Moins Cher</h3>
          <a href="#" class="blog-read">Lire →</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CONTACT -->
<section id="contact">
  <div class="container">
    <p class="section-label reveal">Parlons de votre voyage</p>
    <h2 class="section-title reveal delay-1">CONTACTEZ-<span>NOUS</span></h2>
    <div class="contact-grid">
      <div class="contact-info reveal-left">
        <h3>Planifions votre aventure</h3>
        <p style="font-size:14px;color:var(--muted);line-height:1.9;margin-bottom:32px;">Notre équipe de passionnés est à votre disposition pour vous aider à concevoir le voyage de vos rêves. Répondons à vos questions dans les 24h.</p>
        <div class="contact-item">
          <div class="contact-icon">📍</div>
          <div>
            <strong>Adresse</strong>
            <span>Québec, Canada</span>
          </div>
        </div>
        <div class="contact-item">
          <div class="contact-icon">📞</div>
          <div>
            <strong>Téléphone</strong>
            <span>(418) 525-7748</span>
          </div>
        </div>
        <div class="contact-item">
          <div class="contact-icon">✉️</div>
          <div>
            <strong>Email</strong>
            <span>info@goexploriabusiness.com</span>
          </div>
        </div>
        <div class="contact-item">
          <div class="contact-icon">⏰</div>
          <div>
            <strong>Horaires</strong>
            <span>Lun–Sam : 9h–19h | Dim : 10h–16h</span>
          </div>
        </div>
        <div class="contact-socials">
          <a href="#" class="social-btn">📘</a>
          <a href="#" class="social-btn">📸</a>
          <a href="#" class="social-btn">📌</a>
          <a href="#" class="social-btn">▶</a>
          <a href="#" class="social-btn">🐦</a>
        </div>
      </div>
      <form class="contact-form reveal-right" onsubmit="return handleForm(event)">
        <div class="form-row">
          <div class="form-group">
            <label>Prénom *</label>
            <input type="text" placeholder="Votre prénom" required>
          </div>
          <div class="form-group">
            <label>Nom *</label>
            <input type="text" placeholder="Votre nom" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Email *</label>
            <input type="email" placeholder="votre@email.com" required>
          </div>
          <div class="form-group">
            <label>Téléphone</label>
            <input type="tel" placeholder="(418) 525-7748">
          </div>
        </div>
        <div class="form-group">
          <label>Type de voyage</label>
          <select>
            <option value="">Choisir un service...</option>
            <option>Trekking & Randonnée</option>
            <option>Expédition Désert</option>
            <option>Voyage Sur Mesure</option>
            <option>Aventures Nautiques</option>
            <option>Photo & Vidéo Tour</option>
            <option>Retraite Bien-être</option>
          </select>
        </div>
        <div class="form-group">
          <label>Budget estimé</label>
          <select>
            <option>Moins de 500 €</option>
            <option>500 € – 1500 €</option>
            <option>1500 € – 3000 €</option>
            <option>Plus de 3000 €</option>
          </select>
        </div>
        <div class="form-group">
          <label>Votre message *</label>
          <textarea rows="4" placeholder="Décrivez votre rêve de voyage..." required></textarea>
        </div>
        <button type="submit" class="btn-submit">
          <span>Envoyer ma demande</span> ✦
        </button>
        <div id="form-success" style="display:none;background:rgba(46,216,168,0.1);border:1px solid var(--accent);border-radius:10px;padding:14px 20px;font-size:14px;color:var(--accent);margin-top:8px;">
          ✓ Message envoyé avec succès ! Nous vous répondrons dans les 24h.
        </div>
      </form>
    </div>
  </div>
</section>

<!-- MAP -->
<div id="map-section">
  <div id="nextLevelMap" class="next-level-map"></div>
  <div class="map-overlay">
    <h4>Go Exploria — Next Level</h4>
    <p>Québec, Canada<br>(418) 525-7748<br>info@goexploriabusiness.com</p>
  </div>
</div>

<!-- FOOTER -->
<footer>
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <div class="footer-logo">GO EXPLORIA</div>
        <p>Votre partenaire de confiance pour des aventures de voyage inoubliables. Nous créons des expériences qui transforment les perspectives et les vies.</p>
        <div class="contact-socials">
          <a href="#" class="social-btn">📘</a>
          <a href="#" class="social-btn">📸</a>
          <a href="#" class="social-btn">📌</a>
          <a href="#" class="social-btn">▶</a>
        </div>
      </div>
      <div class="footer-col">
        <h4>Navigation</h4>
        <ul>
          <li><a href="#services">Nos Services</a></li>
          <li><a href="#gallery">Galerie</a></li>
          <li><a href="#testimonials">Avis Clients</a></li>
          <li><a href="#blog">Blog</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Voyages</h4>
        <ul>
          <li><a href="#">Treks Montagne</a></li>
          <li><a href="#">Désert Sahara</a></li>
          <li><a href="#">Côtes & Plages</a></li>
          <li><a href="#">Voyages Culturels</a></li>
          <li><a href="#">Photo Tours</a></li>
          <li><a href="#">Retraites Yoga</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Newsletter</h4>
        <p style="font-size:13px;color:var(--muted);line-height:1.7;margin-bottom:16px;">Recevez nos offres exclusives et inspirations voyage directement dans votre boîte mail.</p>
        <div class="footer-newsletter">
          <input type="email" placeholder="votre@email.com">
          <button>→</button>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© 2025 Go Exploria Next Level. Tous droits réservés.</p>
      <div class="footer-bottom-links">
        <a href="#">Mentions légales</a>
        <a href="#">Confidentialité</a>
        <a href="#">CGV</a>
      </div>
    </div>
  </div>
</footer>

<!-- FLOATING CTA -->
<a href="https://wa.me/14185257748" class="float-cta" title="WhatsApp" target="_blank" rel="noopener"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
// ── HERO SWIPER ──
const heroSwiper = new Swiper('.hero-swiper', {
  loop: true,
  autoplay: { delay: 6000, disableOnInteraction: false },
  effect: 'fade',
  fadeEffect: { crossFade: true },
  pagination: { el: '.hero-swiper .swiper-pagination', clickable: true },
  speed: 1200,
});

// ── TESTIMONIALS SWIPER ──
const testiSwiper = new Swiper('.testi-swiper', {
  loop: true,
  autoplay: { delay: 5000 },
  pagination: { el: '.testi-swiper .swiper-pagination', clickable: true },
  spaceBetween: 24,
  speed: 800,
});

// ── MAP POINTS ──
const nextLevelMapPoints = {!! \Illuminate\Support\Js::from($nextLevelMapPoints) !!};
const nextLevelCategoryStyles = {
  tourism: { icon: '🧭', color: '#C9A84C' },
  culture: { icon: '🎭', color: '#8b5cf6' },
  history: { icon: '🏛️', color: '#b45309' },
  nature: { icon: '🌲', color: '#22c55e' },
  adventure: { icon: '⛰️', color: '#f97316' },
  shopping: { icon: '🛍️', color: '#ec4899' },
  science: { icon: '🔬', color: '#06b6d4' },
  beach: { icon: '🏖️', color: '#0ea5e9' },
  family: { icon: '👨‍👩‍👧', color: '#f59e0b' },
  restaurant: { icon: '🍽️', color: '#ef4444' },
  hotel: { icon: '🏨', color: '#6366f1' },
  commerce: { icon: '🏬', color: '#14b8a6' },
  sante: { icon: '⚕️', color: '#10b981' },
  education: { icon: '🎓', color: '#3b82f6' },
  sport: { icon: '🏅', color: '#84cc16' },
  loisirs: { icon: '🎡', color: '#d946ef' },
  transport: { icon: '🚌', color: '#64748b' },
  immobilier: { icon: '🏠', color: '#a16207' },
  service: { icon: '🛠️', color: '#475569' },
  autre: { icon: '📍', color: '#C9A84C' },
  general: { icon: '📍', color: '#C9A84C' },
};

function escapeNextLevelMapText(value) {
  return String(value || '').replace(/[&<>"']/g, (char) => ({
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  })[char]);
}

function initNextLevelMap() {
  const mapEl = document.getElementById('nextLevelMap');
  if (!window.L || !mapEl || !nextLevelMapPoints.length) return;

  const map = L.map(mapEl, {
    zoomControl: true,
    scrollWheelZoom: false,
  }).setView([46.8139, -71.2080], 6);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; OpenStreetMap',
  }).addTo(map);

  const bounds = [];

  nextLevelMapPoints.forEach((point) => {
    const category = String(point.category || 'autre').toLowerCase();
    const style = nextLevelCategoryStyles[category] || nextLevelCategoryStyles.autre;
    const lat = Number(point.lat);
    const lng = Number(point.lng);
    if (!Number.isFinite(lat) || !Number.isFinite(lng)) return;

    const icon = L.divIcon({
      className: 'next-level-marker',
      html: `<div class="next-level-marker-wrap" style="background:${style.color};"><span>${style.icon}</span></div>`,
      iconSize: [26, 26],
      iconAnchor: [13, 25],
      popupAnchor: [0, -25],
    });
    const pointVideoSrc = String(point.video_embed || '');
    const mutedVideoSrc = pointVideoSrc.includes('mute=') || pointVideoSrc.includes('muted=')
      ? pointVideoSrc
      : pointVideoSrc + (pointVideoSrc.includes('?') ? '&' : '?') + 'mute=1&muted=1';

    const popupHtml = `
      <div class="next-level-popup">
        <small>${escapeNextLevelMapText(category)}</small>
        <strong>${escapeNextLevelMapText(point.title)}</strong>
        <p>${escapeNextLevelMapText(point.address)}</p>
        ${point.description ? `<p>${escapeNextLevelMapText(point.description)}</p>` : ''}
        <iframe src="${mutedVideoSrc}" title="${escapeNextLevelMapText(point.title)}" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
      </div>
    `;

    L.marker([lat, lng], { icon }).addTo(map).bindPopup(popupHtml, {
      maxWidth: 360,
      minWidth: 280,
      className: 'next-level-video-popup',
    });
    bounds.push([lat, lng]);
  });

  map.setView([46.8139, -71.2080], 6);

  setTimeout(() => map.invalidateSize(), 300);
}

initNextLevelMap();

// ── SOCIAL FEED DATA ──
const photoSets = {
  instagram: [
    'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=400&q=80',
    'https://images.unsplash.com/photo-1502791451862-7bd8c1df43a7?w=400&q=80',
    'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=400&q=80',
    'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?w=400&q=80',
    'https://images.unsplash.com/photo-1510797215324-95aa89f43c33?w=400&q=80',
    'https://images.unsplash.com/photo-1522163182402-834f871fd851?w=400&q=80',
    'https://images.unsplash.com/photo-1539635278303-d4002c07eae3?w=400&q=80',
    'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=400&q=80',
  ],
  facebook: [
    'https://images.unsplash.com/photo-1516483638261-f4dbaf036963?w=400&q=80',
    'https://images.unsplash.com/photo-1504609773096-104ff2c73ba4?w=400&q=80',
    'https://images.unsplash.com/photo-1543731068-7e0f5beff43a?w=400&q=80',
    'https://images.unsplash.com/photo-1483728642387-6c3bdd6c93e5?w=400&q=80',
    'https://images.unsplash.com/photo-1505228395891-9a51e7e86bf6?w=400&q=80',
    'https://images.unsplash.com/photo-1527631746610-bca00a040d60?w=400&q=80',
    'https://images.unsplash.com/photo-1509233725247-49e657c54213?w=400&q=80',
    'https://images.unsplash.com/photo-1519451241324-20b4ea2c4220?w=400&q=80',
  ],
  pinterest: [
    'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&q=80',
    'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=400&q=80',
    'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?w=400&q=80',
    'https://images.unsplash.com/photo-1481349518771-20055b2a7b24?w=400&q=80',
    'https://images.unsplash.com/photo-1519046904884-53103b34b206?w=400&q=80',
    'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=400&q=80',
    'https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=400&q=80',
    'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=400&q=80',
  ]
};

const likes = ['2.3K','1.8K','3.1K','980','2.7K','1.5K','4.2K','860'];
const comments = ['47','132','89','23','78','56','201','34'];

let activeSwipers = {};

function buildSocialSlides(platform) {
  const gridId = { instagram: 'insta-grid', facebook: 'fb-grid', pinterest: 'pin-grid' }[platform];
  const grid = document.getElementById(gridId);
  if (grid.children.length > 0) return;
  photoSets[platform].forEach((src, i) => {
    grid.innerHTML += `
      <div class="swiper-slide" style="width:260px">
        <div class="social-post">
          <img src="${src}" alt="post ${i}">
          <div class="social-post-overlay">
            <div class="social-stat">❤️ ${likes[i]}</div>
            <div class="social-stat">💬 ${comments[i]}</div>
          </div>
        </div>
      </div>`;
  });
}

function initSocialSwiper(platform) {
  if (activeSwipers[platform]) return;
  const swiperEl = document.querySelector(`#${platform}-feed .social-feed-swiper`);
  activeSwipers[platform] = new Swiper(swiperEl, {
    slidesPerView: 'auto',
    spaceBetween: 16,
    loop: true,
    autoplay: { delay: 2500, disableOnInteraction: false },
    pagination: { el: swiperEl.querySelector('.swiper-pagination'), clickable: true },
    speed: 700,
  });
}

// Init Instagram on load
buildSocialSlides('instagram');
setTimeout(() => initSocialSwiper('instagram'), 200);

function switchFeed(btn, platform) {
  document.querySelectorAll('.social-tab').forEach(t => t.classList.remove('active'));
  btn.classList.add('active');
  ['instagram','facebook','pinterest'].forEach(p => {
    document.getElementById(`${p}-feed`).style.display = p === platform ? 'block' : 'none';
  });
  buildSocialSlides(platform);
  setTimeout(() => initSocialSwiper(platform), 50);
}

// ── NAVBAR SCROLL ──
window.addEventListener('scroll', () => {
  const nav = document.getElementById('navbar');
  nav.classList.toggle('scrolled', window.scrollY > 60);
});

// ── HAMBURGER ──
document.getElementById('hamburger').addEventListener('click', () => {
  document.getElementById('mobileMenu').classList.toggle('open');
});
function closeMobile() {
  document.getElementById('mobileMenu').classList.remove('open');
}

// ── SCROLL REVEAL ──
const observer = new IntersectionObserver((entries) => {
  entries.forEach(e => {
    if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); }
  });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => observer.observe(el));

// ── CONTACT FORM ──
function handleForm(e) {
  e.preventDefault();
  document.getElementById('form-success').style.display = 'block';
  e.target.reset();
  setTimeout(() => document.getElementById('form-success').style.display = 'none', 5000);
  return false;
}
</script>
</body>
</html>







