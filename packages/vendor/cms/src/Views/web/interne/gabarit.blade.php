{{--
  ═══════════════════════════════════════════════════════════════════════════
  GABARIT INTERNE — le site des établissements importés.

  UN SEUL FICHIER pour tous ces sites. Rien n'est recopié : ni dans
  `etablissement_templates`, ni dans `cms_pages`, ni au dépôt de fichiers.
  Chaque section lit les données de l'établissement au moment du rendu
  ([[GabaritInterne]]), et DISPARAÎT quand il n'y a rien à montrer.

  ⚠ CE SITE N'EST PAS MODIFIABLE DANS L'ÉDITEUR, et c'est voulu : il n'existe
  aucun contenu à éditer. Le jour où l'établissement devient client, on lui
  installe un vrai gabarit — la colonne `site_interne` repasse à 0 et le site
  bascule sur sa copie, sans rien perdre.

  ⚠ RIEN D'INVENTÉ. Un gabarit de démonstration affirme « 12 000 clients »,
  « 4,9/5 », « chiens acceptés », « annulation sans frais ». Appliquées
  automatiquement à des milliers d'entreprises réelles reprises d'annuaires,
  ces phrases deviennent autant de déclarations fausses à leur sujet. Ici,
  tout ce qui concerne l'établissement vient de ses données ; tout le reste
  est présenté comme le discours de GoExploria, et signé comme tel.

  CE QUE LE SITE AJOUTE LUI-MÊME (buildResponse) : métadonnées SEO, tiroir du
  panier, fiche produit, outils de boutique, infolettre, formulaire de demande
  d'un bien et son calendrier, pont du formulaire de contact, carte Maps
  Vidéos, Swiper, pont d'embarquement. Il suffit que les repères soient là —
  `data-gx-contact`, `data-im-detail`, `data-gx-map`, `data-cms-cart-add` — et
  que le document ait un `</body>`.
  ═══════════════════════════════════════════════════════════════════════════
--}}
@php
    use Vendor\Cms\Support\GabaritInterne;
    use Vendor\Cms\Support\ProductPresenter;

    $gxiNom = trim((string) (get_site_name($etablissement->id) ?: $etablissement->name));
    $gxiSlogan = trim((string) ($etablissement->getSetting('slogan', null, 'general') ?? ''));
    $gxiDescription = trim((string) ($etablissement->description
        ?? $etablissement->getSetting('site_description', null, 'general')
        ?? ''));
    $gxiTelephone = trim((string) ($etablissement->phone ?? $etablissement->telephone ?? ''));
    $gxiEmail = trim((string) ($etablissement->email ?? ''));
    $gxiSite = trim((string) ($etablissement->website ?? ''));
    $gxiAdresse = trim((string) ($etablissement->adresse ?? $etablissement->address ?? ''));
    $gxiVille = trim((string) ($etablissement->ville ?? $etablissement->villeRelation->name ?? ''));
    $gxiCodePostal = trim((string) ($etablissement->zip_code ?? ''));
    $gxiAdresseComplete = trim(implode(', ', array_filter([$gxiAdresse, trim($gxiVille . ' ' . $gxiCodePostal)])));
    $gxiLogo = trim((string) ($brandLogoUrl ?? ''));

    // Médias : la galerie, et de quoi nourrir le héros quand aucun diaporama
    // n'a été réglé.
    $gxiMedias = collect($galleryMedia ?? [])->filter(fn ($m) => (bool) (data_get($m, 'url') ?: data_get($m, 'image_url') ?: data_get($m, 'thumbnail_url')))->values();
    $gxiImage = function ($m) {
        return data_get($m, 'url') ?: data_get($m, 'image_url') ?: data_get($m, 'thumbnail_url');
    };
    $gxiTitreMedia = function ($m) {
        return trim((string) (data_get($m, 'title') ?: data_get($m, 'name') ?: ''));
    };

    // ── HÉROS ────────────────────────────────────────────────────────────
    // Les diapositives réglées dans l'espace, sinon les premières photos, et
    // en tout dernier recours une diapositive de titre. Jamais de vidéo de
    // démonstration : une vidéo d'ailleurs sur le site de quelqu'un, c'est un
    // mensonge sur image.
    $gxiDiapos = collect($sliders ?? [])->map(function ($s) {
        $video = trim((string) (data_get($s, 'video_embed_url') ?: data_get($s, 'video_url') ?: ''));

        return [
            'titre' => trim((string) data_get($s, 'name')),
            'texte' => trim((string) data_get($s, 'description')),
            'image' => data_get($s, 'image_url') ?: data_get($s, 'thumbnail_url'),
            'video' => data_get($s, 'type') === 'video' ? $video : '',
            'lien' => trim((string) data_get($s, 'button_url')),
            'bouton' => trim((string) data_get($s, 'button_text')),
        ];
    })->filter(fn ($d) => $d['image'] || $d['video'])->take(5)->values();

    if ($gxiDiapos->isEmpty() && $gxiMedias->isNotEmpty()) {
        $gxiDiapos = $gxiMedias->take(3)->map(fn ($m) => [
            'titre' => $gxiTitreMedia($m) ?: $gxiNom,
            'texte' => '',
            'image' => $gxiImage($m),
            'video' => '',
            'lien' => '',
            'bouton' => '',
        ])->values();
    }

    // ── VIDÉOS ───────────────────────────────────────────────────────────
    // ⚠ `play_url` / `raw_url` : ce sont les clés que produit la chaîne vidéo
    // du site (getLandingVideoChannelItems). Les noms génériques — `url`,
    // `video_url` — n'existent pas, et la section serait restée vide sans un
    // mot d'erreur. Les autres noms sont là pour les sources d'appoint.
    $gxiVideos = collect($videoChannelVideos ?? [])->map(function ($v) {
        $source = trim((string) (
            data_get($v, 'play_url') ?: data_get($v, 'raw_url')
            ?: data_get($v, 'video_url') ?: data_get($v, 'url') ?: data_get($v, 'embed_url') ?: ''
        ));

        return [
            'titre' => trim((string) (data_get($v, 'title') ?: data_get($v, 'name') ?: '')),
            'texte' => trim((string) data_get($v, 'description')),
            'lecteur' => GabaritInterne::lecteurVideo($source),
            'page' => GabaritInterne::pageVideo($source),
            'vignette' => data_get($v, 'thumbnail') ?: data_get($v, 'thumbnail_url') ?: data_get($v, 'poster'),
        ];
    })->filter(fn ($v) => $v['lecteur'] !== '')->take(6)->values();

    // ── MODULES ──────────────────────────────────────────────────────────
    $gxiRayons = collect($rayons ?? []);
    $gxiProduits = collect($produits ?? []);
    $gxiActivites = collect($activitesModule ?? []);
    $gxiArticles = collect($articles ?? []);
    $gxiProximite = collect($proximite ?? []);
    $gxiHebergements = collect($hebergements ?? []);
    $gxiForfaits = collect($forfaits ?? []);
    $gxiVehicules = collect($vehicules ?? []);
    $gxiHoraires = collect($workingHours ?? [])->filter(fn ($h) => trim((string) data_get($h, 'hours')) !== '')->values();
    $gxiReseaux = collect($socialLinks ?? [])->filter(fn ($u) => trim((string) $u) !== '');
    $gxiPlans = collect($plans ?? []);

    // ── MENU ─────────────────────────────────────────────────────────────
    // Une entrée par section REMPLIE. Un menu qui mène à une section vide est
    // pire que pas de menu du tout.
    $gxiMenu = collect([
        ['#gxi-apropos', 'À propos', $gxiDescription !== ''],
        ['#gxi-boutique', 'Boutique', $gxiProduits->isNotEmpty() || $gxiRayons->isNotEmpty()],
        ['#gxi-hebergements', 'Hébergements', $gxiHebergements->isNotEmpty()],
        ['#gxi-forfaits', 'Forfaits', $gxiForfaits->isNotEmpty()],
        ['#gxi-vehicules', 'Location', $gxiVehicules->isNotEmpty()],
        ['#gxi-activites', 'Activités', $gxiActivites->isNotEmpty()],
        ['#gxi-videos', 'Vidéos', $gxiVideos->isNotEmpty()],
        ['#gxi-galerie', 'Galerie', $gxiMedias->isNotEmpty()],
        ['#gxi-blog', 'Actualités', $gxiArticles->isNotEmpty()],
        ['#gxi-carte', 'Nous situer', true],
        ['#gxi-contact', 'Contact', true],
    ])->filter(fn ($e) => $e[2])->values();

    // ── UNIVERS ──────────────────────────────────────────────────────────
    $gxiUnivers = collect([
        ['#gxi-boutique', 'fa-bag-shopping', 'Boutique', $gxiProduits->count() . ' produit' . ($gxiProduits->count() > 1 ? 's' : ''), $gxiProduits->isNotEmpty()],
        ['#gxi-hebergements', 'fa-bed', 'Hébergements', $gxiHebergements->count() . ' à découvrir', $gxiHebergements->isNotEmpty()],
        ['#gxi-forfaits', 'fa-suitcase-rolling', 'Forfaits', $gxiForfaits->count() . ' offre' . ($gxiForfaits->count() > 1 ? 's' : ''), $gxiForfaits->isNotEmpty()],
        ['#gxi-vehicules', 'fa-car', 'Location', $gxiVehicules->count() . ' véhicule' . ($gxiVehicules->count() > 1 ? 's' : ''), $gxiVehicules->isNotEmpty()],
        ['#gxi-activites', 'fa-person-hiking', 'Activités', $gxiActivites->count() . ' proposée' . ($gxiActivites->count() > 1 ? 's' : ''), $gxiActivites->isNotEmpty()],
        ['#gxi-videos', 'fa-film', 'Vidéos', $gxiVideos->count() . ' vidéo' . ($gxiVideos->count() > 1 ? 's' : ''), $gxiVideos->isNotEmpty()],
        ['#gxi-galerie', 'fa-images', 'Galerie', $gxiMedias->count() . ' photo' . ($gxiMedias->count() > 1 ? 's' : ''), $gxiMedias->isNotEmpty()],
        ['#gxi-blog', 'fa-rss', 'Actualités', $gxiArticles->count() . ' article' . ($gxiArticles->count() > 1 ? 's' : ''), $gxiArticles->isNotEmpty()],
    ])->filter(fn ($u) => $u[4])->values();

    // ── CHIFFRES ─────────────────────────────────────────────────────────
    // Comptés, jamais affirmés.
    $gxiChiffres = collect([
        [$gxiProduits->count(), 'produits en ligne'],
        [$gxiHebergements->count() + $gxiForfaits->count() + $gxiVehicules->count(), 'offres réservables'],
        [$gxiActivites->count(), 'activités'],
        [$gxiMedias->count() + $gxiVideos->count(), 'photos et vidéos'],
    ])->filter(fn ($c) => $c[0] > 0)->values();

    $gxiDevis = $devisUrl ?? url('/');
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() ?: 'fr' }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>{{ $gxiNom }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
/* ══════════════════════════════════════════════════════════════════════════
   Feuille du gabarit interne.

   ÉCRITE POUR LE MOBILE D'ABORD : les points de rupture ajoutent des colonnes,
   ils n'en retirent jamais. Un site d'annuaire se consulte au téléphone.

   Aucune largeur fixe, aucune hauteur en `vh` : le site est rendu DANS une
   iframe dimensionnée à la hauteur de son contenu, où `100vh` grandit sans
   fin à chaque mesure. Les hauteurs se donnent en `aspect-ratio` ou en `rem`.
   ══════════════════════════════════════════════════════════════════════════ */
.gxi-tpl{
  --gxi-encre:#0f1a33; --gxi-nuit:#0b1324; --gxi-nuit-2:#152244;
  --gxi-bleu:#2459e0; --gxi-bleu-clair:#3b82f6;
  --gxi-ambre:#f26b3a; --gxi-ambre-clair:#fb923c;
  --gxi-blanc:#fff; --gxi-sable:#f6f8fc; --gxi-bord:#e2e8f0;
  --gxi-gris:#64748b; --gxi-gris-clair:#94a3b8;
  --gxi-rayon:16px; --gxi-ombre:0 18px 40px rgba(15,23,42,.10);
  --gxi-sans:'Inter',system-ui,-apple-system,'Segoe UI',sans-serif;
  --gxi-titre:'Plus Jakarta Sans',var(--gxi-sans);
  --gxi-gouttiere:16px;
}
@media (min-width:768px){ .gxi-tpl{ --gxi-gouttiere:32px; } }

.gxi-tpl *,.gxi-tpl *::before,.gxi-tpl *::after{box-sizing:border-box}
html,body{margin:0;padding:0}
body{background:var(--gxi-blanc)}
.gxi-tpl{
  font-family:var(--gxi-sans); color:var(--gxi-encre); line-height:1.65;
  background:var(--gxi-blanc); overflow-x:hidden;
  -webkit-text-size-adjust:100%;
}
.gxi-tpl img,.gxi-tpl video,.gxi-tpl iframe{max-width:100%;display:block}
/* ⚠ Deux garde-fous contre le débordement horizontal, et ils ne sont pas
   décoratifs : le contenu vient d'annuaires, pas d'un rédacteur. Un nom
   d'établissement de quarante lettres sans espace, une adresse de site qui
   n'en finit pas — et la page entière se décale vers la droite sur
   téléphone, barre de défilement comprise.
     · `overflow-wrap` coupe le mot plutôt que la mise en page ;
     · `min-width:0` sur les enfants de grille : leur valeur par défaut
       (`auto`) les empêche de descendre sous la largeur de leur contenu,
       et c'est la cause la plus fréquente d'une grille qui déborde. */
.gxi-tpl p,.gxi-tpl h1,.gxi-tpl h2,.gxi-tpl h3,.gxi-tpl h4,
.gxi-tpl a,.gxi-tpl span,.gxi-tpl b,.gxi-tpl li{overflow-wrap:break-word}
.gxi-grille > *,.gxi-tuiles > *,.gxi-chiffres > *,.gxi-rayons > *,
.gxi-videos > *,.gxi-mosaique > *,.gxi-duo > *,.gxi-contact > *,
.gxi-pied-grille > *,.gxi-nav-in > *{min-width:0}
.gxi-tpl a{color:inherit;text-decoration:none}
.gxi-tpl h1,.gxi-tpl h2,.gxi-tpl h3,.gxi-tpl h4{font-family:var(--gxi-titre);line-height:1.15;margin:0;letter-spacing:-.4px}
.gxi-tpl p{margin:0}
.gxi-tpl ul{margin:0;padding:0;list-style:none}

/* Le fil de fer commun : une bande, une largeur de lecture, un en-tête. */
.gxi-sec{padding:clamp(48px,7vw,96px) var(--gxi-gouttiere)}
.gxi-sec--sable{background:var(--gxi-sable)}
.gxi-sec--nuit{background:var(--gxi-nuit);color:var(--gxi-blanc)}
.gxi-sec--nuit .gxi-lead{color:rgba(255,255,255,.80)}
.gxi-wrap{max-width:1240px;margin:0 auto}
.gxi-head{max-width:720px;margin:0 0 clamp(28px,4vw,48px)}
.gxi-head--centre{margin-left:auto;margin-right:auto;text-align:center}
.gxi-kicker{
  display:inline-flex;align-items:center;gap:8px;margin:0 0 12px;
  font-size:.74rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:var(--gxi-ambre);
}
.gxi-h2{font-size:clamp(1.6rem,4.2vw,2.6rem);font-weight:800;margin:0 0 12px}
.gxi-h2 em{font-style:normal;color:var(--gxi-bleu)}
.gxi-sec--nuit .gxi-h2 em{color:var(--gxi-ambre-clair)}
.gxi-lead{color:var(--gxi-gris);font-size:1rem}

.gxi-btn{
  display:inline-flex;align-items:center;justify-content:center;gap:9px;
  padding:13px 24px;border-radius:999px;border:1px solid transparent;
  font-weight:700;font-size:.95rem;cursor:pointer;
  transition:transform .18s ease,box-shadow .18s ease,background .18s ease;
}
.gxi-btn:hover{transform:translateY(-1px)}
.gxi-btn--plein{background:var(--gxi-bleu);color:#fff;box-shadow:0 12px 26px rgba(36,89,224,.28)}
.gxi-btn--ambre{background:var(--gxi-ambre);color:#fff;box-shadow:0 12px 26px rgba(242,107,58,.30)}
.gxi-btn--ligne{border-color:currentColor;background:transparent}
.gxi-actions{display:flex;flex-wrap:wrap;gap:12px;margin-top:22px}

/* ── EN-TÊTE ────────────────────────────────────────────────────────── */
.gxi-nav{position:sticky;top:0;z-index:40;background:rgba(255,255,255,.94);backdrop-filter:saturate(150%) blur(10px);border-bottom:1px solid var(--gxi-bord)}
.gxi-nav-in{max-width:1240px;margin:0 auto;padding:10px var(--gxi-gouttiere);display:flex;align-items:center;gap:14px}
.gxi-logo{display:flex;align-items:center;gap:10px;font-family:var(--gxi-titre);font-weight:800;font-size:1.02rem;min-width:0}
.gxi-logo img{width:38px;height:38px;border-radius:10px;object-fit:cover;flex:0 0 auto}
.gxi-logo span{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.gxi-nav-liens{display:none}
.gxi-nav-actions{margin-left:auto;display:flex;align-items:center;gap:8px}
.gxi-burger{
  display:inline-flex;flex-direction:column;justify-content:center;gap:5px;
  width:42px;height:42px;padding:0 10px;border:1px solid var(--gxi-bord);border-radius:12px;background:#fff;cursor:pointer;
}
.gxi-burger span{display:block;height:2px;background:var(--gxi-encre);border-radius:2px}
.gxi-nav-cta{display:none}
/* Tiroir mobile : un panneau qui glisse, jamais un calque plein écran —
   dans l'iframe, un `position:fixed` se pose au milieu du document. */
.gxi-tiroir{display:none;border-top:1px solid var(--gxi-bord);background:#fff;padding:8px var(--gxi-gouttiere) 18px}
.gxi-tiroir.est-ouvert{display:block}
.gxi-tiroir a{display:block;padding:12px 4px;border-bottom:1px solid var(--gxi-bord);font-weight:600}
.gxi-tiroir a:last-child{border-bottom:0}
@media (min-width:1024px){
  .gxi-nav-liens{display:flex;align-items:center;gap:4px;margin-left:12px;flex-wrap:wrap}
  .gxi-nav-liens a{padding:9px 12px;border-radius:999px;font-weight:600;font-size:.9rem;color:var(--gxi-gris)}
  .gxi-nav-liens a:hover{background:var(--gxi-sable);color:var(--gxi-encre)}
  .gxi-burger{display:none}
  .gxi-nav-cta{display:inline-flex}
  .gxi-tiroir{display:none !important}
}

/* ── HÉROS ──────────────────────────────────────────────────────────── */
.gxi-hero{position:relative;background:var(--gxi-nuit);color:#fff;overflow:hidden}
.gxi-piste{display:flex;overflow-x:auto;scroll-snap-type:x mandatory;scrollbar-width:none;-webkit-overflow-scrolling:touch}
.gxi-piste::-webkit-scrollbar{display:none}
.gxi-diapo{position:relative;flex:0 0 100%;min-width:0;scroll-snap-align:start;display:flex;align-items:flex-end;min-height:clamp(380px,62vw,620px)}
.gxi-diapo-fond{position:absolute;inset:0;z-index:0;overflow:hidden;background:#000}
.gxi-diapo-fond img{width:100%;height:100%;object-fit:cover}
/* Le lecteur YouTube met la vidéo en boîte à lettres : on recadre l'iframe
   elle-même, en unités de CONTENEUR — jamais de fenêtre (cf. l'iframe). */
.gxi-diapo-fond iframe{position:absolute;top:0;left:0;width:100%;height:100%;border:0;pointer-events:none}
@supports (width:1cqw){
  .gxi-diapo-fond{container-type:size}
  .gxi-diapo-fond iframe{
    top:50%;left:50%;right:auto;bottom:auto;
    width:max(100cqw,177.7778cqh);height:max(56.25cqw,100cqh);
    max-width:none;max-height:none;transform:translate(-50%,-50%);
  }
}
.gxi-diapo-voile{position:absolute;inset:0;z-index:1;pointer-events:none;
  background:linear-gradient(90deg,rgba(11,19,36,.88) 0%,rgba(11,19,36,.55) 48%,rgba(11,19,36,.18) 100%),
             linear-gradient(0deg,rgba(11,19,36,.70) 0%,rgba(11,19,36,0) 55%)}
.gxi-diapo-corps{position:relative;z-index:2;width:100%;max-width:1240px;margin:0 auto;padding:clamp(48px,8vw,96px) var(--gxi-gouttiere) clamp(64px,9vw,112px)}
.gxi-hero h1{font-size:clamp(1.9rem,6.4vw,3.8rem);font-weight:800;max-width:17ch}
.gxi-hero h1 em{font-style:normal;color:var(--gxi-ambre-clair)}
.gxi-hero-texte{margin-top:14px;max-width:52ch;color:rgba(255,255,255,.88);font-size:clamp(.98rem,2.4vw,1.14rem)}
.gxi-hero-fleche{
  position:absolute;top:50%;transform:translateY(-50%);z-index:3;
  width:44px;height:44px;border-radius:50%;display:none;align-items:center;justify-content:center;
  background:rgba(255,255,255,.16);border:1px solid rgba(255,255,255,.3);color:#fff;cursor:pointer;
}
.gxi-hero-prec{left:12px} .gxi-hero-suiv{right:12px}
.gxi-hero-points{position:absolute;left:0;right:0;bottom:18px;z-index:3;display:flex;justify-content:center;gap:8px}
.gxi-hero-point{width:28px;height:4px;border-radius:99px;border:0;padding:0;background:rgba(255,255,255,.4);cursor:pointer}
.gxi-hero-point.est-actif{width:44px;background:#fff}
@media (min-width:768px){ .gxi-hero-fleche{display:inline-flex} }

/* ── GRILLES ────────────────────────────────────────────────────────── */
.gxi-grille{display:grid;gap:clamp(14px,2vw,22px);grid-template-columns:1fr}
@media (min-width:560px){ .gxi-grille{grid-template-columns:repeat(2,minmax(0,1fr))} }
@media (min-width:960px){ .gxi-grille--3{grid-template-columns:repeat(3,minmax(0,1fr))} }
@media (min-width:960px){ .gxi-grille--4{grid-template-columns:repeat(4,minmax(0,1fr))} }

.gxi-carte{
  position:relative;display:flex;flex-direction:column;overflow:hidden;
  background:#fff;border:1px solid var(--gxi-bord);border-radius:var(--gxi-rayon);
  box-shadow:var(--gxi-ombre);transition:transform .2s ease,box-shadow .2s ease;
}
.gxi-carte:hover{transform:translateY(-3px);box-shadow:0 24px 50px rgba(15,23,42,.16)}
.gxi-carte-media{position:relative;display:block;aspect-ratio:4/3;overflow:hidden;background:var(--gxi-sable)}
.gxi-carte-media img{width:100%;height:100%;object-fit:cover}
.gxi-carte-corps{display:flex;flex-direction:column;gap:7px;padding:16px 18px 18px;flex:1 1 auto}
.gxi-carte-sur{font-size:.72rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase;color:var(--gxi-bleu)}
.gxi-carte-nom{font-family:var(--gxi-titre);font-weight:700;font-size:1.04rem;line-height:1.3}
.gxi-carte-texte{color:var(--gxi-gris);font-size:.92rem}
.gxi-carte-pied{margin-top:auto;padding-top:12px;display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap}
.gxi-prix{font-family:var(--gxi-titre);font-weight:800;font-size:1.12rem}
.gxi-prix small{font-weight:600;font-size:.76rem;color:var(--gxi-gris)}
.gxi-badge{
  position:absolute;top:12px;left:12px;z-index:2;padding:6px 12px;border-radius:999px;
  background:rgba(15,26,51,.88);color:#fff;font-size:.72rem;font-weight:800;
}
.gxi-specs{display:flex;flex-wrap:wrap;gap:8px;font-size:.8rem;color:var(--gxi-gris)}
.gxi-specs span{padding:4px 10px;border-radius:999px;background:var(--gxi-sable)}

/* ── BOUTIQUE ───────────────────────────────────────────────────────── */
.gxi-rayons{display:grid;gap:12px;grid-template-columns:repeat(2,minmax(0,1fr));margin-bottom:26px}
@media (min-width:768px){ .gxi-rayons{grid-template-columns:repeat(4,minmax(0,1fr))} }
.gxi-rayon{display:flex;align-items:center;gap:12px;padding:12px;border:1px solid var(--gxi-bord);border-radius:14px;background:#fff}
.gxi-rayon img{width:48px;height:48px;border-radius:10px;object-fit:cover;flex:0 0 auto}
.gxi-rayon b{display:block;font-size:.92rem;line-height:1.25}
.gxi-rayon span{font-size:.78rem;color:var(--gxi-gris)}
.gxi-ajout{
  width:100%;padding:11px 14px;border:0;border-radius:12px;cursor:pointer;
  background:var(--gxi-encre);color:#fff;font-weight:700;font-size:.88rem;
  display:inline-flex;align-items:center;justify-content:center;gap:8px;
}
.gxi-ajout:hover{background:var(--gxi-bleu)}

/* ── UNIVERS / SERVICES / ESPACES ───────────────────────────────────── */
.gxi-tuiles{display:grid;gap:12px;grid-template-columns:repeat(2,minmax(0,1fr))}
@media (min-width:768px){ .gxi-tuiles{grid-template-columns:repeat(4,minmax(0,1fr))} }
.gxi-tuile{
  display:flex;flex-direction:column;gap:6px;padding:18px;border-radius:14px;
  background:#fff;border:1px solid var(--gxi-bord);box-shadow:var(--gxi-ombre);
}
.gxi-tuile i{font-size:1.3rem;color:var(--gxi-ambre)}
.gxi-tuile b{font-family:var(--gxi-titre);font-size:.98rem}
.gxi-tuile span{font-size:.82rem;color:var(--gxi-gris)}

/* ── CHIFFRES ───────────────────────────────────────────────────────── */
.gxi-chiffres{display:grid;gap:14px;grid-template-columns:repeat(2,minmax(0,1fr));text-align:center}
@media (min-width:768px){ .gxi-chiffres{grid-template-columns:repeat(4,minmax(0,1fr))} }
.gxi-chiffre b{display:block;font-family:var(--gxi-titre);font-size:clamp(1.7rem,5vw,2.6rem);font-weight:800;color:var(--gxi-ambre-clair)}
.gxi-chiffre span{font-size:.84rem;color:rgba(255,255,255,.76)}

/* ── À PROPOS ───────────────────────────────────────────────────────── */
.gxi-duo{display:grid;gap:clamp(22px,4vw,48px);grid-template-columns:1fr;align-items:center}
@media (min-width:900px){ .gxi-duo{grid-template-columns:repeat(2,minmax(0,1fr))} }
.gxi-duo-media{border-radius:var(--gxi-rayon);overflow:hidden;box-shadow:var(--gxi-ombre);aspect-ratio:4/3;background:var(--gxi-sable)}
.gxi-duo-media img{width:100%;height:100%;object-fit:cover}
.gxi-points li{display:flex;gap:10px;padding:8px 0;font-size:.95rem}
.gxi-points i{color:var(--gxi-bleu);margin-top:5px}

/* ── VIDÉOS ─────────────────────────────────────────────────────────── */
.gxi-videos{display:grid;gap:16px;grid-template-columns:1fr}
@media (min-width:768px){ .gxi-videos{grid-template-columns:repeat(2,minmax(0,1fr))} }
@media (min-width:1100px){ .gxi-videos{grid-template-columns:repeat(3,minmax(0,1fr))} }
.gxi-video{background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.12);border-radius:var(--gxi-rayon);overflow:hidden}
.gxi-cadre{position:relative;aspect-ratio:16/9;background:#000}
.gxi-cadre iframe{position:absolute;inset:0;width:100%;height:100%;border:0}
.gxi-video-corps{padding:14px 16px 18px}
.gxi-video-corps h3{font-size:1rem;margin-bottom:5px}
.gxi-video-corps p{font-size:.86rem;color:rgba(255,255,255,.7)}
.gxi-voir{
  display:inline-flex;align-items:center;gap:7px;margin-top:10px;
  font-size:.82rem;font-weight:700;color:var(--gxi-ambre-clair);
}
.gxi-voir:hover{text-decoration:underline}

/* ── GALERIE ────────────────────────────────────────────────────────── */
.gxi-mosaique{display:grid;gap:10px;grid-template-columns:repeat(2,minmax(0,1fr))}
@media (min-width:768px){ .gxi-mosaique{grid-template-columns:repeat(3,minmax(0,1fr))} }
@media (min-width:1100px){ .gxi-mosaique{grid-template-columns:repeat(4,minmax(0,1fr))} }
.gxi-vue{position:relative;margin:0;border-radius:14px;overflow:hidden;aspect-ratio:1/1;background:var(--gxi-sable)}
.gxi-vue--large{grid-column:span 2;aspect-ratio:16/10}
.gxi-vue img{width:100%;height:100%;object-fit:cover;transition:transform .35s ease}
.gxi-vue:hover img{transform:scale(1.04)}
.gxi-vue figcaption{
  position:absolute;left:0;right:0;bottom:0;padding:22px 14px 11px;
  background:linear-gradient(0deg,rgba(11,19,36,.82),transparent);
  color:#fff;font-size:.82rem;font-weight:600;
}

/* ── À PROXIMITÉ ────────────────────────────────────────────────────── */
.gxi-filtres{display:flex;gap:8px;overflow-x:auto;padding-bottom:6px;margin-bottom:20px;scrollbar-width:none}
.gxi-filtres::-webkit-scrollbar{display:none}
.gxi-filtre{
  flex:0 0 auto;padding:9px 16px;border-radius:999px;border:1px solid var(--gxi-bord);
  background:#fff;color:var(--gxi-encre);font-weight:600;font-size:.85rem;cursor:pointer;white-space:nowrap;
}
.gxi-filtre.est-actif{background:var(--gxi-encre);color:#fff;border-color:var(--gxi-encre)}
.gxi-proche[hidden]{display:none !important}
.gxi-distance{font-size:.8rem;font-weight:700;color:var(--gxi-ambre)}

/* ── HORAIRES / CONTACT ─────────────────────────────────────────────── */
.gxi-contact{display:grid;gap:clamp(24px,4vw,48px);grid-template-columns:1fr}
@media (min-width:900px){ .gxi-contact{grid-template-columns:repeat(2,minmax(0,1fr))} }
.gxi-infos{display:grid;gap:14px;margin-top:22px}
.gxi-info{display:flex;gap:12px;align-items:flex-start}
.gxi-info i{width:36px;height:36px;border-radius:10px;background:rgba(255,255,255,.1);display:inline-flex;align-items:center;justify-content:center;flex:0 0 auto;color:var(--gxi-ambre-clair)}
.gxi-info b{display:block;font-size:.78rem;letter-spacing:.06em;text-transform:uppercase;color:rgba(255,255,255,.6)}
.gxi-info span,.gxi-info a{font-size:.98rem;word-break:break-word}
.gxi-horaires{margin-top:18px;border-radius:14px;overflow:hidden;border:1px solid rgba(255,255,255,.14)}
.gxi-horaires li{display:flex;justify-content:space-between;gap:14px;padding:10px 14px;font-size:.9rem}
.gxi-horaires li:nth-child(odd){background:rgba(255,255,255,.05)}
.gxi-form{display:grid;gap:12px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.14);border-radius:var(--gxi-rayon);padding:clamp(18px,3vw,28px)}
.gxi-form-ligne{display:grid;gap:12px;grid-template-columns:1fr}
@media (min-width:520px){ .gxi-form-ligne{grid-template-columns:repeat(2,minmax(0,1fr))} }
.gxi-form input,.gxi-form textarea{
  width:100%;padding:13px 15px;border-radius:12px;border:1px solid rgba(255,255,255,.2);
  background:rgba(255,255,255,.08);color:#fff;font:inherit;font-size:.95rem;
}
.gxi-form input::placeholder,.gxi-form textarea::placeholder{color:rgba(255,255,255,.55)}
.gxi-form textarea{min-height:130px;resize:vertical}
.gxi-form [data-gx-contact-statut]{font-size:.88rem}
.gxi-form .est-erreur{color:#fca5a5}
.gxi-form .est-succes{color:#86efac}

/* ── FICHE D'UN BIEN ────────────────────────────────────────────────── */
.gxi-fiche{position:fixed;inset:0;z-index:90;display:none;background:rgba(8,14,28,.72);padding:16px;overflow:auto}
.gxi-fiche.est-ouverte{display:block}
.gxi-fiche-panneau{max-width:900px;margin:24px auto;background:#fff;border-radius:var(--gxi-rayon);overflow:hidden;box-shadow:0 30px 80px rgba(2,6,23,.45)}
.gxi-fiche-tete{display:flex;align-items:flex-start;gap:14px;padding:20px 22px;border-bottom:1px solid var(--gxi-bord)}
.gxi-fiche-tete h3{font-size:1.25rem;margin:4px 0}
.gxi-fiche-fermer{margin-left:auto;width:38px;height:38px;border-radius:50%;border:1px solid var(--gxi-bord);background:#fff;font-size:1.3rem;line-height:1;cursor:pointer;flex:0 0 auto}
.gxi-fiche-corps{padding:20px 22px 26px;display:grid;gap:16px}
.gxi-fiche-corps img{width:100%;border-radius:12px;aspect-ratio:16/9;object-fit:cover}
.gxi-equip{display:flex;flex-wrap:wrap;gap:8px}
.gxi-equip span{padding:6px 12px;border-radius:999px;background:var(--gxi-sable);font-size:.84rem}

/* ── PIED ───────────────────────────────────────────────────────────── */
.gxi-pied{background:var(--gxi-nuit);color:rgba(255,255,255,.78);padding:clamp(40px,6vw,72px) var(--gxi-gouttiere) 28px}
.gxi-pied-grille{display:grid;gap:28px;grid-template-columns:1fr;max-width:1240px;margin:0 auto}
@media (min-width:768px){ .gxi-pied-grille{grid-template-columns:2fr 1fr 1fr} }
.gxi-pied h4{color:#fff;font-size:.95rem;margin-bottom:12px}
.gxi-pied a:hover{color:#fff}
.gxi-pied-liens{display:grid;gap:8px;font-size:.9rem}
.gxi-pied-social{display:flex;gap:10px;margin-top:14px}
.gxi-pied-social a{width:38px;height:38px;border-radius:50%;background:rgba(255,255,255,.08);display:inline-flex;align-items:center;justify-content:center}
.gxi-pied-bas{
  max-width:1240px;margin:28px auto 0;padding-top:18px;border-top:1px solid rgba(255,255,255,.12);
  display:flex;flex-wrap:wrap;gap:10px;justify-content:space-between;font-size:.82rem;color:rgba(255,255,255,.55);
}

/* Le site est rendu dans une iframe : un lien qui s'ouvre « dans la page »
   remplacerait le cadre et non l'onglet. Le pont s'en charge, cette règle ne
   fait que garder les médias cliquables au-dessus des voiles. */
.gxi-tpl [data-gx-map]{position:relative;z-index:1}

@media (prefers-reduced-motion:reduce){
  .gxi-tpl *{animation:none !important;transition:none !important}
  .gxi-piste{scroll-behavior:auto}
}
</style>
</head>
<body>
<div class="{{ \Vendor\Cms\Support\GabaritInterne::ENVELOPPE }}">

{{-- ══ EN-TÊTE ═══════════════════════════════════════════════════════ --}}
<nav class="gxi-nav" aria-label="Navigation principale">
  <div class="gxi-nav-in">
    <a href="#gxi-haut" class="gxi-logo">
      @if ($gxiLogo)
        <img src="{{ $gxiLogo }}" alt="{{ $gxiNom }}">
      @endif
      <span>{{ $gxiNom }}</span>
    </a>
    <div class="gxi-nav-liens">
      @foreach ($gxiMenu as $entree)
        <a href="{{ $entree[0] }}">{{ $entree[1] }}</a>
      @endforeach
    </div>
    <div class="gxi-nav-actions">
      @if ($gxiTelephone)
        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $gxiTelephone) }}" class="gxi-btn gxi-btn--plein gxi-nav-cta">
          <i class="fas fa-phone"></i> {{ $gxiTelephone }}
        </a>
      @endif
      <button type="button" class="gxi-burger" data-gxi-burger aria-expanded="false" aria-controls="gxi-tiroir" aria-label="Ouvrir le menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
  <div class="gxi-tiroir" id="gxi-tiroir">
    @foreach ($gxiMenu as $entree)
      <a href="{{ $entree[0] }}">{{ $entree[1] }}</a>
    @endforeach
    @if ($gxiTelephone)
      <a href="tel:{{ preg_replace('/[^0-9+]/', '', $gxiTelephone) }}"><i class="fas fa-phone"></i> {{ $gxiTelephone }}</a>
    @endif
  </div>
</nav>

{{-- ══ HÉROS ════════════════════════════════════════════════════════════
     Les vidéos sont MUETTES et ne démarrent pas seules : une page qui parle
     toute seule fait fermer l'onglet, et les navigateurs refusent de toute
     façon de lancer une vidéo sonore.
     ══════════════════════════════════════════════════════════════════════ --}}
<section class="gxi-hero" id="gxi-haut" data-gxi-hero>
  <div class="gxi-piste" data-gxi-piste>
    @if ($gxiDiapos->isEmpty())
      <div class="gxi-diapo">
        <div class="gxi-diapo-fond" aria-hidden="true"
             style="background:linear-gradient(135deg,var(--gxi-nuit),var(--gxi-bleu))"></div>
        <div class="gxi-diapo-voile" aria-hidden="true"></div>
        <div class="gxi-diapo-corps">
          <p class="gxi-kicker"><i class="fas fa-location-dot"></i> {{ $gxiVille ?: 'GoExploria' }}</p>
          <h1>{{ $gxiNom }}</h1>
          @if ($gxiSlogan || $gxiDescription)
            <p class="gxi-hero-texte">{{ \Illuminate\Support\Str::limit($gxiSlogan ?: $gxiDescription, 190) }}</p>
          @endif
          <div class="gxi-actions">
            <a href="#gxi-contact" class="gxi-btn gxi-btn--ambre">Nous contacter <i class="fas fa-arrow-right"></i></a>
            <a href="#gxi-carte" class="gxi-btn gxi-btn--ligne">Nous situer</a>
          </div>
        </div>
      </div>
    @else
      @foreach ($gxiDiapos as $i => $diapo)
        <div class="gxi-diapo">
          <div class="gxi-diapo-fond" aria-hidden="true">
            @if ($diapo['video'])
              <iframe src="{{ \Vendor\Cms\Support\GabaritInterne::lecteurVideo($diapo['video']) }}"
                      title="{{ $diapo['titre'] ?: $gxiNom }}" loading="{{ $i === 0 ? 'eager' : 'lazy' }}"
                      allow="accelerometer; encrypted-media; picture-in-picture" allowfullscreen></iframe>
            @elseif ($diapo['image'])
              <img src="{{ $diapo['image'] }}" alt="" loading="{{ $i === 0 ? 'eager' : 'lazy' }}" decoding="async">
            @endif
          </div>
          <div class="gxi-diapo-voile" aria-hidden="true"></div>
          <div class="gxi-diapo-corps">
            <p class="gxi-kicker"><i class="fas fa-location-dot"></i> {{ $gxiVille ?: 'GoExploria' }}</p>
            <h1>{{ $i === 0 ? $gxiNom : ($diapo['titre'] ?: $gxiNom) }}</h1>
            @if ($i === 0 ? ($gxiSlogan ?: $diapo['texte']) : $diapo['texte'])
              <p class="gxi-hero-texte">{{ \Illuminate\Support\Str::limit($i === 0 ? ($gxiSlogan ?: $diapo['texte']) : $diapo['texte'], 190) }}</p>
            @endif
            <div class="gxi-actions">
              @if ($diapo['lien'] && $diapo['bouton'])
                <a href="{{ $diapo['lien'] }}" class="gxi-btn gxi-btn--ambre" target="_top">{{ $diapo['bouton'] }}</a>
              @else
                <a href="#gxi-contact" class="gxi-btn gxi-btn--ambre">Nous contacter <i class="fas fa-arrow-right"></i></a>
              @endif
              <a href="#gxi-carte" class="gxi-btn gxi-btn--ligne">Nous situer</a>
            </div>
          </div>
        </div>
      @endforeach
    @endif
  </div>

  @if ($gxiDiapos->count() > 1)
    <button type="button" class="gxi-hero-fleche gxi-hero-prec" data-gxi-prec aria-label="Diapositive précédente"><i class="fas fa-chevron-left"></i></button>
    <button type="button" class="gxi-hero-fleche gxi-hero-suiv" data-gxi-suiv aria-label="Diapositive suivante"><i class="fas fa-chevron-right"></i></button>
    <div class="gxi-hero-points">
      @foreach ($gxiDiapos as $i => $d)
        <button type="button" class="gxi-hero-point{{ $i === 0 ? ' est-actif' : '' }}" data-gxi-aller="{{ $i }}" aria-label="Diapositive {{ $i + 1 }}"></button>
      @endforeach
    </div>
  @endif
</section>

{{-- ══ CARTE — remplacée au rendu par la vraie carte Maps Vidéos ══════ --}}
<section id="gxi-carte" data-gx-map data-gx-map-videos data-gx-map-repli data-gx-map-variante="section"
         class="gxi-sec gxi-sec--sable">
  <div class="gxi-wrap gxi-head gxi-head--centre">
    <p class="gxi-kicker"><i class="fas fa-map-location-dot"></i> Nous situer</p>
    <h2 class="gxi-h2">{{ $gxiNom }}</h2>
    @if ($gxiAdresseComplete)
      <p class="gxi-lead">{{ $gxiAdresseComplete }}</p>
    @endif
    <div class="gxi-actions" style="justify-content:center">
      <a class="gxi-btn gxi-btn--plein" data-gx-map-itineraire href="#gxi-carte" target="_blank" rel="noopener">
        <i class="fas fa-diamond-turn-right"></i> Itinéraire
      </a>
    </div>
  </div>
</section>

{{-- ══ NOS UNIVERS ═══════════════════════════════════════════════════ --}}
@if ($gxiUnivers->isNotEmpty())
<section class="gxi-sec" id="gxi-univers">
  <div class="gxi-wrap">
    <div class="gxi-head">
      <p class="gxi-kicker"><i class="fas fa-shapes"></i> Ce que propose cet établissement</p>
      <h2 class="gxi-h2">Tout ce qu'il y a <em>à découvrir</em></h2>
      <p class="gxi-lead">Chaque rubrique est alimentée directement par {{ $gxiNom }} : ce que vous voyez est ce qui est publié aujourd'hui.</p>
    </div>
    <div class="gxi-tuiles">
      @foreach ($gxiUnivers as $u)
        <a class="gxi-tuile" href="{{ $u[0] }}">
          <i class="fas {{ $u[1] }}"></i>
          <b>{{ $u[2] }}</b>
          <span>{{ $u[3] }}</span>
        </a>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- ══ À PROPOS ══════════════════════════════════════════════════════ --}}
@if ($gxiDescription !== '' || $gxiMedias->isNotEmpty())
<section class="gxi-sec gxi-sec--sable" id="gxi-apropos">
  <div class="gxi-wrap gxi-duo">
    @if ($gxiMedias->isNotEmpty())
      <div class="gxi-duo-media">
        <img src="{{ $gxiImage($gxiMedias->first()) }}" alt="{{ $gxiNom }}" loading="lazy" decoding="async">
      </div>
    @endif
    <div>
      <p class="gxi-kicker"><i class="fas fa-circle-info"></i> À propos</p>
      <h2 class="gxi-h2">{{ $gxiNom }}</h2>
      @if ($gxiDescription !== '')
        <p class="gxi-lead">{{ $gxiDescription }}</p>
      @endif
      <ul class="gxi-points" style="margin-top:18px">
        @if ($gxiAdresseComplete)
          <li><i class="fas fa-location-dot"></i><span>{{ $gxiAdresseComplete }}</span></li>
        @endif
        @if ($gxiTelephone)
          <li><i class="fas fa-phone"></i><span>{{ $gxiTelephone }}</span></li>
        @endif
        @if ($gxiSite)
          <li><i class="fas fa-globe"></i><a href="{{ $gxiSite }}" target="_blank" rel="noopener nofollow">{{ preg_replace('#^https?://#', '', $gxiSite) }}</a></li>
        @endif
      </ul>
      <div class="gxi-actions">
        <a href="#gxi-contact" class="gxi-btn gxi-btn--plein"><i class="fas fa-paper-plane"></i> Écrire à cet établissement</a>
      </div>
    </div>
  </div>
</section>
@endif

{{-- ══ CHIFFRES — comptés, jamais affirmés ═══════════════════════════ --}}
@if ($gxiChiffres->isNotEmpty())
<section class="gxi-sec gxi-sec--nuit" id="gxi-chiffres" style="padding-top:clamp(34px,5vw,56px);padding-bottom:clamp(34px,5vw,56px)">
  <div class="gxi-wrap gxi-chiffres">
    @foreach ($gxiChiffres as $c)
      <div class="gxi-chiffre"><b>{{ number_format($c[0], 0, ',', ' ') }}</b><span>{{ $c[1] }}</span></div>
    @endforeach
  </div>
</section>
@endif

{{-- ══ BOUTIQUE — rayons + catalogue (onglet E-commerce) ═════════════ --}}
@if ($gxiProduits->isNotEmpty() || $gxiRayons->isNotEmpty())
<section class="gxi-sec" id="gxi-boutique">
  <div class="gxi-wrap">
    <div class="gxi-head">
      <p class="gxi-kicker"><i class="fas fa-bag-shopping"></i> Boutique</p>
      <h2 class="gxi-h2">Le <em>catalogue</em></h2>
      <p class="gxi-lead">Prix, photos et descriptions viennent de l'onglet E-commerce de l'espace entreprise.</p>
    </div>

    @if ($gxiRayons->isNotEmpty())
      <div class="gxi-rayons">
        @foreach ($gxiRayons as $rayon)
          @php
            $gxiRayonImage = ProductPresenter::url($rayon->image ?? $rayon->icon ?? null);
            $gxiRayonCompte = (int) ($rayon->products_count ?? 0);
          @endphp
          <div class="gxi-rayon">
            @if ($gxiRayonImage)
              <img src="{{ $gxiRayonImage }}" alt="" loading="lazy" decoding="async">
            @else
              <span style="width:48px;height:48px;border-radius:10px;background:var(--gxi-sable);display:inline-flex;align-items:center;justify-content:center;flex:0 0 auto"><i class="fas fa-layer-group" style="color:var(--gxi-gris-clair)"></i></span>
            @endif
            <span>
              <b>{{ $rayon->name }}</b>
              <span>{{ $gxiRayonCompte > 0 ? $gxiRayonCompte . ' article' . ($gxiRayonCompte > 1 ? 's' : '') : 'Rayon' }}</span>
            </span>
          </div>
        @endforeach
      </div>
    @endif

    @if ($gxiProduits->isNotEmpty())
      <div class="gxi-grille gxi-grille--4">
        @foreach ($gxiProduits as $produit)
          @php
            $gxiPrix = ProductPresenter::prix($produit);
            $gxiProdImage = ProductPresenter::image($produit);
            $gxiPastille = ProductPresenter::pastille($produit);
            $gxiEpuise = ProductPresenter::estEpuise($produit);
            $gxiProdUrl = route('cms.company.products.show', ['etablissementId' => $etablissement->id, 'productId' => $produit->id]);
          @endphp
          <article class="gxi-carte">
            <a class="gxi-carte-media" href="{{ $gxiProdUrl }}" target="_top">
              @if ($gxiPastille)<span class="gxi-badge">{{ $gxiPastille }}</span>@endif
              @if ($gxiProdImage)
                <img src="{{ $gxiProdImage }}" alt="{{ $produit->name }}" loading="lazy" decoding="async">
              @endif
            </a>
            <div class="gxi-carte-corps">
              @if ($produit->category?->name)
                <span class="gxi-carte-sur">{{ $produit->category->name }}</span>
              @endif
              <a class="gxi-carte-nom" href="{{ $gxiProdUrl }}" target="_top">{{ $produit->name }}</a>
              <p class="gxi-carte-texte">{{ ProductPresenter::description($produit, 110) }}</p>
              <div class="gxi-carte-pied">
                <span class="gxi-prix">
                  {{ $gxiPrix !== null ? ProductPresenter::montant($gxiPrix) : 'Sur demande' }}
                  @if ($produit->billing_unit)<small>/ {{ $produit->billing_unit }}</small>@endif
                </span>
              </div>
              @if ($gxiEpuise)
                <span class="gxi-ajout" style="background:var(--gxi-gris-clair);cursor:default"><i class="fas fa-circle-xmark"></i> Épuisé</span>
              @elseif ($gxiPrix !== null)
                <button type="button" class="gxi-ajout"
                        data-cms-cart-add
                        data-product-id="{{ $produit->id }}"
                        data-product-name="{{ $produit->name }}"
                        data-product-price="{{ $gxiPrix }}"
                        data-product-image="{{ $gxiProdImage }}"
                        data-product-url="{{ $gxiProdUrl }}"
                        data-etablissement-id="{{ $etablissement->id }}">
                  <i class="fas fa-basket-shopping"></i> Ajouter au panier
                </button>
              @endif
            </div>
          </article>
        @endforeach
      </div>
      <div class="gxi-actions">
        <a class="gxi-btn gxi-btn--ligne" href="{{ route('cms.company.products', ['etablissementId' => $etablissement->id]) }}" target="_top">
          Tout le catalogue <i class="fas fa-arrow-right"></i>
        </a>
      </div>
    @endif
  </div>
</section>
@endif

{{-- ══ HÉBERGEMENTS / FORFAITS / VÉHICULES (onglet Immobilier) ═══════ --}}
@foreach ([
    ['gxi-hebergements', 'Hébergements', 'fa-bed', 'hebergements', $gxiHebergements, 'Réserver'],
    ['gxi-forfaits', 'Forfaits', 'fa-suitcase-rolling', 'forfaits', $gxiForfaits, 'Demander'],
    ['gxi-vehicules', 'Location', 'fa-car-side', 'vehicules', $gxiVehicules, 'Réserver'],
] as [$gxiId, $gxiTitre, $gxiIcone, $gxiPanier, $gxiListe, $gxiBouton])
  @continue($gxiListe->isEmpty())
  @php $gxiMots = GabaritInterne::libelles($gxiPanier); @endphp
  <section class="gxi-sec{{ $loop->index % 2 === 0 ? ' gxi-sec--sable' : '' }}" id="{{ $gxiId }}">
    <div class="gxi-wrap">
      <div class="gxi-head">
        <p class="gxi-kicker"><i class="fas {{ $gxiIcone }}"></i> {{ $gxiTitre }}</p>
        <h2 class="gxi-h2">{{ $gxiListe->count() }} <em>{{ \Illuminate\Support\Str::lower($gxiTitre) }}</em> disponibles</h2>
      </div>
      <div class="gxi-grille gxi-grille--3">
        @foreach ($gxiListe as $bien)
          @php
            $gxiBienImage = GabaritInterne::imageBien($bien);
            $gxiLieu = trim(implode(' · ', array_filter([$bien->area, $bien->city])));
          @endphp
          <article class="gxi-carte">
            <a class="gxi-carte-media" href="#{{ $gxiId }}" data-im-open="{{ $bien->id }}">
              <span class="gxi-badge">{{ $gxiMots['badge'] }}</span>
              @if ($gxiBienImage)
                <img src="{{ $gxiBienImage }}" alt="{{ $bien->title }}" loading="lazy" decoding="async">
              @endif
            </a>
            <div class="gxi-carte-corps">
              @if ($bien->type)<span class="gxi-carte-sur">{{ $bien->type }}</span>@endif
              <a class="gxi-carte-nom" href="#{{ $gxiId }}" data-im-open="{{ $bien->id }}">{{ $bien->title }}</a>
              @if ($gxiLieu)<p class="gxi-carte-texte">{{ $gxiLieu }}</p>@endif
              <div class="gxi-specs">
                @if (GabaritInterne::pluriel($bien->capacity, $gxiMots['capacite']))
                  <span>{{ GabaritInterne::pluriel($bien->capacity, $gxiMots['capacite']) }}</span>
                @endif
                @if (GabaritInterne::pluriel($bien->bedrooms, $gxiMots['second']))
                  <span>{{ GabaritInterne::pluriel($bien->bedrooms, $gxiMots['second']) }}</span>
                @endif
              </div>
              <div class="gxi-carte-pied">
                <span class="gxi-prix">{{ GabaritInterne::prixBien($bien) }}
                  @if (GabaritInterne::prixBien($bien) !== 'Sur demande')<small>{{ $gxiMots['unite'] }}</small>@endif
                </span>
                <a class="gxi-btn gxi-btn--plein" style="padding:9px 16px;font-size:.85rem" href="#{{ $gxiId }}" data-im-open="{{ $bien->id }}">{{ $gxiBouton }}</a>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </section>
@endforeach

{{-- ══ ACTIVITÉS (onglet Activités) ══════════════════════════════════ --}}
@if ($gxiActivites->isNotEmpty())
<section class="gxi-sec" id="gxi-activites">
  <div class="gxi-wrap">
    <div class="gxi-head">
      <p class="gxi-kicker"><i class="fas fa-person-hiking"></i> Activités</p>
      <h2 class="gxi-h2">Ce qu'on peut <em>y faire</em></h2>
    </div>
    <div class="gxi-grille gxi-grille--4">
      @foreach ($gxiActivites as $activite)
        @php
          $gxiActImage = ProductPresenter::url($activite->image ?? $activite->cover ?? null);
          $gxiActDesc = trim(strip_tags((string) $activite->description));
        @endphp
        <article class="gxi-carte">
          <span class="gxi-carte-media" aria-hidden="{{ $gxiActImage ? 'false' : 'true' }}">
            @if ($activite->categoryRelation?->name)
              <span class="gxi-badge">{{ $activite->categoryRelation->name }}</span>
            @endif
            @if ($gxiActImage)
              <img src="{{ $gxiActImage }}" alt="{{ $activite->name }}" loading="lazy" decoding="async">
            @endif
          </span>
          <div class="gxi-carte-corps">
            <span class="gxi-carte-nom">{{ $activite->name }}</span>
            @if ($gxiActDesc !== '')
              <p class="gxi-carte-texte">{{ \Illuminate\Support\Str::limit($gxiActDesc, 120) }}</p>
            @endif
          </div>
        </article>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- ══ VIDÉOS ════════════════════════════════════════════════════════ --}}
@if ($gxiVideos->isNotEmpty())
<section class="gxi-sec gxi-sec--nuit" id="gxi-videos">
  <div class="gxi-wrap">
    <div class="gxi-head">
      <p class="gxi-kicker"><i class="fas fa-film"></i> Vidéos</p>
      <h2 class="gxi-h2">{{ $gxiNom }} <em>en images</em></h2>
    </div>
    <div class="gxi-videos">
      @foreach ($gxiVideos as $video)
        <article class="gxi-video">
          <div class="gxi-cadre">
            <iframe src="{{ $video['lecteur'] }}" title="{{ $video['titre'] ?: 'Vidéo' }}" loading="lazy"
                    allow="accelerometer; encrypted-media; picture-in-picture" allowfullscreen></iframe>
          </div>
          <div class="gxi-video-corps">
            <h3>{{ $video['titre'] ?: 'Vidéo' }}</h3>
            @if ($video['texte'] !== '')
              <p>{{ \Illuminate\Support\Str::limit($video['texte'], 110) }}</p>
            @endif
            @if ($video['page'] !== '')
              <a class="gxi-voir" href="{{ $video['page'] }}" target="_blank" rel="noopener">
                <i class="fas fa-arrow-up-right-from-square"></i> Voir la vidéo
              </a>
            @endif
          </div>
        </article>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- ══ GALERIE ═══════════════════════════════════════════════════════ --}}
@if ($gxiMedias->isNotEmpty())
<section class="gxi-sec gxi-sec--sable" id="gxi-galerie">
  <div class="gxi-wrap">
    <div class="gxi-head">
      <p class="gxi-kicker"><i class="fas fa-images"></i> Galerie</p>
      <h2 class="gxi-h2">Quelques <em>instants</em></h2>
    </div>
    <div class="gxi-mosaique">
      @foreach ($gxiMedias->take(12) as $i => $media)
        @php $gxiLegende = $gxiTitreMedia($media); @endphp
        <figure class="gxi-vue{{ $i === 0 ? ' gxi-vue--large' : '' }}">
          <img src="{{ $gxiImage($media) }}" alt="{{ $gxiLegende ?: $gxiNom }}" loading="lazy" decoding="async">
          @if ($gxiLegende !== '')<figcaption>{{ $gxiLegende }}</figcaption>@endif
        </figure>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- ══ ACTUALITÉS (onglet Blog) ══════════════════════════════════════ --}}
@if ($gxiArticles->isNotEmpty())
<section class="gxi-sec" id="gxi-blog">
  <div class="gxi-wrap">
    <div class="gxi-head">
      <p class="gxi-kicker"><i class="fas fa-rss"></i> Actualités</p>
      <h2 class="gxi-h2">Les dernières <em>nouvelles</em></h2>
    </div>
    <div class="gxi-grille gxi-grille--3">
      @foreach ($gxiArticles as $article)
        @php
          $gxiArtImage = ProductPresenter::url($article->featured_image ?? $article->image ?? null);
          $gxiArtUrl = route('cms.company.blog.show', ['etablissementId' => $etablissement->id, 'slug' => $article->slug]);
          $gxiArtResume = trim(strip_tags((string) ($article->excerpt ?: $article->content)));
        @endphp
        <article class="gxi-carte">
          <a class="gxi-carte-media" href="{{ $gxiArtUrl }}" target="_top">
            @if ($article->published_at)
              <span class="gxi-badge">{{ $article->published_at->translatedFormat('j M Y') }}</span>
            @endif
            @if ($gxiArtImage)
              <img src="{{ $gxiArtImage }}" alt="{{ $article->title }}" loading="lazy" decoding="async">
            @endif
          </a>
          <div class="gxi-carte-corps">
            <a class="gxi-carte-nom" href="{{ $gxiArtUrl }}" target="_top">{{ $article->title }}</a>
            @if ($gxiArtResume !== '')
              <p class="gxi-carte-texte">{{ \Illuminate\Support\Str::limit($gxiArtResume, 130) }}</p>
            @endif
            <div class="gxi-carte-pied">
              <a class="gxi-voir" style="color:var(--gxi-bleu)" href="{{ $gxiArtUrl }}" target="_top">Lire l'article <i class="fas fa-arrow-right"></i></a>
            </div>
          </div>
        </article>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- ══ À PROXIMITÉ ═══════════════════════════════════════════════════ --}}
@if ($gxiProximite->isNotEmpty())
@php
  $gxiGroupes = $gxiProximite->pluck('groupe')->unique()->values();
  $gxiNomsGroupes = ['resto' => 'Restaurants', 'hebergement' => 'Hébergements', 'evenement' => 'Événements',
                     'activite' => 'Activités', 'culture' => 'Culture', 'nature' => 'Nature',
                     'shopping' => 'Boutiques', 'autre' => 'Autres'];
@endphp
<section class="gxi-sec gxi-sec--sable" id="gxi-proximite">
  <div class="gxi-wrap">
    <div class="gxi-head">
      <p class="gxi-kicker"><i class="fas fa-location-crosshairs"></i> Autour</p>
      <h2 class="gxi-h2">À <em>proximité</em></h2>
      <p class="gxi-lead">Les lieux de la carte GoExploria situés autour de l'établissement, du plus proche au plus lointain.</p>
    </div>
    @if ($gxiGroupes->count() > 1)
      <div class="gxi-filtres" role="toolbar" aria-label="Filtrer par catégorie">
        <button type="button" class="gxi-filtre est-actif" data-gxi-filtre="tous">Tout</button>
        @foreach ($gxiGroupes as $g)
          <button type="button" class="gxi-filtre" data-gxi-filtre="{{ $g }}">{{ $gxiNomsGroupes[$g] ?? ucfirst($g) }}</button>
        @endforeach
      </div>
    @endif
    <div class="gxi-grille gxi-grille--3" data-gxi-proches>
      @foreach ($gxiProximite as $lieu)
        <a class="gxi-carte gxi-proche" data-categorie="{{ $lieu['groupe'] }}" href="{{ $lieu['lien'] }}" target="_top">
          <span class="gxi-carte-media">
            @if ($lieu['categorie'])<span class="gxi-badge">{{ $lieu['categorie'] }}</span>@endif
            <img src="{{ $lieu['image'] }}" alt="{{ $lieu['titre'] }}" loading="lazy" decoding="async">
          </span>
          <span class="gxi-carte-corps">
            <span class="gxi-carte-nom">{{ $lieu['titre'] }}</span>
            <span class="gxi-carte-pied">
              @if ($lieu['ville'])<span class="gxi-carte-texte"><i class="fas fa-location-dot"></i> {{ $lieu['ville'] }}</span>@endif
              <span class="gxi-distance">{{ $lieu['distance'] }}</span>
            </span>
          </span>
        </a>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- ══ GOEXPLORIA — le discours de la plateforme, signé comme tel ════
     ⚠ Cette section parle de GoExploria, pas de l'établissement. C'est la
     seule du gabarit dont le contenu n'est pas tiré de ses données ; elle
     l'annonce en toutes lettres, et c'est la condition pour qu'elle soit
     honnête sur le site d'une entreprise qui n'a rien signé.
     ══════════════════════════════════════════════════════════════════════ --}}
