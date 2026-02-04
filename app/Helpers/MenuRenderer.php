<?php
// app/Helpers/MenuRenderer.php
namespace App\Helpers;

use App\Models\Menu;

class MenuRenderer
{
    public static function renderMenu()
    {
        $menus = Menu::with(['activeChildren' => function($query) {
            $query->with('activeChildren')->orderBy('order');
        }])
        ->whereNull('parent_id')
        ->where('is_active', true)
        ->orderBy('order')
        ->get();

        if ($menus->isEmpty()) {
            return self::renderDefaultMenu();
        }

        return self::buildMenuHtml($menus);
    }

    private static function buildMenuHtml($menus)
    {
        $html = '<!--begin: Main Navigation--><div id="mainMenu"><div class="container"><nav><ul>';
        
        foreach ($menus as $menu) {
            $hasChildren = $menu->activeChildren->isNotEmpty();
            $isMegaMenu = self::shouldBeMegaMenu($menu);
            
            $html .= '<li class="' . ($isMegaMenu ? 'dropdown mega-menu-item' : 'dropdown') . '">';
            $html .= '<a href="' . $menu->final_url . '">';
            
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
        
        $html .= '</ul></nav></div></div><!--end: Main Navigation-->';
        
        return $html;
    }

    private static function renderMegaMenu($children)
    {
        $html = '<ul class="dropdown-menu mega-menu">';
        $html .= '<li class="mega-menu-content"><div class="row">';
        
        // Organiser les enfants en colonnes (max 4 colonnes)
        $columns = self::organizeIntoColumns($children, 3);
        
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
        $html = '<ul class="dropdown-menu" style="width:900px;"><div class="mega-menu-content"><div class="row">';
        
        foreach ($children as $child) {
            $hasGrandChildren = $child->activeChildren->isNotEmpty();
            
            $html .= '<div class="col-lg-4"><li class="' . ($hasGrandChildren ? 'mega-menu-title' : '') . '">';
            $html .= '<a href="' . $child->slug . '">';
            
            if ($child->icon) {
                $html .= '<i class="' . $child->icon . ' me-1"></i>';
            }
            
            $html .= $child->final_title;
            
            // if ($hasGrandChildren) {
            //     $html .= '<i class="fas fa-chevron-right float-end"></i>';
            // }
            
            $html .= '</a>';
            
            if ($hasGrandChildren) {
                $html .= '<ul>';
                foreach ($child->activeChildren as $grandChild) {
                    $html .= '<li>';
                    $html .= '<a href="' . $grandChild->final_url . '">';
                    
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
        // Déterminer si un menu doit être un mega-menu
        // Basé sur le titre ou une propriété personnalisée
        $megaMenuTitles = [
            'Destinations', 'Business', 'Local', 'Affaires', 
            'Prime Time', 'Web TV', 'Marketplace', 'Plan-N-Go'
        ];
        
        return in_array($menu->title, $megaMenuTitles) || 
               $menu->activeChildren->count() > 5;
    }

    private static function renderDefaultMenu()
    {
        return '
        <!--begin: Default Navigation-->
        <div id="mainMenu">
            <div class="container">
                <nav>
                    <ul>
                        <li class="dropdown mega-menu-item">
                            <a href="##">🌍 Destinations</a>
                            <ul class="dropdown-menu">
                                <li class="mega-menu-content">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <ul>
                                                <li class="mega-menu-title">🌍 Continents</li>
                                                <li><a href="/continents/europe">Europe</a></li>
                                                <li><a href="/continents/afrique">Afrique</a></li>
                                                <li><a href="/continents/amerique">Amérique</a></li>
                                                <li><a href="/continents/asie">Asie</a></li>
                                                <li><a href="/continents/oceanie">Océanie</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-4">
                                            <ul>
                                                <li class="mega-menu-title">📍 Régions & Villes</li>
                                                <li><a href="/destinations/villes">Grandes villes</a></li>
                                                <li><a href="/destinations/regions">Régions touristiques</a></li>
                                                <li><a href="/destinations/quartiers">Quartiers populaires</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-4">
                                            <ul>
                                                <li class="mega-menu-title">🏖️ Types de destinations</li>
                                                <li><a href="/types/bord-de-mer">Bord de mer</a></li>
                                                <li><a href="/types/montagne">Montagne</a></li>
                                                <li><a href="/types/desert">Désert</a></li>
                                                <li><a href="/types/nature">Nature & Parcs</a></li>
                                                <li><a href="/types/urbain">Urbain</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li><a href="/business">🏢 Business</a></li>
                        <li><a href="/local">🏛️ Local</a></li>
                        <li><a href="/affaires">💼 Affaires</a></li>
                        <li><a href="/plan-n-go">✈️ Plan-N-Go</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <!--end: Default Navigation-->
        ';
    }
}