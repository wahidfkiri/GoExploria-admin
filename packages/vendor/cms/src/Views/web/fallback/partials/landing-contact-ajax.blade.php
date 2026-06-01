@once
    <style>
        .cms-contact-alert {
            display: none;
            margin-top: 12px;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 14px;
            line-height: 1.45;
            font-weight: 700;
        }
        .cms-contact-alert.is-visible { display: block; }
        .cms-contact-alert.is-success {
            color: #076b3d;
            background: rgba(16, 185, 129, .12);
            border: 1px solid rgba(16, 185, 129, .36);
        }
        .cms-contact-alert.is-error {
            color: #9f1239;
            background: rgba(244, 63, 94, .12);
            border: 1px solid rgba(244, 63, 94, .32);
        }
        [data-cms-contact-form] [aria-invalid="true"] {
            border-color: #f43f5e !important;
            box-shadow: 0 0 0 3px rgba(244, 63, 94, .12);
        }
    </style>
    <script>
        (function () {
            function statusBox(form) {
                var box = form.querySelector('[data-cms-contact-status]');
                if (!box) {
                    box = document.createElement('div');
                    box.className = 'cms-contact-alert';
                    box.setAttribute('data-cms-contact-status', '');
                    form.appendChild(box);
                }
                return box;
            }

            function showStatus(form, type, message) {
                var box = statusBox(form);
                box.className = 'cms-contact-alert is-visible is-' + type;
                box.textContent = message;
            }

            function clearFieldState(form) {
                form.querySelectorAll('[aria-invalid="true"]').forEach(function (field) {
                    field.removeAttribute('aria-invalid');
                });
            }

            function markErrors(form, errors) {
                Object.keys(errors || {}).forEach(function (name) {
                    var field = form.querySelector('[name="' + CSS.escape(name) + '"]');
                    if (field) {
                        field.setAttribute('aria-invalid', 'true');
                    }
                });
            }

            function firstError(errors) {
                var keys = Object.keys(errors || {});
                if (!keys.length) {
                    return null;
                }
                var messages = errors[keys[0]];
                return Array.isArray(messages) ? messages[0] : String(messages);
            }

            document.addEventListener('submit', function (event) {
                var form = event.target.closest('form[data-cms-contact-form]');
                if (!form) {
                    return;
                }

                event.preventDefault();
                clearFieldState(form);

                var submit = form.querySelector('[type="submit"]');
                var originalText = submit ? submit.innerHTML : '';
                var data = new FormData(form);

                if (!data.get('subject') && data.get('service')) {
                    data.set('subject', data.get('service'));
                }

                if (!data.get('form_name')) {
                    data.set('form_name', form.getAttribute('data-cms-form-name') || 'landing_contact');
                }

                if (submit) {
                    submit.disabled = true;
                    submit.setAttribute('aria-busy', 'true');
                    submit.innerHTML = form.getAttribute('data-loading-text') || 'Envoi en cours...';
                }

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: data
                })
                    .then(function (response) {
                        return response.json().then(function (payload) {
                            if (!response.ok) {
                                var error = new Error(payload.message || 'Erreur de validation.');
                                error.payload = payload;
                                throw error;
                            }
                            return payload;
                        });
                    })
                    .then(function (payload) {
                        form.reset();
                        showStatus(form, 'success', payload.message || 'Votre message a bien été envoyé.');
                    })
                    .catch(function (error) {
                        var payload = error.payload || {};
                        markErrors(form, payload.errors || {});
                        showStatus(form, 'error', firstError(payload.errors || {}) || payload.message || 'Impossible d’envoyer le message pour le moment.');
                    })
                    .finally(function () {
                        if (submit) {
                            submit.disabled = false;
                            submit.removeAttribute('aria-busy');
                            submit.innerHTML = originalText;
                        }
                    });
            }, true);
        })();
    </script>
@endonce
