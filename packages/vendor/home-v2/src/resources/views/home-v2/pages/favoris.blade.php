<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Favoris &mdash; GoExploria</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home-v2/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/navigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-mega-menu-modern.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-destinations-mega.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/footer.css') }}">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Montserrat',sans-serif;background:#f4f6f9;color:#0a1628;overflow-x:hidden}

        /* Page Banner */
        .page-banner{background:linear-gradient(135deg,#0a1628,#1a2942);padding:48px 40px;position:relative;overflow:hidden}
        .page-banner::before{content:'';position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=1400&q=80') center/cover;opacity:.08}
        .page-banner-inner{position:relative;z-index:1;max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;gap:24px;flex-wrap:wrap}
        .page-banner-left .badge{display:inline-flex;align-items:center;gap:6px;padding:5px 14px;background:rgba(230,57,70,.15);border:1px solid rgba(230,57,70,.3);border-radius:20px;font-size:11px;font-weight:700;color:#ff8591;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:14px}
        .page-banner-left h1{font-size:clamp(1.6rem,3.5vw,2.4rem);font-weight:900;color:#fff;margin-bottom:8px}
        .page-banner-left h1 span{color:#e63946}
        .page-banner-left p{font-size:13px;color:rgba(255,255,255,.55);line-height:1.6}
        .banner-count{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:14px;padding:20px 28px;text-align:center;white-space:nowrap}
        .banner-count .num{font-size:2.4rem;font-weight:900;color:#e63946}
        .banner-count .lbl{font-size:11px;color:rgba(255,255,255,.5);font-weight:600;letter-spacing:.5px;margin-top:2px}

        /* Filters */
        .filters-bar{background:#fff;border-bottom:1px solid #e9ecef;padding:0 40px;position:sticky;top:80px;z-index:100;box-shadow:0 2px 8px rgba(0,0,0,.04);margin-top:150px}
        .filters-inner{max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;gap:16px}
        .filter-tabs{display:flex;gap:0;overflow-x:auto}
        .ftab{display:flex;align-items:center;gap:7px;padding:16px 20px;font-size:12px;font-weight:700;color:#6b7280;border-bottom:3px solid transparent;cursor:pointer;transition:all .18s;white-space:nowrap;text-decoration:none}
        .ftab:hover{color:#0a1628}
        .ftab.active{color:#e63946;border-bottom-color:#e63946}
        .ftab .cnt{background:#f3f4f6;border-radius:10px;padding:2px 7px;font-size:10px;font-weight:800}
        .ftab.active .cnt{background:rgba(230,57,70,.1);color:#e63946}
        .filter-right{display:flex;align-items:center;gap:12px;flex-shrink:0}
        .sort-select{padding:8px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:'Montserrat',sans-serif;font-size:12px;font-weight:600;color:#374151;outline:none;cursor:pointer}
        .view-btn{width:34px;height:34px;border:1.5px solid #e5e7eb;border-radius:8px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .18s;background:#fff;color:#6b7280}
        .view-btn.active,.view-btn:hover{border-color:#0a1628;color:#0a1628}

        /* Content */
        .page-wrap{max-width:1200px;margin:0 auto;padding:40px 32px 60px}
        .fav-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}

        /* Fav Card */
        .fav-card{background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 2px 14px rgba(0,0,0,.06);transition:all .25s;cursor:pointer}
        .fav-card:hover{transform:translateY(-5px);box-shadow:0 10px 32px rgba(0,0,0,.12)}
        .fav-img{position:relative;overflow:hidden;aspect-ratio:16/10}
        .fav-img img{width:100%;height:100%;object-fit:cover;transition:transform .35s}
        .fav-card:hover .fav-img img{transform:scale(1.05)}
        .fav-cat{position:absolute;top:12px;left:12px;padding:4px 10px;border-radius:12px;font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.8px;backdrop-filter:blur(8px)}
        .cat-dest{background:rgba(67,97,238,.85);color:#fff}
        .cat-act{background:rgba(45,198,83,.85);color:#fff}
        .cat-rest{background:rgba(230,57,70,.85);color:#fff}
        .cat-heb{background:rgba(212,175,55,.85);color:#0a1628}
        .fav-heart{position:absolute;top:12px;right:12px;width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,.95);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;box-shadow:0 2px 8px rgba(0,0,0,.15)}
        .fav-heart:hover{background:#e63946;color:#fff}
        .fav-heart i{color:#e63946;font-size:15px;transition:color .2s}
        .fav-heart:hover i{color:#fff}
        .fav-rating{position:absolute;bottom:12px;left:12px;display:flex;align-items:center;gap:5px;padding:4px 10px;background:rgba(10,22,40,.75);border-radius:10px;backdrop-filter:blur(4px)}
        .fav-rating i{color:#d4af37;font-size:11px}
        .fav-rating span{font-size:11px;font-weight:700;color:#fff}
        .fav-body{padding:18px 20px}
        .fav-region{font-size:10px;font-weight:700;color:#9ba3af;text-transform:uppercase;letter-spacing:1px;margin-bottom:5px}
        .fav-name{font-size:15px;font-weight:800;color:#0a1628;margin-bottom:6px;line-height:1.25}
        .fav-desc{font-size:12px;color:#6b7280;line-height:1.55;margin-bottom:14px}
        .fav-footer{display:flex;align-items:center;justify-content:space-between}
        .fav-price{font-size:14px;font-weight:900;color:#0a1628}
        .fav-price small{font-size:10px;color:#9ba3af;font-weight:500}
        .btn-add{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:linear-gradient(135deg,#0a1628,#1a2942);color:#fff;border-radius:8px;font-size:11px;font-weight:700;text-decoration:none;transition:all .2s;border:none;cursor:pointer;font-family:'Montserrat',sans-serif}
        .btn-add:hover{transform:translateY(-1px);box-shadow:0 5px 14px rgba(10,22,40,.25)}
        .btn-add i{color:#d4af37;font-size:10px}

        /* Empty state */
        .empty-state{text-align:center;padding:80px 40px;color:#9ba3af}
        .empty-icon{font-size:64px;margin-bottom:16px;color:#e5e7eb}
        .empty-title{font-size:1.2rem;font-weight:800;color:#374151;margin-bottom:8px}
        .empty-sub{font-size:13px;line-height:1.6;margin-bottom:24px}
        .btn-explore{display:inline-flex;align-items:center;gap:8px;padding:12px 28px;background:linear-gradient(135deg,#0a1628,#1a2942);color:#fff;border-radius:10px;font-size:13px;font-weight:700;text-decoration:none;transition:all .2s}
        .btn-explore:hover{transform:translateY(-1px);box-shadow:0 5px 20px rgba(10,22,40,.25)}

        /* Share Banner */
        .share-banner{background:#fff;border-radius:14px;padding:24px 32px;margin-top:40px;display:flex;align-items:center;justify-content:space-between;gap:20px;box-shadow:0 2px 12px rgba(0,0,0,.05)}
        .share-info h3{font-size:14px;font-weight:800;color:#0a1628;margin-bottom:4px}
        .share-info p{font-size:12px;color:#6b7280;line-height:1.5}
        .share-btns{display:flex;gap:10px;flex-shrink:0}
        .sbtn{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;transition:all .2s;border:1.5px solid transparent}
        .sbtn-copy{border-color:#e5e7eb;color:#374151;background:#fff}
        .sbtn-copy:hover{border-color:#0a1628;color:#0a1628}
        .sbtn-share{background:linear-gradient(135deg,#0a1628,#1a2942);color:#fff}
        .sbtn-share:hover{transform:translateY(-1px);box-shadow:0 4px 14px rgba(10,22,40,.2)}

        @media(max-width:1000px){.fav-grid{grid-template-columns:repeat(2,1fr)}}
        @media(max-width:680px){.fav-grid{grid-template-columns:1fr}.page-wrap{padding:28px 16px}.filters-bar{padding:0 16px}.page-banner{padding:32px 20px}.page-banner-inner{flex-direction:column}.share-banner{flex-direction:column;text-align:center}.share-btns{justify-content:center}}
    </style>
</head>
<body>

@include('home-v2.components.VerticalMenu')
@include('home-v2.components.Header')

<div class="filters-bar">
    <div class="filters-inner">
        <nav class="filter-tabs">
            <a href="#" class="ftab active">Tous <span class="cnt">38</span></a>
            <a href="#" class="ftab">Destinations <span class="cnt">18</span></a>
            <a href="#" class="ftab">Activit&eacute;s <span class="cnt">9</span></a>
            <a href="#" class="ftab">Restaurants <span class="cnt">7</span></a>
            <a href="#" class="ftab">H&eacute;bergements <span class="cnt">4</span></a>
        </nav>
        <div class="filter-right">
            <select class="sort-select">
                <option>R&eacute;cemment ajout&eacute;s</option>
                <option>Alphabétique A-Z</option>
                <option>Prix croissant</option>
                <option>Mieux not&eacute;s</option>
            </select>
            <button class="view-btn active"><i class="fas fa-th"></i></button>
            <button class="view-btn"><i class="fas fa-list"></i></button>
        </div>
    </div>
</div>

<div class="page-wrap">
    <div class="fav-grid">

        {{-- Card 1 --}}
        <div class="fav-card">
            <div class="fav-img">
                <img src="https://images.unsplash.com/photo-1519003722824-194d4455a60c?w=600&q=80" alt="Qu&eacute;bec City">
                <span class="fav-cat cat-dest">Destination</span>
                <div class="fav-heart"><i class="fas fa-heart"></i></div>
                <div class="fav-rating"><i class="fas fa-star"></i><span>4.9 (1 240 avis)</span></div>
            </div>
            <div class="fav-body">
                <div class="fav-region">Qu&eacute;bec, Canada</div>
                <div class="fav-name">Vieux-Qu&eacute;bec &amp; Plaines d&apos;Abraham</div>
                <div class="fav-desc">La seule ville fortifi&eacute;e au nord du Mexique, class&eacute;e patrimoine mondial de l&apos;UNESCO. Paysages spectaculaires et histoire vivante.</div>
                <div class="fav-footer">
                    <div class="fav-price">D&egrave;s 1 290 $<small> / pers.</small></div>
                    <button class="btn-add"><i class="fas fa-plus"></i> Ajouter au panier</button>
                </div>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="fav-card">
            <div class="fav-img">
                <img src="https://images.unsplash.com/photo-1504704911898-68304a7d2807?w=600&q=80" alt="Ski">
                <span class="fav-cat cat-act">Activit&eacute;</span>
                <div class="fav-heart"><i class="fas fa-heart"></i></div>
                <div class="fav-rating"><i class="fas fa-star"></i><span>4.8 (863 avis)</span></div>
            </div>
            <div class="fav-body">
                <div class="fav-region">Laurentides, Qu&eacute;bec</div>
                <div class="fav-name">Ski alpin &mdash; Mont-Tremblant</div>
                <div class="fav-desc">99 pistes, 7 faces, 14 remontes-pentes m&eacute;caniques. Le plus grand domaine skiable de l&apos;Est canadien.</div>
                <div class="fav-footer">
                    <div class="fav-price">D&egrave;s 84 $<small> / journ&eacute;e</small></div>
                    <button class="btn-add"><i class="fas fa-plus"></i> Ajouter au panier</button>
                </div>
            </div>
        </div>

        {{-- Card 3 --}}
        <div class="fav-card">
            <div class="fav-img">
                <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&q=80" alt="Restaurant">
                <span class="fav-cat cat-rest">Restaurant</span>
                <div class="fav-heart"><i class="fas fa-heart"></i></div>
                <div class="fav-rating"><i class="fas fa-star"></i><span>4.7 (412 avis)</span></div>
            </div>
            <div class="fav-body">
                <div class="fav-region">Montr&eacute;al, Qu&eacute;bec</div>
                <div class="fav-name">Le Mousso &mdash; Gastronomie Qu&eacute;b&eacute;coise</div>
                <div class="fav-desc">Cuisine cr&eacute;ative inspir&eacute;e des produits locaux du terroir qu&eacute;b&eacute;cois. R&eacute;serv&eacute; aux grandes occasions.</div>
                <div class="fav-footer">
                    <div class="fav-price">~220 $<small> / couvert</small></div>
                    <button class="btn-add"><i class="fas fa-plus"></i> R&eacute;server</button>
                </div>
            </div>
        </div>

        {{-- Card 4 --}}
        <div class="fav-card">
            <div class="fav-img">
                <img src="https://images.unsplash.com/photo-1467269204594-9661b134dd2b?w=600&q=80" alt="Gasp&eacute;sie">
                <span class="fav-cat cat-dest">Destination</span>
                <div class="fav-heart"><i class="fas fa-heart"></i></div>
                <div class="fav-rating"><i class="fas fa-star"></i><span>4.9 (2 104 avis)</span></div>
            </div>
            <div class="fav-body">
                <div class="fav-region">Gasp&eacute;sie, Qu&eacute;bec</div>
                <div class="fav-name">Circuit Gasp&eacute;sie &mdash; 10 Jours</div>
                <div class="fav-desc">De Sainte-Anne-des-Monts &agrave; Rocher-Perc&eacute;, un voyage inoubliable entre mer, montagne et villages authentiques.</div>
                <div class="fav-footer">
                    <div class="fav-price">D&egrave;s 2 490 $<small> / pers.</small></div>
                    <button class="btn-add"><i class="fas fa-plus"></i> Ajouter au panier</button>
                </div>
            </div>
        </div>

        {{-- Card 5 --}}
        <div class="fav-card">
            <div class="fav-img">
                <img src="https://images.unsplash.com/photo-1445019980597-93fa8acb246c?w=600&q=80" alt="H&ocirc;tel">
                <span class="fav-cat cat-heb">H&eacute;bergement</span>
                <div class="fav-heart"><i class="fas fa-heart"></i></div>
                <div class="fav-rating"><i class="fas fa-star"></i><span>4.8 (688 avis)</span></div>
            </div>
            <div class="fav-body">
                <div class="fav-region">Qu&eacute;bec City</div>
                <div class="fav-name">Fairmont Le Ch&acirc;teau Frontenac</div>
                <div class="fav-desc">L&apos;h&ocirc;tel le plus photographi&eacute; au monde. Situ&eacute; au c&oelig;ur du Vieux-Qu&eacute;bec avec vue panoramique sur le fleuve.</div>
                <div class="fav-footer">
                    <div class="fav-price">D&egrave;s 389 $<small> / nuit</small></div>
                    <button class="btn-add"><i class="fas fa-plus"></i> R&eacute;server</button>
                </div>
            </div>
        </div>

        {{-- Card 6 --}}
        <div class="fav-card">
            <div class="fav-img">
                <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=600&q=80" alt="Kayak">
                <span class="fav-cat cat-act">Activit&eacute;</span>
                <div class="fav-heart"><i class="fas fa-heart"></i></div>
                <div class="fav-rating"><i class="fas fa-star"></i><span>4.9 (341 avis)</span></div>
            </div>
            <div class="fav-body">
                <div class="fav-region">Saguenay, Qu&eacute;bec</div>
                <div class="fav-name">Kayak de mer &amp; Observation baleines</div>
                <div class="fav-desc">Pagayez au c&oelig;ur du fjord du Saguenay &agrave; la rencontre des b&eacute;lugas et rorquals. Exp&eacute;rience guid&eacute;e toute la journ&eacute;e.</div>
                <div class="fav-footer">
                    <div class="fav-price">D&egrave;s 149 $<small> / pers.</small></div>
                    <button class="btn-add"><i class="fas fa-plus"></i> Ajouter au panier</button>
                </div>
            </div>
        </div>

    </div>

    {{-- Share Banner --}}
    <div class="share-banner">
        <div class="share-info">
            <h3><i class="fas fa-share-alt" style="color:#d4af37;margin-right:6px"></i> Partagez votre liste</h3>
            <p>Partagez vos destinations r&ecirc;v&eacute;es avec vos amis ou votre famille pour planifier votre prochain voyage ensemble.</p>
        </div>
        <div class="share-btns">
            <a href="#" class="sbtn sbtn-copy"><i class="fas fa-link"></i> Copier le lien</a>
            <a href="#" class="sbtn sbtn-share"><i class="fas fa-share"></i> Partager</a>
        </div>
    </div>
</div>

@include('home-v2.components.Footer')

<script src="{{ asset('js/home-v2/navigation.js') }}"></script>
<script src="{{ asset('js/home-v2/menu-api-service.js') }}"></script>
<script src="{{ asset('js/home-v2/mega-menu-service.js') }}"></script>
<script src="{{ asset('js/home-v2/vertical-menu-dynamic.js') }}"></script>
<script src="{{ asset('js/home-v2/vertical-menu.js') }}"></script>
<script src="{{ asset('js/home-v2/vertical-destinations-mega.js') }}"></script>
<script src="{{ asset('js/home-v2/mega-menu.js') }}"></script>
<script src="{{ asset('js/home-v2/destinations-mega-menu.js') }}"></script>
<script src="{{ asset('js/home-v2/search-bar.js') }}"></script>
</body>
</html>
