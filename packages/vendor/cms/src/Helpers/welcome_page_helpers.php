<?php

if (!function_exists('get_social_links')) {
    /**
     * Get all social media links for the current establishment.
     *
     * @param int|null $etablissementId
     * @return array
     */
    function get_social_links($etablissementId = null)
    {
        $etablissement = $etablissementId 
            ? \App\Models\Etablissement::find($etablissementId)
            : getCurrentEtablissement();
        
        if (!$etablissement) {
            return [];
        }
        
        // Récupérer tous les settings du groupe 'social'
        $settings = \Vendor\Cms\Models\Setting::where('etablissement_id', $etablissement->id)
            ->where('group', 'social')
            ->get();
        
        $socialLinks = [];
        
        // Mapping des clés de base de données vers des noms conviviaux
        $networkMapping = [
            'facebook_url' => ['name' => 'Facebook', 'icon' => 'fab fa-facebook', 'color' => '#1877F2'],
            'twitter_url' => ['name' => 'Twitter', 'icon' => 'fab fa-twitter', 'color' => '#1DA1F2'],
            'instagram_url' => ['name' => 'Instagram', 'icon' => 'fab fa-instagram', 'color' => '#E4405F'],
            'linkedin_url' => ['name' => 'LinkedIn', 'icon' => 'fab fa-linkedin', 'color' => '#0A66C2'],
            'youtube_url' => ['name' => 'YouTube', 'icon' => 'fab fa-youtube', 'color' => '#FF0000'],
            'tiktok_url' => ['name' => 'TikTok', 'icon' => 'fab fa-tiktok', 'color' => '#000000'],
            'pinterest_url' => ['name' => 'Pinterest', 'icon' => 'fab fa-pinterest', 'color' => '#BD081C'],
            'snapchat_url' => ['name' => 'Snapchat', 'icon' => 'fab fa-snapchat', 'color' => '#FFFC00'],
            'whatsapp_url' => ['name' => 'WhatsApp', 'icon' => 'fab fa-whatsapp', 'color' => '#25D366'],
            'telegram_url' => ['name' => 'Telegram', 'icon' => 'fab fa-telegram', 'color' => '#26A5E4'],
            'github_url' => ['name' => 'GitHub', 'icon' => 'fab fa-github', 'color' => '#181717'],
            'discord_url' => ['name' => 'Discord', 'icon' => 'fab fa-discord', 'color' => '#5865F2'],
            'reddit_url' => ['name' => 'Reddit', 'icon' => 'fab fa-reddit', 'color' => '#FF4500'],
            'medium_url' => ['name' => 'Medium', 'icon' => 'fab fa-medium', 'color' => '#000000'],
            'twitch_url' => ['name' => 'Twitch', 'icon' => 'fab fa-twitch', 'color' => '#9146FF'],
            'vk_url' => ['name' => 'VK', 'icon' => 'fab fa-vk', 'color' => '#4680C2'],
            'weibo_url' => ['name' => 'Weibo', 'icon' => 'fab fa-weibo', 'color' => '#E6162D'],
            'tumblr_url' => ['name' => 'Tumblr', 'icon' => 'fab fa-tumblr', 'color' => '#36465D'],
            'flickr_url' => ['name' => 'Flickr', 'icon' => 'fab fa-flickr', 'color' => '#0063DC'],
            'dribbble_url' => ['name' => 'Dribbble', 'icon' => 'fab fa-dribbble', 'color' => '#EA4C89'],
        ];
        
        foreach ($settings as $setting) {
            // Extraire le nom du réseau à partir de la clé (enlever '_url')
            $networkKey = str_replace('_url', '', $setting->key);
            
            if (isset($networkMapping[$setting->key]) && !empty($setting->value)) {
                $socialLinks[$networkKey] = [
                    'url' => $setting->value,
                    'name' => $networkMapping[$setting->key]['name'],
                    'icon' => $networkMapping[$setting->key]['icon'],
                    'color' => $networkMapping[$setting->key]['color'],
                    'key' => $setting->key,
                ];
            }
        }
        
        return $socialLinks;
    }
}

