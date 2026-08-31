<?php
// app/Http/Controllers/LandingPageController.php

namespace Vendor\Activities\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Category;
use App\Models\PageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LandingPageController extends Controller
{
    /**
     * Afficher la page d'accueil
     */
    public function index()
    {
        // La landing « Espace Activités » : hero, carte, filtres, grille.
        //
        // `activeEtablissements` alimente le compteur de lieux de chaque carte :
        // une activité n'a pas de coordonnées propres, ce sont les
        // établissements qui la proposent qui la situent sur la carte.
        $activities = Activity::query()
            ->where('is_active', true)
            ->with(['categoryRelation:id,name'])
            ->withCount('activeEtablissements')
            ->orderBy('name')
            ->get();

        // Catégories réellement représentées : proposer un filtre vide n'a
        // aucun intérêt, et la liste se construit donc depuis les activités.
        $categories = $activities
            ->map(fn (Activity $a) => $a->categoryRelation)
            ->filter()
            ->unique('id')
            ->sortBy('name')
            ->values();

        // Diaporama du hero : les activités illustrées, faute de média dédié.
        // Sans image, un hero plein écran n'aurait rien à montrer.
        $heroSlides = $activities
            ->filter(fn (Activity $a) => filled($a->image))
            ->take(6)
            ->values();

        return view('activities::landing.home', compact('activities', 'categories', 'heroSlides'));
    }

    /**
     * Afficher la landing page d'une activité par son slug
     */
    public function showBySlug($slug)
    {
        // Récupérer l'activité par son slug
        $activity = Activity::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Récupérer tous les contenus de cette activité
        $contents = $activity->pageContents()
            ->where('is_active', true)
            ->orderBy('type')
            ->orderBy('order')
            ->get();

        // if ($contents->isEmpty()) {
        //     abort(404);
        // }

        // Grouper par type
        $groupedContents = $contents->groupBy('type');

        // Récupérer les contenus spécifiques
        $about = $groupedContents->get('about', collect())->first();
        $blogs = $groupedContents->get('blog', collect());
        $events = $groupedContents->get('event', collect());
        $videos = $groupedContents->get('video', collect());
        $testimonials = $groupedContents->get('testimonial', collect());
        $faqs = $groupedContents->get('faq', collect());
        $contact = $groupedContents->get('contact', collect())->first();

        // Construire les slides du hero UNIQUEMENT à partir des vidéos
        $heroSlides = [];

        // Ajouter les vidéos comme slides
        foreach ($videos as $video) {
            $videoMuted = $video->video_muted ?? true;
            $videoUrl = $this->getHeroVideoEmbedUrl($video->video_url, $videoMuted);

            if (!$videoUrl) {
                continue;
            }

            $subtitle = trim(strip_tags((string) $video->content));

            $heroSlides[] = [
                'type' => 'video',
                'video_url' => $videoUrl,
                'thumbnail' => $this->getHeroVideoThumbnail($video),
                'badge' => 'Vidéo',
                'title' => $video->title ?: $activity->name,
                'subtitle' => $subtitle !== ''
                    ? Str::limit($subtitle, 150)
                    : ($activity->description ?? ''),
                'primary_btn_text' => 'Lire la vidéo',
                'primary_btn_link' => '#hero',
                'secondary_btn_text' => 'En savoir plus',
                'secondary_btn_link' => '#about',
                'button_text' => $video->button_text ?? null,
                'button_url' => $video->button_url ?? null,
            ];
        }

        // Événements en vedette
        $featuredEvents = $events->take(5);

        // Statistiques
        $stats = [
            'total_activities' => 1,
            'total_participants' => $activity->etablissementsCount() ?? 0,
            'total_reviews' => $testimonials->count(),
            'average_rating' => 4.9,
        ];

        // Catégories d'activités (pour la section)
        $categories = $this->getCategories();

        // Catégories avec activités pour le mega menu du header
        $navCategories = Category::where('is_active', true)
            ->with(['activities' => function ($q) {
                $q->where('is_active', true);
            }])
            ->get()
            ->filter(fn($cat) => $cat->activities->isNotEmpty());

        // Partenaires
        $partners = $this->getPartners();

        $ads = DB::table('ads')
            ->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', now()->toDateString());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now()->toDateString());
            })
            ->where(function ($q) {
                $q->whereNull('budget_total')->orWhereRaw('budget_total > COALESCE(budget_spent, 0)');
            })
            ->orderBy('priority')
            ->orderByDesc('id')
            ->get();

        return view('activities::landing.activity-detail', compact(
            'activity',
            'groupedContents',
            'about',
            'blogs',
            'events',
            'videos',
            'testimonials',
            'faqs',
            'contact',
            'heroSlides',
            'featuredEvents',
            'stats',
            'categories',
            'navCategories',
            'partners',
            'ads'
        ));
    }

    /**
     * Afficher un blog en détail pour une activité
     */
    public function showBlog($activitySlug, $blogId)
    {
        $activity = Activity::where('slug', $activitySlug)
            ->where('is_active', true)
            ->firstOrFail();

        $blog = PageContent::where('type', 'blog')
            ->where('id', $blogId)
            ->where('activity_id', $activity->id)
            ->where('is_active', true)
            ->firstOrFail();

        // Incrémenter les vues
        $blog->increment('views');

        $relatedBlogs = PageContent::where('type', 'blog')
            ->where('activity_id', $activity->id)
            ->where('id', '!=', $blog->id)
            ->where('is_active', true)
            ->take(3)
            ->get();

        return view('activities::landing.activity-blog-detail', compact('activity', 'blog', 'relatedBlogs'));
    }

    /**
     * Afficher un événement en détail pour une activité
     */
    public function showEvent($activitySlug, $eventId)
    {
        $activity = Activity::where('slug', $activitySlug)
            ->where('is_active', true)
            ->firstOrFail();

        $event = PageContent::where('type', 'event')
            ->where('id', $eventId)
            ->where('activity_id', $activity->id)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedEvents = PageContent::where('type', 'event')
            ->where('activity_id', $activity->id)
            ->where('id', '!=', $event->id)
            ->where('is_active', true)
            ->take(3)
            ->get();

        return view('activities::landing.activity-event-detail', compact('activity', 'event', 'relatedEvents'));
    }

    /**
     * Afficher tous les blogs d'une activité
     */
    public function blogs($activitySlug)
    {
        $activity = Activity::where('slug', $activitySlug)
            ->where('is_active', true)
            ->firstOrFail();

        $blogs = PageContent::where('type', 'blog')
            ->where('activity_id', $activity->id)
            ->where('is_active', true)
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('activities::landing.activity-blogs', compact('activity', 'blogs'));
    }

    /**
     * Afficher tous les événements d'une activité
     */
    public function events($activitySlug)
    {
        $activity = Activity::where('slug', $activitySlug)
            ->where('is_active', true)
            ->firstOrFail();

        $events = PageContent::where('type', 'event')
            ->where('activity_id', $activity->id)
            ->where('is_active', true)
            ->orderBy('event_start_date', 'asc')
            ->paginate(9);

        return view('activities::landing.activity-events', compact('activity', 'events'));
    }

    /**
     * Afficher tous les témoignages d'une activité
     */
    public function testimonials($activitySlug)
    {
        $activity = Activity::where('slug', $activitySlug)
            ->where('is_active', true)
            ->firstOrFail();

        $testimonials = PageContent::where('type', 'testimonial')
            ->where('activity_id', $activity->id)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('activities::landing.activity-testimonials', compact('activity', 'testimonials'));
    }

    /**
 * Convertir une URL de vidéo en URL embed pour le hero slider
 * avec autoplay, mute et fullscreen
 * 
 * @param string|null $url
 * @return string|null
 */
