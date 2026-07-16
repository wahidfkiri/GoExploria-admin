@php
    use Illuminate\Support\Str;

    $accent = trim((string) ($service->color ?? '')) ?: '#10b981';
    $heroImg = $service->image_url;
    $serviceDesc = trim(strip_tags((string) ($service->description ?? '')));

    // Convertit une URL YouTube/Vimeo en URL d'embed, sinon retourne l'URL brute.
    $embed = static function (?string $url): ?string {
        if (!$url) { return null; }
        if (preg_match('~(?:youtube\.com/(?:watch\?v=|embed/)|youtu\.be/)([A-Za-z0-9_-]{11})~', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }
        if (preg_match('~vimeo\.com/(\d+)~', $url, $m)) {
            return 'https://player.vimeo.com/video/' . $m[1];
        }
        return $url;
    };

    $has = static fn ($t) => isset($grouped[$t]) && $grouped[$t]->count() > 0;
@endphp
<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $service->name }} — GoExploria</title>
    <meta name="description" content="{{ Str::limit($serviceDesc, 155) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root { --accent: {{ $accent }}; --ink: #0b2b25; --text: #26382f; --muted: #647a70; --line: #e7efe9; --soft: #f4faf6; --radius: 22px; --shadow: 0 24px 50px rgba(6,60,45,.12); }
        html { scroll-behavior: smooth; }
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; color: var(--text); background: #fff; line-height: 1.65; }
        img { max-width: 100%; display: block; }
        a { text-decoration: none; color: inherit; }
        .sl-container { width: 100%; max-width: 1160px; margin: 0 auto; padding: 0 24px; }
        .sl-section { padding: 84px 0; }
        .sl-section.alt { background: var(--soft); }
        .sl-eyebrow { display: inline-flex; align-items: center; gap: 8px; font-size: .78rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; color: var(--accent); background: color-mix(in srgb, var(--accent) 12%, #fff); padding: 7px 14px; border-radius: 999px; margin-bottom: 16px; }
        .sl-title { font-size: 2.3rem; font-weight: 800; line-height: 1.15; letter-spacing: -.02em; color: var(--ink); }
        .sl-lead { font-size: 1.06rem; color: var(--muted); max-width: 640px; margin-top: 14px; }
        .sl-head { max-width: 700px; margin: 0 auto 50px; text-align: center; }
        .sl-head .sl-lead { margin-left: auto; margin-right: auto; }
        .sl-btn { display: inline-flex; align-items: center; gap: 9px; padding: 14px 26px; border-radius: 999px; font-weight: 700; font-size: .96rem; cursor: pointer; border: 2px solid transparent; transition: transform .2s, box-shadow .2s, background .2s; }
        .sl-btn--primary { background: var(--accent); color: #fff; box-shadow: 0 14px 28px color-mix(in srgb, var(--accent) 32%, transparent); }
        .sl-btn--primary:hover { transform: translateY(-2px); }
        .sl-btn--light { background: #fff; color: var(--ink); }
        .sl-btn--light:hover { transform: translateY(-2px); box-shadow: var(--shadow); }

        /* Back */
        .sl-back { position: fixed; top: 20px; left: 20px; z-index: 30; display: inline-flex; align-items: center; gap: 8px; background: rgba(255,255,255,.92); backdrop-filter: blur(6px); color: var(--ink); font-weight: 700; font-size: .9rem; padding: 10px 16px; border-radius: 999px; box-shadow: 0 8px 20px rgba(0,0,0,.12); }
        .sl-back:hover { color: var(--accent); }

        /* Hero */
        .sl-hero { position: relative; min-height: 62vh; display: flex; align-items: flex-end; background: var(--ink); color: #fff; overflow: hidden; }
        .sl-hero__media { position: absolute; inset: 0; }
        .sl-hero__media img { width: 100%; height: 100%; object-fit: cover; opacity: .55; }
        .sl-hero__veil { position: absolute; inset: 0; background: linear-gradient(180deg, rgba(11,43,37,.25) 0%, rgba(11,43,37,.55) 55%, rgba(11,43,37,.92) 100%); }
        .sl-hero__inner { position: relative; z-index: 2; width: 100%; max-width: 1160px; margin: 0 auto; padding: 72px 24px; }
        .sl-hero__badge { display: inline-flex; align-items: center; gap: 8px; background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25); padding: 8px 16px; border-radius: 999px; font-size: .82rem; font-weight: 600; margin-bottom: 18px; }
        .sl-hero__inner h1 { font-size: 3.2rem; font-weight: 800; line-height: 1.06; letter-spacing: -.03em; max-width: 820px; }
        .sl-hero__inner p { font-size: 1.16rem; color: #d7e7de; margin-top: 18px; max-width: 620px; }
        .sl-hero__actions { display: flex; flex-wrap: wrap; gap: 14px; margin-top: 30px; }

        /* About */
        .sl-about { display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: center; }
        .sl-about__media img { width: 100%; border-radius: var(--radius); box-shadow: var(--shadow); object-fit: cover; }
        .sl-about__text { font-size: 1.02rem; color: var(--muted); }
        .sl-about__text h2 { color: var(--ink); }
        .sl-values { list-style: none; margin: 26px 0 0; display: grid; gap: 14px; }
        .sl-values li { display: flex; gap: 12px; align-items: flex-start; }
        .sl-values li i { flex: 0 0 auto; width: 28px; height: 28px; border-radius: 8px; background: color-mix(in srgb, var(--accent) 14%, #fff); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: .8rem; }

        /* Cards grid */
        .sl-grid { display: grid; gap: 24px; }
        .sl-grid--3 { grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); }
        .sl-grid--4 { grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); }
        .sl-card { display: flex; flex-direction: column; background: #fff; border: 1px solid var(--line); border-radius: var(--radius); overflow: hidden; transition: transform .25s, box-shadow .25s; }
        .sl-card:hover { transform: translateY(-6px); box-shadow: var(--shadow); }
        .sl-card__media { aspect-ratio: 16/10; overflow: hidden; background: var(--soft); }
        .sl-card__media img { width: 100%; height: 100%; object-fit: cover; }
        .sl-card__body { padding: 22px; display: flex; flex-direction: column; gap: 8px; flex: 1; }
        .sl-card__meta { display: flex; flex-wrap: wrap; gap: 10px; font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: var(--accent); }
        .sl-card__body h3 { font-size: 1.14rem; color: var(--ink); }
        .sl-card__body p { font-size: .93rem; color: var(--muted); }
        .sl-chip { display: inline-flex; align-items: center; gap: 6px; font-size: .8rem; font-weight: 600; color: var(--muted); }
        .sl-chip i { color: var(--accent); }
        .sl-card__link { margin-top: auto; padding-top: 12px; font-weight: 700; color: var(--accent); }

        /* Video */
        .sl-video { border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow); background: #000; aspect-ratio: 16/9; }
        .sl-video iframe, .sl-video video { width: 100%; height: 100%; border: 0; display: block; }

        /* Gallery */
        .sl-gallery { display: grid; grid-template-columns: repeat(4, 1fr); grid-auto-rows: 200px; gap: 14px; }
        .sl-gallery figure { margin: 0; border-radius: 14px; overflow: hidden; }
        .sl-gallery img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s; }
        .sl-gallery figure:hover img { transform: scale(1.07); }
        .sl-gallery .tall { grid-row: span 2; }
        .sl-gallery .wide { grid-column: span 2; }

        /* Testimonials */
        .sl-testi { background: #fff; border: 1px solid var(--line); border-radius: var(--radius); padding: 28px; display: flex; flex-direction: column; gap: 14px; }
        .sl-testi__stars { color: #f4b740; letter-spacing: 2px; }
        .sl-testi__quote { color: var(--text); font-style: italic; }
        .sl-testi__author { display: flex; align-items: center; gap: 12px; margin-top: auto; }
        .sl-testi__avatar { width: 48px; height: 48px; border-radius: 50%; background: color-mix(in srgb, var(--accent) 16%, #fff); color: var(--accent); display: flex; align-items: center; justify-content: center; font-weight: 800; overflow: hidden; }
        .sl-testi__avatar img { width: 100%; height: 100%; object-fit: cover; }
        .sl-testi__author b { display: block; color: var(--ink); }
        .sl-testi__author span { font-size: .85rem; color: var(--muted); }

        /* FAQ */
        .sl-faq { max-width: 820px; margin: 0 auto; display: grid; gap: 12px; }
        .sl-faq details { background: #fff; border: 1px solid var(--line); border-radius: 14px; padding: 4px 22px; }
        .sl-faq summary { list-style: none; cursor: pointer; padding: 18px 0; font-weight: 700; color: var(--ink); display: flex; justify-content: space-between; align-items: center; gap: 16px; }
        .sl-faq summary::-webkit-details-marker { display: none; }
        .sl-faq summary::after { content: "\f067"; font-family: "Font Awesome 6 Free"; font-weight: 900; color: var(--accent); font-size: .85rem; transition: transform .2s; }
        .sl-faq details[open] summary::after { transform: rotate(45deg); }
        .sl-faq details p { padding: 0 0 20px; color: var(--muted); font-size: .95rem; }

        /* Contact */
        .sl-contact { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; }
        .sl-contact__card { background: #fff; border: 1px solid var(--line); border-radius: var(--radius); padding: 28px; text-align: center; }
        .sl-contact__ic { width: 56px; height: 56px; border-radius: 16px; margin: 0 auto 14px; background: color-mix(in srgb, var(--accent) 12%, #fff); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
        .sl-contact__card b { display: block; color: var(--ink); margin-bottom: 4px; }
        .sl-contact__card p, .sl-contact__card a { font-size: .93rem; color: var(--muted); }

        /* Footer */
        .sl-footer { background: var(--ink); color: #a9c8bd; text-align: center; padding: 40px 24px; }
        .sl-footer a { color: #fff; font-weight: 700; }

        @media (max-width: 900px) {
            .sl-about { grid-template-columns: 1fr; gap: 30px; }
            .sl-hero__inner h1 { font-size: 2.3rem; }
            .sl-gallery { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 560px) {
            .sl-section { padding: 56px 0; }
            .sl-title { font-size: 1.7rem; }
            .sl-gallery { grid-template-columns: 1fr; grid-auto-rows: 220px; }
            .sl-gallery .wide, .sl-gallery .tall { grid-column: auto; grid-row: auto; }
        }
    </style>
</head>
<body>

<a href="{{ url('/') }}" class="sl-back"><i class="fas fa-arrow-left"></i> Accueil</a>

{{-- HERO --}}
<header class="sl-hero">
    <div class="sl-hero__media">
        @if($heroImg)<img src="{{ $heroImg }}" alt="{{ $service->name }}">@endif
        <span class="sl-hero__veil"></span>
    </div>
    <div class="sl-hero__inner">
        <span class="sl-hero__badge"><i class="{{ Str::contains((string) $service->icon, 'fa-') ? $service->icon : 'fas fa-'.($service->icon ?: 'concierge-bell') }}"></i> Service</span>
        <h1>{{ $service->name }}</h1>
        @if($serviceDesc)<p>{{ Str::limit($serviceDesc, 220) }}</p>@endif
        <div class="sl-hero__actions">
            @if($has('contact'))<a href="#contact" class="sl-btn sl-btn--primary"><i class="fas fa-envelope"></i> Nous contacter</a>@endif
            <a href="{{ route('devis') }}" class="sl-btn sl-btn--light"><i class="fas fa-file-invoice"></i> Demander un devis</a>
        </div>
    </div>
</header>

{{-- À PROPOS --}}
@if($has('about'))
    @foreach($grouped['about'] as $i => $about)
    <section class="sl-section {{ $i % 2 ? 'alt' : '' }}">
        <div class="sl-container">
            <div class="sl-about">
                <div class="sl-about__text">
                    <span class="sl-eyebrow">{{ $about->about_subtitle ?: 'À propos' }}</span>
                    <h2 class="sl-title">{{ $about->title ?: 'À propos de ce service' }}</h2>
                    @if($about->content)<p class="sl-lead">{!! nl2br(e($about->content)) !!}</p>@endif
                    @php
                        $values = $about->about_values;
                        if (is_string($values)) { $decoded = json_decode($values, true); $values = is_array($decoded) ? $decoded : array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $values))); }
                        $values = is_array($values) ? $values : [];
                    @endphp
                    @if(!empty($values))
                    <ul class="sl-values">
                        @foreach($values as $val)
                            <li><i class="fas fa-check"></i><span>{{ is_array($val) ? ($val['label'] ?? implode(' ', $val)) : $val }}</span></li>
                        @endforeach
                    </ul>
                    @endif
                    @if($about->button_text && $about->button_url)
                        <div style="margin-top:28px;"><a href="{{ $about->button_url }}" class="sl-btn sl-btn--primary">{{ $about->button_text }}</a></div>
                    @endif
                </div>
                <div class="sl-about__media">
                    @if($about->image_url)
                        <img src="{{ $about->image_url }}" alt="{{ $about->title }}">
                    @elseif($heroImg)
                        <img src="{{ $heroImg }}" alt="{{ $service->name }}">
                    @endif
                </div>
            </div>
        </div>
    </section>
    @endforeach
@endif

{{-- ÉVÉNEMENTS --}}
@if($has('event'))
<section class="sl-section">
    <div class="sl-container">
        <div class="sl-head">
            <span class="sl-eyebrow">{{ $typeLabels['event'] }}</span>
            <h2 class="sl-title">Nos prochains événements</h2>
        </div>
        <div class="sl-grid sl-grid--3">
            @foreach($grouped['event'] as $ev)
            <article class="sl-card">
                @if($ev->image_url)<div class="sl-card__media"><img src="{{ $ev->image_url }}" alt="{{ $ev->title }}"></div>@endif
                <div class="sl-card__body">
                    <div class="sl-card__meta">
                        @if($ev->event_start_date)<span><i class="far fa-calendar"></i> {{ $ev->event_start_date->format('d/m/Y') }}</span>@endif
                    </div>
                    <h3>{{ $ev->title }}</h3>
                    @if($ev->content)<p>{{ Str::limit(strip_tags($ev->content), 130) }}</p>@endif
                    <div style="display:flex;flex-wrap:wrap;gap:12px;margin-top:6px;">
                        @if($ev->event_location)<span class="sl-chip"><i class="fas fa-location-dot"></i> {{ $ev->event_location }}</span>@endif
                        <span class="sl-chip"><i class="fas fa-tag"></i> {{ $ev->event_is_free ? 'Gratuit' : ($ev->event_price ? number_format((float) $ev->event_price, 2, ',', ' ').' $' : 'Sur réservation') }}</span>
                    </div>
                    @if($ev->button_url)<a href="{{ $ev->button_url }}" class="sl-card__link">{{ $ev->button_text ?: 'En savoir plus' }} →</a>@endif
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- GALERIE --}}
@if($has('gallery'))
<section class="sl-section alt">
    <div class="sl-container">
        <div class="sl-head">
            <span class="sl-eyebrow">{{ $typeLabels['gallery'] }}</span>
            <h2 class="sl-title">En images</h2>
        </div>
        <div class="sl-gallery">
            @foreach($grouped['gallery'] as $g)
                @if($g->image_url)
                    <figure class="{{ $loop->index % 5 === 0 ? 'wide' : ($loop->index % 3 === 0 ? 'tall' : '') }}"><img src="{{ $g->image_url }}" alt="{{ $g->title }}"></figure>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- VIDÉOS --}}
@if($has('video'))
<section class="sl-section">
    <div class="sl-container">
        <div class="sl-head">
            <span class="sl-eyebrow">{{ $typeLabels['video'] }}</span>
            <h2 class="sl-title">Découvrez en vidéo</h2>
        </div>
        <div class="sl-grid sl-grid--3">
            @foreach($grouped['video'] as $vid)
                @php $vurl = $embed($vid->video_url); @endphp
                @if($vurl)
                <div>
                    <div class="sl-video">
                        @if(Str::contains($vurl, ['youtube.com/embed', 'player.vimeo.com']))
                            <iframe src="{{ $vurl }}" title="{{ $vid->title }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @else
                            <video src="{{ $vurl }}" controls preload="metadata" {{ $vid->video_muted ? 'muted' : '' }}></video>
                        @endif
                    </div>
                    @if($vid->title)<h3 style="margin-top:14px;color:var(--ink);font-size:1.05rem;">{{ $vid->title }}</h3>@endif
                </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ACTUALITÉS / BLOG --}}
@if($has('blog'))
<section class="sl-section alt">
    <div class="sl-container">
        <div class="sl-head">
            <span class="sl-eyebrow">{{ $typeLabels['blog'] }}</span>
            <h2 class="sl-title">Actualités &amp; conseils</h2>
        </div>
        <div class="sl-grid sl-grid--3">
            @foreach($grouped['blog'] as $post)
            <article class="sl-card">
                @if($post->image_url)<div class="sl-card__media"><img src="{{ $post->image_url }}" alt="{{ $post->title }}"></div>@endif
                <div class="sl-card__body">
                    <div class="sl-card__meta">
                        @if($post->blog_category)<span>{{ $post->blog_category }}</span>@endif
                        @if($post->published_at)<span style="color:var(--muted);font-weight:600;">{{ $post->published_at->format('d/m/Y') }}</span>@endif
                    </div>
                    <h3>{{ $post->title }}</h3>
                    <p>{{ Str::limit(strip_tags($post->blog_excerpt ?: $post->content), 140) }}</p>
                    @if($post->blog_author)<span class="sl-chip"><i class="fas fa-user"></i> {{ $post->blog_author }}</span>@endif
                    @if($post->button_url)<a href="{{ $post->button_url }}" class="sl-card__link">{{ $post->button_text ?: 'Lire la suite' }} →</a>@endif
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- TÉMOIGNAGES --}}
@if($has('testimonial'))
<section class="sl-section">
    <div class="sl-container">
        <div class="sl-head">
            <span class="sl-eyebrow">{{ $typeLabels['testimonial'] }}</span>
            <h2 class="sl-title">Ils nous font confiance</h2>
        </div>
        <div class="sl-grid sl-grid--3">
            @foreach($grouped['testimonial'] as $t)
            <article class="sl-testi">
                <div class="sl-testi__stars">@for($s = 0; $s < max(1, (int) ($t->testimonial_rating ?: 5)); $s++)★@endfor</div>
                <p class="sl-testi__quote">« {{ Str::limit(strip_tags($t->testimonial_content ?: $t->content), 220) }} »</p>
                <div class="sl-testi__author">
                    <span class="sl-testi__avatar">@if($t->image_url)<img src="{{ $t->image_url }}" alt="{{ $t->testimonial_name }}">@else{{ Str::upper(Str::substr($t->testimonial_name ?: 'A', 0, 1)) }}@endif</span>
                    <div><b>{{ $t->testimonial_name ?: 'Client' }}</b>@if($t->testimonial_role)<span>{{ $t->testimonial_role }}</span>@endif</div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- FAQ --}}
@if($has('faq'))
<section class="sl-section alt">
    <div class="sl-container">
        <div class="sl-head">
            <span class="sl-eyebrow">{{ $typeLabels['faq'] }}</span>
            <h2 class="sl-title">Questions fréquentes</h2>
        </div>
        <div class="sl-faq">
            @foreach($grouped['faq'] as $f)
            <details {{ $loop->first ? 'open' : '' }}>
                <summary>{{ $f->faq_question ?: $f->title }}</summary>
                <p>{!! nl2br(e(strip_tags($f->content))) !!}</p>
            </details>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CONTACT --}}
@if($has('contact'))
<section class="sl-section" id="contact">
    <div class="sl-container">
        <div class="sl-head">
            <span class="sl-eyebrow">{{ $typeLabels['contact'] }}</span>
            <h2 class="sl-title">Contactez-nous</h2>
            @php $c = $grouped['contact']->first(); @endphp
            @if($c && $c->contact_message)<p class="sl-lead">{{ $c->contact_message }}</p>@endif
        </div>
        @if($c)
        <div class="sl-contact">
            @if($c->contact_address)<div class="sl-contact__card"><div class="sl-contact__ic"><i class="fas fa-location-dot"></i></div><b>Adresse</b><p>{{ $c->contact_address }}</p></div>@endif
            @if($c->contact_phone)<div class="sl-contact__card"><div class="sl-contact__ic"><i class="fas fa-phone"></i></div><b>Téléphone</b><a href="tel:{{ preg_replace('/\s+/', '', $c->contact_phone) }}">{{ $c->contact_phone }}</a></div>@endif
            @if($c->contact_email)<div class="sl-contact__card"><div class="sl-contact__ic"><i class="fas fa-envelope"></i></div><b>Email</b><a href="mailto:{{ $c->contact_email }}">{{ $c->contact_email }}</a></div>@endif
            @if($c->contact_hours)<div class="sl-contact__card"><div class="sl-contact__ic"><i class="far fa-clock"></i></div><b>Horaires</b><p>{{ $c->contact_hours }}</p></div>@endif
        </div>
        @endif
    </div>
</section>
@endif

{{-- Aucun contenu --}}
@if($grouped->isEmpty())
<section class="sl-section">
    <div class="sl-container" style="text-align:center;">
        <div class="sl-head">
            <span class="sl-eyebrow">Service</span>
            <h2 class="sl-title">Bientôt disponible</h2>
            <p class="sl-lead">Le contenu détaillé de ce service sera publié prochainement.</p>
        </div>
        <a href="{{ route('devis') }}" class="sl-btn sl-btn--primary"><i class="fas fa-file-invoice"></i> Demander un devis</a>
    </div>
</section>
@endif

<footer class="sl-footer">
    <p>© {{ date('Y') }} GoExploria — {{ $service->name }}. <a href="{{ url('/') }}">Retour à l'accueil</a></p>
</footer>

</body>
</html>