if (!function_exists('get_social_link')) {
    /**
     * Get a specific social media link.
     *
     * @param string $network Network name (facebook, twitter, instagram, etc.)
     * @param int|null $etablissementId
     * @return string|null
     */
    function get_social_link($network, $etablissementId = null)
    {
        $etablissement = $etablissementId 
            ? \App\Models\Etablissement::find($etablissementId)
            : getCurrentEtablissement();
        
        if (!$etablissement) {
            return null;
        }
        
        // Construire la clé complète (ex: 'facebook' -> 'facebook_url')
        $key = $network . '_url';
        
        $setting = \Vendor\Cms\Models\Setting::where('etablissement_id', $etablissement->id)
            ->where('group', 'social')
            ->where('key', $key)
            ->first();
        
        return $setting ? $setting->value : null;
    }
}

if (!function_exists('has_social_link')) {
    /**
     * Check if a specific social media link exists.
     *
     * @param string $network Network name (facebook, twitter, instagram, etc.)
     * @param int|null $etablissementId
     * @return bool
     */
    function has_social_link($network, $etablissementId = null)
    {
        $url = get_social_link($network, $etablissementId);
        return !empty($url);
    }
}

if (!function_exists('has_any_social_link')) {
    /**
     * Check if the establishment has any social media links.
     *
     * @param int|null $etablissementId
     * @return bool
     */
    function has_any_social_link($etablissementId = null)
    {
        $socialLinks = get_social_links($etablissementId);
        return !empty($socialLinks);
    }
}

if (!function_exists('render_social_links')) {
    /**
     * Render social media links as HTML.
     *
     * @param int|null $etablissementId
     * @param string $style (icons, buttons, list, minimal)
     * @param array $options
     * @return string
     */
    function render_social_links($etablissementId = null, $style = 'icons', $options = [])
    {
        $socialLinks = get_social_links($etablissementId);
        
        if (empty($socialLinks)) {
            return '';
        }
        
        $defaultOptions = [
            'target' => '_blank',
            'rel' => 'noopener noreferrer',
            'class' => 'social-link',
            'icon_class' => 'social-icon',
            'show_name' => false,
            'show_color' => false,
            'separator' => '',
            'wrapper_tag' => 'div',
            'wrapper_class' => 'social-links',
            'size' => 'md', // sm, md, lg
        ];
        
        $options = array_merge($defaultOptions, $options);
        
        // Classes de taille
        $sizeClasses = [
            'sm' => 'text-sm',
            'md' => 'text-base',
            'lg' => 'text-lg',
        ];
        
        $sizeClass = $sizeClasses[$options['size']] ?? $sizeClasses['md'];
        
        $html = '<' . $options['wrapper_tag'] . ' class="' . htmlspecialchars($options['wrapper_class']) . ' ' . $sizeClass . '">';
        
        foreach ($socialLinks as $network => $data) {
            $styleClass = '';
            $styleAttr = '';
            
            if ($options['show_color']) {
                $styleAttr = ' style="color: ' . $data['color'] . ';"';
            }
            
            switch ($style) {
                case 'buttons':
                    $styleClass = 'social-button';
                    $html .= '<a href="' . htmlspecialchars($data['url']) . '" 
                                target="' . htmlspecialchars($options['target']) . '" 
                                rel="' . htmlspecialchars($options['rel']) . '"
                                class="' . htmlspecialchars($options['class']) . ' ' . $styleClass . ' social-' . htmlspecialchars($network) . '"
                                ' . $styleAttr . '>
                                <i class="' . htmlspecialchars($data['icon']) . '"></i>
                                ' . ($options['show_name'] ? '<span>' . htmlspecialchars($data['name']) . '</span>' : '') . '
                             </a>';
                    break;
                    
                case 'list':
                    $html .= '<li class="social-item social-' . htmlspecialchars($network) . '">
                                <a href="' . htmlspecialchars($data['url']) . '" 
                                   target="' . htmlspecialchars($options['target']) . '" 
                                   rel="' . htmlspecialchars($options['rel']) . '"
                                   class="' . htmlspecialchars($options['class']) . '"
                                   ' . $styleAttr . '>
                                   ' . ($options['show_name'] ? htmlspecialchars($data['name']) : '<i class="' . htmlspecialchars($data['icon']) . '"></i>') . '
                                </a>
                             </li>';
                    break;
                    
                case 'minimal':
                    $html .= '<a href="' . htmlspecialchars($data['url']) . '" 
                                target="' . htmlspecialchars($options['target']) . '" 
                                rel="' . htmlspecialchars($options['rel']) . '"
                                class="' . htmlspecialchars($options['class']) . ' minimal social-' . htmlspecialchars($network) . '"
                                title="' . htmlspecialchars($data['name']) . '"
                                ' . $styleAttr . '>
                                ' . htmlspecialchars($data['name']) . '
                             </a>';
                    break;
                    
                case 'icons':
                default:
                    $html .= '<a href="' . htmlspecialchars($data['url']) . '" 
                                target="' . htmlspecialchars($options['target']) . '" 
                                rel="' . htmlspecialchars($options['rel']) . '"
                                class="' . htmlspecialchars($options['class']) . ' ' . $styleClass . ' social-' . htmlspecialchars($network) . '"
                                title="' . htmlspecialchars($data['name']) . '"
                                ' . $styleAttr . '>
                                <i class="' . htmlspecialchars($data['icon']) . ' ' . htmlspecialchars($options['icon_class']) . '"></i>
                             </a>';
                    break;
            }
            
            $html .= $options['separator'];
        }
        
        $html .= '</' . $options['wrapper_tag'] . '>';
        
        return $html;
    }
}

