<?php
namespace App\Helpers;

use App\Models\Menu;
use App\Models\Continent;

class MenuRenderer
{
    public static function renderMenu()
    {
        $menuDestinations = Continent::with(['countries' => function($query) {
            $query->where('is_active', true)->orderBy('name');
        }])
        ->where('is_active', true)
        ->get();

        $menus = Menu::with(['activeChildren' => function($query) {
            $query->with('activeChildren')->orderBy('order');
        }])
        ->whereNull('parent_id')
        ->where('menu_type', 'Accueil')
        ->where('is_active', true)
        ->orderBy('order')
        ->get();

        return self::buildMenuHtml($menus, $menuDestinations);
    }

    private static function buildMenuHtml($menus, $destinations)
    {
        $html = '<!--begin: Main Navigation--><div id="mainMenu"><div class="container"><nav><ul>';
        
        // Ajouter le menu Destination en premier
        $html .= self::renderDestinationMegaMenu($destinations);
        
        foreach ($menus as $menu) {
            $hasChildren = $menu->activeChildren->isNotEmpty();
            $isMegaMenu = self::shouldBeMegaMenu($menu);
            
            $html .= '<li class="' . ($isMegaMenu ? 'dropdown mega-menu-item' : 'dropdown') . '">';
            $html .= '<a href="' . $menu->url . '">';
            
            if ($menu->icon) {
                $html .= '<i class="' . $menu->icon . ' me-1"></i>';
            }
            
            $html .= $menu->final_title . '</a>';
            
            if ($hasChildren) {
                if ($isMegaMenu) {
                    $html .= self::renderMegaMenu($menu->activeChildren);
                } else {
                    $html .= self::renderDropdownMenu($menu->activeChildren);
                }
            }
            
            $html .= '</li>';
        }
        
        // Formulaire de recherche supprimé - maintenant dans la barre horizontale
        // $html .= self::renderSearchForm();
        
        $html .= '</ul></nav></div></div><!--end: Main Navigation-->';
        
        return $html;
    }

    private static function renderSearchForm()
    {
        $html = '<li class="search-menu-item">';
        $html .= '<div class="search-form-container">';
        $html .= '<form action="' . route('search') . '" method="GET" class="d-flex search-form">';
        $html .= '<div class="input-group">';
        $html .= '<input type="text" 
                        name="q" 
                        class="form-control search-input" 
                        placeholder="Rechercher..." 
                        aria-label="Rechercher" 
                        aria-describedby="search-button">';
        $html .= '<button class="btn btn-outline-primary search-button" type="submit" id="search-button">';
        $html .= '<i class="fas fa-search"></i>';
        $html .= '</button>';
        $html .= '</div>';
        $html .= '</form>';
        $html .= '</div>';
        $html .= '</li>';
        
        return $html;
    }

    public static function getMegaMenuPanel()
    {
        // Générer des données mock pour le frontend
        $mockData = self::generateMockDestinationData();
        return self::buildMegaMenuPanel($mockData);
    }

