<!-- Create Activity Modal -->
<div class="modal fade" id="createActivityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modern-modal-content">
            <div class="modal-header modern-modal-header">
                <h5 class="modal-title modern-modal-title">
                    <i class="fas fa-running me-2"></i>Nouvelle Activité
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body modern-modal-body">
                <form id="createActivityForm">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="createActivityName" class="form-label-modern">Nom *</label>
                            <input type="text" class="form-control-modern" id="createActivityName" name="name" required>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="createActivityCategorieId" class="form-label-modern">Catégorie *</label>
                            <select class="form-select-modern" id="createActivityCategorieId" name="categorie_id" required>
                                <option value="">Sélectionnez une catégorie</option>
                                @foreach($categories ?? [] as $categorie)
                                    <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3 d-none">
                            <label for="createActivityPrice" class="form-label-modern">Prix (€)</label>
                            <input type="number" class="form-control-modern" id="createActivityPrice" name="price" step="0.01" min="0">
                        </div>
                        
                        <div class="col-md-6 mb-3 d-none">
                            <label for="createActivityDuration" class="form-label-modern">Durée (min)</label>
                            <input type="number" class="form-control-modern" id="createActivityDuration" name="duration" min="1">
                        </div>
                        
                        <div class="col-md-6 mb-3 d-none">
                            <label for="createActivityMaxParticipants" class="form-label-modern">Max participants</label>
                            <input type="number" class="form-control-modern" id="createActivityMaxParticipants" name="max_participants" min="1">
                        </div>
                        
                        <div class="col-md-12 mb-3 d-none">
                            <label for="createActivityLocation" class="form-label-modern">Lieu</label>
                            <input type="text" class="form-control-modern" id="createActivityLocation" name="location">
                        </div>
                        
                        <div class="col-md-12 mb-3 d-none">
                            <label for="createActivityDescription" class="form-label-modern">Description</label>
                            <textarea class="form-control-modern" id="createActivityDescription" name="description" rows="3"></textarea>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="createActivityIsActive" name="is_active" checked>
                                <label class="form-check-label" for="createActivityIsActive">Activer cette activité</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer modern-modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Annuler
                </button>
                <button type="button" class="btn btn-primary" id="submitActivityBtn" onclick="storeActivity()">
                    <span class="btn-text">
                        <i class="fas fa-save me-2"></i>Créer l'activité
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>