if (!function_exists('get_social_link_with_icon')) {
    /**
     * Get social link with icon HTML.
     *
     * @param string $network Network name (facebook, twitter, instagram, etc.)
     * @param int|null $etablissementId
     * @param array $attributes
     * @return string|null
     */
    function get_social_link_with_icon($network, $etablissementId = null, $attributes = [])
    {
        $url = get_social_link($network, $etablissementId);
        
        if (!$url) {
            return null;
        }
        
        // Obtenir les infos du réseau
        $socialLinks = get_social_links($etablissementId);
        $networkInfo = $socialLinks[$network] ?? null;
        
        $defaultAttributes = [
            'href' => $url,
            'target' => '_blank',
            'rel' => 'noopener noreferrer',
            'class' => 'social-link social-' . $network,
            'title' => $networkInfo['name'] ?? ucfirst($network),
        ];
        
        $attributes = array_merge($defaultAttributes, $attributes);
        
        $attrs = '';
        foreach ($attributes as $key => $value) {
            $attrs .= ' ' . $key . '="' . htmlspecialchars($value) . '"';
        }
        
        $iconClass = $networkInfo['icon'] ?? "fab fa-{$network}";
        
        return '<a' . $attrs . '><i class="' . $iconClass . '"></i></a>';
    }
}

if (!function_exists('get_social_links_json')) {
    /**
     * Get social links as JSON for JavaScript.
     *
     * @param int|null $etablissementId
     * @return string
     */
    function get_social_links_json($etablissementId = null)
    {
        $socialLinks = get_social_links($etablissementId);
        return json_encode($socialLinks);
    }
}

if (!function_exists('get_social_share_url')) {
    /**
     * Get share URL for social networks.
     *
     * @param string $network
     * @param string $url
     * @param string $text
     * @return string|null
     */
    function get_social_share_url($network, $url, $text = '')
    {
        $encodedUrl = urlencode($url);
        $encodedText = urlencode($text);
        
        $shareUrls = [
            'facebook' => "https://www.facebook.com/sharer/sharer.php?u={$encodedUrl}",
            'twitter' => "https://twitter.com/intent/tweet?url={$encodedUrl}&text={$encodedText}",
            'linkedin' => "https://www.linkedin.com/sharing/share-offsite/?url={$encodedUrl}",
            'pinterest' => "https://pinterest.com/pin/create/button/?url={$encodedUrl}&description={$encodedText}",
            'whatsapp' => "https://wa.me/?text={$encodedText}%20{$encodedUrl}",
            'telegram' => "https://t.me/share/url?url={$encodedUrl}&text={$encodedText}",
            'reddit' => "https://reddit.com/submit?url={$encodedUrl}&title={$encodedText}",
            'email' => "mailto:?subject={$encodedText}&body={$encodedUrl}",
        ];
        
        return $shareUrls[$network] ?? null;
    }
}

