@php
    // Établissement cible pour l'enregistrement des messages de contact.
    $wbContactEtablissementId = 3;
@endphp
<style>
    /* ── Bouton retour en haut (déplacé à GAUCHE) ─────────────────── */
    .back-to-top{
        position:fixed;bottom:30px;left:40px;width:50px;height:50px;border-radius:50%;
        background-color:#107583;color:#fff;border:none;display:flex;align-items:center;justify-content:center;
        font-size:1.5rem;cursor:pointer;box-shadow:0 4px 12px rgba(0,0,0,.2);z-index:1000;
        opacity:0;visibility:hidden;transition:all .3s ease;transform:translateY(-10px);
    }
    .back-to-top.visible{opacity:1;visibility:visible;transform:translateY(0)}

    /* ── Bouton "Contactez Nous" (à DROITE) ───────────────────────── */
    .wb-contact-fab{
        position:fixed;bottom:30px;right:40px;z-index:1000;display:inline-flex;align-items:center;gap:9px;
        padding:13px 22px;border:none;border-radius:50px;cursor:pointer;
        background:linear-gradient(135deg,#0a1628,#1a2942);color:#fff;font-family:'Montserrat',sans-serif;
        font-size:13px;font-weight:700;letter-spacing:.5px;box-shadow:0 6px 20px rgba(10,22,40,.35);
        transition:transform .25s ease,box-shadow .25s ease;
    }
    .wb-contact-fab i{color:#d4af37;font-size:15px}
    .wb-contact-fab:hover{transform:translateY(-2px);box-shadow:0 10px 28px rgba(10,22,40,.45)}

    @media(max-width:600px){
        .back-to-top{left:16px;bottom:20px;width:44px;height:44px;font-size:1.2rem}
        .wb-contact-fab{right:14px;bottom:20px;padding:11px 16px;font-size:12px}
        .wb-contact-fab .wb-contact-fab-text{display:none}
        .wb-contact-fab i{font-size:16px}
    }

    /* ── Modale de contact ────────────────────────────────────────── */
    .wb-modal-overlay{
        position:fixed;inset:0;z-index:99999;display:flex;align-items:flex-end;justify-content:flex-end;padding:24px;
        background:rgba(10,22,40,.55);backdrop-filter:blur(4px);opacity:0;visibility:hidden;transition:opacity .3s ease,visibility .3s ease;
    }
    .wb-modal-overlay.active{opacity:1;visibility:visible}
    .wb-modal{
        background:#fff;border-radius:20px;width:min(440px,100%);max-height:calc(100vh - 48px);overflow:auto;position:relative;
        box-shadow:0 30px 80px rgba(10,22,40,.45);transform:translateX(30px) translateY(10px);opacity:0;transition:transform .3s ease,opacity .3s ease;
    }
    .wb-modal-overlay.active .wb-modal{transform:none;opacity:1}
    .wb-modal-head{padding:26px 30px 8px;position:relative}
    .wb-modal-head .wb-badge{display:inline-flex;align-items:center;gap:7px;padding:5px 13px;border-radius:30px;
        background:rgba(212,175,55,.14);border:1px solid rgba(212,175,55,.35);color:#c9980a;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase}
    .wb-modal-head h2{font-family:'Montserrat',sans-serif;font-size:1.4rem;font-weight:900;color:#0a1628;margin:12px 0 4px}
    .wb-modal-head p{font-size:13px;color:#6b7280;margin:0}
    .wb-modal-close{position:absolute;top:18px;right:18px;width:36px;height:36px;border-radius:50%;border:none;
        background:#f3f4f6;color:#374151;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;transition:background .2s}
    .wb-modal-close:hover{background:#e5e7eb}
    .wb-modal-body{padding:16px 30px 30px}
    .wb-frow{display:grid;grid-template-columns:1fr 1fr;gap:14px}
    .wb-fgroup{margin-bottom:14px;display:flex;flex-direction:column;gap:6px}
    .wb-fgroup label{font-size:11px;font-weight:700;color:#374151;letter-spacing:.5px;text-transform:uppercase}
    .wb-fgroup input,.wb-fgroup select,.wb-fgroup textarea{
        width:100%;padding:11px 14px;border:1.5px solid #e5e7eb;border-radius:10px;font-family:'Montserrat',sans-serif;
        font-size:13px;color:#0a1628;outline:none;background:#fbfbfd;transition:border-color .2s,box-shadow .2s}
    .wb-fgroup input:focus,.wb-fgroup select:focus,.wb-fgroup textarea:focus{border-color:#d4af37;background:#fff;box-shadow:0 0 0 3px rgba(212,175,55,.13)}
    .wb-fgroup textarea{resize:vertical;min-height:96px}
    .wb-check{display:flex;align-items:center;gap:9px;font-size:12px;color:#6b7280;margin-bottom:16px}
    .wb-submit{width:100%;padding:14px;background:linear-gradient(135deg,#0a1628,#1a2942);color:#fff;border:none;border-radius:12px;
        font-family:'Montserrat',sans-serif;font-size:13px;font-weight:700;letter-spacing:1px;text-transform:uppercase;cursor:pointer;
        transition:all .25s;display:flex;align-items:center;justify-content:center;gap:10px}
    .wb-submit i{color:#d4af37}
    .wb-submit:hover:not(:disabled){transform:translateY(-1px);box-shadow:0 10px 26px rgba(10,22,40,.3)}
    .wb-submit:disabled{opacity:.7;cursor:not-allowed}
    .wb-feedback{font-size:12.5px;margin-top:12px;text-align:center;font-weight:600;min-height:18px}
    .wb-feedback.ok{color:#10b981}.wb-feedback.err{color:#ef4444}
    @media(max-width:520px){.wb-frow{grid-template-columns:1fr}}
</style>

<!-- Bouton retour en haut (gauche) -->
<button class="back-to-top" id="backToTop" aria-label="Retour en haut"><i class="fas fa-arrow-up"></i></button>

<!-- Bouton Contactez Nous (droite) -->
<button type="button" class="wb-contact-fab" id="wbContactOpen" aria-label="Contactez-nous">
    <i class="fas fa-envelope"></i><span class="wb-contact-fab-text">Contactez-nous</span>
</button>

<!-- Modale de contact (enregistrée pour l'établissement #{{ $wbContactEtablissementId }}) -->
<div class="wb-modal-overlay" id="wbContactModal" role="dialog" aria-modal="true" aria-labelledby="wbContactTitle">
    <div class="wb-modal">
        <button type="button" class="wb-modal-close" id="wbContactClose" aria-label="Fermer"><i class="fas fa-times"></i></button>
        <div class="wb-modal-head">
            <span class="wb-badge"><i class="fas fa-circle" style="font-size:8px"></i> Contactez-nous</span>
            <h2 id="wbContactTitle">Parlons de votre projet</h2>
            <p>Notre équipe vous répond sous 24&nbsp;heures ouvrables.</p>
        </div>
        <div class="wb-modal-body">
            <form id="wbContactForm">
                <div class="wb-frow">
                    <div class="wb-fgroup">
                        <label>Prénom *</label>
                        <input type="text" name="first_name" placeholder="Jean" required>
                    </div>
                    <div class="wb-fgroup">
                        <label>Nom</label>
                        <input type="text" name="last_name" placeholder="Tremblay">
                    </div>
                </div>
                <div class="wb-frow">
                    <div class="wb-fgroup">
                        <label>Courriel *</label>
                        <input type="email" name="email" placeholder="jean@exemple.com" required>
                    </div>
                    <div class="wb-fgroup">
                        <label>Téléphone</label>
                        <input type="tel" name="phone" placeholder="+1 (514) 000-0000">
                    </div>
                </div>
                <div class="wb-fgroup">
                    <label>Sujet</label>
                    <select name="subject">
                        <option value="">-- Sélectionner --</option>
                        <option>Demande d'information</option>
                        <option>Réservation / forfait</option>
                        <option>Demande de devis</option>
                        <option>Partenariat</option>
                        <option>Autre</option>
                    </select>
                </div>
                <div class="wb-fgroup">
                    <label>Votre message *</label>
                    <textarea name="message" placeholder="Décrivez votre demande..." required></textarea>
                </div>
                <label class="wb-check">
                    <input type="checkbox" name="newsletter_opt_in" value="1" checked>
                    Je souhaite recevoir les offres et actualités.
                </label>
                <button type="submit" class="wb-submit" id="wbContactSubmit">
                    <i class="fas fa-paper-plane"></i> <span>Envoyer le message</span>
                </button>
                <div class="wb-feedback" id="wbContactFeedback"></div>
            </form>
        </div>
    </div>
</div>

<script>
(function () {
    // ── Retour en haut ──
    var backTop = document.getElementById('backToTop');
    window.addEventListener('scroll', function () {
        if (window.scrollY > 300) backTop.classList.add('visible'); else backTop.classList.remove('visible');
    });
    backTop.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: 'smooth' }); });

    // ── Modale de contact ──
    var overlay  = document.getElementById('wbContactModal');
    var openBtn  = document.getElementById('wbContactOpen');
    var closeBtn = document.getElementById('wbContactClose');
    var form     = document.getElementById('wbContactForm');
    var submit   = document.getElementById('wbContactSubmit');
    var feedback = document.getElementById('wbContactFeedback');
    var CSRF     = @json(csrf_token());
    var SEND_URL = @json(url('/company/'.$wbContactEtablissementId.'/contact/send'));

    function open()  { overlay.classList.add('active'); document.body.style.overflow = 'hidden'; }
    function close() { overlay.classList.remove('active'); document.body.style.overflow = ''; }

    openBtn.addEventListener('click', open);
    closeBtn.addEventListener('click', close);
    overlay.addEventListener('click', function (e) { if (e.target === overlay) close(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && overlay.classList.contains('active')) close(); });

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        feedback.textContent = ''; feedback.className = 'wb-feedback';
        submit.disabled = true;
        var label = submit.querySelector('span');
        var original = label.textContent;
        label.textContent = 'Envoi en cours...';

        var fd = new FormData(form);
        fd.append('_token', CSRF);
        if (!fd.get('newsletter_opt_in')) fd.append('newsletter_opt_in', '0');

        fetch(SEND_URL, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: fd,
        })
        .then(function (r) { return r.json().catch(function () { return { success: r.ok }; }).then(function (d) { return { ok: r.ok, d: d }; }); })
        .then(function (res) {
            if (res.ok && (res.d.success === undefined || res.d.success)) {
                feedback.textContent = (res.d.message) || 'Message envoyé ! Merci, nous vous répondrons rapidement.';
                feedback.className = 'wb-feedback ok';
                form.reset();
                setTimeout(close, 2200);
            } else {
                var msg = res.d.message || (res.d.errors ? Object.values(res.d.errors)[0][0] : 'Une erreur est survenue.');
                feedback.textContent = msg; feedback.className = 'wb-feedback err';
            }
        })
        .catch(function () { feedback.textContent = 'Erreur réseau. Réessayez.'; feedback.className = 'wb-feedback err'; })
        .finally(function () { submit.disabled = false; label.textContent = original; });
    });
})();
</script>
