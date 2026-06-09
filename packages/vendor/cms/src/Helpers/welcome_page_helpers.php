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

if (!function_exists('cms_header_footer_setting_enabled')) {
    /**
     * Check whether a CMS header/footer slot is explicitly enabled for an establishment.
     */
    function cms_header_footer_setting_enabled($etablissementId, string $key): bool
    {
        if (empty($etablissementId)) {
            return false;
        }

        try {
            $setting = \Vendor\Cms\Models\Setting::where('etablissement_id', $etablissementId)
                ->whereIn('group', ['general', 'layout', 'header_footer', 'header', 'footer'])
                ->where('key', $key)
                ->orderByRaw("CASE WHEN `group` = 'general' THEN 0 WHEN `group` = 'layout' THEN 1 ELSE 2 END")
                ->first();

            if (!$setting) {
                return false;
            }

            $value = $setting->value;
            if (is_bool($value)) {
                return $value;
            }

            return in_array(strtolower(trim((string) $value)), ['1', 'true', 'yes', 'on', 'enabled', 'active'], true);
        } catch (\Throwable $e) {
            \Log::warning('cms_header_footer_setting_enabled error: ' . $e->getMessage(), [
                'etablissement_id' => $etablissementId,
                'key' => $key,
            ]);

            return false;
        }
    }
}

if (!function_exists('is_cms_header_enabled')) {
    function is_cms_header_enabled($etablissementId): bool
    {
        return cms_header_footer_setting_enabled($etablissementId, 'header_enabled');
    }
}

if (!function_exists('is_cms_footer_enabled')) {
    function is_cms_footer_enabled($etablissementId): bool
    {
        return cms_header_footer_setting_enabled($etablissementId, 'footer_enabled');
    }
}

if (!function_exists('get_cms_header_footer_html')) {
    /**
     * Render the latest configured CMS header/footer content for an establishment.
     */
    function get_cms_header_footer_html($etablissementId, string $type): string
    {
        if (empty($etablissementId)) {
            return '';
        }

        try {
            if (!\Illuminate\Support\Facades\Schema::connection('cms')->hasTable('cms_header_footers')) {
                return '';
            }

            $type = $type === \Vendor\Cms\Models\HeaderFooter::TYPE_FOOTER
                ? \Vendor\Cms\Models\HeaderFooter::TYPE_FOOTER
                : \Vendor\Cms\Models\HeaderFooter::TYPE_HEADER;

            $content = \Vendor\Cms\Models\HeaderFooter::query()
                ->where('etablissement_id', $etablissementId)
                ->forType($type)
                ->latest('updated_at')
                ->first();

            return $content ? $content->rendered_content : '';
        } catch (\Throwable $e) {
            \Log::warning('get_cms_header_footer_html error: ' . $e->getMessage(), [
                'etablissement_id' => $etablissementId,
                'type' => $type,
            ]);

            return '';
        }
    }
}

if (!function_exists('get_cms_header_html')) {
    function get_cms_header_html($etablissementId): string
    {
        return is_cms_header_enabled($etablissementId)
            ? get_cms_header_footer_html($etablissementId, \Vendor\Cms\Models\HeaderFooter::TYPE_HEADER)
            : '';
    }
}

