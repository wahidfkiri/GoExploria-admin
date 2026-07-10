@php
use App\Models\Category;
use App\Models\CategorieType;

$tr = static function (string $text): string {
    $locale = app()->getLocale();
    if ($locale === 'fr') {
        return $text;
    }

    static $maps = [];
    if (! array_key_exists($locale, $maps)) {
        $path = lang_path($locale . DIRECTORY_SEPARATOR . 'home-v2-components-map.php');
        $maps[$locale] = is_file($path) ? (require $path) : [];
    }

    return $maps[$locale][$text] ?? $text;
};

// Chargement des catégories + génération des fils d'ariane : déplacés dans le
// bloc Cache::remember plus bas (voir $catMegaData) afin d'éviter les requêtes
// profondes et la reconstruction des liens à chaque affichage. La sortie rendue
// reste strictement identique.

$buildDestBreadcrumb = function ($activity) {
    $slugify = fn($e) => \Illuminate\Support\Str::slug($e->name);
    $paths = [];
    foreach ($activity->cities as $city) {
        $chain = [];
        if ($ct = $city->region?->province?->country?->continent)
            $chain[] = '<a href="' . route('travel-destination.show', ['type' => 'continent', 'slug' => $ct->slug ?? $ct->id, 'slug2' => $slugify($ct)]) . '" class="dest-link">' . e($ct->name) . '</a>';
        if ($c = $city->region?->province?->country)
            $chain[] = '<a href="' . route('travel-destination.show', ['type' => 'country', 'slug' => $c->slug ?? $c->id, 'slug2' => $slugify($c)]) . '" class="dest-link">' . e($c->name) . '</a>';
        if ($p = $city->region?->province)
            $chain[] = '<a href="' . route('travel-destination.show', ['type' => 'province', 'slug' => $p->slug ?? $p->id, 'slug2' => $slugify($p)]) . '" class="dest-link">' . e($p->name) . '</a>';
        if ($r = $city->region)
            $chain[] = '<a href="' . route('travel-destination.show', ['type' => 'region', 'slug' => $r->slug ?? $r->id, 'slug2' => $slugify($r)]) . '" class="dest-link">' . e($r->name) . '</a>';
        $chain[] = '<a href="' . route('travel-destination.show', ['type' => 'city', 'slug' => $city->slug ?? $city->id, 'slug2' => $slugify($city)]) . '" class="dest-link">' . e($city->name) . '</a>';
        $paths[] = implode(' <span class="dest-arrow">&gt;</span> ', $chain);
    }
    foreach ($activity->regions as $region) {
        $chain = [];
        if ($ct = $region->province?->country?->continent)
            $chain[] = '<a href="' . route('travel-destination.show', ['type' => 'continent', 'slug' => $ct->slug ?? $ct->id, 'slug2' => $slugify($ct)]) . '" class="dest-link">' . e($ct->name) . '</a>';
        if ($c = $region->province?->country)
            $chain[] = '<a href="' . route('travel-destination.show', ['type' => 'country', 'slug' => $c->slug ?? $c->id, 'slug2' => $slugify($c)]) . '" class="dest-link">' . e($c->name) . '</a>';
        if ($p = $region->province)
            $chain[] = '<a href="' . route('travel-destination.show', ['type' => 'province', 'slug' => $p->slug ?? $p->id, 'slug2' => $slugify($p)]) . '" class="dest-link">' . e($p->name) . '</a>';
        $chain[] = '<a href="' . route('travel-destination.show', ['type' => 'region', 'slug' => $region->slug ?? $region->id, 'slug2' => $slugify($region)]) . '" class="dest-link">' . e($region->name) . '</a>';
        $path = implode(' <span class="dest-arrow">&gt;</span> ', $chain);
        if (!in_array($path, $paths)) $paths[] = $path;
    }
    foreach ($activity->provinces as $province) {
        $chain = [];
        if ($ct = $province->country?->continent)
            $chain[] = '<a href="' . route('travel-destination.show', ['type' => 'continent', 'slug' => $ct->slug ?? $ct->id, 'slug2' => $slugify($ct)]) . '" class="dest-link">' . e($ct->name) . '</a>';
        if ($c = $province->country)
            $chain[] = '<a href="' . route('travel-destination.show', ['type' => 'country', 'slug' => $c->slug ?? $c->id, 'slug2' => $slugify($c)]) . '" class="dest-link">' . e($c->name) . '</a>';
        $chain[] = '<a href="' . route('travel-destination.show', ['type' => 'province', 'slug' => $province->slug ?? $province->id, 'slug2' => $slugify($province)]) . '" class="dest-link">' . e($province->name) . '</a>';
        $path = implode(' <span class="dest-arrow">&gt;</span> ', $chain);
        if (!in_array($path, $paths)) $paths[] = $path;
    }
    foreach ($activity->countries as $country) {
        $chain = [];
        if ($ct = $country->continent)
            $chain[] = '<a href="' . route('travel-destination.show', ['type' => 'continent', 'slug' => $ct->slug ?? $ct->id, 'slug2' => $slugify($ct)]) . '" class="dest-link">' . e($ct->name) . '</a>';
        $chain[] = '<a href="' . route('travel-destination.show', ['type' => 'country', 'slug' => $country->slug ?? $country->id, 'slug2' => $slugify($country)]) . '" class="dest-link">' . e($country->name) . '</a>';
        $path = implode(' <span class="dest-arrow">&gt;</span> ', $chain);
        if (!in_array($path, $paths)) $paths[] = $path;
    }
    foreach ($activity->continents as $continent) {
        $path = '<a href="' . route('travel-destination.show', ['type' => 'continent', 'slug' => $continent->slug ?? $continent->id, 'slug2' => $slugify($continent)]) . '" class="dest-link">' . e($continent->name) . '</a>';
        if (!in_array($path, $paths)) $paths[] = $path;
    }
    return $paths;
};

