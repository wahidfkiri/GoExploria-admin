<?php 

namespace Vendor\Administration\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\PageRevision;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuPageController extends Controller
{
    // Éditer la page d'un menu
    public function edit(Menu $menu)
    {
        // Vérifier si le menu a une page
        if (!$menu->has_page) {
            $menu->update([
                'has_page' => true,
                'page_slug' => $menu->slug . '-' . Str::random(6),
                'page_meta' => [
                    'title' => $menu->title,
                    'description' => 'Page de ' . $menu->title,
                    'keywords' => $menu->title . ', tourisme, voyage'
                ]
            ]);
            
            // Créer une révision initiale
            $menu->createRevision('Création initiale de la page');
        }
        
        return view('administration::menus.page-editor', compact('menu'));
    }
    
    // Mettre à jour le contenu de la page
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'content' => 'required|string',
            'styles' => 'nullable|string',
            'meta' => 'nullable|array',
            'change_description' => 'nullable|string|max:255'
        ]);
        
        $menu->update([
            'page_content' => $request->content,
            'page_styles' => $request->styles,
            'page_meta' => $request->meta,
            'page_status' => 'draft' // Mettre en brouillon après modification
        ]);
        
        // Créer une révision
        $menu->createRevision($request->change_description);
        
        return response()->json([
            'success' => true,
            'message' => 'Page sauvegardée avec succès',
            'data' => [
                'status' => 'draft',
                'saved_at' => now()->format('d/m/Y H:i:s')
            ]
        ]);
    }
    
    // Publier la page
    public function publish(Request $request, Menu $menu)
    {
        $menu->update([
            'page_status' => 'published',
            'published_at' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Page publiée avec succès',
            'data' => [
                'status' => 'published',
                'published_at' => $menu->published_at
            ]
        ]);
    }
    
    // Dépublier la page
    public function unpublish(Request $request, Menu $menu)
    {
        $menu->update([
            'page_status' => 'draft'
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Page retirée de la publication',
            'data' => [
                'status' => 'draft'
            ]
        ]);
    }
    
    // Prévisualiser la page
    public function preview(Menu $menu)
    {
        if (!$menu->has_page) {
            abort(404);
        }
        
        return view('pages.preview', compact('menu'));
    }
    
    // Activer/désactiver la page
    public function togglePage(Request $request, Menu $menu)
    {
        $menu->update([
            'has_page' => !$menu->has_page
        ]);
        
        $status = $menu->has_page ? 'activée' : 'désactivée';
        
        return response()->json([
            'success' => true,
            'message' => "Page {$status} avec succès",
            'data' => [
                'has_page' => $menu->has_page
            ]
        ]);
    }
    
    // Voir les révisions
    public function revisions(Menu $menu)
    {
        $revisions = $menu->pageRevisions()->with('user')->latest()->get();
        
        return response()->json([
            'success' => true,
            'data' => $revisions
        ]);
    }
    
    // Restaurer une révision
    public function restoreRevision(Request $request, Menu $menu, PageRevision $revision)
    {
        $menu->restoreRevision($revision);
        
        // Créer une nouvelle révision pour la restauration
        $menu->createRevision("Restauration de la version {$revision->version}");
        
        return response()->json([
            'success' => true,
            'message' => 'Révision restaurée avec succès'
        ]);
    }

    // app/Http\Controllers\Admin\MenuPageController.php
public function updateSettings(Request $request, Menu $menu)
{
    $request->validate([
        'title' => 'nullable|string|max:255',
        'slug' => 'nullable|string|max:255|unique:menus,page_slug,' . $menu->id,
        'config' => 'nullable|array'
    ]);
    
    $updates = [];
    
    if ($request->title) {
        $updates['page_meta->title'] = $request->title;
    }
    
    if ($request->slug) {
        $updates['page_slug'] = $request->slug;
    }
    
    if ($request->config) {
        $currentConfig = $menu->page_config ?? [];
        $updates['page_config'] = array_merge($currentConfig, $request->config);
    }
    
    $menu->update($updates);
    
    return response()->json([
        'success' => true,
        'message' => 'Paramètres mis à jour avec succès'
    ]);
}

public function updateSeo(Request $request, Menu $menu)
{
    $request->validate([
        'meta' => 'required|array'
    ]);
    
    $currentMeta = $menu->page_meta ?? [];
    $newMeta = array_merge($currentMeta, $request->meta);
    
    $menu->update([
        'page_meta' => $newMeta
    ]);
    
    return response()->json([
        'success' => true,
        'message' => 'Paramètres SEO mis à jour avec succès'
    ]);
}

public function previewRevision(Menu $menu, PageRevision $revision)
{
    if ($revision->menu_id !== $menu->id) {
        abort(404);
    }
    
    return view('admin.menus.revision-preview', compact('menu', 'revision'));
}
}