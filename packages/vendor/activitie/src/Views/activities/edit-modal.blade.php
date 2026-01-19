<!-- Edit Activity Modal -->
<div class="modal fade" id="editActivityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modern-modal-content">
            <div class="modal-header modern-modal-header">
                <h5 class="modal-title modern-modal-title">
                    <i class="fas fa-edit me-2"></i>Modifier l'Activité
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body modern-modal-body">
                <form id="editActivityForm">
                    <input type="hidden" id="editActivityId" name="id">
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="editActivityName" class="form-label-modern">Nom *</label>
                            <input type="text" class="form-control-modern" id="editActivityName" name="name" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="editActivityCategorieId" class="form-label-modern">Catégorie *</label>
                            <select class="form-select-modern" id="editActivityCategorieId" name="categorie_id" required>
                                <option value="">Sélectionnez une catégorie</option>
                                @foreach($categories ?? [] as $categorie)
                                    <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3 d-none">
                            <label for="editActivityPrice" class="form-label-modern">Prix (€)</label>
                            <input type="number" class="form-control-modern" id="editActivityPrice" name="price" step="0.01" min="0">
                        </div>
                        
                        <div class="col-md-6 mb-3 d-none">
                            <label for="editActivityDuration" class="form-label-modern">Durée (min)</label>
                            <input type="number" class="form-control-modern" id="editActivityDuration" name="duration" min="1">
                        </div>
                        
                        <div class="col-md-6 mb-3 d-none">
                            <label for="editActivityMaxParticipants" class="form-label-modern">Max participants</label>
                            <input type="number" class="form-control-modern" id="editActivityMaxParticipants" name="max_participants" min="1">
                        </div>
                        
                        <div class="col-md-12 mb-3 d-none">
                            <label for="editActivityLocation" class="form-label-modern">Lieu</label>
                            <input type="text" class="form-control-modern" id="editActivityLocation" name="location">
                        </div>
                        
                        <div class="col-md-12 mb-3 d-none">
                            <label for="editActivityDescription" class="form-label-modern">Description</label>
                            <textarea class="form-control-modern" id="editActivityDescription" name="description" rows="3"></textarea>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="editActivityIsActive" name="is_active">
                                <label class="form-check-label" for="editActivityIsActive">Activer cette activité</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer modern-modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Annuler
                </button>
                <button type="button" class="btn btn-primary" id="updateActivityBtn" onclick="updateActivity()">
                    <span class="btn-text">
                        <i class="fas fa-save me-2"></i>Enregistrer les modifications
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>