<section class="gxi-sec gxi-sec--nuit" id="gxi-goexploria">
  <div class="gxi-wrap">
    <div class="gxi-head gxi-head--centre">
      <p class="gxi-kicker"><i class="fas fa-handshake"></i> Message de GoExploria</p>
      <h2 class="gxi-h2">Cette page est publiée par <em>GoExploria</em></h2>
      <p class="gxi-lead">
        {{ $gxiNom }} figure dans notre annuaire touristique et d'affaires.
        Vous dirigez cet établissement&nbsp;? Activez votre Espace Entreprise pour
        reprendre la main sur cette page, y publier vos offres, vos photos et vos
        disponibilités.
      </p>
      <div class="gxi-actions" style="justify-content:center">
        <a class="gxi-btn gxi-btn--ambre" href="{{ $gxiDevis }}" target="_top"><i class="fas fa-rocket"></i> Activer mon espace</a>
        <a class="gxi-btn gxi-btn--ligne" href="#gxi-contact">Poser une question</a>
      </div>
    </div>

    @if ($gxiPlans->isNotEmpty())
      <div class="gxi-grille gxi-grille--3" style="margin-top:14px">
        @foreach ($gxiPlans->take(3) as $plan)
          <article class="gxi-carte" style="background:rgba(255,255,255,.06);border-color:rgba(255,255,255,.14);box-shadow:none">
            <div class="gxi-carte-corps" style="color:#fff">
              @if ($plan->icon)<i class="{{ $plan->icon }}" style="font-size:1.4rem;color:var(--gxi-ambre-clair)"></i>@endif
              <span class="gxi-carte-nom">{{ $plan->name }}</span>
              @if ($plan->description)
                <p class="gxi-carte-texte" style="color:rgba(255,255,255,.72)">{{ \Illuminate\Support\Str::limit(strip_tags((string) $plan->description), 120) }}</p>
              @endif
              @if ($plan->price)
                <div class="gxi-carte-pied">
                  <span class="gxi-prix" style="color:#fff">{{ $plan->price }} {{ $plan->currency ?: '$' }}</span>
                  <a class="gxi-btn gxi-btn--ambre" style="padding:9px 16px;font-size:.85rem" href="{{ $gxiDevis }}" target="_top">Choisir</a>
                </div>
              @endif
            </div>
          </article>
        @endforeach
      </div>
    @endif

    <div class="gxi-tuiles" style="margin-top:22px">
      @foreach ([
        ['fa-map-location-dot', 'Espace destination', 'Visibilité géociblée, locale et internationale.'],
        ['fa-building', 'Espace entreprise', 'Vos offres, vos médias, vos réservations.'],
        ['fa-film', 'Chaîne vidéos', 'Vos vidéos rassemblées et mises en avant.'],
        ['fa-envelope-open-text', 'Mail marketing', 'Écrivez à vos clients depuis votre espace.'],
      ] as [$gxiIc, $gxiT, $gxiD])
        <div class="gxi-tuile" style="background:rgba(255,255,255,.06);border-color:rgba(255,255,255,.14);color:#fff">
          <i class="fas {{ $gxiIc }}"></i><b>{{ $gxiT }}</b>
          <span style="color:rgba(255,255,255,.7)">{{ $gxiD }}</span>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ══ CONTACT ═══════════════════════════════════════════════════════
     `data-gx-contact` : le site greffe au rendu le pont qui porte l'adresse
     d'envoi et le jeton CSRF, et dépose la demande dans « Messages contact ».
     ⚠ `first_name`, et non `name` : le serveur exige le prénom.
     ══════════════════════════════════════════════════════════════════════ --}}