// ── Cache des données du méga-menu ────────────────────────────────────────────
// Le chargement profond (activités → villes/régions/provinces/pays/continents)
// et la génération des fils d'ariane (nombreux appels route() imbriqués) sont
// exécutés une seule fois puis mis en cache. La sortie HTML reste identique.
// Purge manuelle : php artisan cache:clear
$locale = app()->getLocale();
$catMegaCacheKey = 'home_v2_categories_mega_menu_' . $locale;

$catMegaLoader = function () use ($buildDestBreadcrumb) {
        $activitiesQuery = function ($q) {
            $q->where('is_active', true)->orderBy('name')
              ->with([
                  'continents',
                  'countries.continent',
                  'provinces.country.continent',
                  'regions.province.country.continent',
                  'cities.region.province.country.continent',
              ]);
        };

        $tourismeType = CategorieType::where('name', 'like', '%tourisme%')->orWhere('name', 'like', '%Tourisme%')->first();
        $businessType = CategorieType::where('name', 'like', '%business%')->orWhere('name', 'like', '%Business%')->first();

        // On ne conserve que les catégories qui possèdent au moins une activité.
        $onlyWithActivities = function ($cat) { return $cat->activities->isNotEmpty(); };

        $tourismeCats = ($tourismeType
            ? $tourismeType->categories()->with(['activities' => $activitiesQuery])->where('is_active', true)->orderBy('name')->get()
            : collect())->filter($onlyWithActivities)->values();

        $businessCats = ($businessType
            ? $businessType->categories()->with(['activities' => $activitiesQuery])->where('is_active', true)->orderBy('name')->get()
            : collect())->filter($onlyWithActivities)->values();

        // Pré-calcul des fils d'ariane (partie la plus coûteuse).
        $breadcrumbs = [];
        foreach ([$tourismeCats, $businessCats] as $cats) {
            foreach ($cats as $cat) {
                foreach ($cat->activities as $act) {
                    if (! array_key_exists($act->id, $breadcrumbs)) {
                        $breadcrumbs[$act->id] = $buildDestBreadcrumb($act);
                    }
                }
            }
        }

        // Allègement du cache : les relations « destinations » ne servent plus
        // une fois les fils d'ariane générés.
        foreach ([$tourismeCats, $businessCats] as $cats) {
            foreach ($cats as $cat) {
                foreach ($cat->activities as $act) {
                    $act->unsetRelation('continents');
                    $act->unsetRelation('countries');
                    $act->unsetRelation('provinces');
                    $act->unsetRelation('regions');
                    $act->unsetRelation('cities');
                }
            }
        }

        return compact('tourismeCats', 'businessCats', 'breadcrumbs');
};

