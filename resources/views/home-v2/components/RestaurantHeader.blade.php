{{-- ============================================================
     RESTAURANT SERVICE BLOCK — Standard Template
     GoExploria · Accord Mets & Vins
     Bannière + filtres destination/catégorie + cartes + réservation
     Données mock — dynamisation DB prévue
     ============================================================ --}}

@php
/* ----------------------------------------------------------------
   CONFIG BANNIÈRE (uploadable via admin)
---------------------------------------------------------------- */
$restoConfig = [
    'title'    => 'AMBIANCE RESTO — ACCORD METS ET VIN',
    'subtitle' => 'Entrées · Mets principaux · Desserts · Vins — Découvrez les meilleures tables du Québec sublimées par des accords vins d\'exception.',
    'logo_restaurant' => [
        'src'   => asset('logo.png'),
        'alt'   => 'Logo Restaurant',
        'href'  => '#',
        'label' => 'Logo Restaurant',
    ],
    'logo_accord' => [
        'src'   => asset('home2/aventure-accords-met-vin/accord_mets_vin.jpg'),
        'alt'   => 'Accord Mets & Vins',
        'href'  => route('pages.accord-mets-vins'),
        'label' => 'Accord Mets & Vins',
    ],
];

/* ----------------------------------------------------------------
   ONGLETS CATÉGORIES
   data-cat : valeur utilisée par le filtre JS
---------------------------------------------------------------- */
$restoCats = [
    ['key' => 'toutes',         'label' => 'Toutes les formules'],
    ['key' => 'entrees',        'label' => 'Entrées & Salades'],
    ['key' => 'mets-principaux','label' => 'Plats principaux'],
    ['key' => 'desserts',       'label' => 'Desserts'],
];

/* ----------------------------------------------------------------
   DESTINATIONS (filtre barre)
   data-dest : valeur utilisée par le filtre JS
   'all' = toutes les destinations
---------------------------------------------------------------- */
$restoDests = [
    ['key' => 'all',           'label' => 'Toutes destinations'],
    ['key' => 'amerique-nord', 'label' => 'Amérique du Nord'],
    ['key' => 'canada',        'label' => 'Canada'],
    ['key' => 'quebec',        'label' => 'Québec'],
    ['key' => 'region-quebec', 'label' => 'Région de Québec'],
];

