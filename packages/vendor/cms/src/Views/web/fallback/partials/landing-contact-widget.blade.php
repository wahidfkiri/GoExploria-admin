{{-- ═══════════════════════════════════════════════════════════════════════
     Widget « Contactez-nous » : bouton flottant en bas à droite + drawer
     modal qui glisse depuis la droite. Formulaire (nom complet, courriel,
     téléphone, sujet, pièce jointe optionnelle, message) envoyé en AJAX via
     le handler mutualisé landing-contact-ajax → sauvegarde en base CMS.
     Nécessite $etablissement.
     ═══════════════════════════════════════════════════════════════════════ --}}
@isset($etablissement)
@once
    <style>
        .cms-cw-fab {
            position: fixed;
            right: 24px;
            bottom: calc(24px + env(safe-area-inset-bottom, 0px));
            z-index: 10000;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 13px 20px;
            font-family: inherit;
            font-size: 15px;
            font-weight: 700;
            line-height: 1;
            color: #111827;
            background: #f2b705;
            border: 1px solid rgba(255, 255, 255, .5);
            border-radius: 50px;
            box-shadow: 0 14px 34px rgba(0, 0, 0, .28);
            cursor: pointer;
            transition: background .22s ease, transform .22s ease, box-shadow .22s ease;
        }
        .cms-cw-fab:hover,
        .cms-cw-fab:focus { background: #ffd84a; transform: translateY(-2px); outline: none; }
        .cms-cw-fab svg { width: 20px; height: 20px; display: block; flex-shrink: 0; }
        .cms-cw-fab__label { white-space: nowrap; }

        .cms-cw-backdrop {
            position: fixed; inset: 0; z-index: 10001;
            background: rgba(15, 23, 42, .55);
            opacity: 0; visibility: hidden;
            transition: opacity .3s ease, visibility .3s ease;
        }
        .cms-cw-backdrop.is-open { opacity: 1; visibility: visible; }

        .cms-cw-drawer {
            position: fixed; top: 0; right: 0; z-index: 10002;
            width: min(440px, 100vw); height: 100%;
            background: #ffffff; color: #111827;
            box-shadow: -18px 0 48px rgba(0, 0, 0, .28);
            display: flex; flex-direction: column;
            transform: translateX(100%);
            transition: transform .32s cubic-bezier(.4, 0, .2, 1);
            font-family: inherit;
        }
        .cms-cw-drawer.is-open { transform: translateX(0); }

        .cms-cw-header {
            display: flex; align-items: flex-start; justify-content: space-between; gap: 12px;
            padding: 22px 24px 16px;
            border-bottom: 1px solid #eef0f3;
        }
        .cms-cw-header h3 { margin: 0 0 4px; font-size: 20px; font-weight: 800; color: #0f172a; }
        .cms-cw-header p { margin: 0; font-size: 13.5px; line-height: 1.5; color: #64748b; }
        .cms-cw-close {
            flex-shrink: 0; width: 38px; height: 38px; display: inline-flex; align-items: center;
            justify-content: center; border: none; border-radius: 50%; background: #f1f5f9;
            color: #334155; font-size: 22px; line-height: 1; cursor: pointer; transition: background .2s ease;
        }
        .cms-cw-close:hover { background: #e2e8f0; }

        .cms-cw-body { padding: 20px 24px 28px; overflow-y: auto; flex: 1; }
        .cms-cw-form { display: flex; flex-direction: column; gap: 14px; }
        .cms-cw-field { display: flex; flex-direction: column; gap: 6px; }
        .cms-cw-field label { font-size: 12.5px; font-weight: 700; color: #334155; }
        .cms-cw-field label .req { color: #ef4444; }
        .cms-cw-input,
        .cms-cw-textarea {
            width: 100%; padding: 11px 13px; font-size: 14px; font-family: inherit; color: #0f172a;
            background: #f8fafc; border: 1px solid #dfe3e8; border-radius: 10px; transition: border-color .2s ease, box-shadow .2s ease;
        }
        .cms-cw-input:focus,
        .cms-cw-textarea:focus { outline: none; border-color: #f2b705; box-shadow: 0 0 0 3px rgba(242, 183, 5, .18); background: #fff; }
        .cms-cw-textarea { min-height: 110px; resize: vertical; }

        .cms-cw-file {
            display: flex; align-items: center; gap: 10px; padding: 11px 13px; cursor: pointer;
            font-size: 13.5px; color: #475569; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 10px;
            transition: border-color .2s ease, background .2s ease;
        }
        .cms-cw-file:hover { border-color: #f2b705; background: #fffdf5; }
        .cms-cw-file input[type="file"] { display: none; }
        .cms-cw-file svg { width: 18px; height: 18px; flex-shrink: 0; }
        .cms-cw-file__name { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

        .cms-cw-submit {
            margin-top: 4px; padding: 13px 18px; font-size: 15px; font-weight: 800; font-family: inherit;
            color: #111827; background: #f2b705; border: none; border-radius: 10px; cursor: pointer;
            transition: background .2s ease, transform .2s ease;
        }
        .cms-cw-submit:hover { background: #ffd84a; }
        .cms-cw-submit:disabled { opacity: .7; cursor: default; }

        .cms-cw-consent { font-size: 11.5px; line-height: 1.5; color: #94a3b8; margin: 2px 0 0; }

        @media (max-width: 640px) {
            .cms-cw-fab { right: 16px; bottom: calc(16px + env(safe-area-inset-bottom, 0px)); padding: 12px 16px; font-size: 14px; }
            .cms-cw-fab__label { display: none; }
            .cms-cw-fab { padding: 14px; }
            .cms-cw-drawer { width: 100vw; }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var fab = document.querySelector('[data-cms-cw-open]');
            var drawer = document.getElementById('cmsContactDrawer');
            var backdrop = document.getElementById('cmsContactBackdrop');
            if (!fab || !drawer || !backdrop) return;

            function openDrawer() {
                drawer.classList.add('is-open');
                backdrop.classList.add('is-open');
                drawer.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
                var first = drawer.querySelector('input, textarea');
                if (first) setTimeout(function () { first.focus(); }, 320);
            }
            function closeDrawer() {
                drawer.classList.remove('is-open');
                backdrop.classList.remove('is-open');
                drawer.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            }

            fab.addEventListener('click', openDrawer);
            backdrop.addEventListener('click', closeDrawer);
            drawer.querySelectorAll('[data-cms-cw-close]').forEach(function (el) {
                el.addEventListener('click', closeDrawer);
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && drawer.classList.contains('is-open')) closeDrawer();
            });

            // Affiche le nom du fichier choisi
            var fileInput = drawer.querySelector('input[type="file"][name="attachment"]');
            var fileLabel = drawer.querySelector('[data-cms-cw-filename]');
            if (fileInput && fileLabel) {
                var defaultText = fileLabel.textContent;
                fileInput.addEventListener('change', function () {
                    fileLabel.textContent = this.files && this.files.length ? this.files[0].name : defaultText;
                });
            }
        });
    </script>
@endonce

<button type="button" class="cms-cw-fab" data-cms-cw-open aria-label="Contactez-nous" aria-controls="cmsContactDrawer">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
    </svg>
    <span class="cms-cw-fab__label">Contactez-nous</span>
</button>

<div class="cms-cw-backdrop" id="cmsContactBackdrop" aria-hidden="true"></div>

<aside class="cms-cw-drawer" id="cmsContactDrawer" role="dialog" aria-modal="true" aria-labelledby="cmsContactTitle" aria-hidden="true">
    <div class="cms-cw-header">
        <div>
            <h3 id="cmsContactTitle">Contactez-nous</h3>
            <p>Une question ? Écrivez-nous, nous vous répondrons rapidement.</p>
        </div>
        <button type="button" class="cms-cw-close" data-cms-cw-close aria-label="Fermer">&times;</button>
    </div>

    <div class="cms-cw-body">
        <form class="cms-cw-form"
              method="POST"
              enctype="multipart/form-data"
              action="{{ route('cms.company.contact.send', ['etablissementId' => $etablissement->id]) }}"
              data-cms-contact-form
              data-cms-form-name="landing_contact_widget"
              data-loading-text="Envoi en cours...">
            @csrf

            <div class="cms-cw-field">
                <label for="cmsCwName">Nom complet <span class="req">*</span></label>
                <input class="cms-cw-input" id="cmsCwName" type="text" name="first_name" placeholder="Votre nom complet" required>
            </div>

            <div class="cms-cw-field">
                <label for="cmsCwEmail">Courriel <span class="req">*</span></label>
                <input class="cms-cw-input" id="cmsCwEmail" type="email" name="email" placeholder="vous@exemple.com" required>
            </div>

            <div class="cms-cw-field">
                <label for="cmsCwPhone">Téléphone</label>
                <input class="cms-cw-input" id="cmsCwPhone" type="tel" name="phone" placeholder="Votre numéro">
            </div>

            <div class="cms-cw-field">
                <label for="cmsCwSubject">Sujet</label>
                <input class="cms-cw-input" id="cmsCwSubject" type="text" name="subject" placeholder="Objet de votre message">
            </div>

            <div class="cms-cw-field">
                <label for="cmsCwMessage">Message <span class="req">*</span></label>
                <textarea class="cms-cw-textarea" id="cmsCwMessage" name="message" placeholder="Comment pouvons-nous vous aider ?" required></textarea>
            </div>

            <div class="cms-cw-field">
                <label>Pièce jointe <span style="color:#94a3b8;font-weight:600">(optionnel)</span></label>
                <label class="cms-cw-file">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                    </svg>
                    <span class="cms-cw-file__name" data-cms-cw-filename>Choisir un fichier…</span>
                    <input type="file" name="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp,.txt,.zip">
                </label>
            </div>

            <button type="submit" class="cms-cw-submit">Envoyer le message</button>
            <p class="cms-cw-consent">En envoyant ce formulaire, vous acceptez d'être contacté au sujet de votre demande.</p>
        </form>
    </div>
</aside>

@include('cms::web.fallback.partials.landing-contact-ajax')
@endisset
