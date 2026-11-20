<?php
/**
 * Le gabarit interne se rend-il vraiment ?
 *
 * On ne teste pas le contrôleur (il faudrait toute la base) mais LA VUE, qui
 * est le livrable : un établissement sans le moindre module, puis le même
 * avec un produit, un bien, un article, une photo et un lieu voisin.
 *
 * Ce qu'on vérifie :
 *   · la vue se rend sans erreur dans les deux cas ;
 *   · un site sans données n'affiche AUCUNE section vide ;
 *   · les repères dont dépendent les greffes du site sont présents ;
 *   · rien de la démonstration ne subsiste (pas de prix inventé, pas d'avis).
 */
$racine = dirname(__DIR__);
require $racine . '/vendor/autoload.php';
$app = require $racine . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

$fichier = sys_get_temp_dir() . '/banc_gxi_' . getmypid() . '.sqlite';
@unlink($fichier);
touch($fichier);
$sq = ['driver' => 'sqlite', 'database' => $fichier, 'prefix' => '', 'foreign_key_constraints' => false];
config(['database.default' => 'mysql', 'database.connections.mysql' => $sq, 'database.connections.cms' => $sq]);
DB::purge('mysql');
DB::purge('cms');

/* Les seules tables que la vue et ses aides touchent réellement. */
Schema::create('etablissements', function (Blueprint $t) {
    $t->id();
    $t->string('name')->nullable();
    $t->string('slug')->nullable();
    $t->string('lname')->nullable();
    $t->string('adresse')->nullable();
    $t->string('ville')->nullable();
    $t->string('zip_code')->nullable();
    $t->string('phone')->nullable();
    $t->string('email')->nullable();
    $t->string('email_contact')->nullable();
    $t->string('website')->nullable();
    $t->boolean('is_active')->default(true);
    $t->boolean('site_interne')->default(false);
    $t->unsignedBigInteger('ville_id')->nullable();
    $t->softDeletes();
    $t->timestamps();
});
Schema::create('cms_settings', function (Blueprint $t) {
    $t->id();
    $t->unsignedBigInteger('etablissement_id')->nullable();
    $t->string('group')->nullable();
    $t->string('key')->nullable();
    $t->text('value')->nullable();
    $t->timestamps();
});

DB::table('etablissements')->insert([
    'id' => 1, 'name' => 'Auberge du Banc', 'slug' => 'auberge-du-banc',
    'adresse' => '12 rue du Quai', 'ville' => 'Baie-Saint-Paul', 'zip_code' => 'G3Z 1A1',
    'phone' => '418 555 0100', 'email_contact' => 'info@exemple.ca',
    'is_active' => 1, 'site_interne' => 1,
]);

$etablissement = \App\Models\Etablissement::find(1);

$ok = 0; $ko = 0;
$dire = function (string $quoi, bool $bon, string $detail = '') use (&$ok, &$ko) {
    $bon ? $ok++ : $ko++;
    printf("  [%s] %-56s %s\n", $bon ? 'ok' : 'KO', $quoi, $detail);
};

$vides = [
    'etablissement' => $etablissement,
    'sliders' => collect(), 'galleryMedia' => collect(), 'brandLogoUrl' => '',
    'plans' => collect(), 'activities' => collect(), 'workingHours' => [],
    'socialLinks' => [], 'blogPosts' => collect(), 'videoChannelVideos' => collect(),
    'devisUrl' => 'https://exemple.test/devis',
    'rayons' => collect(), 'produits' => collect(), 'activitesModule' => collect(),
    'articles' => collect(), 'proximite' => collect(),
    'hebergements' => collect(), 'forfaits' => collect(), 'vehicules' => collect(),
];

/* ── 1. Établissement NU ─────────────────────────────────────────────── */
echo "\n1. Établissement sans aucun module\n";
try {
    $html = view('cms::web.interne.gabarit', $vides)->render();
    $dire('la vue se rend', true, strlen($html) . ' octets');
} catch (\Throwable $e) {
    $dire('la vue se rend', false, get_class($e) . ' : ' . $e->getMessage());
    echo $e->getTraceAsString() . "\n";
    @unlink($fichier);
    exit(1);
}

$dire('le document est complet (</body>)', str_contains($html, '</body>'));
$dire('le nom de l\'établissement est affiché', str_contains($html, 'Auberge du Banc'));
$dire('l\'adresse est affichée', str_contains($html, 'Baie-Saint-Paul'));

foreach ([
    'boutique' => 'id="gxi-boutique"',
    'hébergements' => 'id="gxi-hebergements"',
    'forfaits' => 'id="gxi-forfaits"',
    'location' => 'id="gxi-vehicules"',
    'activités' => 'id="gxi-activites"',
    'vidéos' => 'id="gxi-videos"',
    'galerie' => 'id="gxi-galerie"',
    'actualités' => 'id="gxi-blog"',
    'à proximité' => 'id="gxi-proximite"',
] as $nom => $repere) {
    $dire("section « $nom » absente quand il n'y a rien", ! str_contains($html, $repere));
}

$dire('carte et contact restent (toujours vraies)',
    str_contains($html, 'id="gxi-carte"') && str_contains($html, 'id="gxi-contact"'));

/* Les repères sans lesquels les greffes du site ne font rien. */
foreach (['data-gx-map', 'data-gx-contact', 'data-gx-contact-statut'] as $repere) {
    $dire("repère « $repere » présent", str_contains($html, $repere));
}
$dire('fiche de bien absente sans aucun bien', ! str_contains($html, 'class="gxi-fiche"'));

