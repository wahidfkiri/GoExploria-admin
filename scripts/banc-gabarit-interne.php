<?php
/**
 * LE GABARIT INTERNE TIENT-IL DEBOUT ?
 *
 * Le site des établissements importés n'est pas une copie en base : ce sont
 * deux fichiers du dépôt, lus à chaque rendu.
 *
 *     packages/vendor/cms/resources/gabarit-interne/code.html
 *     public/vendor/cms/gabarit-interne/code.css
 *
 * Ce banc vérifie ce qui casse en silence quand on les remplace :
 *
 *   · les deux fichiers sont là et lisibles ;
 *   · le découpage des `<link>` ne perd ni ne duplique rien ;
 *   · la vue produit un document VALIDE, avec le `</body>` sans lequel le
 *     site ne greffe plus ni panier, ni formulaire, ni carte ;
 *   · les 38 sections du gabarit sont toutes là ;
 *   · les repères dont dépendent les hydrateurs et les greffes sont intacts.
 *
 *   php scripts/banc-gabarit-interne.php
 */
$racine = dirname(__DIR__);
require $racine . '/vendor/autoload.php';
$app = require $racine . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Vendor\Cms\Support\GabaritInterne;

/* Base d'essai : un fichier SQLite partagé par les deux connexions. La vue ne
   touche la base que pour le nom du site et les biens de l'onglet Immobilier. */
$fichier = sys_get_temp_dir() . '/banc_gxi_' . getmypid() . '.sqlite';
@unlink($fichier);
touch($fichier);
$sq = ['driver' => 'sqlite', 'database' => $fichier, 'prefix' => '', 'foreign_key_constraints' => false];
config(['database.default' => 'mysql', 'database.connections.mysql' => $sq, 'database.connections.cms' => $sq]);
DB::purge('mysql');
DB::purge('cms');

