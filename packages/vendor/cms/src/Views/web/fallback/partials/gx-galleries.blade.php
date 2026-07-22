{{-- ═══════════════════════════════════════════════════════════════════════
     Hydrateur des galeries filtrables (Lot 5).

     Transforme chaque placeholder <div data-gx-gallery …> (déposé via l'éditeur
     VvvebJS) en galerie réelle : grille, carrousel, slider, lightbox ou
     carrousel YouTube. Filtres destination/activité/catégorie, titre + lien
     cliquable sous chaque média, lazy-loading, et barre de filtres cliquable
     optionnelle (data-filterable="true").

     Dépend de l'API du Lot 2 : /api/cms/company/{etab}/galleries/media.
     Swiper (déjà chargé par la landing) sert aux carrousels/sliders.
     Inclus une seule fois par page (@once) ; nécessite $etablissement.
     ═══════════════════════════════════════════════════════════════════════ --}}
@isset($etablissement)
@once
<style>
    .gxg{margin:22px 0}
    .gxg-bar{display:flex;flex-wrap:wrap;gap:8px;align-items:center;margin-bottom:18px}
    .gxg-bar .gxg-group{display:flex;flex-wrap:wrap;gap:6px}
    .gxg-chip{padding:8px 15px;border-radius:999px;border:1px solid rgba(15,23,42,.14);background:#fff;font:600 13.5px/1 inherit;color:#334155;cursor:pointer;transition:.18s;white-space:nowrap}
    .gxg-chip:hover{border-color:#0284c7;color:#0284c7}
    .gxg-chip.is-on{background:#0284c7;border-color:#0284c7;color:#fff}
    .gxg-search{flex:1;min-width:180px;padding:9px 14px;border:1px solid rgba(15,23,42,.14);border-radius:999px;font:inherit}
    .gxg-search:focus{outline:none;border-color:#0284c7}
    .gxg-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px}
    .gxg-item{position:relative;border-radius:14px;overflow:hidden;background:#0f172a;box-shadow:0 8px 24px rgba(15,23,42,.08)}
    .gxg-item > a,.gxg-item > .gxg-frame{display:block;position:relative;aspect-ratio:4/3;overflow:hidden}
    .gxg-item img,.gxg-item video{width:100%;height:100%;object-fit:cover;display:block;transition:transform .5s ease}
    .gxg-item:hover img{transform:scale(1.06)}
    .gxg-item iframe{width:100%;height:100%;border:0;display:block}
    .gxg-play{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;color:#fff;font-size:44px;text-shadow:0 4px 16px rgba(0,0,0,.5);pointer-events:none}
    .gxg-cap{padding:11px 13px;background:#fff}
    .gxg-cap .t{font-weight:700;font-size:14.5px;color:#0f172a;margin:0;line-height:1.3}
    .gxg-cap .l{display:inline-flex;align-items:center;gap:6px;margin-top:6px;font-size:13px;font-weight:700;color:#0284c7;text-decoration:none}
    .gxg-empty{padding:30px;text-align:center;color:#64748b;font-size:14.5px}
    .gxg-more{display:block;margin:20px auto 0;padding:12px 26px;border:0;border-radius:999px;background:#0f172a;color:#fff;font-weight:700;cursor:pointer}
    /* Carrousel / slider : chaque item devient une slide Swiper */
    .gxg-swiper{overflow:hidden}
    .gxg-swiper .swiper-slide{height:auto}
    .gxg-swiper .swiper-button-next,.gxg-swiper .swiper-button-prev{color:#0284c7}
    .gxg-swiper .swiper-pagination-bullet-active{background:#0284c7}
    /* Lightbox plein écran */
    .gxg-lb{position:fixed;inset:0;z-index:100000;background:rgba(2,6,23,.92);display:none;align-items:center;justify-content:center;padding:20px}
    .gxg-lb.is-open{display:flex}
    .gxg-lb img,.gxg-lb video,.gxg-lb iframe{max-width:92vw;max-height:88vh;border-radius:10px;background:#000}
    .gxg-lb-close,.gxg-lb-nav{position:absolute;background:rgba(255,255,255,.14);color:#fff;border:0;width:52px;height:52px;border-radius:50%;font-size:22px;cursor:pointer}
    .gxg-lb-close{top:18px;right:18px}
    .gxg-lb-nav.prev{left:14px;top:50%;transform:translateY(-50%)}
    .gxg-lb-nav.next{right:14px;top:50%;transform:translateY(-50%)}
    @media(max-width:640px){.gxg-grid{grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:10px}}
</style>

<script>
    window.GX_GALLERY_API = @json(url('/api/cms/company/' . $etablissement->id . '/galleries'));
</script>

<script>
(function () {
    var API = window.GX_GALLERY_API;
    if (!API) { return; }

    function esc(s) { return String(s == null ? '' : s).replace(/[&<>"]/g, function (c) {
        return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c];
    }); }

    function ytId(url) {
        var m = String(url || '').match(/(?:youtube\.com\/(?:watch\?v=|shorts\/|embed\/|live\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/i);
        return m ? m[1] : null;
    }
    function vimeoId(url) {
        var m = String(url || '').match(/vimeo\.com\/(?:video\/)?(\d+)/i);
        return m ? m[1] : null;
    }

    // Construit l'URL de l'API à partir des filtres d'une galerie.
    function apiUrl(state) {
        var p = [];
        if (state.type && state.type !== 'mixed') p.push('type=' + encodeURIComponent(state.type));
        if (state.destination) p.push('destination_id=' + encodeURIComponent(state.destination));
        if (state.activite) p.push('activite_id=' + encodeURIComponent(state.activite));
        if (state.categorie) p.push('categorie_id=' + encodeURIComponent(state.categorie));
        if (state.q) p.push('q=' + encodeURIComponent(state.q));
        p.push('limit=' + (parseInt(state.limit, 10) || 12));
        p.push('page=' + (state.page || 1));
        return API + '/media?' + p.join('&');
    }

    // Média cliquable : lightbox si demandé, sinon le lien du média.
    function mediaInner(item, layout) {
        var isVideo = item.type === 'video';
        var media;
        if (isVideo && (ytId(item.video_url) || vimeoId(item.video_url))) {
            var yt = ytId(item.video_url);
            var src = yt ? 'https://www.youtube.com/embed/' + yt
                         : 'https://player.vimeo.com/video/' + vimeoId(item.video_url);
            media = '<div class="gxg-frame"><iframe src="' + src + '" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen loading="lazy"></iframe></div>';
        } else if (isVideo && item.video_url) {
            media = '<div class="gxg-frame"><video src="' + esc(item.video_url) + '" controls muted playsinline preload="metadata"></video></div>';
        } else if (isVideo) {
            media = '<div class="gxg-frame"><video src="' + esc(item.url) + '" controls muted playsinline preload="metadata"></video></div>';
        } else {
            media = '<img src="' + esc(item.url) + '" alt="' + esc(item.alt) + '" loading="lazy">';
        }
        if (isVideo && (ytId(item.video_url) || vimeoId(item.video_url))) return media;
        return media + (isVideo ? '' : '');
    }

    // Vignette complète (média + titre + lien).
    function card(item, layout) {
        var isVideo = item.type === 'video';
        var inner = mediaInner(item, layout);
        var openable = !(isVideo && (ytId(item.video_url) || vimeoId(item.video_url)));
        var wrap = (layout === 'lightbox' && openable)
            ? '<a href="#" class="gxg-open" data-id="' + item.id + '">' + inner + (isVideo ? '<span class="gxg-play"><i class="fa-solid fa-play"></i></span>' : '') + '</a>'
            : inner;

        var cap = '';
        if (item.title || item.link_url) {
            cap = '<div class="gxg-cap">'
                + (item.title ? '<p class="t">' + esc(item.title) + '</p>' : '')
                + (item.link_url ? '<a class="l" href="' + esc(item.link_url) + '" target="_blank" rel="noopener">'
                    + esc(item.link_text || 'Voir') + ' <i class="fa-solid fa-arrow-right"></i></a>' : '')
                + '</div>';
        }
        return '<div class="gxg-item">' + wrap + cap + '</div>';
    }

    // Récupère les médias et rend la galerie.
    function load(host, state, append) {
        fetch(apiUrl(state), { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                var items = (res && res.data) || [];
                var body = host.querySelector('.gxg-body');

                if (!append && !items.length) {
                    body.innerHTML = '<div class="gxg-empty">Aucun média pour ces filtres.</div>';
                    return;
                }

                var layout = state.layout;
                if (layout === 'carousel' || layout === 'slider' || layout === 'youtube') {
                    renderSwiper(host, body, items, layout, state);
                } else {
                    var html = items.map(function (it) { return card(it, layout); }).join('');
                    if (append) { body.insertAdjacentHTML('beforeend', html); }
                    else { body.className = 'gxg-body gxg-grid'; body.innerHTML = html; }
                    wireLightbox(host, state, items, append);
                    // Pagination « charger plus »
                    var more = host.querySelector('.gxg-more');
                    if (more) { more.remove(); }
                    if (res.pagination && res.pagination.has_more) {
                        var btn = document.createElement('button');
                        btn.className = 'gxg-more'; btn.textContent = 'Voir plus';
                        btn.addEventListener('click', function () { state.page = (state.page || 1) + 1; load(host, state, true); });
                        body.after(btn);
                    }
                }
            })
            .catch(function () {
                host.querySelector('.gxg-body').innerHTML = '<div class="gxg-empty">Impossible de charger la galerie.</div>';
            });
    }

    function renderSwiper(host, body, items, layout, state) {
        var slides = items.map(function (it) { return '<div class="swiper-slide">' + card(it, layout) + '</div>'; }).join('');
        body.className = 'gxg-body gxg-swiper swiper';
        body.innerHTML = '<div class="swiper-wrapper">' + slides + '</div>'
            + '<div class="swiper-button-prev"></div><div class="swiper-button-next"></div>'
            + '<div class="swiper-pagination"></div>';
        if (typeof Swiper === 'undefined') { return; }
        new Swiper(body, {
            slidesPerView: 1.15, spaceBetween: 16, loop: items.length > 3,
            pagination: { el: body.querySelector('.swiper-pagination'), clickable: true },
            navigation: { nextEl: body.querySelector('.swiper-button-next'), prevEl: body.querySelector('.swiper-button-prev') },
            breakpoints: { 576: { slidesPerView: 2 }, 992: { slidesPerView: layout === 'slider' ? 1 : 3 }, 1200: { slidesPerView: layout === 'slider' ? 1 : 4 } }
        });
    }

    // Lightbox partagée (une par galerie).
    function wireLightbox(host, state, items, append) {
        if (state.layout !== 'lightbox') { return; }
        if (append) { state._items = (state._items || []).concat(items); }
        else { state._items = items.slice(); }

        var lb = host.__lb;
        if (!lb) {
            lb = document.createElement('div');
            lb.className = 'gxg-lb';
            lb.innerHTML = '<button class="gxg-lb-close" aria-label="Fermer">&times;</button>'
                + '<button class="gxg-lb-nav prev" aria-label="Précédent">&#8249;</button>'
                + '<div class="gxg-lb-stage"></div>'
                + '<button class="gxg-lb-nav next" aria-label="Suivant">&#8250;</button>';
            document.body.appendChild(lb);
            host.__lb = lb;
            var idx = 0;
            function show(i) {
                var arr = state._items; if (!arr.length) return;
                idx = (i + arr.length) % arr.length;
                var it = arr[idx];
                var stage = lb.querySelector('.gxg-lb-stage');
                stage.innerHTML = it.type === 'video'
                    ? (ytId(it.video_url) ? '<iframe src="https://www.youtube.com/embed/' + ytId(it.video_url) + '?autoplay=1" allow="autoplay; fullscreen" allowfullscreen></iframe>'
                        : '<video src="' + esc(it.video_url || it.url) + '" controls autoplay playsinline></video>')
                    : '<img src="' + esc(it.url) + '" alt="' + esc(it.alt) + '">';
            }
            lb.__show = show;
            lb.querySelector('.gxg-lb-close').addEventListener('click', function () { lb.classList.remove('is-open'); lb.querySelector('.gxg-lb-stage').innerHTML = ''; });
            lb.querySelector('.prev').addEventListener('click', function () { show(idx - 1); });
            lb.querySelector('.next').addEventListener('click', function () { show(idx + 1); });
            lb.addEventListener('click', function (e) { if (e.target === lb) { lb.classList.remove('is-open'); lb.querySelector('.gxg-lb-stage').innerHTML = ''; } });
            document.addEventListener('keydown', function (e) { if (!lb.classList.contains('is-open')) return; if (e.key === 'Escape') lb.querySelector('.gxg-lb-close').click(); if (e.key === 'ArrowLeft') show(idx - 1); if (e.key === 'ArrowRight') show(idx + 1); });
        }
        host.querySelectorAll('.gxg-open').forEach(function (a) {
            if (a.__w) return; a.__w = 1;
            a.addEventListener('click', function (e) {
                e.preventDefault();
                var id = a.dataset.id;
                var i = state._items.findIndex(function (x) { return String(x.id) === String(id); });
                lb.__show(i < 0 ? 0 : i);
                lb.classList.add('is-open');
            });
        });
    }

    // Barre de filtres cliquable + recherche (si data-filterable="true").
    function buildFilters(host, state) {
        fetch(API + '/filters', { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.json(); })
            .then(function (f) {
                var groups = [
                    { key: 'destination', label: 'Destination', list: f.destinations || [] },
                    { key: 'activite', label: 'Activité', list: f.activites || [] },
                    { key: 'categorie', label: 'Catégorie', list: f.categories || [] }
                ].filter(function (g) { return g.list.length; });

                var bar = host.querySelector('.gxg-bar');
                var html = '';
                groups.forEach(function (g) {
                    var chips = '<button class="gxg-chip is-on" data-k="' + g.key + '" data-v="">Tout</button>'
                        + g.list.map(function (o) { return '<button class="gxg-chip" data-k="' + g.key + '" data-v="' + o.id + '">' + esc(o.name) + '</button>'; }).join('');
                    html += '<div class="gxg-group">' + chips + '</div>';
                });
                html += '<input class="gxg-search" type="search" placeholder="Rechercher…">';
                bar.innerHTML = html;

                bar.querySelectorAll('.gxg-chip').forEach(function (c) {
                    c.addEventListener('click', function () {
                        bar.querySelectorAll('.gxg-chip[data-k="' + c.dataset.k + '"]').forEach(function (x) { x.classList.remove('is-on'); });
                        c.classList.add('is-on');
                        state[c.dataset.k] = c.dataset.v || '';
                        state.page = 1;
                        load(host, state, false);
                    });
                });
                var s = bar.querySelector('.gxg-search'), t;
                s.addEventListener('input', function () {
                    clearTimeout(t);
                    t = setTimeout(function () { state.q = s.value.trim(); state.page = 1; load(host, state, false); }, 350);
                });
            }).catch(function () {});
    }

    // Hydrate un placeholder.
    function hydrate(el) {
        if (el.__gx) return; el.__gx = 1;
        var d = el.dataset;
        var state = {
            layout: d.layout || 'grid',
            type: d.type || 'image',
            destination: d.destination || '',
            activite: d.activite || '',
            categorie: d.categorie || '',
            limit: d.limit || 12,
            q: '', page: 1
        };
        var filterable = d.filterable === 'true' || d.filterable === '1';
        el.classList.add('gxg');
        el.innerHTML = (filterable ? '<div class="gxg-bar"></div>' : '') + '<div class="gxg-body gxg-grid"></div>';
        if (filterable) { buildFilters(el, state); }
        load(el, state, false);
    }

    function scan(root) {
        (root || document).querySelectorAll('[data-gx-gallery]').forEach(hydrate);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () { scan(document); });
    } else { scan(document); }
})();
</script>
@endonce
@endisset
