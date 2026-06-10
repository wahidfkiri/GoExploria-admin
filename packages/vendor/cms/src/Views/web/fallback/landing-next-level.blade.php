@php
    $siteName = get_site_name($etablissement->id) ?: ($etablissement->name ?? 'Go Exploria Next Level');
    $siteDescription = $etablissement->getSetting('description', null, 'general')
        ?: $etablissement->getSetting('site_description', null, 'general')
        ?: get_site_description($etablissement->id)
        ?: '';
    $devisLink = $devisUrl ?? route('devis');
    $hours = $etablissement->getSetting('opening_hours', [], 'company');
    $workingHours = normalize_cms_opening_hours($hours, $workingHours ?? []);
    $openingHoursText = format_cms_opening_hours($workingHours);
    $socialLinks = $socialLinks ?? get_establishment_social_links($etablissement);
    $visibleSocialLinks = collect($socialLinks ?? [])->filter(fn ($link) => !empty(data_get($link, 'url')))->values();
    $phone = $etablissement->getSetting('phone', null, 'company')
        ?: $etablissement->getSetting('phone', null, 'general')
        ?: $etablissement->getSetting('telephone', null, 'general')
        ?: ($etablissement->phone ?? null)
        ?: ($etablissement->telephone ?? null);
    $email = $etablissement->getSetting('email', null, 'company')
        ?: $etablissement->getSetting('email', null, 'general')
        ?: $etablissement->getSetting('email_contact', null, 'general')
        ?: ($etablissement->email_contact ?? null)
        ?: ($etablissement->email ?? null);
    $address = $etablissement->getSetting('address', null, 'company')
        ?: $etablissement->getSetting('adress', null, 'company')
        ?: $etablissement->getSetting('address', null, 'general')
        ?: $etablissement->getSetting('adresse', null, 'general')
        ?: ($etablissement->adresse ?? null);
    $heroPrimaryCtaText = $etablissement->getSetting('hero_cta_text', null, 'landing')
        ?: $etablissement->getSetting('cta_text', null, 'general');
    $heroPrimaryCtaUrl = $etablissement->getSetting('hero_cta_url', null, 'landing')
        ?: $devisLink;
    $heroSecondaryCtaText = $etablissement->getSetting('hero_secondary_cta_text', null, 'landing');
    $heroSecondaryCtaUrl = $etablissement->getSetting('hero_secondary_cta_url', null, 'landing');

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

    $heroSlides = collect($sliders ?? [])->map(function ($slider) use ($mediaUrl, $heroEmbedUrl) {
        $type = strtolower((string) data_get($slider, 'type', 'image'));
        $url = $mediaUrl(data_get($slider, 'image_url') ?: data_get($slider, 'thumbnail_url') ?: data_get($slider, 'video_url') ?: data_get($slider, 'url') ?: data_get($slider, 'image_path'));
        $embed = $heroEmbedUrl(data_get($slider, 'video_embed_url') ?: data_get($slider, 'embed') ?: ($type === 'iframe' ? data_get($slider, 'url') : null));
        return [
            'type' => $type,
            'url' => $url,
            'embed' => $embed,
            'title' => data_get($slider, 'title'),
            'subtitle' => data_get($slider, 'subtitle') ?: data_get($slider, 'description'),
            'button_text' => data_get($slider, 'button_text'),
            'button_url' => data_get($slider, 'button_url') ?: data_get($slider, 'button_link'),
        ];
    })->filter(fn ($slide) => !empty($slide['url']) || !empty($slide['embed']))->values();
    $nextLevelGalleryFallback = collect();

    $normalizeNextLevelMedia = static function ($items, $fallback) use ($mediaUrl) {
        $media = collect($items ?? [])->map(function ($row) use ($mediaUrl) {
            $url = $mediaUrl(data_get($row, 'thumbnail') ?: data_get($row, 'url') ?: data_get($row, 'path'));
            return [
                'thumbnail' => $url,
                'url' => $mediaUrl(data_get($row, 'url') ?: data_get($row, 'path')) ?: $url,
                'name' => data_get($row, 'name') ?: data_get($row, 'title') ?: 'Photo',
            ];
        })->filter(fn ($row) => !empty($row['thumbnail']))->values();

        return $media->isNotEmpty() ? $media : $fallback->values();
    };

    $nextLevelGallery = $normalizeNextLevelMedia($mainGalleryMedia ?? [], collect());
    if ($nextLevelGallery->isEmpty()) {
        $nextLevelGallery = $normalizeNextLevelMedia($galleryMedia ?? [], collect());
    }
    $nextLevelInstagram = $normalizeNextLevelMedia($instagramGalleryMedia ?? [], collect());
    $nextLevelFacebook = $normalizeNextLevelMedia($facebookGalleryMedia ?? [], collect());
    $nextLevelPinterest = $normalizeNextLevelMedia($pinterestGalleryMedia ?? [], collect());

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

            $establishmentPoints = (clone $baseMapQuery)
                ->where('etablissement_id', $etablissement->id)
                ->limit(80)
                ->get();

            $otherPoints = (clone $baseMapQuery)
                ->where(function ($query) use ($etablissement) {
                    $query->whereNull('etablissement_id')
                        ->orWhere('etablissement_id', '!=', $etablissement->id);
                })
                ->orderByDesc('is_featured')
                ->latest('updated_at')
                ->limit(max(0, 80 - $establishmentPoints->count()))
                ->get();

            $mapQuery = $establishmentPoints
                ->merge($otherPoints)
                ->unique('id')
                ->values();
        }
    } catch (\Throwable $e) {
        $mapQuery = collect();
    }

    $nextLevelMapPoints = $mapQuery->map(function ($point) use ($youtubeIdFromUrl) {
        $video = optional($point->videos->first());
        $youtubeId = $point->youtube_id ?: $video->youtube_id ?: $youtubeIdFromUrl($point->youtube_url ?: $video->youtube_url);
        return [
            'title' => $point->title ?: 'Point Go Exploria',
            'description' => \Illuminate\Support\Str::limit(strip_tags((string) $point->description), 160),
            'category' => strtolower((string) ($point->category ?: 'autre')),
            'lat' => (float) $point->latitude,
            'lng' => (float) $point->longitude,
            'address' => $point->adresse ?: trim(collect([$point->ville, $point->code_postal])->filter()->implode(' ')),
            'video_embed' => $youtubeId ? 'https://www.youtube.com/embed/' . $youtubeId . '?autoplay=1&mute=1&muted=1&playsinline=1&rel=0&modestbranding=1' : null,
        ];
    })->values();

    $heroTitleParts = static function ($title) {
        $words = preg_split('/\s+/', trim((string) $title));
        if (!$words || count($words) < 2) return e($title);
        $last = array_pop($words);
        return e(implode(' ', $words)) . ' <span class="gold">' . e($last) . '</span>';
    };
@endphp<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons@7.2.3/css/flag-icons.min.css"/>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script>
(function () {
  try {
    document.documentElement.classList.add('light');
    localStorage.setItem('go-exploria-theme', 'light');
  } catch (error) {}
})();
</script>
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
.nav-links { display: flex; gap: 32px; list-style: none; align-items: center; }
.nav-links > li { position: relative; }
.nav-links a,
.templates-mega-toggle { color: var(--text); text-decoration: none; font-size: 13px; letter-spacing: 2px; text-transform: uppercase; opacity: 0.75; transition: var(--transition); position: relative; }
.templates-mega-toggle { border: 0; background: transparent; font-family: 'Outfit', sans-serif; cursor: pointer; display: inline-flex; align-items: center; gap: 7px; }
.nav-links a::after,
.templates-mega-toggle::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 1px; background: var(--gold); transition: var(--transition); }
.nav-links a:hover,
.templates-mega-toggle:hover,
.templates-mega.is-open .templates-mega-toggle { opacity: 1; color: var(--gold); }
.nav-links a:hover::after,
.templates-mega-toggle:hover::after,
.templates-mega.is-open .templates-mega-toggle::after { width: 100%; }
.templates-mega-panel {
  position: fixed; top: 76px; left: 50%; transform: translate(-50%, 12px);
  width: min(1380px, calc(100vw - 64px));
  max-height: calc(100vh - 110px);
  overflow-y: auto;
  background: rgba(10,10,10,0.96);
  border: 1px solid rgba(201,168,76,0.2);
  border-radius: 24px;
  padding: 22px;
  opacity: 0;
  visibility: hidden;
  pointer-events: none;
  box-shadow: 0 28px 80px rgba(0,0,0,0.58);
  backdrop-filter: blur(20px);
  transition: var(--transition);
}
nav.scrolled .templates-mega-panel { top: 64px; }
.templates-mega.is-open .templates-mega-panel { opacity: 1; visibility: visible; pointer-events: auto; transform: translate(-50%, 0); }
.templates-mega-head { display: flex; align-items: flex-end; justify-content: space-between; gap: 24px; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 18px; margin-bottom: 18px; }
.templates-mega-kicker { color: var(--gold); font-size: 11px; letter-spacing: 4px; text-transform: uppercase; margin-bottom: 6px; }
.templates-mega-title { font-family: 'Bebas Neue'; font-size: 36px; letter-spacing: 2px; line-height: 0.95; }
.templates-mega-copy { max-width: 380px; color: var(--muted); font-size: 13px; line-height: 1.6; }
.templates-mega-grid { display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); gap: 14px; }
.template-card { position: relative; overflow: hidden; min-height: 260px; border-radius: 18px; padding: 12px; color: var(--text); text-decoration: none; background: linear-gradient(145deg, rgba(201,168,76,0.13), rgba(255,255,255,0.035)); border: 1px solid rgba(255,255,255,0.08); display: flex; flex-direction: column; justify-content: space-between; transition: var(--transition); }
.template-card::before { content: ''; position: absolute; inset: 0; background: radial-gradient(circle at top right, rgba(201,168,76,0.32), transparent 48%); opacity: 0.7; transition: var(--transition); }
.template-card:hover { transform: translateY(-6px); border-color: rgba(201,168,76,0.45); box-shadow: 0 18px 48px rgba(0,0,0,0.42); }
.template-card:hover::before { opacity: 1; transform: scale(1.18); }
.template-card > * { position: relative; z-index: 1; }
.template-card--inactive { opacity: 0.55; cursor: not-allowed; filter: grayscale(0.25); }
.template-card--inactive:hover { transform: none; border-color: rgba(255,255,255,0.08); box-shadow: none; }
.template-card--inactive:hover::before { opacity: 0.7; transform: none; }
.template-card--inactive .template-cta { color: rgba(240,237,230,0.55); }
.template-media { position: relative; height: 92px; border-radius: 14px; overflow: hidden; margin-bottom: 14px; background: var(--dark3); }
.template-media img { width: 100%; height: 100%; object-fit: cover; display: block; filter: saturate(0.95) contrast(1.08); transition: var(--transition); }
.template-card:hover .template-media img { transform: scale(1.08); }
.template-card--inactive:hover .template-media img { transform: none; }
.template-icon { position: absolute; left: 10px; bottom: 10px; width: 36px; height: 36px; border-radius: 12px; display: grid; place-items: center; background: var(--gold); color: var(--dark); font-size: 15px; box-shadow: 0 10px 22px rgba(0,0,0,0.35); }
.template-card h4 { font-family: 'Bebas Neue'; font-size: 20px; line-height: 1; letter-spacing: 1.2px; margin-bottom: 8px; }
.template-card p { color: rgba(240,237,230,0.68); font-size: 11.5px; line-height: 1.48; }
.template-cta { margin-top: 14px; color: var(--gold); font-size: 10.5px; font-weight: 800; letter-spacing: 0.8px; text-transform: uppercase; }
.nav-actions { display: flex; align-items: center; gap: 14px; }
.nav-cta { background: var(--gold); color: var(--dark); padding: 10px 24px; border-radius: 50px; font-size: 13px; font-weight: 600; letter-spacing: 1px; text-decoration: none; transition: var(--transition); }
.nav-cta:hover { background: var(--gold-light); transform: translateY(-2px); box-shadow: 0 8px 30px rgba(201,168,76,0.4); }
.language-switcher { position: relative; }
.lang-current { border: 1px solid rgba(201,168,76,0.28); background: rgba(10,10,10,0.58); color: var(--text); border-radius: 50px; padding: 8px 12px; display: inline-flex; align-items: center; gap: 8px; font-family: 'Outfit', sans-serif; font-size: 12px; font-weight: 800; letter-spacing: 1px; cursor: pointer; backdrop-filter: blur(12px); transition: var(--transition); }
.lang-current:hover,
.language-switcher.is-open .lang-current { background: var(--gold); color: var(--dark); }
.lang-menu { position: absolute; top: calc(100% + 10px); right: 0; min-width: 118px; background: rgba(10,10,10,0.96); border: 1px solid rgba(201,168,76,0.22); border-radius: 16px; padding: 6px; display: grid; gap: 4px; opacity: 0; visibility: hidden; transform: translateY(-8px); box-shadow: 0 18px 44px rgba(0,0,0,0.44); backdrop-filter: blur(16px); transition: var(--transition); }
.language-switcher.is-open .lang-menu { opacity: 1; visibility: visible; transform: translateY(0); }
.lang-btn { width: 100%; border: 0; background: transparent; color: var(--text); border-radius: 12px; padding: 9px 10px; display: inline-flex; align-items: center; gap: 8px; font-family: 'Outfit', sans-serif; font-size: 12px; font-weight: 800; letter-spacing: 0.8px; cursor: pointer; opacity: 0.76; transition: var(--transition); }
.lang-btn:hover,
.lang-btn.is-active { background: var(--gold); color: var(--dark); opacity: 1; }
.lang-flag { width: 18px; height: 13px; border-radius: 3px; box-shadow: 0 0 0 1px rgba(255,255,255,0.18); line-height: 1; background-size: cover; }
.theme-toggle {
  width: 46px;
  height: 26px;
  border: 1px solid rgba(201,168,76,0.28);
  border-radius: 50px;
  cursor: pointer;
  position: relative;
  background: rgba(10,10,10,0.58);
  transition: var(--transition);
  flex-shrink: 0;
  padding: 0;
  color: var(--text);
  backdrop-filter: blur(12px);
}
.theme-toggle::after {
  content: '';
  position: absolute;
  top: 3px;
  left: 3px;
  width: 18px;
  height: 18px;
  border-radius: 50%;
  background: var(--gold);
  transition: transform 0.35s cubic-bezier(0.23, 1, 0.32, 1);
  z-index: 1;
}
.theme-toggle:hover { border-color: var(--gold); }
.theme-toggle-icon {
  position: absolute;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 7px;
  pointer-events: none;
  font-size: 10px;
  line-height: 1;
  z-index: 2;
}
html.light .theme-toggle { background: rgba(255,255,255,0.72); color: var(--text); }
html.light .theme-toggle::after { transform: translateX(20px); }
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
.hero-audio-toggle {
  position: absolute; right: 40px; top: 50%; transform: translateY(-50%); z-index: 12;
  width: 52px; height: 52px;
  display: inline-flex; align-items: center; justify-content: center;
  border: 1px solid rgba(201,168,76,0.45);
  background: rgba(10,10,10,0.72);
  color: var(--text);
  border-radius: 50%;
  padding: 0;
  font-size: 18px;
  cursor: pointer;
  backdrop-filter: blur(14px);
  transition: var(--transition);
}
.hero-audio-toggle:hover,
.hero-audio-toggle.is-active {
  background: var(--gold);
  color: var(--dark);
  transform: translateY(-50%) scale(1.08);
}
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
.testi-right { flex: 1; min-width: 0; width: 100%; position: relative; }
.testi-swiper { overflow: hidden; width: 100%; padding: 6px 6px 58px !important; margin: -6px; }
.testi-swiper .swiper-wrapper { align-items: stretch; }
.testi-swiper .swiper-slide { height: auto; display: flex; }
.testi-card {
  position: relative;
  width: 100%;
  min-height: 360px;
  background: linear-gradient(145deg, var(--dark4), rgba(26,26,26,0.92));
  border: 1px solid rgba(201,168,76,0.14);
  border-radius: var(--radius);
  padding: 38px;
  height: 100%;
  display: flex;
  flex-direction: column;
  overflow: hidden;
  box-shadow: 0 24px 70px rgba(0,0,0,0.24);
}
.testi-card::before {
  content: '';
  position: absolute;
  inset: 0;
  background: radial-gradient(circle at top right, rgba(201,168,76,0.18), transparent 42%);
  pointer-events: none;
}
.testi-card > * { position: relative; z-index: 1; }
.testi-quote { font-size: 40px; color: var(--gold); line-height: 1; margin-bottom: 16px; font-family: 'Playfair Display'; }
.testi-text { font-size: 15px; line-height: 1.9; color: rgba(255,255,255,0.8); margin-bottom: 28px; font-style: italic; flex: 1; }
.testi-author { display: flex; align-items: center; gap: 16px; margin-top: auto; }
.testi-avatar { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid var(--gold); }
.testi-name { font-weight: 600; font-size: 15px; }
.testi-dest { font-size: 12px; color: var(--gold); letter-spacing: 1px; margin-top: 2px; }
.testi-stars { font-size: 13px; color: var(--gold); margin-bottom: 4px; }
.testi-swiper .swiper-pagination { bottom: 10px !important; }
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
.next-cms-pages { background: var(--dark2); }
.next-cms-pages .container { display: grid; gap: 24px; }
.next-cms-page { background: var(--dark3); border: 1px solid rgba(255,255,255,0.08); border-radius: var(--radius); padding: clamp(24px, 4vw, 48px); }
.next-cms-page-content { color: var(--muted); line-height: 1.8; }
.next-cms-page-content :where(h1,h2,h3,h4,h5,h6) { color: var(--text); margin: 0 0 16px; line-height: 1.08; }
.next-cms-page-content :where(p,ul,ol,blockquote,figure) { margin: 0 0 18px; }
.next-cms-page-content :where(img,video,iframe) { max-width: 100%; border-radius: var(--radius-sm); }

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
.map-commercial-header { background: var(--dark); padding: 72px 20px 34px; text-align: center; border-top: 1px solid rgba(201,168,76,0.14); }
.map-commercial-header .section-label { margin-bottom: 12px; }
.map-commercial-header h2 { font-family: 'Bebas Neue'; font-size: clamp(42px, 7vw, 86px); line-height: 0.95; letter-spacing: 3px; color: var(--text); margin-bottom: 16px; }
.map-commercial-header h2 span { color: var(--gold); }
.map-commercial-header p { max-width: 680px; margin: 0 auto; color: var(--muted); font-size: 15px; line-height: 1.8; }
.next-level-map { width: 100%; height: 100%; min-height: 500px; background: var(--dark2); }
.next-level-map .leaflet-tile-pane { filter: invert(90%) hue-rotate(200deg) saturate(0.8); }
.next-level-marker-wrap { width: 26px; height: 26px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); display: grid; place-items: center; color: var(--dark); border: 2px solid rgba(255,255,255,0.9); box-shadow: 0 8px 22px rgba(0,0,0,0.38); }
.next-level-marker-wrap i { transform: rotate(45deg); font-size: 12px; line-height: 1; }
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
.back-to-top {
  position: fixed; bottom: 30px; left: 30px; z-index: 990;
  width: 54px; height: 54px; border-radius: 50%;
  border: 1px solid rgba(201,168,76,0.45);
  background: rgba(10,10,10,0.78);
  color: var(--gold);
  display: inline-flex; align-items: center; justify-content: center;
  font-size: 18px;
  cursor: pointer;
  opacity: 0;
  pointer-events: none;
  transform: translateY(14px);
  backdrop-filter: blur(14px);
  box-shadow: 0 10px 34px rgba(0,0,0,0.38);
  transition: var(--transition);
}
.back-to-top.is-visible {
  opacity: 1;
  pointer-events: auto;
  transform: translateY(0);
}
.back-to-top:hover {
  background: var(--gold);
  color: var(--dark);
  transform: translateY(-4px);
}

