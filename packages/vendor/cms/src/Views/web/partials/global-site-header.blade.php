{{-- ═══════════════════════════════════════════════════════════════════
     En-tête global du site (repris de « / ») injecté sur les pages
     établissements. SOLIDE (non transparent) — contrairement à « / » où
     il est transparent. CSS entièrement préfixé « cgh- » et auto-suffisant
     pour ne pas entrer en conflit avec le thème de l'établissement.
     ═══════════════════════════════════════════════════════════════════ --}}
@php
    $cghVideoUrl = \Illuminate\Support\Facades\Route::has('cms.videos.channel')
        ? route('cms.videos.channel') : url('/chaine-videos');
    $cghLink = fn ($name, $fallback = '#') => \Illuminate\Support\Facades\Route::has($name) ? route($name) : $fallback;
@endphp
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" media="print" onload="this.media='all'">
<style>
    :root{ --cgh-h: 68px; }
    .cgh-spacer{ height: var(--cgh-h); }
    .cgh-header{
        position: sticky; top: 0; left: 0; right: 0; z-index: 99990;
        height: var(--cgh-h); display: flex; align-items: center;
        /* Même teinte que le header de « / » au scroll, mais OPAQUE (non transparent) */
        background: rgba(9,16,31,.97);
        -webkit-backdrop-filter: blur(16px) saturate(150%); backdrop-filter: blur(16px) saturate(150%);
        border-bottom: 1px solid rgba(255,255,255,.09);
        box-shadow: 0 8px 26px rgba(3,8,18,.30);
        font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    .cgh-inner{ width:100%; max-width:1440px; margin:0 auto; padding:0 clamp(14px,3vw,36px); display:flex; align-items:center; gap:18px; }
    .cgh-logo{ display:inline-flex; align-items:center; flex-shrink:0; }
    .cgh-logo img{ height:40px; width:auto; display:block; }
    .cgh-nav{ display:flex; align-items:center; gap:26px; margin-left:auto; }
    .cgh-nav a{ color:#e8ecf4; text-decoration:none; font-size:13px; font-weight:600; letter-spacing:.4px; line-height:1; transition:color .2s ease; white-space:nowrap; }
    .cgh-nav a:hover{ color:#d4af37; }
    .cgh-nav a.cgh-nextlevel{ padding:6px 14px; border-radius:20px; color:#0a1628; font-weight:700; background:linear-gradient(135deg,#f6d365,#d4af37); box-shadow:0 2px 8px rgba(212,175,55,.35); }
    .cgh-nav a.cgh-nextlevel:hover{ color:#0a1628; filter:brightness(1.06); }
    .cgh-nav a.cgh-account{ display:inline-flex; align-items:center; gap:6px; }
    .cgh-devis{ display:inline-flex; align-items:center; gap:7px; padding:8px 16px; border-radius:22px; background:linear-gradient(135deg,#1677ff,#7c3aed); color:#fff !important; font-size:12.5px; font-weight:700; }
    .cgh-devis:hover{ filter:brightness(1.08); color:#fff !important; }
    .cgh-burger{ display:none; background:none; border:0; color:#fff; font-size:22px; cursor:pointer; margin-left:auto; }
    @media (max-width: 992px){
        .cgh-nav{ position:fixed; top:var(--cgh-h); right:0; width:min(300px,86vw); height:calc(100vh - var(--cgh-h));
            flex-direction:column; align-items:flex-start; gap:4px; padding:18px; background:rgba(9,16,31,.98);
            transform:translateX(105%); transition:transform .3s ease; overflow-y:auto; margin-left:0; z-index:99991; }
        .cgh-header.cgh-open .cgh-nav{ transform:none; }
        .cgh-nav a{ width:100%; padding:12px 6px; font-size:14px; border-bottom:1px solid rgba(255,255,255,.06); }
        .cgh-burger{ display:inline-flex; }
    }
</style>

<header class="cgh-header" id="cghHeader">
    <div class="cgh-inner">
        <a href="{{ url('/') }}" class="cgh-logo" aria-label="Accueil GoExploria">
            <img src="{{ asset('logo.png') }}" alt="GoExploria" loading="eager">
        </a>
        <button class="cgh-burger" id="cghBurger" aria-label="Menu" aria-expanded="false"><i class="fas fa-bars"></i></button>
        <nav class="cgh-nav" id="cghNav">
            <a href="{{ url('/') }}">ACCUEIL</a>
            <a href="{{ $cghLink('valeurs') }}">NOS VALEURS</a>
            <a href="/company/3/go-exploria-business-next-level" target="_blank" rel="noopener" class="cgh-nextlevel">Next Level</a>
            <a href="{{ $cghVideoUrl }}" target="_blank" rel="noopener"><i class="fas fa-video" style="font-size:11px"></i> Chaîne vidéos</a>
            <a href="{{ $cghLink('contact') }}">CONTACTEZ NOUS</a>
            <a href="{{ $cghLink('mon-compte') }}" class="cgh-account"><i class="fas fa-user-circle"></i> Mon Compte</a>
            <a href="{{ $cghLink('devis') }}" target="_blank" rel="noopener" class="cgh-devis"><i class="fas fa-file-signature" style="font-size:12px"></i> AFFICHEZ VOUS</a>
        </nav>
    </div>
</header>
<div class="cgh-spacer" aria-hidden="true"></div>


<script>
(function(){
    var b = document.getElementById('cghBurger'), h = document.getElementById('cghHeader');
    if (b && h) {
        b.addEventListener('click', function(){
            var open = h.classList.toggle('cgh-open');
            b.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }
})();
</script>
