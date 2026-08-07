<?php

namespace Vendor\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * Annonce d'un établissement (produit, image, vidéo, HTML ou texte).
 * Stockée dans la base « cms » (partagée admin ↔ front).
 *
 * Reprend les règles de campagne du module ads-manager : formats normés,
 * contextes d'affichage, priorité, plafonds et suivi. La couche monétisation
 * d'ads-manager (CPM/CPC, budgets, approbation) n'est pas reprise — une
 * entreprise ne s'achète pas d'espace sur son propre site.
 */
class Announcement extends Model
{
    use SoftDeletes;

    protected $connection = 'cms';
    protected $table = 'cms_announcements';

    public const TYPE_PRODUCT = 'product';
    public const TYPE_IMAGE   = 'image';
    public const TYPE_VIDEO   = 'video';
    public const TYPE_HTML    = 'html';
    public const TYPE_TEXT    = 'text';

    public const TYPES = [
        self::TYPE_PRODUCT => 'Produit',
        self::TYPE_IMAGE   => 'Image',
        self::TYPE_VIDEO   => 'Vidéo',
        self::TYPE_HTML    => 'HTML',
        self::TYPE_TEXT    => 'Texte',
    ];

    public const POSITIONS = ['center', 'bottom-right', 'bottom-left'];

    /**
     * Cycle de vie. Le workflow d'approbation d'ads-manager (pending/rejected)
     * n'a pas lieu d'être ici : l'établissement publie sur son propre site.
     */
    public const STATUSES = [
        'draft'   => 'Brouillon',
        'active'  => 'Active',
        'paused'  => 'En pause',
        'expired' => 'Expirée',
    ];

    /**
     * Contextes de page front où l'annonce peut paraître.
     * Repris à l'identique de Vendor\AdsManager\Models\Ad::DISPLAY_LOCATIONS,
     * pour que les deux modules parlent le même langage côté front.
     */
    public const DISPLAY_LOCATIONS = [
        'home'           => 'Page d\'accueil',
        'continent'      => 'Pages Continent',
        'country'        => 'Pages Pays',
        'province'       => 'Pages Province',
        'region'         => 'Pages Région',
        'secteur'        => 'Pages Secteur',
        'city'           => 'Pages Ville',
        'arrondissement' => 'Pages Arrondissement',
        'quartier'       => 'Pages Quartier',
        'activities'     => 'Pages Activités',
        'etablissements' => 'Pages Établissements',
    ];

    /** Sous-ensemble « niveaux de destination », pour grouper les cases à cocher. */
    public const DESTINATION_LOCATIONS = [
        'continent', 'country', 'province', 'region',
        'secteur', 'city', 'arrondissement', 'quartier',
    ];

    /** Repli si le paquet ads-manager n'est pas installé (voir formats()). */
    protected const FORMATS_DEFAUT = [
        'banner'      => ['width' => 728,  'height' => 90,   'label' => 'Bannière horizontale'],
        'rectangle'   => ['width' => 300,  'height' => 250,  'label' => 'Rectangle moyen'],
        'square'      => ['width' => 250,  'height' => 250,  'label' => 'Carré'],
        'interstitial'=> ['width' => 600,  'height' => 500,  'label' => 'Interstitiel'],
    ];

    protected $fillable = [
        'etablissement_id', 'type', 'format', 'width', 'height',
        'title', 'message',
        'product_id', 'media_url', 'video_url', 'html_content', 'text_content',
        'link_url', 'button_label', 'open_new_tab',
        'position', 'display_locations', 'dismissible',
        'is_active', 'status', 'display_delay', 'order', 'priority', 'slide_duration',
        'starts_at', 'ends_at',
        'impression_limit', 'click_limit', 'frequency_cap',
        'impressions_count', 'clicks_count',
        'settings',
    ];

    protected $casts = [
        'dismissible'       => 'boolean',
        'is_active'         => 'boolean',
        'open_new_tab'      => 'boolean',
        'display_delay'     => 'integer',
        'order'             => 'integer',
        'priority'          => 'integer',
        'slide_duration'    => 'integer',
        'width'             => 'integer',
        'height'            => 'integer',
        'impression_limit'  => 'integer',
        'click_limit'       => 'integer',
        'frequency_cap'     => 'integer',
        'impressions_count' => 'integer',
        'clicks_count'      => 'integer',
        'starts_at'         => 'datetime',
        'ends_at'           => 'datetime',
        'display_locations' => 'array',
        'settings'          => 'array',
    ];

    /* ------------------------------------------------------------------ */
    /*  Formats                                                             */
    /* ------------------------------------------------------------------ */