/* ─── RESPONSIVE ─── */
@media (max-width: 1024px) {
  .gallery-grid { grid-template-columns: repeat(2, 1fr); grid-template-rows: auto; }
  .gallery-item:nth-child(1) { grid-column: span 2; grid-row: span 1; }
  .gallery-item:nth-child(5) { grid-column: span 1; }
  .templates-mega-grid { grid-template-columns: repeat(3, 1fr); }
  .blog-grid { grid-template-columns: 1fr 1fr; }
  .blog-card.featured { grid-column: span 2; }
  .footer-grid { grid-template-columns: 1fr 1fr; gap: 40px; }
  .testimonials-wrap { flex-direction: column; gap: 40px; }
  .testi-left { flex: none; width: 100%; }
  .testi-right { width: 100%; max-width: 100%; }
  .contact-grid { grid-template-columns: 1fr; gap: 60px; }
}
@media (max-width: 768px) {
  nav { padding: 16px 20px; }
  nav.scrolled { padding: 12px 20px; }
  .nav-links, .nav-cta { display: none; }
  .templates-mega-panel { display: none; }
  .nav-actions { gap: 8px; margin-left: auto; margin-right: 14px; }
  .lang-current { padding: 8px 10px; font-size: 11px; }
  .lang-menu { right: -4px; }
  .hamburger { display: flex; }
  section { padding: 70px 20px; }
  .hero-stats { display: none; }
  .hero-content { left: 20px; right: 20px; bottom: 20%; }
  .hero-audio-toggle { right: 20px; top: 50%; width: 46px; height: 46px; }
  .gallery-grid { grid-template-columns: 1fr 1fr; grid-template-rows: auto; }
  .gallery-item:nth-child(1) { grid-column: span 2; }
  .blog-grid { grid-template-columns: 1fr; }
  .blog-card.featured { grid-column: span 1; }
  .footer-grid { grid-template-columns: 1fr; }
  .form-row { grid-template-columns: 1fr; }
  .testi-card { min-height: 0; padding: 30px 24px; }
  .footer-bottom { flex-direction: column; text-align: center; }
  .map-overlay { display: none; }
}

.hero-slide-bg iframe { width: 100%; height: 100%; border: 0; position: absolute; inset: 0; object-fit: cover; pointer-events: none; }

