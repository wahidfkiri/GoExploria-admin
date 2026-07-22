<?php

namespace Vendor\Cms\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Etablissement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Vendor\Cms\Models\Media;

/**
 * API des galeries photos/vidéos filtrables (Lot 2).
 *
 * Alimente les composants de galerie de l'éditeur et leur rendu front.
 *
 * Rappel de contrainte (cf. migration du Lot 1) : cms_media vit dans la base
 * « cms », les référentiels destinations/activities/categories dans la base
 * applicative. On ne joint donc JAMAIS entre bases :
 *   1. on filtre/pagine les médias sur la connexion « cms » ;
 *   2. on résout les libellés des taxonomies en requêtes groupées séparées.
 */
class GalleryController extends Controller
{
    /** Référentiels : table (connexion par défaut) par dimension. */
    protected array $refTables = [
        'destination' => 'destinations',
        'activite'    => 'activities',
        'categorie'   => 'categories',
    ];

    /**
     * Médias filtrés + paginés.
     * GET /api/cms/company/{etab}/galleries/media
     */
    public function media(Request $request, $etablissementId): JsonResponse
    {
        $etablissement = Etablissement::findOrFail($etablissementId);

        $data = $request->validate([
            'type'           => 'nullable|in:image,video',
            'destination_id' => 'nullable|integer',
            'activite_id'    => 'nullable', // int ou liste "1,2,3"
            'categorie_id'   => 'nullable',
            'q'              => 'nullable|string|max:120',
            'limit'          => 'nullable|integer|min:1|max:60',
            'page'           => 'nullable|integer|min:1',
        ]);

        $limit = (int) ($data['limit'] ?? 12);

        $query = Media::query()
            ->where('etablissement_id', $etablissement->id)
            ->where('is_public', true);

        // Le type est géré par les scopes (robustes aux valeurs mime : image/jpeg…),
        // le reste par galleryFilter().
        $type = $data['type'] ?? null;
        if ($type === 'image') {
            $query->images();
        } elseif ($type === 'video') {
            $query->videos();
        }

        $query->galleryFilter([
            'destination_id' => $data['destination_id'] ?? null,
            'activite_id'    => $this->ids($data['activite_id'] ?? null),
            'categorie_id'   => $this->ids($data['categorie_id'] ?? null),
            'q'              => $data['q'] ?? null,
        ]);

        $page = $query->ordered()->paginate($limit);

        /** @var \Illuminate\Support\Collection<int,Media> $items */
        $items = collect($page->items());
        $mediaIds = $items->pluck('id')->all();

        // Rattachements chargés en lot (anti N+1).
        $actByMedia = Media::pivotIdsFor($mediaIds, Media::PIVOT_ACTIVITE, 'activite_id');
        $catByMedia = Media::pivotIdsFor($mediaIds, Media::PIVOT_CATEGORIE, 'categorie_id');

        // Libellés des taxonomies présentes sur la page, résolus en 3 requêtes.
        $destLabels = $this->labels('destination', $items->pluck('destination_id')->filter()->unique()->all());
        $actLabels  = $this->labels('activite', collect($actByMedia)->flatten()->unique()->all());
        $catLabels  = $this->labels('categorie', collect($catByMedia)->flatten()->unique()->all());

        $payload = $items->map(function (Media $m) use ($actByMedia, $catByMedia, $destLabels, $actLabels, $catLabels) {
            $isVideo = str_starts_with((string) $m->type, 'video') || $m->type === 'video';

            return [
                'id'          => $m->id,
                'type'        => $isVideo ? 'video' : 'image',
                'url'         => $m->url,
                'video_url'   => $m->video_url ?: null,
                'title'       => $m->title ?: $m->name,
                'alt'         => $m->alt ?: ($m->title ?: $m->name),
                'description' => $m->description,
                'link_text'   => $m->button_text ?: null,
                'link_url'    => $m->button_url ?: null,
                'width'       => $m->width,
                'height'      => $m->height,
                'destination' => $m->destination_id ? ($destLabels[$m->destination_id] ?? null) : null,
                'activites'   => $this->pick($actByMedia[$m->id] ?? [], $actLabels),
                'categories'  => $this->pick($catByMedia[$m->id] ?? [], $catLabels),
            ];
        })->all();

        return response()->json([
            'success'    => true,
            'data'       => $payload,
            'pagination' => [
                'current_page' => $page->currentPage(),
                'last_page'    => $page->lastPage(),
                'per_page'     => $page->perPage(),
                'total'        => $page->total(),
                'has_more'     => $page->hasMorePages(),
            ],
        ]);
    }