// Lecture/écriture du cache tolérante aux pannes : si le cache store du serveur
// est indisponible (table `cache` absente, permissions fichier, Redis down…),
// on calcule directement au lieu de casser toute la page (page blanche en prod).
$catMegaData = null;
try {
    $catMegaData = \Illuminate\Support\Facades\Cache::get($catMegaCacheKey);
} catch (\Throwable $e) {
    $catMegaData = null;
}
if (! is_array($catMegaData)) {
    $catMegaData = $catMegaLoader();
    try {
        \Illuminate\Support\Facades\Cache::put($catMegaCacheKey, $catMegaData, 600);
    } catch (\Throwable $e) {
        // Cache indisponible : on ignore, la page reste fonctionnelle.
    }
}

$tourismeCats       = $catMegaData['tourismeCats'];
$businessCats       = $catMegaData['businessCats'];
$catMegaBreadcrumbs = $catMegaData['breadcrumbs'];

// Le template appelle toujours $buildDestBreadcrumb($act) : on renvoie désormais
// le fil d'ariane pré-calculé → sortie strictement identique, sans requête.
$buildDestBreadcrumb = function ($activity) use ($catMegaBreadcrumbs) {
    return $catMegaBreadcrumbs[$activity->id] ?? [];
};
@endphp

{{-- ── PANEL TOURISME ── --}}
<div class="cat-mega-panel" id="catMegaPanelTourisme" role="dialog" aria-label="{{ $tr('Catégories Tourisme') }}">
    <div class="cat-mega-left">
        <div class="cat-mega-header">
            <div class="cat-mega-header-icon"><i class="fas fa-map-marked-alt"></i></div>
            <span class="cat-mega-header-title">{{ $tr('Activités Tourisme') }}</span>
        </div>
        @forelse($tourismeCats as $index => $cat)
            <a href="{{ route('category.show', $cat->slug ?? $cat->id) }}"
               class="cat-mega-cat-item {{ $index === 0 ? 'active' : '' }}"
               data-cat-id="t{{ $cat->id }}"
               data-cat-href="{{ route('category.show', $cat->slug ?? $cat->id) }}"
               onclick="catMegaSelect(event, this, 'tourisme')">
                <span>{{ $cat->name }}</span>
                @if($cat->activities->isNotEmpty())
                    <span class="cat-mega-cat-arrow"><i class="fas fa-chevron-right"></i></span>
                @endif
            </a>
        @empty
            <div class="cat-mega-empty">{{ $tr('Aucune catégorie active') }}</div>
        @endforelse
    </div>
    <div class="cat-mega-right">
        <div class="cat-mega-right-inner" id="catMegaRightInnerTourisme">
            @forelse($tourismeCats as $index => $cat)
                <ul class="cat-mega-activities {{ $index === 0 ? 'visible' : '' }}"
                    id="cat-acts-t{{ $cat->id }}">
                    @forelse($cat->activities as $act)
                        @php $destPaths = $buildDestBreadcrumb($act); @endphp
                        <li>
                            <a href="{{ route('activity.show', $act->slug ?? $act->id) }}" class="cat-mega-act-link">
                                @if(!empty($destPaths))
                                    <span class="cat-mega-dest-breadcrumb">
                                        @foreach($destPaths as $i => $path)
                                            <span class="dest-crumb">{!! $path !!}</span>@if($i < count($destPaths) - 1)<span class="dest-sep"> • </span>@endif
                                        @endforeach
                                    </span>
                                @endif
                                <span class="cat-mega-act-name">{{ $act->name }}</span>
                            </a>
                        </li>
                    @empty
                        <li class="cat-mega-empty">{{ $tr('Aucune activité') }}</li>
                    @endforelse
                </ul>
            @empty
            @endforelse
        </div>
        @if($tourismeCats->isNotEmpty())
        <div class="cat-mega-footer">
            <a href="{{ route('category.show', $tourismeCats->first()->slug ?? $tourismeCats->first()->id) }}"
               class="cat-mega-view-all" id="catMegaViewAllTourisme">
                {{ $tr('Voir toutes les activités') }} <i class="fas fa-arrow-right" style="font-size:9px;margin-left:2px"></i>
            </a>
            <a href="{{ route('categories.index') }}" class="cat-mega-view-all-cats">{{ $tr('Toutes les catégories') }}</a>
        </div>
        @endif
    </div>
</div>