    private static function generateMockDestinationData()
    {
        return [
            (object)[
                'id' => 1,
                'name' => 'Afrique',
                'code' => 'AF',
                'countries' => collect([
                    (object)[
                        'id' => 1,
                        'name' => 'Maroc',
                        'flag_emoji' => '🇲🇦',
                        'image' => null,
                        'provinces' => collect([
                            (object)[
                                'id' => 1,
                                'name' => 'Grand Casablanca',
                                'regions' => collect([
                                    (object)[
                                        'id' => 1,
                                        'name' => 'Casablanca-Settat',
                                        'villes' => collect([
                                            (object)['id' => 1, 'name' => 'Casablanca', 'population' => 3600000, 'quartiers' => ['Anfa', 'Maarif', 'Ain Diab', 'Hay Hassani']],
                                            (object)['id' => 2, 'name' => 'Mohammedia', 'population' => 200000, 'quartiers' => ['Centre-ville', 'Port', 'Oulad Azzouz']],
                                            (object)['id' => 3, 'name' => 'Settat', 'population' => 142000, 'quartiers' => ['Médina', 'Ville Nouvelle', 'Hay Salam']],
                                        ])
                                    ]
                                ])
                            ],
                            (object)[
                                'id' => 2,
                                'name' => 'Marrakech-Safi',
                                'regions' => collect([
                                    (object)[
                                        'id' => 2,
                                        'name' => 'Marrakech',
                                        'villes' => collect([
                                            (object)['id' => 4, 'name' => 'Marrakech', 'population' => 928850, 'quartiers' => ['Médina', 'Guéliz', 'Hivernage', 'Palmeraie']],
                                            (object)['id' => 5, 'name' => 'Safi', 'population' => 308508, 'quartiers' => ['Médina', 'Ville Nouvelle', 'Hay Mohammadi']],
                                        ])
                                    ]
                                ])
                            ]
                        ])
                    ],
                    (object)[
                        'id' => 2,
                        'name' => 'Égypte',
                        'flag_emoji' => '🇪🇬',
                        'image' => null,
                        'provinces' => collect([
                            (object)[
                                'id' => 3,
                                'name' => 'Le Caire',
                                'regions' => collect([
                                    (object)[
                                        'id' => 3,
                                        'name' => 'Grand Caire',
                                        'villes' => collect([
                                            (object)['id' => 6, 'name' => 'Le Caire', 'population' => 9500000, 'quartiers' => ['Zamalek', 'Maadi', 'Heliopolis', 'Nasr City']],
                                            (object)['id' => 7, 'name' => 'Gizeh', 'population' => 3600000, 'quartiers' => ['Dokki', 'Mohandessin', 'Agouza']],
                                            (object)['id' => 8, 'name' => 'Alexandrie', 'population' => 5200000, 'quartiers' => ['Montaza', 'Raml Station', 'Sidi Gaber']],
                                        ])
                                    ]
                                ])
                            ]
                        ])
                    ],
                    (object)[
                        'id' => 3,
                        'name' => 'Afrique du Sud',
                        'flag_emoji' => '🇿🇦',
                        'image' => null,
                        'provinces' => collect([
                            (object)[
                                'id' => 4,
                                'name' => 'Gauteng',
                                'regions' => collect([
                                    (object)[
                                        'id' => 4,
                                        'name' => 'Johannesburg Metro',
                                        'villes' => collect([
                                            (object)['id' => 9, 'name' => 'Johannesburg', 'population' => 5600000, 'quartiers' => ['Sandton', 'Rosebank', 'Melville', 'Braamfontein']],
                                            (object)['id' => 10, 'name' => 'Pretoria', 'population' => 2900000, 'quartiers' => ['Hatfield', 'Arcadia', 'Brooklyn', 'Menlyn']],
                                            (object)['id' => 11, 'name' => 'Soweto', 'population' => 1300000, 'quartiers' => ['Orlando', 'Diepkloof', 'Meadowlands']],
                                        ])
                                    ]
                                ])
                            ]
                        ])
                    ],
                ])
            ],
            (object)[
                'id' => 2,
                'name' => 'Europe',
                'code' => 'EU',
                'countries' => collect([
                    (object)[
                        'id' => 4,
                        'name' => 'France',
                        'flag_emoji' => '🇫🇷',
                        'image' => null,
                        'provinces' => collect([
                            (object)[
                                'id' => 5,
                                'name' => 'Île-de-France',
                                'regions' => collect([
                                    (object)[
                                        'id' => 5,
                                        'name' => 'Paris et Petite Couronne',
                                        'villes' => collect([
                                            (object)['id' => 12, 'name' => 'Paris', 'population' => 2200000, 'quartiers' => ['Marais', 'Montmartre', 'Latin Quarter', 'Champs-Élysées', 'Saint-Germain']],
                                            (object)['id' => 13, 'name' => 'Versailles', 'population' => 85000, 'quartiers' => ['Notre-Dame', 'Saint-Louis', 'Montreuil']],
                                            (object)['id' => 14, 'name' => 'Boulogne-Billancourt', 'population' => 120000, 'quartiers' => ['Rives de Seine', 'Point-du-Jour', 'Silly-Gallieni']],
                                            (object)['id' => 15, 'name' => 'Saint-Denis', 'population' => 112000, 'quartiers' => ['Basilique', 'Pleyel', 'Franc-Moisin']],
                                        ])
                                    ]
                                ])
                            ],
                            (object)[
                                'id' => 6,
                                'name' => 'Provence-Alpes-Côte d\'Azur',
                                'regions' => collect([
                                    (object)[
                                        'id' => 6,
                                        'name' => 'Bouches-du-Rhône',
                                        'villes' => collect([
                                            (object)['id' => 16, 'name' => 'Marseille', 'population' => 870000, 'quartiers' => ['Vieux-Port', 'Canebière', 'Panier', 'Prado']],
                                            (object)['id' => 17, 'name' => 'Aix-en-Provence', 'population' => 145000, 'quartiers' => ['Centre-ville', 'Jas de Bouffan', 'Sextius']],
                                            (object)['id' => 18, 'name' => 'Nice', 'population' => 340000, 'quartiers' => ['Vieux Nice', 'Promenade', 'Libération', 'Cimiez']],
                                        ])
                                    ]
                                ])
                            ]
                        ])
                    ],
                    (object)[
                        'id' => 5,
                        'name' => 'Espagne',
                        'flag_emoji' => '🇪🇸',
                        'image' => null,
                        'provinces' => collect([
                            (object)[
                                'id' => 7,
                                'name' => 'Communauté de Madrid',
                                'regions' => collect([
                                    (object)[
                                        'id' => 7,
                                        'name' => 'Madrid Métropolitain',
                                        'villes' => collect([
                                            (object)['id' => 19, 'name' => 'Madrid', 'population' => 3300000, 'quartiers' => ['Sol', 'Malasaña', 'Chueca', 'Salamanca', 'Retiro']],
                                            (object)['id' => 20, 'name' => 'Alcalá de Henares', 'population' => 195000, 'quartiers' => ['Centro', 'Espartales', 'Nueva Alcalá']],
                                            (object)['id' => 21, 'name' => 'Getafe', 'population' => 180000, 'quartiers' => ['Centro', 'San Isidro', 'Juan de la Cierva']],
                                        ])
                                    ]
                                ])
                            ],
                            (object)[
                                'id' => 8,
                                'name' => 'Catalogne',
                                'regions' => collect([
                                    (object)[
                                        'id' => 8,
                                        'name' => 'Barcelone',
                                        'villes' => collect([
                                            (object)['id' => 22, 'name' => 'Barcelone', 'population' => 1620000, 'quartiers' => ['Gothic Quarter', 'Eixample', 'Gràcia', 'Barceloneta']],
                                            (object)['id' => 23, 'name' => 'Hospitalet de Llobregat', 'population' => 260000, 'quartiers' => ['Centre', 'Santa Eulàlia', 'Collblanc']],
                                        ])
                                    ]
                                ])
                            ]
                        ])
                    ],
                    (object)[
                        'id' => 6,
                        'name' => 'Italie',
                        'flag_emoji' => '🇮🇹',
                        'image' => null,
                        'provinces' => collect([
                            (object)[
                                'id' => 9,
                                'name' => 'Latium',
                                'regions' => collect([
                                    (object)[
                                        'id' => 9,
                                        'name' => 'Rome Capitale',
                                        'villes' => collect([
                                            (object)['id' => 24, 'name' => 'Rome', 'population' => 2870000, 'quartiers' => ['Trastevere', 'Monti', 'Testaccio', 'Prati', 'EUR']],
                                            (object)['id' => 25, 'name' => 'Ostia', 'population' => 85000, 'quartiers' => ['Lido', 'Antica', 'Levante']],
                                            (object)['id' => 26, 'name' => 'Tivoli', 'population' => 56000, 'quartiers' => ['Centro Storico', 'Villa Adriana']],
                                        ])
                                    ]
                                ])
                            ],
                            (object)[
                                'id' => 10,
                                'name' => 'Lombardie',
                                'regions' => collect([
                                    (object)[
                                        'id' => 10,
                                        'name' => 'Milan Métropole',
                                        'villes' => collect([
                                            (object)['id' => 27, 'name' => 'Milan', 'population' => 1400000, 'quartiers' => ['Duomo', 'Brera', 'Navigli', 'Porta Romana']],
                                            (object)['id' => 28, 'name' => 'Bergame', 'population' => 120000, 'quartiers' => ['Città Alta', 'Città Bassa', 'Borgo Palazzo']],
                                        ])
                                    ]
                                ])
                            ]
                        ])
                    ],
                    (object)[
                        'id' => 7,
                        'name' => 'Allemagne',
                        'flag_emoji' => '🇩🇪',
                        'image' => null,
                        'provinces' => collect([
                            (object)[
                                'id' => 11,
                                'name' => 'Bavière',
                                'regions' => collect([
                                    (object)[
                                        'id' => 11,
                                        'name' => 'Munich',
                                        'villes' => collect([
                                            (object)['id' => 29, 'name' => 'Munich', 'population' => 1500000, 'quartiers' => ['Altstadt', 'Schwabing', 'Maxvorstadt', 'Haidhausen']],
                                            (object)['id' => 30, 'name' => 'Nuremberg', 'population' => 518000, 'quartiers' => ['Altstadt', 'Südstadt', 'Mitte']],
                                        ])
                                    ]
                                ])
                            ]
                        ])
                    ],
                ])
            ],
            (object)[
                'id' => 3,
                'name' => 'Asie',
                'code' => 'AS',
                'countries' => collect([
                    (object)[
                        'id' => 8,
                        'name' => 'Japon',
                        'flag_emoji' => '🇯🇵',
                        'image' => null,
                        'provinces' => collect([
                            (object)[
                                'id' => 12,
                                'name' => 'Tokyo',
                                'regions' => collect([
                                    (object)[
                                        'id' => 12,
                                        'name' => 'Tokyo Métropole',
                                        'villes' => collect([
                                            (object)['id' => 31, 'name' => 'Tokyo', 'population' => 13960000, 'quartiers' => ['Shibuya', 'Shinjuku', 'Ginza', 'Akihabara', 'Roppongi']],
                                            (object)['id' => 32, 'name' => 'Shibuya', 'population' => 230000, 'quartiers' => ['Harajuku', 'Omotesando', 'Daikanyama']],
                                            (object)['id' => 33, 'name' => 'Shinjuku', 'population' => 340000, 'quartiers' => ['Kabukicho', 'Yoyogi', 'Takadanobaba']],
                                            (object)['id' => 34, 'name' => 'Yokohama', 'population' => 3750000, 'quartiers' => ['Minato Mirai', 'Chinatown', 'Kannai', 'Motomachi']],
                                        ])
                                    ]
                                ])
                            ]
                        ])
                    ],
                    (object)[
                        'id' => 9,
                        'name' => 'Chine',
                        'flag_emoji' => '🇨🇳',
                        'image' => null,
                        'provinces' => collect([
                            (object)[
                                'id' => 13,
                                'name' => 'Pékin',
                                'regions' => collect([
                                    (object)[
                                        'id' => 13,
                                        'name' => 'Pékin Centre',
                                        'villes' => collect([
                                            (object)['id' => 35, 'name' => 'Pékin', 'population' => 21540000, 'quartiers' => ['Dongcheng', 'Xicheng', 'Chaoyang', 'Haidian']],
                                            (object)['id' => 36, 'name' => 'Chaoyang', 'population' => 3700000, 'quartiers' => ['CBD', 'Sanlitun', 'Wangjing']],
                                            (object)['id' => 37, 'name' => 'Haidian', 'population' => 3500000, 'quartiers' => ['Zhongguancun', 'Wudaokou', 'Tsinghua']],
                                        ])
                                    ]
                                ])
                            ],
                            (object)[
                                'id' => 14,
                                'name' => 'Shanghai',
                                'regions' => collect([
                                    (object)[
                                        'id' => 14,
                                        'name' => 'Shanghai Métropole',
                                        'villes' => collect([
                                            (object)['id' => 38, 'name' => 'Shanghai', 'population' => 24280000, 'quartiers' => ['Bund', 'Pudong', 'French Concession', 'Jing\'an']],
                                            (object)['id' => 39, 'name' => 'Pudong', 'population' => 5500000, 'quartiers' => ['Lujiazui', 'Jinqiao', 'Zhangjiang']],
                                        ])
                                    ]
                                ])
                            ]
                        ])
                    ],
                    (object)[
                        'id' => 10,
                        'name' => 'Thaïlande',
                        'flag_emoji' => '🇹🇭',
                        'image' => null,
                        'provinces' => collect([
                            (object)[
                                'id' => 15,
                                'name' => 'Bangkok',
                                'regions' => collect([
                                    (object)[
                                        'id' => 15,
                                        'name' => 'Bangkok Métropole',
                                        'villes' => collect([
                                            (object)['id' => 40, 'name' => 'Bangkok', 'population' => 10700000, 'quartiers' => ['Sukhumvit', 'Silom', 'Siam', 'Chatuchak', 'Thonburi']],
                                            (object)['id' => 41, 'name' => 'Pattaya', 'population' => 120000, 'quartiers' => ['Beach Road', 'Jomtien', 'Naklua']],
                                            (object)['id' => 42, 'name' => 'Chiang Mai', 'population' => 170000, 'quartiers' => ['Old City', 'Nimman', 'Santitham']],
                                        ])
                                    ]
                                ])
                            ]
                        ])
                    ],
                    (object)[
                        'id' => 11,
                        'name' => 'Inde',
                        'flag_emoji' => '🇮🇳',
                        'image' => null,
                        'provinces' => collect([
                            (object)[
                                'id' => 16,
                                'name' => 'Maharashtra',
                                'regions' => collect([
                                    (object)[
                                        'id' => 16,
                                        'name' => 'Mumbai Métropole',
                                        'villes' => collect([
                                            (object)['id' => 43, 'name' => 'Mumbai', 'population' => 20400000, 'quartiers' => ['Colaba', 'Bandra', 'Andheri', 'Juhu', 'Marine Drive']],
                                            (object)['id' => 44, 'name' => 'Pune', 'population' => 3100000, 'quartiers' => ['Koregaon Park', 'Shivajinagar', 'Kothrud']],
                                        ])
                                    ]
                                ])
                            ]
                        ])
                    ],
                ])
            ],
            (object)[
                'id' => 4,
                'name' => 'Amérique du Nord',
                'code' => 'NA',
                'countries' => collect([
                    (object)[
                        'id' => 12,
                        'name' => 'Canada',
                        'flag_emoji' => '🇨🇦',
                        'image' => null,
                        'provinces' => collect([
                            (object)[
                                'id' => 17,
                                'name' => 'Québec',
                                'regions' => collect([
                                    (object)[
                                        'id' => 17,
                                        'name' => 'Région de Québec',
                                        'villes' => collect([
                                            (object)['id' => 45, 'name' => 'Ville de Québec', 'population' => 540000, 'quartiers' => ['Vieux-Québec', 'Saint-Roch', 'Limoilou', 'Sainte-Foy', 'Sillery']],
                                            (object)['id' => 46, 'name' => 'Lévis', 'population' => 145000, 'quartiers' => ['Vieux-Lévis', 'Saint-Romuald', 'Saint-Nicolas', 'Charny']],
                                            (object)['id' => 47, 'name' => 'Beauport', 'population' => 78000, 'quartiers' => ['Vieux-Beauport', 'Montmorency', 'Courville', 'Giffard']],
                                            (object)['id' => 48, 'name' => 'Sainte-Foy', 'population' => 85000, 'quartiers' => ['Cité Universitaire', 'Plateau', 'Cap-Rouge', 'Saint-Louis']],
                                            (object)['id' => 49, 'name' => 'Charlesbourg', 'population' => 76000, 'quartiers' => ['Trait-Carré', 'Neufchâtel', 'Orsainville', 'Des Châtels']],
                                        ])
                                    ],
                                    (object)[
                                        'id' => 18,
                                        'name' => 'Chaudière-Appalaches',
                                        'villes' => collect([
                                            (object)['id' => 50, 'name' => 'Saint-Georges', 'population' => 32000, 'quartiers' => ['Centre-ville', 'Est', 'Ouest', 'Aubert-Gallion']],
                                            (object)['id' => 51, 'name' => 'Thetford Mines', 'population' => 25000, 'quartiers' => ['Centre-ville', 'Black Lake', 'Robertsonville']],
                                        ])
                                    ]
                                ])
                            ],
                            (object)[
                                'id' => 18,
                                'name' => 'Ontario',
                                'regions' => collect([
                                    (object)[
                                        'id' => 19,
                                        'name' => 'Toronto Métropole',
                                        'villes' => collect([
                                            (object)['id' => 52, 'name' => 'Toronto', 'population' => 2930000, 'quartiers' => ['Downtown', 'Yorkville', 'The Annex', 'Distillery District', 'Queen West']],
                                            (object)['id' => 53, 'name' => 'Mississauga', 'population' => 721000, 'quartiers' => ['Port Credit', 'Streetsville', 'Meadowvale', 'Erin Mills']],
                                            (object)['id' => 54, 'name' => 'Brampton', 'population' => 656000, 'quartiers' => ['Downtown', 'Bramalea', 'Heart Lake', 'Springdale']],
                                        ])
                                    ]
                                ])
                            ],
                            (object)[
                                'id' => 19,
                                'name' => 'Colombie-Britannique',
                                'regions' => collect([
                                    (object)[
                                        'id' => 20,
                                        'name' => 'Vancouver Métropole',
                                        'villes' => collect([
                                            (object)['id' => 55, 'name' => 'Vancouver', 'population' => 675000, 'quartiers' => ['Downtown', 'Gastown', 'Yaletown', 'Kitsilano', 'Commercial Drive']],
                                            (object)['id' => 56, 'name' => 'Surrey', 'population' => 568000, 'quartiers' => ['City Centre', 'Guildford', 'Fleetwood', 'Newton']],
                                            (object)['id' => 57, 'name' => 'Burnaby', 'population' => 249000, 'quartiers' => ['Metrotown', 'Brentwood', 'Lougheed', 'Edmonds']],
                                        ])
                                    ]
                                ])
                            ]
                        ])
                    ],
                    (object)[
                        'id' => 13,
                        'name' => 'États-Unis',
                        'flag_emoji' => '🇺🇸',
                        'image' => null,
                        'provinces' => collect([
                            (object)[
                                'id' => 20,
                                'name' => 'New York',
                                'regions' => collect([
                                    (object)[
                                        'id' => 21,
                                        'name' => 'New York City',
                                        'villes' => collect([
                                            (object)['id' => 58, 'name' => 'Manhattan', 'population' => 1630000, 'quartiers' => ['Times Square', 'SoHo', 'Tribeca', 'Upper East Side', 'Harlem']],
                                            (object)['id' => 59, 'name' => 'Brooklyn', 'population' => 2560000, 'quartiers' => ['Williamsburg', 'DUMBO', 'Park Slope', 'Bushwick']],
                                            (object)['id' => 60, 'name' => 'Queens', 'population' => 2270000, 'quartiers' => ['Astoria', 'Flushing', 'Long Island City', 'Forest Hills']],
                                        ])
                                    ]
                                ])
                            ],
                            (object)[
                                'id' => 21,
                                'name' => 'Californie',
                                'regions' => collect([
                                    (object)[
                                        'id' => 22,
                                        'name' => 'Los Angeles Métropole',
                                        'villes' => collect([
                                            (object)['id' => 61, 'name' => 'Los Angeles', 'population' => 3970000, 'quartiers' => ['Hollywood', 'Beverly Hills', 'Santa Monica', 'Venice Beach', 'Downtown LA']],
                                            (object)['id' => 62, 'name' => 'San Francisco', 'population' => 875000, 'quartiers' => ['Financial District', 'Mission', 'Castro', 'Haight-Ashbury', 'Chinatown']],
                                        ])
                                    ]
                                ])
                            ]
                        ])
                    ],
                    (object)[
                        'id' => 14,
                        'name' => 'Mexique',
                        'flag_emoji' => '🇲🇽',
                        'image' => null,
                        'provinces' => collect([
                            (object)[
                                'id' => 22,
                                'name' => 'Mexico',
                                'regions' => collect([
                                    (object)[
                                        'id' => 23,
                                        'name' => 'Mexico City',
                                        'villes' => collect([
                                            (object)['id' => 63, 'name' => 'Mexico City', 'population' => 9200000, 'quartiers' => ['Polanco', 'Condesa', 'Roma', 'Coyoacán', 'Zona Rosa']],
                                            (object)['id' => 64, 'name' => 'Guadalajara', 'population' => 1500000, 'quartiers' => ['Centro', 'Zapopan', 'Tlaquepaque', 'Providencia']],
                                        ])
                                    ]
                                ])
                            ]
                        ])
                    ],
                ])
            ],
            (object)[
                'id' => 5,
                'name' => 'Amérique du Sud',
                'code' => 'SA',
                'countries' => collect([
                    (object)[
                        'id' => 12,
                        'name' => 'Brésil',
                        'flag_emoji' => '🇧🇷',
                        'image' => null,
                        'provinces' => collect([
                            (object)[
                                'id' => 17,
                                'name' => 'São Paulo',
                                'regions' => collect([
                                    (object)[
                                        'id' => 17,
                                        'name' => 'Grande São Paulo',
                                        'villes' => collect([
                                            (object)['id' => 45, 'name' => 'São Paulo', 'population' => 12300000, 'quartiers' => ['Paulista', 'Vila Madalena', 'Jardins', 'Pinheiros', 'Centro']],
                                            (object)['id' => 46, 'name' => 'Guarulhos', 'population' => 1400000, 'quartiers' => ['Centro', 'Bonsucesso', 'Gopouva']],
                                            (object)['id' => 47, 'name' => 'Campinas', 'population' => 1200000, 'quartiers' => ['Cambuí', 'Centro', 'Barão Geraldo']],
                                        ])
                                    ]
                                ])
                            ],
                            (object)[
                                'id' => 18,
                                'name' => 'Rio de Janeiro',
                                'regions' => collect([
                                    (object)[
                                        'id' => 18,
                                        'name' => 'Rio Métropole',
                                        'villes' => collect([
                                            (object)['id' => 48, 'name' => 'Rio de Janeiro', 'population' => 6700000, 'quartiers' => ['Copacabana', 'Ipanema', 'Leblon', 'Botafogo', 'Lapa']],
                                            (object)['id' => 49, 'name' => 'Niterói', 'population' => 500000, 'quartiers' => ['Icaraí', 'Centro', 'São Francisco']],
                                        ])
                                    ]
                                ])
                            ]
                        ])
                    ],
                    (object)[
                        'id' => 13,
                        'name' => 'Argentine',
                        'flag_emoji' => '🇦🇷',
                        'image' => null,
                        'provinces' => collect([
                            (object)[
                                'id' => 19,
                                'name' => 'Buenos Aires',
                                'regions' => collect([
                                    (object)[
                                        'id' => 19,
                                        'name' => 'Grand Buenos Aires',
                                        'villes' => collect([
                                            (object)['id' => 50, 'name' => 'Buenos Aires', 'population' => 3100000, 'quartiers' => ['Palermo', 'Recoleta', 'San Telmo', 'Puerto Madero', 'Belgrano']],
                                            (object)['id' => 51, 'name' => 'La Plata', 'population' => 650000, 'quartiers' => ['Centro', 'Tolosa', 'City Bell']],
                                            (object)['id' => 52, 'name' => 'Mar del Plata', 'population' => 620000, 'quartiers' => ['Centro', 'Playa Grande', 'Güemes']],
                                        ])
                                    ]
                                ])
                            ]
                        ])
                    ],
                    (object)[
                        'id' => 14,
                        'name' => 'Colombie',
                        'flag_emoji' => '🇨🇴',
                        'image' => null,
                        'provinces' => collect([
                            (object)[
                                'id' => 20,
                                'name' => 'Cundinamarca',
                                'regions' => collect([
                                    (object)[
                                        'id' => 20,
                                        'name' => 'Bogotá',
                                        'villes' => collect([
                                            (object)['id' => 53, 'name' => 'Bogotá', 'population' => 7400000, 'quartiers' => ['Chapinero', 'Usaquén', 'La Candelaria', 'Zona Rosa']],
                                            (object)['id' => 54, 'name' => 'Medellín', 'population' => 2500000, 'quartiers' => ['El Poblado', 'Laureles', 'Envigado', 'Belén']],
                                        ])
                                    ]
                                ])
                            ]
                        ])
                    ],
                ])
            ],
            (object)[
                'id' => 5,
                'name' => 'Océanie',
                'code' => 'OC',
                'countries' => collect([
                    (object)[
                        'id' => 15,
                        'name' => 'Australie',
                        'flag_emoji' => '🇦🇺',
                        'image' => null,
                        'provinces' => collect([
                            (object)[
                                'id' => 21,
                                'name' => 'Nouvelle-Galles du Sud',
                                'regions' => collect([
                                    (object)[
                                        'id' => 21,
                                        'name' => 'Sydney Métropole',
                                        'villes' => collect([
                                            (object)['id' => 55, 'name' => 'Sydney', 'population' => 5300000, 'quartiers' => ['CBD', 'Bondi', 'Manly', 'Darling Harbour', 'Surry Hills']],
                                            (object)['id' => 56, 'name' => 'Newcastle', 'population' => 320000, 'quartiers' => ['CBD', 'Merewether', 'The Junction']],
                                            (object)['id' => 57, 'name' => 'Wollongong', 'population' => 300000, 'quartiers' => ['CBD', 'North Wollongong', 'Fairy Meadow']],
                                        ])
                                    ]
                                ])
                            ],
                            (object)[
                                'id' => 22,
                                'name' => 'Victoria',
                                'regions' => collect([
                                    (object)[
                                        'id' => 22,
                                        'name' => 'Melbourne Métropole',
                                        'villes' => collect([
                                            (object)['id' => 58, 'name' => 'Melbourne', 'population' => 5100000, 'quartiers' => ['CBD', 'Fitzroy', 'St Kilda', 'Carlton', 'South Yarra']],
                                            (object)['id' => 59, 'name' => 'Geelong', 'population' => 250000, 'quartiers' => ['CBD', 'Newtown', 'Belmont']],
                                        ])
                                    ]
                                ])
                            ]
                        ])
                    ],
                    (object)[
                        'id' => 16,
                        'name' => 'Nouvelle-Zélande',
                        'flag_emoji' => '🇳🇿',
                        'image' => null,
                        'provinces' => collect([
                            (object)[
                                'id' => 23,
                                'name' => 'Auckland',
                                'regions' => collect([
                                    (object)[
                                        'id' => 23,
                                        'name' => 'Auckland Métropole',
                                        'villes' => collect([
                                            (object)['id' => 60, 'name' => 'Auckland', 'population' => 1660000, 'quartiers' => ['CBD', 'Ponsonby', 'Parnell', 'Mission Bay', 'Newmarket']],
                                            (object)['id' => 61, 'name' => 'Manukau', 'population' => 400000, 'quartiers' => ['Manukau City Centre', 'Otara', 'Papatoetoe']],
                                            (object)['id' => 62, 'name' => 'Wellington', 'population' => 420000, 'quartiers' => ['Te Aro', 'Mount Victoria', 'Thorndon', 'Kelburn']],
                                        ])
                                    ]
                                ])
                            ]
                        ])
                    ],
                ])
            ],
        ];
    }