if (!function_exists('render_social_share_buttons')) {
    /**
     * Render social share buttons.
     *
     * @param string $url
     * @param string $title
     * @param array $networks
     * @param array $options
     * @return string
     */
    function render_social_share_buttons($url, $title = '', $networks = ['facebook', 'twitter', 'linkedin', 'whatsapp'], $options = [])
    {
        $defaultOptions = [
            'target' => '_blank',
            'class' => 'share-button',
            'wrapper_tag' => 'div',
            'wrapper_class' => 'share-buttons',
        ];
        
        $options = array_merge($defaultOptions, $options);
        
        $html = '<' . $options['wrapper_tag'] . ' class="' . htmlspecialchars($options['wrapper_class']) . '">';
        
        foreach ($networks as $network) {
            $shareUrl = get_social_share_url($network, $url, $title);
            if ($shareUrl) {
                $html .= '<a href="' . htmlspecialchars($shareUrl) . '" 
                            target="' . htmlspecialchars($options['target']) . '"
                            class="' . htmlspecialchars($options['class']) . ' share-' . htmlspecialchars($network) . '">
                            <i class="fab fa-' . htmlspecialchars($network) . '"></i>
                            <span>' . ucfirst($network) . '</span>
                         </a>';
            }
        }
        
        $html .= '</' . $options['wrapper_tag'] . '>';
        
        return $html;
    }
}

if (!function_exists('update_social_link')) {
    /**
     * Update a social media link in the database.
     *
     * @param string $network
     * @param string $url
     * @param int|null $etablissementId
     * @return bool
     */
    function update_social_link($network, $url, $etablissementId = null)
    {
        $etablissement = $etablissementId 
            ? \App\Models\Etablissement::find($etablissementId)
            : getCurrentEtablissement();
        
        if (!$etablissement) {
            return false;
        }
        
        $key = $network . '_url';
        
        return \Vendor\Cms\Models\Setting::updateOrCreate(
            [
                'etablissement_id' => $etablissement->id,
                'group' => 'social',
                'key' => $key,
            ],
            [
                'value' => $url,
                'type' => 'string',
            ]
        );
    }
}

if (!function_exists('get_social_settings_form')) {
    /**
     * Generate HTML form for social media settings.
     *
     * @param int|null $etablissementId
     * @return string
     */
    function get_social_settings_form($etablissementId = null)
    {
        $socialLinks = get_social_links($etablissementId);
        
        $allNetworks = [
            'facebook_url' => ['label' => 'Facebook', 'icon' => 'fab fa-facebook', 'placeholder' => 'https://facebook.com/votre-page'],
            'twitter_url' => ['label' => 'Twitter', 'icon' => 'fab fa-twitter', 'placeholder' => 'https://twitter.com/votre-compte'],
            'instagram_url' => ['label' => 'Instagram', 'icon' => 'fab fa-instagram', 'placeholder' => 'https://instagram.com/votre-compte'],
            'linkedin_url' => ['label' => 'LinkedIn', 'icon' => 'fab fa-linkedin', 'placeholder' => 'https://linkedin.com/company/votre-entreprise'],
            'youtube_url' => ['label' => 'YouTube', 'icon' => 'fab fa-youtube', 'placeholder' => 'https://youtube.com/c/votre-chaine'],
            'tiktok_url' => ['label' => 'TikTok', 'icon' => 'fab fa-tiktok', 'placeholder' => 'https://tiktok.com/@votre-compte'],
            'pinterest_url' => ['label' => 'Pinterest', 'icon' => 'fab fa-pinterest', 'placeholder' => 'https://pinterest.com/votre-compte'],
        ];
        
        $html = '<div class="social-settings-form">';
        
        foreach ($allNetworks as $key => $network) {
            $currentValue = '';
            foreach ($socialLinks as $link) {
                if ($link['key'] === $key) {
                    $currentValue = $link['url'];
                    break;
                }
            }
            
            $html .= '<div class="form-group mb-3">
                        <label class="form-label">
                            <i class="' . $network['icon'] . '"></i> ' . $network['label'] . '
                        </label>
                        <input type="url" 
                               name="social[' . $key . ']" 
                               class="form-control" 
                               value="' . htmlspecialchars($currentValue) . '"
                               placeholder="' . htmlspecialchars($network['placeholder']) . '">
                      </div>';
        }
        
        $html .= '</div>';
        
        return $html;
    }
}

// ==================== SLIDER HELPERS ====================

