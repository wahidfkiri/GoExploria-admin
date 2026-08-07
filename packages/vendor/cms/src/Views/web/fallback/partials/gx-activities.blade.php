{{-- ═══════════════════════════════════════════════════════════════════════
     Activités proposées par l'établissement.

     Rattachées depuis l'onglet « Activités » du tableau de bord CMS (table de
     liaison `activity_etablissement`). Chaque carte pointe vers la page
     publique de l'activité, servie par le paquet « activities » sous
     /activity/{slug}.

     Deux conditions pour qu'une activité paraisse ici : elle doit être mise en
     avant sur CE site (is_active sur la liaison) ET active dans le catalogue
     commun — c'est ce que fait le scope activeActivities().

     Nécessite $etablissement. À inclure une fois (@once).
     ═══════════════════════════════════════════════════════════════════════ --}}
@isset($etablissement)
@php
    try {
        $gxActivities = $etablissement->activeActivities()->limit(24)->get();
    } catch (\Throwable $e) {
        // Table de liaison absente (migration non jouée) : la section
        // disparaît, le reste de la page continue de s'afficher.
        $gxActivities = collect();
    }

    // Résout l'URL d'un visuel : absolu tel quel, sinon /storage/…
    $gxActImg = function ($chemin) {
        $chemin = trim((string) $chemin);
        if ($chemin === '') return '';
        if (\Illuminate\Support\Str::startsWith($chemin, ['http://', 'https://', '//'])) return $chemin;
        return asset('storage/' . ltrim($chemin, '/'));
    };
@endphp

@if($gxActivities->isNotEmpty())
@once
<style>
    .gxact-wrap{padding:72px 24px;background:#f8fafc;}
    .gxact-head{max-width:760px;margin:0 auto 40px;text-align:center;}
    .gxact-eyebrow{display:inline-flex;align-items:center;gap:8px;background:#e0f2fe;color:#0369a1;
        padding:6px 16px;border-radius:999px;font-size:.72rem;font-weight:800;letter-spacing:.08em;
        text-transform:uppercase;margin-bottom:14px;}
    .gxact-title{font-size:clamp(1.6rem,3.4vw,2.3rem);font-weight:800;color:#0f172a;margin:0 0 12px;}
    .gxact-lead{color:#64748b;font-size:.98rem;margin:0;}
    .gxact-grid{max-width:1200px;margin:0 auto;display:grid;
        grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:22px;}
    .gxact-card{display:flex;flex-direction:column;background:#fff;border:1px solid #e2e8f0;
        border-radius:16px;overflow:hidden;text-decoration:none;color:inherit;
        transition:transform .22s ease,box-shadow .22s ease,border-color .22s ease;}
    .gxact-card:hover{transform:translateY(-4px);box-shadow:0 18px 40px rgba(15,23,42,.12);
        border-color:transparent;}
    .gxact-vis{height:150px;background:#eef2f7;display:flex;align-items:center;justify-content:center;
        color:#94a3b8;font-size:2rem;overflow:hidden;}
    .gxact-vis img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .5s ease;}
    .gxact-card:hover .gxact-vis img{transform:scale(1.05);}
    .gxact-body{padding:16px 18px 18px;display:flex;flex-direction:column;gap:6px;flex:1;}
    .gxact-cat{display:inline-block;background:#eff6ff;color:#1d4ed8;border-radius:999px;
        font-size:.66rem;font-weight:800;padding:3px 9px;align-self:flex-start;}
    .gxact-nom{font-size:1rem;font-weight:700;color:#0f172a;margin:0;}
    .gxact-lien{margin-top:auto;padding-top:10px;font-size:.82rem;font-weight:700;color:#0284c7;
        display:inline-flex;align-items:center;gap:6px;}
    @media (max-width:600px){
        .gxact-wrap{padding:52px 16px;}
        .gxact-grid{grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:14px;}
        .gxact-vis{height:110px;}
    }
</style>
@endonce

<section class="gxact-wrap" id="nos-activites">
    <div class="gxact-head">
        <div class="gxact-eyebrow"><i class="fa-solid fa-person-hiking"></i> Nos activités</div>
        <h2 class="gxact-title">Ce que nous proposons</h2>
        <p class="gxact-lead">Découvrez chaque activité en détail sur sa page dédiée.</p>
    </div>

    <div class="gxact-grid">
        @foreach($gxActivities as $gxAct)
            @php
                $gxActUrl = filled($gxAct->slug) ? url('/activity/' . $gxAct->slug) : null;
                $gxActSrc = $gxActImg($gxAct->image ?? '');
            @endphp

            {{-- Une activité sans slug n'a pas de page publique : on la rend en
                 <div> plutôt qu'en lien mort. --}}
            <{{ $gxActUrl ? 'a' : 'div' }} class="gxact-card"
                @if($gxActUrl) href="{{ $gxActUrl }}" @endif>
                <div class="gxact-vis">
                    @if($gxActSrc)
                        <img src="{{ $gxActSrc }}" alt="{{ $gxAct->name }}" loading="lazy">
                    @else
                        <i class="fa-solid fa-person-hiking"></i>
                    @endif
                </div>
                <div class="gxact-body">
                    @if($gxAct->categoryRelation?->name)
                        <span class="gxact-cat">{{ $gxAct->categoryRelation->name }}</span>
                    @endif
                    <h3 class="gxact-nom">{{ $gxAct->name }}</h3>
                    @if($gxActUrl)
                        <span class="gxact-lien">
                            Découvrir <i class="fa-solid fa-arrow-right"></i>
                        </span>
                    @endif
                </div>
            </{{ $gxActUrl ? 'a' : 'div' }}>
        @endforeach
    </div>
</section>
@endif
@endisset
