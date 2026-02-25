@extends('layouts.app')

@section('content')
    <!-- MAIN CONTENT -->
    <main class="dashboard-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex align-items-center">
                <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="page-title mb-0">
                    <span class="page-title-icon"><i class="fas fa-project-diagram"></i></span>
                    {{ $project->name }}
                </h1>
                @if($project->is_active)
                    <span class="badge bg-success ms-3"><i class="fas fa-check-circle me-1"></i>Actif</span>
                @else
                    <span class="badge bg-secondary ms-3"><i class="fas fa-times-circle me-1"></i>Inactif</span>
                @endif
            </div>
            
            <div class="page-actions">
                <div class="btn-group me-2">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-h me-2"></i>Actions
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('projects.edit', $project) }}">
                                <i class="fas fa-edit me-2"></i>Modifier
                            </a>
                        </li>
                        <li>
                            <button class="dropdown-item" onclick="duplicateProject({{ $project->id }})">
                                <i class="fas fa-copy me-2"></i>Dupliquer
                            </button>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <button class="dropdown-item" onclick="openCreateTaskModal()">
                                <i class="fas fa-plus-circle me-2"></i>Nouvelle tâche
                            </button>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="exportProject({{ $project->id }})">
                                <i class="fas fa-download me-2"></i>Exporter
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <button class="dropdown-item text-danger" onclick="confirmDelete({{ $project->id }})">
                                <i class="fas fa-trash me-2"></i>Supprimer
                            </button>
                        </li>
                    </ul>
                </div>
                
                <button class="btn btn-primary" onclick="updateStatus({{ $project->id }})">
                    <i class="fas fa-sync-alt me-2"></i>Mettre à jour le statut
                </button>
            </div>
        </div>

        <!-- Project Stats Cards -->
        <div class="stats-grid mb-4">
            <div class="stats-card-modern">
                <div class="stats-header-modern">
                    <div>
                        <div class="stats-value-modern">{{ $stats['total_tasks'] ?? 0 }}</div>
                        <div class="stats-label-modern">Tâches totales</div>
                    </div>
                    <div class="stats-icon-modern" style="background: linear-gradient(135deg, #45b7d1, #3a56e4);">
                        <i class="fas fa-tasks"></i>
                    </div>
                </div>
                <div class="stats-footer">
                    <small class="text-muted">
                        {{ $stats['completed_tasks'] ?? 0 }} terminées
                    </small>
                </div>
            </div>
            
            <div class="stats-card-modern">
                <div class="stats-header-modern">
                    <div>
                        <div class="stats-value-modern">{{ $stats['total_hours'] ?? 0 }}h</div>
                        <div class="stats-label-modern">Heures estimées</div>
                    </div>
                    <div class="stats-icon-modern" style="background: linear-gradient(135deg, #06b48a, #049a72);">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <div class="stats-footer">
                    <small class="text-muted">Taux: {{ number_format($project->hourly_rate ?? 0, 2) }} €/h</small>
                </div>
            </div>
            
            <div class="stats-card-modern">
                <div class="stats-header-modern">
                    <div>
                        <div class="stats-value-modern">{{ number_format($project->estimated_budget ?? 0, 0, ',', ' ') }} €</div>
                        <div class="stats-label-modern">Budget estimé</div>
                    </div>
                    <div class="stats-icon-modern" style="background: linear-gradient(135deg, #ffd166, #ffb347);">
                        <i class="fas fa-euro-sign"></i>
                    </div>
                </div>
                <div class="stats-footer">
                    <small class="text-muted">Coût réel: {{ number_format($stats['total_cost'] ?? 0, 0, ',', ' ') }} €</small>
                </div>
            </div>
            
            <div class="stats-card-modern">
                <div class="stats-header-modern">
                    <div>
                        <div class="stats-value-modern">{{ $project->progress }}%</div>
                        <div class="stats-label-modern">Avancement</div>
                    </div>
                    <div class="stats-icon-modern" style="background: linear-gradient(135deg, #ef476f, #d4335f);">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
                <div class="stats-footer">
                    <div class="progress-modern" style="height: 4px;">
                        <div class="progress-bar-modern" style="width: {{ $project->progress }}%; background: {{ $project->progress > 70 ? '#06b48a' : ($project->progress > 30 ? '#ffd166' : '#ef476f') }}"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="row">
            <!-- Left Column - Project Info -->
            <div class="col-lg-4">
                <!-- Project Info Card -->
                <div class="info-card-modern mb-4">
                    <div class="info-card-header">
                        <h5 class="info-card-title">
                            <i class="fas fa-info-circle me-2"></i>
                            Informations générales
                        </h5>
                    </div>
                    <div class="info-card-body">
                        <div class="info-item">
                            <div class="info-label">Statut</div>
                            <div class="info-value">
                                <span class="status-badge" style="background: {{ $project->status_color === 'success' ? '#06b48a' : ($project->status_color === 'danger' ? '#ef476f' : '#ffd166') }}">
                                    <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                                    {{ $project->formatted_status }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Responsable</div>
                            <div class="info-value">
                                @if($project->user)
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar-sm me-2" style="background: {{ \App\Helpers\ViewHelper::getAvatarColor($project->user->name) }}">
                                            {{ \App\Helpers\ViewHelper::getInitials($project->user->name) }}
                                        </div>
                                        <div>
                                            <div>{{ $project->user->name }}</div>
                                            <small class="text-muted">{{ $project->user->email }}</small>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">Non assigné</span>
                                @endif
                            </div>
                        </div>
                        
                        @if($project->client)
                        <div class="info-item">
                            <div class="info-label">Client</div>
                            <div class="info-value">
                                <div class="d-flex align-items-center">
                                    <div class="client-icon-sm me-2">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <div>
                                        <div>{{ $project->client->name }}</div>
                                        <small class="text-muted">{{ $project->client->ville }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($project->contract_number)
                        <div class="info-item">
                            <div class="info-label">N° Contrat</div>
                            <div class="info-value">
                                <span class="contract-badge">{{ $project->contract_number }}</span>
                            </div>
                        </div>
                        @endif
                        
                        <div class="info-item">
                            <div class="info-label">Dates</div>
                            <div class="info-value">
                                <div><i class="fas fa-calendar-alt me-2 text-muted"></i>Début: {{ $project->start_date ? $project->start_date->format('d/m/Y') : 'Non définie' }}</div>
                                <div><i class="fas fa-calendar-check me-2 text-muted"></i>Fin: {{ $project->end_date ? $project->end_date->format('d/m/Y') : 'Non définie' }}</div>
                                @if($project->end_date && !in_array($project->status, ['completed', 'cancelled']))
                                    <div class="mt-2">
                                        @php
                                            $daysRemaining = now()->diffInDays($project->end_date, false);
                                        @endphp
                                        @if($daysRemaining < 0)
                                            <span class="badge bg-danger">En retard de {{ abs($daysRemaining) }} jours</span>
                                        @elseif($daysRemaining <= 7)
                                            <span class="badge bg-warning">{{ $daysRemaining }} jours restants</span>
                                        @else
                                            <span class="badge bg-info">{{ $daysRemaining }} jours restants</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        @if($project->tags)
                        <div class="info-item">
                            <div class="info-label">Tags</div>
                            <div class="info-value">
                                <div class="tags-container">
                                    @foreach(explode(',', $project->tags) as $tag)
                                        <span class="tag">{{ trim($tag) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Contact Info Card -->
                @if($project->contact_name || $project->client)
                <div class="info-card-modern mb-4">
                    <div class="info-card-header">
                        <h5 class="info-card-title">
                            <i class="fas fa-address-card me-2"></i>
                            Contact
                        </h5>
                    </div>
                    <div class="info-card-body">
                        @if($project->contact_name)
                        <div class="info-item">
                            <div class="info-label">Nom</div>
                            <div class="info-value">{{ $project->contact_name }}</div>
                        </div>
                        @endif
                        
                        @if($project->contact_phone)
                        <div class="info-item">
                            <div class="info-label">Téléphone</div>
                            <div class="info-value">
                                <a href="tel:{{ $project->contact_phone }}" class="contact-link">
                                    <i class="fas fa-phone me-2"></i>{{ $project->contact_phone }}
                                </a>
                            </div>
                        </div>
                        @endif
                        
                        @if($project->contact_email)
                        <div class="info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value">
                                <a href="mailto:{{ $project->contact_email }}" class="contact-link">
                                    <i class="fas fa-envelope me-2"></i>{{ $project->contact_email }}
                                </a>
                            </div>
                        </div>
                        @endif
                        
                        @if($project->client)
                        <div class="info-item mt-3 pt-3 border-top">
                            <div class="info-value">
                                <a href="{{ route('etablissements.show', $project->client_id) }}" class="btn btn-outline-primary btn-sm w-100">
                                    <i class="fas fa-building me-2"></i>Voir la fiche client
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Metadata Card -->
                <div class="info-card-modern">
                    <div class="info-card-header">
                        <h5 class="info-card-title">
                            <i class="fas fa-cog me-2"></i>
                            Métadonnées
                        </h5>
                    </div>
                    <div class="info-card-body">
                        <div class="info-item">
                            <div class="info-label">Créé par</div>
                            <div class="info-value">{{ $project->user->name ?? 'N/A' }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Créé le</div>
                            <div class="info-value">{{ $project->created_at->format('d/m/Y à H:i') }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Dernière modif.</div>
                            <div class="info-value">{{ $project->updated_at->format('d/m/Y à H:i') }}</div>
                        </div>
                        
                        @if($project->metadata)
                            @php $metadata = json_decode($project->metadata, true); @endphp
                            @if(!empty($metadata['priority']))
                            <div class="info-item">
                                <div class="info-label">Priorité</div>
                                <div class="info-value">
                                    @if($metadata['priority'] === 'urgent')
                                        <span class="badge bg-danger">Urgente</span>
                                    @elseif($metadata['priority'] === 'high')
                                        <span class="badge bg-warning">Haute</span>
                                    @elseif($metadata['priority'] === 'medium')
                                        <span class="badge bg-info">Moyenne</span>
                                    @else
                                        <span class="badge bg-secondary">Basse</span>
                                    @endif
                                </div>
                            </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column - Description & Tasks -->
            <div class="col-lg-8">
                <!-- Description Card -->
                <div class="info-card-modern mb-4">
                    <div class="info-card-header">
                        <h5 class="info-card-title">
                            <i class="fas fa-align-left me-2"></i>
                            Description
                        </h5>
                    </div>
                    <div class="info-card-body">
                        <div class="project-description">
                            @if($project->description)
                                {!! $project->description !!}
                            @else
                                <p class="text-muted fst-italic">Aucune description fournie</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tasks Card -->
                <div class="info-card-modern">
                    <div class="info-card-header d-flex justify-content-between align-items-center">
                        <h5 class="info-card-title mb-0">
                            <i class="fas fa-tasks me-2"></i>
                            Tâches ({{ $stats['total_tasks'] }})
                        </h5>
                        <div class="d-flex gap-2">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-secondary" onclick="filterTasks('all')">Toutes</button>
                                <button type="button" class="btn btn-outline-secondary" onclick="filterTasks('pending')">En cours</button>
                                <button type="button" class="btn btn-outline-secondary" onclick="filterTasks('completed')">Terminées</button>
                            </div>
                            <button onclick="openCreateTaskModal()" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="info-card-body p-0">
                        @if($recentTasks->count() > 0)
                            <div class="task-list">
                                @foreach($recentTasks as $task)
                                    <div class="task-item" data-status="{{ $task->status }}" id="task-{{ $task->id }}">
                                        <div class="task-item-content">
                                            <div class="task-checkbox">
                                                <input type="checkbox" 
                                                       class="task-check" 
                                                       {{ $task->status === 'approved' ? 'checked' : '' }}
                                                       onchange="toggleTaskStatus({{ $task->id }}, this.checked)">
                                            </div>
                                            <div class="task-info">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="task-name {{ $task->status === 'approved' ? 'task-completed' : '' }}">
                                                        <a href="javascript:void(0)" onclick="openEditTaskModal({{ $task->id }})">{{ $task->name }}</a>
                                                    </span>
                                                    <span class="task-badge status-{{ $task->status }}">
                                                        {{ $task->formatted_status }}
                                                    </span>
                                                </div>
                                                <div class="task-meta">
                                                    <span><i class="fas fa-user me-1"></i>{{ $task->user->name ?? 'Non assigné' }}</span>
                                                    @if($task->due_date)
                                                        <span><i class="fas fa-calendar me-1"></i>{{ $task->due_date->format('d/m/Y') }}</span>
                                                    @endif
                                                    <span><i class="fas fa-clock me-1"></i>{{ $task->estimated_hours ?? 0 }}h</span>
                                                </div>
                                            </div>
                                            <div class="task-actions">
                                                <button class="task-action-btn" onclick="openEditTaskModal({{ $task->id }})" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="task-action-btn" onclick="deleteTask({{ $task->id }})" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            @if($project->tasks->count() > 5)
                                <div class="text-center p-3 border-top">
                                    <a href="{{ route('projects.tasks', $project) }}" class="btn btn-link">
                                        Voir toutes les tâches ({{ $project->tasks->count() }})
                                        <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="empty-state-modern p-5">
                                <div class="empty-icon-modern">
                                    <i class="fas fa-tasks"></i>
                                </div>
                                <h3 class="empty-title-modern">Aucune tâche</h3>
                                <p class="empty-text-modern">Commencez par créer une tâche pour ce projet.</p>
                                <button onclick="openCreateTaskModal()" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i>Créer une tâche
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Timeline Card -->
                @if(isset($activities) && $activities->count() > 0)
                <div class="info-card-modern mt-4">
                    <div class="info-card-header">
                        <h5 class="info-card-title">
                            <i class="fas fa-history me-2"></i>
                            Activités récentes
                        </h5>
                    </div>
                    <div class="info-card-body">
                        <div class="timeline">
                            @foreach($activities as $activity)
                                <div class="timeline-item">
                                    <div class="timeline-icon" style="background: {{ \App\Helpers\ViewHelper::getActivityColor($activity->description) }}">
                                        <i class="fas {{ \App\Helpers\ViewHelper::getActivityIcon($activity->description) }}"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-header">
                                            <span class="timeline-title">{!! $activity->description !!}</span>
                                            <span class="timeline-time">{{ $activity->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="timeline-body">
                                            {{ $activity->causer->name ?? 'Système' }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </main>

    <!-- CREATE TASK MODAL -->
    <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTaskModalLabel">
                        <i class="fas fa-plus-circle me-2" style="color: #45b7d1;"></i>
                        Nouvelle tâche
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createTaskForm" method="POST">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="task_name" class="form-label required-field">Nom de la tâche</label>
                                <input type="text" class="form-control" id="task_name" name="name" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="task_status" class="form-label">Statut</label>
                                <select class="form-select" id="task_status" name="status">
                                    <option value="pending">En attente</option>
                                    <option value="in_progress">En cours</option>
                                    <option value="test">En test</option>
                                    <option value="integrated">Intégré</option>
                                    <option value="delivered">Livré</option>
                                    <option value="approved">Approuvé</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="task_description" class="form-label">Description</label>
                            <textarea class="form-control" id="task_description" name="details" rows="3"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="task_user_id" class="form-label required-field">Assigné à</label>
                                <select class="form-select" id="task_user_id" name="user_id" required>
                                    <option value="">Sélectionner...</option>
                                    @foreach($users ?? [] as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="task_contact_name" class="form-label">Contact client</label>
                                <input type="text" class="form-control" id="task_contact_name" name="contact_name" value="{{ $project->contact_name }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="task_due_date" class="form-label">Date d'échéance</label>
                                <input type="datetime-local" class="form-control" id="task_due_date" name="due_date">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="task_delivery_date" class="form-label">Date de livraison</label>
                                <input type="datetime-local" class="form-control" id="task_delivery_date" name="delivery_date">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="task_estimated_hours" class="form-label">Heures estimées</label>
                                <input type="number" class="form-control" id="task_estimated_hours" name="estimated_hours" min="0" step="0.5">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="task_country" class="form-label">Pays</label>
                                <input type="text" class="form-control" id="task_country" name="country" placeholder="France">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="task_location" class="form-label">Lieu</label>
                                <input type="text" class="form-control" id="task_location" name="location" placeholder="Paris">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="task_contract_number" class="form-label">N° Contrat</label>
                                <input type="text" class="form-control" id="task_contract_number" name="contract_number" value="{{ $project->contract_number }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="task_hourly_rate" class="form-label">Taux horaire (€)</label>
                                <input type="number" class="form-control" id="task_hourly_rate" name="hourly_rate" min="0" step="0.01" value="{{ $project->hourly_rate }}">
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            La tâche sera associée au projet "{{ $project->name }}"
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" id="saveTaskBtn">
                            <i class="fas fa-save me-2"></i>Créer la tâche
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT TASK MODAL -->
    <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">
                        <i class="fas fa-edit me-2" style="color: #45b7d1;"></i>
                        Modifier la tâche
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editTaskForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_task_id" name="task_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="edit_task_name" class="form-label required-field">Nom de la tâche</label>
                                <input type="text" class="form-control" id="edit_task_name" name="name" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_task_status" class="form-label">Statut</label>
                                <select class="form-select" id="edit_task_status" name="status">
                                    <option value="pending">En attente</option>
                                    <option value="in_progress">En cours</option>
                                    <option value="test">En test</option>
                                    <option value="integrated">Intégré</option>
                                    <option value="delivered">Livré</option>
                                    <option value="approved">Approuvé</option>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" name="project_id" value="{{$project->id}}">

                        <div class="mb-3">
                            <label for="edit_task_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_task_description" name="details" rows="3"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_task_user_id" class="form-label required-field">Assigné à</label>
                                <select class="form-select" id="edit_task_user_id" name="user_id" required>
                                    <option value="">Sélectionner...</option>
                                    @foreach($users ?? [] as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_task_contact_name" class="form-label">Contact client</label>
                                <input type="text" class="form-control" id="edit_task_contact_name" name="contact_name">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="edit_task_due_date" class="form-label">Date d'échéance</label>
                                <input type="datetime-local" class="form-control" id="edit_task_due_date" name="due_date">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_task_delivery_date" class="form-label">Date de livraison</label>
                                <input type="datetime-local" class="form-control" id="edit_task_delivery_date" name="delivery_date">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_task_estimated_hours" class="form-label">Heures estimées</label>
                                <input type="number" class="form-control" id="edit_task_estimated_hours" name="estimated_hours" min="0" step="0.5">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_task_country" class="form-label">Pays</label>
                                <input type="text" class="form-control" id="edit_task_country" name="country" placeholder="France">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_task_location" class="form-label">Lieu</label>
                                <input type="text" class="form-control" id="edit_task_location" name="location" placeholder="Paris">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_task_contract_number" class="form-label">N° Contrat</label>
                                <input type="text" class="form-control" id="edit_task_contract_number" name="contract_number">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_task_hourly_rate" class="form-label">Taux horaire (€)</label>
                                <input type="number" class="form-control" id="edit_task_hourly_rate" name="hourly_rate" min="0" step="0.01">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" id="updateTaskBtn">
                            <i class="fas fa-save me-2"></i>Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="delete-icon mb-3">
                        <i class="fas fa-exclamation-triangle fa-3x" style="color: #ef476f;"></i>
                    </div>
                    <p class="mb-0">Êtes-vous sûr de vouloir supprimer ce projet ?</p>
                    <p class="text-muted small">Cette action est irréversible et supprimera toutes les tâches associées.</p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Supprimer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Status Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Mettre à jour le statut</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="statusForm">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="new_status" class="form-label">Nouveau statut</label>
                            <select class="form-select" id="new_status" name="status">
                                <option value="planning" {{ $project->status === 'planning' ? 'selected' : '' }}>Planification</option>
                                <option value="in_progress" {{ $project->status === 'in_progress' ? 'selected' : '' }}>En cours</option>
                                <option value="on_hold" {{ $project->status === 'on_hold' ? 'selected' : '' }}>En pause</option>
                                <option value="completed" {{ $project->status === 'completed' ? 'selected' : '' }}>Terminé</option>
                                <option value="cancelled" {{ $project->status === 'cancelled' ? 'selected' : '' }}>Annulé</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" onclick="submitStatusUpdate()">Mettre à jour</button>
                </div>
            </div>
        </div>
    </div>
<!-- Bibliothèques CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Info Cards */
    .info-card-modern {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border: 1px solid #eaeaea;
        overflow: hidden;
    }

    .info-card-header {
        padding: 15px 20px;
        background: #f8f9fa;
        border-bottom: 1px solid #eaeaea;
    }

    .info-card-title {
        font-size: 1rem;
        font-weight: 600;
        color: #333;
        margin: 0;
    }

    .info-card-body {
        padding: 20px;
    }

    .info-item {
        display: flex;
        margin-bottom: 15px;
    }

    .info-item:last-child {
        margin-bottom: 0;
    }

    .info-label {
        width: 120px;
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 500;
    }

    .info-value {
        flex: 1;
        font-size: 0.95rem;
        color: #333;
    }

    /* Status Badge */
    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        color: white;
        font-weight: 500;
        font-size: 0.85rem;
    }

    /* Contract Badge */
    .contract-badge {
        background: #f8f9fa;
        padding: 4px 10px;
        border-radius: 4px;
        font-family: monospace;
        font-size: 0.9rem;
        border: 1px solid #e0e0e0;
    }

    /* Tags */
    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .tag {
        background: linear-gradient(135deg, #45b7d1, #3a56e4);
        color: white;
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 0.8rem;
    }

    /* User Avatar */
    .user-avatar-sm {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .client-icon-sm {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: linear-gradient(135deg, #45b7d1, #3a56e4);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    /* Contact Links */
    .contact-link {
        color: #333;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .contact-link:hover {
        color: #45b7d1;
    }

    /* Project Description */
    .project-description {
        line-height: 1.6;
        color: #333;
    }

    .project-description h1,
    .project-description h2,
    .project-description h3 {
        margin-top: 1rem;
        margin-bottom: 0.5rem;
    }

    .project-description ul,
    .project-description ol {
        padding-left: 1.5rem;
        margin-bottom: 1rem;
    }

    /* Task List */
    .task-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .task-item {
        padding: 15px 20px;
        border-bottom: 1px solid #eaeaea;
        transition: background 0.3s ease;
    }

    .task-item:hover {
        background: #f8f9fa;
    }

    .task-item-content {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .task-checkbox {
        width: 20px;
    }

    .task-check {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .task-info {
        flex: 1;
    }

    .task-name {
        font-weight: 500;
        color: #333;
        text-decoration: none;
        cursor: pointer;
    }

    .task-name a {
        color: inherit;
        text-decoration: none;
    }

    .task-name a:hover {
        color: #45b7d1;
    }

    .task-name:hover {
        color: #45b7d1;
    }

    .task-name.task-completed {
        text-decoration: line-through;
        color: #6c757d;
    }

    .task-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
        color: white;
    }

    .task-badge.status-pending {
        background: #ffd166;
    }

    .task-badge.status-in_progress {
        background: #45b7d1;
    }

    .task-badge.status-test {
        background: #9b59b6;
    }

    .task-badge.status-integrated {
        background: #3498db;
    }

    .task-badge.status-delivered {
        background: #f39c12;
    }

    .task-badge.status-approved {
        background: #06b48a;
    }

    .task-badge.status-cancelled {
        background: #ef476f;
    }

    .task-meta {
        display: flex;
        gap: 15px;
        margin-top: 5px;
        font-size: 0.8rem;
        color: #6c757d;
    }

    .task-actions {
        display: flex;
        gap: 8px;
    }

    .task-action-btn {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: transparent;
        color: #6c757d;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .task-action-btn:hover {
        background: #e9ecef;
        color: #333;
    }

    /* Timeline */
    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-icon {
        position: absolute;
        left: -30px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.85rem;
        z-index: 1;
    }

    .timeline-content {
        padding-left: 15px;
    }

    .timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
    }

    .timeline-title {
        font-weight: 500;
        color: #333;
    }

    .timeline-time {
        font-size: 0.8rem;
        color: #6c757d;
    }

    .timeline-body {
        font-size: 0.9rem;
        color: #6c757d;
    }

    /* Stats Footer */
    .stats-footer {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #eaeaea;
    }

    /* Progress Bar */
    .progress-modern {
        height: 4px;
        background: #e9ecef;
        border-radius: 2px;
        overflow: hidden;
    }

    .progress-bar-modern {
        height: 100%;
        border-radius: 2px;
        transition: width 0.3s ease;
    }

    /* Required field indicator */
    .required-field:after {
        content: " *";
        color: #ef476f;
        font-weight: bold;
    }

    /* Modal styles */
    .modal-content {
        border-radius: 12px;
        border: none;
    }

    .modal-header {
        background: #f8f9fa;
        border-bottom: 1px solid #eaeaea;
        padding: 15px 20px;
    }

    .modal-title {
        font-weight: 600;
        color: #333;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        border-top: 1px solid #eaeaea;
        padding: 15px 20px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .info-item {
            flex-direction: column;
        }
        
        .info-label {
            width: 100%;
            margin-bottom: 5px;
        }
        
        .task-item-content {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .task-actions {
            width: 100%;
            justify-content: flex-end;
        }
        
        .task-meta {
            flex-wrap: wrap;
        }
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let projectId = {{ $project->id }};
    let deleteModal;
    let statusModal;
    let createTaskModal;
    let editTaskModal;

    $(document).ready(function() {
        // Initialize modals
        deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
        createTaskModal = new bootstrap.Modal(document.getElementById('createTaskModal'));
        editTaskModal = new bootstrap.Modal(document.getElementById('editTaskModal'));

        // Initialize Select2 in modals
        $('.modal').on('shown.bs.modal', function() {
            $(this).find('.select2-modern').select2({
                dropdownParent: $(this),
                width: '100%'
            });
        });

        // Create Task Form Submit
        $('#createTaskForm').on('submit', function(e) {
            e.preventDefault();
            createTask();
        });

        // Edit Task Form Submit
        $('#editTaskForm').on('submit', function(e) {
            e.preventDefault();
            updateTask();
        });
    });

    // Helper functions for avatar
    function getInitials(name) {
        if (!name) return '?';
        return name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
    }

    function getAvatarColor(name) {
        const colors = ['#45b7d1', '#96ceb4', '#feca57', '#ff6b6b', '#9b59b6'];
        const index = (name?.length || 0) % colors.length;
        return colors[index];
    }

    // Activity helpers
    function getActivityColor(description) {
        const colors = {
            'created': '#06b48a',
            'updated': '#45b7d1',
            'deleted': '#ef476f',
            'status': '#ffd166'
        };
        
        if (description.includes('créé')) return colors.created;
        if (description.includes('supprim')) return colors.deleted;
        if (description.includes('statut')) return colors.status;
        return colors.updated;
    }

    function getActivityIcon(description) {
        const icons = {
            'created': 'fa-plus-circle',
            'updated': 'fa-edit',
            'deleted': 'fa-trash',
            'status': 'fa-exchange-alt'
        };
        
        if (description.includes('créé')) return icons.created;
        if (description.includes('supprim')) return icons.deleted;
        if (description.includes('statut')) return icons.status;
        return icons.updated;
    }

    // Open Create Task Modal
    function openCreateTaskModal() {
        $('#createTaskForm')[0].reset();
        $('#createTaskModal').modal('show');
    }

    // Create Task
    function createTask() {
        const formData = $('#createTaskForm').serialize();
        
        $.ajax({
            url: '{{ route("tasks.store") }}',
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    createTaskModal.hide();
                    showNotification('success', 'Tâche créée avec succès');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification('error', response.message || 'Erreur lors de la création');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = 'Erreurs de validation:\n';
                    for (let field in errors) {
                        errorMessage += `- ${errors[field].join('\n')}\n`;
                    }
                    showNotification('error', errorMessage);
                } else {
                    showNotification('error', 'Erreur de connexion au serveur');
                }
            }
        });
    }

    // Open Edit Task Modal
    function openEditTaskModal(taskId) {
        $.ajax({
            url: `/tasks/${taskId}/edit`,
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    const task = response.data;
                    
                    $('#edit_task_id').val(task.id);
                    $('#edit_task_name').val(task.name);
                    $('#edit_task_status').val(task.status);
                    $('#edit_task_description').val(task.details);
                    $('#edit_task_user_id').val(task.user_id);
                    $('#edit_task_contact_name').val(task.contact_name);
                    
                    if (task.due_date) {
                        $('#edit_task_due_date').val(task.due_date.replace(' ', 'T').substring(0, 16));
                    }
                    if (task.delivery_date) {
                        $('#edit_task_delivery_date').val(task.delivery_date.replace(' ', 'T').substring(0, 16));
                    }
                    
                    $('#edit_task_estimated_hours').val(task.estimated_hours);
                    $('#edit_task_country').val(task.country);
                    $('#edit_task_location').val(task.location);
                    $('#edit_task_contract_number').val(task.contract_number);
                    $('#edit_task_hourly_rate').val(task.hourly_rate);
                    
                    editTaskModal.show();
                }
            },
            error: function(xhr) {
                showNotification('error', 'Erreur lors du chargement de la tâche');
            }
        });
    }

    // Update Task
    function updateTask() {
        const taskId = $('#edit_task_id').val();
        const formData = $('#editTaskForm').serialize();
        
        $.ajax({
            url: `/tasks/${taskId}`,
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    editTaskModal.hide();
                    showNotification('success', 'Tâche mise à jour avec succès');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification('error', response.message || 'Erreur lors de la mise à jour');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = 'Erreurs de validation:\n';
                    for (let field in errors) {
                        errorMessage += `- ${errors[field].join('\n')}\n`;
                    }
                    showNotification('error', errorMessage);
                } else {
                    showNotification('error', 'Erreur de connexion au serveur');
                }
            }
        });
    }

    // Task filtering
    function filterTasks(filter) {
        $('.task-item').each(function() {
            const status = $(this).data('status');
            
            if (filter === 'all') {
                $(this).show();
            } else if (filter === 'pending') {
                $(this).show(status !== 'approved' && status !== 'cancelled');
            } else if (filter === 'completed') {
                $(this).show(status === 'approved');
            }
        });
    }

    // Toggle task status
    function toggleTaskStatus(taskId, completed) {
        $.ajax({
            url: `/tasks/${taskId}/toggle-status`,
            type: 'PATCH',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                completed: completed
            },
            success: function(response) {
                if (response.success) {
                    const taskItem = $(`#task-${taskId}`);
                    const taskName = taskItem.find('.task-name');
                    
                    if (completed) {
                        taskName.addClass('task-completed');
                        taskItem.find('.task-badge').text('Terminée').attr('class', 'task-badge status-approved');
                    } else {
                        taskName.removeClass('task-completed');
                        taskItem.find('.task-badge').text('En cours').attr('class', 'task-badge status-in_progress');
                    }
                    
                    showNotification('success', 'Statut de la tâche mis à jour');
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                showNotification('error', 'Erreur lors de la mise à jour');
            }
        });
    }

    // Delete task
    function deleteTask(taskId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')) {
            $.ajax({
                url: `/tasks/${taskId}`,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $(`#task-${taskId}`).fadeOut(300, function() {
                            $(this).remove();
                            showNotification('success', 'Tâche supprimée avec succès');
                        });
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    showNotification('error', 'Erreur lors de la suppression');
                }
            });
        }
    }

    // Duplicate project
    function duplicateProject(id) {
        $.ajax({
            url: `/projects/${id}/duplicate`,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    showNotification('success', 'Projet dupliqué avec succès');
                    setTimeout(() => {
                        window.location.href = response.redirect;
                    }, 1500);
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                showNotification('error', 'Erreur lors de la duplication');
            }
        });
    }

    // Export project
    function exportProject(id) {
        window.location.href = `/projects/${id}/export`;
    }

    // Delete confirmation
    function confirmDelete(id) {
        deleteModal.show();
        $('#confirmDeleteBtn').off('click').on('click', function() {
            deleteProject(id);
        });
    }

    function deleteProject(id) {
        $.ajax({
            url: `/projects/${id}`,
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    deleteModal.hide();
                    showNotification('success', 'Projet supprimé avec succès');
                    setTimeout(() => {
                        window.location.href = '{{ route("projects.index") }}';
                    }, 1500);
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                deleteModal.hide();
                showNotification('error', 'Erreur lors de la suppression');
            }
        });
    }

    // Update status
    function updateStatus(id) {
        statusModal.show();
    }

    function submitStatusUpdate() {
        const newStatus = $('#new_status').val();
        
        $.ajax({
            url: `/projects/${projectId}/status`,
            type: 'PATCH',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                status: newStatus
            },
            success: function(response) {
                if (response.success) {
                    statusModal.hide();
                    showNotification('success', 'Statut mis à jour avec succès');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                statusModal.hide();
                showNotification('error', 'Erreur lors de la mise à jour');
            }
        });
    }

    // Notification system
    function showNotification(type, message) {
        $('.notification-toast').remove();
        
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };
        
        const colors = {
            success: '#06b48a',
            error: '#ef476f',
            warning: '#ffd166',
            info: '#45b7d1'
        };
        
        const notification = `
            <div class="notification-toast" style="
                position: fixed;
                top: 20px;
                right: 20px;
                background: white;
                border-radius: 8px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.15);
                padding: 15px 20px;
                display: flex;
                align-items: center;
                gap: 12px;
                z-index: 10000;
                animation: slideInRight 0.3s ease;
                border-left: 4px solid ${colors[type]};
                max-width: 400px;
            ">
                <i class="fas ${icons[type]}" style="color: ${colors[type]}; font-size: 1.5rem;"></i>
                <div style="flex: 1;">
                    <div style="font-weight: 600; margin-bottom: 4px; color: #333;">
                        ${type === 'success' ? 'Succès' : type === 'error' ? 'Erreur' : type === 'warning' ? 'Attention' : 'Information'}
                    </div>
                    <div style="color: #666; font-size: 0.9rem;">${message}</div>
                </div>
                <i class="fas fa-times" style="color: #999; cursor: pointer;" onclick="this.closest('.notification-toast').remove()"></i>
            </div>
        `;
        
        $('body').append(notification);
        
        setTimeout(function() {
            $('.notification-toast').fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);
    }
</script>
@endsection