    private static function buildMegaMenuPanel($continents)
    {
        $continents = collect($continents);
        // Find Amérique du Nord continent
        $americaNorth = $continents->firstWhere('name', 'Amérique du Nord');
        $canada = $americaNorth ? $americaNorth->countries->firstWhere('name', 'Canada') : null;
        $quebec = $canada ? $canada->provinces->firstWhere('name', 'Québec') : null;
        $regionQuebec = $quebec ? $quebec->regions->firstWhere('name', 'Région de Québec') : null;
        
        // Set default active country for sidebar
        $firstCountry = $canada;

        $html  = '<div class="destination-mega-menu" id="destinationMegaMenuPanel" style="display:none;position:fixed;left:0;right:0;z-index:999999;">';

        /* ---- BARRE HORIZONTALE ---- */
        $html .= '<div class="destination-top-bar">';
        $html .= '<div class="destination-breadcrumb">';
        // Default breadcrumb: AMÉRIQUE DU NORD / CANADA / QUÉBEC / RÉGION DE QUÉBEC
        if ($americaNorth) {
            $html .= '<a href="' . url('continent/' . $americaNorth->id) . '" class="breadcrumb-link">' . e($americaNorth->name) . '</a>';
        }
        if ($canada) {
            $html .= '<span class="breadcrumb-separator">/</span>';
            $html .= '<a href="' . url('country/' . $canada->id) . '" class="breadcrumb-link">' . e($canada->name) . '</a>';
        }
        if ($quebec) {
            $html .= '<span class="breadcrumb-separator">/</span>';
            $html .= '<a href="' . url('province/' . $quebec->id) . '" class="breadcrumb-link">' . e($quebec->name) . '</a>';
        }
        if ($regionQuebec) {
            $html .= '<span class="breadcrumb-separator">/</span>';
            $html .= '<a href="' . url('region/' . $regionQuebec->id) . '" class="breadcrumb-link active">' . e($regionQuebec->name) . '</a>';
        }
        $html .= '</div>';
        $html .= '</div>'; // fin top-bar

        /* ---- CONTENEUR PRINCIPAL ---- */
        $html .= '<div class="destination-main-container">';

        /* ---- SIDEBAR VERTICALE ---- */
        $html .= '<div class="destination-sidebar">';
        $html .= '<div class="sidebar-search">';
        $html .= '<i class="fas fa-search"></i>';
        $html .= '<input type="text" placeholder="Rechercher une destination..." id="destinationSearchInput">';
        $html .= '</div>';
        $html .= '<div class="sidebar-destinations-list">';

        foreach ($continents as $continent) {
            $html .= '<div class="destination-category">';
            $html .= '<div class="category-header"><i class="fas fa-globe-americas"></i><span>' . e($continent->name) . '</span></div>';

            if ($continent->countries->isNotEmpty()) {
                $html .= '<ul class="destination-items">';
                foreach ($continent->countries as $country) {
                    $active = ($firstCountry && $firstCountry->id === $country->id) ? ' active' : '';
                    $flag   = $country->flag_emoji ? $country->flag_emoji . ' ' : '';
                    
                    // Prepare hierarchical data as JSON for JS
                    $countryData = [
                        'id' => $country->id,
                        'name' => $country->name,
                        'continent' => $continent->name,
                        'flag' => $flag,
                        'image' => $country->image ? asset('storage/' . $country->image) : 'https://picsum.photos/seed/' . $country->id . '/300/200',
                        'provinces' => $country->provinces->map(function($province) {
                            return [
                                'id' => $province->id,
                                'name' => $province->name,
                                'regions' => $province->regions->map(function($region) {
                                    return [
                                        'id' => $region->id,
                                        'name' => $region->name,
                                        'villes' => $region->villes->map(function($ville) {
                                            return [
                                                'id' => $ville->id,
                                                'name' => $ville->name,
                                                'population' => $ville->population
                                            ];
                                        })
                                    ];
                                })
                            ];
                        })
                    ];
                    
                    $html .= '<li><a href="' . url('continent/page/' . $continent->id . '/country/' . $country->id) . '" class="destination-item country-item' . $active . '" data-country="' . htmlspecialchars(json_encode($countryData), ENT_QUOTES, 'UTF-8') . '">' . $flag . e($country->name) . '</a></li>';
                }
                $html .= '</ul>';
            }

            $html .= '</div>';
        }

        $html .= '</div>'; // fin sidebar-destinations-list
        $html .= '</div>'; // fin destination-sidebar

        /* ---- ZONE DE CONTENU ---- */
        $html .= '<div class="destination-content">';
        $html .= '<div class="destination-content-scroll">';
        $html .= '<h2 class="destination-title"><i class="fas fa-map-marked-alt"></i> Région de Québec</h2>';

        // Display destinations from Région de Québec
        if ($regionQuebec && $regionQuebec->villes) {
            // Villes section
            $html .= '<div class="destination-section">';
            $html .= '<h3 class="section-title"><i class="fas fa-city me-2"></i>Villes</h3>';
            $html .= '<div class="destination-grid">';
            
            // City images mapping
            $cityImages = [
                45 => 'https://images.unsplash.com/photo-1608481337062-4093bf3ed404?w=300&h=200&fit=crop', // Ville de Québec
                46 => 'https://images.unsplash.com/photo-1564760055775-d63b17a55c44?w=300&h=200&fit=crop', // Lévis
                47 => 'https://images.unsplash.com/photo-1529704193007-e8c78f0f46f9?w=300&h=200&fit=crop', // Beauport
                48 => 'https://images.unsplash.com/photo-1519451241324-20b4ea2c4220?w=300&h=200&fit=crop', // Sainte-Foy
                49 => 'https://images.unsplash.com/photo-1517935706615-2717063c2225?w=300&h=200&fit=crop', // Charlesbourg
            ];
            
            foreach ($regionQuebec->villes as $ville) {
                $imgUrl = $cityImages[$ville->id] ?? 'https://picsum.photos/seed/' . $ville->id . '/300/200';
                
                $html .= '<a href="' . url('city/' . $ville->id) . '" class="destination-card">';
                $html .= '<img src="' . $imgUrl . '" alt="' . e($ville->name) . '">';
                $html .= '<div class="card-content">';
                $html .= '<h4>' . e($ville->name) . '</h4>';
                $html .= '<p>' . number_format($ville->population) . ' habitants</p>';
                $html .= '</div>';
                $html .= '</a>';
            }
            
            $html .= '</div>'; // fin destination-grid
            $html .= '</div>'; // fin destination-section
            
            // Quartiers section for each ville
            foreach ($regionQuebec->villes as $ville) {
                if (!empty($ville->quartiers)) {
                    $html .= '<div class="destination-section">';
                    $html .= '<h3 class="section-title"><i class="fas fa-building me-2"></i>Quartiers de ' . e($ville->name) . '</h3>';
                    $html .= '<div class="destination-list">';
                    
                    foreach ($ville->quartiers as $quartier) {
                        $html .= '<a href="' . url('quartier/' . $ville->id . '/' . urlencode($quartier)) . '" class="list-item">';
                        $html .= '<i class="fas fa-map-marker-alt"></i>';
                        $html .= '<span>' . e($quartier) . '</span>';
                        $html .= '</a>';
                    }
                    
                    $html .= '</div>'; // fin destination-list
                    $html .= '</div>'; // fin destination-section
                }
            }
        }

        $html .= '</div>'; // fin destination-content-scroll
        $html .= '</div>'; // fin destination-content

        /* ---- SECTION PUBLICITÉS ---- */
        $html .= '<div class="destination-ads">';
        $html .= '<h4><i class="fas fa-ad me-1"></i> Publicités</h4>';
        $html .= '<div class="ad-item"><img src="https://picsum.photos/seed/ad1/250/200" alt="Publicité"><div class="ad-label">Pub</div></div>';
        $html .= '<div class="ad-item"><img src="https://picsum.photos/seed/ad2/250/200" alt="Publicité"><div class="ad-label">Pub</div></div>';
        $html .= '<div class="ad-item"><img src="https://picsum.photos/seed/ad3/250/160" alt="Publicité"><div class="ad-label">Pub</div></div>';
        $html .= '</div>'; // fin destination-ads

        $html .= '</div>'; // fin destination-main-container
        $html .= '</div>'; // fin destination-mega-menu panel

        return $html;
    }