if (!function_exists('get_slider_items')) {
    /**
     * Get slider items (images/videos) for the current establishment.
     * 
     * @param int|null $etablissementId
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    function get_slider_items($etablissementId = null, $limit = 10)
    {
        $etablissement = $etablissementId 
            ? \App\Models\Etablissement::find($etablissementId)
            : getCurrentEtablissement();
        
        if (!$etablissement) {
            return collect([]);
        }
        
        // Récupérer les médias du slider depuis les settings
        $sliderItems = \Vendor\Cms\Models\Setting::where('etablissement_id', $etablissement->id)
            ->where('group', 'slider')
            // ->orderBy('order', 'asc')
            ->limit($limit)
            ->get();
        
        if ($sliderItems->isEmpty()) {
            // Fallback: récupérer les médias récents
            return \Vendor\Cms\Models\Media::where('etablissement_id', $etablissement->id)
                ->whereIn('type', ['image', 'video'])
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        }
        
        $items = collect();
        foreach ($sliderItems as $setting) {
            $value = json_decode($setting->value, true);
            if ($value && isset($value['media_id'])) {
                $media = \Vendor\Cms\Models\Media::find($value['media_id']);
                if ($media) {
                    $items->push((object)[
                        'media' => $media,
                        'title' => $value['title'] ?? '',
                        'subtitle' => $value['subtitle'] ?? '',
                        'button_text' => $value['button_text'] ?? '',
                        'button_link' => $value['button_link'] ?? '',
                        'order' => $setting->order ?? 0,
                    ]);
                }
            }
        }
        
        return $items;
    }
}

if (!function_exists('get_slider_html')) {
    /**
     * Render slider HTML with Swiper.js.
     *
     * @param int|null $etablissementId
     * @param array $options
     * @return string
     */
    function get_slider_html($etablissementId = null, $options = [])
    {
        $items = get_slider_items($etablissementId);
        
        if ($items->isEmpty()) {
            return '';
        }
        
        $defaultOptions = [
            'autoplay_delay' => 5500,
            'loop' => true,
            'navigation' => true,
            'pagination' => true,
            'height' => '85vh',
            'min_height' => '550px',
            'overlay_opacity' => 0.65,
        ];
        
        $options = array_merge($defaultOptions, $options);
        
        $sliderId = 'heroSlider_' . uniqid();
        
        $html = '<div class="hero-slider" style="height: ' . $options['height'] . '; min-height: ' . $options['min_height'] . ';">';
        $html .= '<div class="swiper ' . $sliderId . '">';
        $html .= '<div class="swiper-wrapper">';
        
        foreach ($items as $item) {
            $media = $item->media;
            $isVideo = $media->isVideo();
            
            $html .= '<div class="swiper-slide">';
            
            if ($isVideo) {
                $html .= '<video class="slide-media" autoplay muted loop playsinline>';
                $html .= '<source src="' . $media->url . '" type="' . $media->mime_type . '">';
                $html .= '</video>';
            } else {
                $html .= '<img src="' . $media->url . '" class="slide-media" alt="' . e($item->title) . '">';
            }
            
            $html .= '<div class="slide-overlay" style="background: linear-gradient(135deg, rgba(0,0,0,' . $options['overlay_opacity'] . ') 0%, rgba(0,0,0,' . ($options['overlay_opacity'] + 0.1) . ') 100%);">';
            $html .= '<div class="hero-content">';
            
            if ($item->title) {
                $html .= '<h2>' . e($item->title) . '</h2>';
            }
            if ($item->subtitle) {
                $html .= '<p>' . e($item->subtitle) . '</p>';
            }
            
            if ($item->button_text && $item->button_link) {
                $html .= '<div class="btn-group">';
                $html .= '<a href="' . e($item->button_link) . '" class="btn-primary">' . e($item->button_text) . '</a>';
                $html .= '</div>';
            }
            
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }
        
        $html .= '</div>';
        
        if ($options['pagination']) {
            $html .= '<div class="swiper-pagination"></div>';
        }
        if ($options['navigation']) {
            $html .= '<div class="swiper-button-next"></div>';
            $html .= '<div class="swiper-button-prev"></div>';
        }
        
        $html .= '</div>';
        $html .= '</div>';
        
        // JavaScript pour initialiser Swiper
        $html .= '<script>
            document.addEventListener("DOMContentLoaded", function() {
                new Swiper(".' . $sliderId . '", {
                    loop: ' . ($options['loop'] ? 'true' : 'false') . ',
                    autoplay: { delay: ' . $options['autoplay_delay'] . ', disableOnInteraction: false },
                    pagination: { el: ".swiper-pagination", clickable: true },
                    navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" }
                });
            });
        </script>';
        
        return $html;
    }
}