private function getHeroVideoEmbedUrl($url, $muted = true)
{
    if (empty($url)) {
        return null;
    }

    $url = trim($url);

    $muteParam = $muted ? '1' : '0';

    // YouTube - Format standard
    if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
        $vid = $matches[1];
        return 'https://www.youtube.com/embed/' . $vid . '?autoplay=1&mute=' . $muteParam . '&loop=1&playlist=' . $vid . '&rel=0&modestbranding=1&controls=0&showinfo=0&iv_load_policy=3&enablejsapi=1&playsinline=1';
    }

    // YouTube - Format court
    if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
        $vid = $matches[1];
        return 'https://www.youtube.com/embed/' . $vid . '?autoplay=1&mute=' . $muteParam . '&loop=1&playlist=' . $vid . '&rel=0&modestbranding=1&controls=0&showinfo=0&iv_load_policy=3&enablejsapi=1&playsinline=1';
    }

    // YouTube - Format embed déjà
    if (preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
        $vid = $matches[1];
        $separator = (strpos($url, '?') !== false) ? '&' : '?';
        return $url . $separator . 'autoplay=1&mute=' . $muteParam . '&loop=1&playlist=' . $vid . '&controls=0&playsinline=1';
    }

    // Vimeo
    if (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
        return 'https://player.vimeo.com/video/' . $matches[1] . '?autoplay=1&muted=' . $muteParam . '&loop=1&title=0&byline=0&portrait=0&badge=0&controls=0&background=1';
    }

    // Vimeo - Format embed déjà
    if (preg_match('/player\.vimeo\.com\/video\/(\d+)/', $url, $matches)) {
        $separator = (strpos($url, '?') !== false) ? '&' : '?';
        return $url . $separator . 'autoplay=1&muted=' . $muteParam . '&loop=1&controls=0&background=1';
    }

    // Dailymotion
    if (preg_match('/dailymotion\.com\/video\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
        return 'https://www.dailymotion.com/embed/video/' . $matches[1] . '?autoplay=1&mute=' . $muteParam . '&controls=0&loop=1';
    }

    // Dailymotion - Format embed déjà
    if (preg_match('/dailymotion\.com\/embed\/video\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
        $separator = (strpos($url, '?') !== false) ? '&' : '?';
        return $url . $separator . 'autoplay=1&mute=' . $muteParam . '&controls=0&loop=1';
    }

    return null;
}

    /**
     * Récupérer la miniature d'une vidéo pour le hero
     * 
     * @param PageContent $video
     * @return string|null
     */
    private function getHeroVideoThumbnail($video)
    {
        if (empty($video->video_url)) {
            return null;
        }

        $url = $video->video_url;

        // YouTube
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return 'https://img.youtube.com/vi/' . $matches[1] . '/maxresdefault.jpg';
        }

        // Vimeo
        if (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
            try {
                $apiUrl = 'https://vimeo.com/api/v2/video/' . $matches[1] . '.json';
                $ch = curl_init($apiUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                $response = curl_exec($ch);
                curl_close($ch);
                
                if ($response) {
                    $data = json_decode($response, true);
                    if (isset($data[0]['thumbnail_large'])) {
                        return $data[0]['thumbnail_large'];
                    }
                }
            } catch (\Exception $e) {
                // En cas d'erreur, utiliser vumbnail
            }
            
            return 'https://vumbnail.com/' . $matches[1] . '.jpg';
        }

        // Dailymotion
        if (preg_match('/dailymotion\.com\/(?:video\/|embed\/video\/)([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return 'https://www.dailymotion.com/thumbnail/video/' . $matches[1];
        }

        // Si l'image est stockée localement
        if ($video->image) {
            return $video->image_url;
        }

        if (isset($video->extra_data['thumbnail'])) {
            return $video->extra_data['thumbnail'];
        }

        return null;
    }

    /**
     * Récupérer les catégories
     * 
     * @return array
     */
    private function getCategories()
    {
        return [
            [
                'name' => 'Ski & Snowboard',
                'icon' => 'fa-skiing',
                'image' => 'https://images.unsplash.com/photo-1521335629791-ce4aec67dd15?w=600&q=80',
                'count' => 12
            ],
            [
                'name' => 'Randonnée',
                'icon' => 'fa-hiking',
                'image' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?w=600&q=80',
                'count' => 24
            ],
            [
                'name' => 'Natation & Plongée',
                'icon' => 'fa-person-swimming',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&q=80',
                'count' => 8
            ],
            [
                'name' => 'Cyclisme & VTT',
                'icon' => 'fa-person-biking',
                'image' => 'https://images.unsplash.com/photo-1553361371-9b22f78e8b1d?w=600&q=80',
                'count' => 16
            ],
            [
                'name' => 'Surf & Kayak',
                'icon' => 'fa-water',
                'image' => 'https://images.unsplash.com/photo-1528360983277-13d401cdc186?w=600&q=80',
                'count' => 10
            ],
            [
                'name' => 'Sports Extrêmes',
                'icon' => 'fa-parachute-box',
                'image' => 'https://images.unsplash.com/photo-1517692547823-f013ac69b2ba?w=600&q=80',
                'count' => 7
            ],
        ];
    }

    /**
     * Récupérer les partenaires
     * 
     * @return array
     */
    private function getPartners()
    {
        return ['SALOMON', 'MAMMUT', 'PATAGONIA', 'GARMIN', 'DECATHLON', 'BLACK DIAMOND', 'THE NORTH FACE', 'OSPREY'];
    }
}