<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vidéos de paysages canadiens - Mix de vidéos uploadées (Pexels) et YouTube
        $sliders = [
            [
                'name' => 'Montagnes Rocheuses Canadiennes',
                'description' => 'Découvrez les majestueuses Rocheuses',
                'type' => 'video',
                'video_type' => 'upload',
                'video_path' => 'https://videos.pexels.com/video-files/3571264/3571264-uhd_2560_1440_30fps.mp4',
                'thumbnail_path' => 'https://images.pexels.com/videos/3571264/pictures/preview-0.jpg',
                'order' => 1,
                'is_active' => true,
                'button_text' => 'Explorer',
                'button_url' => '/destinations/canada',
            ],
            [
                'name' => 'Découvrez le Canada',
                'description' => 'Vidéo officielle de Destination Canada',
                'type' => 'video',
                'video_type' => 'youtube',
                'video_url' => 'https://www.youtube.com/watch?v=Se12y9hSOM0',
                'thumbnail_path' => 'https://img.youtube.com/vi/Se12y9hSOM0/maxresdefault.jpg',
                'order' => 2,
                'is_active' => true,
                'button_text' => 'Découvrir',
                'button_url' => '/destinations/canada',
            ],
            [
                'name' => 'Forêt Boréale',
                'description' => 'Les couleurs spectaculaires de l\'automne canadien',
                'type' => 'video',
                'video_type' => 'upload',
                'video_path' => 'https://videos.pexels.com/video-files/3571264/3571264-uhd_2560_1440_30fps.mp4',
                'thumbnail_path' => 'https://images.pexels.com/videos/3571264/pictures/preview-0.jpg',
                'order' => 3,
                'is_active' => true,
                'button_text' => 'Voir plus',
                'button_url' => '/destinations/canada/forets',
            ],
            [
                'name' => 'Rivière de Montagne',
                'description' => 'Eaux cristallines des montagnes',
                'type' => 'video',
                'video_type' => 'upload',
                'video_path' => 'https://videos.pexels.com/video-files/3571264/3571264-uhd_2560_1440_30fps.mp4',
                'thumbnail_path' => 'https://images.pexels.com/videos/3571264/pictures/preview-0.jpg',
                'order' => 4,
                'is_active' => true,
                'button_text' => 'Explorer',
                'button_url' => '/destinations/canada/rivieres',
            ],
            [
                'name' => 'Paysage Hivernal',
                'description' => 'La beauté de l\'hiver canadien',
                'type' => 'video',
                'video_type' => 'upload',
                'video_path' => 'https://videos.pexels.com/video-files/3571264/3571264-uhd_2560_1440_30fps.mp4',
                'thumbnail_path' => 'https://images.pexels.com/videos/3571264/pictures/preview-0.jpg',
                'order' => 5,
                'is_active' => true,
                'button_text' => 'Découvrir',
                'button_url' => '/destinations/canada/hiver',
            ],
            [
                'name' => 'Cascade Naturelle',
                'description' => 'Cascades majestueuses du Canada',
                'type' => 'video',
                'video_type' => 'upload',
                'video_path' => 'https://videos.pexels.com/video-files/3571264/3571264-uhd_2560_1440_30fps.mp4',
                'thumbnail_path' => 'https://images.pexels.com/videos/3571264/pictures/preview-0.jpg',
                'order' => 6,
                'is_active' => true,
                'button_text' => 'Visiter',
                'button_url' => '/destinations/canada/cascades',
            ],
            [
                'name' => 'Aurores Boréales',
                'description' => 'Le spectacle magique des aurores boréales',
                'type' => 'video',
                'video_type' => 'upload',
                'video_path' => 'https://videos.pexels.com/video-files/3571264/3571264-uhd_2560_1440_30fps.mp4',
                'thumbnail_path' => 'https://images.pexels.com/videos/3571264/pictures/preview-0.jpg',
                'order' => 7,
                'is_active' => true,
                'button_text' => 'En savoir plus',
                'button_url' => '/destinations/canada/aurores-boreales',
            ],
            [
                'name' => 'Vallée Verdoyante',
                'description' => 'Vallées verdoyantes du Canada',
                'type' => 'video',
                'video_type' => 'upload',
                'video_path' => 'https://videos.pexels.com/video-files/3571264/3571264-uhd_2560_1440_30fps.mp4',
                'thumbnail_path' => 'https://images.pexels.com/videos/3571264/pictures/preview-0.jpg',
                'order' => 8,
                'is_active' => true,
                'button_text' => 'Explorer',
                'button_url' => '/destinations/canada/vallees',
            ],
            [
                'name' => 'Village nordique',
                'description' => 'Ambiance hivernale et chalets au Canada',
                'type' => 'image',
                'image_path' => 'https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=1920&h=1080&fit=crop',
                'thumbnail_path' => 'https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=480&h=270&fit=crop',
                'order' => 9,
                'is_active' => true,
                'button_text' => 'Voir le guide',
                'button_url' => '/destinations/canada/hiver',
            ],
            [
                'name' => 'Route panoramique',
                'description' => 'Parcours scenic entre lacs et montagnes',
                'type' => 'image',
                'image_path' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=1920&h=1080&fit=crop',
                'thumbnail_path' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=480&h=270&fit=crop',
                'order' => 10,
                'is_active' => true,
                'button_text' => 'Explorer',
                'button_url' => '/destinations/canada/routes',
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::updateOrCreate(
                ['name' => $slider['name']],
                $slider
            );
        }
    }
}
