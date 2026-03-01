@extends('layouts.app')

@section('content')
    <!-- MAIN CONTENT -->
    <main class="dashboard-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <span class="page-title-icon"><i class="fas fa-shield-alt"></i></span>
                Gestion des Rôles & Permissions
            </h1>
            
            <div class="page-actions">
                <button class="btn btn-outline-secondary" id="toggleFilterBtn">
                    <i class="fas fa-sliders-h me-2"></i>Filtres
                </button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                    <i class="fas fa-plus-circle me-2"></i>Nouveau Rôle
                </button>
            </div>
        </div>
        
        <!-- Filter Section (Initially Hidden) -->
        <div class="filter-section-modern" id="filterSection" style="display: none;">
            <div class="filter-header-modern">
                <h3 class="filter-title-modern">Filtres</h3>
                <div class="filter-actions-modern">
                    <button class="btn btn-sm btn-outline-secondary" id="clearFiltersBtn">
                        <i class="fas fa-times me-1"></i>Effacer
                    </button>
                    <button class="btn btn-sm btn-primary" id="applyFiltersBtn">
                        <i class="fas fa-check me-1"></i>Appliquer
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="filterGuard" class="form-label-modern">Guard</label>
                    <select class="form-select-modern" id="filterGuard">
                        <option value="">Tous les guards</option>
                        <option value="web">Web</option>
                        <option value="api">API</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="filterSortBy" class="form-label-modern">Trier par</label>
                    <select class="form-select-modern" id="filterSortBy">
                        <option value="name">Nom</option>
                        <option value="guard_name">Guard</option>
                        <option value="created_at">Date de création</option>
                        <option value="permissions_count">Nombre de permissions</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="filterSortDirection" class="form-label-modern">Ordre</label>
                    <select class="form-select-modern" id="filterSortDirection">
                        <option value="asc">Croissant</option>
                        <option value="desc">Décroissant</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Main Card - Modern Design -->
        <div class="main-card-modern">
            <div class="card-header-modern">
                <h3 class="card-title-modern">Liste des Rôles</h3>
                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Rechercher un rôle..." id="searchInput">
                </div>
            </div>
            
            <div class="card-body-modern">
                <!-- Loading Spinner -->
                <div class="spinner-container" id="loadingSpinner">
                    <div class="spinner-border text-primary spinner" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                </div>
                
                <!-- Table Container -->
                <div class="table-container-modern" id="tableContainer" style="display: none;">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th style="width: 80px;">ID</th>
                                <th>Rôle</th>
                                <th>Guard</th>
                                <th>Permissions</th>
                                <th>Date création</th>
                                <th style="text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="rolesTableBody">
                            <!-- Roles will be loaded here via AJAX -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Empty State -->
                <div class="empty-state-modern" id="emptyState" style="display: none;">
                    <div class="empty-icon-modern">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="empty-title-modern">Aucun rôle trouvé</h3>
                    <p class="empty-text-modern">Commencez par créer votre premier rôle.</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                        <i class="fas fa-plus-circle me-2"></i>Créer un rôle
                    </button>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="pagination-container-modern" id="paginationContainer" style="display: none;">
                <div class="pagination-info-modern" id="paginationInfo">
                    <!-- Pagination info will be loaded here -->
                </div>
                
                <nav aria-label="Page navigation">
                    <ul class="modern-pagination" id="pagination">
                        <!-- Pagination will be loaded here -->
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Permissions Section -->
        <div class="main-card-modern mt-4">
            <div class="card-header-modern">
                <h3 class="card-title-modern">
                    <i class="fas fa-key me-2"></i>
                    Gestion des Permissions
                </h3>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPermissionModal">
                    <i class="fas fa-plus-circle me-2"></i>Nouvelle Permission
                </button>
            </div>
            
            <div class="card-body-modern">
                <div class="table-container-modern">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th style="width: 80px;">ID</th>
                                <th>Permission</th>
                                <th>Guard</th>
                                <th>Group</th>
                                <th>Date création</th>
                                <th style="text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="permissionsTableBody">
                            <!-- Permissions will be loaded here via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Floating Action Button -->
        <button class="fab-modern" data-bs-toggle="modal" data-bs-target="#createRoleModal">
            <i class="fas fa-plus-circle"></i>
        </button>
    </main>
    
    <!-- Modals -->
    <!-- Create Role Modal -->
    <div class="modal fade" id="createRoleModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content-modern">
                <div class="modal-header-modern">
                    <h5 class="modal-title-modern">
                        <i class="fas fa-plus-circle me-2"></i>
                        Créer un nouveau rôle
                    </h5>
                    <button type="button" class="btn-close-modern" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="createRoleForm">
                    <div class="modal-body-modern">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="form-label-modern" for="roleName">
                                        <i class="fas fa-tag me-1"></i>Nom du rôle *
                                    </label>
                                    <input type="text" class="form-control-modern" id="roleName" name="name" 
                                           placeholder="ex: admin, manager, editor..." required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="form-label-modern" for="roleGuard">
                                        <i class="fas fa-shield me-1"></i>Guard *
                                    </label>
                                    <select class="form-select-modern" id="roleGuard" name="guard_name" required>
                                        <option value="web">Web</option>
                                        <option value="api">API</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group-modern mt-3">
                            <label class="form-label-modern">
                                <i class="fas fa-lock me-1"></i>Permissions
                            </label>
                            <div class="permissions-container" id="permissionsContainer">
                                <!-- Permissions will be loaded here -->
                                <div class="text-center text-muted py-3">
                                    <i class="fas fa-spinner fa-spin me-2"></i>Chargement des permissions...
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer-modern">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Annuler
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitRoleBtn">
                            <i class="fas fa-save me-2"></i>Créer le rôle
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Role Modal -->
    <div class="modal fade" id="editRoleModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content-modern">
                <div class="modal-header-modern">
                    <h5 class="modal-title-modern">
                        <i class="fas fa-edit me-2"></i>
                        Modifier le rôle
                    </h5>
                    <button type="button" class="btn-close-modern" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="editRoleForm">
                    <input type="hidden" id="editRoleId" name="role_id">
                    <div class="modal-body-modern">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="form-label-modern" for="editRoleName">
                                        <i class="fas fa-tag me-1"></i>Nom du rôle *
                                    </label>
                                    <input type="text" class="form-control-modern" id="editRoleName" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="form-label-modern" for="editRoleGuard">
                                        <i class="fas fa-shield me-1"></i>Guard *
                                    </label>
                                    <select class="form-select-modern" id="editRoleGuard" name="guard_name" required>
                                        <option value="web">Web</option>
                                        <option value="api">API</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group-modern mt-3">
                            <label class="form-label-modern">
                                <i class="fas fa-lock me-1"></i>Permissions
                            </label>
                            <div class="permissions-container" id="editPermissionsContainer">
                                <!-- Permissions will be loaded here -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer-modern">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Annuler
                        </button>
                        <button type="submit" class="btn btn-primary" id="updateRoleBtn">
                            <i class="fas fa-save me-2"></i>Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Create Permission Modal -->
    <div class="modal fade" id="createPermissionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content-modern">
                <div class="modal-header-modern">
                    <h5 class="modal-title-modern">
                        <i class="fas fa-plus-circle me-2"></i>
                        Créer une permission
                    </h5>
                    <button type="button" class="btn-close-modern" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="createPermissionForm">
                    <div class="modal-body-modern">
                        <div class="form-group-modern">
                            <label class="form-label-modern" for="permissionName">
                                <i class="fas fa-tag me-1"></i>Nom de la permission *
                            </label>
                            <input type="text" class="form-control-modern" id="permissionName" name="name" 
                                   placeholder="ex: create-users, edit-roles..." required>
                            <small class="text-muted">Utilisez le format: action-ressource (ex: create-users)</small>
                        </div>
                        
                        <div class="form-group-modern mt-3">
                            <label class="form-label-modern" for="permissionGuard">
                                <i class="fas fa-shield me-1"></i>Guard *
                            </label>
                            <select class="form-select-modern" id="permissionGuard" name="guard_name" required>
                                <option value="web">Web</option>
                                <option value="api">API</option>
                            </select>
                        </div>

                        <div class="form-group-modern mt-3">
                            <label class="form-label-modern" for="permissionGroup">
                                <i class="fas fa-folder me-1"></i>Groupe
                            </label>
                            <input type="text" class="form-control-modern" id="permissionGroup" name="group" 
                                   placeholder="ex: users, roles, permissions...">
                        </div>
                    </div>
                    <div class="modal-footer-modern">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Annuler
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitPermissionBtn">
                            <i class="fas fa-save me-2"></i>Créer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content-modern">
                <div class="modal-header-modern">
                    <h5 class="modal-title-modern text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Confirmer la suppression
                    </h5>
                    <button type="button" class="btn-close-modern" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body-modern">
                    <div id="deleteItemInfo"></div>
                    <p class="mb-0 text-muted">Cette action est irréversible.</p>
                </div>
                <div class="modal-footer-modern">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Annuler
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash me-2"></i>Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   <script>
    // ==================== CONFIGURATION ====================
    let currentPage = 1;
    let currentFilters = {};
    let allRoles = [];
    let allPermissions = [];
    let itemToDelete = null;
    let deleteType = null;
    let currentEditRoleId = null;

    // ==================== INITIALISATION ====================
    document.addEventListener('DOMContentLoaded', function() {
        setupAjax();
        loadRoles();
        loadPermissions();
        setupEventListeners();
        fixModals(); // Nouvelle fonction pour corriger les modals
    });

    // ==================== FIX MODALS ====================
    const fixModals = () => {
        // Forcer la suppression des attributs aria-hidden au chargement
        document.querySelectorAll('[aria-hidden="true"]').forEach(el => {
            el.removeAttribute('aria-hidden');
        });

        // Intercepter l'ouverture de toutes les modals Bootstrap
        const modals = ['createRoleModal', 'editRoleModal', 'createPermissionModal', 'deleteConfirmationModal'];
        
        modals.forEach(modalId => {
            const modalElement = document.getElementById(modalId);
            if (!modalElement) return;

            // Remplacer le gestionnaire d'ouverture de Bootstrap
            modalElement.addEventListener('show.bs.modal', function(e) {
                e.stopPropagation();
                // Empêcher Bootstrap d'ajouter aria-hidden
                this.removeAttribute('aria-hidden');
            });

            modalElement.addEventListener('shown.bs.modal', function() {
                // Nettoyer tous les aria-hidden
                document.querySelectorAll('[aria-hidden="true"]').forEach(el => {
                    el.removeAttribute('aria-hidden');
                });
                
                // Mettre le focus sur le premier champ
                const firstInput = this.querySelector('input:not([disabled]), select:not([disabled]), textarea:not([disabled])');
                if (firstInput) {
                    setTimeout(() => firstInput.focus(), 100);
                }
            });

            modalElement.addEventListener('hidden.bs.modal', function() {
                // Nettoyer après fermeture
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                
                // Supprimer tous les backdrops
                document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
                
                // Nettoyer les aria-hidden
                document.querySelectorAll('[aria-hidden="true"]').forEach(el => {
                    el.removeAttribute('aria-hidden');
                });
            });
        });

        // Nettoyage périodique
        setInterval(() => {
            document.querySelectorAll('[aria-hidden="true"]').forEach(el => {
                // Ne pas enlever des modals ouvertes
                if (!el.classList.contains('show')) {
                    el.removeAttribute('aria-hidden');
                }
            });
        }, 500);
    };

    // ==================== AJAX SETUP ====================
    const setupAjax = () => {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
    };

    // ==================== RÔLES ====================

    // Charger les rôles
    const loadRoles = (page = 1, filters = {}) => {
        showLoading();
        
        const searchTerm = document.getElementById('searchInput')?.value || '';
        
        $.ajax({
            url: '{{ route("roles.index") }}',
            type: 'GET',
            data: {
                page: page,
                search: searchTerm,
                ...filters,
                ajax: true
            },
            success: function(response) {
                if (response.success) {
                    allRoles = response.data || [];
                    renderRoles(allRoles);
                    renderPagination(response);
                    hideLoading();
                } else {
                    showError('Erreur lors du chargement des rôles');
                }
            },
            error: function(xhr) {
                hideLoading();
                showError('Erreur de connexion au serveur');
                console.error('Error:', xhr.responseText);
            }
        });
    };

    // Afficher les rôles
    const renderRoles = (roles) => {
        const tbody = document.getElementById('rolesTableBody');
        tbody.innerHTML = '';
        
        if (!roles || !Array.isArray(roles) || roles.length === 0) {
            document.getElementById('emptyState').style.display = 'block';
            document.getElementById('tableContainer').style.display = 'none';
            document.getElementById('paginationContainer').style.display = 'none';
            return;
        }
        
        roles.forEach((role, index) => {
            const row = document.createElement('tr');
            row.id = `role-row-${role.id}`;
            row.style.animationDelay = `${index * 0.05}s`;
            
            const permissionsCount = role.permissions ? role.permissions.length : 0;
            const permissionsList = role.permissions ? 
                role.permissions.slice(0, 3).map(p => 
                    `<span class="permission-badge" title="${escapeHtml(p.name)}">${escapeHtml(p.name)}</span>`
                ).join('') : '';
            
            const morePermissions = permissionsCount > 3 ? 
                `<span class="permission-badge more" title="${role.permissions.slice(3).map(p => escapeHtml(p.name)).join(', ')}">+${permissionsCount - 3}</span>` : '';
            
            row.innerHTML = `
                <td><span class="badge-id">#${role.id}</span></td>
                <td class="role-name-cell">
                    <div class="role-name-modern">
                        <div class="role-avatar-modern">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div>
                            <div class="role-name-text">${escapeHtml(role.name)}</div>
                            <small class="text-muted">${escapeHtml(role.guard_name || 'web')}</small>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="guard-badge ${role.guard_name === 'api' ? 'guard-api' : 'guard-web'}">
                        <i class="fas fa-${role.guard_name === 'api' ? 'cloud' : 'globe'} me-1"></i>
                        ${escapeHtml(role.guard_name || 'web')}
                    </span>
                </td>
                <td>
                    <div class="permissions-badges">
                        ${permissionsList}
                        ${morePermissions}
                    </div>
                </td>
                <td>
                    <div class="date-info">
                        <i class="far fa-calendar-alt me-1"></i>
                        ${new Date(role.created_at).toLocaleDateString('fr-FR')}
                    </div>
                </td>
                <td>
                    <div class="role-actions-modern">
                        <button class="action-btn-modern edit-btn-modern" title="Modifier" 
                                onclick="openEditModal(${role.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="action-btn-modern copy-btn-modern" title="Dupliquer" 
                                onclick="duplicateRole(${role.id})">
                            <i class="fas fa-copy"></i>
                        </button>
                        <button class="action-btn-modern delete-btn-modern" title="Supprimer" 
                                onclick="showDeleteConfirmation('role', ${role.id}, '${escapeHtml(role.name)}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            
            tbody.appendChild(row);
        });
        
        document.getElementById('emptyState').style.display = 'none';
        document.getElementById('tableContainer').style.display = 'block';
        document.getElementById('paginationContainer').style.display = 'flex';
    };

    // Créer un rôle
    const createRole = (e) => {
        e.preventDefault();
        
        const form = document.getElementById('createRoleForm');
        const submitBtn = document.getElementById('submitRoleBtn');
        
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        const formData = new FormData(form);
        
        // Récupérer les permissions sélectionnées
        const selectedPermissions = Array.from(document.querySelectorAll('#permissionsContainer .permission-input:checked'))
            .map(cb => cb.value);
        
        selectedPermissions.forEach(permId => {
            formData.append('permissions[]', permId);
        });
        
        // Désactiver le bouton
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Création...';
        submitBtn.disabled = true;
        
        $.ajax({
            url: '{{ route("roles.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message || 'Rôle créé avec succès !');
                    
                    const modal = bootstrap.Modal.getInstance(document.getElementById('createRoleModal'));
                    modal.hide();
                    
                    form.reset();
                    loadRoles(1, currentFilters);
                } else {
                    showAlert('danger', response.message || 'Erreur lors de la création');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = 'Erreurs de validation:<br>';
                    for (const field in errors) {
                        errorMessage += `- ${errors[field].join('<br>')}<br>`;
                    }
                    showAlert('danger', errorMessage);
                } else {
                    showAlert('danger', xhr.responseJSON?.message || 'Erreur lors de la création');
                }
            },
            complete: function() {
                submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Créer le rôle';
                submitBtn.disabled = false;
            }
        });
    };

    // Ouvrir la modal d'édition
    const openEditModal = (roleId) => {
        currentEditRoleId = roleId;
        
        const modalElement = document.getElementById('editRoleModal');
        const modal = new bootstrap.Modal(modalElement);
        
        // Forcer la suppression de aria-hidden avant ouverture
        modalElement.removeAttribute('aria-hidden');
        document.querySelectorAll('[aria-hidden="true"]').forEach(el => {
            el.removeAttribute('aria-hidden');
        });
        
        modal.show();
        
        document.getElementById('editPermissionsContainer').innerHTML = '<div class="text-center text-muted py-3"><i class="fas fa-spinner fa-spin me-2"></i>Chargement des permissions...</div>';
        
        // Charger les détails du rôle
        $.ajax({
            url: `/roles/${roleId}`,
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    const role = response.data;
                    
                    document.getElementById('editRoleId').value = role.id;
                    document.getElementById('editRoleName').value = role.name;
                    document.getElementById('editRoleGuard').value = role.guard_name || 'web';
                    
                    const selectedPermissions = role.permissions ? role.permissions.map(p => p.id) : [];
                    renderPermissionsCheckboxes('editPermissionsContainer', selectedPermissions);
                    
                    // Focus sur le premier champ après chargement
                    setTimeout(() => {
                        document.getElementById('editRoleName').focus();
                    }, 200);
                } else {
                    showAlert('danger', 'Erreur lors du chargement du rôle');
                    modal.hide();
                }
            },
            error: function(xhr) {
                showAlert('danger', 'Erreur lors du chargement du rôle');
                modal.hide();
            }
        });
    };

    // Mettre à jour un rôle
    const updateRole = (e) => {
        e.preventDefault();
        
        const form = document.getElementById('editRoleForm');
        const submitBtn = document.getElementById('updateRoleBtn');
        const roleId = document.getElementById('editRoleId').value;
        
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        const formData = new FormData(form);
        
        const selectedPermissions = Array.from(document.querySelectorAll('#editPermissionsContainer .permission-input:checked'))
            .map(cb => cb.value);
        
        selectedPermissions.forEach(permId => {
            formData.append('permissions[]', permId);
        });
        
        formData.append('_method', 'PUT');
        
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mise à jour...';
        submitBtn.disabled = true;
        
        $.ajax({
            url: `/roles/${roleId}`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message || 'Rôle mis à jour avec succès !');
                    
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editRoleModal'));
                    modal.hide();
                    
                    loadRoles(currentPage, currentFilters);
                } else {
                    showAlert('danger', response.message || 'Erreur lors de la mise à jour');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = 'Erreurs de validation:<br>';
                    for (const field in errors) {
                        errorMessage += `- ${errors[field].join('<br>')}<br>`;
                    }
                    showAlert('danger', errorMessage);
                } else {
                    showAlert('danger', xhr.responseJSON?.message || 'Erreur lors de la mise à jour');
                }
            },
            complete: function() {
                submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Mettre à jour';
                submitBtn.disabled = false;
            }
        });
    };

    // Dupliquer un rôle
    const duplicateRole = (roleId) => {
        const role = allRoles.find(r => r.id === roleId);
        
        if (!role) {
            showError('Rôle non trouvé');
            return;
        }
        
        document.getElementById('createRoleForm').reset();
        document.getElementById('roleName').value = `${role.name}_copy`;
        document.getElementById('roleGuard').value = role.guard_name || 'web';
        
        const modalElement = document.getElementById('createRoleModal');
        const modal = new bootstrap.Modal(modalElement);
        
        modalElement.removeAttribute('aria-hidden');
        modal.show();
        
        const selectedPermissions = role.permissions ? role.permissions.map(p => p.id) : [];
        
        setTimeout(() => {
            renderPermissionsCheckboxes('permissionsContainer', selectedPermissions);
            document.getElementById('roleName').focus();
        }, 500);
    };

    // ==================== PERMISSIONS ====================

    // Charger les permissions
    const loadPermissions = () => {
        $.ajax({
            url: '{{ route("permissions.index") }}',
            type: 'GET',
            data: { ajax: true, all: true },
            success: function(response) {
                if (response.success) {
                    if (response.data && typeof response.data === 'object' && !Array.isArray(response.data)) {
                        allPermissions = [];
                        Object.values(response.data).forEach(group => {
                            allPermissions = allPermissions.concat(group);
                        });
                    } else {
                        allPermissions = response.data || [];
                    }
                    renderPermissions(allPermissions);
                    renderPermissionsCheckboxes('permissionsContainer');
                } else {
                    showError('Erreur lors du chargement des permissions');
                }
            },
            error: function(xhr) {
                console.error('Error loading permissions:', xhr);
                showError('Erreur lors du chargement des permissions');
            }
        });
    };

    // Afficher les permissions
    const renderPermissions = (permissions) => {
        const tbody = document.getElementById('permissionsTableBody');
        if (!tbody) return;
        
        tbody.innerHTML = '';
        
        if (!permissions || permissions.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-key fa-2x mb-2"></i>
                        <p>Aucune permission trouvée</p>
                    </td>
                </tr>
            `;
            return;
        }
        
        const groupedPermissions = permissions.reduce((acc, permission) => {
            const group = permission.group || 'Autres';
            if (!acc[group]) acc[group] = [];
            acc[group].push(permission);
            return acc;
        }, {});
        
        const sortedGroups = Object.keys(groupedPermissions).sort();
        
        sortedGroups.forEach(group => {
            const groupHeader = document.createElement('tr');
            groupHeader.className = 'group-header';
            groupHeader.innerHTML = `
                <td colspan="6">
                    <div class="group-title">
                        <i class="fas fa-folder-open me-2"></i>
                        ${escapeHtml(group)} (${groupedPermissions[group].length})
                    </div>
                </td>
            `;
            tbody.appendChild(groupHeader);
            
            groupedPermissions[group].forEach((permission) => {
                const row = document.createElement('tr');
                row.id = `permission-row-${permission.id}`;
                row.innerHTML = `
                    <td><span class="badge-id">#${permission.id}</span></td>
                    <td>
                        <div class="permission-name">
                            <i class="fas fa-key permission-icon"></i>
                            ${escapeHtml(permission.name)}
                        </div>
                    </td>
                    <td>
                        <span class="guard-badge ${permission.guard_name === 'api' ? 'guard-api' : 'guard-web'}">
                            ${escapeHtml(permission.guard_name || 'web')}
                        </span>
                    </td>
                    <td>
                        <span class="group-badge">${escapeHtml(group)}</span>
                    </td>
                    <td>
                        <div class="date-info">
                            <i class="far fa-calendar-alt me-1"></i>
                            ${new Date(permission.created_at).toLocaleDateString('fr-FR')}
                        </div>
                    </td>
                    <td>
                        <div class="role-actions-modern">
                            <button class="action-btn-modern delete-btn-modern" title="Supprimer" 
                                    onclick="showDeleteConfirmation('permission', ${permission.id}, '${escapeHtml(permission.name)}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(row);
            });
        });
    };

    // Afficher les checkboxes des permissions
    const renderPermissionsCheckboxes = (containerId, selectedPermissions = []) => {
        const container = document.getElementById(containerId);
        if (!container) return;
        
        if (!allPermissions || allPermissions.length === 0) {
            container.innerHTML = '<p class="text-muted text-center py-3">Aucune permission disponible</p>';
            return;
        }
        
        const groupedPermissions = allPermissions.reduce((acc, permission) => {
            const group = permission.group || 'Autres';
            if (!acc[group]) acc[group] = [];
            acc[group].push(permission);
            return acc;
        }, {});
        
        let html = '';
        const sortedGroups = Object.keys(groupedPermissions).sort();
        
        sortedGroups.forEach(group => {
            const groupId = `${containerId}_${group.replace(/[^a-zA-Z0-9]/g, '_')}`;
            html += `
                <div class="permission-group">
                    <div class="permission-group-header" onclick="toggleGroup('${groupId}')">
                        <i class="fas fa-chevron-right me-2 group-icon"></i>
                        <strong>${escapeHtml(group)}</strong>
                        <span class="group-count">(${groupedPermissions[group].length})</span>
                    </div>
                    <div class="permission-group-body" id="${groupId}">
            `;
            
            groupedPermissions[group].forEach(permission => {
                const checked = selectedPermissions.includes(permission.id) ? 'checked' : '';
                html += `
                    <div class="form-check permission-checkbox">
                        <input class="form-check-input permission-input" type="checkbox" 
                               name="permissions[]" value="${permission.id}" 
                               id="perm_${containerId}_${permission.id}" ${checked}>
                        <label class="form-check-label" for="perm_${containerId}_${permission.id}">
                            ${escapeHtml(permission.name)}
                        </label>
                    </div>
                `;
            });
            
            html += '</div></div>';
        });
        
        container.innerHTML = html;
        
        // Ouvrir les groupes qui ont des permissions sélectionnées
        setTimeout(() => {
            sortedGroups.forEach(group => {
                const groupId = `${containerId}_${group.replace(/[^a-zA-Z0-9]/g, '_')}`;
                const groupElement = document.getElementById(groupId);
                if (groupElement) {
                    const hasChecked = Array.from(groupElement.querySelectorAll('.permission-input:checked')).length > 0;
                    if (hasChecked) {
                        groupElement.style.display = 'block';
                        const header = groupElement.previousElementSibling;
                        const icon = header.querySelector('.group-icon');
                        if (icon) {
                            icon.className = 'fas fa-chevron-down me-2 group-icon';
                        }
                    }
                }
            });
        }, 100);
    };

    // Basculer l'affichage d'un groupe
    const toggleGroup = (groupId) => {
        const group = document.getElementById(groupId);
        if (!group) return;
        
        const header = group.previousElementSibling;
        const icon = header.querySelector('.group-icon');
        
        if (group.style.display === 'none' || !group.style.display) {
            group.style.display = 'block';
            if (icon) icon.className = 'fas fa-chevron-down me-2 group-icon';
        } else {
            group.style.display = 'none';
            if (icon) icon.className = 'fas fa-chevron-right me-2 group-icon';
        }
    };

    // Créer une permission
    const createPermission = (e) => {
        e.preventDefault();
        
        const form = document.getElementById('createPermissionForm');
        const submitBtn = document.getElementById('submitPermissionBtn');
        
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        const formData = new FormData(form);
        
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Création...';
        submitBtn.disabled = true;
        
        $.ajax({
            url: '{{ route("permissions.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message || 'Permission créée avec succès !');
                    
                    const modal = bootstrap.Modal.getInstance(document.getElementById('createPermissionModal'));
                    modal.hide();
                    
                    form.reset();
                    loadPermissions();
                } else {
                    showAlert('danger', response.message || 'Erreur lors de la création');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = 'Erreurs de validation:<br>';
                    for (const field in errors) {
                        errorMessage += `- ${errors[field].join('<br>')}<br>`;
                    }
                    showAlert('danger', errorMessage);
                } else {
                    showAlert('danger', xhr.responseJSON?.message || 'Erreur lors de la création');
                }
            },
            complete: function() {
                submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Créer';
                submitBtn.disabled = false;
            }
        });
    };

    // ==================== SUPPRESSION ====================

    // Afficher la confirmation de suppression
    const showDeleteConfirmation = (type, id, name) => {
        itemToDelete = { id, name };
        deleteType = type;
        
        const modalElement = document.getElementById('deleteConfirmationModal');
        const modal = new bootstrap.Modal(modalElement);
        
        modalElement.removeAttribute('aria-hidden');
        
        const modalTitle = document.querySelector('#deleteConfirmationModal .modal-title-modern');
        if (modalTitle) {
            modalTitle.innerHTML = type === 'role' 
                ? '<i class="fas fa-exclamation-triangle me-2"></i>Confirmer la suppression du rôle'
                : '<i class="fas fa-exclamation-triangle me-2"></i>Confirmer la suppression de la permission';
        }
        
        document.getElementById('deleteItemInfo').innerHTML = `
            <div class="alert alert-warning">
                <i class="fas fa-info-circle me-2"></i>
                Êtes-vous sûr de vouloir supprimer ${type === 'role' ? 'le rôle' : 'la permission'} 
                <strong>"${escapeHtml(name)}"</strong> ?
            </div>
        `;
        
        modal.show();
        
        setTimeout(() => {
            document.querySelector('#deleteConfirmationModal .btn-danger').focus();
        }, 200);
    };

    // Supprimer un élément
    const deleteItem = () => {
        if (!itemToDelete || !deleteType) return;
        
        const url = deleteType === 'role' 
            ? `{{ url('roles') }}/${itemToDelete.id}`
            : `{{ url('permissions') }}/${itemToDelete.id}`;
        
        const deleteBtn = document.getElementById('confirmDeleteBtn');
        const originalText = deleteBtn.innerHTML;
        
        deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Suppression...';
        deleteBtn.disabled = true;
        
        $.ajax({
            url: url,
            type: 'DELETE',
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message || 'Suppression effectuée avec succès !');
                    
                    if (deleteType === 'role') {
                        loadRoles(currentPage, currentFilters);
                    } else {
                        loadPermissions();
                    }
                    
                    const modal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal'));
                    modal.hide();
                } else {
                    showAlert('danger', response.message || 'Erreur lors de la suppression');
                }
            },
            error: function(xhr) {
                let errorMessage = 'Erreur lors de la suppression';
                if (xhr.responseJSON?.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON?.error) {
                    errorMessage = xhr.responseJSON.error;
                }
                showAlert('danger', errorMessage);
                console.error(xhr);
            },
            complete: function() {
                deleteBtn.innerHTML = originalText;
                deleteBtn.disabled = false;
            }
        });
    };

    // ==================== PAGINATION ====================

    // Afficher la pagination
    const renderPagination = (response) => {
        const pagination = document.getElementById('pagination');
        const paginationInfo = document.getElementById('paginationInfo');
        
        if (!pagination || !paginationInfo) return;
        
        const start = (response.current_page - 1) * response.per_page + 1;
        const end = Math.min(response.current_page * response.per_page, response.total);
        paginationInfo.textContent = `Affichage de ${start} à ${end} sur ${response.total} rôles`;
        
        let paginationHtml = '';
        
        if (response.prev_page_url) {
            paginationHtml += `
                <li class="page-item">
                    <a class="page-link-modern" href="#" onclick="changePage(${response.current_page - 1})">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
            `;
        } else {
            paginationHtml += `
                <li class="page-item disabled">
                    <span class="page-link-modern"><i class="fas fa-chevron-left"></i></span>
                </li>
            `;
        }
        
        const maxPages = 5;
        let startPage = Math.max(1, response.current_page - Math.floor(maxPages / 2));
        let endPage = Math.min(response.last_page, startPage + maxPages - 1);
        
        if (endPage - startPage + 1 < maxPages) {
            startPage = Math.max(1, endPage - maxPages + 1);
        }
        
        for (let i = startPage; i <= endPage; i++) {
            if (i === response.current_page) {
                paginationHtml += `
                    <li class="page-item active">
                        <span class="page-link-modern">${i}</span>
                    </li>
                `;
            } else {
                paginationHtml += `
                    <li class="page-item">
                        <a class="page-link-modern" href="#" onclick="changePage(${i})">${i}</a>
                    </li>
                `;
            }
        }
        
        if (response.next_page_url) {
            paginationHtml += `
                <li class="page-item">
                    <a class="page-link-modern" href="#" onclick="changePage(${response.current_page + 1})">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            `;
        } else {
            paginationHtml += `
                <li class="page-item disabled">
                    <span class="page-link-modern"><i class="fas fa-chevron-right"></i></span>
                </li>
            `;
        }
        
        pagination.innerHTML = paginationHtml;
    };

    // Changer de page
    const changePage = (page) => {
        currentPage = page;
        loadRoles(page, currentFilters);
    };

    // ==================== UTILITAIRES ====================

    // Échapper le HTML
    const escapeHtml = (text) => {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    };

    // Afficher le chargement
    const showLoading = () => {
        document.getElementById('loadingSpinner').style.display = 'flex';
        document.getElementById('tableContainer').style.display = 'none';
        document.getElementById('emptyState').style.display = 'none';
        document.getElementById('paginationContainer').style.display = 'none';
    };

    // Cacher le chargement
    const hideLoading = () => {
        document.getElementById('loadingSpinner').style.display = 'none';
    };

    // Afficher une alerte
    const showAlert = (type, message) => {
        const alertContainer = document.getElementById('alertContainer') || createAlertContainer();
        
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show`;
        alert.setAttribute('role', 'alert');
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        alertContainer.appendChild(alert);
        
        setTimeout(() => {
            if (alert.parentNode) {
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 300);
            }
        }, 5000);
    };

    // Créer le conteneur d'alertes
    const createAlertContainer = () => {
        const container = document.createElement('div');
        container.id = 'alertContainer';
        container.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            max-width: 500px;
        `;
        document.body.appendChild(container);
        return container;
    };

    // Afficher une erreur
    const showError = (message) => {
        showAlert('danger', message);
    };

    // ==================== EVENT LISTENERS ====================

    const setupEventListeners = () => {
        // Recherche avec debounce
        const searchInput = document.getElementById('searchInput');
        let searchTimeout;
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    loadRoles(1, currentFilters);
                }, 500);
            });
        }
        
        // Formulaire de création de rôle
        const createRoleForm = document.getElementById('createRoleForm');
        if (createRoleForm) {
            createRoleForm.addEventListener('submit', createRole);
        }
        
        // Formulaire d'édition de rôle
        const editRoleForm = document.getElementById('editRoleForm');
        if (editRoleForm) {
            editRoleForm.addEventListener('submit', updateRole);
        }
        
        // Formulaire de création de permission
        const createPermissionForm = document.getElementById('createPermissionForm');
        if (createPermissionForm) {
            createPermissionForm.addEventListener('submit', createPermission);
        }
        
        // Bouton de confirmation de suppression
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        if (confirmDeleteBtn) {
            confirmDeleteBtn.addEventListener('click', deleteItem);
        }
        
        // Toggle des filtres
        const toggleFilterBtn = document.getElementById('toggleFilterBtn');
        const filterSection = document.getElementById('filterSection');
        
        if (toggleFilterBtn && filterSection) {
            toggleFilterBtn.addEventListener('click', () => {
                const isVisible = filterSection.style.display === 'block';
                filterSection.style.display = isVisible ? 'none' : 'block';
                toggleFilterBtn.innerHTML = isVisible 
                    ? '<i class="fas fa-sliders-h me-2"></i>Filtres'
                    : '<i class="fas fa-times me-2"></i>Masquer les filtres';
            });
        }
        
        // Appliquer les filtres
        const applyFiltersBtn = document.getElementById('applyFiltersBtn');
        if (applyFiltersBtn) {
            applyFiltersBtn.addEventListener('click', () => {
                currentFilters = {
                    guard: document.getElementById('filterGuard').value,
                    sort_by: document.getElementById('filterSortBy').value,
                    sort_direction: document.getElementById('filterSortDirection').value
                };
                loadRoles(1, currentFilters);
            });
        }
        
        // Effacer les filtres
        const clearFiltersBtn = document.getElementById('clearFiltersBtn');
        if (clearFiltersBtn) {
            clearFiltersBtn.addEventListener('click', () => {
                document.getElementById('filterGuard').value = '';
                document.getElementById('filterSortBy').value = 'name';
                document.getElementById('filterSortDirection').value = 'asc';
                currentFilters = {};
                loadRoles(1);
            });
        }
    };
</script>
    
    <style>
        /* Styles spécifiques pour les rôles et permissions */
        .role-name-modern {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .role-avatar-modern {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #8e44ad, #9b59b6);
            color: white;
            font-size: 1.2rem;
        }

        .role-name-text {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 2px;
            text-transform: capitalize;
        }

        .guard-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .guard-web {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }

        .guard-api {
            background: linear-gradient(135deg, #e67e22, #d35400);
            color: white;
        }

        .permissions-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .permission-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 15px;
            background: #f0f7ff;
            color: #3a56e4;
            font-size: 0.75rem;
            font-weight: 500;
            border: 1px solid #d1e3ff;
        }

        .permission-badge.more {
            background: #e9ecef;
            color: #6c757d;
            border-color: #dee2e6;
        }

        .badge-id {
            display: inline-block;
            padding: 3px 8px;
            background: #e9ecef;
            color: #495057;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .date-info {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .role-actions-modern {
            display: flex;
            gap: 6px;
            justify-content: center;
        }

        .action-btn-modern {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .copy-btn-modern {
            background: linear-gradient(135deg, #f1c40f, #f39c12);
            color: #333;
        }

        .copy-btn-modern:hover {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(241, 196, 15, 0.3);
        }

        .edit-btn-modern {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }

        .edit-btn-modern:hover {
            background: linear-gradient(135deg, #2980b9, #1f618d);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(52, 152, 219, 0.3);
        }

        .delete-btn-modern {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
        }

        .delete-btn-modern:hover {
            background: linear-gradient(135deg, #c0392b, #a93226);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(231, 76, 60, 0.3);
        }

        /* Permissions container */
        .permissions-container {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 15px;
        }

        .permission-group {
            margin-bottom: 20px;
        }

        .permission-group-header {
            padding: 10px 15px;
            background: #f8f9fa;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            color: #495057;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .permission-group-header:hover {
            background: #e9ecef;
        }

        .group-count {
            margin-left: 10px;
            color: #6c757d;
            font-size: 0.85rem;
        }

        .permission-group-body {
            padding: 10px 15px 10px 35px;
            display: none;
        }

        .permission-group-body.show {
            display: block;
        }

        .permission-checkbox {
            margin: 8px 0;
            padding: 5px 10px;
            border-radius: 6px;
            transition: background 0.3s ease;
        }

        .permission-checkbox:hover {
            background: #f8f9fa;
        }

        .permission-input {
            cursor: pointer;
        }

        .permission-checkbox .form-check-label {
            cursor: pointer;
            font-size: 0.9rem;
            color: #495057;
        }

        /* Group header in permissions table */
        .group-header {
            background: #f8f9fa;
        }

        .group-header td {
            padding: 10px 15px !important;
            font-weight: 600;
            color: #495057;
            border-top: 2px solid #e9ecef;
        }

        .group-title {
            display: flex;
            align-items: center;
            color: #2c3e50;
        }

        .permission-name {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .permission-icon {
            color: #f1c40f;
            font-size: 0.9rem;
        }

        .group-badge {
            display: inline-block;
            padding: 3px 8px;
            background: #e9ecef;
            color: #6c757d;
            border-radius: 15px;
            font-size: 0.7rem;
            font-weight: 500;
        }

        /* Modal styles */
        .modal-content-modern {
            background: white;
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .modal-header-modern {
            padding: 20px 30px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title-modern {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }

        .btn-close-modern {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background: #f8f9fa;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .btn-close-modern:hover {
            background: #e9ecef;
            color: #495057;
            transform: rotate(90deg);
        }

        .modal-body-modern {
            padding: 30px;
        }

        .modal-footer-modern {
            padding: 20px 30px;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .role-actions-modern {
                flex-direction: column;
                gap: 5px;
            }
            
            .action-btn-modern {
                width: 100%;
                height: 36px;
            }
            
            .permissions-badges {
                flex-direction: column;
                gap: 3px;
            }
            
            .permission-badge {
                width: fit-content;
            }
            
            .role-name-modern {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            
            .modal-body-modern {
                padding: 20px;
            }
        }
        /* Correction pour les problèmes d'aria-hidden */
.modal.fade.show {
    pointer-events: auto;
    z-index: 1050;
}

.modal-backdrop {
    z-index: 1040;
}

.modal-open {
    overflow: hidden;
    padding-right: 0 !important;
}

.modal-open .modal {
    overflow-x: hidden;
    overflow-y: auto;
}

/* Éviter les conflits d'aria-hidden */
[aria-hidden="true"] {
    pointer-events: none !important;
}

[aria-hidden="true"]:focus,
[aria-hidden="true"] *:focus {
    outline: none !important;
}
    </style>
@endsection