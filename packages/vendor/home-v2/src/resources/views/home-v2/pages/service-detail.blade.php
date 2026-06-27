@php(ob_start());@endphp
@php
    $supportedLocales = [
        'fr' => ['flag' => 'fr', 'code' => 'FR', 'label' => 'Français'],
        'en' => ['flag' => 'gb', 'code' => 'EN', 'label' => 'English'],
        'es' => ['flag' => 'es', 'code' => 'ES', 'label' => 'Español'],
        'de' => ['flag' => 'de', 'code' => 'DE', 'label' => 'Deutsch'],
        'it' => ['flag' => 'it', 'code' => 'IT', 'label' => 'Italiano'],
    ];
    $currentLocale = app()->getLocale();
    if (! array_key_exists($currentLocale, $supportedLocales)) {
        $currentLocale = 'fr';
    }
    $currentLanguage = $supportedLocales[$currentLocale];

    $serviceTitle = trim((string) ($service->title ?? ''));
    $serviceDescription = $service->description ?? '';
    $serviceImageUrl = $service->image_url ?? null;
    $servicePrice = (float) ($service->unit_price ?? 0);
    $serviceCurrency = 'CAD';
    $serviceUnit = trim((string) ($service->billing_unit ?? 'forfait'));
    $isFeatured = (bool) ($service->is_featured ?? false);