    /**
     * Formats disponibles. On lit la configuration d'ads-manager quand elle est
     * là, pour n'avoir qu'UNE définition des dimensions dans l'application ;
     * sinon on retombe sur un jeu minimal, afin que ce paquet reste autonome.
     */
    public static function formats(): array
    {
        $formats = config('ads-manager.ad_formats');

        return is_array($formats) && $formats !== [] ? $formats : self::FORMATS_DEFAUT;
    }

    /** Formats acceptables pour un type donné (un format peut se restreindre). */
    public static function formatsForType(string $type): array
    {
        return array_filter(self::formats(), function ($f) use ($type) {
            $types = $f['types'] ?? null;

            return $types === null || in_array($type, (array) $types, true);
        });
    }

    /** Dimensions d'un format, ou [null, null] si le format est inconnu. */
    public static function dimensionsForFormat(?string $format): array
    {
        $f = self::formats()[$format] ?? [];

        return ['width' => $f['width'] ?? null, 'height' => $f['height'] ?? null];
    }

    /** Ne conserve que des contextes d'affichage connus. */
    public static function cleanDisplayLocations(array $locations): array
    {
        return array_values(array_intersect(
            array_map('strval', $locations),
            array_keys(self::DISPLAY_LOCATIONS)
        ));
    }

    /* ------------------------------------------------------------------ */
    /*  Portées                                                             */
    /* ------------------------------------------------------------------ */

    /**
     * Annonces réellement diffusables : actives, dans la fenêtre de dates et
     * sous leurs plafonds.
     *
     * Le filtre sur is_active est conservé en plus de status : le front lit
     * encore cette colonne, que le contrôleur maintient synchronisée.
     */
    public function scopeLive($query)
    {
        $now = now();

        return $query->where('is_active', true)
            ->where(fn ($q) => $q->whereNull('status')->orWhere('status', 'active'))
            ->where(fn ($q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now))
            ->where(fn ($q) => $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now))
            ->where(fn ($q) => $q->whereNull('impression_limit')
                                 ->orWhereColumn('impressions_count', '<', 'impression_limit'))
            ->where(fn ($q) => $q->whereNull('click_limit')
                                 ->orWhereColumn('clicks_count', '<', 'click_limit'));
    }

    /**
     * Annonces visibles sur un contexte de page donné.
     * NULL ou liste vide = affichée partout (rétro-compatibilité : les annonces
     * créées avant cette colonne n'en ont pas).
     */
    public function scopeVisibleOn($query, ?string $location)
    {
        if (! $location) {
            return $query;
        }

        // « ville » (MapPoint / legacy) équivaut à « city ».
        if ($location === 'ville') {
            $location = 'city';
        }

        return $query->where(function ($q) use ($location) {
            $q->whereNull('display_locations')
              ->orWhereRaw('JSON_LENGTH(display_locations) = 0')
              ->orWhereJsonContains('display_locations', $location);
        });
    }

    /** Priorité décroissante d'abord, puis l'ordre manuel. */
    public function scopeOrdered($query)
    {
        return $query->orderByDesc('priority')->orderBy('order')->orderByDesc('id');
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /* ------------------------------------------------------------------ */
    /*  Accesseurs                                                          */
    /* ------------------------------------------------------------------ */

    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? (string) $this->type;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? (string) $this->status;
    }

    public function getFormatLabelAttribute(): ?string
    {
        return self::formats()[$this->format]['label'] ?? null;
    }

    /** Taux de clic, en pourcentage, ou null si aucune impression. */
    public function getCtrAttribute(): ?float
    {
        if (! $this->impressions_count) {
            return null;
        }

        return round($this->clicks_count / $this->impressions_count * 100, 2);
    }

    /** L'annonce a-t-elle atteint l'un de ses plafonds ? */
    public function getIsCappedAttribute(): bool
    {
        return ($this->impression_limit && $this->impressions_count >= $this->impression_limit)
            || ($this->click_limit && $this->clicks_count >= $this->click_limit);
    }

    /** Date de fin dépassée. */
    public function getIsExpiredAttribute(): bool
    {
        return $this->ends_at !== null && $this->ends_at->isPast();
    }

    /* ------------------------------------------------------------------ */

    /**
     * Résout le produit (autre base) : nom, prix, image, url. Retourne null si
     * le produit n'existe plus. Aucune jointure inter-bases.
     */
    public function productData(): ?array
    {
        if ($this->type !== self::TYPE_PRODUCT || empty($this->product_id)) {
            return null;
        }

        try {
            $p = DB::table('products')->where('id', $this->product_id)->first();
        } catch (\Throwable $e) {
            return null;
        }

        if (! $p) {
            return null;
        }

        return [
            'id'    => (int) $p->id,
            'name'  => (string) ($p->name ?? ''),
            'price' => $p->price_ttc ?? $p->price_ht ?? 0,
            'image' => $p->main_image ?: $this->media_url,
            'slug'  => $p->slug ?? null,
        ];
    }
}
