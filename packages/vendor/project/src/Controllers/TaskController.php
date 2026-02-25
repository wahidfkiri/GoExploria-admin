<?php

namespace Vendor\Project\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Models\Etablissement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Constructeur avec middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the tasks.
     */
    public function index(Request $request)
    {
        // Si c'est une requête AJAX
        if ($request->ajax()) {
            return $this->getTasksData($request);
        }
        
        // Récupérer les données pour les filtres
        $projects = Project::where('etablissement_id', Auth::user()->etablissement_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);
        
        $users = User::where('is_active', true)
            ->where('etablissement_id', Auth::user()->etablissement_id)
            ->orderBy('name')
            ->get(['id', 'name']);
        
        $statuses = [
            'pending' => 'En attente',
            'in_progress' => 'En cours',
            'test' => 'En test',
            'integrated' => 'Intégré',
            'delivered' => 'Livré',
            'approved' => 'Approuvé',
            'cancelled' => 'Annulé',
        ];
        
        return view('tasks.index', compact('projects', 'users', 'statuses'));
    }

    /**
     * Get tasks data for AJAX requests.
     */
    private function getTasksData(Request $request)
    {
        try {
            $query = Task::with([
                'project', 
                'user', 
                'creator',
                'etablissement'
            ])
            ->where('etablissement_id', Auth::user()->etablissement_id);
            
            // Apply search
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('details', 'like', "%{$search}%")
                      ->orWhere('contract_number', 'like', "%{$search}%")
                      ->orWhere('contact_name', 'like', "%{$search}%")
                      ->orWhereHas('project', function($projectQuery) use ($search) {
                          $projectQuery->where('name', 'like', "%{$search}%");
                      });
                });
            }
            
            // Apply filters
            if ($request->filled('project_id')) {
                $query->where('project_id', $request->project_id);
            }
            
            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }
            
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            if ($request->filled('priority')) {
                $query->whereJsonContains('metadata->priority', $request->priority);
            }
            
            if ($request->filled('is_active')) {
                $query->where('is_active', $request->is_active === '1');
            }
            
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', Carbon::parse($request->date_from));
            }
            
            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', Carbon::parse($request->date_to));
            }
            
            if ($request->filled('due_date_from')) {
                $query->whereDate('due_date', '>=', Carbon::parse($request->due_date_from));
            }
            
            if ($request->filled('due_date_to')) {
                $query->whereDate('due_date', '<=', Carbon::parse($request->due_date_to));
            }
            
            if ($request->filled('country')) {
                $query->where('country', 'like', "%{$request->country}%");
            }
            
            if ($request->filled('location')) {
                $query->where('location', 'like', "%{$request->location}%");
            }
            
            // Apply sorting
            $sortField = $request->get('sort_by', 'created_at');
            $sortDirection = $request->get('sort_direction', 'desc');
            
            $allowedSortFields = ['name', 'status', 'created_at', 'updated_at', 'due_date', 'delivery_date', 'estimated_hours'];
            if (in_array($sortField, $allowedSortFields)) {
                $query->orderBy($sortField, $sortDirection);
            } else {
                $query->orderBy('created_at', 'desc');
            }
            
            // Get total count before pagination
            $totalTasks = $query->count();
            
            // Pagination
            $perPage = $request->get('per_page', 15);
            $tasks = $query->paginate($perPage);
            
            // Transform tasks for response
            $tasks->getCollection()->transform(function($task) {
                $metadata = json_decode($task->metadata, true) ?? [];
                
                return [
                    'id' => $task->id,
                    'name' => $task->name,
                    'details' => Str::limit(strip_tags($task->details), 100),
                    'project_id' => $task->project_id,
                    'project_name' => $task->project->name ?? 'N/A',
                    'user_id' => $task->user_id,
                    'user_name' => $task->user->name ?? 'Non assigné',
                    'creator_name' => $task->creator->name ?? 'Système',
                    'country' => $task->country,
                    'location' => $task->location,
                    'contract_number' => $task->contract_number,
                    'contact_name' => $task->contact_name,
                    'due_date' => $task->due_date ? $task->due_date->format('d/m/Y H:i') : null,
                    'due_date_raw' => $task->due_date,
                    'delivery_date' => $task->delivery_date ? $task->delivery_date->format('d/m/Y H:i') : null,
                    'delivery_date_raw' => $task->delivery_date,
                    'estimated_hours' => $task->estimated_hours,
                    'hourly_rate' => $task->hourly_rate,
                    'estimated_cost' => $task->estimated_cost,
                    'estimated_cost_formatted' => number_format($task->estimated_cost ?? 0, 2, ',', ' ') . ' €',
                    'status' => $task->status,
                    'status_formatted' => $task->formatted_status,
                    'status_color' => $task->status_color,
                    
                    // Dates techniques
                    'test_date' => $task->test_date ? $task->test_date->format('d/m/Y H:i') : null,
                    'test_details' => $task->test_details,
                    'integration_date' => $task->integration_date ? $task->integration_date->format('d/m/Y H:i') : null,
                    'push_prod_date' => $task->push_prod_date ? $task->push_prod_date->format('d/m/Y H:i') : null,
                    'module_url' => $task->module_url,
                    
                    // Approbation
                    'is_approved_by_manager' => $task->is_approved_by_manager,
                    'approved_by_name' => $task->approvedBy->name ?? null,
                    'approved_at' => $task->approved_at ? $task->approved_at->format('d/m/Y H:i') : null,
                    
                    // Gestionnaires
                    'general_manager' => $task->generalManager ? [
                        'id' => $task->generalManager->id,
                        'name' => $task->generalManager->name,
                        'email' => $task->generalManager->email,
                    ] : null,
                    'client_manager' => $task->clientManager ? [
                        'id' => $task->clientManager->id,
                        'name' => $task->clientManager->name,
                        'email' => $task->clientManager->email,
                    ] : null,
                    
                    // Métadonnées
                    'priority' => $metadata['priority'] ?? 'medium',
                    'tags' => $metadata['tags'] ?? [],
                    'is_active' => $task->is_active,
                    'is_overdue' => $task->isOverdue(),
                    'days_remaining' => $task->daysRemaining,
                    
                    'created_at' => $task->created_at->format('d/m/Y H:i'),
                    'created_at_raw' => $task->created_at,
                    'updated_at' => $task->updated_at->format('d/m/Y H:i'),
                    
                    // URLs
                    'urls' => [
                        'show' => route('tasks.show', $task->id),
                        'edit' => route('tasks.edit', $task->id),
                        'delete' => route('tasks.destroy', $task->id),
                        'project' => route('projects.show', $task->project_id),
                    ]
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $tasks->items(),
                'current_page' => $tasks->currentPage(),
                'last_page' => $tasks->lastPage(),
                'per_page' => $tasks->perPage(),
                'total' => $tasks->total(),
                'from' => $tasks->firstItem(),
                'to' => $tasks->lastItem(),
                'prev_page_url' => $tasks->previousPageUrl(),
                'next_page_url' => $tasks->nextPageUrl(),
                'total_tasks' => $totalTasks,
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error loading tasks: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des tâches',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Get task statistics.
     */
    public function statistics(Request $request)
    {
        try {
            $etablissementId = Auth::user()->etablissement_id;
            
            $query = Task::where('etablissement_id', $etablissementId);
            
            if ($request->filled('project_id')) {
                $query->where('project_id', $request->project_id);
            }
            
            // Statistiques de base
            $total = $query->count();
            
            $byStatus = $query->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get()
                ->keyBy('status');
            
            $byUser = $query->select('user_id', DB::raw('count(*) as total'))
                ->whereNotNull('user_id')
                ->with('user:id,name')
                ->groupBy('user_id')
                ->orderByDesc('total')
                ->limit(5)
                ->get()
                ->map(function($item) {
                    return [
                        'user_id' => $item->user_id,
                        'user_name' => $item->user->name ?? 'Inconnu',
                        'total' => $item->total,
                    ];
                });
            
            $byProject = $query->select('project_id', DB::raw('count(*) as total'))
                ->whereNotNull('project_id')
                ->with('project:id,name')
                ->groupBy('project_id')
                ->orderByDesc('total')
                ->limit(5)
                ->get()
                ->map(function($item) {
                    return [
                        'project_id' => $item->project_id,
                        'project_name' => $item->project->name ?? 'Inconnu',
                        'total' => $item->total,
                    ];
                });
            
            // Tâches en retard
            $overdue = $query->clone()
                ->whereNotNull('due_date')
                ->where('due_date', '<', now())
                ->whereNotIn('status', ['approved', 'cancelled'])
                ->count();
            
            // Tâches à venir (7 prochains jours)
            $upcoming = $query->clone()
                ->whereNotNull('due_date')
                ->whereBetween('due_date', [now(), now()->addDays(7)])
                ->whereNotIn('status', ['approved', 'cancelled'])
                ->count();
            
            // Statistiques temporelles
            $completedThisMonth = $query->clone()
                ->where('status', 'approved')
                ->where('updated_at', '>=', now()->startOfMonth())
                ->count();
            
            $createdThisMonth = $query->clone()
                ->where('created_at', '>=', now()->startOfMonth())
                ->count();
            
            // Totaux financiers
            $totalHours = $query->sum('estimated_hours');
            $totalCost = $query->sum('estimated_cost');
            
            // Évolution mensuelle
            $monthlyEvolution = collect(range(5, 0))->map(function($monthsAgo) use ($etablissementId, $request) {
                $date = now()->subMonths($monthsAgo);
                $startOfMonth = $date->copy()->startOfMonth();
                $endOfMonth = $date->copy()->endOfMonth();
                
                $taskQuery = Task::where('etablissement_id', $etablissementId)
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                
                if ($request->filled('project_id')) {
                    $taskQuery->where('project_id', $request->project_id);
                }
                
                $created = $taskQuery->count();
                
                $completed = Task::where('etablissement_id', $etablissementId)
                    ->where('status', 'approved')
                    ->whereBetween('updated_at', [$startOfMonth, $endOfMonth])
                    ->when($request->filled('project_id'), function($q) use ($request) {
                        $q->where('project_id', $request->project_id);
                    })
                    ->count();
                
                return [
                    'month' => $date->format('Y-m'),
                    'month_label' => $date->locale('fr')->isoFormat('MMM YYYY'),
                    'created' => $created,
                    'completed' => $completed,
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => [
                    'total' => $total,
                    'by_status' => $byStatus,
                    'by_user' => $byUser,
                    'by_project' => $byProject,
                    'overdue' => $overdue,
                    'upcoming' => $upcoming,
                    'completed_this_month' => $completedThisMonth,
                    'created_this_month' => $createdThisMonth,
                    'total_hours' => $totalHours,
                    'total_cost' => $totalCost,
                    'total_cost_formatted' => number_format($totalCost, 2, ',', ' ') . ' €',
                    'monthly_evolution' => $monthlyEvolution,
                    
                    // Comptes par statut
                    'pending' => $byStatus['pending']->total ?? 0,
                    'in_progress' => $byStatus['in_progress']->total ?? 0,
                    'test' => $byStatus['test']->total ?? 0,
                    'integrated' => $byStatus['integrated']->total ?? 0,
                    'delivered' => $byStatus['delivered']->total ?? 0,
                    'approved' => $byStatus['approved']->total ?? 0,
                    'cancelled' => $byStatus['cancelled']->total ?? 0,
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error loading task statistics: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des statistiques',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Show the form for creating a new task.
     */
    public function create(Request $request)
    {
        $projectId = $request->get('project_id');
        $project = null;
        
        if ($projectId) {
            $project = Project::where('etablissement_id', Auth::user()->etablissement_id)
                ->findOrFail($projectId);
        }
        
        $projects = Project::where('etablissement_id', Auth::user()->etablissement_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);
        
        $users = User::where('is_active', true)
            ->where('etablissement_id', Auth::user()->etablissement_id)
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
        
        $statuses = [
            'pending' => 'En attente',
            'in_progress' => 'En cours',
            'test' => 'En test',
            'integrated' => 'Intégré',
            'delivered' => 'Livré',
            'approved' => 'Approuvé',
            'cancelled' => 'Annulé',
        ];
        
        return view('tasks.create', compact('projects', 'users', 'statuses', 'project'));
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'details' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
            'country' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'contract_number' => 'nullable|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'due_date' => 'nullable|date',
            'delivery_date' => 'nullable|date|after_or_equal:due_date',
            'estimated_hours' => 'nullable|integer|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,in_progress,test,integrated,delivered,approved,cancelled',
            'test_date' => 'nullable|date',
            'test_details' => 'nullable|string',
            'integration_date' => 'nullable|date',
            'push_prod_date' => 'nullable|date',
            'module_url' => 'nullable|url|max:255',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'tags' => 'nullable|string',
        ], [
            'name.required' => 'Le nom de la tâche est obligatoire',
            'project_id.required' => 'Le projet est obligatoire',
            'user_id.required' => 'L\'utilisateur assigné est obligatoire',
            'delivery_date.after_or_equal' => 'La date de livraison doit être postérieure à la date d\'échéance',
            'module_url.url' => 'L\'URL du module doit être une URL valide',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            // Récupérer le projet pour l'établissement_id
            $project = Project::findOrFail($request->project_id);
            
            // Calculer le coût estimé
            $estimatedCost = null;
            if ($request->estimated_hours && $request->hourly_rate) {
                $estimatedCost = $request->estimated_hours * $request->hourly_rate;
            }
            
            // Préparer les métadonnées
            $metadata = [
                'priority' => $request->priority ?? 'medium',
                'tags' => $request->tags ? explode(',', $request->tags) : [],
                'created_by' => Auth::user()->name,
                'created_at' => now()->toDateTimeString(),
            ];
            
            // Créer la tâche
            $task = Task::create([
                'name' => $request->name,
                'details' => $request->details,
                'project_id' => $request->project_id,
                'etablissement_id' => $project->etablissement_id,
                'user_id' => $request->user_id,
                'created_by' => Auth::id(),
                'country' => $request->country,
                'location' => $request->location,
                'contract_number' => $request->contract_number,
                'contact_name' => $request->contact_name,
                'due_date' => $request->due_date,
                'delivery_date' => $request->delivery_date,
                'estimated_hours' => $request->estimated_hours,
                'hourly_rate' => $request->hourly_rate,
                'estimated_cost' => $estimatedCost,
                'status' => $request->status,
                'test_date' => $request->test_date,
                'test_details' => $request->test_details,
                'integration_date' => $request->integration_date,
                'push_prod_date' => $request->push_prod_date,
                'module_url' => $request->module_url,
                'is_active' => true,
                'metadata' => json_encode($metadata),
            ]);
            
            // Log l'activité
            // activity()
            //     ->performedOn($task)
            //     ->causedBy(Auth::user())
            //     ->withProperties(['name' => $task->name, 'project' => $project->name])
            //     ->log('Tâche créée');
            
            DB::commit();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tâche créée avec succès',
                    'data' => $task,
                    'redirect' => route('tasks.show', $task->id)
                ]);
            }
            
            return redirect()->route('tasks.show', $task->id)
                ->with('success', 'Tâche créée avec succès');
                
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating task: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la création de la tâche',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Erreur lors de la création de la tâche')
                ->withInput();
        }
    }

    /**
     * Display the specified task.
     */
    public function show(Task $task)
    {
       // $this->authorize('view', $task);
        
        $task->load([
            'project',
            'user',
            'creator',
            'generalManager',
            'clientManager',
            'approvedBy',
            'comments' => function($query) {
                $query->with('user')->latest()->limit(20);
            }
        ]);
        
        $metadata = json_decode($task->metadata, true) ?? [];
        
        return view('tasks.show', compact('task', 'metadata'));
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task, Request $request)
    {
     //   $this->authorize('update', $task);
        
        $projects = Project::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);
        
        $users = User::where('is_active', true)
          //  ->where('etablissement_id', Auth::user()->etablissement_id)
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
        
        $statuses = [
            'pending' => 'En attente',
            'in_progress' => 'En cours',
            'test' => 'En test',
            'integrated' => 'Intégré',
            'delivered' => 'Livré',
            'approved' => 'Approuvé',
            'cancelled' => 'Annulé',
        ];
        
        $generalManagers = User::where('is_active', true)
          //  ->where('etablissement_id', Auth::user()->etablissement_id)
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
        
        $metadata = json_decode($task->metadata, true) ?? [];
        $tags = isset($metadata['tags']) ? implode(',', $metadata['tags']) : '';
        $priority = $metadata['priority'] ?? 'medium';
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $task->id,
                    'name' => $task->name,
                    'details' => $task->details,
                    'project_id' => $task->project_id,
                    'user_id' => $task->user_id,
                    'country' => $task->country,
                    'location' => $task->location,
                    'contract_number' => $task->contract_number,
                    'contact_name' => $task->contact_name,
                    'due_date' => $task->due_date ? $task->due_date->format('Y-m-d\TH:i') : null,
                    'delivery_date' => $task->delivery_date ? $task->delivery_date->format('Y-m-d\TH:i') : null,
                    'estimated_hours' => $task->estimated_hours,
                    'hourly_rate' => $task->hourly_rate,
                    'status' => $task->status,
                    'test_date' => $task->test_date ? $task->test_date->format('Y-m-d\TH:i') : null,
                    'test_details' => $task->test_details,
                    'integration_date' => $task->integration_date ? $task->integration_date->format('Y-m-d\TH:i') : null,
                    'push_prod_date' => $task->push_prod_date ? $task->push_prod_date->format('Y-m-d\TH:i') : null,
                    'module_url' => $task->module_url,
                    'priority' => $priority,
                    'tags' => $tags,
                ]
            ]);
        }
        
        return view('tasks.edit', compact('task', 'projects', 'users', 'statuses', 'generalManagers', 'tags', 'priority'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Task $task)
    {
     //   $this->authorize('update', $task);
        
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'details' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
            'country' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'contract_number' => 'nullable|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'due_date' => 'nullable|date',
            'delivery_date' => 'nullable|date|after_or_equal:due_date',
            'estimated_hours' => 'nullable|integer|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,in_progress,test,integrated,delivered,approved,cancelled',
            'test_date' => 'nullable|date',
            'test_details' => 'nullable|string',
            'integration_date' => 'nullable|date',
            'push_prod_date' => 'nullable|date',
            'module_url' => 'nullable|url|max:255',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'tags' => 'nullable|string',
            'general_manager_id' => 'nullable|exists:users,id',
            'client_manager_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            // Récupérer le projet pour l'établissement_id
            $project = Project::findOrFail($request->project_id);
            
            // Calculer le coût estimé
            $estimatedCost = null;
            if ($request->estimated_hours && $request->hourly_rate) {
                $estimatedCost = $request->estimated_hours * $request->hourly_rate;
            }
            
            // Préparer les métadonnées
            $metadata = json_decode($task->metadata, true) ?? [];
            $metadata['priority'] = $request->priority ?? $metadata['priority'] ?? 'medium';
            $metadata['tags'] = $request->tags ? explode(',', $request->tags) : ($metadata['tags'] ?? []);
            $metadata['updated_by'] = Auth::user()->name;
            $metadata['updated_at'] = now()->toDateTimeString();
            
            $oldStatus = $task->status;
            
            // Mettre à jour la tâche
            $task->update([
                'name' => $request->name,
                'details' => $request->details,
                'project_id' => $request->project_id,
                'etablissement_id' => $project->etablissement_id,
                'user_id' => $request->user_id,
                'country' => $request->country,
                'location' => $request->location,
                'contract_number' => $request->contract_number,
                'contact_name' => $request->contact_name,
                'due_date' => $request->due_date,
                'delivery_date' => $request->delivery_date,
                'estimated_hours' => $request->estimated_hours,
                'hourly_rate' => $request->hourly_rate,
                'estimated_cost' => $estimatedCost,
                'status' => $request->status,
                'test_date' => $request->test_date,
                'test_details' => $request->test_details,
                'integration_date' => $request->integration_date,
                'push_prod_date' => $request->push_prod_date,
                'module_url' => $request->module_url,
                'general_manager_id' => $request->general_manager_id,
                'client_manager_id' => $request->client_manager_id,
                'metadata' => json_encode($metadata),
            ]);
            
            // Log le changement de statut si modifié
            if ($oldStatus !== $request->status) {
                // activity()
                //     ->performedOn($task)
                //     ->causedBy(Auth::user())
                //     ->withProperties([
                //         'old_status' => $oldStatus,
                //         'new_status' => $request->status
                //     ])
                //     ->log('Statut de la tâche modifié');
            }
            
            // Log la mise à jour
            // activity()
            //     ->performedOn($task)
            //     ->causedBy(Auth::user())
            //     ->log('Tâche mise à jour');
            
            DB::commit();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tâche mise à jour avec succès',
                    'data' => $task,
                    'redirect' => route('tasks.show', $task->id)
                ]);
            }
            
            return redirect()->route('tasks.show', $task->id)
                ->with('success', 'Tâche mise à jour avec succès');
                
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating task: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la mise à jour de la tâche',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour de la tâche')
                ->withInput();
        }
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task)
    {
      //  $this->authorize('delete', $task);
        
        try {
            DB::beginTransaction();
            
            $taskName = $task->name;
            $projectName = $task->project->name ?? 'N/A';
            
            // Log avant suppression
            activity()
                ->performedOn($task)
                ->causedBy(Auth::user())
                ->withProperties([
                    'name' => $taskName,
                    'project' => $projectName
                ])
                ->log('Tâche supprimée');
            
            $task->delete();
            
            DB::commit();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "La tâche '{$taskName}' a été supprimée avec succès"
                ]);
            }
            
            return redirect()->route('tasks.index')
                ->with('success', "La tâche '{$taskName}' a été supprimée avec succès");
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error deleting task: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la suppression de la tâche',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression de la tâche');
        }
    }

    /**
     * Toggle task status (for quick checkbox update).
     */
    public function toggleStatus(Request $request, Task $task)
    {
       // $this->authorize('update', $task);
        
        try {
            $oldStatus = $task->status;
            $newStatus = $request->completed ? 'approved' : 'in_progress';
            
            $task->status = $newStatus;
            $task->save();
            
            // activity()
            //     ->performedOn($task)
            //     ->causedBy(Auth::user())
            //     ->withProperties([
            //         'old_status' => $oldStatus,
            //         'new_status' => $newStatus
            //     ])
            //     ->log('Statut de la tâche mis à jour');
            
            return response()->json([
                'success' => true,
                'message' => 'Statut mis à jour avec succès',
                'data' => [
                    'status' => $task->status,
                    'formatted_status' => $task->formatted_status
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error toggling task status: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du statut',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Duplicate a task.
     */
    public function duplicate(Task $task)
    {
       // $this->authorize('view', $task);
        
        try {
            DB::beginTransaction();
            
            $newTask = $task->replicate();
            $newTask->name = $task->name . ' (copie)';
            $newTask->status = 'pending';
            $newTask->created_at = now();
            $newTask->updated_at = now();
            
            // Mettre à jour les métadonnées
            $metadata = json_decode($task->metadata, true) ?? [];
            $metadata['duplicated_from'] = $task->id;
            $metadata['duplicated_at'] = now()->toDateTimeString();
            $metadata['duplicated_by'] = Auth::user()->name;
            $newTask->metadata = json_encode($metadata);
            
            $newTask->save();
            
            activity()
                ->performedOn($newTask)
                ->causedBy(Auth::user())
                ->withProperties(['original' => $task->id])
                ->log('Tâche dupliquée');
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Tâche dupliquée avec succès',
                'data' => $newTask,
                'redirect' => route('tasks.edit', $newTask->id)
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error duplicating task: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la duplication de la tâche',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Assign task to a user.
     */
    public function assign(Request $request, Task $task)
    {
      //  $this->authorize('update', $task);
        
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);
        
        try {
            $oldUser = $task->user->name ?? 'Personne';
            $newUser = User::find($request->user_id)->name;
            
            $task->user_id = $request->user_id;
            $task->save();
            
            activity()
                ->performedOn($task)
                ->causedBy(Auth::user())
                ->withProperties([
                    'old_user' => $oldUser,
                    'new_user' => $newUser
                ])
                ->log('Tâche réassignée');
            
            return response()->json([
                'success' => true,
                'message' => 'Tâche assignée avec succès',
                'data' => [
                    'user_id' => $task->user_id,
                    'user_name' => $task->user->name
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'assignation'
            ], 500);
        }
    }

    /**
     * Get task comments.
     */
    public function comments(Task $task)
    {
       // $this->authorize('view', $task);
        
        $comments = $task->comments()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $comments
        ]);
    }

    /**
     * Add a comment to a task.
     */
    public function addComment(Request $request, Task $task)
    {
      //  $this->authorize('view', $task);
        
        $request->validate([
            'content' => 'required|string'
        ]);
        
        try {
            $comment = $task->comments()->create([
                'user_id' => Auth::id(),
                'content' => $request->content
            ]);
            
            $comment->load('user');
            
            return response()->json([
                'success' => true,
                'message' => 'Commentaire ajouté avec succès',
                'data' => $comment
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout du commentaire'
            ], 500);
        }
    }

    /**
     * Update test date.
     */
    public function updateTestDate(Request $request, Task $task)
    {
     //   $this->authorize('update', $task);
        
        $request->validate([
            'test_date' => 'required|date',
            'test_details' => 'nullable|string'
        ]);
        
        try {
            $task->test_date = $request->test_date;
            $task->test_details = $request->test_details;
            $task->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Date de test mise à jour avec succès'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour'
            ], 500);
        }
    }

    /**
     * Update integration date.
     */
    public function updateIntegrationDate(Request $request, Task $task)
    {
      //  $this->authorize('update', $task);
        
        $request->validate([
            'integration_date' => 'required|date'
        ]);
        
        try {
            $task->integration_date = $request->integration_date;
            $task->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Date d\'intégration mise à jour avec succès'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour'
            ], 500);
        }
    }

    /**
     * Update push to production date.
     */
    public function updatePushProdDate(Request $request, Task $task)
    {
       // $this->authorize('update', $task);
        
        $request->validate([
            'push_prod_date' => 'required|date'
        ]);
        
        try {
            $task->push_prod_date = $request->push_prod_date;
            $task->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Date de mise en production mise à jour avec succès'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour'
            ], 500);
        }
    }

    /**
     * Export tasks to CSV.
     */
    public function export(Request $request)
    {
        try {
            $query = Task::with(['project', 'user', 'creator'])
                ->where('etablissement_id', Auth::user()->etablissement_id);
            
            // Apply filters
            if ($request->filled('project_id')) {
                $query->where('project_id', $request->project_id);
            }
            
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }
            
            $tasks = $query->get();
            
            // Create CSV
            $filename = 'taches_' . now()->format('Y-m-d_His') . '.csv';
            $handle = fopen('php://temp', 'w');
            
            // UTF-8 BOM for Excel
            fputs($handle, "\xEF\xBB\xBF");
            
            // CSV Headers
            fputcsv($handle, [
                'ID',
                'Nom',
                'Projet',
                'Assigné à',
                'Statut',
                'Date d\'échéance',
                'Date de livraison',
                'Heures estimées',
                'Coût estimé',
                'Pays',
                'Lieu',
                'N° Contrat',
                'Contact',
                'Date de test',
                'Date d\'intégration',
                'Date de MEP',
                'URL Module',
                'Approuvé',
                'Créé le',
                'Créé par'
            ], ';');
            
            // Data
            foreach ($tasks as $task) {
                fputcsv($handle, [
                    $task->id,
                    $task->name,
                    $task->project->name ?? 'N/A',
                    $task->user->name ?? 'N/A',
                    $task->formatted_status,
                    $task->due_date ? $task->due_date->format('d/m/Y H:i') : 'N/A',
                    $task->delivery_date ? $task->delivery_date->format('d/m/Y H:i') : 'N/A',
                    $task->estimated_hours ?? 0,
                    number_format($task->estimated_cost ?? 0, 2, ',', ' ') . ' €',
                    $task->country ?? 'N/A',
                    $task->location ?? 'N/A',
                    $task->contract_number ?? 'N/A',
                    $task->contact_name ?? 'N/A',
                    $task->test_date ? $task->test_date->format('d/m/Y H:i') : 'N/A',
                    $task->integration_date ? $task->integration_date->format('d/m/Y H:i') : 'N/A',
                    $task->push_prod_date ? $task->push_prod_date->format('d/m/Y H:i') : 'N/A',
                    $task->module_url ?? 'N/A',
                    $task->is_approved_by_manager ? 'Oui' : 'Non',
                    $task->created_at->format('d/m/Y H:i'),
                    $task->creator->name ?? 'N/A'
                ], ';');
            }
            
            rewind($handle);
            $content = stream_get_contents($handle);
            fclose($handle);
            
            return response($content)
                ->header('Content-Type', 'text/csv; charset=utf-8')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
            
        } catch (\Exception $e) {
            \Log::error('Error exporting tasks: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Erreur lors de l\'export des tâches');
        }
    }

    /**
     * Bulk delete tasks.
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:tasks,id'
        ]);
        
        try {
            DB::beginTransaction();
            
            $tasks = Task::whereIn('id', $request->ids)
                ->where('etablissement_id', Auth::user()->etablissement_id)
                ->get();
            
            $count = $tasks->count();
            $names = $tasks->pluck('name')->implode(', ');
            
            foreach ($tasks as $task) {
            //    $this->authorize('delete', $task);
                $task->delete();
            }
            
            activity()
                ->causedBy(Auth::user())
                ->withProperties(['count' => $count, 'ids' => $request->ids])
                ->log('Suppression multiple de tâches');
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => "{$count} tâche(s) supprimée(s) avec succès",
                'deleted_ids' => $request->ids
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression multiple'
            ], 500);
        }
    }

    /**
     * Get upcoming tasks (for dashboard).
     */
    public function getUpcomingTasks()
    {
        $tasks = Task::where('etablissement_id', Auth::user()->etablissement_id)
            ->whereNotNull('due_date')
            ->where('due_date', '>=', now())
            ->where('due_date', '<=', now()->addDays(7))
            ->whereNotIn('status', ['approved', 'cancelled'])
            ->with(['project', 'user'])
            ->orderBy('due_date')
            ->limit(10)
            ->get()
            ->map(function($task) {
                return [
                    'id' => $task->id,
                    'name' => $task->name,
                    'project_name' => $task->project->name ?? 'N/A',
                    'user_name' => $task->user->name ?? 'Non assigné',
                    'due_date' => $task->due_date->format('d/m/Y H:i'),
                    'days_remaining' => now()->diffInDays($task->due_date, false) + 1,
                    'url' => route('tasks.show', $task->id)
                ];
            });
        
        return response()->json([
            'success' => true,
            'data' => $tasks
        ]);
    }

    /**
     * Get overdue tasks (for dashboard).
     */
    public function getOverdueTasks()
    {
        $tasks = Task::where('etablissement_id', Auth::user()->etablissement_id)
            ->whereNotNull('due_date')
            ->where('due_date', '<', now())
            ->whereNotIn('status', ['approved', 'cancelled'])
            ->with(['project', 'user'])
            ->orderBy('due_date')
            ->limit(10)
            ->get()
            ->map(function($task) {
                return [
                    'id' => $task->id,
                    'name' => $task->name,
                    'project_name' => $task->project->name ?? 'N/A',
                    'user_name' => $task->user->name ?? 'Non assigné',
                    'due_date' => $task->due_date->format('d/m/Y H:i'),
                    'days_overdue' => abs(now()->diffInDays($task->due_date, false)),
                    'url' => route('tasks.show', $task->id)
                ];
            });
        
        return response()->json([
            'success' => true,
            'data' => $tasks
        ]);
    }

    /**
     * Get tasks by user.
     */
    public function getTasksByUser(User $user)
    {
        $tasks = Task::where('etablissement_id', Auth::user()->etablissement_id)
            ->where('user_id', $user->id)
            ->whereNotIn('status', ['approved', 'cancelled'])
            ->with('project')
            ->orderBy('due_date')
            ->limit(20)
            ->get()
            ->map(function($task) {
                return [
                    'id' => $task->id,
                    'name' => $task->name,
                    'project_name' => $task->project->name ?? 'N/A',
                    'status' => $task->formatted_status,
                    'status_color' => $task->status_color,
                    'due_date' => $task->due_date ? $task->due_date->format('d/m/Y H:i') : null,
                    'is_overdue' => $task->isOverdue(),
                    'url' => route('tasks.show', $task->id)
                ];
            });
        
        return response()->json([
            'success' => true,
            'data' => $tasks
        ]);
    }

    /**
     * Get task summary for dashboard.
     */
    public function summary()
    {
        $etablissementId = Auth::user()->etablissement_id;
        
        $stats = [
            'total' => Task::where('etablissement_id', $etablissementId)->count(),
            'pending' => Task::where('etablissement_id', $etablissementId)->where('status', 'pending')->count(),
            'in_progress' => Task::where('etablissement_id', $etablissementId)->where('status', 'in_progress')->count(),
            'test' => Task::where('etablissement_id', $etablissementId)->where('status', 'test')->count(),
            'integrated' => Task::where('etablissement_id', $etablissementId)->where('status', 'integrated')->count(),
            'delivered' => Task::where('etablissement_id', $etablissementId)->where('status', 'delivered')->count(),
            'approved' => Task::where('etablissement_id', $etablissementId)->where('status', 'approved')->count(),
            'cancelled' => Task::where('etablissement_id', $etablissementId)->where('status', 'cancelled')->count(),
            'overdue' => Task::where('etablissement_id', $etablissementId)
                ->whereNotNull('due_date')
                ->where('due_date', '<', now())
                ->whereNotIn('status', ['approved', 'cancelled'])
                ->count(),
            'upcoming' => Task::where('etablissement_id', $etablissementId)
                ->whereNotNull('due_date')
                ->where('due_date', '>=', now())
                ->where('due_date', '<=', now()->addDays(7))
                ->whereNotIn('status', ['approved', 'cancelled'])
                ->count(),
        ];
        
        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}