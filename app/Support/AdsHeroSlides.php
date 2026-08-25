<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Annonces à intercaler dans le slider (hero) de la page d'accueil.
 *
 * Lues CÔTÉ SERVEUR dans la base PARTAGÉE avec l'admin (zone
 * « slider_home_welcome »), puis converties au format d'un slide du hero pour
 * que le composant Hero les rende exactement comme les autres : même mise en
 * page, même vignette dans la bande de sélection.
 *
 * Le calcul vit ici plutôt que dans la vue parce que le hero appartient au
 * paquet home-v2, alors que la configuration publicitaire est propre à
 * l'application.
 */
class AdsHeroSlides
{
    /**
     * Ajoute les annonces à la liste des slides du hero.
     *
     * Rend la collection inchangée si la zone est vide, désactivée ou
     * indisponible : le hero ne doit jamais dépendre de la publicité.
     */
    public static function fusionner(Collection $slides): Collection
    {
        $annonces = static::slides();

        if ($annonces->isEmpty()) {
            return $slides;
        }

        return config('ads.home_slider_first', true)
            ? $annonces->concat($slides)->values()
            : $slides->concat($annonces)->values();
    }

    /**
     * Les annonces de la zone, au format d'un slide du hero.
     */
    public static function slides(): Collection
    {
        if (! config('ads.home_slider_enabled', true)) {
            return collect();
        }

        $adminUrl = rtrim((string) config('ads.admin_url'), '/');

        foreach (static::annonces() as $annonce) {
            $slides[] = static::versSlide($annonce, $adminUrl);
        }

        return collect($slides ?? [])
            // Un slide sans visuel ne peut pas tenir dans un hero plein écran.
            ->filter(fn (array $s) => ! empty($s['media']) || ! empty($s['poster']))
            ->values();
    }

    /**
     * Annonces actives rattachées à la zone, dans l'ordre de priorité.
     */
    protected static function annonces(): Collection
    {
        $zone = config('ads.home_slider_zone', 'slider_home_welcome');

        try {
            $placement = DB::table('ad_placements')
                ->where('code', $zone)->where('is_active', true)->first();

            if (! $placement) {
                return collect();
            }

            $aujourdhui = now()->toDateString();

            return DB::table('ads')
                ->join('ad_placement', 'ads.id', '=', 'ad_placement.ad_id')
                ->where('ad_placement.placement_id', $placement->id)
                ->where('ad_placement.is_active', true)
                ->where('ads.status', 'active')
                ->where(fn ($q) => $q->whereNull('ads.start_date')->orWhere('ads.start_date', '<=', $aujourdhui))
                ->where(fn ($q) => $q->whereNull('ads.end_date')->orWhere('ads.end_date', '>=', $aujourdhui))
                ->where(fn ($q) => $q->whereNull('ads.budget_total')->orWhereRaw('ads.budget_total > ads.budget_spent'))
                // Pas de JSON_LENGTH() : cette fonction n'existe que sur MySQL et
                // l'exception serait avalée plus bas, faisant disparaître les
                // annonces sans le moindre signe.
                ->where(fn ($q) => $q
                    ->whereNull('ads.display_locations')
                    ->orWhereIn('ads.display_locations', ['[]', ''])
                    ->orWhereJsonContains('ads.display_locations', 'home'))
                ->select('ads.*')
                ->orderBy('ads.priority')
                ->limit(($placement->max_ads ?: 5))
                ->get();
        } catch (\Throwable $e) {
            // Base indisponible ou zone absente : l'accueil s'affiche sans pub.
            return collect();
        }
    }

    /**
     * Convertit une annonce en slide du hero.
     */
    protected static function versSlide(object $annonce, string $adminUrl): array
    {
        $type = $annonce->type === 'video' ? 'video' : 'image';

        $media  = static::url($annonce->image_path, $adminUrl);
        $poster = $media;

        $youtubeId = null;
        $vimeoId = null;

        if ($type === 'video') {
            $source = trim((string) ($annonce->video_url ?: $annonce->destination_url));
            $youtubeId = static::youtube($source);
            $vimeoId = static::vimeo($source);

            // Le hero lit « media » pour la vidéo ; l'image d'illustration, si
            // elle existe, sert d'affiche le temps du chargement.
            $media = $youtubeId || $vimeoId ? $source : static::url($annonce->video_url, $adminUrl);

            if (! $poster && $youtubeId) {
                $poster = 'https://img.youtube.com/vi/' . $youtubeId . '/maxresdefault.jpg';
            }
        }

        $description = (string) ($annonce->description ?? '');
        if ($description === '' && $type !== 'video') {
            $description = (string) ($annonce->text_content ?? '');
        }

        $destination = trim((string) $annonce->destination_url);

        return [
            'title'       => (string) $annonce->titre,
            'description' => $description,
            'type'        => $type,
            'video_type'  => $youtubeId ? 'youtube' : ($vimeoId ? 'vimeo' : 'upload'),
            'media'       => $media,
            'poster'      => $poster,
            'youtube_id'  => $youtubeId,
            'vimeo_id'    => $vimeoId,
            // Le bouton du hero devient le lien de l'annonce.
            'button_text' => trim((string) ($annonce->button_text ?? '')) ?: 'En savoir plus',
            'button_url'  => $destination,
            'badge'       => 'Sponsorisé',

            // Champs propres aux annonces, lus par le composant Hero.
            'sponsored'      => true,
            'ad_click'       => $destination !== '' ? $adminUrl . '/ads/track/click/' . $annonce->id : '',
            'ad_impression'  => $adminUrl . '/ads/track/impression/' . $annonce->id,
        ];
    }

    /** Images stockées côté admin : URL absolue vers son storage. */
    protected static function url(?string $chemin, string $adminUrl): ?string
    {
        $chemin = trim((string) $chemin);

        if ($chemin === '') {
            return null;
        }

        return Str::startsWith($chemin, ['http://', 'https://', '//'])
            ? $chemin
            : $adminUrl . '/storage/' . ltrim($chemin, '/');
    }

    protected static function youtube(string $url): ?string
    {
        return preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/|live\/|embed\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/i', $url, $m)
            ? $m[1] : null;
    }

    protected static function vimeo(string $url): ?string
    {
        return preg_match('/vimeo\.com\/(?:video\/)?(\d+)/i', $url, $m) ? $m[1] : null;
    }
}