    private static function renderDestinationMegaMenu($continents)
    {
        // Menu Destinations déplacé vers la barre horizontale (horizontal-nav.blade.php)
        // Retourner vide pour ne pas afficher dans le navbar principal
        return '';
    }

    private static function organizeContinentsIntoColumns($continents, $maxColumns = 4)
    {
        $total = $continents->count();
        
        // Vérifier si la collection est vide
        if ($total === 0) {
            return []; // Retourner un tableau vide si aucun continent
        }
        
        // S'assurer qu'on a au moins 1 colonne
        $columns = min($maxColumns, max(1, ceil($total / 3)));
        
        // Éviter la division par zéro
        $itemsPerColumn = ceil($total / $columns);
        $organized = [];
        
        $index = 0;
        for ($col = 0; $col < $columns; $col++) {
            $organized[$col] = [];
            for ($i = 0; $i < $itemsPerColumn && $index < $total; $i++) {
                $organized[$col][] = $continents[$index];
                $index++;
            }
        }
        
        return $organized;
    }

    private static function renderMegaMenu($children)
    {
        $html = '<ul class="dropdown-menu mega-menu">';
        $html .= '<li class="mega-menu-content"><div class="row">';
        
        // Organiser les enfants en colonnes (max 4 colonnes)
        $columns = self::organizeIntoColumns($children, 4);
        
        foreach ($columns as $columnIndex => $columnItems) {
            $html .= '<div class="col-lg-' . (12 / count($columns)) . '">';
            
            foreach ($columnItems as $item) {
                if ($item->level === 0) {
                    $html .= '<ul>';
                    $html .= '<li class="mega-menu-title">';
                    
                    if ($item->icon) {
                        $html .= '<i class="' . $item->icon . ' me-1"></i>';
                    }
                    
                    $html .= $item->final_title . '</li>';
                    
                    // Afficher les sous-enfants de cet item
                    if ($item->activeChildren->isNotEmpty()) {
                        foreach ($item->activeChildren as $subItem) {
                            $html .= '<li>';
                            $html .= '<a href="' . $subItem->final_url . '">';
                            
                            if ($subItem->icon) {
                                $html .= '<i class="' . $subItem->icon . ' me-1"></i>';
                            }
                            
                            $html .= $subItem->final_title . '</a>';
                            $html .= '</li>';
                        }
                    }
                    
                    $html .= '</ul>';
                }
            }
            
            $html .= '</div>';
        }
        
        $html .= '</div></li></ul>';
        
        return $html;
    }