/* Rien d'inventé sur le dos d'une entreprise réelle. */
foreach (['12 000', '4,9/5', 'Camille Reynaud', 'Chiens bienvenus', 'Annulation souple',
          'années à recevoir', 'Prestation de base'] as $mensonge) {
    $dire('aucune donnée inventée : « ' . mb_substr($mensonge, 0, 22) . ' »', ! str_contains($html, $mensonge));
}

/* Les commentaires CSS parlent de `100vh` pour expliquer pourquoi on s'en
   passe : on les retire avant de chercher une VRAIE déclaration. */
$sansCommentaires = preg_replace('#/\*.*?\*/#s', '', $html);
$dire('aucune hauteur en vh (iframe)', ! preg_match('/[:,(]\s*[\d.]+vh\b/', $sansCommentaires));
$dire('la vue déclare le viewport', str_contains($html, 'width=device-width'));

/* ── 2. Établissement GARNI ──────────────────────────────────────────── */
echo "\n2. Le même avec un produit, un bien, un article, une photo, un voisin\n";

$produit = (new \App\Models\Product())->forceFill([
    'id' => 7, 'name' => 'Panier du terroir', 'price_ttc' => 42.5,
    'description' => 'Produits de la région.',
]);
$produit->setRelation('category', null);

$bien = (new \Vendor\Cms\Models\Property())->forceFill([
    'id' => 3, 'title' => 'Chalet du quai', 'type' => 'Chalet', 'city' => 'Baie-Saint-Paul',
    'price' => 185, 'capacity' => 4, 'bedrooms' => 2,
]);

$article = (new \Vendor\Cms\Models\BlogPost())->forceFill([
    'id' => 11, 'title' => 'Ouverture de la saison', 'slug' => 'ouverture-saison',
    'excerpt' => 'La saison commence.', 'published_at' => now(),
]);

$garni = array_merge($vides, [
    'galleryMedia' => collect([['url' => 'https://exemple.test/a.jpg', 'title' => 'La terrasse']]),
    'workingHours' => [['day' => 'Lundi', 'hours' => '09:00 - 17:00']],
    'socialLinks' => ['facebook' => 'https://facebook.test/x'],
    /* ⚠ LA FORME EXACTE de getLandingVideoChannelItems : `play_url`, et non
       un `video_url` générique. C'est le piège qui vidait la section des
       vidéos sans un mot d'erreur. */
    'videoChannelVideos' => collect([
        ['title' => 'Visite', 'description' => 'En images',
         'play_url' => 'https://www.youtube.com/embed/3SyfpOaNtE0',
         'raw_url' => 'https://www.youtube.com/watch?v=3SyfpOaNtE0',
         'thumbnail' => 'https://i.ytimg.com/vi/3SyfpOaNtE0/hqdefault.jpg'],
    ]),
    'produits' => collect([$produit]),
    'hebergements' => collect([$bien]),
    'articles' => collect([$article]),
    'proximite' => collect([[
        'id' => 5, 'titre' => 'Musée régional', 'categorie' => 'Culture', 'groupe' => 'culture',
        'ville' => 'Baie-Saint-Paul', 'distance' => 'à 1,6 km',
        'image' => 'https://exemple.test/m.jpg', 'lien' => '/company/9',
    ]]),
]);

try {
    $html2 = view('cms::web.interne.gabarit', $garni)->render();
    $dire('la vue se rend', true, strlen($html2) . ' octets');
} catch (\Throwable $e) {
    $dire('la vue se rend', false, get_class($e) . ' : ' . $e->getMessage());
    echo $e->getTraceAsString() . "\n";
    @unlink($fichier);
    exit(1);
}

$dire('la boutique apparaît', str_contains($html2, 'id="gxi-boutique"') && str_contains($html2, 'Panier du terroir'));
$dire('le bouton panier porte son contrat', str_contains($html2, 'data-cms-cart-add'));
$dire('les hébergements apparaissent', str_contains($html2, 'Chalet du quai'));
$dire('la fiche de bien est posée', str_contains($html2, 'data-im-detail'));
$dire('l\'ouverture d\'un bien est câblée', str_contains($html2, 'data-im-open="3"'));
$dire('l\'article apparaît', str_contains($html2, 'Ouverture de la saison'));
$dire('la galerie apparaît', str_contains($html2, 'id="gxi-galerie"'));
$dire('la section vidéos apparaît', str_contains($html2, 'id="gxi-videos"') && str_contains($html2, 'Visite'));
$dire('la vidéo est MUETTE', str_contains($html2, 'mute=1'));
$dire('la vidéo ne démarre pas seule', ! str_contains($html2, 'autoplay=1'));
$dire('les horaires apparaissent', str_contains($html2, '09:00 - 17:00'));
$dire('« à proximité » apparaît', str_contains($html2, 'Musée régional'));
$dire('le menu ne liste que les sections remplies',
    substr_count($html2, 'href="#gxi-boutique"') > 0 && ! str_contains($html2, 'href="#gxi-forfaits"'));

@unlink($fichier);

echo "\n" . str_repeat('─', 72) . "\n";
printf("%d vérification(s) passée(s), %d en échec\n", $ok, $ko);
exit($ko === 0 ? 0 : 1);