html.light {
  --dark: #f5f2ec;
  --dark2: #ede9e0;
  --dark3: #e4dfd4;
  --dark4: #d8d2c6;
  --text: #1a1410;
  --muted: #6b6258;
  --accent: #1aaa82;
}
html.light body {
  background: var(--dark);
  color: var(--text);
}
html.light ::-webkit-scrollbar-track { background: var(--dark); }
html.light nav {
  background: linear-gradient(to bottom, rgba(245,242,236,0.92) 0%, transparent 100%);
}
html.light nav.scrolled {
  background: rgba(245,242,236,0.97);
  border-bottom: 1px solid rgba(201,168,76,0.25);
  box-shadow: 0 4px 30px rgba(0,0,0,0.08);
}
html.light .nav-logo span:last-child,
html.light .nav-links a,
html.light .templates-mega-toggle,
html.light .hamburger span,
html.light .mobile-menu a { color: var(--text); }
html.light .hamburger span { background: var(--text); }
html.light .mobile-menu { background: var(--dark); }
html.light .templates-mega-panel,
html.light .lang-menu {
  background: rgba(245,242,236,0.97);
  border-color: rgba(201,168,76,0.28);
  box-shadow: 0 28px 80px rgba(0,0,0,0.16);
}
html.light .templates-mega-head { border-bottom-color: rgba(0,0,0,0.08); }
html.light .templates-mega-copy,
html.light .template-card p { color: var(--muted); }
html.light .template-card {
  color: var(--text);
  background: #fff;
  border-color: rgba(0,0,0,0.08);
  box-shadow: 0 2px 16px rgba(0,0,0,0.04);
}
html.light .template-card:hover { box-shadow: 0 18px 48px rgba(0,0,0,0.12); }
html.light .template-media { background: var(--dark3); }
html.light .template-card--inactive .template-cta { color: rgba(26,20,16,0.5); }
html.light .lang-current {
  background: rgba(255,255,255,0.72);
  color: var(--text);
}
html.light .lang-current:hover,
html.light .language-switcher.is-open .lang-current,
html.light .lang-btn:hover,
html.light .lang-btn.is-active {
  background: var(--gold);
  color: var(--dark);
}
html.light .lang-btn { color: var(--text); }
html.light .lang-flag { box-shadow: 0 0 0 1px rgba(0,0,0,0.12); }
html.light .hero-overlay {
  background: linear-gradient(135deg, rgba(245,242,236,0.55) 0%, rgba(245,242,236,0.1) 60%, rgba(245,242,236,0.3) 100%);
}
html.light .hero-title { color: #fff; text-shadow: 0 2px 30px rgba(0,0,0,0.6); }
html.light .hero-sub,
html.light .stat-label { color: rgba(255,255,255,0.76); }
html.light .btn-outline {
  border-color: rgba(255,255,255,0.7);
  color: #fff;
}
html.light .btn-outline:hover {
  border-color: var(--gold);
  color: var(--gold);
}
html.light .hero-audio-toggle {
  background: rgba(255,255,255,0.72);
  color: var(--text);
}
html.light #services,
html.light #testimonials,
html.light #contact { background: var(--dark2); }
html.light #gallery,
html.light #social { background: var(--dark3); }
html.light #blog { background: var(--dark); }
html.light .service-card,
html.light .testi-card,
html.light .blog-card {
  background: #fff;
  border-color: rgba(201,168,76,0.15);
  box-shadow: 0 2px 16px rgba(0,0,0,0.05);
}
html.light .service-card:hover,
html.light .blog-card:hover { box-shadow: 0 20px 60px rgba(0,0,0,0.12); }
html.light .service-card h3,
html.light .blog-card h3,
html.light .contact-info h3,
html.light .social-handle-text strong { color: var(--text); }
html.light .service-card p,
html.light .testi-text,
html.light .blog-card p,
html.light .blog-meta,
html.light .contact-item span,
html.light .social-handle-text span,
html.light .form-group label { color: var(--muted); }
html.light .service-arrow,
html.light .social-btn {
  border-color: rgba(0,0,0,0.12);
  color: var(--text);
}
html.light .service-card:hover .service-arrow,
html.light .social-btn:hover { color: var(--dark); }
html.light .platform-badge,
html.light .social-tabs {
  background: #fff;
  border-color: rgba(0,0,0,0.1);
  color: var(--text);
}
html.light .social-tab { color: var(--muted); }
html.light .form-group input,
html.light .form-group select,
html.light .form-group textarea,
html.light .footer-newsletter input {
  background: #fff;
  border-color: rgba(0,0,0,0.12);
  color: var(--text);
}
html.light .form-group input:focus,
html.light .form-group select:focus,
html.light .form-group textarea:focus,
html.light .footer-newsletter input:focus {
  background: rgba(201,168,76,0.04);
  border-color: var(--gold);
}
html.light .form-group select option { background: #fff; color: var(--text); }
html.light .map-overlay {
  background: #fff;
  border-color: rgba(201,168,76,0.3);
  box-shadow: 0 20px 60px rgba(0,0,0,0.12);
}
html.light .map-overlay p { color: var(--muted); }
html.light footer {
  background: #e0dbd0;
  border-top-color: rgba(201,168,76,0.2);
}
html.light .footer-brand p,
html.light .footer-col ul li a,
html.light .footer-bottom p,
html.light .footer-bottom-links a { color: var(--muted); }
html.light .footer-bottom { border-top-color: rgba(0,0,0,0.08); }
html.light .back-to-top,
html.light .float-cta {
  box-shadow: 0 14px 34px rgba(0,0,0,0.16);
}
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
    <li class="templates-mega" id="templatesMega">
      <button type="button" class="templates-mega-toggle" id="templatesMegaToggle" aria-expanded="false">
        Nos templates <i class="fas fa-chevron-down" aria-hidden="true"></i>
      </button>
      <div class="templates-mega-panel" role="menu" aria-label="Nos templates">
        <div class="templates-mega-head">
          <div>
            <p class="templates-mega-kicker">Templates premium</p>
            <div class="templates-mega-title">Choisissez votre univers digital</div>
          </div>
          <p class="templates-mega-copy">Des bases visuelles prêtes à personnaliser pour lancer rapidement une présence web moderne, professionnelle et orientée conversion.</p>
        </div>
        <div class="templates-mega-grid">
          <a href="{{ asset('templates/next-level/agence-marketing.html') }}" class="template-card" role="menuitem" target="_blank" rel="noopener">
            <div>
              <div class="template-media">
                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=500&q=80" alt="Agence marketing digitale">
                <div class="template-icon"><i class="fas fa-bullhorn" aria-hidden="true"></i></div>
              </div>
              <h4>Agence marketing digitale</h4>
              <p>Landing dynamique pour agences, consultants, campagnes et services de croissance.</p>
            </div>
            <span class="template-cta">Voir ce template</span>
          </a>
          <a href="{{ asset('templates/next-level/travel-tourism.html') }}" class="template-card" role="menuitem" target="_blank" rel="noopener">
            <div>
              <div class="template-media">
                <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=500&q=80" alt="Travel & tourism">
                <div class="template-icon"><i class="fas fa-plane-departure" aria-hidden="true"></i></div>
              </div>
              <h4>Travel & tourism</h4>
              <p>Expériences, destinations, cartes vidéo et storytelling immersif pour le tourisme.</p>
            </div>
            <span class="template-cta">Voir ce template</span>
          </a>
          <a href="{{ asset('templates/next-level/location-vehicule.html') }}" class="template-card" role="menuitem" target="_blank" rel="noopener">
            <div>
              <div class="template-media">
                <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=500&q=80" alt="Location des véhicules">
                <div class="template-icon"><i class="fas fa-car-side" aria-hidden="true"></i></div>
              </div>
              <h4>Location des véhicules</h4>
              <p>Flotte, disponibilités, offres premium et parcours de réservation pour locations auto.</p>
            </div>
            <span class="template-cta">Voir ce template</span>
          </a>
          <a href="{{ asset('templates/next-level/garage-automobile.html') }}" class="template-card" role="menuitem" target="_blank" rel="noopener">
            <div>
              <div class="template-media">
                <img src="https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=500&q=80" alt="Garage automobile">
                <div class="template-icon"><i class="fas fa-screwdriver-wrench" aria-hidden="true"></i></div>
              </div>
              <h4>Garage automobile</h4>
              <p>Atelier, réparations, entretien, diagnostic et prise de rendez-vous pour services auto.</p>
            </div>
            <span class="template-cta">Voir ce template</span>
          </a>
          <a href="{{ asset('templates/next-level/garage-reparation-auto.html') }}" class="template-card" role="menuitem" target="_blank" rel="noopener">
            <div>
              <div class="template-media">
                <img src="https://images.unsplash.com/photo-1615906655593-ad0386982a0f?w=500&q=80" alt="Garage réparation automobile">
                <div class="template-icon"><i class="fas fa-car-burst" aria-hidden="true"></i></div>
              </div>
              <h4>Garage réparation auto</h4>
              <p>Services mécaniques, entretien, pneus, diagnostic et suivi client pour atelier auto.</p>
            </div>
            <span class="template-cta">Voir ce template</span>
          </a>
          <a href="{{ asset('templates/next-level/autopro-garage.html') }}" class="template-card" role="menuitem" target="_blank" rel="noopener">
            <div>
              <div class="template-media">
                <img src="https://images.unsplash.com/photo-1621905252507-b35492cc74b4?w=500&q=80" alt="AutoPro garage">
                <div class="template-icon"><i class="fas fa-wrench" aria-hidden="true"></i></div>
              </div>
              <h4>AutoPro garage</h4>
              <p>Landing compacte pour garage automobile, services, forfaits, équipe et rendez-vous.</p>
            </div>
            <span class="template-cta">Voir ce template</span>
          </a>
          <a href="{{ asset('templates/next-level/media-news.html') }}" class="template-card" role="menuitem" target="_blank" rel="noopener">
            <div>
              <div class="template-media">
                <img src="https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=500&q=80" alt="Médias & news">
                <div class="template-icon"><i class="fas fa-newspaper" aria-hidden="true"></i></div>
              </div>
              <h4>Médias & news</h4>
              <p>Format éditorial moderne pour articles, actualités, vidéos et contenus sociaux.</p>
            </div>
            <span class="template-cta">Voir ce template</span>
          </a>
          <a href="{{ asset('templates/next-level/cabinet-conseil.html') }}" class="template-card" role="menuitem" target="_blank" rel="noopener">
            <div>
              <div class="template-media">
                <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=500&q=80" alt="Commerce local premium">
                <div class="template-icon"><i class="fas fa-store" aria-hidden="true"></i></div>
              </div>
              <h4>Commerce local premium</h4>
              <p>Vitrine élégante pour produits, services, avis clients et demandes de devis.</p>
            </div>
            <span class="template-cta">Voir ce template</span>
          </a>
          <a href="#" class="template-card template-card--inactive" role="menuitem" aria-disabled="true">
            <div>
              <div class="template-media">
                <img src="https://images.unsplash.com/photo-1556761175-b413da4baf72?w=500&q=80" alt="Cabinet conseil">
                <div class="template-icon"><i class="fas fa-briefcase" aria-hidden="true"></i></div>
              </div>
              <h4>Cabinet conseil</h4>
              <p>Présentation premium pour consultants, coachs, experts et services professionnels.</p>
            </div>
            <span class="template-cta">Voir ce template</span>
          </a>
          <a href="#" class="template-card template-card--inactive" role="menuitem" aria-disabled="true">
            <div>
              <div class="template-media">
                <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=500&q=80" alt="SaaS & startup">
                <div class="template-icon"><i class="fas fa-rocket" aria-hidden="true"></i></div>
              </div>
              <h4>SaaS & startup</h4>
              <p>Hero produit, fonctionnalités, preuves sociales et conversion pour logiciels et apps.</p>
            </div>
            <span class="template-cta">Voir ce template</span>
          </a>
          <a href="#" class="template-card template-card--inactive" role="menuitem" aria-disabled="true">
            <div>
              <div class="template-media">
                <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=500&q=80" alt="Formation & coaching">
                <div class="template-icon"><i class="fas fa-chalkboard-user" aria-hidden="true"></i></div>
              </div>
              <h4>Formation & coaching</h4>
              <p>Parcours clair pour programmes, cours, ateliers, inscriptions et accompagnement.</p>
            </div>
            <span class="template-cta">Voir ce template</span>
          </a>
          <a href="{{ asset('templates/next-level/immobilier-premium.html') }}" class="template-card" role="menuitem" target="_blank" rel="noopener">
            <div>
              <div class="template-media">
                <img src="https://images.unsplash.com/photo-1518005020951-eccb494ad742?w=500&q=80" alt="Immobilier premium">
                <div class="template-icon"><i class="fas fa-house-chimney-window" aria-hidden="true"></i></div>
              </div>
              <h4>Immobilier premium</h4>
              <p>Biens vedettes, visites vidéo, cartes, galerie et demandes de visite ou de devis.</p>
            </div>
            <span class="template-cta">Voir ce template</span>
          </a>
          <a href="{{ asset('templates/next-level/restaurant-bistro-noir.html') }}" class="template-card" role="menuitem" target="_blank" rel="noopener">
            <div>
              <div class="template-media">
                <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=500&q=80" alt="Restaurant & food">
                <div class="template-icon"><i class="fas fa-utensils" aria-hidden="true"></i></div>
              </div>
              <h4>Restaurant & food</h4>
              <p>Menus, ambiance, avis clients, galerie gourmande et parcours réservation/devis.</p>
            </div>
            <span class="template-cta">Voir ce template</span>
          </a>
          <a href="#" class="template-card template-card--inactive" role="menuitem" aria-disabled="true">
            <div>
              <div class="template-media">
                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&q=80" alt="Portfolio créatif">
                <div class="template-icon"><i class="fas fa-palette" aria-hidden="true"></i></div>
              </div>
              <h4>Portfolio créatif</h4>
              <p>Showcase visuel pour designers, photographes, artistes, studios et freelances.</p>
            </div>
            <span class="template-cta">Voir ce template</span>
          </a>
          <a href="{{ asset('templates/next-level/sante-bien-etre.html') }}" class="template-card" role="menuitem" target="_blank" rel="noopener">
            <div>
              <div class="template-media">
                <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=500&q=80" alt="Santé & bien-être">
                <div class="template-icon"><i class="fas fa-heart-pulse" aria-hidden="true"></i></div>
              </div>
              <h4>Santé & bien-être</h4>
              <p>Services, horaires, équipe, témoignages et prise de contact pour professionnels santé.</p>
            </div>
            <span class="template-cta">Voir ce template</span>
          </a>
          <a href="{{ \Illuminate\Support\Facades\Route::has('cms.videos.channel') ? route('cms.videos.channel') : url('/chaine-videos') }}" class="template-card" role="menuitem" target="_blank" rel="noopener">
            <div>
              <div class="template-media">
                <img src="https://images.unsplash.com/photo-1497015289639-54688650d173?w=500&q=80" alt="Chaine videos">
                <div class="template-icon"><i class="fas fa-video" aria-hidden="true"></i></div>
              </div>
              <h4>Chaine videos</h4>
              <p>Hub video avec sources sliders, CMS media, recherche AJAX et suggestions.</p>
            </div>
            <span class="template-cta">Voir ce template</span>
          </a>
          <a href="#" class="template-card template-card--inactive" role="menuitem" aria-disabled="true">
            <div>
              <div class="template-media">
                <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=500&q=80" alt="Finance & assurance">
                <div class="template-icon"><i class="fas fa-chart-pie" aria-hidden="true"></i></div>
              </div>
              <h4>Finance & assurance</h4>
              <p>Structure fiable pour services financiers, assurances, rendez-vous et formulaires qualifiés.</p>
            </div>
            <span class="template-cta">Voir ce template</span>
          </a>
        </div>
      </div>
    </li>
    <li><a href="#gallery">Galerie</a></li>
    <li><a href="#testimonials">Avis</a></li>
    <li><a href="#social">Social</a></li>
    <li><a href="#blog">Blog</a></li>
    <li><a href="#contact">Contact</a></li>
  </ul>
  <div class="nav-actions">
    <a href="#contact" class="nav-cta">Demander un devis</a>
    <div class="language-switcher" id="languageSwitcher">
      <button type="button" class="lang-current" id="langCurrent" aria-label="Choisir la langue" aria-expanded="false">
        <span class="fi fi-fr lang-flag" aria-hidden="true"></span><span class="lang-code">FR</span><i class="fas fa-chevron-down" aria-hidden="true"></i>
      </button>
      <div class="lang-menu" role="menu" aria-label="Choisir la langue">
        <button type="button" class="lang-btn is-active" data-lang="fr" role="menuitem" aria-label="Français"><span class="fi fi-fr lang-flag" aria-hidden="true"></span><span class="lang-code">FR</span></button>
        <button type="button" class="lang-btn" data-lang="en" role="menuitem" aria-label="English"><span class="fi fi-gb lang-flag" aria-hidden="true"></span><span class="lang-code">EN</span></button>
        <button type="button" class="lang-btn" data-lang="es" role="menuitem" aria-label="Español"><span class="fi fi-es lang-flag" aria-hidden="true"></span><span class="lang-code">ES</span></button>
        <button type="button" class="lang-btn" data-lang="de" role="menuitem" aria-label="Deutsch"><span class="fi fi-de lang-flag" aria-hidden="true"></span><span class="lang-code">DE</span></button>
        <button type="button" class="lang-btn" data-lang="it" role="menuitem" aria-label="Italiano"><span class="fi fi-it lang-flag" aria-hidden="true"></span><span class="lang-code">IT</span></button>
        <button type="button" class="lang-btn" data-lang="ar" role="menuitem" aria-label="العربية"><span class="fi fi-sa lang-flag" aria-hidden="true"></span><span class="lang-code">AR</span></button>
      </div>
    </div>
  </div>
  <div class="hamburger" id="hamburger">
    <span></span><span></span><span></span>
  </div>
</nav>

<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobileMenu">
  <a href="#services" onclick="closeMobile()">Services</a>
  <a href="#contact" onclick="closeMobile()">Nos templates</a>
  <a href="#gallery" onclick="closeMobile()">Galerie</a>
  <a href="#testimonials" onclick="closeMobile()">Avis</a>
  <a href="#social" onclick="closeMobile()">Social</a>
  <a href="#blog" onclick="closeMobile()">Blog</a>
  <a href="#contact" onclick="closeMobile()">Contact</a>
</div>

<!-- HERO -->
    @include('cms::web.fallback.partials.landing-cms-header')
@if(is_slider_enabled($etablissement->id))
@if(has_slider($etablissement->id))
{!! get_slider_html($etablissement->id) !!}
@else
<section id="hero">
  <div class="swiper hero-swiper">
    <div class="swiper-wrapper">
      @foreach($heroSlides as $slide)
        <div class="swiper-slide">
          <div class="hero-slide-bg" @if(empty($slide['embed']) && (($slide['type'] ?? 'image') !== 'video')) style="background-image:url('{{ $slide['url'] }}')" @endif>
            @if(!empty($slide['embed']))
              <iframe src="{{ $slide['embed'] }}" title="{{ $slide['title'] }}" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
            @elseif(($slide['type'] ?? 'image') === 'video')
              <video src="{{ $slide['url'] }}" autoplay muted loop playsinline preload="metadata" data-hero-local-video="true"></video>
            @endif
          </div>
          <div class="hero-overlay"></div>
          <div class="hero-content">
            <h1 class="hero-title">{!! $heroTitleParts($slide['title']) !!}</h1>
            <p class="hero-sub">{{ $slide['subtitle'] }}</p>
            <div class="hero-btns">
              @if(!empty($slide['button_text']) && !empty($slide['button_url']))
                <a href="{{ $slide['button_url'] }}" target="_blank" class="btn-primary">{{ $slide['button_text'] }} →</a>
              @endif
              @if(!empty($heroSecondaryCtaText) && !empty($heroSecondaryCtaUrl))
                <a href="{{ $heroSecondaryCtaUrl }}" target="_blank" class="btn-outline"><i class="fas fa-play" aria-hidden="true"></i> {{ $heroSecondaryCtaText }}</a>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="swiper-pagination"></div>
  </div>
  <button type="button" class="hero-audio-toggle" id="heroAudioToggle" aria-pressed="false" aria-label="Activer le son de la vidéo">
    <i class="fas fa-volume-xmark" aria-hidden="true"></i>
  </button>
</section>
@endif
@endif

@include('cms::web.fallback.partials.landing-map-video-points')

@if(collect($cmsPageSections ?? [])->isNotEmpty())
    @foreach(collect($cmsPageSections) as $cmsPage)
          {!! data_get($cmsPage, 'content') !!}
    @endforeach
@endif






<!-- SOCIAL FEED -->
@if($nextLevelInstagram->isNotEmpty() || $nextLevelFacebook->isNotEmpty() || $nextLevelPinterest->isNotEmpty())
<section id="social">
  <div class="container">
    <p class="section-label reveal">Suivez-nous</p>
    <h2 class="section-title reveal delay-1">NOS <span>RÉSEAUX</span></h2>
    <div class="social-tabs reveal delay-3">
      @if($nextLevelInstagram->isNotEmpty())<button class="social-tab active" onclick="switchFeed(this,'instagram')"><i class="fab fa-instagram" aria-hidden="true"></i> Instagram</button>@endif
      @if($nextLevelFacebook->isNotEmpty())<button class="social-tab{{ $nextLevelInstagram->isEmpty() ? ' active' : '' }}" onclick="switchFeed(this,'facebook')"><i class="fab fa-facebook-f" aria-hidden="true"></i> Facebook</button>@endif
      @if($nextLevelPinterest->isNotEmpty())<button class="social-tab{{ $nextLevelInstagram->isEmpty() && $nextLevelFacebook->isEmpty() ? ' active' : '' }}" onclick="switchFeed(this,'pinterest')"><i class="fab fa-pinterest-p" aria-hidden="true"></i> Pinterest</button>@endif
    </div>
    @if($nextLevelInstagram->isNotEmpty())
    <div id="instagram-feed" style="{{ $nextLevelInstagram->isNotEmpty() ? '' : 'display:none' }}">
      <div class="swiper social-feed-swiper">
        <div class="swiper-wrapper" id="insta-grid">
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
    @endif
    @if($nextLevelFacebook->isNotEmpty())
    <div id="facebook-feed" style="{{ $nextLevelInstagram->isEmpty() ? '' : 'display:none' }}">
      <div class="swiper social-feed-swiper">
        <div class="swiper-wrapper" id="fb-grid"></div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
    @endif
    @if($nextLevelPinterest->isNotEmpty())
    <div id="pinterest-feed" style="{{ $nextLevelInstagram->isEmpty() && $nextLevelFacebook->isEmpty() ? '' : 'display:none' }}">
      <div class="swiper social-feed-swiper">
        <div class="swiper-wrapper" id="pin-grid"></div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
    @endif
  </div>
</section>
@endif

<!-- BLOG -->
@if(is_blog_enabled($etablissement->id) && collect($blogPosts ?? [])->filter(fn ($post) => trim((string) data_get($post, 'title')) !== '')->isNotEmpty())
@php
  $nextLevelBlogSectionTitle = function_exists('get_blog_section_title')
    ? get_blog_section_title($etablissement->id)
    : '';
  $nextLevelBlogSectionTitle = trim((string) $nextLevelBlogSectionTitle);
  $nextLevelBlogs = collect($blogPosts ?? [])->filter(fn ($post) => trim((string) data_get($post, 'title')) !== '')->take(5)->values()->map(function ($post) {
    return [
      'title' => data_get($post, 'title'),
      'excerpt' => data_get($post, 'excerpt'),
      'image' => data_get($post, 'image'),
      'tag' => data_get($post, 'tag'),
      'date' => data_get($post, 'date'),
      'reading_time' => data_get($post, 'reading_time'),
      'url' => data_get($post, 'url') ?: '#blog',
    ];
  });
@endphp
<section id="blog">
  <div class="container">
    <p class="section-label reveal">Inspirations & Conseils</p>
    @if($nextLevelBlogSectionTitle !== '')<h2 class="section-title reveal delay-1">{{ $nextLevelBlogSectionTitle }}</h2>@endif
    <div class="blog-grid">
      @foreach($nextLevelBlogs as $blog)
        @php
          $blogUrl = data_get($blog, 'url') ?: '#blog';
          $isExternalBlogUrl = !\Illuminate\Support\Str::startsWith($blogUrl, '#');
          $blogTargetAttrs = $isExternalBlogUrl ? ' target="_blank" rel="noopener noreferrer"' : '';
          $blogClass = $loop->first ? 'blog-card featured reveal' : 'blog-card reveal' . ($loop->iteration === 2 || $loop->iteration === 5 ? ' delay-1' : ($loop->iteration === 3 ? ' delay-2' : ''));
        @endphp
        <div class="{{ $blogClass }}">
          @if(data_get($blog, 'image'))
            <div class="blog-img">
              <img src="{{ data_get($blog, 'image') }}" alt="{{ data_get($blog, 'title') }}">
              @if(data_get($blog, 'tag'))<span class="blog-tag">{{ data_get($blog, 'tag') }}</span>@endif
            </div>
          @endif
          <div class="blog-body">
            @if(data_get($blog, 'date') || data_get($blog, 'reading_time'))
              <div class="blog-meta">
                @if(data_get($blog, 'date'))<span>{{ data_get($blog, 'date') }}</span>@endif
                @if(data_get($blog, 'date') && data_get($blog, 'reading_time'))<span>·</span>@endif
                @if(data_get($blog, 'reading_time'))<span>{{ data_get($blog, 'reading_time') }} min{{ $loop->first ? ' de lecture' : '' }}</span>@endif
              </div>
            @endif
            <h3>{{ data_get($blog, 'title') }}</h3>
            @if($loop->first && data_get($blog, 'excerpt'))
              <p>{{ data_get($blog, 'excerpt') }}</p>
            @endif
            <a href="{{ $blogUrl }}" class="blog-read"{!! $blogTargetAttrs !!}>{{ $loop->first ? "Lire l'article" : 'Lire' }} →</a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- CONTACT -->
@include('cms::web.fallback.partials.landing-working-hours')

<section id="contact">
  <div class="container">
    <p class="section-label reveal">Parlons de votre voyage</p>
    <h2 class="section-title reveal delay-1">CONTACTEZ-<span>NOUS</span></h2>
    <div class="contact-grid">
      <div class="contact-info reveal-left">
        <h3>Planifions votre aventure</h3>
        @if($address)
          <div class="contact-item">
            <div class="contact-icon"><i class="fas fa-location-dot" aria-hidden="true"></i></div>
            <div>
              <strong>Adresse</strong>
              <span>{{ $address }}</span>
            </div>
          </div>
        @endif
        @if($phone)
          <div class="contact-item">
            <div class="contact-icon"><i class="fas fa-phone" aria-hidden="true"></i></div>
            <div>
              <strong>Téléphone</strong>
              <span>{{ $phone }}</span>
            </div>
          </div>
        @endif
        @if($email)
          <div class="contact-item">
            <div class="contact-icon"><i class="fas fa-envelope" aria-hidden="true"></i></div>
            <div>
              <strong>Email</strong>
              <span>{{ $email }}</span>
            </div>
          </div>
        @endif
        @if($openingHoursText)
          <div class="contact-item">
            <div class="contact-icon"><i class="fas fa-clock" aria-hidden="true"></i></div>
            <div>
              <strong>Horaires</strong>
              <span>{{ $openingHoursText }}</span>
            </div>
          </div>
        @endif
        @if($visibleSocialLinks->isNotEmpty())
          <div class="contact-socials">
            @foreach($visibleSocialLinks as $link)
              <a href="{{ $link['url'] }}" class="social-btn" aria-label="{{ $link['label'] }}" target="_blank" rel="noopener noreferrer"><i class="{{ $link['icon'] }}" aria-hidden="true"></i></a>
            @endforeach
          </div>
        @endif
      </div>
      <form class="contact-form reveal-right" method="POST" action="{{ route('cms.company.contact.send', ['etablissementId' => $etablissement->id]) }}" data-cms-contact-form data-cms-form-name="landing_next_level">
        @csrf
        <div class="form-row">
          <div class="form-group">
            <label>Prénom *</label>
            <input type="text" name="first_name" placeholder="Votre prénom" required>
          </div>
          <div class="form-group">
            <label>Nom *</label>
            <input type="text" name="last_name" placeholder="Votre nom" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Email *</label>
            <input type="email" name="email" placeholder="votre@email.com" required>
          </div>
          <div class="form-group">
            <label>Téléphone</label>
            <input type="tel" name="phone" placeholder="(418) 525-7748">
          </div>
        </div>
        <div class="form-group">
          <label>Type de service</label>
          <select name="service">
            <option value="">Choisir un service...</option>
            <option>Création site web</option>
            <option>Marketing digital</option>
            <option>SEO & optimisation</option>
            <option>Boutique en ligne</option>
            <option>Identité visuelle</option>
            <option>Contenu photo & vidéo</option>
            <option>Analytics & performance</option>
            <option>Maintenance & sécurité</option>
            <option>Automatisation IA</option>
          </select>
        </div>
        <div class="form-group">
          <label>Budget estimé</label>
          <select name="budget">
            <option>Moins de 500 €</option>
            <option>500 € – 1500 €</option>
            <option>1500 € – 3000 €</option>
            <option>Plus de 3000 €</option>
          </select>
        </div>
        <div class="form-group">
          <label>Votre message *</label>
          <textarea rows="4" name="message" placeholder="Décrivez votre rêve de voyage..." required></textarea>
        </div>
        <button type="submit" class="btn-submit">
          <span>Envoyer ma demande</span> <i class="fas fa-paper-plane" aria-hidden="true"></i>
        </button>
        <div id="form-success" style="display:none;background:rgba(46,216,168,0.1);border:1px solid var(--accent);border-radius:10px;padding:14px 20px;font-size:14px;color:var(--accent);margin-top:8px;">
          ✓ Message envoyé avec succès ! Nous vous répondrons dans les 24h.
        </div>
      </form>
    </div>
  </div>
</section>

@include('cms::web.fallback.partials.landing-media-slideshow')
@include('cms::web.fallback.partials.landing-contact-ajax')

<!-- FOOTER -->
@include('cms::web.fallback.partials.landing-cms-footer')
<footer>
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <div class="footer-logo">GO EXPLORIA</div>
        <p>Votre partenaire de confiance pour des aventures de voyage inoubliables. Nous créons des expériences qui transforment les perspectives et les vies.</p>
        @if(!empty($socialLinks))
          <div class="contact-socials">
            @foreach($socialLinks as $link)
              <a href="{{ $link['url'] }}" class="social-btn" aria-label="{{ $link['label'] }}" target="_blank" rel="noopener noreferrer"><i class="{{ $link['icon'] }}" aria-hidden="true"></i></a>
            @endforeach
          </div>
        @endif
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
          <button aria-label="Envoyer"><i class="fas fa-arrow-right" aria-hidden="true"></i></button>
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
<button type="button" class="back-to-top" id="backToTop" aria-label="Retour en haut">
  <i class="fas fa-arrow-up" aria-hidden="true"></i>
</button>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
// ── LIGHT THEME ONLY ──
(function () {
  const html = document.documentElement;
  const prefKey = 'go-exploria-theme';

  html.classList.add('light');
  try {
    localStorage.setItem(prefKey, 'light');
  } catch (error) {}
})();

// ── LOCAL LANGUAGE DICTIONARY ──
const nextLevelTranslations = {
  fr: {},
  en: {
    'Services': 'Services',
    'Nos templates': 'Our templates',
    'Templates premium': 'Premium templates',
    'Choisissez votre univers digital': 'Choose your digital universe',
    'Des bases visuelles prêtes à personnaliser pour lancer rapidement une présence web moderne, professionnelle et orientée conversion.': 'Visual foundations ready to customize so you can quickly launch a modern, professional and conversion-focused web presence.',
    'Agence marketing digitale': 'Digital marketing agency',
    'Landing dynamique pour agences, consultants, campagnes et services de croissance.': 'Dynamic landing page for agencies, consultants, campaigns and growth services.',
    'Travel & tourism': 'Travel & tourism',
    'Expériences, destinations, cartes vidéo et storytelling immersif pour le tourisme.': 'Experiences, destinations, video maps and immersive storytelling for tourism.',
    'Location des véhicules': 'Vehicle rental',
    'Flotte, disponibilités, offres premium et parcours de réservation pour locations auto.': 'Fleet, availability, premium offers and booking journey for car rentals.',
    'Médias & news': 'Media & news',
    'Format éditorial moderne pour articles, actualités, vidéos et contenus sociaux.': 'Modern editorial format for articles, news, videos and social content.',
    'Commerce local premium': 'Premium local commerce',
    'Vitrine élégante pour produits, services, avis clients et demandes de devis.': 'Elegant showcase for products, services, client reviews and quote requests.',
    'Cabinet conseil': 'Consulting firm',
    'Présentation premium pour consultants, coachs, experts et services professionnels.': 'Premium presentation for consultants, coaches, experts and professional services.',
    'SaaS & startup': 'SaaS & startup',
    'Hero produit, fonctionnalités, preuves sociales et conversion pour logiciels et apps.': 'Product hero, features, social proof and conversion for software and apps.',
    'Formation & coaching': 'Training & coaching',
    'Parcours clair pour programmes, cours, ateliers, inscriptions et accompagnement.': 'Clear journey for programs, courses, workshops, signups and support.',
    'Immobilier premium': 'Premium real estate',
    'Biens vedettes, visites vidéo, cartes, galerie et demandes de visite ou de devis.': 'Featured properties, video tours, maps, gallery and visit or quote requests.',
    'Restaurant & food': 'Restaurant & food',
    'Menus, ambiance, avis clients, galerie gourmande et parcours réservation/devis.': 'Menus, atmosphere, client reviews, food gallery and booking or quote path.',
    'Portfolio créatif': 'Creative portfolio',
    'Showcase visuel pour designers, photographes, artistes, studios et freelances.': 'Visual showcase for designers, photographers, artists, studios and freelancers.',
    'Santé & bien-être': 'Health & wellness',
    'Services, horaires, équipe, témoignages et prise de contact pour professionnels santé.': 'Services, opening hours, team, testimonials and contact path for health professionals.',
    'Finance & assurance': 'Finance & insurance',
    'Structure fiable pour services financiers, assurances, rendez-vous et formulaires qualifiés.': 'Reliable structure for financial services, insurance, appointments and qualified forms.',
    'Voir ce template': 'View this template',
    'Galerie': 'Gallery',
    'Avis': 'Reviews',
    'Social': 'Social',
    'Blog': 'Blog',
    'Contact': 'Contact',
    'Demander un devis': 'Request a quote',
    'Nos Voyages': 'Our trips',
    'Nos services': 'Our services',
    'Son désactivé': 'Sound off',
    'Son activé': 'Sound on',
    'Scroll': 'Scroll',
    'Site vitrine': 'Showcase website',
    'Boutique en ligne': 'Online store',
    'Restaurant': 'Restaurant',
    'Tourisme': 'Tourism',
    'Immobilier': 'Real estate',
    'Marketplace': 'Marketplace',
    'Portfolio': 'Portfolio',
    'Blog professionnel': 'Business blog',
    'Ce que nous offrons': 'What we offer',
    'NOS': 'OUR',
    'SERVICES': 'SERVICES',
    'Des solutions web et marketing pensées pour propulser votre présence en ligne, attirer plus de clients et convertir vos visiteurs en demandes concrètes.': 'Web and marketing solutions built to boost your online presence, attract more clients and turn visitors into real inquiries.',
    'Création site web': 'Website creation',
    'Sites vitrines modernes, rapides et responsive, conçus pour présenter votre activité avec une image professionnelle et rassurante.': 'Modern, fast and responsive showcase websites designed to present your business with a professional and reassuring image.',
    'Marketing digital': 'Digital marketing',
    'Campagnes ciblées, stratégie de visibilité et tunnels de conversion pour transformer votre audience en clients qualifiés.': 'Targeted campaigns, visibility strategy and conversion funnels to turn your audience into qualified clients.',
    'SEO & optimisation': 'SEO & optimization',
    'Optimisation technique, contenus structurés et performance pour améliorer votre classement Google et votre expérience utilisateur.': 'Technical optimization, structured content and performance improvements to strengthen your Google ranking and user experience.',
    'Boutique en ligne': 'Online store',
    "Création de pages produits, parcours d'achat fluide, demandes de devis et vitrines e-commerce adaptées à vos offres.": 'Product pages, smooth buying paths, quote requests and e-commerce showcases tailored to your offers.',
    'Identité visuelle': 'Visual identity',
    'Direction artistique, choix des couleurs, typographies et univers visuel pour rendre votre marque immédiatement reconnaissable.': 'Art direction, colors, typography and visual universe to make your brand instantly recognizable.',
    'Contenu photo & vidéo': 'Photo & video content',
    'Mise en valeur de vos services, lieux, produits et témoignages avec des contenus visuels pensés pour le web et les réseaux sociaux.': 'Showcase your services, places, products and testimonials with visuals designed for web and social media.',
    'Analytics & performance': 'Analytics & performance',
    'Suivi des visites, conversions, sources de trafic et indicateurs clés pour piloter vos actions avec des données claires.': 'Track visits, conversions, traffic sources and key indicators to guide your actions with clear data.',
    'Maintenance & sécurité': 'Maintenance & security',
    'Surveillance, corrections, mises à jour, sauvegardes et accompagnement pour garder votre présence web fiable et durable.': 'Monitoring, fixes, updates, backups and support to keep your web presence reliable and durable.',
    'Automatisation IA': 'AI automation',
    'Formulaires intelligents, réponses rapides, génération de contenus et outils connectés pour gagner du temps au quotidien.': 'Smart forms, quick replies, content generation and connected tools to save time every day.',
    'Nos Destinations': 'Our Destinations',
    'GALERIE': 'PHOTO',
    'PHOTOS': 'GALLERY',
    "Plongez dans l'univers visuel de Go Exploria. Chaque image raconte une histoire, chaque lieu est une invitation.": 'Step into Go Exploria’s visual universe. Every image tells a story, every place is an invitation.',
    "Ce qu'ils disent": 'What they say',
    'AVIS': 'CLIENT',
    'CLIENTS': 'REVIEWS',
    'Basé sur 486 avis vérifiés': 'Based on 486 verified reviews',
    'Suivez-nous': 'Follow us',
    'RÉSEAUX': 'NETWORKS',
    'Rejoignez notre communauté de voyageurs et partagez vos aventures avec le hashtag #GoExploriaNextLevel': 'Join our travel community and share your adventures with #GoExploriaNextLevel',
    '12.4K abonnés · 340 publications': '12.4K followers · 340 posts',
    "8.2K J'aime · 8.7K abonnés": '8.2K likes · 8.7K followers',
    '3.1K abonnés · 24 tableaux': '3.1K followers · 24 boards',
    'Inspirations & Conseils': 'Inspiration & Tips',
    'NOTRE': 'OUR',
    'Des articles pour inspirer vos prochains voyages, des conseils pratiques et des récits d\'aventures vécues.': 'Articles to inspire your next trips, practical tips and real adventure stories.',
    'À La Une': 'Featured',
    'Lire l\'article →': 'Read article →',
    'Lire →': 'Read →',
    'Parlons de votre voyage': 'Let’s talk about your trip',
    'CONTACTEZ-': 'CONTACT',
    'NOUS': 'US',
    'Planifions votre aventure': 'Let’s plan your adventure',
    'Notre équipe de passionnés est à votre disposition pour vous aider à concevoir le voyage de vos rêves. Répondons à vos questions dans les 24h.': 'Our passionate team is here to help design the trip of your dreams. We answer your questions within 24 hours.',
    'Adresse': 'Address',
    'Téléphone': 'Phone',
    'Email': 'Email',
    'Horaires': 'Opening hours',
    'Lun–Sam : 9h–19h | Dim : 10h–16h': 'Mon-Sat: 9am-7pm | Sun: 10am-4pm',
    'Prénom *': 'First name *',
    'Nom *': 'Last name *',
    'Type de voyage': 'Trip type',
    'Type de service': 'Service type',
    'Budget estimé': 'Estimated budget',
    'Votre message *': 'Your message *',
    'Choisir un service...': 'Choose a service...',
    'Moins de 500 €': 'Less than €500',
    '500 € – 1500 €': '€500 – €1500',
    '1500 € – 3000 €': '€1500 – €3000',
    'Plus de 3000 €': 'More than €3000',
    'Envoyer ma demande': 'Send my request',
    '✓ Message envoyé avec succès ! Nous vous répondrons dans les 24h.': '✓ Message sent successfully! We will reply within 24 hours.',
    'Votre visibilité locale': 'Your local visibility',
    'Affichez votre entreprise': 'Showcase your business',
    'sur la carte du monde': 'on the world map',
    "Transformez chaque point sur la carte en vitrine interactive avec vos informations, vos vidéos et vos lieux d'intérêt.": 'Turn every map point into an interactive showcase with your information, videos and points of interest.',
    'Navigation': 'Navigation',
    'Nos Services': 'Our Services',
    'Avis Clients': 'Client Reviews',
    'Voyages': 'Trips',
    'Newsletter': 'Newsletter',
    'Recevez nos offres exclusives et inspirations voyage directement dans votre boîte mail.': 'Receive exclusive offers and travel inspiration directly in your inbox.',
    '© 2025 Go Exploria Next Level. Tous droits réservés.': '© 2025 Go Exploria Next Level. All rights reserved.',
    'Mentions légales': 'Legal notice',
    'Confidentialité': 'Privacy',
    'CGV': 'Terms',
    'Votre prénom': 'Your first name',
    'Votre nom': 'Your last name',
    'votre@email.com': 'your@email.com',
    'Décrivez votre rêve de voyage...': 'Describe your dream trip...',
    'Envoyer': 'Send',
    'Activer le son de la vidéo': 'Turn video sound on',
    'Désactiver le son de la vidéo': 'Turn video sound off',
    'Retour en haut': 'Back to top',
  },
  es: {
    'Services': 'Servicios',
    'Nos templates': 'Nuestras plantillas',
    'Templates premium': 'Plantillas premium',
    'Choisissez votre univers digital': 'Elija su universo digital',
    'Des bases visuelles prêtes à personnaliser pour lancer rapidement une présence web moderne, professionnelle et orientée conversion.': 'Bases visuales listas para personalizar y lanzar rápidamente una presencia web moderna, profesional y orientada a la conversión.',
    'Agence marketing digitale': 'Agencia de marketing digital',
    'Landing dynamique pour agences, consultants, campagnes et services de croissance.': 'Landing dinámica para agencias, consultores, campañas y servicios de crecimiento.',
    'Travel & tourism': 'Viajes y turismo',
    'Expériences, destinations, cartes vidéo et storytelling immersif pour le tourisme.': 'Experiencias, destinos, mapas de video y storytelling inmersivo para turismo.',
    'Location des véhicules': 'Alquiler de vehículos',
    'Flotte, disponibilités, offres premium et parcours de réservation pour locations auto.': 'Flota, disponibilidad, ofertas premium y recorrido de reserva para alquiler de coches.',
    'Médias & news': 'Medios y noticias',
    'Format éditorial moderne pour articles, actualités, vidéos et contenus sociaux.': 'Formato editorial moderno para artículos, noticias, videos y contenido social.',
    'Commerce local premium': 'Comercio local premium',
    'Vitrine élégante pour produits, services, avis clients et demandes de devis.': 'Vitrina elegante para productos, servicios, reseñas y solicitudes de presupuesto.',
    'Cabinet conseil': 'Consultoría',
    'Présentation premium pour consultants, coachs, experts et services professionnels.': 'Presentación premium para consultores, coaches, expertos y servicios profesionales.',
    'SaaS & startup': 'SaaS y startup',
    'Hero produit, fonctionnalités, preuves sociales et conversion pour logiciels et apps.': 'Hero de producto, funcionalidades, prueba social y conversión para software y apps.',
    'Formation & coaching': 'Formación y coaching',
    'Parcours clair pour programmes, cours, ateliers, inscriptions et accompagnement.': 'Recorrido claro para programas, cursos, talleres, inscripciones y acompañamiento.',
    'Immobilier premium': 'Inmobiliaria premium',
    'Biens vedettes, visites vidéo, cartes, galerie et demandes de visite ou de devis.': 'Propiedades destacadas, visitas en video, mapas, galería y solicitudes de visita o presupuesto.',
    'Restaurant & food': 'Restaurante y gastronomía',
    'Menus, ambiance, avis clients, galerie gourmande et parcours réservation/devis.': 'Menús, ambiente, reseñas, galería gastronómica y recorrido de reserva o presupuesto.',
    'Portfolio créatif': 'Portafolio creativo',
    'Showcase visuel pour designers, photographes, artistes, studios et freelances.': 'Showcase visual para diseñadores, fotógrafos, artistas, estudios y freelancers.',
    'Santé & bien-être': 'Salud y bienestar',
    'Services, horaires, équipe, témoignages et prise de contact pour professionnels santé.': 'Servicios, horarios, equipo, testimonios y contacto para profesionales de salud.',
    'Finance & assurance': 'Finanzas y seguros',
    'Structure fiable pour services financiers, assurances, rendez-vous et formulaires qualifiés.': 'Estructura fiable para servicios financieros, seguros, citas y formularios cualificados.',
    'Voir ce template': 'Ver esta plantilla',
    'Galerie': 'Galería',
    'Avis': 'Reseñas',
    'Social': 'Social',
    'Blog': 'Blog',
    'Contact': 'Contacto',
    'Demander un devis': 'Solicitar presupuesto',
    'Nos Voyages': 'Nuestros viajes',
    'Nos services': 'Nuestros servicios',
    'Son désactivé': 'Sonido desactivado',
    'Son activé': 'Sonido activado',
    'Scroll': 'Desplazar',
    'Site vitrine': 'Sitio corporativo',
    'Boutique en ligne': 'Tienda online',
    'Restaurant': 'Restaurante',
    'Tourisme': 'Turismo',
    'Immobilier': 'Inmobiliaria',
    'Marketplace': 'Marketplace',
    'Portfolio': 'Portafolio',
    'Blog professionnel': 'Blog profesional',
    'Ce que nous offrons': 'Lo que ofrecemos',
    'NOS': 'NUESTROS',
    'SERVICES': 'SERVICIOS',
    'Des solutions web et marketing pensées pour propulser votre présence en ligne, attirer plus de clients et convertir vos visiteurs en demandes concrètes.': 'Soluciones web y marketing pensadas para impulsar su presencia online, atraer más clientes y convertir visitantes en solicitudes concretas.',
    'Création site web': 'Creación de sitio web',
    'Sites vitrines modernes, rapides et responsive, conçus pour présenter votre activité avec une image professionnelle et rassurante.': 'Sitios modernos, rápidos y responsive diseñados para presentar su actividad con una imagen profesional y confiable.',
    'Marketing digital': 'Marketing digital',
    'Campagnes ciblées, stratégie de visibilité et tunnels de conversion pour transformer votre audience en clients qualifiés.': 'Campañas segmentadas, estrategia de visibilidad y embudos de conversión para transformar su audiencia en clientes cualificados.',
    'SEO & optimisation': 'SEO y optimización',
    'Optimisation technique, contenus structurés et performance pour améliorer votre classement Google et votre expérience utilisateur.': 'Optimización técnica, contenidos estructurados y rendimiento para mejorar su posicionamiento en Google y la experiencia del usuario.',
    'Boutique en ligne': 'Tienda online',
    "Création de pages produits, parcours d'achat fluide, demandes de devis et vitrines e-commerce adaptées à vos offres.": 'Creación de páginas de producto, proceso de compra fluido, solicitudes de presupuesto y vitrinas e-commerce adaptadas a sus ofertas.',
    'Identité visuelle': 'Identidad visual',
    'Direction artistique, choix des couleurs, typographies et univers visuel pour rendre votre marque immédiatement reconnaissable.': 'Dirección artística, colores, tipografías y universo visual para hacer que su marca sea reconocible al instante.',
    'Contenu photo & vidéo': 'Contenido foto y video',
    'Mise en valeur de vos services, lieux, produits et témoignages avec des contenus visuels pensés pour le web et les réseaux sociaux.': 'Puesta en valor de sus servicios, lugares, productos y testimonios con contenidos visuales pensados para web y redes sociales.',
    'Analytics & performance': 'Analytics y rendimiento',
    'Suivi des visites, conversions, sources de trafic et indicateurs clés pour piloter vos actions avec des données claires.': 'Seguimiento de visitas, conversiones, fuentes de tráfico e indicadores clave para dirigir sus acciones con datos claros.',
    'Maintenance & sécurité': 'Mantenimiento y seguridad',
    'Surveillance, corrections, mises à jour, sauvegardes et accompagnement pour garder votre présence web fiable et durable.': 'Supervisión, correcciones, actualizaciones, copias de seguridad y soporte para mantener su presencia web fiable y duradera.',
    'Automatisation IA': 'Automatización IA',
    'Formulaires intelligents, réponses rapides, génération de contenus et outils connectés pour gagner du temps au quotidien.': 'Formularios inteligentes, respuestas rápidas, generación de contenidos y herramientas conectadas para ahorrar tiempo cada día.',
    'Nos Destinations': 'Nuestros destinos',
    'GALERIE': 'GALERÍA',
    'PHOTOS': 'FOTOS',
    "Plongez dans l'univers visuel de Go Exploria. Chaque image raconte une histoire, chaque lieu est une invitation.": 'Entre en el universo visual de Go Exploria. Cada imagen cuenta una historia, cada lugar es una invitación.',
    "Ce qu'ils disent": 'Lo que dicen',
    'AVIS': 'RESEÑAS',
    'CLIENTS': 'CLIENTES',
    'Basé sur 486 avis vérifiés': 'Basado en 486 reseñas verificadas',
    'Suivez-nous': 'Síganos',
    'RÉSEAUX': 'REDES',
    'Rejoignez notre communauté de voyageurs et partagez vos aventures avec le hashtag #GoExploriaNextLevel': 'Únase a nuestra comunidad de viajeros y comparta sus aventuras con #GoExploriaNextLevel',
    '12.4K abonnés · 340 publications': '12.4K seguidores · 340 publicaciones',
    "8.2K J'aime · 8.7K abonnés": '8.2K me gusta · 8.7K seguidores',
    '3.1K abonnés · 24 tableaux': '3.1K seguidores · 24 tableros',
    'Inspirations & Conseils': 'Inspiración y consejos',
    'NOTRE': 'NUESTRO',
    'Des articles pour inspirer vos prochains voyages, des conseils pratiques et des récits d\'aventures vécues.': 'Artículos para inspirar sus próximos viajes, consejos prácticos y relatos de aventuras reales.',
    'À La Une': 'Destacado',
    'Lire l\'article →': 'Leer artículo →',
    'Lire →': 'Leer →',
    'Parlons de votre voyage': 'Hablemos de su viaje',
    'CONTACTEZ-': 'CONTÁCTE',
    'NOUS': 'NOS',
    'Planifions votre aventure': 'Planifiquemos su aventura',
    'Notre équipe de passionnés est à votre disposition pour vous aider à concevoir le voyage de vos rêves. Répondons à vos questions dans les 24h.': 'Nuestro equipo apasionado está a su disposición para diseñar el viaje de sus sueños. Respondemos sus preguntas en 24 horas.',
    'Adresse': 'Dirección',
    'Téléphone': 'Teléfono',
    'Email': 'Correo',
    'Horaires': 'Horario',
    'Lun–Sam : 9h–19h | Dim : 10h–16h': 'Lun-Sáb: 9h-19h | Dom: 10h-16h',
    'Prénom *': 'Nombre *',
    'Nom *': 'Apellido *',
    'Type de voyage': 'Tipo de viaje',
    'Type de service': 'Tipo de servicio',
    'Budget estimé': 'Presupuesto estimado',
    'Votre message *': 'Su mensaje *',
    'Choisir un service...': 'Elegir un servicio...',
    'Moins de 500 €': 'Menos de 500 €',
    '500 € – 1500 €': '500 € – 1500 €',
    '1500 € – 3000 €': '1500 € – 3000 €',
    'Plus de 3000 €': 'Más de 3000 €',
    'Envoyer ma demande': 'Enviar mi solicitud',
    '✓ Message envoyé avec succès ! Nous vous répondrons dans les 24h.': '✓ Mensaje enviado correctamente. Le responderemos en 24 horas.',
    'Votre visibilité locale': 'Su visibilidad local',
    'Affichez votre entreprise': 'Muestre su empresa',
    'sur la carte du monde': 'en el mapa mundial',
    "Transformez chaque point sur la carte en vitrine interactive avec vos informations, vos vidéos et vos lieux d'intérêt.": 'Transforme cada punto del mapa en una vitrina interactiva con su información, videos y lugares de interés.',
    'Navigation': 'Navegación',
    'Nos Services': 'Nuestros servicios',
    'Avis Clients': 'Reseñas de clientes',
    'Voyages': 'Viajes',
    'Newsletter': 'Boletín',
    'Recevez nos offres exclusives et inspirations voyage directement dans votre boîte mail.': 'Reciba ofertas exclusivas e inspiración de viaje directamente en su correo.',
    '© 2025 Go Exploria Next Level. Tous droits réservés.': '© 2025 Go Exploria Next Level. Todos los derechos reservados.',
    'Mentions légales': 'Aviso legal',
    'Confidentialité': 'Privacidad',
    'CGV': 'Condiciones',
    'Votre prénom': 'Su nombre',
    'Votre nom': 'Su apellido',
    'votre@email.com': 'su@email.com',
    'Décrivez votre rêve de voyage...': 'Describa su viaje soñado...',
    'Envoyer': 'Enviar',
    'Activer le son de la vidéo': 'Activar sonido del video',
    'Désactiver le son de la vidéo': 'Desactivar sonido del video',
    'Retour en haut': 'Volver arriba',
  },
  de: {
    'Choisir la langue': 'Sprache wählen',
    'Services': 'Services',
    'Nos templates': 'Unsere Templates',
    'Templates premium': 'Premium-Templates',
    'Choisissez votre univers digital': 'Wählen Sie Ihre digitale Welt',
    'Des bases visuelles prêtes à personnaliser pour lancer rapidement une présence web moderne, professionnelle et orientée conversion.': 'Visuelle Grundlagen, die schnell angepasst werden können, um eine moderne, professionelle und conversion-orientierte Webpräsenz zu starten.',
    'Agence marketing digitale': 'Digitale Marketingagentur',
    'Landing dynamique pour agences, consultants, campagnes et services de croissance.': 'Dynamische Landingpage für Agenturen, Berater, Kampagnen und Wachstumsservices.',
    'Travel & tourism': 'Travel & Tourism',
    'Expériences, destinations, cartes vidéo et storytelling immersif pour le tourisme.': 'Erlebnisse, Reiseziele, Videokarten und immersives Storytelling für den Tourismus.',
    'Location des véhicules': 'Fahrzeugvermietung',
    'Flotte, disponibilités, offres premium et parcours de réservation pour locations auto.': 'Flotte, Verfügbarkeiten, Premium-Angebote und Buchungsstrecke für Autovermietungen.',
    'Médias & news': 'Medien & News',
    'Format éditorial moderne pour articles, actualités, vidéos et contenus sociaux.': 'Modernes redaktionelles Format für Artikel, Nachrichten, Videos und Social Content.',
    'Commerce local premium': 'Premium lokaler Handel',
    'Vitrine élégante pour produits, services, avis clients et demandes de devis.': 'Elegantes Schaufenster für Produkte, Services, Kundenbewertungen und Angebotsanfragen.',
    'Cabinet conseil': 'Beratungsfirma',
    'Présentation premium pour consultants, coachs, experts et services professionnels.': 'Premium-Präsentation für Berater, Coaches, Experten und professionelle Dienstleistungen.',
    'SaaS & startup': 'SaaS & Startup',
    'Hero produit, fonctionnalités, preuves sociales et conversion pour logiciels et apps.': 'Produkt-Hero, Funktionen, Social Proof und Conversion für Software und Apps.',
    'Formation & coaching': 'Training & Coaching',
    'Parcours clair pour programmes, cours, ateliers, inscriptions et accompagnement.': 'Klarer Ablauf für Programme, Kurse, Workshops, Anmeldungen und Betreuung.',
    'Immobilier premium': 'Premium-Immobilien',
    'Biens vedettes, visites vidéo, cartes, galerie et demandes de visite ou de devis.': 'Top-Immobilien, Videotouren, Karten, Galerie und Anfragen für Besichtigungen oder Angebote.',
    'Restaurant & food': 'Restaurant & Food',
    'Menus, ambiance, avis clients, galerie gourmande et parcours réservation/devis.': 'Menüs, Atmosphäre, Kundenbewertungen, Food-Galerie und Reservierungs- oder Angebotsstrecke.',
    'Portfolio créatif': 'Kreativportfolio',
    'Showcase visuel pour designers, photographes, artistes, studios et freelances.': 'Visuelles Showcase für Designer, Fotografen, Künstler, Studios und Freelancer.',
    'Santé & bien-être': 'Gesundheit & Wellness',
    'Services, horaires, équipe, témoignages et prise de contact pour professionnels santé.': 'Services, Öffnungszeiten, Team, Referenzen und Kontaktaufnahme für Gesundheitsprofis.',
    'Finance & assurance': 'Finanzen & Versicherung',
    'Structure fiable pour services financiers, assurances, rendez-vous et formulaires qualifiés.': 'Zuverlässige Struktur für Finanzservices, Versicherungen, Termine und qualifizierte Formulare.',
    'Voir ce template': 'Dieses Template ansehen',
    'Galerie': 'Galerie',
    'Avis': 'Bewertungen',
    'Social': 'Social',
    'Blog': 'Blog',
    'Contact': 'Kontakt',
    'Demander un devis': 'Angebot anfordern',
    'Nos Voyages': 'Unsere Reisen',
    'Nos services': 'Unsere Services',
    'Son désactivé': 'Ton aus',
    'Son activé': 'Ton an',
    'Scroll': 'Scrollen',
    'Site vitrine': 'Unternehmenswebsite',
    'Boutique en ligne': 'Onlineshop',
    'Restaurant': 'Restaurant',
    'Tourisme': 'Tourismus',
    'Immobilier': 'Immobilien',
    'Marketplace': 'Marktplatz',
    'Portfolio': 'Portfolio',
    'Blog professionnel': 'Business-Blog',
    'Ce que nous offrons': 'Was wir anbieten',
    'NOS': 'UNSERE',
    'SERVICES': 'SERVICES',
    'Des solutions web et marketing pensées pour propulser votre présence en ligne, attirer plus de clients et convertir vos visiteurs en demandes concrètes.': 'Web- und Marketinglösungen, die Ihre Online-Präsenz stärken, mehr Kunden gewinnen und Besucher in konkrete Anfragen verwandeln.',
    'Création site web': 'Website-Erstellung',
    'Sites vitrines modernes, rapides et responsive, conçus pour présenter votre activité avec une image professionnelle et rassurante.': 'Moderne, schnelle und responsive Websites, die Ihr Unternehmen professionell und vertrauenswürdig präsentieren.',
    'Marketing digital': 'Digitales Marketing',
    'Campagnes ciblées, stratégie de visibilité et tunnels de conversion pour transformer votre audience en clients qualifiés.': 'Gezielte Kampagnen, Sichtbarkeitsstrategie und Conversion-Funnels, um Ihre Zielgruppe in qualifizierte Kunden zu verwandeln.',
    'SEO & optimisation': 'SEO & Optimierung',
    'Optimisation technique, contenus structurés et performance pour améliorer votre classement Google et votre expérience utilisateur.': 'Technische Optimierung, strukturierte Inhalte und Performance, um Ihr Google-Ranking und die Nutzererfahrung zu verbessern.',
    'Boutique en ligne': 'Onlineshop',
    "Création de pages produits, parcours d'achat fluide, demandes de devis et vitrines e-commerce adaptées à vos offres.": 'Produktseiten, reibungslose Kaufstrecken, Angebotsanfragen und E-Commerce-Präsentationen passend zu Ihren Angeboten.',
    'Identité visuelle': 'Visuelle Identität',
    'Direction artistique, choix des couleurs, typographies et univers visuel pour rendre votre marque immédiatement reconnaissable.': 'Art Direction, Farben, Typografie und visuelle Welt, damit Ihre Marke sofort wiedererkennbar wird.',
    'Contenu photo & vidéo': 'Foto- & Videoinhalte',
    'Mise en valeur de vos services, lieux, produits et témoignages avec des contenus visuels pensés pour le web et les réseaux sociaux.': 'Präsentation Ihrer Services, Orte, Produkte und Referenzen mit visuellen Inhalten für Web und soziale Medien.',
    'Analytics & performance': 'Analytics & Performance',
    'Suivi des visites, conversions, sources de trafic et indicateurs clés pour piloter vos actions avec des données claires.': 'Tracking von Besuchen, Conversions, Traffic-Quellen und Kennzahlen für klare datenbasierte Entscheidungen.',
    'Maintenance & sécurité': 'Wartung & Sicherheit',
    'Surveillance, corrections, mises à jour, sauvegardes et accompagnement pour garder votre présence web fiable et durable.': 'Überwachung, Korrekturen, Updates, Backups und Betreuung für eine zuverlässige und nachhaltige Web-Präsenz.',
    'Automatisation IA': 'KI-Automatisierung',
    'Formulaires intelligents, réponses rapides, génération de contenus et outils connectés pour gagner du temps au quotidien.': 'Intelligente Formulare, schnelle Antworten, Content-Generierung und vernetzte Tools, um täglich Zeit zu sparen.',
    'Nos Destinations': 'Unsere Ziele',
    'GALERIE': 'FOTO',
    'PHOTOS': 'GALERIE',
    "Plongez dans l'univers visuel de Go Exploria. Chaque image raconte une histoire, chaque lieu est une invitation.": 'Tauchen Sie in die visuelle Welt von Go Exploria ein. Jedes Bild erzählt eine Geschichte, jeder Ort ist eine Einladung.',
    "Ce qu'ils disent": 'Was Kunden sagen',
    'AVIS': 'KUNDEN',
    'CLIENTS': 'BEWERTUNGEN',
    'Basé sur 486 avis vérifiés': 'Basierend auf 486 geprüften Bewertungen',
    'Suivez-nous': 'Folgen Sie uns',
    'RÉSEAUX': 'NETZWERKE',
    'Rejoignez notre communauté de voyageurs et partagez vos aventures avec le hashtag #GoExploriaNextLevel': 'Treten Sie unserer Community bei und teilen Sie Ihre Projekte mit #GoExploriaNextLevel',
    '12.4K abonnés · 340 publications': '12,4K Follower · 340 Beiträge',
    "8.2K J'aime · 8.7K abonnés": '8,2K Likes · 8,7K Follower',
    '3.1K abonnés · 24 tableaux': '3,1K Follower · 24 Boards',
    'Inspirations & Conseils': 'Inspiration & Tipps',
    'NOTRE': 'UNSER',
    'Des articles pour inspirer vos prochains voyages, des conseils pratiques et des récits d\'aventures vécues.': 'Artikel, die Ihre nächsten Projekte inspirieren, praktische Tipps und echte Erfolgsgeschichten.',
    'À La Une': 'Im Fokus',
    'Lire l\'article →': 'Artikel lesen →',
    'Lire →': 'Lesen →',
    'Parlons de votre voyage': 'Sprechen wir über Ihr Projekt',
    'CONTACTEZ-': 'KONTAKTIEREN',
    'NOUS': 'SIE UNS',
    'Planifions votre aventure': 'Planen wir Ihr Projekt',
    'Notre équipe de passionnés est à votre disposition pour vous aider à concevoir le voyage de vos rêves. Répondons à vos questions dans les 24h.': 'Unser engagiertes Team hilft Ihnen, Ihr digitales Projekt zu planen. Wir antworten innerhalb von 24 Stunden.',
    'Adresse': 'Adresse',
    'Téléphone': 'Telefon',
    'Email': 'E-Mail',
    'Horaires': 'Öffnungszeiten',
    'Lun–Sam : 9h–19h | Dim : 10h–16h': 'Mo-Sa: 9-19 Uhr | So: 10-16 Uhr',
    'Prénom *': 'Vorname *',
    'Nom *': 'Nachname *',
    'Type de voyage': 'Projekttyp',
    'Type de service': 'Serviceart',
    'Budget estimé': 'Geschätztes Budget',
    'Votre message *': 'Ihre Nachricht *',
    'Choisir un service...': 'Service auswählen...',
    'Moins de 500 €': 'Weniger als 500 €',
    '500 € – 1500 €': '500 € – 1500 €',
    '1500 € – 3000 €': '1500 € – 3000 €',
    'Plus de 3000 €': 'Mehr als 3000 €',
    'Envoyer ma demande': 'Anfrage senden',
    '✓ Message envoyé avec succès ! Nous vous répondrons dans les 24h.': '✓ Nachricht erfolgreich gesendet! Wir antworten innerhalb von 24 Stunden.',
    'Votre visibilité locale': 'Ihre lokale Sichtbarkeit',
    'Affichez votre entreprise': 'Präsentieren Sie Ihr Unternehmen',
    'sur la carte du monde': 'auf der Weltkarte',
    "Transformez chaque point sur la carte en vitrine interactive avec vos informations, vos vidéos et vos lieux d'intérêt.": 'Verwandeln Sie jeden Kartenpunkt in ein interaktives Schaufenster mit Informationen, Videos und interessanten Orten.',
    'Navigation': 'Navigation',
    'Nos Services': 'Unsere Services',
    'Avis Clients': 'Kundenbewertungen',
    'Voyages': 'Reisen',
    'Newsletter': 'Newsletter',
    'Recevez nos offres exclusives et inspirations voyage directement dans votre boîte mail.': 'Erhalten Sie exklusive Angebote und Inspiration direkt per E-Mail.',
    '© 2025 Go Exploria Next Level. Tous droits réservés.': '© 2025 Go Exploria Next Level. Alle Rechte vorbehalten.',
    'Mentions légales': 'Impressum',
    'Confidentialité': 'Datenschutz',
    'CGV': 'AGB',
    'Votre prénom': 'Ihr Vorname',
    'Votre nom': 'Ihr Nachname',
    'votre@email.com': 'ihre@email.com',
    'Décrivez votre rêve de voyage...': 'Beschreiben Sie Ihr Projekt...',
    'Envoyer': 'Senden',
    'Activer le son de la vidéo': 'Videoton aktivieren',
    'Désactiver le son de la vidéo': 'Videoton deaktivieren',
    'Retour en haut': 'Nach oben',
    'Français': 'Französisch',
    'English': 'Englisch',
    'Español': 'Spanisch',
    'Deutsch': 'Deutsch',
    'Italiano': 'Italienisch',
    'العربية': 'Arabisch',
  },
  it: {
    'Choisir la langue': 'Scegli la lingua',
    'Services': 'Servizi',
    'Nos templates': 'I nostri template',
    'Templates premium': 'Template premium',
    'Choisissez votre univers digital': 'Scegli il tuo universo digitale',
    'Des bases visuelles prêtes à personnaliser pour lancer rapidement une présence web moderne, professionnelle et orientée conversion.': 'Basi visive pronte da personalizzare per lanciare rapidamente una presenza web moderna, professionale e orientata alla conversione.',
    'Agence marketing digitale': 'Agenzia di marketing digitale',
    'Landing dynamique pour agences, consultants, campagnes et services de croissance.': 'Landing dinamica per agenzie, consulenti, campagne e servizi di crescita.',
    'Travel & tourism': 'Travel & tourism',
    'Expériences, destinations, cartes vidéo et storytelling immersif pour le tourisme.': 'Esperienze, destinazioni, mappe video e storytelling immersivo per il turismo.',
    'Location des véhicules': 'Noleggio veicoli',
    'Flotte, disponibilités, offres premium et parcours de réservation pour locations auto.': 'Flotta, disponibilità, offerte premium e percorso di prenotazione per autonoleggi.',
    'Médias & news': 'Media e news',
    'Format éditorial moderne pour articles, actualités, vidéos et contenus sociaux.': 'Formato editoriale moderno per articoli, notizie, video e contenuti social.',
    'Commerce local premium': 'Commercio locale premium',
    'Vitrine élégante pour produits, services, avis clients et demandes de devis.': 'Vetrina elegante per prodotti, servizi, recensioni clienti e richieste di preventivo.',
    'Cabinet conseil': 'Studio di consulenza',
    'Présentation premium pour consultants, coachs, experts et services professionnels.': 'Presentazione premium per consulenti, coach, esperti e servizi professionali.',
    'SaaS & startup': 'SaaS e startup',
    'Hero produit, fonctionnalités, preuves sociales et conversion pour logiciels et apps.': 'Hero prodotto, funzionalità, prove sociali e conversione per software e app.',
    'Formation & coaching': 'Formazione e coaching',
    'Parcours clair pour programmes, cours, ateliers, inscriptions et accompagnement.': 'Percorso chiaro per programmi, corsi, workshop, iscrizioni e accompagnamento.',
    'Immobilier premium': 'Immobiliare premium',
    'Biens vedettes, visites vidéo, cartes, galerie et demandes de visite ou de devis.': 'Immobili in evidenza, visite video, mappe, galleria e richieste di visita o preventivo.',
    'Restaurant & food': 'Ristorante e food',
    'Menus, ambiance, avis clients, galerie gourmande et parcours réservation/devis.': 'Menu, atmosfera, recensioni, galleria food e percorso prenotazione/preventivo.',
    'Portfolio créatif': 'Portfolio creativo',
    'Showcase visuel pour designers, photographes, artistes, studios et freelances.': 'Showcase visivo per designer, fotografi, artisti, studi e freelance.',
    'Santé & bien-être': 'Salute e benessere',
    'Services, horaires, équipe, témoignages et prise de contact pour professionnels santé.': 'Servizi, orari, team, testimonianze e contatto per professionisti della salute.',
    'Finance & assurance': 'Finanza e assicurazioni',
    'Structure fiable pour services financiers, assurances, rendez-vous et formulaires qualifiés.': 'Struttura affidabile per servizi finanziari, assicurazioni, appuntamenti e moduli qualificati.',
    'Voir ce template': 'Vedi questo template',
    'Galerie': 'Galleria',
    'Avis': 'Recensioni',
    'Social': 'Social',
    'Blog': 'Blog',
    'Contact': 'Contatto',
    'Demander un devis': 'Richiedi un preventivo',
    'Nos Voyages': 'I nostri viaggi',
    'Nos services': 'I nostri servizi',
    'Son désactivé': 'Audio disattivato',
    'Son activé': 'Audio attivato',
    'Scroll': 'Scorri',
    'Site vitrine': 'Sito vetrina',
    'Boutique en ligne': 'Negozio online',
    'Restaurant': 'Ristorante',
    'Tourisme': 'Turismo',
    'Immobilier': 'Immobiliare',
    'Marketplace': 'Marketplace',
    'Portfolio': 'Portfolio',
    'Blog professionnel': 'Blog professionale',
    'Ce que nous offrons': 'Cosa offriamo',
    'NOS': 'I NOSTRI',
    'SERVICES': 'SERVIZI',
    'Des solutions web et marketing pensées pour propulser votre présence en ligne, attirer plus de clients et convertir vos visiteurs en demandes concrètes.': 'Soluzioni web e marketing pensate per far crescere la tua presenza online, attirare più clienti e convertire i visitatori in richieste concrete.',
    'Création site web': 'Creazione siti web',
    'Sites vitrines modernes, rapides et responsive, conçus pour présenter votre activité avec une image professionnelle et rassurante.': 'Siti vetrina moderni, veloci e responsive, progettati per presentare la tua attività con un’immagine professionale e rassicurante.',
    'Marketing digital': 'Marketing digitale',
    'Campagnes ciblées, stratégie de visibilité et tunnels de conversion pour transformer votre audience en clients qualifiés.': 'Campagne mirate, strategia di visibilità e funnel di conversione per trasformare il pubblico in clienti qualificati.',
    'SEO & optimisation': 'SEO e ottimizzazione',
    'Optimisation technique, contenus structurés et performance pour améliorer votre classement Google et votre expérience utilisateur.': 'Ottimizzazione tecnica, contenuti strutturati e performance per migliorare il posizionamento Google e l’esperienza utente.',
    'Boutique en ligne': 'Negozio online',
    "Création de pages produits, parcours d'achat fluide, demandes de devis et vitrines e-commerce adaptées à vos offres.": 'Pagine prodotto, percorsi d’acquisto fluidi, richieste di preventivo e vetrine e-commerce adatte alle tue offerte.',
    'Identité visuelle': 'Identità visiva',
    'Direction artistique, choix des couleurs, typographies et univers visuel pour rendre votre marque immédiatement reconnaissable.': 'Direzione artistica, colori, tipografie e universo visivo per rendere il tuo brand immediatamente riconoscibile.',
    'Contenu photo & vidéo': 'Contenuti foto e video',
    'Mise en valeur de vos services, lieux, produits et témoignages avec des contenus visuels pensés pour le web et les réseaux sociaux.': 'Valorizzazione di servizi, luoghi, prodotti e testimonianze con contenuti visivi pensati per web e social.',
    'Analytics & performance': 'Analytics e performance',
    'Suivi des visites, conversions, sources de trafic et indicateurs clés pour piloter vos actions avec des données claires.': 'Monitoraggio di visite, conversioni, fonti di traffico e indicatori chiave per guidare le azioni con dati chiari.',
    'Maintenance & sécurité': 'Manutenzione e sicurezza',
    'Surveillance, corrections, mises à jour, sauvegardes et accompagnement pour garder votre présence web fiable et durable.': 'Monitoraggio, correzioni, aggiornamenti, backup e supporto per mantenere la tua presenza web affidabile e duratura.',
    'Automatisation IA': 'Automazione IA',
    'Formulaires intelligents, réponses rapides, génération de contenus et outils connectés pour gagner du temps au quotidien.': 'Moduli intelligenti, risposte rapide, generazione di contenuti e strumenti connessi per risparmiare tempo ogni giorno.',
    'Nos Destinations': 'Le nostre destinazioni',
    'GALERIE': 'GALLERIA',
    'PHOTOS': 'FOTO',
    "Plongez dans l'univers visuel de Go Exploria. Chaque image raconte une histoire, chaque lieu est une invitation.": 'Immergiti nell’universo visivo di Go Exploria. Ogni immagine racconta una storia, ogni luogo è un invito.',
    "Ce qu'ils disent": 'Cosa dicono',
    'AVIS': 'RECENSIONI',
    'CLIENTS': 'CLIENTI',
    'Basé sur 486 avis vérifiés': 'Basato su 486 recensioni verificate',
    'Suivez-nous': 'Seguici',
    'RÉSEAUX': 'RETI',
    'Rejoignez notre communauté de voyageurs et partagez vos aventures avec le hashtag #GoExploriaNextLevel': 'Unisciti alla nostra community e condividi i tuoi progetti con #GoExploriaNextLevel',
    '12.4K abonnés · 340 publications': '12,4K follower · 340 post',
    "8.2K J'aime · 8.7K abonnés": '8,2K mi piace · 8,7K follower',
    '3.1K abonnés · 24 tableaux': '3,1K follower · 24 bacheche',
    'Inspirations & Conseils': 'Ispirazioni e consigli',
    'NOTRE': 'IL NOSTRO',
    'Des articles pour inspirer vos prochains voyages, des conseils pratiques et des récits d\'aventures vécues.': 'Articoli per ispirare i tuoi prossimi progetti, consigli pratici e storie reali.',
    'À La Une': 'In evidenza',
    'Lire l\'article →': 'Leggi l’articolo →',
    'Lire →': 'Leggi →',
    'Parlons de votre voyage': 'Parliamo del tuo progetto',
    'CONTACTEZ-': 'CONTATTA',
    'NOUS': 'CI',
    'Planifions votre aventure': 'Pianifichiamo il tuo progetto',
    'Notre équipe de passionnés est à votre disposition pour vous aider à concevoir le voyage de vos rêves. Répondons à vos questions dans les 24h.': 'Il nostro team è a disposizione per aiutarti a progettare la tua presenza digitale. Rispondiamo entro 24 ore.',
    'Adresse': 'Indirizzo',
    'Téléphone': 'Telefono',
    'Email': 'Email',
    'Horaires': 'Orari',
    'Lun–Sam : 9h–19h | Dim : 10h–16h': 'Lun-Sab: 9-19 | Dom: 10-16',
    'Prénom *': 'Nome *',
    'Nom *': 'Cognome *',
    'Type de voyage': 'Tipo di progetto',
    'Type de service': 'Tipo di servizio',
    'Budget estimé': 'Budget stimato',
    'Votre message *': 'Il tuo messaggio *',
    'Choisir un service...': 'Scegli un servizio...',
    'Moins de 500 €': 'Meno di 500 €',
    '500 € – 1500 €': '500 € – 1500 €',
    '1500 € – 3000 €': '1500 € – 3000 €',
    'Plus de 3000 €': 'Più di 3000 €',
    'Envoyer ma demande': 'Invia la mia richiesta',
    '✓ Message envoyé avec succès ! Nous vous répondrons dans les 24h.': '✓ Messaggio inviato con successo! Risponderemo entro 24 ore.',
    'Votre visibilité locale': 'La tua visibilità locale',
    'Affichez votre entreprise': 'Mostra la tua azienda',
    'sur la carte du monde': 'sulla mappa del mondo',
    "Transformez chaque point sur la carte en vitrine interactive avec vos informations, vos vidéos et vos lieux d'intérêt.": 'Trasforma ogni punto sulla mappa in una vetrina interattiva con informazioni, video e luoghi di interesse.',
    'Navigation': 'Navigazione',
    'Nos Services': 'I nostri servizi',
    'Avis Clients': 'Recensioni clienti',
    'Voyages': 'Viaggi',
    'Newsletter': 'Newsletter',
    'Recevez nos offres exclusives et inspirations voyage directement dans votre boîte mail.': 'Ricevi offerte esclusive e ispirazioni direttamente nella tua email.',
    '© 2025 Go Exploria Next Level. Tous droits réservés.': '© 2025 Go Exploria Next Level. Tutti i diritti riservati.',
    'Mentions légales': 'Note legali',
    'Confidentialité': 'Privacy',
    'CGV': 'Condizioni',
    'Votre prénom': 'Il tuo nome',
    'Votre nom': 'Il tuo cognome',
    'votre@email.com': 'tua@email.com',
    'Décrivez votre rêve de voyage...': 'Descrivi il tuo progetto...',
    'Envoyer': 'Invia',
    'Activer le son de la vidéo': 'Attiva audio video',
    'Désactiver le son de la vidéo': 'Disattiva audio video',
    'Retour en haut': 'Torna su',
    'Français': 'Francese',
    'English': 'Inglese',
    'Español': 'Spagnolo',
    'Deutsch': 'Tedesco',
    'Italiano': 'Italiano',
    'العربية': 'Arabo',
  },
  ar: {
    'Choisir la langue': 'اختر اللغة',
    'Services': 'الخدمات',
    'Nos templates': 'قوالبنا',
    'Templates premium': 'قوالب مميزة',
    'Choisissez votre univers digital': 'اختر عالمك الرقمي',
    'Des bases visuelles prêtes à personnaliser pour lancer rapidement une présence web moderne, professionnelle et orientée conversion.': 'أساسات بصرية جاهزة للتخصيص لإطلاق حضور ويب حديث واحترافي وموجه للتحويل بسرعة.',
    'Agence marketing digitale': 'وكالة تسويق رقمي',
    'Landing dynamique pour agences, consultants, campagnes et services de croissance.': 'صفحة هبوط ديناميكية للوكالات والمستشارين والحملات وخدمات النمو.',
    'Travel & tourism': 'السفر والسياحة',
    'Expériences, destinations, cartes vidéo et storytelling immersif pour le tourisme.': 'تجارب ووجهات وخرائط فيديو وسرد قصصي تفاعلي للسياحة.',
    'Location des véhicules': 'تأجير المركبات',
    'Flotte, disponibilités, offres premium et parcours de réservation pour locations auto.': 'أسطول وتوفر وعروض مميزة ومسار حجز لتأجير السيارات.',
    'Médias & news': 'الإعلام والأخبار',
    'Format éditorial moderne pour articles, actualités, vidéos et contenus sociaux.': 'تنسيق تحريري حديث للمقالات والأخبار والفيديوهات والمحتوى الاجتماعي.',
    'Commerce local premium': 'تجارة محلية مميزة',
    'Vitrine élégante pour produits, services, avis clients et demandes de devis.': 'واجهة أنيقة للمنتجات والخدمات وآراء العملاء وطلبات عروض الأسعار.',
    'Cabinet conseil': 'مكتب استشارات',
    'Présentation premium pour consultants, coachs, experts et services professionnels.': 'عرض احترافي للمستشارين والمدربين والخبراء والخدمات المهنية.',
    'SaaS & startup': 'SaaS والشركات الناشئة',
    'Hero produit, fonctionnalités, preuves sociales et conversion pour logiciels et apps.': 'واجهة منتج ومزايا وإثبات اجتماعي وتحويل للبرامج والتطبيقات.',
    'Formation & coaching': 'تدريب وكوتشينغ',
    'Parcours clair pour programmes, cours, ateliers, inscriptions et accompagnement.': 'مسار واضح للبرامج والدورات والورشات والتسجيل والمرافقة.',
    'Immobilier premium': 'عقارات مميزة',
    'Biens vedettes, visites vidéo, cartes, galerie et demandes de visite ou de devis.': 'عقارات مميزة وجولات فيديو وخرائط ومعرض وطلبات زيارة أو عرض سعر.',
    'Restaurant & food': 'مطاعم ومأكولات',
    'Menus, ambiance, avis clients, galerie gourmande et parcours réservation/devis.': 'قوائم وأجواء وآراء عملاء ومعرض مأكولات ومسار حجز أو طلب عرض سعر.',
    'Portfolio créatif': 'معرض أعمال إبداعي',
    'Showcase visuel pour designers, photographes, artistes, studios et freelances.': 'واجهة بصرية للمصممين والمصورين والفنانين والاستوديوهات والمستقلين.',
    'Santé & bien-être': 'الصحة والعافية',
    'Services, horaires, équipe, témoignages et prise de contact pour professionnels santé.': 'خدمات وساعات عمل وفريق وشهادات وتواصل لمهنيي الصحة.',
    'Finance & assurance': 'المالية والتأمين',
    'Structure fiable pour services financiers, assurances, rendez-vous et formulaires qualifiés.': 'هيكل موثوق للخدمات المالية والتأمين والمواعيد والنماذج المؤهلة.',
    'Voir ce template': 'عرض هذا القالب',
    'Galerie': 'المعرض',
    'Avis': 'آراء العملاء',
    'Social': 'الشبكات',
    'Blog': 'المدونة',
    'Contact': 'اتصل بنا',
    'Demander un devis': 'اطلب عرض سعر',
    'Nos Voyages': 'رحلاتنا',
    'Nos services': 'خدماتنا',
    'Son désactivé': 'الصوت متوقف',
    'Son activé': 'الصوت مفعل',
    'Scroll': 'تمرير',
    'Site vitrine': 'موقع تعريفي',
    'Boutique en ligne': 'متجر إلكتروني',
    'Restaurant': 'مطعم',
    'Tourisme': 'سياحة',
    'Immobilier': 'عقارات',
    'Marketplace': 'سوق إلكتروني',
    'Portfolio': 'معرض أعمال',
    'Blog professionnel': 'مدونة مهنية',
    'Ce que nous offrons': 'ما نقدمه',
    'NOS': 'خدماتنا',
    'SERVICES': 'الخدمات',
    'Des solutions web et marketing pensées pour propulser votre présence en ligne, attirer plus de clients et convertir vos visiteurs en demandes concrètes.': 'حلول ويب وتسويق مصممة لتعزيز حضورك الرقمي وجذب المزيد من العملاء وتحويل الزوار إلى طلبات فعلية.',
    'Création site web': 'إنشاء موقع إلكتروني',
    'Sites vitrines modernes, rapides et responsive, conçus pour présenter votre activité avec une image professionnelle et rassurante.': 'مواقع تعريفية حديثة وسريعة ومتجاوبة لعرض نشاطك بصورة احترافية وموثوقة.',
    'Marketing digital': 'التسويق الرقمي',
    'Campagnes ciblées, stratégie de visibilité et tunnels de conversion pour transformer votre audience en clients qualifiés.': 'حملات مستهدفة واستراتيجية ظهور ومسارات تحويل لتحويل جمهورك إلى عملاء مؤهلين.',
    'SEO & optimisation': 'تحسين محركات البحث',
    'Optimisation technique, contenus structurés et performance pour améliorer votre classement Google et votre expérience utilisateur.': 'تحسين تقني ومحتوى منظم وأداء أفضل لتحسين ترتيبك في جوجل وتجربة المستخدم.',
    'Boutique en ligne': 'متجر إلكتروني',
    "Création de pages produits, parcours d'achat fluide, demandes de devis et vitrines e-commerce adaptées à vos offres.": 'إنشاء صفحات منتجات ومسار شراء سلس وطلبات عروض سعر وواجهات تجارة إلكترونية مناسبة لعروضك.',
    'Identité visuelle': 'هوية بصرية',
    'Direction artistique, choix des couleurs, typographies et univers visuel pour rendre votre marque immédiatement reconnaissable.': 'توجيه فني وألوان وخطوط وهوية مرئية تجعل علامتك التجارية واضحة ومميزة.',
    'Contenu photo & vidéo': 'محتوى صور وفيديو',
    'Mise en valeur de vos services, lieux, produits et témoignages avec des contenus visuels pensés pour le web et les réseaux sociaux.': 'إبراز خدماتك ومواقعك ومنتجاتك وشهادات العملاء بمحتوى بصري مناسب للويب والشبكات الاجتماعية.',
    'Analytics & performance': 'التحليلات والأداء',
    'Suivi des visites, conversions, sources de trafic et indicateurs clés pour piloter vos actions avec des données claires.': 'تتبع الزيارات والتحويلات ومصادر المرور والمؤشرات الأساسية لاتخاذ قرارات واضحة.',
    'Maintenance & sécurité': 'الصيانة والأمان',
    'Surveillance, corrections, mises à jour, sauvegardes et accompagnement pour garder votre présence web fiable et durable.': 'مراقبة وإصلاحات وتحديثات ونسخ احتياطي ودعم للحفاظ على حضور رقمي موثوق ومستمر.',
    'Automatisation IA': 'أتمتة بالذكاء الاصطناعي',
    'Formulaires intelligents, réponses rapides, génération de contenus et outils connectés pour gagner du temps au quotidien.': 'نماذج ذكية وردود سريعة وإنشاء محتوى وأدوات متصلة لتوفير الوقت يومياً.',
    'Nos Destinations': 'وجهاتنا',
    'GALERIE': 'معرض',
    'PHOTOS': 'الصور',
    "Plongez dans l'univers visuel de Go Exploria. Chaque image raconte une histoire, chaque lieu est une invitation.": 'ادخل إلى العالم البصري لـ Go Exploria. كل صورة تحكي قصة وكل مكان دعوة للاكتشاف.',
    "Ce qu'ils disent": 'ماذا يقولون',
    'AVIS': 'آراء',
    'CLIENTS': 'العملاء',
    'Basé sur 486 avis vérifiés': 'استناداً إلى 486 مراجعة موثقة',
    'Suivez-nous': 'تابعنا',
    'RÉSEAUX': 'الشبكات',
    'Rejoignez notre communauté de voyageurs et partagez vos aventures avec le hashtag #GoExploriaNextLevel': 'انضم إلى مجتمعنا وشارك مشاريعك باستخدام الوسم #GoExploriaNextLevel',
    '12.4K abonnés · 340 publications': '12.4 ألف متابع · 340 منشوراً',
    "8.2K J'aime · 8.7K abonnés": '8.2 ألف إعجاب · 8.7 ألف متابع',
    '3.1K abonnés · 24 tableaux': '3.1 ألف متابع · 24 لوحة',
    'Inspirations & Conseils': 'إلهام ونصائح',
    'NOTRE': 'مدونتنا',
    'Des articles pour inspirer vos prochains voyages, des conseils pratiques et des récits d\'aventures vécues.': 'مقالات لإلهام مشاريعك القادمة ونصائح عملية وقصص نجاح حقيقية.',
    'À La Une': 'مميز',
    'Lire l\'article →': 'اقرأ المقال →',
    'Lire →': 'اقرأ →',
    'Parlons de votre voyage': 'لنتحدث عن مشروعك',
    'CONTACTEZ-': 'تواصل',
    'NOUS': 'معنا',
    'Planifions votre aventure': 'لنخطط لمشروعك',
    'Notre équipe de passionnés est à votre disposition pour vous aider à concevoir le voyage de vos rêves. Répondons à vos questions dans les 24h.': 'فريقنا جاهز لمساعدتك في تصميم مشروعك الرقمي. نرد على أسئلتك خلال 24 ساعة.',
    'Adresse': 'العنوان',
    'Téléphone': 'الهاتف',
    'Email': 'البريد الإلكتروني',
    'Horaires': 'ساعات العمل',
    'Lun–Sam : 9h–19h | Dim : 10h–16h': 'الاثنين-السبت: 9-19 | الأحد: 10-16',
    'Prénom *': 'الاسم الأول *',
    'Nom *': 'الاسم الأخير *',
    'Type de voyage': 'نوع المشروع',
    'Type de service': 'نوع الخدمة',
    'Budget estimé': 'الميزانية المتوقعة',
    'Votre message *': 'رسالتك *',
    'Choisir un service...': 'اختر خدمة...',
    'Moins de 500 €': 'أقل من 500 €',
    '500 € – 1500 €': '500 € – 1500 €',
    '1500 € – 3000 €': '1500 € – 3000 €',
    'Plus de 3000 €': 'أكثر من 3000 €',
    'Envoyer ma demande': 'إرسال الطلب',
    '✓ Message envoyé avec succès ! Nous vous répondrons dans les 24h.': '✓ تم إرسال الرسالة بنجاح! سنرد خلال 24 ساعة.',
    'Votre visibilité locale': 'ظهورك المحلي',
    'Affichez votre entreprise': 'اعرض شركتك',
    'sur la carte du monde': 'على خريطة العالم',
    "Transformez chaque point sur la carte en vitrine interactive avec vos informations, vos vidéos et vos lieux d'intérêt.": 'حوّل كل نقطة على الخريطة إلى واجهة تفاعلية تحتوي معلوماتك وفيديوهاتك ونقاط الاهتمام.',
    'Navigation': 'التنقل',
    'Nos Services': 'خدماتنا',
    'Avis Clients': 'آراء العملاء',
    'Voyages': 'رحلات',
    'Newsletter': 'النشرة البريدية',
    'Recevez nos offres exclusives et inspirations voyage directement dans votre boîte mail.': 'استقبل عروضنا الحصرية وإلهامنا مباشرة في بريدك الإلكتروني.',
    '© 2025 Go Exploria Next Level. Tous droits réservés.': '© 2025 Go Exploria Next Level. جميع الحقوق محفوظة.',
    'Mentions légales': 'إشعار قانوني',
    'Confidentialité': 'الخصوصية',
    'CGV': 'الشروط',
    'Votre prénom': 'اسمك الأول',
    'Votre nom': 'اسمك الأخير',
    'votre@email.com': 'email@example.com',
    'Décrivez votre rêve de voyage...': 'صف مشروعك...',
    'Envoyer': 'إرسال',
    'Activer le son de la vidéo': 'تفعيل صوت الفيديو',
    'Désactiver le son de la vidéo': 'إيقاف صوت الفيديو',
    'Retour en haut': 'العودة للأعلى',
    'Français': 'الفرنسية',
    'English': 'الإنجليزية',
    'Español': 'الإسبانية',
    'Deutsch': 'الألمانية',
    'Italiano': 'الإيطالية',
    'العربية': 'العربية',
  },
};

const nextLevelOriginalText = new WeakMap();
const nextLevelOriginalPlaceholder = new WeakMap();
const nextLevelOriginalAria = new WeakMap();
let currentNextLevelLang = localStorage.getItem('nextLevelLandingLang') || 'fr';
const nextLevelLangMeta = {
  fr: { flagClass: 'fi fi-fr', code: 'FR' },
  en: { flagClass: 'fi fi-gb', code: 'EN' },
  es: { flagClass: 'fi fi-es', code: 'ES' },
  de: { flagClass: 'fi fi-de', code: 'DE' },
  it: { flagClass: 'fi fi-it', code: 'IT' },
  ar: { flagClass: 'fi fi-sa', code: 'AR' },
};

function nextLevelT(text) {
  return (nextLevelTranslations[currentNextLevelLang] && nextLevelTranslations[currentNextLevelLang][text]) || text;
}

function translateNextLevelLanding(lang) {
  currentNextLevelLang = nextLevelTranslations[lang] ? lang : 'fr';
  localStorage.setItem('nextLevelLandingLang', currentNextLevelLang);
  document.documentElement.lang = currentNextLevelLang === 'fr' ? 'fr-CA' : currentNextLevelLang;
  document.documentElement.dir = currentNextLevelLang === 'ar' ? 'rtl' : 'ltr';
  document.body.classList.toggle('is-rtl', currentNextLevelLang === 'ar');

  const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, {
    acceptNode(node) {
      if (!node.nodeValue.trim()) return NodeFilter.FILTER_REJECT;
      const parent = node.parentElement;
      if (!parent || ['SCRIPT', 'STYLE'].includes(parent.tagName)) return NodeFilter.FILTER_REJECT;
      return NodeFilter.FILTER_ACCEPT;
    }
  });

  const nodes = [];
  while (walker.nextNode()) nodes.push(walker.currentNode);
  nodes.forEach((node) => {
    if (!nextLevelOriginalText.has(node)) nextLevelOriginalText.set(node, node.nodeValue);
    const original = nextLevelOriginalText.get(node);
    const leading = original.match(/^\s*/)[0];
    const trailing = original.match(/\s*$/)[0];
    node.nodeValue = leading + nextLevelT(original.trim()) + trailing;
  });

  document.querySelectorAll('input[placeholder], textarea[placeholder]').forEach((field) => {
    if (!nextLevelOriginalPlaceholder.has(field)) nextLevelOriginalPlaceholder.set(field, field.getAttribute('placeholder'));
    field.setAttribute('placeholder', nextLevelT(nextLevelOriginalPlaceholder.get(field)));
  });

  document.querySelectorAll('[aria-label]').forEach((el) => {
    if (!nextLevelOriginalAria.has(el)) nextLevelOriginalAria.set(el, el.getAttribute('aria-label'));
    el.setAttribute('aria-label', nextLevelT(nextLevelOriginalAria.get(el)));
  });

  document.querySelectorAll('.lang-btn').forEach((btn) => {
    btn.classList.toggle('is-active', btn.dataset.lang === currentNextLevelLang);
  });

  const activeLang = nextLevelLangMeta[currentNextLevelLang] || nextLevelLangMeta.fr;
  const langCurrent = document.getElementById('langCurrent');
  if (langCurrent) {
    langCurrent.innerHTML = `<span class="${activeLang.flagClass} lang-flag" aria-hidden="true"></span><span class="lang-code">${activeLang.code}</span><i class="fas fa-chevron-down" aria-hidden="true"></i>`;
  }

  if (typeof syncHeroAudio === 'function') syncHeroAudio();
}

const languageSwitcher = document.getElementById('languageSwitcher');
const langCurrent = document.getElementById('langCurrent');
if (languageSwitcher && langCurrent) {
  langCurrent.addEventListener('click', (event) => {
    event.stopPropagation();
    languageSwitcher.classList.toggle('is-open');
    langCurrent.setAttribute('aria-expanded', languageSwitcher.classList.contains('is-open') ? 'true' : 'false');
  });
  document.addEventListener('click', (event) => {
    if (!languageSwitcher.contains(event.target)) {
      languageSwitcher.classList.remove('is-open');
      langCurrent.setAttribute('aria-expanded', 'false');
    }
  });
}

document.querySelectorAll('.lang-btn').forEach((btn) => {
  btn.addEventListener('click', () => {
    translateNextLevelLanding(btn.dataset.lang);
    if (languageSwitcher && langCurrent) {
      languageSwitcher.classList.remove('is-open');
      langCurrent.setAttribute('aria-expanded', 'false');
    }
  });
});

// ── TEMPLATES MEGA MENU ──
const templatesMega = document.getElementById('templatesMega');
const templatesMegaToggle = document.getElementById('templatesMegaToggle');
if (templatesMega && templatesMegaToggle) {
  templatesMegaToggle.addEventListener('click', (event) => {
    event.stopPropagation();
    const isOpen = templatesMega.classList.toggle('is-open');
    templatesMegaToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  });
  document.addEventListener('click', (event) => {
    if (!templatesMega.contains(event.target)) {
      templatesMega.classList.remove('is-open');
      templatesMegaToggle.setAttribute('aria-expanded', 'false');
    }
  });
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      templatesMega.classList.remove('is-open');
      templatesMegaToggle.setAttribute('aria-expanded', 'false');
    }
  });
  templatesMega.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', (event) => {
      if (link.classList.contains('template-card--inactive')) {
        event.preventDefault();
        return;
      }
      templatesMega.classList.remove('is-open');
      templatesMegaToggle.setAttribute('aria-expanded', 'false');
    });
  });
}