<section class="gxi-sec gxi-sec--nuit" id="gxi-contact">
  <div class="gxi-wrap gxi-contact">
    <div>
      <p class="gxi-kicker"><i class="fas fa-envelope-open-text"></i> Nous joindre</p>
      <h2 class="gxi-h2">Une question&nbsp;?<br>Écrivez à <em>{{ $gxiNom }}</em></h2>
      <div class="gxi-infos">
        @if ($gxiAdresseComplete)
          <div class="gxi-info"><i class="fas fa-location-dot"></i><div><b>Adresse</b><span>{{ $gxiAdresseComplete }}</span></div></div>
        @endif
        @if ($gxiTelephone)
          <div class="gxi-info"><i class="fas fa-phone"></i><div><b>Téléphone</b><a href="tel:{{ preg_replace('/[^0-9+]/', '', $gxiTelephone) }}">{{ $gxiTelephone }}</a></div></div>
        @endif
        @if ($gxiEmail)
          <div class="gxi-info"><i class="fas fa-envelope"></i><div><b>Courriel</b><a href="mailto:{{ $gxiEmail }}">{{ $gxiEmail }}</a></div></div>
        @endif
        @if ($gxiSite)
          <div class="gxi-info"><i class="fas fa-globe"></i><div><b>Site web</b><a href="{{ $gxiSite }}" target="_blank" rel="noopener nofollow">{{ preg_replace('#^https?://#', '', $gxiSite) }}</a></div></div>
        @endif
      </div>

      @if ($gxiHoraires->isNotEmpty())
        <ul class="gxi-horaires">
          @foreach ($gxiHoraires as $h)
            <li><span>{{ data_get($h, 'day') }}</span><strong>{{ data_get($h, 'hours') }}</strong></li>
          @endforeach
        </ul>
      @endif

      @if ($gxiReseaux->isNotEmpty())
        <div class="gxi-pied-social">
          @foreach ($gxiReseaux as $reseau => $url)
            <a href="{{ $url }}" target="_blank" rel="noopener nofollow" aria-label="{{ ucfirst($reseau) }}">
              <i class="fab fa-{{ $reseau === 'twitter' ? 'x-twitter' : $reseau }}"></i>
            </a>
          @endforeach
        </div>
      @endif
    </div>

    <form class="gxi-form" data-gx-contact="contact_interne"
          data-gx-contact-sujet="Message depuis la page {{ $gxiNom }}"
          method="post" action="#gxi-contact">
      <div class="gxi-form-ligne">
        <input type="text" name="first_name" placeholder="Prénom" aria-label="Prénom" autocomplete="given-name" required>
        <input type="text" name="last_name" placeholder="Nom" aria-label="Nom" autocomplete="family-name">
      </div>
      <input type="email" name="email" placeholder="Votre courriel" aria-label="Votre courriel" autocomplete="email" required>
      <input type="text" name="subject" placeholder="Sujet" aria-label="Sujet">
      <textarea name="message" placeholder="Votre message" aria-label="Votre message" required></textarea>
      <div data-gx-contact-statut role="status" aria-live="polite"></div>
      <button type="submit" class="gxi-btn gxi-btn--ambre"><i class="fas fa-paper-plane"></i> Envoyer</button>
    </form>
  </div>
