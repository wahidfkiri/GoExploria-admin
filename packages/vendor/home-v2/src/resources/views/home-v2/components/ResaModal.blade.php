{{-- ================================================================
     MODAL RÉSERVATION GLOBAL — Table & Vin
     Déclenché par openGoExpResaModal(type, itemName)
     ================================================================ --}}
<div class="goexp-resa-overlay" id="goexpResaModal" role="dialog" aria-modal="true" aria-labelledby="resaModalTitle">
    <div class="goexp-resa-box">
        <div class="goexp-resa-header">
            <div class="goexp-resa-icon table-type" id="resaModalIcon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="goexp-resa-titles">
                <h3 id="resaModalTitle">Réserver votre Table</h3>
                <p id="resaModalSubtitle">Choisissez votre date et complétez vos informations.</p>
            </div>
            <button class="goexp-resa-close-btn" id="goexpResaClose" aria-label="Fermer">&#x2715;</button>
        </div>
        <div class="goexp-resa-divider"></div>
        <form class="goexp-resa-form" id="goexpResaForm" onsubmit="handleResaSubmit(event)">
            <div class="goexp-resa-field">
                <label class="goexp-resa-label" for="resaItemField">Sélection</label>
                <input type="text" id="resaItemField" class="goexp-resa-input selection-field"
                       placeholder="Aucune sélection" aria-label="Item sélectionné" readonly>
            </div>
            <div class="goexp-resa-row">
                <div class="goexp-resa-field">
                    <label class="goexp-resa-label" for="resaDateField">Date</label>
                    <input type="date" id="resaDateField" class="goexp-resa-input"
                           min="{{ date('Y-m-d') }}" aria-label="Date de réservation">
                </div>
                <div class="goexp-resa-field">
                    <label class="goexp-resa-label" for="resaTimeField">Heure</label>
                    <select id="resaTimeField" class="goexp-resa-select" aria-label="Heure">
                        <option value="">— Heure —</option>
                        <option>11h30</option><option>12h00</option><option>12h30</option>
                        <option>13h00</option><option>17h30</option><option>18h00</option>
                        <option>18h30</option><option>19h00</option><option>19h30</option>
                        <option>20h00</option><option>20h30</option><option>21h00</option>
                    </select>
                </div>
            </div>
            <div class="goexp-resa-row">
                <div class="goexp-resa-field">
                    <label class="goexp-resa-label" for="resaGuestsField">Convives</label>
                    <input type="number" id="resaGuestsField" class="goexp-resa-input"
                           min="1" max="20" placeholder="Nb personnes">
                </div>
                <div class="goexp-resa-field">
                    <label class="goexp-resa-label" for="resaNameField">Nom</label>
                    <input type="text" id="resaNameField" class="goexp-resa-input"
                           placeholder="Votre nom complet">
                </div>
            </div>
            <div class="goexp-resa-field">
                <label class="goexp-resa-label" for="resaEmailField">Email</label>
                <input type="email" id="resaEmailField" class="goexp-resa-input"
                       placeholder="votre@email.com">
            </div>
            <div class="goexp-resa-field">
                <label class="goexp-resa-label" for="resaMsgField">Message (optionnel)</label>
                <textarea id="resaMsgField" class="goexp-resa-textarea" rows="2"
                          placeholder="Allergies, occasion spéciale, demandes particulières..."></textarea>
            </div>
            <button type="submit" class="goexp-resa-submit">
                <i class="fas fa-check-circle"></i> Confirmer la réservation
            </button>
        </form>
        <div class="goexp-resa-success" id="goexpResaSuccess">
            <div class="goexp-resa-success-icon"><i class="fas fa-check-circle"></i></div>
            <h4>Demande envoyée !</h4>
            <p>Votre demande de réservation a bien été reçue.<br>Vous recevrez une confirmation par email sous peu.</p>
        </div>
    </div>
</div>

<script>
(function () {
    var modal    = document.getElementById('goexpResaModal');
    var closeBtn = document.getElementById('goexpResaClose');
    var form     = document.getElementById('goexpResaForm');
    var success  = document.getElementById('goexpResaSuccess');
    var icon     = document.getElementById('resaModalIcon');
    var titleEl  = document.getElementById('resaModalTitle');
    var subEl    = document.getElementById('resaModalSubtitle');
    var itemFld  = document.getElementById('resaItemField');

    window.openGoExpResaModal = function (type, itemName) {
        if (!modal) return;
        form.style.display = '';
        success.classList.remove('show');
        if (type === 'wine') {
            icon.className = 'goexp-resa-icon wine-type';
            icon.innerHTML = '<i class="fas fa-wine-glass-alt"></i>';
            titleEl.textContent = 'Réserver un Vin';
            subEl.textContent   = 'Complétez les détails pour votre réservation de vin.';
            itemFld.placeholder = 'Vin sélectionné...';
        } else {
            icon.className = 'goexp-resa-icon table-type';
            icon.innerHTML = '<i class="fas fa-calendar-check"></i>';
            titleEl.textContent = 'Réserver votre Table';
            subEl.textContent   = 'Choisissez votre date et complétez vos informations.';
            itemFld.placeholder = 'Plat ou formule sélectionné...';
        }
        itemFld.value = itemName || '';
        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
    };

    window.handleResaSubmit = function (e) {
        e.preventDefault();
        form.style.display = 'none';
        success.classList.add('show');
        setTimeout(function () {
            modal.classList.remove('open');
            document.body.style.overflow = '';
        }, 3200);
    };

    function closeModal() {
        modal.classList.remove('open');
        document.body.style.overflow = '';
    }

    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (modal) modal.addEventListener('click', function (e) {
        if (e.target === modal) closeModal();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeModal();
    });
})();
</script>
