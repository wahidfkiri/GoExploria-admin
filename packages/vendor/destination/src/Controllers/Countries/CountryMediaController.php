<?php

namespace Vendor\Destination\Controllers\Countries;

use App\Http\Controllers\Controller;
use App\Models\CountryMedia;
use App\Models\Country;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CountryMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = CountryMedia::query();
            
            // Filtres
            if ($request->has('country_id')) {
                $query->where('country_id', $request->country_id);
            }
            
            if ($request->has('activity_id')) {
                $query->where('activity_id', $request->activity_id);
            }
            
            if ($request->has('type')) {
                $query->where('type', $request->type);
            }
            
            if ($request->has('is_active')) {
                $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
            }
            
            if ($request->has('is_featured')) {
                $query->where('is_featured', filter_var($request->is_featured, FILTER_VALIDATE_BOOLEAN));
            }
            
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('alt_text', 'like', "%{$search}%");
                });
            }
            
            // Tri
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);
            
            // Pagination
            $perPage = $request->get('per_page', 20);
            $medias = $query->with(['country', 'activity', 'creator'])->paginate($perPage);
            
            return response()->json([
                'success' => true,
                'data' => $medias,
                'message' => 'Médias récupérés avec succès'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des médias', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des médias'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Début création de média', ['request' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'type' => 'required|in:image,video_local,video_youtube,video_vimeo,video_dailymotion,video_other',
                'image_file' => 'nullable|image|max:51200', // 50MB max pour les images
                'video_file' => 'nullable|mimes:mp4,avi,mov,wmv,flv,mkv|max:512000', // 500MB max pour les vidéos
                'video_url' => 'nullable|url',
                'alt_text' => 'nullable|string|max:255',
                'tags' => 'nullable|string',
                'is_featured' => 'boolean',
                'is_active' => 'boolean',
                'country_id' => 'required|exists:countries,id',
                'activity_id' => 'nullable|exists:activities,id',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => 'Erreur de validation'
                ], 422);
            }
            
            $data = $request->only([
                'title', 'description', 'type', 'video_url', 
                'alt_text', 'is_featured', 'is_active', 
                'country_id', 'activity_id'
            ]);
            
            $data['is_featured'] = $request->boolean('is_featured', false);
            $data['is_active'] = $request->boolean('is_active', true);
            
            // Gérer les tags
            if ($request->has('tags')) {
                $tags = array_map('trim', explode(',', $request->tags));
                $data['tags'] = json_encode($tags);
            }
            
            // Gérer les images
            if ($request->hasFile('image_file') && $request->type === 'image') {
                $imagePath = $request->file('image_file')->store('country_medias/images', 'public');
                $data['image_path'] = $imagePath;
                
                // Récupérer les infos de l'image
                $data['mime_type'] = $request->file('image_file')->getMimeType();
                $data['file_size'] = $request->file('image_file')->getSize();
                
                // Pour les dimensions, vous pouvez utiliser Intervention Image si installé
                // Sinon, on les laisse null
            }
            
            // Gérer les vidéos locales
            if ($request->hasFile('video_file') && $request->type === 'video_local') {
                $videoPath = $request->file('video_file')->store('country_medias/videos', 'public');
                $data['video_path'] = $videoPath;
                
                $data['mime_type'] = $request->file('video_file')->getMimeType();
                $data['file_size'] = $request->file('video_file')->getSize();
                
                // Générer une thumbnail (simplifié - en production, utiliser FFmpeg)
                // Pour l'instant, on utilise une image par défaut
                $data['image_path'] = 'defaults/video-thumbnail.jpg';
            }
            
            // Gérer les vidéos YouTube/Vimeo
            if (in_array($request->type, ['video_youtube', 'video_vimeo', 'video_dailymotion']) && $request->video_url) {
                $data['video_url'] = $request->video_url;
                
                // Extraire l'ID de la vidéo
                $videoId = $this->extractVideoId($request->video_url, $request->type);
                if ($videoId) {
                    $data['video_id'] = $videoId;
                    $data['video_provider'] = str_replace('video_', '', $request->type);
                }
            }
            
            // Créer le média
            $media = CountryMedia::create($data);
            
            Log::info('Média créé avec succès', ['media_id' => $media->id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Média créé avec succès',
                'data' => $media->load(['country', 'activity', 'creator'])
            ], 201);
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du média', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['image_file', 'video_file'])
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du média'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $media = CountryMedia::with(['country', 'activity', 'creator'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $media,
                'message' => 'Média récupéré avec succès'
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Média non trouvé'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération du média', [
                'media_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération du média'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $media = CountryMedia::findOrFail($id);
            
            Log::info('Début mise à jour de média', [
                'media_id' => $id,
                'request' => $request->all()
            ]);
            
            $validator = Validator::make($request->all(), [
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'type' => 'sometimes|in:image,video_local,video_youtube,video_vimeo,video_dailymotion,video_other',
                'image_file' => 'nullable|image|max:51200',
                'video_file' => 'nullable|mimes:mp4,avi,mov,wmv,flv,mkv|max:512000',
                'video_url' => 'nullable|url',
                'alt_text' => 'nullable|string|max:255',
                'tags' => 'nullable|string',
                'is_featured' => 'boolean',
                'is_active' => 'boolean',
                'activity_id' => 'nullable|exists:activities,id',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => 'Erreur de validation'
                ], 422);
            }
            
            $data = $request->only([
                'title', 'description', 'alt_text', 'is_featured', 
                'is_active', 'activity_id'
            ]);
            
            if ($request->has('is_featured')) {
                $data['is_featured'] = $request->boolean('is_featured');
            }
            
            if ($request->has('is_active')) {
                $data['is_active'] = $request->boolean('is_active');
            }
            
            // Gérer les tags
            if ($request->has('tags')) {
                $tags = array_map('trim', explode(',', $request->tags));
                $data['tags'] = json_encode($tags);
            }
            
            // Gérer le changement d'image
            if ($request->hasFile('image_file')) {
                // Supprimer l'ancienne image
                if ($media->image_path && !Str::startsWith($media->image_path, 'defaults/')) {
                    Storage::disk('public')->delete($media->image_path);
                }
                
                $imagePath = $request->file('image_file')->store('country_medias/images', 'public');
                $data['image_path'] = $imagePath;
                $data['mime_type'] = $request->file('image_file')->getMimeType();
                $data['file_size'] = $request->file('image_file')->getSize();
            }
            
            // Gérer le changement de vidéo locale
            if ($request->hasFile('video_file')) {
                // Supprimer l'ancienne vidéo
                if ($media->video_path) {
                    Storage::disk('public')->delete($media->video_path);
                }
                
                $videoPath = $request->file('video_file')->store('country_medias/videos', 'public');
                $data['video_path'] = $videoPath;
                $data['mime_type'] = $request->file('video_file')->getMimeType();
                $data['file_size'] = $request->file('video_file')->getSize();
                $data['type'] = 'video_local';
            }
            
            // Gérer le changement de vidéo URL
            if ($request->has('video_url') && in_array($request->type, ['video_youtube', 'video_vimeo', 'video_dailymotion'])) {
                $data['video_url'] = $request->video_url;
                
                // Extraire l'ID de la vidéo
                $videoId = $this->extractVideoId($request->video_url, $request->type);
                if ($videoId) {
                    $data['video_id'] = $videoId;
                    $data['video_provider'] = str_replace('video_', '', $request->type);
                }
                
                $data['type'] = $request->type;
            }
            
            // Mettre à jour le média
            $media->update($data);
            
            Log::info('Média mis à jour avec succès', ['media_id' => $media->id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Média mis à jour avec succès',
                'data' => $media->load(['country', 'activity', 'creator'])
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Média non trouvé'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du média', [
                'media_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du média'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $media = CountryMedia::findOrFail($id);
            
            // Supprimer les fichiers physiques
            if ($media->image_path && !Str::startsWith($media->image_path, 'defaults/')) {
                Storage::disk('public')->delete($media->image_path);
            }
            
            if ($media->video_path) {
                Storage::disk('public')->delete($media->video_path);
            }
            
            $media->delete();
            
            Log::info('Média supprimé avec succès', ['media_id' => $id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Média supprimé avec succès'
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Média non trouvé'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression du média', [
                'media_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du média'
            ], 500);
        }
    }

    /**
     * Toggle active status
     */
    public function toggleStatus($id)
    {
        try {
            $media = CountryMedia::findOrFail($id);
            $media->is_active = !$media->is_active;
            $media->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Statut mis à jour avec succès',
                'data' => [
                    'is_active' => $media->is_active
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur lors du changement de statut', [
                'media_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du changement de statut'
            ], 500);
        }
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured($id)
    {
        try {
            $media = CountryMedia::findOrFail($id);
            $media->is_featured = !$media->is_featured;
            $media->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Statut "À la une" mis à jour avec succès',
                'data' => [
                    'is_featured' => $media->is_featured
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur lors du changement de statut "À la une"', [
                'media_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du changement de statut "À la une"'
            ], 500);
        }
    }

    /**
     * Extract video ID from URL
     */
    private function extractVideoId($url, $type)
    {
        switch ($type) {
            case 'video_youtube':
                // Patterns pour YouTube
                $patterns = [
                    '/youtube\.com\/watch\?v=([^&]+)/',
                    '/youtu\.be\/([^?]+)/',
                    '/youtube\.com\/embed\/([^?]+)/'
                ];
                break;
                
            case 'video_vimeo':
                // Patterns pour Vimeo
                $patterns = [
                    '/vimeo\.com\/(\d+)/',
                    '/vimeo\.com\/video\/(\d+)/'
                ];
                break;
                
            case 'video_dailymotion':
                // Patterns pour Dailymotion
                $patterns = [
                    '/dailymotion\.com\/video\/([^_]+)/',
                    '/dai\.ly\/([^?]+)/'
                ];
                break;
                
            default:
                return null;
        }
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }
        
        return null;
    }

    /**
     * Get statistics for media
     */
    public function statistics(Request $request)
    {
        try {
            $countryId = $request->get('country_id');
            
            $query = CountryMedia::query();
            
            if ($countryId) {
                $query->where('country_id', $countryId);
            }
            
            $stats = [
                'total' => $query->count(),
                'images' => $query->clone()->where('type', 'image')->count(),
                'videos' => $query->clone()->where('type', 'like', 'video_%')->count(),
                'video_local' => $query->clone()->where('type', 'video_local')->count(),
                'video_youtube' => $query->clone()->where('type', 'video_youtube')->count(),
                'video_vimeo' => $query->clone()->where('type', 'video_vimeo')->count(),
                'active' => $query->clone()->where('is_active', true)->count(),
                'featured' => $query->clone()->where('is_featured', true)->count(),
            ];
            
            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Statistiques récupérées avec succès'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des statistiques', [
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des statistiques'
            ], 500);
        }
    }
}