// ── HERO SWIPER ──
const heroSwiperEl = document.querySelector('.hero-swiper');
const heroSwiper = heroSwiperEl ? new Swiper('.hero-swiper', {
  loop: true,
  autoplay: { delay: 6000, disableOnInteraction: false },
  effect: 'fade',
  fadeEffect: { crossFade: true },
  pagination: { el: '.hero-swiper .swiper-pagination', clickable: true },
  speed: 1200,
}) : null;

// ── HERO AUDIO CONTROL ──
let heroAudioEnabled = false;
const heroAudioBtn = document.getElementById('heroAudioToggle');

function muteHeroLocalVideosByDefault() {
  document.querySelectorAll('.hero-slide-bg video').forEach((video) => {
    video.muted = true;
    video.defaultMuted = true;
    video.volume = 0;
    video.setAttribute('muted', 'muted');
    video.setAttribute('playsinline', 'playsinline');
  });
}

function withHeroAudioParams(src, enabled) {
  if (!src) return src;
  try {
    const url = new URL(src, window.location.href);
    const host = url.hostname.toLowerCase();
    if (!host.includes('youtube.com') && !host.includes('youtu.be') && !host.includes('vimeo.com')) {
      return src;
    }
    url.searchParams.set('autoplay', '1');
    url.searchParams.set('mute', enabled ? '0' : '1');
    url.searchParams.set('muted', enabled ? '0' : '1');
    url.searchParams.set('playsinline', '1');
    return url.toString();
  } catch (error) {
    const joiner = src.includes('?') ? '&' : '?';
    return `${src}${joiner}autoplay=1&mute=${enabled ? '0' : '1'}&muted=${enabled ? '0' : '1'}&playsinline=1`;
  }
}

