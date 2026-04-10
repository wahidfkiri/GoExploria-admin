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

// ==================== SLIDER HELPERS (sans Media) ====================

if (!function_exists('get_slider_items')) {
    function get_slider_items($etablissementId = null, $limit = 10)
    {
        $etablissement = $etablissementId 
            ? \App\Models\Etablissement::find($etablissementId)
            : getCurrentEtablissement();
        
        if (!$etablissement) {
            return collect([]);
        }
        
        $sliderSettings = \Vendor\Cms\Models\Setting::where('etablissement_id', $etablissement->id)
            ->where('group', 'slider')
            ->limit($limit)
            ->get();
        
        $items = collect();
        
        foreach ($sliderSettings as $setting) {
            $value = null;
            
            if (is_string($setting->value)) {
                $value = json_decode($setting->value, true);
                if ($value === null && !empty($setting->value)) {
                    $cleanValue = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $setting->value);
                    $value = json_decode($cleanValue, true);
                }
            } elseif (is_array($setting->value)) {
                $value = $setting->value;
            }
            
            if ($value && isset($value['type'])) {
                $mediaUrl = $value['url'] ?? '';
                
                // Construire l'URL pour le poster de la vidéo
                $posterUrl = $value['poster_url'] ?? '';
                if ($posterUrl && !filter_var($posterUrl, FILTER_VALIDATE_URL) && !str_starts_with($posterUrl, 'http')) {
                    $posterUrl = \Storage::disk('public')->url($posterUrl);
                }
                
                // Construire l'URL complète
                if ($mediaUrl && !filter_var($mediaUrl, FILTER_VALIDATE_URL) && !str_starts_with($mediaUrl, 'http')) {
                    $mediaUrl = \Storage::disk('public')->url($mediaUrl);
                }
                
                $items->push((object)[
                    'id' => $setting->id,
                    'type' => $value['type'] ?? 'image',
                    'url' => $mediaUrl,
                    'poster_url' => $posterUrl,  // 🔥 Ajout du poster pour les vidéos
                    'title' => $value['title'] ?? '',
                    'subtitle' => $value['subtitle'] ?? '',
                    'button_text' => $value['button_text'] ?? '',
                    'button_link' => $value['button_link'] ?? '',
                    'order' => $setting->order ?? 0,
                    'is_active' => $value['is_active'] ?? true,
                    'video_html' => $value['video_html'] ?? null,
                ]);
            }
        }
        
        $items = $items->filter(function($item) {
            return $item->is_active === true;
        });
        
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
            'overlay_color' => 'rgba(0,0,0,0.5)',
            'video_autoplay' => true,
            'video_muted' => true,
            'video_loop' => true,
        ];
        
        $options = array_merge($defaultOptions, $options);
        
        $sliderId = 'heroSlider_' . uniqid();
        
        $html = '<div class="hero-slider" style="height: ' . $options['height'] . '; min-height: ' . $options['min_height'] . ';">';
        $html .= '<div class="swiper ' . $sliderId . '">';
        $html .= '<div class="swiper-wrapper">';
        
        foreach ($items as $index => $item) {
            $html .= '<div class="swiper-slide" data-type="' . $item->type . '" data-index="' . $index . '">';
            
            // GESTION DES VIDÉOS
if ($item->type === 'video') {
    // Vérifier si c'est une vidéo locale ou externe
    $videoUrl = $item->url;
    
    // Poster image (thumbnail)
    $posterUrl = $item->poster_url ?? '';
    
    $html .= '<video class="slide-video" 
        ' . ($options['video_autoplay'] ? 'autoplay' : '') . '
        ' . ($options['video_muted'] ? 'muted' : '') . '
        ' . ($options['video_loop'] ? 'loop' : '') . '
        playsinline
        ' . ($posterUrl ? 'poster="' . e($posterUrl) . '"' : '') . '>';
    $html .= '<source src="' . e($videoUrl) . '" type="video/mp4">';
    $html .= 'Votre navigateur ne supporte pas la vidéo.';
    $html .= '</video>';
} 
            // 🔥 GESTION DES IMAGES
            else {
                $html .= '<img src="' . e($item->url) . '" class="slide-media" alt="' . e($item->title) . '" loading="lazy">';
            }
            
            // Overlay avec contenu textuel (commun aux images et vidéos)
            if ($item->title || $item->subtitle || $item->button_text) {
                $html .= '<div class="slide-overlay" style="background: linear-gradient(135deg, ' . $options['overlay_color'] . ' 0%, rgba(0,0,0,' . ($options['overlay_opacity'] + 0.1) . ') 100%);">';
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
            }
            
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
        
        // JavaScript pour initialiser Swiper et gérer les vidéos
        $html .= '<script>
            if (typeof Swiper !== "undefined") {
                document.addEventListener("DOMContentLoaded", function() {
                    const swiper = new Swiper(".' . $sliderId . '", {
                        loop: ' . ($options['loop'] ? 'true' : 'false') . ',
                        autoplay: { delay: ' . $options['autoplay_delay'] . ', disableOnInteraction: false },
                        pagination: { el: ".swiper-pagination", clickable: true },
                        navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
                        on: {
                            slideChangeTransitionStart: function() {
                                // Pause toutes les vidéos quand on change de slide
                                const videos = document.querySelectorAll(".' . $sliderId . ' video");
                                videos.forEach(video => {
                                    video.pause();
                                });
                            },
                            slideChangeTransitionEnd: function() {
                                // Lecture auto de la vidéo sur le slide actif
                                const activeSlide = document.querySelector(".' . $sliderId . ' .swiper-slide-active");
                                const video = activeSlide ? activeSlide.querySelector("video") : null;
                                if (video && ' . ($options['video_autoplay'] ? 'true' : 'false') . ') {
                                    video.play();
                                }
                            }
                        }
                    });
                });
            }
        </script>';
        
        // Styles CSS pour les vidéos
        $html .= '<style>
            .hero-slider .swiper-slide {
                position: relative;
                overflow: hidden;
            }
            .hero-slider .slide-media,
            .hero-slider .slide-video,
            .hero-slider .video-wrapper-youtube,
            .hero-slider .video-wrapper-vimeo,
            .hero-slider .video-wrapper-embed {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            .hero-slider .slide-video-iframe,
            .hero-slider .video-wrapper-embed iframe {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                border: 0;
                object-fit: cover;
            }
            .hero-slider .video-wrapper-youtube,
            .hero-slider .video-wrapper-vimeo,
            .hero-slider .video-wrapper-embed {
                background: #000;
            }
            .hero-slider .slide-overlay {
                position: absolute;
                inset: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                color: white;
                z-index: 10;
            }
            .hero-slider .hero-content {
                max-width: 800px;
                padding: 0 20px;
            }
            .hero-slider .hero-content h2 {
                font-size: 3rem;
                font-weight: 800;
                margin-bottom: 20px;
                text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
            }
            .hero-slider .hero-content p {
                font-size: 1.2rem;
                margin-bottom: 32px;
            }
            .hero-slider .btn-group {
                display: flex;
                gap: 16px;
                justify-content: center;
                flex-wrap: wrap;
            }
            @media (max-width: 768px) {
                .hero-slider .hero-content h2 {
                    font-size: 1.8rem;
                }
                .hero-slider .hero-content p {
                    font-size: 1rem;
                }
            }
        </style>';
        
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

if (!function_exists('add_slider_item')) {
    /**
     * Add an item to the slider.
     *
     * @param string $type 'image' or 'video'
     * @param string $url URL or storage path
     * @param array $data
     * @param int|null $etablissementId
     * @return \Vendor\Cms\Models\Setting|null
     */
    function add_slider_item($type, $url, $data = [], $etablissementId = null)
    {
        $etablissement = $etablissementId 
            ? \App\Models\Etablissement::find($etablissementId)
            : getCurrentEtablissement();
        
        if (!$etablissement) {
            return null;
        }
        
        // Compter le nombre d'items existants pour l'ordre
        $count = \Vendor\Cms\Models\Setting::where('etablissement_id', $etablissement->id)
            ->where('group', 'slider')
            ->count();
        
        $value = json_encode([
            'type' => $type,
            'url' => $url,
            'title' => $data['title'] ?? '',
            'subtitle' => $data['subtitle'] ?? '',
            'button_text' => $data['button_text'] ?? '',
            'button_link' => $data['button_link'] ?? '',
            'video_html' => $data['video_html'] ?? null,
            'is_active' => $data['is_active'] ?? true,
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

if (!function_exists('update_slider_item')) {
    /**
     * Update a slider item.
     *
     * @param int $itemId
     * @param array $data
     * @param int|null $etablissementId
     * @return bool
     */
    function update_slider_item($itemId, $data, $etablissementId = null)
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
        
        if (!$setting) {
            return false;
        }
        
        $currentValue = json_decode($setting->value, true);
        $newValue = array_merge($currentValue, $data);
        
        return $setting->update([
            'value' => json_encode($newValue)
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
        
        return \Vendor\Cms\Models\Setting::where('etablissement_id', $etablissement->id)
            ->where('group', 'slider')
            ->where('id', $itemId)
            ->delete();
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
        
        if (!$etabolissement) {
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

if (!function_exists('get_slider_settings_form')) {
    /**
     * Generate HTML form for slider settings.
     *
     * @param int|null $etablissementId
     * @return string
     */
    function get_slider_settings_form($etablissementId = null)
    {
        $items = get_slider_items($etablissementId);
        
        $html = '<div class="slider-settings-form">';
        $html .= '<div class="slider-items-list">';
        
        foreach ($items as $item) {
            $html .= '<div class="slider-item" data-id="' . $item->id . '">';
            $html .= '<div class="slider-item-preview">';
            
            if ($item->type === 'video') {
                $html .= '<video src="' . e($item->url) . '" style="width: 100px; height: 60px; object-fit: cover;"></video>';
            } else {
                $html .= '<img src="' . e($item->url) . '" style="width: 100px; height: 60px; object-fit: cover;">';
            }
            
            $html .= '</div>';
            $html .= '<div class="slider-item-info">';
            $html .= '<h4>' . e($item->title) . '</h4>';
            $html .= '<p>' . e($item->subtitle) . '</p>';
            $html .= '</div>';
            $html .= '<div class="slider-item-actions">';
            $html .= '<button type="button" class="btn-edit" data-id="' . $item->id . '">Modifier</button>';
            $html .= '<button type="button" class="btn-delete" data-id="' . $item->id . '">Supprimer</button>';
            $html .= '<span class="drag-handle"><i class="fas fa-grip-vertical"></i></span>';
            $html .= '</div>';
            $html .= '</div>';
        }
        
        $html .= '</div>';
        
        $html .= '<div class="slider-add-form">';
        $html .= '<h3>Ajouter un slide</h3>';
        $html .= '<div class="form-group">';
        $html .= '<label>Type</label>';
        $html .= '<select name="type" class="slider-type">';
        $html .= '<option value="image">Image</option>';
        $html .= '<option value="video">Vidéo</option>';
        $html .= '</select>';
        $html .= '</div>';
        $html .= '<div class="form-group">';
        $html .= '<label>URL du fichier (ou chemin Storage)</label>';
        $html .= '<input type="text" name="url" class="slider-url" placeholder="/uploads/slide1.jpg ou https://...">';
        $html .= '</div>';
        $html .= '<div class="form-group">';
        $html .= '<label>Titre</label>';
        $html .= '<input type="text" name="title" class="slider-title">';
        $html .= '</div>';
        $html .= '<div class="form-group">';
        $html .= '<label>Sous-titre</label>';
        $html .= '<input type="text" name="subtitle" class="slider-subtitle">';
        $html .= '</div>';
        $html .= '<div class="form-group">';
        $html .= '<label>Texte du bouton</label>';
        $html .= '<input type="text" name="button_text" class="slider-button-text">';
        $html .= '</div>';
        $html .= '<div class="form-group">';
        $html .= '<label>Lien du bouton</label>';
        $html .= '<input type="text" name="button_link" class="slider-button-link">';
        $html .= '</div>';
        $html .= '<button type="button" class="btn-add-slide">Ajouter</button>';
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
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
        $whatsappNumber = $etablissement->getSetting('phone', null, 'company');
        
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



// ==================== MAP POINT HELPERS ====================
// Add these functions to your welcome_page_helpers.php file

if (!function_exists('has_map_points')) {
    /**
     * Check if the current establishment has active map points.
     *
     * @param int|null $etablissementId
     * @return bool
     */
    function has_map_points($etablissementId = null)
    {
        $etablissement = $etablissementId
            ? \App\Models\Etablissement::find($etablissementId)
            : getCurrentEtablissement();

        if (!$etablissement) {
            return false;
        }

        try {
            return \App\Models\MapPoint::where('etablissement_id', $etablissement->id)
                ->exists();
        } catch (\Exception $e) {
            \Log::error('has_map_points error: ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('get_map_points')) {
    /**
     * Get all active map points for the current establishment.
     *
     * @param int|null  $etablissementId
     * @param array     $options  ['limit' => 50, 'category' => null, 'with_details' => false]
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function get_map_points($etablissementId = null, array $options = [])
    {
        $etablissement = $etablissementId
            ? \App\Models\Etablissement::find($etablissementId)
            : getCurrentEtablissement();

        if (!$etablissement) {
            return collect();
        }

        $defaults = [
            'limit'        => 50,
            'category'     => null,
            'with_details' => false,
        ];
        $options = array_merge($defaults, $options);

        try {
            $with = ['images', 'mainImage'];
            if ($options['with_details']) {
                $with[] = 'details';
            }

            $query = \App\Models\MapPoint::with($with)
                ->active()
                ->where('etablissement_id', $etablissement->id)
                ->orderBy('is_featured', 'desc')
                ->orderBy('views', 'desc');

            if (!empty($options['category'])) {
                $query->byCategory($options['category']);
            }

            return $query->limit((int) $options['limit'])->get();

        } catch (\Exception $e) {
            \Log::error('get_map_points error: ' . $e->getMessage());
            return collect();
        }
    }
}

if (!function_exists('get_map_points_json')) {
    /**
     * Get map points serialised as JSON — ready to be injected into a JS variable.
     *
     * @param int|null $etablissementId
     * @param array    $options  Forwarded to get_map_points()
     * @return string  JSON string
     */
    function get_map_points_json($etablissementId = null, array $options = [])
    {
        $points = get_map_points($etablissementId, $options);

        $data = $points->map(function ($point) {
            $thumbnail = null;

            if ($point->youtube_id) {
                $thumbnail = "https://img.youtube.com/vi/{$point->youtube_id}/hqdefault.jpg";
            } elseif ($point->main_image) {
                $thumbnail = asset('storage/' . $point->main_image);
            } elseif ($point->mainImage) {
                $thumbnail = $point->mainImage->url;
            }

            return [
                'id'          => $point->id,
                'title'       => $point->title,
                'description' => $point->description,
                'category'    => $point->category,
                'type'        => $point->type,
                'latitude'    => (float) $point->latitude,
                'longitude'   => (float) $point->longitude,
                'adresse'     => $point->adresse,
                'ville'       => $point->ville,
                'thumbnail'   => $thumbnail,
                'details_url' => $point->has_details_page ? $point->details_url : null,
                'is_featured' => (bool) $point->is_featured,
                'youtube_id'  => $point->youtube_id,
            ];
        });

        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
    }
}

if (!function_exists('get_map_center')) {
    /**
     * Compute the geographic center (centroid) of all map points for the establishment.
     * Falls back to a default center if no points exist.
     *
     * @param int|null $etablissementId
     * @param array    $default  ['lat' => 46.8, 'lng' => -71.2]  (Québec default)
     * @return array   ['lat' => float, 'lng' => float]
     */
    function get_map_center($etablissementId = null, array $default = ['lat' => 46.8, 'lng' => -71.2])
    {
        $etablissement = $etablissementId
            ? \App\Models\Etablissement::find($etablissementId)
            : getCurrentEtablissement();

        if (!$etablissement) {
            return $default;
        }

        try {
            $result = \App\Models\MapPoint::active()
                ->where('etablissement_id', $etablissement->id)
                ->selectRaw('AVG(latitude) as avg_lat, AVG(longitude) as avg_lng')
                ->first();

            if ($result && $result->avg_lat && $result->avg_lng) {
                return [
                    'lat' => round((float) $result->avg_lat, 6),
                    'lng' => round((float) $result->avg_lng, 6),
                ];
            }
        } catch (\Exception $e) {
            \Log::error('get_map_center error: ' . $e->getMessage());
        }

        return $default;
    }
}

if (!function_exists('get_map_section_html')) {
    /**
     * Render the full interactive Leaflet map section HTML.
     *
     * Injects Leaflet CSS/JS (from CDN), renders all active map points as markers,
     * and shows a styled popup card on click.
     *
     * @param int|null $etablissementId
     * @param array    $options
     *   - height        string   CSS height of the map container  (default '480px')
     *   - zoom          int      Initial zoom level               (default 11)
     *   - title         string   Section heading                  (default 'Nous trouver')
     *   - show_title    bool     Display the section heading      (default true)
     *   - tile_url      string   Leaflet tile URL template        (default OSM)
     *   - limit         int      Max points to load               (default 50)
     * @return string  HTML string (safe to echo with {!! !!})
     */
    function get_map_section_html($etablissementId = null, array $options = [])
    {
        if (!has_map_points($etablissementId)) {
            return '';
        }

        $defaults = [
            'height'     => '480px',
            'zoom'       => 11,
            'title'      => 'Nous trouver',
            'show_title' => true,
            'tile_url'   => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            'limit'      => 50,
        ];
        $options = array_merge($defaults, $options);

        $center      = get_map_center($etablissementId);
        $pointsJson  = get_map_points_json($etablissementId, ['limit' => $options['limit']]);
        $mapId       = 'map-' . uniqid();
        $height      = htmlspecialchars($options['height']);
        $zoom        = (int) $options['zoom'];
        $tileUrl     = htmlspecialchars($options['tile_url']);
        $centerLat   = $center['lat'];
        $centerLng   = $center['lng'];
        $sectionTitle = htmlspecialchars($options['title']);

        $titleHtml = $options['show_title']
            ? '<h2 class="map-section-title">' . $sectionTitle . '</h2>'
            : '';

        $html = <<<HTML
<!-- Leaflet Map Section -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
<section class="map-section" aria-label="Carte des points d'intérêt">
    <div class="map-section-inner">
        {$titleHtml}
        <div id="{$mapId}" class="map-container" style="height:{$height}; width:100%; border-radius:12px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.12);"></div>
    </div>
</section>
<style>
.map-section {
    padding: 60px 0 0;
    background: transparent;
}
.map-section-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}
.map-section-title {
    text-align: center;
    margin-bottom: 28px;
    font-size: 2rem;
    font-weight: 700;
    color: var(--color-heading, #1a1a2e);
    letter-spacing: -0.5px;
}
/* Leaflet popup overrides */
.leaflet-popup-content-wrapper {
    border-radius: 12px;
    padding: 0;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0,0,0,0.18);
    min-width: 220px;
    max-width: 280px;
}
.leaflet-popup-content {
    margin: 0;
    width: 100% !important;
}
.leaflet-popup-tip-container { margin-top: -1px; }
.map-popup-img {
    width: 100%;
    height: 130px;
    object-fit: cover;
    display: block;
}
.map-popup-body {
    padding: 12px 14px 14px;
}
.map-popup-category {
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--color-primary, #e05c00);
    margin-bottom: 4px;
}
.map-popup-title {
    font-size: 1rem;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0 0 4px;
    line-height: 1.3;
}
.map-popup-address {
    font-size: 0.8rem;
    color: #666;
    margin-bottom: 10px;
    display: flex;
    align-items: flex-start;
    gap: 4px;
}
.map-popup-desc {
    font-size: 0.82rem;
    color: #444;
    margin-bottom: 10px;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.map-popup-link {
    display: inline-block;
    padding: 6px 14px;
    background: var(--color-primary, #e05c00);
    color: #fff !important;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: opacity 0.2s;
}
.map-popup-link:hover { opacity: 0.85; }
</style>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV/XN2GqvE=" crossorigin=""></script>
<script>
(function() {
    function initMap() {
        if (typeof L === 'undefined') {
            setTimeout(initMap, 100);
            return;
        }

        var mapEl = document.getElementById('{$mapId}');
        if (!mapEl) return;

        var map = L.map('{$mapId}', {
            center: [{$centerLat}, {$centerLng}],
            zoom: {$zoom},
            scrollWheelZoom: false
        });

        L.tileLayer('{$tileUrl}', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            maxZoom: 19
        }).addTo(map);

        // Enable scroll zoom on click
        map.once('focus', function() { map.scrollWheelZoom.enable(); });

        var points = {$pointsJson};

        if (!points || points.length === 0) return;

        var bounds = [];

        points.forEach(function(point) {
            if (!point.latitude || !point.longitude) return;

            var latlng = [point.latitude, point.longitude];
            bounds.push(latlng);

            var marker = L.marker(latlng).addTo(map);

            // Build popup HTML
            var imgHtml = '';
            if (point.thumbnail) {
                imgHtml = '<img class="map-popup-img" src="' + point.thumbnail + '" alt="' + (point.title || '') + '" loading="lazy">';
            }

            var addressHtml = '';
            if (point.adresse || point.ville) {
                var addr = [point.adresse, point.ville].filter(Boolean).join(', ');
                addressHtml = '<p class="map-popup-address"><i class="fas fa-map-marker-alt" style="color:var(--color-primary,#e05c00);margin-top:2px"></i> ' + addr + '</p>';
            }

            var descHtml = '';
            if (point.description) {
                descHtml = '<p class="map-popup-desc">' + point.description + '</p>';
            }

            var linkHtml = '';
            if (point.details_url) {
                linkHtml = '<a href="' + point.details_url + '" class="map-popup-link">Voir plus</a>';
            }

            var categoryHtml = '';
            if (point.category) {
                categoryHtml = '<div class="map-popup-category">' + point.category + '</div>';
            }

            var popupContent =
                '<div>' +
                imgHtml +
                '<div class="map-popup-body">' +
                categoryHtml +
                '<p class="map-popup-title">' + (point.title || '') + '</p>' +
                addressHtml +
                descHtml +
                linkHtml +
                '</div></div>';

            marker.bindPopup(popupContent, { maxWidth: 280, minWidth: 220 });
        });

        // Fit map to all markers if more than one
        if (bounds.length > 1) {
            map.fitBounds(bounds, { padding: [40, 40], maxZoom: 14 });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMap);
    } else {
        initMap();
    }
})();
</script>
HTML;

        return $html;
    }
}