@endphp
<!DOCTYPE html>
<html lang="{{ $currentLocale }}" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $serviceTitle }} — GoExploria | Détail du service</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons@7.2.3/css/flag-icons.min.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: #ffffff;
      color: #0a0a1a;
      scroll-behavior: smooth;
    }
    .container { max-width: 1280px; margin: 0 auto; padding: 0 32px; }
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; }
    ::-webkit-scrollbar-thumb { background: linear-gradient(135deg, #4f46e5, #ec4899); border-radius: 4px; }

    .nav-premium {
      position: fixed; top: 0; left: 0; right: 0;
      background: rgba(255,255,255,0.95);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(0,0,0,0.05);
      z-index: 1000; padding: 16px 0;
      transition: all 0.3s ease;
    }
    .nav-premium.scrolled { padding: 12px 0; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    .plan-detail-logo-link { display: inline-flex; align-items: center; }
    .plan-detail-logo-image { height: 64px; width: auto; display: block; }

    .hero-premium {
      min-height: 90vh;
      display: flex;
      align-items: center;
      position: relative;
      overflow: hidden;
      background: linear-gradient(135deg, #fefce8 0%, #fef3c7 50%, #fce7f3 100%);
      padding-top: 80px;
    }
    .hero-premium .orb {
      position: absolute; border-radius: 50%; filter: blur(60px);
      opacity: 0.4; pointer-events: none;
    }
    .orb-1 { top: -100px; right: -100px; width: 400px; height: 400px; background: #4f46e5; }
    .orb-2 { bottom: -100px; left: -100px; width: 350px; height: 350px; background: #ec4899; }
    .orb-3 { top: 50%; left: 30%; width: 200px; height: 200px; background: #f59e0b; }

    .hero-badge-premium {
      display: inline-flex; align-items: center; gap: 8px;
      background: rgba(255,255,255,0.8);
      backdrop-filter: blur(10px); padding: 8px 20px; border-radius: 100px;
      font-size: 0.85rem; font-weight: 600; color: #4f46e5;
      margin-bottom: 28px; border: 1px solid rgba(79,70,229,0.2);
    }
    .gradient-premium {
      background: linear-gradient(135deg, #4f46e5, #ec4899);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .hero-title-premium {
      font-size: 4rem; font-weight: 800; line-height: 1.1;
      margin-bottom: 24px;
    }
    .hero-desc-premium {
      font-size: 1.15rem; line-height: 1.7;
      color: #475569; margin-bottom: 32px; max-width: 540px;
    }

    .btn-premium-primary {
      display: inline-flex; align-items: center; gap: 8px;
      background: linear-gradient(135deg, #4f46e5, #7c3aed);
      color: white; border: none; padding: 14px 28px;
      border-radius: 100px; font-size: 0.95rem; font-weight: 700;
      cursor: pointer; transition: all 0.3s ease; text-decoration: none;
    }
    .btn-premium-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(79,70,229,0.4); }
    .btn-premium-secondary {
      display: inline-flex; align-items: center; gap: 8px;
      background: transparent; color: #0a0a1a; border: 2px solid #e5e7eb;
      padding: 14px 28px; border-radius: 100px; font-size: 0.95rem;
      font-weight: 700; cursor: pointer; transition: all 0.3s ease; text-decoration: none;
    }
    .btn-premium-secondary:hover { border-color: #4f46e5; color: #4f46e5; }

    .hero-image-wrapper {
      background: rgba(255,255,255,0.8);
      backdrop-filter: blur(20px);
      border-radius: 32px;
      padding: 24px;
      border: 1px solid rgba(255,255,255,0.5);
      text-align: center;
    }
    .hero-image-wrapper img {
      max-width: 100%;
      border-radius: 24px;
      max-height: 400px;
      object-fit: cover;
    }
    .hero-image-placeholder {
      padding: 80px 40px;
      background: linear-gradient(135deg, #e0e7ff, #fce7f3);
      border-radius: 24px;
      font-size: 4rem;
      color: #8a9bb8;
    }

    .trust-badges {
      display: flex; gap: 24px; margin-top: 32px; flex-wrap: wrap;
    }
    .trust-item { display: flex; align-items: center; gap: 12px; }
    .trust-item .icon { font-size: 1.5rem; }

    .service-detail-section {
      padding: 80px 0;
    }
    .service-detail-section.alt { background: #f8fafc; }
    .section-header-premium { text-align: center; margin-bottom: 48px; }
    .section-tag-premium {
      display: inline-block;
      background: linear-gradient(135deg, #4f46e5, #7c3aed);
      color: white; padding: 6px 18px; border-radius: 100px;
      font-size: 0.8rem; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 16px;
    }
    .section-title-premium {
      font-size: 2.5rem; font-weight: 800; line-height: 1.2; margin-bottom: 16px;
    }

    .description-content {
      max-width: 800px;
      margin: 0 auto;
      font-size: 1.1rem;
      line-height: 1.8;
      color: #475569;
    }

    .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 24px;
      margin-top: 48px;
    }
    .info-card {
      background: white;
      border: 1px solid #e5e7eb;
      border-radius: 24px;
      padding: 32px;
      text-align: center;
    }
    .info-card i {
      font-size: 2rem;
      color: #4f46e5;
      margin-bottom: 16px;
    }
    .info-card .value {
      font-size: 1.5rem;
      font-weight: 800;
      margin-bottom: 4px;
    }
    .info-card .label {
      color: #6b7280;
      font-size: 0.9rem;
    }

    .cta-premium {
      text-align: center;
      background: linear-gradient(135deg, #eef2ff, #ffffff);
      border-radius: 32px;
      padding: 64px;
      margin: 40px 0;
    }
    .btn-cta-premium {
      display: inline-flex; align-items: center; gap: 8px;
      background: linear-gradient(135deg, #4f46e5, #7c3aed);
      color: white; border: none; padding: 16px 36px;
      border-radius: 100px; font-size: 1rem; font-weight: 700;
      cursor: pointer; transition: all 0.3s ease; text-decoration: none; margin-top: 24px;
    }
    .btn-cta-premium:hover { transform: translateY(-2px); box-shadow: 0 14px 28px rgba(79,70,229,0.35); }

    .footer-premium {
      background: #0a0a1a; color: #9ca3af;
      padding: 60px 0 30px; margin-top: 60px;
    }

    @media (max-width: 968px) {
      .hero-title-premium { font-size: 2.5rem; }
      .hero-grid { grid-template-columns: 1fr !important; gap: 32px !important; }
      .section-title-premium { font-size: 2rem; }
      .plan-detail-logo-image { height: 56px; }
    }
  </style>
</head>
<body>

  <nav class="nav-premium" id="nav">
    <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
      <div class="nav-logo">
        <a href="{{ url('/') }}" class="plan-detail-logo-link" aria-label="Accueil">
          <img src="{{ asset('logo.png') }}" class="plan-detail-logo-image" alt="GoExploria Business">
        </a>
      </div>
      <div style="display: flex; gap: 16px; align-items: center;">
        <a href="{{ route('devis') }}" class="btn-premium-primary" style="padding: 10px 20px; text-decoration: none;">
          <i class="fas fa-arrow-left"></i> Retour au devis
        </a>
      </div>
    </div>
  </nav>

  <section class="hero-premium">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="container">
      <div class="hero-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 64px; align-items: center;">
        <div>
          <div class="hero-badge-premium">
            <i class="fas fa-crown"></i>
            Service {{ $isFeatured ? 'Premium' : 'Professionnel' }}
          </div>
          <h1 class="hero-title-premium">
            <span class="gradient-premium">{{ $serviceTitle }}</span>
          </h1>
          
{!! $serviceDescription !== '' 
    ? \Illuminate\Support\Str::limit(strip_tags($serviceDescription), 500)
    : 'Service professionnel GoExploria pour booster votre activité.' 
!!}          
          <div style="display: flex; gap: 16px; flex-wrap: wrap;">
            <a href="{{ route('devis') }}" class="btn-premium-primary">
              <i class="fas fa-file-invoice"></i> Demander un devis
            </a>
          </div>
          <div class="trust-badges">
            <div class="trust-item">
              <div class="icon"><i class="fas fa-tag" style="color: #4f46e5;"></i></div>
              <div>
                <strong>
                  @if($servicePrice > 0)
                    {{ number_format($servicePrice, 2, ',', ' ') }} {{ $serviceCurrency }}
                  @else
                    Sur devis
                  @endif
                </strong>
                <br><span style="font-size: 0.8rem;">prix {{ $serviceUnit }}</span>
              </div>
            </div>
            <div class="trust-item">
              <div class="icon"><i class="fas fa-star" style="color: #f59e0b;"></i></div>
              <div><strong>4.9★</strong><br><span style="font-size: 0.8rem;">satisfaction</span></div>
            </div>
          </div>
        </div>
        <div>
          <div class="hero-image-wrapper">
            @if($serviceImageUrl)
              <img src="{{ $serviceImageUrl }}" alt="{{ $serviceTitle }}" loading="lazy">
            @else
              <div class="hero-image-placeholder">
                <i class="fas fa-briefcase"></i>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="service-detail-section">
    <div class="container">
      <div class="section-header-premium">
        <span class="section-tag-premium">DESCRIPTION</span>
        <h2 class="section-title-premium">En savoir <span class="gradient-premium">plus</span></h2>
      </div>
      <div class="description-content">
        {!! $serviceDescription !!}
      </div>

      <div class="info-grid">
        <div class="info-card">
          <i class="fas fa-tag"></i>
          <div class="value">
            @if($servicePrice > 0)
              {{ number_format($servicePrice, 2, ',', ' ') }} {{ $serviceCurrency }}
            @else
              Sur devis
            @endif
          </div>
          <div class="label">Prix unitaire ({{ $serviceUnit }})</div>
        </div>
        <div class="info-card">
          <i class="fas fa-box"></i>
          <div class="value">{{ ucfirst($serviceUnit) }}</div>
          <div class="label">Unité de facturation</div>
        </div>
        <div class="info-card">
          <i class="fas fa-{{ $isFeatured ? 'crown' : 'check-circle' }}"></i>
          <div class="value">{{ $isFeatured ? 'Premium' : 'Standard' }}</div>
          <div class="label">Type de service</div>
        </div>
      </div>
    </div>
  </section>

  <section class="service-detail-section alt">
    <div class="container">
      <div class="cta-premium">
        <i class="fas fa-file-invoice" style="font-size: 3rem; color: #4f46e5; margin-bottom: 16px;"></i>
        <h2 style="font-size: 2rem; margin-bottom: 16px;">Prêt à démarrer avec ce service ?</h2>
        <p style="color: #6b7280; max-width: 600px; margin: 0 auto;">
          Demandez un devis personnalisé et notre équipe vous recontactera sous 24h pour discuter de votre projet.
        </p>
        <a href="{{ route('devis') }}" class="btn-cta-premium">
          <i class="fas fa-file-invoice"></i> Demander un devis
        </a>
      </div>
    </div>
  </section>

  @if(isset($mapPoints) && $mapPoints->count() > 0)
  <section class="map-points-section" style="padding:64px 0;background:#f9fafb">
    <div class="container">
      <div class="section-header" style="text-align:center;margin-bottom:32px">
        <h2 style="font-size:1.8rem;font-weight:700;margin-bottom:8px">Découvrez les points d'intérêt</h2>
        <p style="color:#6b7280">Cliquez sur les marqueurs pour en savoir plus</p>
      </div>
      <div id="travel-map" style="height:500px;border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.08);margin-bottom:40px"></div>
      <div class="map-points-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:20px">
        @foreach($mapPoints as $point)
          <div class="map-point-card" style="background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.08);transition:transform .2s">
            @if($point->mainImage)
              <img src="{{ $point->mainImage->url }}" alt="{{ $point->title }}" style="width:100%;height:180px;object-fit:cover" loading="lazy">
            @elseif($point->youtube_id)
              <div style="width:100%;height:180px;background:#1a1a2e;display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px">
                <i class="fas fa-play-circle" style="font-size:40px;opacity:.6"></i>
              </div>
            @endif
            <div style="padding:18px">
              <h3 style="margin:0 0 6px;font-size:17px">{{ $point->title }}</h3>
              @if($point->adresse)
                <p style="margin:0 0 4px;font-size:13px;color:#666"><i class="fas fa-map-marker-alt" style="margin-right:6px;color:#4f46e5"></i>{{ $point->adresse }}{{ $point->ville ? ', ' . $point->ville : '' }}</p>
              @endif
              @if($point->description)
                <p style="margin:0 0 8px;font-size:13px;color:#888;line-height:1.4">{{ \Illuminate\Support\Str::limit($point->description, 120) }}</p>
              @endif
              @if($point->details && $point->details->phone)
                <p style="margin:0;font-size:13px;color:#666"><i class="fas fa-phone" style="margin-right:6px;color:#4f46e5"></i>{{ $point->details->phone }}</p>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  <footer class="footer-premium">
    <div class="container">
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 48px;">
        <div>
          <div style="font-size: 1.5rem; font-weight: 700; margin-bottom: 16px;">Go<span style="color: #4f46e5;">Exploria</span></div>
          <p style="color: #6b7280;">La plateforme tout-en-un pour les professionnels.</p>
        </div>
        <div>
          <h4 style="color: white; margin-bottom: 16px;">Liens</h4>
          <a href="{{ route('devis') }}" style="display: block; margin-bottom: 8px; color: #9ca3af; text-decoration: none;">Demande de devis</a>
          <a href="{{ url('/') }}" style="display: block; margin-bottom: 8px; color: #9ca3af; text-decoration: none;">Accueil</a>
        </div>
        <div>
          <h4 style="color: white; margin-bottom: 16px;">Légal</h4>
          <a href="#" style="display: block; margin-bottom: 8px; color: #9ca3af; text-decoration: none;">CGU</a>
          <a href="#" style="display: block; margin-bottom: 8px; color: #9ca3af; text-decoration: none;">Confidentialité</a>
        </div>
      </div>
      <div style="text-align: center; padding-top: 48px; margin-top: 48px; border-top: 1px solid #1f2937;">
        <p>© {{ date('Y') }} GoExploria Business — Tous droits réservés</p>
      </div>
    </div>
  </footer>

  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var mapEl = document.getElementById('travel-map');
      if (!mapEl) return;

      var mapPoints = {!! json_encode($mapPoints->map(function($p) {
        $img = $p->mainImage ? $p->mainImage->url : ($p->youtube_id ? 'https://img.youtube.com/vi/' . $p->youtube_id . '/hqdefault.jpg' : null);
        return [
          'id' => $p->id,
          'title' => $p->title,
          'description' => $p->description,
          'latitude' => (float)$p->latitude,
          'longitude' => (float)$p->longitude,
          'category' => $p->category,
          'address' => $p->adresse,
          'city' => $p->ville,
          'thumbnail' => $img,
          'is_featured' => (bool)$p->is_featured,
          'phone' => $p->details?->phone,
        ];
      })->values(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!};

      var map = L.map('travel-map', {
        center: [20, 0],
        zoom: 2,
        zoomControl: true,
        scrollWheelZoom: true,
        worldCopyJump: true
      });

      L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>, &copy; <a href="https://carto.com/">CARTO</a>',
        subdomains: 'abcd',
        maxZoom: 19
      }).addTo(map);

      var markers = L.markerClusterGroup ? L.markerClusterGroup() : null;

      mapPoints.forEach(function(p) {
        if (!p.latitude || !p.longitude) return;
        var color = '#4f46e5';
        var icon = L.divIcon({
          className: 'custom-marker',
          html: '<div style="background:' + color + ';width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;box-shadow:0 2px 8px rgba(0,0,0,0.3);border:2px solid #fff"><i class="fas fa-map-pin"></i></div>',
          iconSize: [32, 32],
          iconAnchor: [16, 16],
          popupAnchor: [0, -20]
        });
        var marker = L.marker([p.latitude, p.longitude], { icon: icon });
        var popupHtml = '<div style="min-width:220px"><strong>' + p.title + '</strong>';
        if (p.address) popupHtml += '<br><span style="font-size:12px;color:#666">' + p.address + (p.city ? ', ' + p.city : '') + '</span>';
        if (p.description) popupHtml += '<br><span style="font-size:12px;color:#888">' + p.description.substring(0, 100) + '</span>';
        if (p.phone) popupHtml += '<br><span style="font-size:12px;color:#666"><i class="fas fa-phone"></i> ' + p.phone + '</span>';
        popupHtml += '</div>';
        marker.bindPopup(popupHtml);

        if (markers) {
          markers.addLayer(marker);
        } else {
          marker.addTo(map);
        }
      });

      if (markers) {
        map.addLayer(markers);
      }

      if (mapPoints.length > 0) {
        var latLngs = mapPoints.filter(function(p) { return p.latitude && p.longitude; }).map(function(p) { return [p.latitude, p.longitude]; });
        if (latLngs.length > 1) {
          map.fitBounds(latLngs, { padding: [30, 30], maxZoom: 12 });
        }
      }
    });
  </script>
</body>
</html>
@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate(
        $__componentHtml,
        app()->getLocale(),
        'home-v2-components-source.php'
    );
@endphp