{{-- ── PANEL BUSINESS ── --}}
<div class="cat-mega-panel" id="catMegaPanelBusiness" role="dialog" aria-label="{{ $tr('Catégories Business') }}">
    <div class="cat-mega-left">
        <div class="cat-mega-header">
            <div class="cat-mega-header-icon"><i class="fas fa-briefcase"></i></div>
            <span class="cat-mega-header-title">{{ $tr('Activités Business') }}</span>
        </div>
        @forelse($businessCats as $index => $cat)
            <a href="{{ route('category.show', $cat->slug ?? $cat->id) }}"
               class="cat-mega-cat-item {{ $index === 0 ? 'active' : '' }}"
               data-cat-id="b{{ $cat->id }}"
               data-cat-href="{{ route('category.show', $cat->slug ?? $cat->id) }}"
               onclick="catMegaSelect(event, this, 'business')">
                <span>{{ $cat->name }}</span>
                @if($cat->activities->isNotEmpty())
                    <span class="cat-mega-cat-arrow"><i class="fas fa-chevron-right"></i></span>
                @endif
            </a>
        @empty
            <div class="cat-mega-empty">{{ $tr('Aucune catégorie active') }}</div>
        @endforelse
    </div>
    <div class="cat-mega-right">
        <div class="cat-mega-right-inner" id="catMegaRightInnerBusiness">
            @forelse($businessCats as $index => $cat)
                <ul class="cat-mega-activities {{ $index === 0 ? 'visible' : '' }}"
                    id="cat-acts-b{{ $cat->id }}">
                    @forelse($cat->activities as $act)
                        @php $destPaths = $buildDestBreadcrumb($act); @endphp
                        <li>
                            <a href="{{ route('activity.show', $act->slug ?? $act->id) }}" class="cat-mega-act-link">
                                @if(!empty($destPaths))
                                    <span class="cat-mega-dest-breadcrumb">
                                        @foreach($destPaths as $i => $path)
                                            <span class="dest-crumb">{!! $path !!}</span>@if($i < count($destPaths) - 1)<span class="dest-sep"> • </span>@endif
                                        @endforeach
                                    </span>
                                @endif
                                <span class="cat-mega-act-name">{{ $act->name }}</span>
                            </a>
                        </li>
                    @empty
                        <li class="cat-mega-empty">{{ $tr('Aucune activité') }}</li>
                    @endforelse
                </ul>
            @empty
            @endforelse
        </div>
        @if($businessCats->isNotEmpty())
        <div class="cat-mega-footer">
            <a href="{{ route('category.show', $businessCats->first()->slug ?? $businessCats->first()->id) }}"
               class="cat-mega-view-all" id="catMegaViewAllBusiness">
                {{ $tr('Voir toutes les activités') }} <i class="fas fa-arrow-right" style="font-size:9px;margin-left:2px"></i>
            </a>
            <a href="{{ route('categories.index') }}" class="cat-mega-view-all-cats">{{ $tr('Toutes les catégories') }}</a>
        </div>
        @endif
    </div>
</div>