Schema::create('etablissements', function (Blueprint $t) {
    $t->id();
    $t->string('name')->nullable();
    $t->string('slug')->nullable();
    $t->string('adresse')->nullable();
    $t->string('ville')->nullable();
    $t->string('zip_code')->nullable();
    $t->string('phone')->nullable();
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

$ok = 0;
$ko = 0;
$dire = function (string $quoi, bool $bon, string $detail = '') use (&$ok, &$ko) {
    $bon ? $ok++ : $ko++;
    printf("  [%s] %-58s %s\n", $bon ? 'ok' : 'KO', $quoi, $detail);
};

/* ── 1. LES DEUX FICHIERS ────────────────────────────────────────────── */
echo "\n1. Les deux fichiers du gabarit\n";

$source = GabaritInterne::source();
$dire('le gabarit est lisible', $source !== '', number_format(strlen($source), 0, ',', ' ') . ' octets');

$feuille = $racine . '/public/vendor/cms/gabarit-interne/code.css';
$dire('la feuille est en place', is_file($feuille),
    is_file($feuille) ? number_format(filesize($feuille), 0, ',', ' ') . ' octets' : 'MANQUANTE');
$dire('la feuille est horodatée', (bool) preg_match('/\?v=\d{6,}$/', GabaritInterne::feuille()), GabaritInterne::feuille());

if ($source === '') {
    echo "\nLe gabarit est introuvable : le reste n'a pas de sens.\n";
    @unlink($fichier);
    exit(1);
}

/* ── 2. LE DÉCOUPAGE DES `<link>` ────────────────────────────────────── */
echo "\n2. Les feuilles de tête remontent dans le <head>\n";

$decoupe = GabaritInterne::decouper($source);
$dire('des liens ont été extraits', trim($decoupe['liens']) !== '',
    substr_count($decoupe['liens'], '<link') . ' lien(s) uniques');
$dire('les doublons sont écartés',
    substr_count($decoupe['liens'], '<link') < substr_count($source, '<link'),
    substr_count($source, '<link') . ' dans le fichier');
$dire('le corps ne commence plus par un <link>', ! str_starts_with(ltrim($decoupe['corps']), '<link'));
$dire('le corps commence par l\'enveloppe du gabarit',
    str_starts_with(ltrim($decoupe['corps']), '<div class="' . GabaritInterne::ENVELOPPE . '"'),
    substr(ltrim($decoupe['corps']), 0, 32));
$dire('rien n\'a été perdu du corps',
    strlen($decoupe['corps']) > strlen($source) - 2000,
    'écart ' . (strlen($source) - strlen($decoupe['corps'])) . ' octets');

/* ── 3. LE DOCUMENT RENDU ────────────────────────────────────────────── */
echo "\n3. Le document que voit le navigateur\n";

try {
    // Le contenu arrive hydraté par le contrôleur ; ici on passe la source
    // telle quelle : c'est l'ENVELOPPE qu'on teste, pas les hydrateurs.
    $html = view('cms::web.interne.gabarit', [
        'etablissement' => $etablissement,
        'contenu' => $source,
    ])->render();
    $dire('la vue se rend', true, number_format(strlen($html), 0, ',', ' ') . ' octets');
} catch (\Throwable $e) {
    $dire('la vue se rend', false, get_class($e) . ' : ' . $e->getMessage());
    echo $e->getTraceAsString() . "\n";
    @unlink($fichier);
    exit(1);
}

$dire('doctype présent', str_starts_with(ltrim($html), '<!DOCTYPE html>'));
$dire('⚠ </body> présent (sinon aucune greffe)', str_contains($html, '</body>'));
$dire('viewport déclaré', str_contains($html, 'width=device-width'));
$dire('le titre est celui de l\'établissement', str_contains($html, '<title>Auberge du Banc</title>'));
$dire('la feuille du gabarit est liée', str_contains($html, 'gabarit-interne/code.css'));
$dire('les polices sont dans le <head>',
    strpos($html, 'fonts.googleapis.com') < strpos($html, '</head>'));
$dire('l\'enveloppe du gabarit est dans le <body>',
    strpos($html, 'class="' . GabaritInterne::ENVELOPPE . '"') > strpos($html, '<body>'));

/* ── 4. TOUTES LES SECTIONS ──────────────────────────────────────────── */
echo "\n4. Les sections du gabarit\n";

$sections = [
    'hz-hero' => 'héros', 'hz-lieux' => 'carte', 'hz-partenaires' => 'partenaires',
    'hz-univers' => 'univers', 'hz-apropos' => 'à propos', 'hz-chiffres' => 'chiffres',
    'hz-boutique' => 'boutique', 'hz-vidette' => 'restaurants vedettes',
    'hebergement-vedette' => 'hébergements vedettes', 'evenements-vedette' => 'événements vedettes',
    'destination-vedette' => 'destinations vedettes', 'produit-vedette-evenement' => 'produits vedettes',
    'hz-forfaits-motoneige' => 'forfaits motoneige', 'hz-hebergements' => 'hébergements',
    'hz-forfaits' => 'forfaits', 'hz-vehicules' => 'location', 'hz-activites' => 'activités',
    'hz-agenda' => 'agenda', 'hz-videos' => 'vidéos', 'hz-services' => 'services',
    'go-tik-tok' => 'Go-Tik-Tok', 'hz-galerie' => 'galerie', 'hz-espaces' => 'espaces',
    'hz-tarifs' => 'tarifs', 'vp-chaine' => 'MyTube', 'hz-equipe' => 'équipe',
    'hz-avis' => 'avis', 'hz-faq' => 'FAQ', 'hz-proximite' => 'à proximité',
    'hz-appel' => 'bandeau d\'appel', 'hz-outils' => 'préparez votre séjour',
    'hz-paiement' => 'paiement', 'hz-appli' => 'application', 'hz-contact' => 'contact',
];

$manquantes = [];
foreach ($sections as $id => $nom) {
    if (! str_contains($html, 'id="' . $id . '"')) {
        $manquantes[] = $nom;
    }
}
$dire(count($sections) . ' sections présentes', $manquantes === [],
    $manquantes === [] ? '' : 'manquantes : ' . implode(', ', $manquantes));

$dire('un en-tête <nav> et un pied <footer>',
    substr_count($html, '<nav') >= 1 && substr_count($html, '<footer') >= 1);

/* ── 5. LES REPÈRES ──────────────────────────────────────────────────── */
echo "\n5. Les repères des hydrateurs et des greffes\n";

$reperes = [
    'data-gx-bind' => 'nom, téléphone, adresse (TemplateDataBinder)',
    'data-gx-products' => 'catalogue (TemplateProducts)',
    'data-gx-categories' => 'rayons (TemplateCategories)',
    'data-gx-activities' => 'activités (TemplateActivities)',
    'data-gx-forfaits' => 'forfaits (TemplateForfaits)',
    'data-gx-nearby' => 'à proximité (TemplateNearby)',
    'data-gx-map' => 'carte Maps Vidéos (injectLandingMap)',
    'data-gx-contact' => 'formulaire de contact (gx-contact-form)',
    'data-im-detail' => 'fiche d\'un bien (gx-immo-request + calendrier)',
    'data-im-grid' => 'grilles de biens (window.GX_IMMO)',
    'data-gx-video' => 'lecteurs vidéo',
    'data-gx-filters' => 'barres de filtres',
];
foreach ($reperes as $repere => $quoi) {
    $dire('« ' . $repere .' » → ' . $quoi, str_contains($html, $repere));
}

$dire('les biens sont publiés pour la fiche (GX_IMMO)',
    str_contains($html, 'GX_IMMO') || str_contains($html, 'gxImmo'),
    'partial gx-immo-data');

/* ── 6. LES PIÈGES DE L'IFRAME ───────────────────────────────────────── */
echo "\n6. Le site est rendu dans une iframe\n";

/* Une hauteur en `vh` s'emballe dans une iframe dimensionnée à la hauteur de
   son contenu : `1vh` y vaut toute la page, et la page atteignait 86 000 px.
   Le gabarit en contient (le héros), comme la version installée — ce n'est
   pas une faute, À CONDITION que le pont enfant soit là pour les borner.
   C'est lui qu'on vérifie : sans sa conversion, ces `vh` redeviennent un
   défaut d'affichage. */
$css = is_file($feuille) ? (string) file_get_contents($feuille) : '';
preg_match_all('/[:,(]\s*[\d.]+vh\b/', (string) preg_replace('#/\*.*?\*/#s', '', $css), $vh);
$pont = $racine . '/packages/vendor/cms/src/Views/web/embed/partials/child-bridge.blade.php';
$convertit = is_file($pont) && str_contains((string) file_get_contents($pont), 'UNITES_ECRAN');
$dire('les ' . count($vh[0]) . ' hauteurs en vh sont bornées par le pont', $convertit,
    $convertit ? 'child-bridge convertit vh → pixels d\'écran' : 'PONT SANS CONVERSION');

/* Lecture automatique : on ne regarde QUE les balises, pas les scripts — le
   lecteur partagé contient la chaîne « autoplay=1 » dans du code qui ne
   s'exécute qu'au clic du visiteur. */
preg_match_all('/<iframe\b[^>]*\bsrc="([^"]*)"[^>]*>/i', $html, $cadres);
$cadresSonores = array_filter($cadres[1], fn ($src) => str_contains($src, 'autoplay=1') && ! str_contains($src, 'mute=1'));
$dire('aucune iframe ne démarre avec le son', $cadresSonores === [],
    count($cadres[1]) . ' lecteur(s) examiné(s)');

preg_match_all('/<video\b[^>]*>/i', $html, $videos);
$videosSonores = array_filter($videos[0], fn ($t) => str_contains($t, 'autoplay') && ! str_contains($t, 'muted'));
$dire('aucune vidéo ne démarre avec le son', $videosSonores === [],
    count($videos[0]) . ' vidéo(s) examinée(s)');

@unlink($fichier);

echo "\n" . str_repeat('─', 76) . "\n";
printf("%d vérification(s) passée(s), %d en échec\n", $ok, $ko);
exit($ko === 0 ? 0 : 1);