if (!function_exists('has_slider')) {
    /**
     * Check if slider has items.
     *
     * @param int|null $etablissementId
     * @return bool
     */
    function has_slider($etablissementId = null)
    {
        $items = get_slider_items($etablissementId);
        return !$items->isEmpty();
    }
}


// ==================== WHATSAPP HELPERS ====================

if (!function_exists('get_whatsapp_number')) {
    /**
     * Get WhatsApp number for the current establishment.
     *
     * @param int|null $etablissementId
     * @param string $default
     * @return string|null
     */
    function get_whatsapp_number($etablissementId = null, $default = null)
    {
        $etablissement = $etablissementId 
            ? \App\Models\Etablissement::find($etablissementId)
            : getCurrentEtablissement();
        
        if (!$etablissement) {
            return $default;
        }
        
        // Chercher dans les settings d'abord
        $whatsappNumber = $etablissement->getSetting('whatsapp_number', null, 'contact');
        
        if (!$whatsappNumber) {
            // Fallback sur le téléphone de l'établissement
            $whatsappNumber = $etablissement->getSetting('phone', $etablissement->phone, 'general');
        }
        
        // Nettoyer le numéro (garder uniquement chiffres)
        if ($whatsappNumber) {
            $whatsappNumber = preg_replace('/[^0-9]/', '', $whatsappNumber);
        }
        
        return $whatsappNumber ?: $default;
    }
}

if (!function_exists('get_whatsapp_url')) {
    /**
     * Get WhatsApp chat URL.
     *
     * @param string|null $message
     * @param int|null $etablissementId
     * @return string|null
     */
    function get_whatsapp_url($message = null, $etablissementId = null)
    {
        $number = get_whatsapp_number($etablissementId);
        
        if (!$number) {
            return null;
        }
        
        $url = "https://wa.me/{$number}";
        
        if ($message) {
            $url .= "?text=" . urlencode($message);
        }
        
        return $url;
    }
}

if (!function_exists('has_whatsapp')) {
    /**
     * Check if establishment has WhatsApp configured.
     *
     * @param int|null $etablissementId
     * @return bool
     */
    function has_whatsapp($etablissementId = null)
    {
        $number = get_whatsapp_number($etablissementId);
        return !empty($number);
    }
}

if (!function_exists('get_whatsapp_button_html')) {
    /**
     * Get WhatsApp floating button HTML.
     *
     * @param int|null $etablissementId
     * @param array $options
     * @return string
     */
    function get_whatsapp_button_html($etablissementId = null, $options = [])
    {
        if (!has_whatsapp($etablissementId)) {
            return '';
        }
        
        $defaultOptions = [
            'position' => 'bottom-right',
            'size' => '60px',
            'message' => null,
            'tooltip' => 'WhatsApp nous',
            'class' => 'btn-wa',
        ];
        
        $options = array_merge($defaultOptions, $options);
        
        $url = get_whatsapp_url($options['message'], $etablissementId);
        
        $positionClasses = [
            'bottom-right' => 'bottom: 24px; right: 24px;',
            'bottom-left' => 'bottom: 24px; left: 24px;',
            'top-right' => 'top: 24px; right: 24px;',
            'top-left' => 'top: 24px; left: 24px;',
        ];
        
        $positionStyle = $positionClasses[$options['position']] ?? $positionClasses['bottom-right'];
        
        $html = '<a href="' . $url . '" 
                    target="_blank" 
                    rel="noopener noreferrer"
                    class="' . $options['class'] . '"
                    style="position: fixed; ' . $positionStyle . ' width: ' . $options['size'] . '; height: ' . $options['size'] . '; background: #25D366; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: calc(' . $options['size'] . ' * 0.5); color: white; z-index: 999; box-shadow: 0 4px 15px rgba(0,0,0,0.2); transition: transform 0.2s; text-decoration: none;"
                    title="' . e($options['tooltip']) . '">';
        $html .= '<i class="fab fa-whatsapp"></i>';
        $html .= '</a>';
        
        $html .= '<style>
            .' . $options['class'] . ':hover {
                transform: scale(1.08);
                background: #20b859 !important;
            }
        </style>';
        
        return $html;
    }
}