<style>
.cat-mega-activities { display: none; margin: 0; padding: 0; list-style: none; }
.cat-mega-activities.visible { display: block; }
.cat-mega-activities li { list-style: none; }
.cat-mega-dest-breadcrumb { display: block; margin-bottom: 2px; }
.cat-mega-act-link { display: flex; flex-direction: column; gap: 1px; padding: 4px 0; text-decoration: none; }
.cat-mega-act-name { font-weight: 600; font-size: 13px; }
.cat-mega-dest-breadcrumb { font-size: 11px; font-weight: 700; line-height: 1.4; color: #374151; }
.dest-link { color: #4f46e5; text-decoration: none; }
.dest-link:hover { text-decoration: underline; }
.dest-arrow { color: #9ca3af; margin: 0 1px; font-weight: 400; }
.dest-crumb { white-space: nowrap; }
.dest-sep { color: #9ca3af; margin: 0 3px; font-weight: 400; font-size: 10px; }

/* Icône chevron : pointe vers le bas quand la catégorie est ouverte (toggle) */
.cat-mega-cat-arrow { transition: transform 0.2s ease, color 0.2s ease; }
.cat-mega-cat-item.active .cat-mega-cat-arrow { transform: rotate(90deg); color: #1a72cc; opacity: 1; }
</style>

<script>
/* ── Coordination globale : un seul mega menu ouvert à la fois ── */
window.goMegaClosers = window.goMegaClosers || [];
window.goCloseOtherMega = window.goCloseOtherMega || function (exceptEl) {
    document.querySelectorAll('.cat-mega-panel.open').forEach(function (p) {
        if (p !== exceptEl) p.classList.remove('open');
    });
    var info = document.getElementById('infoMegaMenuV2');
    if (info && info !== exceptEl) {
        info.classList.remove('active');
        var it = document.getElementById('infoTrigger');
        if (it) it.classList.remove('active');
    }
    var dest = document.getElementById('destinationsMegaMenu');
    if (dest && dest !== exceptEl && window.destinationsMegaMenu && typeof window.destinationsMegaMenu.hide === 'function') {
        window.destinationsMegaMenu.hide();
    }
    window.goMegaClosers.forEach(function (fn) { try { fn(exceptEl); } catch (e) {} });
};

/* Fonction partagée de positionnement et gestion des panels */
window.initCatMegaPanel = function initCatMegaPanel(triggerId, panelId, viewAllId) {
    var panel   = document.getElementById(panelId);
    var trigger = document.getElementById(triggerId);
    if (!panel || !trigger) return;
    /* Évite un double-binding si le composant est inclus plusieurs fois (Hero + VerticalMenu) */
    if (trigger.dataset.catMegaBound === panelId) return;
    trigger.dataset.catMegaBound = panelId;

    function positionPanel() {
        if (window.innerWidth <= 768) return;
        var rect   = trigger.getBoundingClientRect();
        var viewW  = window.innerWidth;
        var viewH  = window.innerHeight;
        var panelW = panel ? (panel.offsetWidth || 680) : 680;
        var left   = rect.left + rect.width / 2 - panelW / 2;
        if (left + panelW > viewW - 12) left = viewW - panelW - 12;
        if (left < 12) left = 12;
        var spaceBelow = viewH - rect.bottom - 10;
        var spaceAbove = rect.top - 80;
        var panelH = panel.offsetHeight || 400;
        var top;
        if (spaceBelow >= Math.min(panelH, 260)) {
            top = rect.bottom + 10;
        } else if (spaceAbove >= Math.min(panelH, 260)) {
            top = rect.top - Math.min(panelH, spaceAbove) - 10;
        } else {
            top = 80;
        }
        panel.style.maxHeight = (viewH - top - 16) + 'px';
        panel.style.left = left + 'px';
        panel.style.top  = top  + 'px';
    }

    function openPanel() {
        /* Ferme tous les autres mega menus (un seul ouvert à la fois) */
        window.goCloseOtherMega(panel);
        positionPanel();
        panel.classList.add('open');
    }

    trigger.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        panel.classList.contains('open') ? panel.classList.remove('open') : openPanel();
    });

    document.addEventListener('click', function(e) {
        if (!panel.classList.contains('open')) return;
        if (!panel.contains(e.target) && !trigger.contains(e.target)) {
            panel.classList.remove('open');
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') panel.classList.remove('open');
    });

    window.addEventListener('resize', function() {
        if (panel.classList.contains('open')) positionPanel();
    });
};

/* Initialisation des deux panels */
initCatMegaPanel('catMegaTriggerTourisme', 'catMegaPanelTourisme', 'catMegaViewAllTourisme');
initCatMegaPanel('catMegaTriggerBusiness', 'catMegaPanelBusiness', 'catMegaViewAllBusiness');

/* Sélection d'une catégorie dans un panel donné */
function catMegaSelect(e, el, type) {
    if (el.closest('.vmenu-inline-panel')) return;
    e.preventDefault();
    e.stopPropagation();
    var panel = el.closest('.cat-mega-panel') || document.getElementById('catMegaPanel' + (type === 'tourisme' ? 'Tourisme' : 'Business'));
    if (!panel) return;

    var acts = panel.querySelector('#cat-acts-' + el.dataset.catId);
    /* État courant : la catégorie est-elle déjà ouverte ? */
    var isOpen = el.classList.contains('active') && acts && acts.classList.contains('visible');

    /* Réinitialise toutes les catégories du panel */
    panel.querySelectorAll('.cat-mega-cat-item').forEach(function(i) { i.classList.remove('active'); });
    panel.querySelectorAll('.cat-mega-activities').forEach(function(a) { a.classList.remove('visible'); });

    /* Toggle : un second clic sur la même catégorie referme sa liste */
    if (isOpen) return;

    el.classList.add('active');
    if (acts) acts.classList.add('visible');

    var viewAll = panel.querySelector('#catMegaViewAll' + (type === 'tourisme' ? 'Tourisme' : 'Business'));
    if (viewAll && el.dataset.catHref) viewAll.href = el.dataset.catHref;
}
</script>