function syncHeroAudio() {
  const slides = document.querySelectorAll('.hero-swiper .swiper-slide');
  slides.forEach((slide) => {
    const shouldPlaySound = heroAudioEnabled && slide.classList.contains('swiper-slide-active');
    slide.querySelectorAll('video').forEach((video) => {
      video.muted = !shouldPlaySound;
      video.defaultMuted = !shouldPlaySound;
      video.volume = shouldPlaySound ? 1 : 0;
      if (shouldPlaySound) {
        video.removeAttribute('muted');
      } else {
        video.setAttribute('muted', 'muted');
      }
      video.play().catch(() => {});
    });
    slide.querySelectorAll('iframe').forEach((iframe) => {
      const currentSrc = iframe.getAttribute('src') || '';
      const nextSrc = withHeroAudioParams(currentSrc, shouldPlaySound);
      if (nextSrc && nextSrc !== currentSrc) {
        iframe.setAttribute('src', nextSrc);
      }
    });
  });

  if (heroAudioBtn) {
    heroAudioBtn.classList.toggle('is-active', heroAudioEnabled);
    heroAudioBtn.setAttribute('aria-pressed', heroAudioEnabled ? 'true' : 'false');
    heroAudioBtn.setAttribute('aria-label', nextLevelT(heroAudioEnabled ? 'Désactiver le son de la vidéo' : 'Activer le son de la vidéo'));
    heroAudioBtn.innerHTML = heroAudioEnabled
      ? '<i class="fas fa-volume-high" aria-hidden="true"></i>'
      : '<i class="fas fa-volume-xmark" aria-hidden="true"></i>';
  }
}