</section>

{{-- ══ FICHE D'UN BIEN — reçoit du site le formulaire et le calendrier ═ --}}
@if ($gxiHebergements->isNotEmpty() || $gxiForfaits->isNotEmpty() || $gxiVehicules->isNotEmpty())
<div class="gxi-fiche" data-im-detail aria-hidden="true">
  <div class="gxi-fiche-panneau" role="dialog" aria-modal="true" aria-label="Fiche détaillée">
    <div class="gxi-fiche-tete">
      <div>
        <span class="gxi-carte-sur" data-im-d-badge>Séjour</span>
        <h3 data-im-d-title>Titre</h3>
        <p class="gxi-carte-texte" data-im-d-loc></p>
      </div>
      <button type="button" class="gxi-fiche-fermer" data-im-d-close aria-label="Fermer la fiche">×</button>
    </div>
    <div class="gxi-fiche-corps im-detail-body">
      <img data-im-d-photo src="" alt="" hidden>
      <div class="gxi-prix" data-im-d-price>Sur demande</div>
      <div class="gxi-specs">
        <span data-im-d-spec hidden></span><span data-im-d-spec hidden></span>
        <span data-im-d-spec hidden></span><span data-im-d-spec hidden></span>
      </div>
      <p class="gxi-carte-texte" data-im-d-description></p>
      <div class="gxi-equip" data-im-d-amenities></div>
    </div>
  </div>
</div>
@endif

{{-- ══ PIED ══════════════════════════════════════════════════════════ --}}
<footer class="gxi-pied">
  <div class="gxi-pied-grille">
    <div>
      <a href="#gxi-haut" class="gxi-logo" style="color:#fff">
        @if ($gxiLogo)<img src="{{ $gxiLogo }}" alt="">@endif
        <span>{{ $gxiNom }}</span>
      </a>
      @if ($gxiDescription !== '')
        <p style="margin-top:12px;font-size:.9rem">{{ \Illuminate\Support\Str::limit($gxiDescription, 200) }}</p>
      @endif
      @if ($gxiReseaux->isNotEmpty())
        <div class="gxi-pied-social">
          @foreach ($gxiReseaux as $reseau => $url)
            <a href="{{ $url }}" target="_blank" rel="noopener nofollow" aria-label="{{ ucfirst($reseau) }}">
              <i class="fab fa-{{ $reseau === 'twitter' ? 'x-twitter' : $reseau }}"></i>
            </a>
          @endforeach
        </div>
      @endif
    </div>
    <div>
      <h4>Le site</h4>
      <div class="gxi-pied-liens">
        @foreach ($gxiMenu as $entree)
          <a href="{{ $entree[0] }}">{{ $entree[1] }}</a>
        @endforeach
      </div>
    </div>
    <div>
      <h4>Coordonnées</h4>
      <div class="gxi-pied-liens">
        @if ($gxiAdresseComplete)<span>{{ $gxiAdresseComplete }}</span>@endif
        @if ($gxiTelephone)<a href="tel:{{ preg_replace('/[^0-9+]/', '', $gxiTelephone) }}">{{ $gxiTelephone }}</a>@endif
        @if ($gxiEmail)<a href="mailto:{{ $gxiEmail }}">{{ $gxiEmail }}</a>@endif
      </div>
    </div>
  </div>
  <div class="gxi-pied-bas">
    <span>© {{ date('Y') }} {{ $gxiNom }}</span>
    <span>Page publiée par GoExploria</span>
  </div>
</footer>

{{-- Biens de l'onglet Immobilier pour la fiche (window.GX_IMMO) : même
     source que les cartes ci-dessus, lue par le formulaire de demande, le
     calendrier et le média principal que le site greffe ensuite. --}}
@include('cms::web.fallback.partials.gx-immo-data', ['gxForcerImmo' => true])

<script>
/* ══════════════════════════════════════════════════════════════════════════
   Comportements du gabarit interne.

   Contrairement aux gabarits CMS, CE FICHIER N'EST JAMAIS ENREGISTRÉ : il
   n'existe pas de copie en base, donc aucune des précautions du §5 (ne rien
   écrire dans le DOM) ne s'applique ici. On peut poser des classes et des
   attributs librement.
   ══════════════════════════════════════════════════════════════════════════ */
(function () {
  'use strict';

  var racine = document.querySelector('.{{ \Vendor\Cms\Support\GabaritInterne::ENVELOPPE }}');
  if (!racine) { return; }

  var $  = function (s, p) { return (p || racine).querySelector(s); };
  var $$ = function (s, p) { return Array.prototype.slice.call((p || racine).querySelectorAll(s)); };

  /* ── Tiroir mobile ──────────────────────────────────────────────── */
  var burger = $('[data-gxi-burger]');
  var tiroir = $('#gxi-tiroir');
  if (burger && tiroir) {
    burger.addEventListener('click', function () {
      var ouvert = tiroir.classList.toggle('est-ouvert');
      burger.setAttribute('aria-expanded', String(ouvert));
    });
    $$('a', tiroir).forEach(function (a) {
      a.addEventListener('click', function () {
        tiroir.classList.remove('est-ouvert');
        burger.setAttribute('aria-expanded', 'false');
      });
    });
  }

  /* ── Héros ──────────────────────────────────────────────────────────
     La piste défile par `scrollTo`, et INSTANTANÉMENT : sur un conteneur à
     ancrage, un défilement doux n'avance pas d'un pixel. */
  var piste = $('[data-gxi-piste]');
  if (piste) {
    var diapos  = function () { return $$('.gxi-diapo', piste); };
    var largeur = function () { return piste.clientWidth || 1; };
    var rang    = function () { return Math.round(piste.scrollLeft / largeur()); };
    var points  = $$('[data-gxi-aller]');
    var minuteur = null;

    var aller = function (n) {
      var total = diapos().length;
      if (!total) { return; }
      piste.scrollTo({ left: (((n % total) + total) % total) * largeur() });
    };

    var marquer = function () {
      var r = rang();
      points.forEach(function (p, i) { p.classList.toggle('est-actif', i === r); });
    };

    var relancer = function () {
      window.clearInterval(minuteur);
      if (diapos().length < 2) { return; }
      minuteur = window.setInterval(function () { aller(rang() + 1); }, 7000);
    };

    var prec = $('[data-gxi-prec]'), suiv = $('[data-gxi-suiv]');
    if (prec) { prec.addEventListener('click', function () { aller(rang() - 1); relancer(); }); }
    if (suiv) { suiv.addEventListener('click', function () { aller(rang() + 1); relancer(); }); }
    points.forEach(function (p) {
      p.addEventListener('click', function () {
        aller(parseInt(p.getAttribute('data-gxi-aller'), 10) || 0);
        relancer();
      });
    });

    piste.addEventListener('scroll', function () { window.requestAnimationFrame(marquer); }, { passive: true });
    // Une largeur qui change laisse la piste entre deux diapositives.
    window.addEventListener('resize', function () { aller(rang()); });
    marquer();
    relancer();
  }

  /* ── À proximité : filtres ──────────────────────────────────────── */
  var filtres = $$('[data-gxi-filtre]');
  if (filtres.length) {
    filtres.forEach(function (bouton) {
      bouton.addEventListener('click', function () {
        var cle = bouton.getAttribute('data-gxi-filtre');
        filtres.forEach(function (b) { b.classList.toggle('est-actif', b === bouton); });
        $$('.gxi-proche').forEach(function (carte) {
          carte.hidden = cle !== 'tous' && carte.getAttribute('data-categorie') !== cle;
        });
      });
    });
  }

  /* ── Fiche d'un bien ────────────────────────────────────────────────
     Les données viennent de `window.GX_IMMO`, posé par gx-immo-data — la
     même liste que les cartes. Le formulaire de demande, le calendrier de
     disponibilités et le média principal sont greffés PAR LE SITE dans
     `.im-detail-body`, d'après `data-im-detail-id`. */
  var fiche = $('[data-im-detail]');

  function bien(id) {
    var liste = (window.GX_IMMO && window.GX_IMMO.properties) || [];
    for (var i = 0; i < liste.length; i++) {
      if (String(liste[i].id) === String(id)) { return liste[i]; }
    }
    return null;
  }

  function poser(sel, valeur) {
    var el = $(sel, fiche);
    if (!el) { return; }
    el.textContent = valeur == null ? '' : String(valeur);
    el.hidden = (valeur == null || valeur === '');
  }

  function ouvrir(id) {
    if (!fiche) { return; }
    var b = bien(id);
    if (!b) { return; }

    fiche.setAttribute('data-im-detail-id', String(b.id));
    poser('[data-im-d-title]', b.title);
    poser('[data-im-d-loc]', [b.area, b.city].filter(Boolean).join(' · '));
    poser('[data-im-d-badge]', b.type || 'Bien');
    poser('[data-im-d-price]', b.priceLabel || (b.price ? b.price + ' ' + (b.currency || '$') : 'Sur demande'));
    poser('[data-im-d-description]', b.description || '');

    var photo = $('[data-im-d-photo]', fiche);
    var image = b.cover || (b.gallery && b.gallery[0]) || '';
    if (photo) {
      photo.src = image || '';
      photo.alt = b.title || '';
      photo.hidden = !image;
    }

    var valeurs = [
      b.capacity ? b.capacity + ' voyageurs' : '',
      b.bedrooms ? b.bedrooms + ' chambres' : '',
      b.bathrooms ? b.bathrooms + ' salles d\'eau' : '',
      b.reference ? 'Réf. ' + b.reference : ''
    ];
    $$('[data-im-d-spec]', fiche).forEach(function (el, i) {
      el.textContent = valeurs[i] || '';
      el.hidden = !valeurs[i];
    });

    var equip = $('[data-im-d-amenities]', fiche);
    if (equip) {
      equip.textContent = '';
      (b.amenities || []).forEach(function (a) {
        var s = document.createElement('span');
        s.textContent = a;
        equip.appendChild(s);
      });
    }

    fiche.classList.add('est-ouverte');
    fiche.setAttribute('aria-hidden', 'false');
    signaler('gx:overlay-open');
  }

  function fermer() {
    if (!fiche) { return; }
    signaler('gx:overlay-close');
    fiche.classList.remove('est-ouverte');
    fiche.setAttribute('aria-hidden', 'true');
    fiche.removeAttribute('data-im-detail-id');
  }

  /* Le site est rendu DANS une iframe haute comme son contenu : un calque
     `position:fixed` s'y centre au milieu de la PAGE, pas de l'écran, et
     s'ouvre donc très loin sous le visiteur. Le pont parent-enfant sait le
     recaler sur la bande réellement visible — encore faut-il l'en informer.

     ⚠ CONTRAT STRICT, qui échoue en silence : le nom porte un TIRET
     (`gx:overlay-open`), l'événement part de `window`, et la charge utile
     s'appelle `element`. Hors iframe, personne n'écoute. */
  function signaler(nom) {
    if (!fiche) { return; }
    try {
      window.dispatchEvent(new CustomEvent(nom, { detail: { element: fiche } }));
    } catch (e) { /* sans CustomEvent : le calque reste utilisable */ }
  }

  racine.addEventListener('click', function (e) {
    var cible = e.target;
    if (!cible || !cible.closest) { return; }

    var lien = cible.closest('[data-im-open]');
    if (lien) {
      e.preventDefault();
      ouvrir(lien.getAttribute('data-im-open'));
      return;
    }

    if (fiche && (cible.closest('[data-im-d-close]') || cible === fiche)) {
      e.preventDefault();
      fermer();
    }
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') { fermer(); }
  });
})();
</script>
</div>
</body>
</html>