    private static function renderDropdownMenu($children)
    {
        $html = '<ul class="dropdown-menu" style="width:400px;"><div class="mega-menu-content"><div class="row">';
        
        foreach ($children as $child) {
            $hasGrandChildren = $child->activeChildren->isNotEmpty();
            
            $html .= '<div class="col-lg-4"><li class="' . ($hasGrandChildren ? 'mega-menu-title' : '') . '">';
            $html .= '<a href="' . $child->url . '">';
            
            if ($child->icon) {
                $html .= '<i class="' . $child->icon . ' me-1"></i>';
            }
            
            $html .= $child->final_title;
            
            $html .= '</a>';
            
            if ($hasGrandChildren) {
                $html .= '<ul>';
                foreach ($child->activeChildren as $grandChild) {
                    $html .= '<li>';
                    $html .= '<a href="' . $grandChild->url . '">';
                    
                    if ($grandChild->icon) {
                        $html .= '<i class="' . $grandChild->icon . ' me-1"></i>';
                    }
                    
                    $html .= $grandChild->final_title . '</a>';
                    $html .= '</li>';
                }
                $html .= '</ul>';
            }
            
            $html .= '</li></div>';
        }
        
        $html .= '</div></div></ul>';
        
        return $html;
    }

    private static function organizeIntoColumns($items, $maxColumns = 4)
    {
        $totalItems = $items->count();
        $columns = min($maxColumns, ceil($totalItems / 3));
        
        $itemsPerColumn = ceil($totalItems / $columns);
        $organized = [];
        
        $index = 0;
        for ($col = 0; $col < $columns; $col++) {
            $organized[$col] = [];
            for ($i = 0; $i < $itemsPerColumn && $index < $totalItems; $i++) {
                $organized[$col][] = $items[$index];
                $index++;
            }
        }
        
        return $organized;
    }

    private static function shouldBeMegaMenu($menu)
    {
        // Exclure "Destinations" de cette vérification car on le gère séparément
        if ($menu->title === 'Destinations') {
            return false;
        }
        
        $megaMenuTitles = [
            'Business', 'Local', 'Affaires', 
            'Prime Time', 'Web TV', 'Marketplace', 'Plan-N-Go'
        ];
        
        return in_array($menu->title, $megaMenuTitles) || 
               $menu->activeChildren->count() > 5;
    }
}