muteHeroLocalVideosByDefault();
if (heroAudioBtn) {
  heroAudioBtn.addEventListener('click', () => {
    heroAudioEnabled = !heroAudioEnabled;
    syncHeroAudio();
  });
}
if (heroSwiper) {
  heroSwiper.on('slideChangeTransitionEnd', syncHeroAudio);
}
translateNextLevelLanding(currentNextLevelLang);

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
  tourism: { icon: 'fas fa-compass', color: '#C9A84C' },
  culture: { icon: 'fas fa-masks-theater', color: '#8b5cf6' },
  history: { icon: 'fas fa-landmark', color: '#b45309' },
  nature: { icon: 'fas fa-tree', color: '#22c55e' },
  adventure: { icon: 'fas fa-mountain', color: '#f97316' },
  shopping: { icon: 'fas fa-bag-shopping', color: '#ec4899' },
  science: { icon: 'fas fa-flask', color: '#06b6d4' },
  beach: { icon: 'fas fa-umbrella-beach', color: '#0ea5e9' },
  family: { icon: 'fas fa-people-group', color: '#f59e0b' },
  restaurant: { icon: 'fas fa-utensils', color: '#ef4444' },
  hotel: { icon: 'fas fa-hotel', color: '#6366f1' },
  commerce: { icon: 'fas fa-store', color: '#14b8a6' },
  sante: { icon: 'fas fa-briefcase-medical', color: '#10b981' },
  education: { icon: 'fas fa-graduation-cap', color: '#3b82f6' },
  sport: { icon: 'fas fa-medal', color: '#84cc16' },
  loisirs: { icon: 'fas fa-ticket', color: '#d946ef' },
  transport: { icon: 'fas fa-bus', color: '#64748b' },
  immobilier: { icon: 'fas fa-house-chimney', color: '#a16207' },
  service: { icon: 'fas fa-screwdriver-wrench', color: '#475569' },
  autre: { icon: 'fas fa-location-dot', color: '#C9A84C' },
  general: { icon: 'fas fa-location-dot', color: '#C9A84C' },
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
  }).setView([46.8139, -71.2080], 5);

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
      html: `<div class="next-level-marker-wrap" style="background:${style.color};"><i class="${style.icon}" aria-hidden="true"></i></div>`,
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

  map.setView([46.8139, -71.2080], 5);

  setTimeout(() => map.invalidateSize(), 300);
}

initNextLevelMap();

// ── SOCIAL FEED DATA ──
const photoSets = {
  instagram: @json($nextLevelInstagram->take(8)->pluck('thumbnail')->values()),
  facebook: @json($nextLevelFacebook->take(8)->pluck('thumbnail')->values()),
  pinterest: @json($nextLevelPinterest->take(8)->pluck('thumbnail')->values())
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

// ── BACK TO TOP ──
const backToTopBtn = document.getElementById('backToTop');
if (backToTopBtn) {
  window.addEventListener('scroll', () => {
    backToTopBtn.classList.toggle('is-visible', window.scrollY > 520);
  });
  backToTopBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
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
    @include('cms::web.fallback.partials.landing-cart-drawer')
    @include('cms::web.fallback.partials.landing-back-to-top')
</body>
</html>