if (!function_exists('get_cms_footer_html')) {
    function get_cms_footer_html($etablissementId): string
    {
        return is_cms_footer_enabled($etablissementId)
            ? get_cms_header_footer_html($etablissementId, \Vendor\Cms\Models\HeaderFooter::TYPE_FOOTER)
            : '';
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
        $hasRenderableSliderMedia = static function ($item): bool {
            $type = strtolower((string) ($item->type ?? 'image')) === 'video' ? 'video' : 'image';
            $url = trim((string) ($item->url ?? ''));

            if ($url === '' || in_array(strtolower($url), ['null', 'undefined', '#'], true)) {
                return false;
            }

            if ($type === 'video') {
                return true;
            }

            return (bool) preg_match('/\.(jpg|jpeg|png|gif|webp|avif|svg)(\?.*)?$/i', $url);
        };

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
        
        $items = $items->filter(function($item) use ($hasRenderableSliderMedia) {
            return $item->is_active === true && $hasRenderableSliderMedia($item);
        })->values();

        if ($items->isEmpty() && function_exists('get_slider_media')) {
            $items = collect(get_slider_media($etablissement->id))
                ->map(function ($item, $index) {
                    $row = (array) $item;
                    $type = strtolower((string) ($row['type'] ?? 'image')) === 'video' ? 'video' : 'image';
                    $url = $type === 'video'
                        ? ($row['video_url'] ?? $row['image_url'] ?? $row['thumbnail_url'] ?? '')
                        : ($row['image_url'] ?? $row['thumbnail_url'] ?? '');

                    return (object) [
                        'id' => $row['id'] ?? ('media-' . $index),
                        'type' => $type,
                        'url' => $url,
                        'poster_url' => $row['thumbnail_url'] ?? $row['image_url'] ?? '',
                        'title' => $row['title'] ?? $row['name'] ?? '',
                        'subtitle' => $row['subtitle'] ?? $row['description'] ?? '',
                        'button_text' => $row['button_text'] ?? '',
                        'button_link' => $row['button_link'] ?? $row['button_url'] ?? '',
                        'order' => $row['order'] ?? ($index + 1),
                        'is_active' => true,
                        'video_html' => null,
                    ];
                })
                ->filter(function ($item) use ($hasRenderableSliderMedia) {
                    return $hasRenderableSliderMedia($item);
                })
                ->values();
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
            'overlay_color' => 'rgba(0,0,0,0.5)',
            'video_autoplay' => true,
            'video_muted' => true,
            'video_loop' => true,
        ];
        
        $options = array_merge($defaultOptions, $options);
        
        $sliderId = 'heroSlider_' . uniqid();
        
        $html = '<div class="hero-slider" style="height: ' . $options['height'] . '; min-height: ' . $options['min_height'] . '; background:#000; overflow:hidden;">';
        $html .= '<div class="swiper ' . $sliderId . '">';
        $html .= '<div class="swiper-wrapper">';
        
        foreach ($items as $index => $item) {
            $html .= '<div class="swiper-slide" data-type="' . $item->type . '" data-index="' . $index . '">';
            
            // GESTION DES VIDÉOS
if ($item->type === 'video') {
    // Vérifier si c'est une vidéo locale ou externe
    $videoUrl = $item->url;
    $youtubeId = null;
    $vimeoId = null;

    if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/|live\/|embed\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/', $videoUrl, $matches)) {
        $youtubeId = $matches[1];
    } elseif (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $videoUrl, $matches)) {
        $vimeoId = $matches[1];
    }
    
    // Poster image (thumbnail)
    $posterUrl = $item->poster_url ?? '';

    if ($youtubeId || $vimeoId) {
        $embedUrl = $youtubeId
            ? 'https://www.youtube.com/embed/' . $youtubeId . '?autoplay=1&mute=1&muted=1&loop=1&playlist=' . $youtubeId . '&controls=0&rel=0&playsinline=1'
            : 'https://player.vimeo.com/video/' . $vimeoId . '?autoplay=1&muted=1&loop=1&background=1';

        $html .= '<div class="video-wrapper-embed"' . ($posterUrl ? ' style="background-image:url(\'' . e($posterUrl) . '\');background-size:cover;background-position:center;"' : '') . '>';
        $html .= '<iframe class="slide-video-iframe" src="' . e($embedUrl) . '" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen loading="lazy"></iframe>';
        $html .= '</div>';
    } else {
    
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
                    const sliderRoot = document.querySelector(".' . $sliderId . '");
                    const outerSlider = sliderRoot ? sliderRoot.closest(".hero-slider") : null;
                    const updateRenderableSlides = function() {
                        if (!sliderRoot || !outerSlider) {
                            return;
                        }

                        const slides = Array.from(sliderRoot.querySelectorAll(".swiper-slide:not(.swiper-slide-duplicate)"));
                        const hasRenderableSlide = slides.some(function(slide) {
                            const image = slide.querySelector("img.slide-media");

                            return slide.querySelector("video, iframe") || (image && image.dataset.failed !== "1");
                        });

                        if (!hasRenderableSlide) {
                            outerSlider.style.display = "none";
                        }
                    };

                    sliderRoot.querySelectorAll("img.slide-media").forEach(function(image) {
                        const markFailed = function() {
                            image.dataset.failed = "1";
                            updateRenderableSlides();
                        };

                        image.addEventListener("error", markFailed, { once: true });

                        if (image.complete && image.naturalWidth === 0) {
                            markFailed();
                        }
                    });

                    updateRenderableSlides();

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
                top: 50%;
                left: 50%;
                width: 177.78vh;
                height: 56.25vw;
                min-width: 100%;
                min-height: 100%;
                transform: translate(-50%, -50%);
                border: 0;
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

if (!function_exists('is_slideshow_enabled')) {
    /**
     * Check if the landing slideshow is enabled for an establishment.
     *
     * The slideshow is enabled by default unless an explicit CMS setting disables it.
     *
     * @param int|null $etablissementId
     * @return bool
     */
    function is_slideshow_enabled($etablissementId = null)
    {
        $etablissement = $etablissementId
            ? \App\Models\Etablissement::find($etablissementId)
            : getCurrentEtablissement();

        if (!$etablissement) {
            return false;
        }

        $setting = \Vendor\Cms\Models\Setting::where('etablissement_id', $etablissement->id)
            ->whereIn('group', ['slideshow', 'slider', 'general'])
            ->whereIn('key', ['is_enabled', 'enabled', 'slideshow_enabled', 'show_slideshow', 'active'])
            ->get()
            ->sortBy(fn ($item) => match ($item->group) {
                'slideshow' => 0,
                'slider' => 1,
                default => 2,
            })
            ->first();

        if (!$setting) {
            return true;
        }

        $value = $setting->value;
        if (is_bool($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return (int) $value === 1;
        }

        $normalized = mb_strtolower(trim((string) $value), 'UTF-8');

        return !in_array($normalized, ['0', 'false', 'no', 'non', 'off', 'disabled', 'disable'], true);
    }
}

if (!function_exists('is_slider_enabled')) {
    /**
     * Check if the main landing hero slider is enabled for an establishment.
     *
     * The slider is enabled by default unless an explicit CMS setting disables it.
     *
     * @param int|null $etablissementId
     * @return bool
     */
    function is_slider_enabled($etablissementId = null)
    {
        $etablissement = $etablissementId
            ? \App\Models\Etablissement::find($etablissementId)
            : getCurrentEtablissement();

        if (!$etablissement) {
            return false;
        }

        $setting = \Vendor\Cms\Models\Setting::where('etablissement_id', $etablissement->id)
            ->whereIn('group', ['slider', 'hero', 'general'])
            ->whereIn('key', ['is_enabled', 'enabled', 'slider_enabled', 'hero_slider_enabled', 'show_slider', 'active'])
            ->get()
            ->sortBy(fn ($item) => match ($item->group) {
                'slider' => 0,
                'hero' => 1,
                default => 2,
            })
            ->first();

        if (!$setting) {
            return true;
        }

        $value = $setting->value;
        if (is_bool($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return (int) $value === 1;
        }

        $normalized = mb_strtolower(trim((string) $value), 'UTF-8');

        return !in_array($normalized, ['0', 'false', 'no', 'non', 'off', 'disabled', 'disable'], true);
    }
}

if (!function_exists('is_blog_enabled')) {
    /**
     * Check if landing blog sections are enabled for an establishment.
     *
     * Blogs are enabled by default unless an explicit CMS setting disables them.
     *
     * @param int|null $etablissementId
     * @return bool
     */
    function is_blog_enabled($etablissementId = null)
    {
        $etablissement = $etablissementId
            ? \App\Models\Etablissement::find($etablissementId)
            : getCurrentEtablissement();

        if (!$etablissement) {
            return false;
        }

        $setting = \Vendor\Cms\Models\Setting::where('etablissement_id', $etablissement->id)
            ->whereIn('group', ['blog', 'blogs', 'general'])
            ->whereIn('key', ['is_enabled', 'enabled', 'blog_enabled', 'blogs_enabled', 'show_blog', 'show_blogs', 'active'])
            ->get()
            ->sortBy(fn ($item) => match ($item->group) {
                'blog' => 0,
                'blogs' => 1,
                default => 2,
            })
            ->first();

        if (!$setting) {
            return true;
        }

        $value = $setting->value;
        if (is_bool($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return (int) $value === 1;
        }

        $normalized = mb_strtolower(trim((string) $value), 'UTF-8');

        return !in_array($normalized, ['0', 'false', 'no', 'non', 'off', 'disabled', 'disable'], true);
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
            return \App\Models\MapPoint::active()
                ->where('etablissement_id', $etablissement->id)
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

if (!function_exists('is_maps_enabled')) {
    /**
     * Check if landing maps are enabled for an establishment.
     *
     * Maps are enabled by default unless an explicit CMS setting disables them.
     *
     * @param int|null $etablissementId
     * @return bool
     */
    function is_maps_enabled($etablissementId = null)
    {
        $etablissement = $etablissementId
            ? \App\Models\Etablissement::find($etablissementId)
            : getCurrentEtablissement();

        if (!$etablissement) {
            return false;
        }

        $setting = \Vendor\Cms\Models\Setting::where('etablissement_id', $etablissement->id)
            ->whereIn('group', ['maps', 'map', 'general'])
            ->whereIn('key', ['is_enabled', 'enabled', 'maps_enabled', 'map_enabled', 'show_maps', 'show_map', 'active'])
            ->get()
            ->sortBy(fn ($item) => match ($item->group) {
                'maps' => 0,
                'map' => 1,
                default => 2,
            })
            ->first();

        if (!$setting) {
            return true;
        }

        $value = $setting->value;
        if (is_bool($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return (int) $value === 1;
        }

        $normalized = mb_strtolower(trim((string) $value), 'UTF-8');

        return !in_array($normalized, ['0', 'false', 'no', 'non', 'off', 'disabled', 'disable'], true);
    }
}

if (!function_exists('get_map_video_points')) {
    /**
     * Get active map points with a YouTube video.
     *
     * @param int|null $etablissementId
     * @param array $options ['limit' => 50]
     * @return \Illuminate\Support\Collection
     */
    function get_map_video_points($etablissementId = null, array $options = [])
    {
        $etablissement = $etablissementId
            ? \App\Models\Etablissement::find($etablissementId)
            : getCurrentEtablissement();

        if (!$etablissement) {
            return collect();
        }

        $options = array_merge(['limit' => 50], $options);

        try {
            if (!\Illuminate\Support\Facades\Schema::hasTable('map_points')) {
                return collect();
            }

            $hasVideosTable = \Illuminate\Support\Facades\Schema::hasTable('map_point_videos');
            $hasImagesTable = \Illuminate\Support\Facades\Schema::hasTable('map_point_images');
            $hasDetailsTable = \Illuminate\Support\Facades\Schema::hasTable('map_point_details');
            $relations = ['mainImage'];

            if ($hasVideosTable) {
                $relations[] = 'videos';
            }

            if ($hasImagesTable) {
                $relations[] = 'images';
            }

            if ($hasDetailsTable) {
                $relations[] = 'details';
            }

            $query = \App\Models\MapPoint::with($relations)
                ->active()
                ->where('etablissement_id', $etablissement->id)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->where(function ($query) use ($hasVideosTable) {
                    $query->whereNotNull('youtube_id')
                        ->where('youtube_id', '<>', '');

                    if ($hasVideosTable) {
                        $query->orWhereHas('videos', function ($videoQuery) {
                            $videoQuery->whereNotNull('youtube_id')
                                ->where('youtube_id', '<>', '');
                        });
                    }
                })
                ->orderByDesc('is_featured')
                ->orderByDesc('views')
                ->limit((int) $options['limit']);

            return $query->get()
                ->map(function ($point) {
                    $video = $point->youtube_id ? null : $point->videos->firstWhere('youtube_id');
                    $youtubeId = trim((string) ($point->youtube_id ?: ($video->youtube_id ?? '')));

                    if ($youtubeId === '') {
                        return null;
                    }

                    $point->youtube_id = $youtubeId;
                    $point->youtube_url = $point->youtube_url ?: ($video->youtube_url ?? ('https://www.youtube.com/watch?v=' . $youtubeId));
                    $point->video_title = $video->title ?? $point->title;
                    $point->thumbnail = 'https://img.youtube.com/vi/' . $youtubeId . '/hqdefault.jpg';
                    $point->embed_url = 'https://www.youtube.com/embed/' . $youtubeId . '?autoplay=0&rel=0&playsinline=1';

                    return $point;
                })
                ->filter()
                ->values();
        } catch (\Throwable $e) {
            \Log::error('get_map_video_points error: ' . $e->getMessage());

            return collect();
        }
    }
}

if (!function_exists('get_cms_general_section_title')) {
    /**
     * Read a section title from cms_settings group=general.
     */
    function get_cms_general_section_title($etablissementId, string $key, string $fallback = ''): string
    {
        try {
            $etablissement = $etablissementId
                ? \App\Models\Etablissement::find($etablissementId)
                : getCurrentEtablissement();

            if (!$etablissement || !method_exists($etablissement, 'getSetting')) {
                return $fallback;
            }

            $value = trim((string) ($etablissement->getSetting($key, '', 'general') ?? ''));

            return $value !== '' ? $value : $fallback;
        } catch (\Throwable $e) {
            \Log::warning('get_cms_general_section_title error: ' . $e->getMessage(), [
                'etablissement_id' => $etablissementId,
                'key' => $key,
            ]);

            return $fallback;
        }
    }
}

if (!function_exists('get_maps_section_title')) {
    function get_maps_section_title($etablissementId = null): string
    {
        return get_cms_general_section_title($etablissementId, 'map_section_title');
    }
}

if (!function_exists('get_blog_section_title')) {
    function get_blog_section_title($etablissementId = null): string
    {
        return get_cms_general_section_title($etablissementId, 'blog_section_title');
    }
}

if (!function_exists('get_ecommerce_section_title')) {
    function get_ecommerce_section_title($etablissementId = null): string
    {
        return get_cms_general_section_title($etablissementId, 'ecommerce_section_title');
    }
}

if (!function_exists('get_slideshow_section_title')) {
    function get_slideshow_section_title($etablissementId = null): string
    {
        return get_cms_general_section_title($etablissementId, 'slideshow_section_title');
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
     * Render a full interactive Leaflet map section.
     * Style: full-width map, custom markers, popup with YouTube iframe + "Voir détails" button,
     * rich modal with video / gallery / social / contact. No filters, no sidebar.
     *
     * @param int|null $etablissementId
     * @param array    $options  height, zoom, title, show_title, tile_url, limit
     * @return string
     */
    function get_map_section_html($etablissementId = null, array $options = [])
    {
        if (!has_map_points($etablissementId)) {
            return '';
        }

        $defaults = [
            'height'     => '560px',
            'zoom'       => 12,
            'title'      => 'Nous trouver',
            'show_title' => true,
            'tile_url'   => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            'limit'      => 50,
        ];
        $options = array_merge($defaults, $options);

        $center     = get_map_center($etablissementId);
        $pointsJson = get_map_points_json($etablissementId, ['limit' => $options['limit'], 'with_details' => true]);
        $mapId      = 'emap-' . uniqid();
        $height     = htmlspecialchars($options['height']);
        $zoom       = (int) $options['zoom'];
        $tileUrl    = htmlspecialchars($options['tile_url']);
        $centerLat  = $center['lat'];
        $centerLng  = $center['lng'];

        $titleHtml = $options['show_title']
            ? '<h2 class="emap-section-title">' . htmlspecialchars($options['title']) . '</h2>'
            : '';

        $html = <<<HTML
<!-- Enhanced Map Section -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
<section class="emap-section" aria-label="Carte interactive">
    <div class="emap-inner">
        {$titleHtml}
        <div id="{$mapId}" class="emap-map" style="height:{$height};"></div>
    </div>
</section>

<!-- Map Modal -->
<div id="{$mapId}-modal" class="emap-modal" role="dialog" aria-modal="true">
    <div class="emap-modal-box">
        <button class="emap-modal-close" onclick="document.getElementById('{$mapId}-modal').style.display='none';document.body.style.overflow='';" aria-label="Fermer">&times;</button>
        <div id="{$mapId}-modal-body"></div>
    </div>
</div>

<style>
/* ── Section wrapper ── */
.emap-section { padding: 60px 0 0; }
.emap-inner   { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
.emap-section-title {
    text-align: center; margin-bottom: 28px;
    font-size: 2rem; font-weight: 700;
    color: var(--color-heading, #1a1d28);
    letter-spacing: -.5px;
}

/* ── Map ── */
.emap-map {
    width: 100%; border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0,0,0,0.13);
}

/* ── Custom markers ── */
.emap-marker-wrap {
    width: 40px; height: 40px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 17px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.25);
    border: 3px solid #fff;
    transition: transform .2s, box-shadow .2s;
    cursor: pointer;
}
.emap-marker-wrap:hover { transform: scale(1.15); box-shadow: 0 6px 18px rgba(0,0,0,0.3); }

/* ── Leaflet popup overrides ── */
.leaflet-popup-content-wrapper {
    border-radius: 14px; padding: 0;
    overflow: hidden; min-width: 260px; max-width: 300px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.18);
    border: 2px solid #2a5bd7;
}
.leaflet-popup-content { margin: 0 !important; width: 100% !important; }
.leaflet-popup-tip     { background: #2a5bd7; }

/* Popup inner */
.emap-popup { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
.emap-popup-head {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 14px 10px;
}
.emap-popup-icon {
    width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; color: #fff;
}
.emap-popup-name {
    margin: 0; font-size: 14px; font-weight: 700;
    color: #1a1d28; white-space: nowrap;
    overflow: hidden; text-overflow: ellipsis;
}
.emap-popup-cat { font-size: 11px; color: #888; margin-top: 1px; }

/* YouTube in popup */
.emap-popup-yt {
    position: relative; padding-bottom: 56.25%;
    height: 0; background: #000; margin: 0;
}
.emap-popup-yt iframe {
    position: absolute; top: 0; left: 0;
    width: 100%; height: 100%; border: none;
}
.emap-popup-yt-badge {
    position: absolute; top: 8px; right: 8px;
    background: rgba(255,0,0,.9); color: #fff;
    font-size: 10px; font-weight: 700;
    padding: 3px 8px; border-radius: 4px; z-index: 5;
    display: flex; align-items: center; gap: 4px;
}

/* Popup image (fallback) */
.emap-popup-img { width: 100%; height: 120px; object-fit: cover; display: block; }

/* Popup body */
.emap-popup-body { padding: 10px 14px 14px; }
.emap-popup-desc {
    font-size: 11px; color: #666; line-height: 1.45;
    margin: 0 0 10px;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden;
}
.emap-popup-addr { font-size: 11px; color: #888; margin: 0 0 10px; display: flex; gap: 4px; align-items: flex-start; }
.emap-popup-btn {
    display: flex; align-items: center; justify-content: center; gap: 6px;
    width: 100%; padding: 9px 12px;
    background: #2a5bd7; color: #fff;
    border: none; border-radius: 7px;
    font-size: 12px; font-weight: 600;
    cursor: pointer; transition: background .2s;
}
.emap-popup-btn:hover { background: #1a3fa0; }

/* ── Modal ── */
.emap-modal {
    display: none; position: fixed;
    inset: 0; background: rgba(0,0,0,.8);
    z-index: 9999; overflow-y: auto;
    animation: emapFadeIn .2s ease;
}
@keyframes emapFadeIn { from{opacity:0} to{opacity:1} }
.emap-modal-box {
    position: relative; background: #fff;
    margin: 40px auto 60px; width: 92%; max-width: 860px;
    border-radius: 20px; overflow: hidden;
    animation: emapSlideIn .3s ease;
}
@keyframes emapSlideIn { from{transform:translateY(-40px);opacity:0} to{transform:translateY(0);opacity:1} }
.emap-modal-close {
    position: absolute; top: 16px; right: 16px;
    background: rgba(0,0,0,.45); color: #fff;
    border: none; width: 38px; height: 38px;
    border-radius: 50%; font-size: 20px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; z-index: 10; transition: background .2s, transform .2s;
    line-height: 1;
}
.emap-modal-close:hover { background: rgba(0,0,0,.8); transform: rotate(90deg); }

/* Modal body */
.emap-modal-body { padding: 30px; }
.emap-modal-video { position: relative; padding-bottom: 56.25%; height: 0; border-radius: 12px; overflow: hidden; margin-bottom: 24px; background: #000; }
.emap-modal-video iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none; }
.emap-modal-yt-badge { position: absolute; top: 14px; right: 14px; background: rgba(255,0,0,.9); color: #fff; padding: 7px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; }
.emap-modal-title { margin: 0 0 10px; font-size: 1.7rem; font-weight: 700; color: #1a1d28; }
.emap-modal-badges { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 24px; }
.emap-modal-badge { padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 500; color: #fff; }
.emap-modal-badge-rating { background: #fbbf24; color: #333; }
.emap-modal-badge-loc { color: #666; font-size: 13px; }

/* Gallery grid */
.emap-gallery { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 8px; margin-bottom: 24px; }
.emap-gallery-item { aspect-ratio: 1; border-radius: 10px; overflow: hidden; cursor: pointer; background: #f0f0f0; }
.emap-gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: transform .3s; display: block; }
.emap-gallery-item:hover img { transform: scale(1.07); }

/* Info grid */
.emap-info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 24px; }
.emap-info-card { background: #f8f9fa; border-radius: 10px; padding: 18px; }
.emap-info-card-head { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; font-weight: 700; color: #333; font-size: 14px; }
.emap-info-card-head i { font-size: 16px; }
.emap-info-card p { margin: 0; color: #666; font-size: 14px; }
.emap-info-card a { color: #2a5bd7; text-decoration: none; font-weight: 500; }
.emap-info-card a:hover { text-decoration: underline; }

/* Social */
.emap-social { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 24px; }
.emap-social a {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: 8px;
    font-size: 13px; font-weight: 500; text-decoration: none;
    transition: all .2s;
}

/* Services */
.emap-services { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 24px; }
.emap-service-tag { background: #e0e7ff; color: #3730a3; padding: 5px 12px; border-radius: 20px; font-size: 12px; }

/* Section label */
.emap-section-label { font-size: 1.1rem; font-weight: 700; color: #333; margin: 0 0 14px; display: flex; align-items: center; gap: 8px; }

/* Modal footer buttons */
.emap-modal-footer { display: flex; gap: 12px; padding-top: 24px; border-top: 1px solid #e5e5e5; margin-top: 8px; }
.emap-modal-cta {
    flex: 1; padding: 14px; border: none; border-radius: 10px;
    font-size: 15px; font-weight: 600; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    gap: 8px; text-decoration: none; transition: opacity .2s; color: #fff;
}
.emap-modal-cta:hover { opacity: .85; color: #fff; }
.emap-modal-btn-close {
    flex: 1; padding: 14px; background: #f0f0f0; color: #333;
    border: none; border-radius: 10px; font-size: 15px; font-weight: 600;
    cursor: pointer; display: flex; align-items: center;
    justify-content: center; gap: 8px; transition: background .2s;
}
.emap-modal-btn-close:hover { background: #e0e0e0; }

/* Responsive */
@media (max-width: 600px) {
    .emap-modal-box  { margin: 0; width: 100%; border-radius: 16px 16px 0 0; margin-top: 20px; }
    .emap-modal-body { padding: 20px; }
    .emap-modal-title { font-size: 1.3rem; }
}
</style>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
(function () {
    /* ── Category meta ── */
    var CAT = {
        business:   {icon:'fa-briefcase',      color:'#2a5bd7'},
        tourism:    {icon:'fa-globe-americas',  color:'#00c9b7'},
        restaurant: {icon:'fa-utensils',        color:'#e53e3e'},
        hotel:      {icon:'fa-hotel',           color:'#38a169'},
        museum:     {icon:'fa-landmark',        color:'#805ad5'},
        shopping:   {icon:'fa-shopping-bag',    color:'#3182ce'},
        park:       {icon:'fa-tree',            color:'#d69e2e'},
        monument:   {icon:'fa-monument',        color:'#dd6b20'},
        event:      {icon:'fa-calendar-alt',    color:'#ed64a6'},
        airport:    {icon:'fa-plane',           color:'#667eea'},
        beach:      {icon:'fa-umbrella-beach',  color:'#4299e1'},
        mountain:   {icon:'fa-mountain',        color:'#48bb78'},
        lake:       {icon:'fa-water',           color:'#0bc5ea'}
    };
    function catColor(c){ return (CAT[c]||{color:'#718096'}).color; }
    function catIcon(c) { return 'fas '+(CAT[c]||{icon:'fa-map-marker-alt'}).icon; }

    /* ── Social map ── */
    var SM = {
        facebook:{i:'fab fa-facebook',  c:'#1877F2', l:'Facebook'},
        instagram:{i:'fab fa-instagram',c:'#E1306C', l:'Instagram'},
        twitter:  {i:'fab fa-x-twitter',c:'#000',    l:'X'},
        linkedin: {i:'fab fa-linkedin', c:'#0A66C2', l:'LinkedIn'},
        youtube:  {i:'fab fa-youtube',  c:'#FF0000', l:'YouTube'},
        tiktok:   {i:'fab fa-tiktok',   c:'#010101', l:'TikTok'},
        pinterest:{i:'fab fa-pinterest',c:'#E60023', l:'Pinterest'},
        whatsapp: {i:'fab fa-whatsapp', c:'#25D366', l:'WhatsApp'},
        telegram: {i:'fab fa-telegram', c:'#229ED9', l:'Telegram'},
        discord:  {i:'fab fa-discord',  c:'#5865F2', l:'Discord'},
        twitch:   {i:'fab fa-twitch',   c:'#9146FF', l:'Twitch'},
        reddit:   {i:'fab fa-reddit',   c:'#FF4500', l:'Reddit'},
        github:   {i:'fab fa-github',   c:'#181717', l:'GitHub'},
        spotify:  {i:'fab fa-spotify',  c:'#1DB954', l:'Spotify'},
        tripadvisor:{i:'fab fa-tripadvisor',c:'#34E0A1',l:'TripAdvisor'},
        yelp:     {i:'fab fa-yelp',     c:'#D32323', l:'Yelp'},
        google_maps:{i:'fab fa-google', c:'#4285F4', l:'Google Maps'}
    };

    function esc(t){ if(!t) return ''; var d=document.createElement('div'); d.textContent=t; return d.innerHTML; }
    function cleanYt(id){ return id?id.split('?')[0]:null; }

    /* ── Popup builder ── */
    function buildPopup(point, mapId) {
        var yt = cleanYt(point.youtube_id);
        var color = catColor(point.category);
        var icon  = catIcon(point.category);

        var mediaHtml = '';
        if (yt) {
            mediaHtml = '<div class="emap-popup-yt">' +
                '<iframe src="https://www.youtube.com/embed/'+yt+'?autoplay=0&mute=1&controls=1&modestbranding=1&rel=0"' +
                ' allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture" allowfullscreen loading="lazy"></iframe>' +
                '<div class="emap-popup-yt-badge"><i class="fab fa-youtube"></i> YouTube</div>' +
                '</div>';
        } else if (point.thumbnail) {
            mediaHtml = '<img class="emap-popup-img" src="'+esc(point.thumbnail)+'" alt="'+esc(point.title)+'" loading="lazy">';
        }

        var addr = [point.adresse, point.ville].filter(Boolean).join(', ');
        var addrHtml = addr ? '<p class="emap-popup-addr"><i class="fas fa-map-marker-alt" style="color:'+color+';margin-top:1px;flex-shrink:0;"></i> '+esc(addr)+'</p>' : '';
        var descHtml = point.description ? '<p class="emap-popup-desc">'+esc(point.description)+'</p>' : '';

        var pData = 'data-point="'+encodeURIComponent(JSON.stringify(point))+'"';
        var btnHtml = '<button class="emap-popup-btn" '+pData+' data-modal="'+mapId+'-modal" onclick="window.__emapShowModal(this)">'+
            '<i class="fas fa-info-circle"></i> Voir les détails</button>';

        return '<div class="emap-popup">'+
            '<div class="emap-popup-head">'+
                '<div class="emap-popup-icon" style="background:'+color+'"><i class="'+icon+'"></i></div>'+
                '<div><p class="emap-popup-name">'+esc(point.title)+'</p>'+
                    '<div class="emap-popup-cat">'+esc(point.category||'')+'</div></div>'+
            '</div>'+
            mediaHtml+
            '<div class="emap-popup-body">'+addrHtml+descHtml+btnHtml+'</div>'+
        '</div>';
    }

    /* ── Modal builder ── */
    window.__emapShowModal = function(btn) {
        var point   = JSON.parse(decodeURIComponent(btn.dataset.point));
        var modalId = btn.dataset.modal;
        var modal   = document.getElementById(modalId);
        var body    = document.getElementById(modalId+'-body');
        if (!modal || !body) return;

        var yt    = cleanYt(point.youtube_id);
        var color = catColor(point.category);

        /* Video */
        var videoHtml = yt ?
            '<div class="emap-modal-video">'+
                '<iframe src="https://www.youtube-nocookie.com/embed/'+yt+'?autoplay=1&mute=0&controls=1&modestbranding=1&rel=0"'+
                ' frameborder="0" allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture" allowfullscreen></iframe>'+
                '<div class="emap-modal-yt-badge"><i class="fab fa-youtube"></i> YouTube</div>'+
            '</div>' : '';

        /* Gallery */
        var galleryHtml = '';
        if (point.images && point.images.length) {
            var imgs = point.images.map(function(img){
                return '<div class="emap-gallery-item"><img src="'+(img.thumbnail||img.url)+'" alt="'+esc(img.caption||'')+'" loading="lazy"></div>';
            }).join('');
            galleryHtml = '<p class="emap-section-label"><i class="fas fa-images" style="color:#4299e1"></i> Galerie</p>'+
                '<div class="emap-gallery">'+imgs+'</div>';
        }

        /* Info cards */
        var infoCards = '';
        var addr = [point.adresse, point.ville].filter(Boolean).join(', ');
        if (addr) {
            infoCards += '<div class="emap-info-card" style="border-left:4px solid #4299e1">'+
                '<div class="emap-info-card-head"><i class="fas fa-map-marker-alt" style="color:#4299e1"></i> Adresse</div>'+
                '<p>'+esc(addr)+'</p></div>';
        }
        if (point.details && point.details.phone) {
            infoCards += '<div class="emap-info-card" style="border-left:4px solid #38a169">'+
                '<div class="emap-info-card-head"><i class="fas fa-phone" style="color:#38a169"></i> Contact</div>'+
                '<p><a href="tel:'+esc(point.details.phone)+'">'+esc(point.details.phone)+'</a>'+
                (point.details.email ? '<br><a href="mailto:'+esc(point.details.email)+'">'+esc(point.details.email)+'</a>' : '')+
                '</p></div>';
        }
        if (point.details && point.details.website) {
            infoCards += '<div class="emap-info-card" style="border-left:4px solid #805ad5">'+
                '<div class="emap-info-card-head"><i class="fas fa-globe" style="color:#805ad5"></i> Site web</div>'+
                '<p><a href="'+esc(point.details.website)+'" target="_blank" rel="noopener">Visiter le site</a></p></div>';
        }
        var infoGridHtml = infoCards ? '<div class="emap-info-grid">'+infoCards+'</div>' : '';

        /* Description */
        var descHtml = '';
        if (point.description || (point.details && point.details.long_description)) {
            descHtml = '<p class="emap-section-label"><i class="fas fa-info-circle" style="color:#4299e1"></i> Description</p>'+
                (point.description ? '<p style="color:#666;line-height:1.6;font-size:15px;margin:0 0 10px">'+esc(point.description)+'</p>' : '')+
                (point.details && point.details.long_description ?
                    '<p style="color:#666;line-height:1.6;font-size:15px;margin:0">'+esc(point.details.long_description)+'</p>' : '');
        }

        /* Services */
        var servicesHtml = '';
        if (point.details && point.details.services) {
            try {
                var svcs = typeof point.details.services === 'string' ? JSON.parse(point.details.services) : point.details.services;
                if (svcs && svcs.length) {
                    servicesHtml = '<p class="emap-section-label"><i class="fas fa-concierge-bell" style="color:#4299e1"></i> Services</p>'+
                        '<div class="emap-services">'+svcs.map(function(s){ return '<span class="emap-service-tag">'+esc(s)+'</span>'; }).join('')+'</div>';
                }
            } catch(e){}
        }

        /* Social */
        var socialHtml = '';
        if (point.details && point.details.social_networks) {
            var socials = Object.entries(point.details.social_networks);
            if (socials.length) {
                var btns = socials.map(function(entry){
                    var k = entry[0]; var d = entry[1];
                    var m = SM[k] || {i:'fas fa-link', c:'#718096', l:k};
                    return '<a href="'+esc(d.url||d)+'" target="_blank" rel="noopener" class="emap-social-link"'+
                        ' style="background:'+m.c+'18;color:'+m.c+';border:1px solid '+m.c+'30;"'+
                        ' onmouseover="this.style.background=\''+m.c+'\';this.style.color=\'#fff\';"'+
                        ' onmouseout="this.style.background=\''+m.c+'18\';this.style.color=\''+m.c+'\';">'+
                        '<i class="'+m.i+'" style="font-size:14px;"></i> '+m.l+'</a>';
                }).join('');
                socialHtml = '<p class="emap-section-label"><i class="fas fa-share-alt" style="color:#4299e1"></i> Réseaux sociaux</p>'+
                    '<div class="emap-social">'+btns+'</div>';
            }
        }

        /* CTA */
        var ctaMap = {
            restaurant:{l:'Commander',i:'fa-shopping-cart',c:'#e53e3e'},
            hotel:     {l:'Réserver', i:'fa-calendar-check',c:'#38a169'},
            tourism:   {l:'Visiter',  i:'fa-globe-americas',c:'#2a5bd7'},
            museum:    {l:'Visiter',  i:'fa-landmark',c:'#805ad5'},
            business:  {l:'Contacter',i:'fa-briefcase',c:'#2a5bd7'}
        };
        var cta = ctaMap[point.category] || {l:'Visiter', i:'fa-external-link-alt', c:'#2a5bd7'};
        var ctaHtml = (point.details && point.details.website) ?
            '<a href="'+esc(point.details.website)+'" target="_blank" rel="noopener" class="emap-modal-cta" style="background:'+cta.c+'">'+
            '<i class="fas '+cta.i+'"></i> '+cta.l+'</a>' : '';

        /* Badges */
        var ratingBadge = (point.details && point.details.rating) ?
            '<span class="emap-modal-badge emap-modal-badge-rating"><i class="fas fa-star"></i> '+point.details.rating+
            (point.details.reviews_count ? ' ('+point.details.reviews_count+' avis)' : '')+'</span>' : '';
        var catBadge = '<span class="emap-modal-badge" style="background:'+color+'">'+esc(point.category||'')+'</span>';
        var locBadge = (point.ville||point.adresse) ?
            '<span class="emap-modal-badge-loc"><i class="fas fa-map-marker-alt"></i> '+esc(point.ville||point.adresse)+'</span>' : '';

        body.innerHTML =
            '<div class="emap-modal-body">'+
                videoHtml+
                '<h2 class="emap-modal-title">'+esc(point.title)+'</h2>'+
                '<div class="emap-modal-badges">'+catBadge+ratingBadge+locBadge+'</div>'+
                galleryHtml+
                infoGridHtml+
                descHtml+
                servicesHtml+
                socialHtml+
                '<div class="emap-modal-footer">'+
                    ctaHtml+
                    '<button class="emap-modal-btn-close" onclick="document.getElementById(\''+modalId+'\').style.display=\'none\';document.body.style.overflow=\'\';">'+
                    '<i class="fas fa-times"></i> Fermer</button>'+
                '</div>'+
            '</div>';

        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
        modal.scrollTop = 0;
    };

    /* ── Close modal on backdrop click / Escape ── */
    document.addEventListener('click', function(e){
        if (e.target && e.target.classList && e.target.classList.contains('emap-modal')) {
            e.target.style.display = 'none';
            document.body.style.overflow = '';
        }
    });
    document.addEventListener('keydown', function(e){
        if (e.key === 'Escape') {
            document.querySelectorAll('.emap-modal').forEach(function(m){ m.style.display='none'; });
            document.body.style.overflow = '';
        }
    });

    /* ── Init map ── */
    function initMap() {
        if (typeof L === 'undefined') { setTimeout(initMap, 100); return; }
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

        map.once('focus', function(){ map.scrollWheelZoom.enable(); });

        var points  = {$pointsJson};
        var bounds  = [];

        points.forEach(function(point) {
            if (!point.latitude || !point.longitude) return;
            var ll    = [point.latitude, point.longitude];
            var color = catColor(point.category);
            var icon  = catIcon(point.category);
            bounds.push(ll);

            var divIcon = L.divIcon({
                className: '',
                html: '<div class="emap-marker-wrap" style="background:'+color+'"><i class="'+icon+'"></i></div>',
                iconSize:   [40, 40],
                iconAnchor: [20, 40]
            });

            var marker = L.marker(ll, {icon: divIcon, title: point.title}).addTo(map);
            var popup  = L.popup({
                maxWidth: 300, minWidth: 260,
                closeButton: true, autoClose: true,
                closeOnClick: false, offset: L.point(0, -45)
            }).setContent(buildPopup(point, '{$mapId}'));

            marker.on('click', function(e){
                L.DomEvent.stopPropagation(e);
                popup.setLatLng(marker.getLatLng()).openOn(map);
            });
            marker.on('mouseover', function(){
                popup.setLatLng(marker.getLatLng()).openOn(map);
            });
        });

        if (bounds.length > 1) {
            map.fitBounds(bounds, {padding: [40, 40], maxZoom: 14});
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