/* ----------------------------------------------------------------
   CAROUSEL PHOTOS (mockable)
---------------------------------------------------------------- */
$carouselSlides = [
    ['img' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=1200&h=420&fit=crop', 'caption' => 'Ambiance & Gastronomie'],
    ['img' => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=1200&h=420&fit=crop', 'caption' => 'Sélection de Vins'],
    ['img' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=1200&h=420&fit=crop', 'caption' => 'Cuisine Raffinée'],
    ['img' => 'https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?w=1200&h=420&fit=crop', 'caption' => "Accord Mets & Vins"],
    ['img' => 'https://images.unsplash.com/photo-1559329007-40df8a9345d8?w=1200&h=420&fit=crop', 'caption' => "Moments d'exception"],
];

/* ----------------------------------------------------------------
   VIDÉO FEATURED (mockable)
---------------------------------------------------------------- */
$restoVideo = [
    'thumbnail'  => 'https://images.unsplash.com/photo-1466978913421-dad2ebd01d17?w=640&h=360&fit=crop',
    'youtube_id' => 'UhR5XQ-FfRo',
    'title'      => "L'art de l'accord parfait",
    'subtitle'   => 'Découvrez notre ambiance en vidéo',
];

/* ----------------------------------------------------------------
   TYPES D'ÉVÉNEMENTS
---------------------------------------------------------------- */
$restoEventTypes = [
    ['key'=>'all',           'label'=>'Tous',                   'icon'=>'fa-calendar-days'],
    ['key'=>'fete-meres',    'label'=>'Fête des mères',         'icon'=>'fa-heart'],
    ['key'=>'fete-peres',    'label'=>'Fête des pères',         'icon'=>'fa-star'],
    ['key'=>'noel',          'label'=>'Noël',                   'icon'=>'fa-snowflake'],
    ['key'=>'jour-an',       'label'=>"Jour de l'an",           'icon'=>'fa-wine-glass'],
    ['key'=>'anniversaires', 'label'=>"Fêtes d'anniversaires",  'icon'=>'fa-cake-candles'],
    ['key'=>'levee-fonds',   'label'=>'Levée de fonds',         'icon'=>'fa-hand-holding-dollar'],
    ['key'=>'acadiens',      'label'=>'Acadiens',               'icon'=>'fa-flag'],
    ['key'=>'irlandais',     'label'=>'Irlandais',              'icon'=>'fa-leaf'],
    ['key'=>'paques',        'label'=>'Pâques',                 'icon'=>'fa-egg'],
];

/* ----------------------------------------------------------------
   CARTES ÉVÉNEMENTS
---------------------------------------------------------------- */
$restoEventCards = [
    ['type'=>'fete-meres',    'badge'=>'Populaire',    'price'=>'75$ / pers.',   'title'=>'Menu Spécial Maman',          'desc'=>'Menu 4 services avec accord vins. Bouquet de fleurs offert à chaque maman.',    'img'=>'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=500&h=280&fit=crop'],
    ['type'=>'fete-meres',    'badge'=>'Exclusif',     'price'=>'145$ / duo',    'title'=>'Forfait Duo Romantique',      'desc'=>'Table privée, bouquet, bouteille de rosé & mets 5 services.',                    'img'=>'https://images.unsplash.com/photo-1559329007-40df8a9345d8?w=500&h=280&fit=crop'],
    ['type'=>'fete-meres',    'badge'=>'Famille',      'price'=>'45$ / pers.',   'title'=>'Brunch Famille',              'desc'=>'Buffet brunch gastronomique pour toute la famille, ambiance chaleureuse.',        'img'=>'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=500&h=280&fit=crop'],
    ['type'=>'fete-peres',    'badge'=>'BBQ',          'price'=>'65$ / pers.',   'title'=>'Grillade & Bière Artisanale', 'desc'=>'Sélection de grillades premium avec accord bières artisanales du Québec.',       'img'=>'https://images.unsplash.com/photo-1544025162-d76694265947?w=500&h=280&fit=crop'],
    ['type'=>'fete-peres',    'badge'=>'Premium',      'price'=>'120$ / pers.',  'title'=>'Dégustation Whisky',          'desc'=>"Menu 4 services avec dégustation de whiskies d'exception et cigares.",          'img'=>'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=500&h=280&fit=crop'],
    ['type'=>'fete-peres',    'badge'=>'Famille',      'price'=>'55$ / pers.',   'title'=>'Barbecue Familial',           'desc'=>'Grande table conviviale, BBQ à volonté, bières et desserts.',                    'img'=>'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=500&h=280&fit=crop'],
    ['type'=>'noel',          'badge'=>'Réveillon',    'price'=>'110$ / pers.',  'title'=>'Réveillon de Noël',           'desc'=>'Menu 5 services, musique live, cotillons et vins millésimés.',                   'img'=>'https://images.unsplash.com/photo-1467810563316-b5476525c0f9?w=500&h=280&fit=crop'],
    ['type'=>'noel',          'badge'=>'Tradition',    'price'=>'75$ / pers.',   'title'=>'Dîner de Noël en Famille',    'desc'=>'Menu traditionnel québécois avec tourtière et bûche maison.',                   'img'=>'https://images.unsplash.com/photo-1543155170-9eb4f10b0fc0?w=500&h=280&fit=crop'],
    ['type'=>'noel',          'badge'=>'Corporate',    'price'=>'50$ / pers.',   'title'=>'Cocktail Noël Corporate',     'desc'=>'Forfait groupe 20+ personnes, bouchées fines & cocktails de saison.',            'img'=>'https://images.unsplash.com/photo-1512389142860-9c449e58a543?w=500&h=280&fit=crop'],
    ['type'=>'jour-an',       'badge'=>'Gala',         'price'=>'150$ / pers.',  'title'=>'Gala Saint-Sylvestre',        'desc'=>'Soirée de gala avec champagne minuit, musique live et menu gastronomique.',      'img'=>'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=500&h=280&fit=crop'],
    ['type'=>'jour-an',       'badge'=>'Festif',       'price'=>'85$ / pers.',   'title'=>'Cocktail Nouvel An',          'desc'=>'Bouchées festives, champagne à minuit, DJ et ambiance festive.',                 'img'=>'https://images.unsplash.com/photo-1467810563316-b5476525c0f9?w=500&h=280&fit=crop'],
    ['type'=>'anniversaires', 'badge'=>'VIP',          'price'=>'95$ / pers.',   'title'=>'Forfait Anniversaire VIP',    'desc'=>'Table décorée, gâteau personnalisé, bouteille de champagne et menu surprise.',   'img'=>'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&h=280&fit=crop'],
    ['type'=>'anniversaires', 'badge'=>'Enfants',      'price'=>'35$ / enfant',  'title'=>'Anniversaire Enfants',        'desc'=>'Menu enfant, gâteau animé, cadeaux surprises et décoration thématique.',         'img'=>'https://images.unsplash.com/photo-1587640478513-6c6ed3ac2e80?w=500&h=280&fit=crop'],
    ['type'=>'anniversaires', 'badge'=>'Groupe',       'price'=>'55$ / pers.',   'title'=>'Soirée Groupe Anniversaire',  'desc'=>'Salle privée pour 15 à 50 personnes, menu banquet et animation.',                'img'=>'https://images.unsplash.com/photo-1527529482837-4698179dc6ce?w=500&h=280&fit=crop'],
    ['type'=>'levee-fonds',   'badge'=>'Gala',         'price'=>'125$ / pers.',  'title'=>'Gala Caritatif',              'desc'=>'Dîner gala avec encan, conférenciers et menu gastronomique.',                    'img'=>'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=500&h=280&fit=crop'],
    ['type'=>'levee-fonds',   'badge'=>'Communauté',   'price'=>'40$ / pers.',   'title'=>'Brunch Bénéfice',             'desc'=>'Brunch communautaire avec musique live et kiosques de dons.',                    'img'=>'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=500&h=280&fit=crop'],
    ['type'=>'acadiens',      'badge'=>'Tradition',    'price'=>'55$ / pers.',   'title'=>'Menu Acadien Traditionnel',   'desc'=>'Fricot, poutine râpée et rappie. Musique acadienne et trad.',                   'img'=>'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=500&h=280&fit=crop'],
    ['type'=>'acadiens',      'badge'=>'Culturel',     'price'=>'65$ / pers.',   'title'=>"Fête Nationale de l'Acadie",  'desc'=>'Célébration du 15 août avec menu festif et animations culturelles.',             'img'=>'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?w=500&h=280&fit=crop'],
    ['type'=>'irlandais',     'badge'=>'St-Patrick',   'price'=>'60$ / pers.',   'title'=>"St. Patrick's Dinner",        'desc'=>"Corned beef, irish stew, Guinness et whisky irlandais.",                         'img'=>'https://images.unsplash.com/photo-1536935338788-846bb9981813?w=500&h=280&fit=crop'],
    ['type'=>'irlandais',     'badge'=>'Pub',          'price'=>'45$ / pers.',   'title'=>'Soirée Pub Irlandais',        'desc'=>'Menu pub avec bières irlandaises, musique live et ambiance festive.',            'img'=>'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=500&h=280&fit=crop'],
    ['type'=>'paques',        'badge'=>'Famille',      'price'=>'55$ / pers.',   'title'=>'Brunch de Pâques',            'desc'=>"Buffet familial avec chasse aux œufs pour les enfants et menu pascal.",          'img'=>'https://images.unsplash.com/photo-1547592180-85f173990554?w=500&h=280&fit=crop'],
    ['type'=>'paques',        'badge'=>'Gastronomique','price'=>'80$ / pers.',   'title'=>'Dîner Pascal Gastronomique',  'desc'=>'Menu 4 services avec agneau pascal et accord vins de saison.',                  'img'=>'https://images.unsplash.com/photo-1476978913421-dad2ebd01d17?w=500&h=280&fit=crop'],
];

/* ----------------------------------------------------------------
   MENU RESTO GRAFFITI — Données du site restaurantgraffiti.com
   cat   : clé du filtre JS  |  sub : sous-catégorie affichée
   badge : classe CSS couleur |  accord : suggestion vin
---------------------------------------------------------------- */
$menuItems = [

    /* ==================== ENTRÉES ==================== */
    ['id'=>1,  'name'=>"Burrata, gelée de tomates, tapenade d'olives et crumble",
     'desc'=>"Huile verte, oignons marinés, pousses de basilic et pain foccacia",
     'price'=>'28 $','sub'=>'Entrées','badge'=>'cat-entrees','cat'=>'entrees',
     'accord'=>'Chablis · Blanc sec',
     'img'=>'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=500&h=300&fit=crop'],

    ['id'=>2,  'name'=>"Polpettes de veau et filet mignon",
     'desc'=>"Sauce tomates maison, pousse de basilic et parmesan",
     'price'=>'19 $','sub'=>'Entrées','badge'=>'cat-entrees','cat'=>'entrees',
     'accord'=>'Chianti Classico',
     'img'=>'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=500&h=300&fit=crop'],

    ['id'=>3,  'name'=>"Poêlée de ris de veau",
     'desc'=>"Champignons marinés au balsamique",
     'price'=>'28 $','sub'=>'Entrées','badge'=>'cat-entrees','cat'=>'entrees',
     'accord'=>'Bourgogne Blanc · Meursault',
     'img'=>'https://images.unsplash.com/photo-1476978913421-dad2ebd01d17?w=500&h=300&fit=crop'],

    ['id'=>4,  'name'=>"Bruschetta au canard confit",
     'desc'=>"Pain à l'ail gratiné au fromage Doré-mi",
     'price'=>'18 $','sub'=>'Entrées','badge'=>'cat-entrees','cat'=>'entrees',
     'accord'=>"Pinot Gris d'Alsace",
     'img'=>'https://images.unsplash.com/photo-1565299507177-b0ac66763828?w=500&h=300&fit=crop'],

    ['id'=>5,  'name'=>"Soupe à l'oignon gratinée au migneron de Charlevoix",
     'desc'=>'',
     'price'=>'15 $','sub'=>'Entrées','badge'=>'cat-entrees','cat'=>'entrees',
     'accord'=>'Chardonnay · Vin blanc sec',
     'img'=>'https://images.unsplash.com/photo-1547592180-85f173990554?w=500&h=300&fit=crop'],

    ['id'=>6,  'name'=>"Tartare de Thon, salsa de mangues, tortillas de maïs",
     'desc'=>"Servi avec salade du marché",
     'price'=>'26 $','sub'=>'Entrées','badge'=>'cat-entrees','cat'=>'entrees',
     'accord'=>'Sauvignon Blanc · Pouilly-Fumé',
     'img'=>'https://images.unsplash.com/photo-1580822184713-fc5400e7fe10?w=500&h=300&fit=crop'],

    ['id'=>7,  'name'=>"Potage de saison au goût du jour",
     'desc'=>'',
     'price'=>'9 $','sub'=>'Entrées','badge'=>'cat-entrees','cat'=>'entrees',
     'accord'=>'Viognier · Blanc fruité',
     'img'=>'https://images.unsplash.com/photo-1547592180-85f173990554?w=500&h=300&fit=crop'],

    ['id'=>8,  'name'=>"Tomate Caprèse",
     'desc'=>"Mozzarella di Bufala, tomate confite au pesto, caramel de balsamique et roquette",
     'price'=>'17 $','sub'=>'Entrées','badge'=>'cat-entrees','cat'=>'entrees',
     'accord'=>'Pinot Grigio · Soave',
     'img'=>'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=500&h=300&fit=crop'],

    ['id'=>9,  'name'=>"Feuilleté de crevettes et pétoncles",
     'desc'=>"Beurre nantais et tombée d'épinards",
     'price'=>'24 $','sub'=>'Entrées','badge'=>'cat-entrees','cat'=>'entrees',
     'accord'=>'Chablis · Blanc de Blancs',
     'img'=>'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=500&h=300&fit=crop'],

    ['id'=>10, 'name'=>"Dégustation de saumon en trois temps",
     'desc'=>"Tartare, gravlax et fumé de la Boucanerie d'Henry",
     'price'=>'24 $','sub'=>'Entrées','badge'=>'cat-entrees','cat'=>'entrees',
     'accord'=>'Sancerre · Sauvignon Blanc',
     'img'=>'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=500&h=300&fit=crop'],

    ['id'=>11, 'name'=>"Escargots crémeux parfumé à l'estragon",
     'desc'=>"Foccacia à l'ail grillé",
     'price'=>'20 $','sub'=>'Entrées','badge'=>'cat-entrees','cat'=>'entrees',
     'accord'=>'Riesling Sec · Alsace',
     'img'=>'https://images.unsplash.com/photo-1476124369491-e7addf5db371?w=500&h=300&fit=crop'],

    ['id'=>12, 'name'=>"Duo d'arancini aux champignons et fondue parmesan",
     'desc'=>"Ketchup maison, roquette",
     'price'=>'19 $','sub'=>'Entrées','badge'=>'cat-entrees','cat'=>'entrees',
     'accord'=>'Soave · Pinot Grigio',
     'img'=>'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=500&h=300&fit=crop'],

    ['id'=>13, 'name'=>"Carpaccio de filet mignon de bœuf",
     'desc'=>"Aïoli maison, citron confit, copeaux de vieux parmesan, câpres, noix de pin, huile de roquette",
     'price'=>'25 $','sub'=>'Entrées','badge'=>'cat-entrees','cat'=>'entrees',
     'accord'=>'Barolo · Nebbiolo',
     'img'=>'https://images.unsplash.com/photo-1580822184713-fc5400e7fe10?w=500&h=300&fit=crop'],

    ['id'=>14, 'name'=>"César",
     'desc'=>"Jambon de parme et parmigiano reggiano — Extra poulet grillé (+7 $)",
     'price'=>'19 $','sub'=>'Salades','badge'=>'cat-entrees','cat'=>'entrees',
     'accord'=>'Pinot Grigio · Blanc sec',
     'img'=>'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=500&h=300&fit=crop'],

    /* ==================== PLATS PRINCIPAUX — Les pâtes & risottos ==================== */
    ['id'=>15, 'name'=>"Risotto Graffiti",
     'desc'=>"Flanc de porc croustillant, tomates fraîches, champignons, fines herbes, crumble de panko, poireaux au beurre, parmesan",
     'price'=>'35 $','sub'=>'Les pâtes & risottos','badge'=>'cat-mets','cat'=>'mets-principaux',
     'accord'=>'Barolo · Nebbiolo',
     'img'=>'https://images.unsplash.com/photo-1476124369491-e7addf5db371?w=500&h=300&fit=crop'],

    ['id'=>16, 'name'=>"Risotto au canard confit",
     'desc'=>"Canneberges, poireaux et mascarpone, fines herbes et parmesan reggiano",
     'price'=>'35 $','sub'=>'Les pâtes & risottos','badge'=>'cat-mets','cat'=>'mets-principaux',
     'accord'=>'Côtes du Rhône · Grenache',
     'img'=>'https://images.unsplash.com/photo-1476124369491-e7addf5db371?w=500&h=300&fit=crop'],

    ['id'=>17, 'name'=>"Raviolis aux champignons sauvages",
     'desc'=>"Noix de pin, tomates, épinard frit, crème, vin blanc et parmesan reggiano",
     'price'=>'29 $','sub'=>'Les pâtes & risottos','badge'=>'cat-mets','cat'=>'mets-principaux',
     'accord'=>'Pinot Noir · Bourgogne',
     'img'=>'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=500&h=300&fit=crop'],

    ['id'=>18, 'name'=>"Gnocchis aux pommes caramélisées",
     'desc'=>"Fromage Haloumi, noix de cajou rôties, tomates fraîches, crème, vin blanc et parmesan",
     'price'=>'29 $','sub'=>'Les pâtes & risottos','badge'=>'cat-mets','cat'=>'mets-principaux',
     'accord'=>'Chardonnay · Viognier',
     'img'=>'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=500&h=300&fit=crop'],

    ['id'=>19, 'name'=>"Linguine Graffiti",
     'desc'=>"Jambon de Parme, champignons, tomates fraîches, vin blanc, crème et parmesan regiano",
     'price'=>'27 $','sub'=>'Les pâtes & risottos','badge'=>'cat-mets','cat'=>'mets-principaux',
     'accord'=>'Soave · Pinot Grigio',
     'img'=>'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=500&h=300&fit=crop'],

    ['id'=>20, 'name'=>"Fettucine Alfredo au poulet grillé",
     'desc'=>"Crème, vin blanc et parmesan",
     'price'=>'26 $','sub'=>'Les pâtes & risottos','badge'=>'cat-mets','cat'=>'mets-principaux',
     'accord'=>'Chardonnay · Pouilly-Fuissé',
     'img'=>'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=500&h=300&fit=crop'],

    ['id'=>21, 'name'=>"Lasagne maison à la chair de saucisse",
     'desc'=>"Ricotta et épinard (extra salade César +8 $)",
     'price'=>'25 $','sub'=>'Les pâtes & risottos','badge'=>'cat-mets','cat'=>'mets-principaux',
     'accord'=>'Chianti Classico · Sangiovese',
     'img'=>'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=500&h=300&fit=crop'],

    ['id'=>22, 'name'=>"Spaghetti pomodoro",
     'desc'=>"Sauce tomate maison, pesto de basilic",
     'price'=>'22 $','sub'=>'Les pâtes & risottos','badge'=>'cat-mets','cat'=>'mets-principaux',
     'accord'=>'Sangiovese · Rosso Toscano',
     'img'=>'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=500&h=300&fit=crop'],

    ['id'=>23, 'name'=>"Linguine aux fruits de mer",
     'desc'=>"Pétoncles, crevettes, moules et palourdes — sauce crème et vin blanc",
     'price'=>'37 $','sub'=>'Les pâtes & risottos','badge'=>'cat-mets','cat'=>'mets-principaux',
     'accord'=>'Muscadet · Blanc de Blancs',
     'img'=>'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=500&h=300&fit=crop'],

    ['id'=>24, 'name'=>"Fettucine au canard confit et oignons caramélisés",
     'desc'=>"Tombée de poireaux, échalote et noix de cajou torréfiée",
     'price'=>'35 $','sub'=>'Les pâtes & risottos','badge'=>'cat-mets','cat'=>'mets-principaux',
     'accord'=>'Pinot Noir · Côte de Nuits',
     'img'=>'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=500&h=300&fit=crop'],

    /* Les tartares */
    ['id'=>25, 'name'=>"Tartare de bœuf classique",
     'desc'=>"Pommes de terre frites et salade",
     'price'=>'Entrée 25 $ · Plat 33 $','sub'=>'Les tartares','badge'=>'cat-mets','cat'=>'mets-principaux',
     'accord'=>'Bordeaux Rouge · Cabernet',
     'img'=>'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=500&h=300&fit=crop'],

    ['id'=>26, 'name'=>"Tartare de saumon",
     'desc'=>"Chutney d'ananas et mangue, pommes de terre frites et salade",
     'price'=>'Entrée 25 $ · Plat 33 $','sub'=>'Les tartares','badge'=>'cat-mets','cat'=>'mets-principaux',
     'accord'=>'Sauvignon Blanc · Sancerre',
     'img'=>'https://images.unsplash.com/photo-1580822184713-fc5400e7fe10?w=500&h=300&fit=crop'],

    /* Les classiques du Graffiti */
    ['id'=>27, 'name'=>"Filet mignon de bœuf, sauce porto et fromage migneron",
     'desc'=>"Risotto aux champignons sauvages et huile de truffes, légumes du moment",
     'price'=>'56 $','sub'=>'Les classiques','badge'=>'cat-mets','cat'=>'mets-principaux',
     'accord'=>'Saint-Émilion · Pomerol',
     'img'=>'https://images.unsplash.com/photo-1558030006-450675393462?w=500&h=300&fit=crop'],

    ['id'=>28, 'name'=>"Escalope de veau parmigiana",
     'desc'=>"Tomates, gratinée au parmesan et mozzarella avec linguine et légumes du moment",
     'price'=>'37 $','sub'=>'Les classiques','badge'=>'cat-mets','cat'=>'mets-principaux',
     'accord'=>'Chianti Classico · Barolo',
     'img'=>'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?w=500&h=300&fit=crop'],

    ['id'=>29, 'name'=>"Joue de bœuf braisée à basse température",
     'desc'=>"Sauce aux fines herbes et pommes caramélisées, tombée d'épinards, poireaux frits et purée de pommes de terre",
     'price'=>'44 $','sub'=>'Les classiques','badge'=>'cat-mets','cat'=>'mets-principaux',
     'accord'=>'Pomerol · Merlot',
     'img'=>'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?w=500&h=300&fit=crop'],

    ['id'=>30, 'name'=>"Ris de veau poêlés aux champignons marinés au balsamique",
     'desc'=>"Gratin dauphinois et légumes du moment",
     'price'=>'50 $','sub'=>'Les classiques','badge'=>'cat-mets','cat'=>'mets-principaux',
     'accord'=>'Meursault · Bourgogne Blanc',
     'img'=>'https://images.unsplash.com/photo-1476978913421-dad2ebd01d17?w=500&h=300&fit=crop'],

    ['id'=>31, 'name'=>"Escalope de veau Graffiti",
     'desc'=>"Sauce crème aux champignons et linguine avec légumes du moment",
     'price'=>'36 $','sub'=>'Les classiques','badge'=>'cat-mets','cat'=>'mets-principaux',
     'accord'=>'Chardonnay · Mâcon-Villages',
     'img'=>'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?w=500&h=300&fit=crop'],

    ['id'=>32, 'name'=>"Saumon de l'Atlantique rôti et crevettes",
     'desc'=>"Beurre blanc citronné, risotto, légumes du moment",
     'price'=>'42 $','sub'=>'Les classiques','badge'=>'cat-mets','cat'=>'mets-principaux',
     'accord'=>'Chablis Grand Cru · Blanc de Blancs',
     'img'=>'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=500&h=300&fit=crop'],

    ['id'=>33, 'name'=>"Escalope de veau au citron",
     'desc'=>"Linguine et légumes du moment",
     'price'=>'35 $','sub'=>'Les classiques','badge'=>'cat-mets','cat'=>'mets-principaux',
     'accord'=>'Soave · Pinot Grigio',
     'img'=>'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?w=500&h=300&fit=crop'],

    /* ==================== DESSERTS ==================== */
    ['id'=>34, 'name'=>"Crème brûlée vanille",
     'desc'=>"Petits fruits (sans gluten)",
     'price'=>'11 $','sub'=>'Desserts','badge'=>'cat-desserts','cat'=>'desserts',
     'accord'=>'Sauternes · Moelleux',
     'img'=>'https://images.unsplash.com/photo-1470324161839-ce2bb6fa6bc3?w=500&h=300&fit=crop'],
];
@endphp

{{-- ================================================================
     SECTION PRINCIPALE
     ================================================================ --}}
<section class="resto-service-block" id="resto-service-block">

    {{-- ============================================================
         BANNIÈRE HEADER (orange gradient)
         ============================================================ --}}
    <div class="resto-header-block">

        <div class="resto-header-main">

            {{-- Logo gauche : Restaurant --}}
            <div class="resto-header-logo-left">
                <a href="{{ $restoConfig['logo_restaurant']['href'] }}"
                   class="logo-wrapper"
                   title="{{ $restoConfig['logo_restaurant']['label'] }}">
                    <img src="{{ $restoConfig['logo_restaurant']['src'] }}"
                         alt="{{ $restoConfig['logo_restaurant']['alt'] }}">
                </a>
                <span class="resto-logo-label">{{ $restoConfig['logo_restaurant']['label'] }}</span>
            </div>

            {{-- Centre : H1, H2, onglets catégories --}}
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $restoConfig['title'] }}</h1>
                <p class="resto-header-subtitle">{{ $restoConfig['subtitle'] }}</p>

                <div class="resto-header-tabs" id="restoHeaderTabs" role="tablist">
                    @foreach($restoCats as $i => $cat)
                        @php
                            $catItemCount = $cat['key'] === 'toutes'
                                ? count($menuItems)
                                : count(array_filter($menuItems, fn($m) => $m['cat'] === $cat['key']));
                        @endphp
                        <button class="resto-tab-btn {{ $i === 0 ? 'active' : '' }}"
                                data-cat="{{ $cat['key'] }}"
                                role="tab"
                                aria-selected="{{ $i === 0 ? 'true' : 'false' }}">
                            <span class="resto-tab-count">{{ $catItemCount }}</span>
                            {{ $cat['label'] }}
                        </button>
                    @endforeach

                </div>
            </div>

            {{-- Logo droit : Accord Mets & Vins --}}
            <div class="resto-header-logo-right">
                <a href="{{ $restoConfig['logo_accord']['href'] }}"
                   class="logo-wrapper"
                   title="{{ $restoConfig['logo_accord']['label'] }}">
                    <img src="{{ $restoConfig['logo_accord']['src'] }}"
                         alt="{{ $restoConfig['logo_accord']['alt'] }}">
                </a>
                <span class="resto-logo-label">{{ $restoConfig['logo_accord']['label'] }}</span>
            </div>

        </div>

        {{-- Barre Destinations + CTA --}}
        <div class="resto-header-destinations-bar">

            {{-- Ligne 1 : Icône + Breadcrumb destinations --}}
            <div class="resto-dest-row">
                <div class="resto-dest-icon-box">
                    <img src="{{ asset('REDI.png') }}" alt="Destinations">
                    <span>Destinations</span>
                </div>

                <div class="resto-dest-breadcrumb">
                    @foreach($restoDests as $i => $dest)
                        @if($i > 0)<span class="resto-dest-sep">/</span>@endif
                        <a href="#resto-cards-grid"
                           class="resto-dest-link {{ $i === 0 ? 'active' : '' }}"
                           data-dest="{{ $dest['key'] }}">{{ $dest['label'] }}</a>
                    @endforeach
                </div>
            </div>

            {{-- Ligne 2 : CTAs + Plans + Langue --}}
            <div class="resto-actions-row">
                <div class="resto-header-ctas">
                    <a href="#" class="resto-cta-btn primary" id="restoReserveTopBtn"
                       onclick="openGoExpResaModal('table'); return false;">
                        <i class="fas fa-calendar-check"></i>
                        Réservez une table
                    </a>
                    <a href="#resto-cards-grid" class="resto-cta-btn secondary">
                        En savoir
                        <span class="cta-plus">+</span>
                    </a>
                </div>

                <a href="#resto-events" class="resto-cta-btn resto-events-nav-btn">
                    <i class="fas fa-calendar-days"></i>
                    Événements
                </a>

                <a href="#resto-plans" class="resto-plans-btn">
                    <i class="fas fa-rocket"></i>
                    <span>Plans Go Next Level</span>
                </a>

                <div class="resto-lang-switcher">
                    <i class="fas fa-globe"></i>
                    <select class="resto-lang-select" id="restoLangSelect" onchange="restoSwitchLang(this.value)">
                        <option value="fr">🇫🇷 Français</option>
                        <option value="en">🇬🇧 English</option>
                        <option value="es">🇪🇸 Español</option>
                    </select>
                </div>
            </div>

        </div>

        <div class="resto-header-shimmer"></div>
    </div>

    {{-- ============================================================
         SECTION MÉDIA : Carousel photos + Vidéo featured
         ============================================================ --}}
    <div class="resto-media-strip">

        {{-- Carousel photos --}}
        <div class="resto-carousel">
            <div class="resto-carousel-track" id="restoCarouselTrack">
                @foreach($carouselSlides as $slide)
                <div class="resto-carousel-slide">
                    <img src="{{ $slide['img'] }}" alt="{{ $slide['caption'] }}" loading="lazy">
                    <div class="resto-carousel-caption">
                        <i class="fas fa-camera"></i> {{ $slide['caption'] }}
                    </div>
                </div>
                @endforeach
            </div>
            <button class="resto-carousel-btn prev" id="restoCarouselPrev" aria-label="Précédent">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="resto-carousel-btn next" id="restoCarouselNext" aria-label="Suivant">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="resto-carousel-dots" id="restoCarouselDots">
                @foreach($carouselSlides as $i => $slide)
                <button class="resto-carousel-dot {{ $i === 0 ? 'active' : '' }}"
                        data-index="{{ $i }}" aria-label="Photo {{ $i + 1 }}"></button>
                @endforeach
            </div>
        </div>

        {{-- Vidéo featured --}}
        <div class="resto-video-featured">
            <div class="resto-video-thumb" id="restoVideoThumb"
                 onclick="restoOpenVideo('{{ $restoVideo['youtube_id'] }}')">
                <img src="{{ $restoVideo['thumbnail'] }}" alt="{{ $restoVideo['title'] }}" loading="lazy">
                <div class="resto-video-overlay">
                    <div class="resto-video-play-circle">
                        <i class="fas fa-play"></i>
                    </div>
                </div>
            </div>
            <div class="resto-video-info">
                <span class="resto-video-tag"><i class="fas fa-film"></i> Vidéo</span>
                <h4 class="resto-video-title">{{ $restoVideo['title'] }}</h4>
                <p class="resto-video-sub">{{ $restoVideo['subtitle'] }}</p>
                <button class="resto-video-watch-btn"
                        onclick="restoOpenVideo('{{ $restoVideo['youtube_id'] }}')"
                        type="button">
                    <i class="fas fa-play-circle"></i> Visionner
                </button>
            </div>
        </div>

        {{-- Lightbox vidéo --}}
        <div class="resto-video-lightbox" id="restoVideoLightbox" onclick="restoCloseVideo()">
            <div class="resto-video-lightbox-inner" onclick="event.stopPropagation()">
                <button class="resto-video-lightbox-close" onclick="restoCloseVideo()" aria-label="Fermer">
                    <i class="fas fa-times"></i>
                </button>
                <div class="resto-video-iframe-wrap">
                    <iframe id="restoVideoIframe" src="" frameborder="0"
                            allow="autoplay; encrypted-media; fullscreen"
                            allowfullscreen></iframe>
                </div>
            </div>
        </div>

    </div>

    {{-- ============================================================
         ZONE CONTENU : statut filtres + grille de cartes
         ============================================================ --}}
    <div class="resto-content-area">
        <div class="resto-content-inner">

        {{-- Statut des filtres actifs --}}
        <div class="resto-filter-status">
            <span class="resto-filter-label">Affichage :</span>
            <span class="resto-filter-badge" id="restoBadgeCat">Toutes les formules</span>
            <span class="resto-filter-badge dest" id="restoBadgeDest">Toutes destinations</span>
            <span class="resto-filter-count" id="restoCardCount"></span>
        </div>

        {{-- Grille de cartes --}}
        <div class="resto-cards-grid" id="resto-cards-grid">

            @foreach($menuItems as $item)
            <article class="resto-card"
                     data-dest="all amerique-nord canada quebec region-quebec"
                     data-cat="toutes {{ $item['cat'] }}"
                     id="resto-card-{{ $item['id'] }}">

                <div class="resto-card-img">
                    <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}" loading="lazy">

                    <div class="resto-card-badges">
                        <span class="resto-badge {{ $item['badge'] }}">{{ $item['sub'] }}</span>
                    </div>

                    <div class="resto-price-overlay">{{ $item['price'] }}</div>
                </div>

                <div class="resto-card-body">
                    <h3 class="resto-card-name">{{ $item['name'] }}</h3>
                    @if($item['desc'])
                        <p class="resto-card-desc">{{ $item['desc'] }}</p>
                    @endif
                    <div class="resto-card-accord">
                        <i class="fas fa-wine-glass-alt"></i>
                        Accord : {{ $item['accord'] }}
                    </div>
                </div>

                <div class="resto-card-footer">
                    <span class="resto-card-subcategory">{{ $item['sub'] }}</span>
                    <a href="#resto-reservation"
                       class="resto-card-reserve-btn"
                       data-item="{{ $item['name'] }}">
                        <i class="fas fa-calendar-check"></i>
                        Réservez
                    </a>
                </div>

            </article>
            @endforeach

            <div class="resto-no-results" id="restoNoResults">
                <i class="fas fa-search"></i>
                Aucun restaurant trouvé pour ces critères.
            </div>

        </div>
        </div>{{-- /.resto-content-inner --}}
    </div>{{-- /.resto-content-area --}}

    {{-- ============================================================
         SECTION ÉVÉNEMENTS
         ============================================================ --}}
    <section class="resto-events-section" id="resto-events">

        <div class="resto-events-header">
            <span class="resto-events-eyebrow"><i class="fas fa-calendar-days"></i> Événements &amp; Célébrations</span>
            <h2 class="resto-events-title">Occasions Spéciales &amp; Forfaits</h2>
            <p class="resto-events-lead">Choisissez votre type d'événement pour découvrir nos forfaits exclusifs.</p>
        </div>

        {{-- Onglets types d'événement --}}
        <div class="resto-events-types-bar" id="restoEventsTypesBar">
            @foreach($restoEventTypes as $i => $evType)
            @php
                $evCount = $evType['key'] === 'all'
                    ? count($restoEventCards)
                    : count(array_filter($restoEventCards, fn($c) => $c['type'] === $evType['key']));
            @endphp
            <button class="resto-event-type-btn {{ $i === 0 ? 'active' : '' }}"
                    data-event="{{ $evType['key'] }}"
                    type="button">
                <span class="resto-type-count">{{ $evCount }}</span>
                <i class="fas {{ $evType['icon'] }}"></i>
                <span>{{ $evType['label'] }}</span>
            </button>
            @endforeach
        </div>

        {{-- Grille des cartes événement --}}
        <div class="resto-events-grid" id="restoEventsGrid">

            @foreach($restoEventCards as $card)
            <article class="resto-event-card" data-event="{{ $card['type'] }}">
                <div class="resto-event-card-img">
                    <img src="{{ $card['img'] }}" alt="{{ $card['title'] }}" loading="lazy">
                    <span class="resto-event-badge">{{ $card['badge'] }}</span>
                </div>
                <div class="resto-event-card-body">
                    <h3 class="resto-event-card-title">{{ $card['title'] }}</h3>
                    <p class="resto-event-card-desc">{{ $card['desc'] }}</p>
                    <div class="resto-event-card-footer">
                        <span class="resto-event-card-price">{{ $card['price'] }}</span>
                        <button class="resto-event-card-cta"
                                onclick="openGoExpResaModal('table', '{{ addslashes($card['title']) }}')"
                                type="button">
                            <i class="fas fa-calendar-check"></i> Réserver
                        </button>
                    </div>
                </div>
            </article>
            @endforeach

            <div class="resto-events-no-results" id="restoEventsNoResults">
                <i class="fas fa-calendar-xmark"></i>
                Aucun forfait disponible pour ce type d'événement.
            </div>

        </div>

    </section>

    {{-- ============================================================
         PLANS GO NEXT LEVEL — GoExploria restaurant plans
         ============================================================ --}}
    <section class="resto-plans-section" id="resto-plans">
        <div class="resto-plans-topbar">
            <span class="resto-plans-topbar-badge">
                <i class="fas fa-rocket"></i> GoExploria
            </span>
            <span class="resto-plans-topbar-text">
                Propulsez votre restaurant vers de nouveaux sommets
            </span>
        </div>

        <div class="resto-plans-inner">

            <div class="resto-plans-heading">
                <span class="resto-plans-eyebrow">Nos Formules</span>
                <h3 class="resto-plans-title">
                    Plans <span class="resto-plans-highlight">Go Next Level</span>
                </h3>
                <p class="resto-plans-lead">
                    GoExploria conçoit des sites web sur mesure pour les restaurants — du template prêt à l'emploi
                    jusqu'au site premium 100% personnalisé, avec réservation en ligne, carte digitale et CRM intégré.
                </p>
            </div>

            <div class="resto-plans-grid">

                {{-- Plan Starter --}}
                <div class="resto-plan-card">
                    <div class="resto-plan-header">
                        <div class="resto-plan-icon"><i class="fas fa-seedling"></i></div>
                        <div class="resto-plan-name">Starter</div>
                        <div class="resto-plan-price">
                            <span class="resto-plan-amount">399</span>
                            <span class="resto-plan-currency">$</span>
                            <span class="resto-plan-period">/ mois</span>
                        </div>
                        <p class="resto-plan-tagline">Idéal pour démarrer votre présence en ligne</p>
                    </div>
                    <ul class="resto-plan-features">
                        <li><i class="fas fa-check"></i> Site web responsive 1 page</li>
                        <li><i class="fas fa-check"></i> Carte du menu digitale</li>
                        <li><i class="fas fa-check"></i> Formulaire de réservation</li>
                        <li><i class="fas fa-check"></i> Galerie photos</li>
                        <li><i class="fas fa-check"></i> Intégration Google Maps</li>
                        <li class="resto-plan-feat-no"><i class="fas fa-times"></i> Système de paiement</li>
                        <li class="resto-plan-feat-no"><i class="fas fa-times"></i> CRM clients</li>
                    </ul>
                    <a href="#" class="resto-plan-cta starter">
                        <i class="fas fa-arrow-right"></i> Démarrer
                    </a>
                </div>

                {{-- Plan Pro (recommandé) --}}
                <div class="resto-plan-card featured">
                    <div class="resto-plan-badge">Recommandé</div>
                    <div class="resto-plan-header">
                        <div class="resto-plan-icon"><i class="fas fa-crown"></i></div>
                        <div class="resto-plan-name">Pro</div>
                        <div class="resto-plan-price">
                            <span class="resto-plan-amount">799</span>
                            <span class="resto-plan-currency">$</span>
                            <span class="resto-plan-period">/ mois</span>
                        </div>
                        <p class="resto-plan-tagline">Pour les restaurants ambitieux</p>
                    </div>
                    <ul class="resto-plan-features">
                        <li><i class="fas fa-check"></i> Site web multipage complet</li>
                        <li><i class="fas fa-check"></i> Carte des vins interactive</li>
                        <li><i class="fas fa-check"></i> Réservation en ligne avancée</li>
                        <li><i class="fas fa-check"></i> Carousel photos &amp; vidéos</li>
                        <li><i class="fas fa-check"></i> Accords Mets &amp; Vins</li>
                        <li><i class="fas fa-check"></i> Paiement en ligne</li>
                        <li class="resto-plan-feat-no"><i class="fas fa-times"></i> CRM clients avancé</li>
                    </ul>
                    <a href="#" class="resto-plan-cta pro">
                        <i class="fas fa-arrow-right"></i> Choisir Pro
                    </a>
                </div>

                {{-- Plan Premium --}}
                <div class="resto-plan-card">
                    <div class="resto-plan-header">
                        <div class="resto-plan-icon"><i class="fas fa-gem"></i></div>
                        <div class="resto-plan-name">Premium</div>
                        <div class="resto-plan-price">
                            <span class="resto-plan-amount">1499</span>
                            <span class="resto-plan-currency">$</span>
                            <span class="resto-plan-period">/ mois</span>
                        </div>
                        <p class="resto-plan-tagline">Solution 100% sur mesure clé en main</p>
                    </div>
                    <ul class="resto-plan-features">
                        <li><i class="fas fa-check"></i> Site premium full custom</li>
                        <li><i class="fas fa-check"></i> App mobile iOS &amp; Android</li>
                        <li><i class="fas fa-check"></i> CRM clients &amp; fidélité</li>
                        <li><i class="fas fa-check"></i> Marketing &amp; SEO inclus</li>
                        <li><i class="fas fa-check"></i> Réservation &amp; paiement</li>
                        <li><i class="fas fa-check"></i> Tableau de bord analytique</li>
                        <li><i class="fas fa-check"></i> Support prioritaire 24/7</li>
                    </ul>
                    <a href="#" class="resto-plan-cta premium">
                        <i class="fas fa-arrow-right"></i> Découvrir Premium
                    </a>
                </div>

            </div>{{-- /.resto-plans-grid --}}

            <div class="resto-plans-footer">
                <p>Tous les plans incluent l'hébergement, la maintenance et les mises à jour.</p>
                <a href="#" class="resto-plans-contact">
                    <i class="fas fa-envelope"></i> Nous contacter pour un devis personnalisé
                </a>
            </div>

        </div>{{-- /.resto-plans-inner --}}
    </section>{{-- /.resto-plans-section --}}

</section>

{{-- ================================================================
     JAVASCRIPT — Filtrage destination × catégorie
     ================================================================ --}}
<script>
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {

        var activeCat  = 'toutes';
        var activeDest = 'all';

        var cards      = document.querySelectorAll('#resto-cards-grid .resto-card');
        var tabs       = document.querySelectorAll('#restoHeaderTabs .resto-tab-btn');
        var destLinks  = document.querySelectorAll('.resto-dest-link[data-dest]');
        var badgeCat   = document.getElementById('restoBadgeCat');
        var badgeDest  = document.getElementById('restoBadgeDest');
        var countEl    = document.getElementById('restoCardCount');
        var noResults  = document.getElementById('restoNoResults');
        var selectResto= document.getElementById('restoSelectRestaurant');

        /* ---- Applique les filtres actifs ---- */
        function applyFilters() {
            var visible = 0;

            cards.forEach(function (card) {
                var cardCats  = card.getAttribute('data-cat').split(' ');
                var cardDests = card.getAttribute('data-dest').split(' ');

                var catMatch  = (activeCat === 'toutes') || cardCats.indexOf(activeCat) !== -1;
                var destMatch = (activeDest === 'all')   || cardDests.indexOf(activeDest) !== -1;

                if (catMatch && destMatch) {
                    card.classList.remove('hidden');
                    visible++;
                } else {
                    card.classList.add('hidden');
                }
            });

            /* Compteur */
            if (countEl) {
                countEl.textContent = visible + ' restaurant' + (visible > 1 ? 's' : '') + ' trouvé' + (visible > 1 ? 's' : '');
            }

            /* Message aucun résultat */
            if (noResults) {
                noResults.style.display = visible === 0 ? 'block' : 'none';
            }
        }

        /* ---- Onglets catégories ---- */
        tabs.forEach(function (btn) {
            btn.addEventListener('click', function () {
                tabs.forEach(function (t) {
                    t.classList.remove('active');
                    t.setAttribute('aria-selected', 'false');
                });
                btn.classList.add('active');
                btn.setAttribute('aria-selected', 'true');

                activeCat = btn.getAttribute('data-cat');

                if (badgeCat) badgeCat.textContent = btn.textContent.trim();

                applyFilters();

                /* Scroll doux vers les cartes */
                var grid = document.getElementById('resto-cards-grid');
                if (grid) grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });

        /* ---- Liens destinations ---- */
        destLinks.forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                destLinks.forEach(function (l) { l.classList.remove('active'); });
                link.classList.add('active');

                activeDest = link.getAttribute('data-dest');

                if (badgeDest) badgeDest.textContent = link.textContent.trim();

                applyFilters();

                /* Scroll doux vers les cartes */
                var grid = document.getElementById('resto-cards-grid');
                if (grid) grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });

        /* ---- Bouton "Réservez" sur chaque carte → ouvre le modal global ---- */
        document.querySelectorAll('.resto-card-reserve-btn').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                var itemName = btn.getAttribute('data-item') || '';
                if (typeof openGoExpResaModal === 'function') {
                    openGoExpResaModal('table', itemName);
                }
            });
        });

        /* ---- Init : compter les cartes visibles au chargement ---- */
        applyFilters();
    });

    /* ================================================================
       CAROUSEL PHOTOS
       ================================================================ */
    (function () {
        var track  = document.getElementById('restoCarouselTrack');
        var prev   = document.getElementById('restoCarouselPrev');
        var next   = document.getElementById('restoCarouselNext');
        var dots   = document.querySelectorAll('#restoCarouselDots .resto-carousel-dot');
        if (!track) return;

        var total   = track.children.length;
        var current = 0;
        var timer;

        function goTo(index) {
            current = (index + total) % total;
            track.style.transform = 'translateX(-' + (current * 100) + '%)';
            dots.forEach(function (d, i) {
                d.classList.toggle('active', i === current);
            });
        }

        function startAuto() {
            timer = setInterval(function () { goTo(current + 1); }, 4500);
        }

        function resetAuto() {
            clearInterval(timer);
            startAuto();
        }

        if (prev) prev.addEventListener('click', function () { goTo(current - 1); resetAuto(); });
        if (next) next.addEventListener('click', function () { goTo(current + 1); resetAuto(); });

        dots.forEach(function (d) {
            d.addEventListener('click', function () {
                goTo(parseInt(d.getAttribute('data-index')));
                resetAuto();
            });
        });

        startAuto();
    })();

    /* ================================================================
       VIDÉO LIGHTBOX
       ================================================================ */
    function restoOpenVideo(youtubeId) {
        var lb     = document.getElementById('restoVideoLightbox');
        var iframe = document.getElementById('restoVideoIframe');
        if (!lb || !iframe) return;
        iframe.src = 'https://www.youtube.com/embed/' + youtubeId + '?autoplay=1&rel=0';
        lb.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function restoCloseVideo() {
        var lb     = document.getElementById('restoVideoLightbox');
        var iframe = document.getElementById('restoVideoIframe');
        if (lb) lb.classList.remove('active');
        if (iframe) iframe.src = '';
        document.body.style.overflow = '';
    }

    /* Fermer avec Escape */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') restoCloseVideo();
    });

    /* ================================================================
       ÉVÉNEMENTS — FILTRE PAR TYPE
       ================================================================ */
    (function () {
        var typeBtns   = document.querySelectorAll('.resto-event-type-btn');
        var eventCards = document.querySelectorAll('.resto-event-card');
        var noResults  = document.getElementById('restoEventsNoResults');
        var activeType = 'all';

        if (!typeBtns.length) return;

        function applyEventFilter() {
            var visible = 0;
            eventCards.forEach(function (card) {
                var match = activeType === 'all' || card.getAttribute('data-event') === activeType;
                card.classList.toggle('hidden', !match);
                if (match) visible++;
            });
            if (noResults) noResults.style.display = visible === 0 ? 'flex' : 'none';
        }

        typeBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                typeBtns.forEach(function (b) { b.classList.remove('active'); });
                btn.classList.add('active');
                activeType = btn.getAttribute('data-event');
                applyEventFilter();
            });
        });

        applyEventFilter();
    })();

})();
</script>
