{{-- resources/views/menus/page-editor.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-edit me-2"></i>
                Éditeur de page : {{ $menu->title }}
            </h1>
            <div class="page-actions">
                <button class="btn btn-outline-secondary" id="togglePreviewBtn">
                    <i class="fas fa-eye me-2"></i>Prévisualiser
                </button>
                <button class="btn btn-success" id="savePageBtn">
                    <i class="fas fa-save me-2"></i>Sauvegarder
                </button>
                <button class="btn btn-primary" id="publishPageBtn">
                    <i class="fas fa-paper-plane me-2"></i>Publier
                </button>
                <a href="{{ route('menus.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour aux menus
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2">
                <div class="editor-sidebar">
                    <div class="sidebar-section">
                        <h6><i class="fas fa-layer-group"></i> Blocs</h6>
                        <div class="blocks-container">
                            <div class="block" data-type="text">
                                <i class="fas fa-paragraph"></i> Texte
                            </div>
                            <div class="block" data-type="image">
                                <i class="fas fa-image"></i> Image
                            </div>
                            <div class="block" data-type="video">
                                <i class="fas fa-video"></i> Vidéo
                            </div>
                            <div class="block" data-type="button">
                                <i class="fas fa-hand-pointer"></i> Bouton
                            </div>
                            <div class="block" data-type="columns">
                                <i class="fas fa-columns"></i> Colonnes
                            </div>
                        </div>
                    </div>

                    <div class="sidebar-section">
                        <h6><i class="fas fa-sliders-h"></i> Options</h6>
                        <div class="options-container">
                            <div class="option" id="pageSettingsBtn">
                                <i class="fas fa-cog"></i> Paramètres
                            </div>
                            <div class="option" id="revisionsBtn">
                                <i class="fas fa-history"></i> Révisions
                            </div>
                            <div class="option" id="seoBtn">
                                <i class="fas fa-search"></i> SEO
                            </div>
                        </div>
                    </div>

                    <div class="sidebar-section">
                        <h6><i class="fas fa-info-circle"></i> Statut</h6>
                        <div class="status-badge {{ $menu->page_status }}">
                            {{ ucfirst($menu->page_status) }}
                        </div>
                        @if($menu->page_status === 'published')
                            <a href="{{ $menu->page_url }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                <i class="fas fa-external-link-alt"></i> Voir la page
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Editor Area -->
            <div class="col-lg-10">
                <div id="gjs">
                    <!-- Contenu initial chargé depuis la base de données -->
                    {!! $menu->page_content ?: '<div class="container"><h1>Bienvenue sur la page ' . $menu->title . '</h1><p>Commencez à éditer votre contenu ici.</p></div>' !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    @include('administration::menus.modals.page-settings')
    @include('administration::menus.modals.revisions')
    @include('administration::menus.modals.seo')

    <!-- CSS Styles from database -->
    <style>
        {{ $menu->page_styles }}
    </style>


    <link href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" rel="stylesheet">
    <style>
        .editor-sidebar {
            background: #f8f9fa;
            height: calc(100vh - 120px);
            position: sticky;
            top: 20px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .sidebar-section {
            margin-bottom: 25px;
        }

        .sidebar-section h6 {
            color: #495057;
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .blocks-container, .options-container {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .block, .option {
            padding: 10px;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            cursor: move;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .block:hover, .option:hover {
            background: #e9ecef;
            border-color: #007bff;
            transform: translateX(5px);
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-badge.draft {
            background: #ffc107;
            color: #333;
        }

        .status-badge.published {
            background: #28a745;
            color: white;
        }

        .status-badge.archived {
            background: #6c757d;
            color: white;
        }

        #gjs {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            height: calc(100vh - 120px);
        }

        /* GrapeJS custom styles */
        .gjs-editor-cont {
            border-radius: 8px;
        }

        .gjs-one-bg {
            background-color: #f8f9fa;
        }

        .gjs-two-color {
            color: #495057;
        }

        .gjs-three-bg {
            background-color: #007bff;
        }

        .gjs-four-color {
            color: white;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/grapesjs"></script>
    <script src="https://unpkg.com/grapesjs-blocks-basic"></script>
    <script src="https://unpkg.com/grapesjs-plugin-forms"></script>
    <script src="https://unpkg.com/grapesjs-component-countdown"></script>
    <script src="https://unpkg.com/grapesjs-plugin-export"></script>
    <script src="https://unpkg.com/grapesjs-style-filter"></script>
    <script src="https://unpkg.com/grapesjs-tabs"></script>
    <script src="https://unpkg.com/grapesjs-tooltip"></script>
    <script src="https://unpkg.com/grapesjs-touch"></script>
    <script src="https://unpkg.com/grapesjs-navbar"></script>
    <script src="https://unpkg.com/grapesjs-preset-webpage"></script>

    <script>
        // Configuration GrapeJS
        const editor = grapesjs.init({
            container: '#gjs',
            fromElement: true,
            height: 'calc(100vh - 120px)',
            storageManager: false, // Nous gérons le stockage nous-mêmes
            plugins: [
                'gjs-blocks-basic',
                'grapesjs-plugin-forms',
                'grapesjs-component-countdown',
                'grapesjs-plugin-export',
                'grapesjs-style-filter',
                'grapesjs-tabs',
                'grapesjs-tooltip',
                'grapesjs-touch',
                'grapesjs-navbar',
                'grapesjs-preset-webpage'
            ],
            pluginsOpts: {
                'grapesjs-preset-webpage': {
                    blocks: ['column1', 'column2', 'column3', 'column4', 'text', 'image', 'video', 'map'],
                    modalImportTitle: 'Importer du HTML',
                    modalImportLabel: '<div style="margin-bottom:10px; font-size: 13px;">Coller votre HTML ici:</div>',
                    modalImportContent: function(editor) {
                        return editor.getHtml();
                    }
                }
            },
            blockManager: {
                appendTo: '#blocks',
                blocks: [
                    {
                        id: 'section',
                        label: 'Section',
                        content: '<section class="py-5"><div class="container"><h2>Nouvelle section</h2><p>Ajoutez votre contenu ici</p></div></section>',
                        category: 'Layout'
                    },
                    {
                        id: 'hero',
                        label: 'Hero',
                        content: '<section class="hero-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 100px 0; text-align: center;"><div class="container"><h1 style="font-size: 3rem; margin-bottom: 20px;">Titre principal</h1><p style="font-size: 1.2rem; margin-bottom: 30px;">Description de votre page ou offre spéciale</p><a href="#" class="btn btn-light" style="padding: 12px 30px; border-radius: 30px; font-weight: 600;">En savoir plus</a></div></section>',
                        category: 'Layout'
                    }
                ]
            },
            styleManager: {
                sectors: [{
                    name: 'General',
                    open: false,
                    buildProps: ['display', 'float', 'position', 'top', 'right', 'left', 'bottom']
                }, {
                    name: 'Dimension',
                    open: false,
                    buildProps: ['width', 'height', 'max-width', 'min-height', 'margin', 'padding']
                }, {
                    name: 'Typography',
                    open: false,
                    buildProps: ['font-family', 'font-size', 'font-weight', 'letter-spacing', 'color', 'line-height', 'text-align', 'text-shadow'],
                    properties: [{
                        property: 'text-align',
                        list: [
                            { value: 'left', className: 'fa fa-align-left' },
                            { value: 'center', className: 'fa fa-align-center' },
                            { value: 'right', className: 'fa fa-align-right' },
                            { value: 'justify', className: 'fa fa-align-justify' }
                        ]
                    }]
                }, {
                    name: 'Decorations',
                    open: false,
                    buildProps: ['background-color', 'border-radius', 'border', 'box-shadow', 'background']
                }]
            },
            canvas: {
                styles: [
                    'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css',
                    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'
                ]
            }
        });

        // Variables globales
        const menuId = {{ $menu->id }};
        let autoSaveInterval;
        let isSaving = false;

        // Initialisation
        $(document).ready(function() {
            setupEditorEvents();
            setupAutoSave();
            loadPageMeta();
        });

        // Configuration des événements de l'éditeur
        const setupEditorEvents = () => {
            // Sauvegarde manuelle
            $('#savePageBtn').on('click', function() {
                savePage('Sauvegarde manuelle');
            });

            // Publication
            $('#publishPageBtn').on('click', function() {
                if (confirm('Êtes-vous sûr de vouloir publier cette page ?')) {
                    publishPage();
                }
            });

            // Prévisualisation
            $('#togglePreviewBtn').on('click', function() {
                const isPreview = editor.getModel().get('preview');
                if (isPreview) {
                    editor.stopCommand('preview');
                    $(this).html('<i class="fas fa-eye me-2"></i>Prévisualiser');
                } else {
                    editor.runCommand('preview');
                    $(this).html('<i class="fas fa-edit me-2"></i>Éditer');
                }
            });

            // Paramètres de la page
            $('#pageSettingsBtn').on('click', function() {
                $('#pageSettingsModal').modal('show');
            });

            // Révisions
            $('#revisionsBtn').on('click', function() {
                loadRevisions();
                $('#revisionsModal').modal('show');
            });

            // SEO
            $('#seoBtn').on('click', function() {
                $('#seoModal').modal('show');
            });

            // Drag and drop des blocs
            $('.block').on('mousedown', function() {
                const type = $(this).data('type');
                addBlock(type);
            });
        };

        // Sauvegarder la page
        const savePage = (changeDescription = 'Modification') => {
            if (isSaving) return;
            
            isSaving = true;
            const saveBtn = $('#savePageBtn');
            const originalText = saveBtn.html();
            
            saveBtn.prop('disabled', true).html(
                '<div class="spinner-border spinner-border-sm me-2"></div>Sauvegarde...'
            );
            
            const html = editor.getHtml();
            const css = editor.getCss();
            
            // Récupérer les métadonnées
            const meta = {
                title: $('#pageTitle').val() || '{{ $menu->title }}',
                description: $('#pageDescription').val() || '',
                keywords: $('#pageKeywords').val() || '',
                author: $('#pageAuthor').val() || '',
                og_image: $('#pageOgImage').val() || ''
            };
            
            $.ajax({
                url: `/menus/${menuId}/page`,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    content: html,
                    styles: css,
                    meta: meta,
                    change_description: changeDescription
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        showNotification('success', 'Page sauvegardée avec succès');
                        
                        // Mettre à jour le statut
                        updatePageStatus(response.data.status);
                    } else {
                        showNotification('danger', response.message || 'Erreur lors de la sauvegarde');
                    }
                },
                error: function(xhr) {
                    console.error('Save error:', xhr.responseText);
                    showNotification('danger', 'Erreur lors de la sauvegarde');
                },
                complete: function() {
                    saveBtn.prop('disabled', false).html(originalText);
                    isSaving = false;
                }
            });
        };

        // Publier la page
        const publishPage = () => {
            $.ajax({
                url: `/menus/${menuId}/page/publish`,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        showNotification('success', 'Page publiée avec succès');
                        updatePageStatus('published');
                    } else {
                        showNotification('danger', response.message || 'Erreur lors de la publication');
                    }
                },
                error: function(xhr) {
                    console.error('Publish error:', xhr.responseText);
                    showNotification('danger', 'Erreur lors de la publication');
                }
            });
        };

        // Sauvegarde automatique
        const setupAutoSave = () => {
            // Sauvegarde automatique toutes les 30 secondes
            autoSaveInterval = setInterval(() => {
                if (editor.getDirtyCount() > 0) {
                    savePage('Sauvegarde automatique');
                }
            }, 30000);
            
            // Sauvegarde lors de la fermeture de la page
            window.addEventListener('beforeunload', function(e) {
                if (editor.getDirtyCount() > 0) {
                    e.preventDefault();
                    e.returnValue = 'Vous avez des modifications non sauvegardées. Voulez-vous vraiment quitter ?';
                }
            });
        };

        // Charger les métadonnées de la page
        const loadPageMeta = () => {
            const meta = @json($menu->page_meta);
            
            if (meta) {
                $('#pageTitle').val(meta.title || '');
                $('#pageDescription').val(meta.description || '');
                $('#pageKeywords').val(meta.keywords || '');
                $('#pageAuthor').val(meta.author || '');
                $('#pageOgImage').val(meta.og_image || '');
            }
        };

        // Charger les révisions
        const loadRevisions = () => {
            $('#revisionsList').html(`
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                    <p class="mt-2">Chargement des révisions...</p>
                </div>
            `);
            
            $.ajax({
                url: `/menus/${menuId}/revisions`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.data.length > 0) {
                        let html = '';
                        
                        response.data.forEach((revision, index) => {
                            html += `
                                <div class="revision-item ${index === 0 ? 'current' : ''}">
                                    <div class="revision-header">
                                        <div class="revision-version">
                                            <i class="fas fa-code-branch"></i>
                                            ${revision.version}
                                        </div>
                                        <div class="revision-date">
                                            <i class="far fa-clock"></i>
                                            ${revision.formatted_date}
                                        </div>
                                    </div>
                                    <div class="revision-info">
                                        <div class="revision-user">
                                            <i class="fas fa-user"></i>
                                            ${revision.user_name}
                                        </div>
                                        <div class="revision-description">
                                            ${revision.change_description || 'Modification sans description'}
                                        </div>
                                    </div>
                                    <div class="revision-actions">
                                        <button class="btn btn-sm btn-outline-primary preview-revision" data-id="${revision.id}">
                                            <i class="fas fa-eye"></i> Prévisualiser
                                        </button>
                                        <button class="btn btn-sm btn-outline-success restore-revision" data-id="${revision.id}">
                                            <i class="fas fa-history"></i> Restaurer
                                        </button>
                                    </div>
                                </div>
                            `;
                        });
                        
                        $('#revisionsList').html(html);
                    } else {
                        $('#revisionsList').html(`
                            <div class="text-center py-4">
                                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                <p>Aucune révision disponible</p>
                            </div>
                        `);
                    }
                },
                error: function(xhr) {
                    console.error('Load revisions error:', xhr.responseText);
                    $('#revisionsList').html(`
                        <div class="text-center py-4">
                            <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                            <p>Erreur lors du chargement des révisions</p>
                        </div>
                    `);
                }
            });
        };

        // Restaurer une révision
        $(document).on('click', '.restore-revision', function() {
            const revisionId = $(this).data('id');
            
            if (confirm('Êtes-vous sûr de vouloir restaurer cette révision ?')) {
                $.ajax({
                    url: `/menus/${menuId}/revisions/${revisionId}/restore`,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            showNotification('success', 'Révision restaurée avec succès');
                            $('#revisionsModal').modal('hide');
                            
                            // Recharger l'éditeur avec le contenu restauré
                            location.reload();
                        } else {
                            showNotification('danger', response.message || 'Erreur lors de la restauration');
                        }
                    },
                    error: function(xhr) {
                        console.error('Restore error:', xhr.responseText);
                        showNotification('danger', 'Erreur lors de la restauration');
                    }
                });
            }
        });

        // Mettre à jour le statut de la page
        const updatePageStatus = (status) => {
            $('.status-badge')
                .removeClass('draft published archived')
                .addClass(status)
                .text(status.charAt(0).toUpperCase() + status.slice(1));
        };

        // Ajouter un bloc
        const addBlock = (type) => {
            let content = '';
            
            switch(type) {
                case 'text':
                    content = '<div class="content-block"><h3>Titre de section</h3><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p></div>';
                    break;
                case 'image':
                    content = '<div class="image-block"><img src="https://via.placeholder.com/800x400" alt="Image placeholder" style="width:100%; border-radius: 8px;"></div>';
                    break;
                case 'video':
                    content = '<div class="video-block"><div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/dQw4w9WgXcQ" allowfullscreen></iframe></div></div>';
                    break;
                case 'button':
                    content = '<div class="button-block"><a href="#" class="btn btn-primary" style="padding: 12px 30px; border-radius: 30px;">Bouton</a></div>';
                    break;
                case 'columns':
                    content = '<div class="row"><div class="col-md-6"><p>Colonne gauche</p></div><div class="col-md-6"><p>Colonne droite</p></div></div>';
                    break;
            }
            
            editor.addComponents(content);
        };

        // Notification
        const showNotification = (type, message) => {
            const notification = $(`
                <div class="alert alert-${type} alert-dismissible fade show notification-alert" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `);
            
            $('.container-fluid').prepend(notification);
            
            setTimeout(() => {
                notification.alert('close');
            }, 5000);
        };

        // Sauvegarder les paramètres SEO
        $('#saveSeoBtn').on('click', function() {
            const meta = {
                title: $('#pageTitle').val(),
                description: $('#pageDescription').val(),
                keywords: $('#pageKeywords').val(),
                author: $('#pageAuthor').val(),
                og_image: $('#pageOgImage').val()
            };
            
            // Mettre à jour le contenu avec les nouvelles métadonnées
            savePage('Mise à jour des paramètres SEO');
            $('#seoModal').modal('hide');
        });
    </script>

@endsection