    /**
     * Valeurs de filtre RÉELLEMENT disponibles pour cet établissement
     * (on n'affiche pas un filtre qui ne renverrait aucun média).
     * GET /api/cms/company/{etab}/galleries/filters
     */
    public function filters(Request $request, $etablissementId): JsonResponse
    {
        $etablissement = Etablissement::findOrFail($etablissementId);

        // Identifiants des médias publics de l'établissement (une seule fois).
        $mediaIds = Media::where('etablissement_id', $etablissement->id)
            ->where('is_public', true)
            ->pluck('id')
            ->all();

        if (empty($mediaIds)) {
            return response()->json([
                'success' => true,
                'destinations' => [], 'activites' => [], 'categories' => [],
            ]);
        }

        // Destinations distinctes réellement utilisées.
        $destIds = Media::whereIn('id', $mediaIds)
            ->whereNotNull('destination_id')
            ->distinct()
            ->pluck('destination_id')
            ->all();

        // Activités / catégories distinctes via les pivots (connexion cms).
        $conn = Media::query()->getConnection();
        $actIds = $conn->table(Media::PIVOT_ACTIVITE)->whereIn('media_id', $mediaIds)->distinct()->pluck('activite_id')->all();
        $catIds = $conn->table(Media::PIVOT_CATEGORIE)->whereIn('media_id', $mediaIds)->distinct()->pluck('categorie_id')->all();

        return response()->json([
            'success'      => true,
            'destinations' => $this->options('destination', $destIds),
            'activites'    => $this->options('activite', $actIds),
            'categories'   => $this->options('categorie', $catIds),
        ]);
    }

    /* ------------------------------------------------------------------ */

    /** Normalise "1,2,3" | 2 | [1,2] en tableau d'entiers. */
    protected function ids($value): array
    {
        if (is_array($value)) {
            $raw = $value;
        } elseif (is_string($value)) {
            $raw = explode(',', $value);
        } elseif ($value === null || $value === '') {
            return [];
        } else {
            $raw = [$value];
        }

        return array_values(array_filter(array_map('intval', $raw)));
    }

    /**
     * Libellés d'une taxonomie : id => name, résolus sur la connexion par
     * défaut (référentiels), en UNE requête. Zéro jointure inter-bases.
     *
     * @return array<int,string>
     */
    protected function labels(string $dim, array $ids): array
    {
        $ids = array_values(array_filter(array_map('intval', $ids)));
        if (empty($ids) || !isset($this->refTables[$dim])) {
            return [];
        }

        return DB::table($this->refTables[$dim])
            ->whereIn('id', $ids)
            ->pluck('name', 'id')
            ->map(fn ($n) => (string) $n)
            ->all();
    }

    /**
     * Options de filtre {id, name, slug} pour une taxonomie, triées par nom,
     * limitées aux ids fournis (uniquement les valeurs actives si la colonne
     * existe).
     */
    protected function options(string $dim, array $ids): array
    {
        $ids = array_values(array_filter(array_map('intval', $ids)));
        if (empty($ids) || !isset($this->refTables[$dim])) {
            return [];
        }

        $table = $this->refTables[$dim];
        $cols = ['id', 'name'];
        if (\Illuminate\Support\Facades\Schema::hasColumn($table, 'slug')) {
            $cols[] = 'slug';
        }

        $q = DB::table($table)->whereIn('id', $ids);
        if (\Illuminate\Support\Facades\Schema::hasColumn($table, 'is_active')) {
            $q->where('is_active', true);
        }

        return $q->orderBy('name')->get($cols)->map(fn ($r) => [
            'id'   => (int) $r->id,
            'name' => (string) $r->name,
            'slug' => $r->slug ?? null,
        ])->all();
    }

    /** Transforme une liste d'ids en [{id,name}] à partir d'un dictionnaire. */
    protected function pick(array $ids, array $labels): array
    {
        $out = [];
        foreach ($ids as $id) {
            if (isset($labels[$id])) {
                $out[] = ['id' => (int) $id, 'name' => $labels[$id]];
            }
        }

        return $out;
    }
}