if (!function_exists('get_whatsapp_link')) {
    /**
     * Get simple WhatsApp link HTML.
     *
     * @param string $text
     * @param int|null $etablissementId
     * @param array $attributes
     * @return string|null
     */
    function get_whatsapp_link($text = 'WhatsApp', $etablissementId = null, $attributes = [])
    {
        $url = get_whatsapp_url(null, $etablissementId);
        
        if (!$url) {
            return null;
        }
        
        $defaultAttributes = [
            'href' => $url,
            'target' => '_blank',
            'rel' => 'noopener noreferrer',
            'class' => 'whatsapp-link',
        ];
        
        $attributes = array_merge($defaultAttributes, $attributes);
        
        $attrs = '';
        foreach ($attributes as $key => $value) {
            $attrs .= ' ' . $key . '="' . e($value) . '"';
        }
        
        return '<a' . $attrs . '><i class="fab fa-whatsapp"></i> ' . e($text) . '</a>';
    }
}


// ==================== MÉDIA SLIDER HELPERS ====================

if (!function_exists('add_slider_item')) {
    /**
     * Add an item to the slider.
     *
     * @param int $mediaId
     * @param array $data
     * @param int|null $etablissementId
     * @return \Vendor\Cms\Models\Setting|null
     */
    function add_slider_item($mediaId, $data = [], $etablissementId = null)
    {
        $etablissement = $etablissementId 
            ? \App\Models\Etablissement::find($etablissementId)
            : getCurrentEtablissement();
        
        if (!$etablissement) {
            return null;
        }
        
        $media = \Vendor\Cms\Models\Media::find($mediaId);
        if (!$media) {
            return null;
        }
        
        // Compter le nombre d'items existants pour l'ordre
        $count = \Vendor\Cms\Models\Setting::where('etablissement_id', $etablissement->id)
            ->where('group', 'slider')
            ->count();
        
        $value = json_encode([
            'media_id' => $mediaId,
            'title' => $data['title'] ?? '',
            'subtitle' => $data['subtitle'] ?? '',
            'button_text' => $data['button_text'] ?? '',
            'button_link' => $data['button_link'] ?? '',
        ]);
        
        return \Vendor\Cms\Models\Setting::create([
            'etablissement_id' => $etablissement->id,
            'group' => 'slider',
            'key' => 'slider_item_' . ($count + 1),
            'value' => $value,
            'type' => 'json',
            'order' => $count + 1,
        ]);
    }
}

if (!function_exists('remove_slider_item')) {
    /**
     * Remove an item from the slider.
     *
     * @param int $itemId
     * @param int|null $etablissementId
     * @return bool
     */
    function remove_slider_item($itemId, $etablissementId = null)
    {
        $etablissement = $etablissementId 
            ? \App\Models\Etablissement::find($etablissementId)
            : getCurrentEtablissement();
        
        if (!$etablissement) {
            return false;
        }
        
        $setting = \Vendor\Cms\Models\Setting::where('etablissement_id', $etablissement->id)
            ->where('group', 'slider')
            ->where('id', $itemId)
            ->first();
        
        if ($setting) {
            return $setting->delete();
        }
        
        return false;
    }
}

if (!function_exists('update_slider_order')) {
    /**
     * Update slider items order.
     *
     * @param array $order (['item_id' => order_number])
     * @param int|null $etablissementId
     * @return bool
     */
    function update_slider_order($order, $etablissementId = null)
    {
        $etablissement = $etablissementId 
            ? \App\Models\Etablissement::find($etablissementId)
            : getCurrentEtablissement();
        
        if (!$etablissement) {
            return false;
        }
        
        foreach ($order as $itemId => $orderNumber) {
            \Vendor\Cms\Models\Setting::where('etablissement_id', $etablissement->id)
                ->where('group', 'slider')
                ->where('id', $itemId)
                ->update(['order' => $orderNumber]);
        }
        
        return true;
    }
}