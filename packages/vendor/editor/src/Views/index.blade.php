<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@if(isset($template)){{ $template->name }} - @endif Web Page Builder</title>
    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- GrapesJS CSS via CDN -->
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
    
    <link rel="stylesheet" href="{{ asset('vendor/editor/css/editor.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/editor/css/custom.css') }}">
    
    <style>
        .preview-frame {
            width: 100%;
            height: 600px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: white;
        }
        
        .preview-modal-footer {
            display: flex;
            justify-content: flex-end;
            padding: 15px;
            border-top: 1px solid #e2e8f0;
        }
        
        .modal-content {
            max-width: 90%;
            margin: 5vh auto;
        }
        
        .preview-fullscreen-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #3b82f6;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .preview-fullscreen-btn:hover {
            background: #2563eb;
        }
    </style>
</head>
<body>
    <!-- Barre supérieure -->
    <div class="top-bar">
        <div class="logo">
            <i class="fas fa-paint-brush logo-icon"></i>
            <span>Web Page Builder</span>
        </div>
        
        <div class="menu-actions">
            <button class="menu-btn danger" onclick="clearCanvas()" title="Effacer tout">
                <i class="fas fa-trash"></i>
                Vider le canevas
            </button>
            <button class="menu-btn" onclick="showPreviewInNewTab()" title="Aperçu">
                <i class="fas fa-eye"></i>
                Afficher l'aperçu
            </button>
            <button class="menu-btn success" onclick="saveTemplate()" title="Sauvegarder">
                <i class="fas fa-save"></i>
                Sauvegarder
            </button>
        </div>
    </div>

    <!-- Container principal -->
    <div class="editor-container">
        <!-- Barre latérale gauche - Blocks & Templates -->
        <div class="sidebar-left">
            <div class="sidebar-header">
                <div class="sidebar-title" style="display:none;">
                    <i class="fas fa-cube"></i>
                    <span>Blocks Library</span>
                    <div class="sidebar-badge">PRO</div>
                </div>
                <button class="sidebar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            
            <div class="blocks-search-container">
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="blocks-search-input" 
                           id="blockSearch" 
                           placeholder="Search blocks, categories, tags...">
                    <button class="search-clear" onclick="clearSearch()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="blocks-quick-filters">
                    <button class="filter-chip active" data-filter="all">
                        <i class="fas fa-layer-group"></i>
                        <span>All</span>
                    </button>
                    <button class="filter-chip" data-filter="popular">
                        <i class="fas fa-fire"></i>
                        <span>Popular</span>
                    </button>
                    <button class="filter-chip" data-filter="free">
                        <i class="fas fa-bolt"></i>
                        <span>Free</span>
                    </button>
                    <button class="filter-chip" data-filter="responsive">
                        <i class="fas fa-mobile-alt"></i>
                        <span>Mobile</span>
                    </button>
                </div>
            </div>
            
            <div class="blocks-categories-nav">
                <div class="categories-scroll">
                    <!-- Les catégories seront générées dynamiquement -->
                </div>
                <button class="categories-more" onclick="showAllCategories()">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
            </div>
            
            <div class="blocks-content">
                <div class="blocks-stats-bar">
                    <div class="stat-item">
                        <div class="stat-value" id="blocksCount">0</div>
                        <div class="stat-label">Blocks</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value" id="freeCount">0</div>
                        <div class="stat-label">Free</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value" id="proCount">0</div>
                        <div class="stat-label">PRO</div>
                    </div>
                </div>
                
                <div class="blocks-grid-modern" id="blocksContainer">
                    <!-- Les blocs seront chargés dynamiquement -->
                </div>
                
                <div class="blocks-empty-state" id="blocksEmptyState" style="display: none;">
                    <div class="empty-icon">
                        <i class="fas fa-cubes"></i>
                    </div>
                    <h3>No blocks found</h3>
                    <p>Try adjusting your search or filters</p>
                    <button class="btn-primary" onclick="resetFilters()">
                        <i class="fas fa-redo"></i>
                        Reset Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Zone éditeur principale -->
        <div class="editor-main">
            <div id="gjs"></div>
        </div>

        <!-- Panneau droit amélioré -->
        <div class="sidebar-right" style="display:none;">
            <div class="right-panel-tabs">
                <button class="right-panel-tab active" onclick="showRightPanel('layers')">
                    <i class="fas fa-layer-group"></i> Layers
                </button>
                <button class="right-panel-tab" onclick="showRightPanel('history')">
                    <i class="fas fa-history"></i> History
                </button>
                <button class="right-panel-tab" onclick="showRightPanel('settings')">
                    <i class="fas fa-cog"></i> Settings
                </button>
            </div>
            
            <!-- Panneau Couches -->
            <div class="right-panel-content active" id="right-panel-layers">
                <div class="layers-container">
                    <div class="layers-list" id="layersList">
                        <!-- Les couches seront chargées dynamiquement -->
                    </div>
                </div>
            </div>
            
            <!-- Panneau Historique -->
            <div class="right-panel-content" id="right-panel-history">
                <div class="history-container">
                    <div class="history-list" id="historyList">
                        <!-- L'historique sera chargé dynamiquement -->
                    </div>
                </div>
            </div>
            
            <!-- Panneau Paramètres -->
            <div class="right-panel-content" id="right-panel-settings">
                <div class="settings-container">
                    <div class="settings-section">
                        <div class="settings-title">Canvas Settings</div>
                        <div class="settings-group">
                            <div class="setting-item">
                                <span class="setting-label">Show Grid</span>
                                <div class="setting-control">
                                    <label class="switch">
                                        <input type="checkbox" id="showGrid" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="setting-item">
                                <span class="setting-label">Show Outlines</span>
                                <div class="setting-control">
                                    <label class="switch">
                                        <input type="checkbox" id="showOutlines" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="setting-item">
                                <span class="setting-label">Canvas Width</span>
                                <div class="setting-control">
                                    <select class="control-select" id="canvasWidth">
                                        <option value="100%">100%</option>
                                        <option value="1200px">Desktop (1200px)</option>
                                        <option value="768px">Tablet (768px)</option>
                                        <option value="375px">Mobile (375px)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="settings-section">
                        <div class="settings-title">Editor Settings</div>
                        <div class="settings-group">
                            <div class="setting-item">
                                <span class="setting-label">Auto-save</span>
                                <div class="setting-control">
                                    <label class="switch">
                                        <input type="checkbox" id="autoSave">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="setting-item">
                                <span class="setting-label">Snap to Grid</span>
                                <div class="setting-control">
                                    <label class="switch">
                                        <input type="checkbox" id="snapToGrid">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="setting-item">
                                <span class="setting-label">Dark Mode</span>
                                <div class="setting-control">
                                    <label class="switch">
                                        <input type="checkbox" id="darkMode" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="settings-section">
                        <div class="settings-title">Export Settings</div>
                        <div class="settings-group">
                            <div class="setting-item">
                                <span class="setting-label">Format</span>
                                <div class="setting-control">
                                    <select class="control-select" id="exportFormat">
                                        <option value="html">HTML</option>
                                        <option value="react">React</option>
                                        <option value="vue">Vue</option>
                                    </select>
                                </div>
                            </div>
                            <div class="setting-item">
                                <span class="setting-label">Minify CSS</span>
                                <div class="setting-control">
                                    <label class="switch">
                                        <input type="checkbox" id="minifyCSS" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="setting-item">
                                <span class="setting-label">Minify HTML</span>
                                <div class="setting-control">
                                    <label class="switch">
                                        <input type="checkbox" id="minifyHTML">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Code -->
    <div id="codeModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fas fa-code"></i>
                    Generated Code
                </div>
                <button class="modal-close" onclick="closeModal('codeModal')">&times;</button>
            </div>
            <div class="modal-body code-modal-body">
                <div class="code-actions">
                    <button onclick="copyCode()" class="menu-btn">
                        <i class="fas fa-copy"></i> Copy Code
                    </button>
                </div>
                <textarea id="codeEditor" class="code-editor"></textarea>
            </div>
        </div>
    </div>

    <!-- Modal Preview -->
    <div id="previewModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fas fa-eye"></i>
                    Preview
                </div>
                <button class="modal-close" onclick="closeModal('previewModal')">&times;</button>
            </div>
            <div class="modal-body">
                <iframe id="previewFrame" class="preview-frame"></iframe>
            </div>
            <div class="preview-modal-footer">
                <button class="preview-fullscreen-btn" onclick="showPreviewInNewTab()">
                    <i class="fas fa-external-link-alt"></i>
                    Open in New Tab
                </button>
            </div>
        </div>
    </div>

    <!-- Clear Canvas Confirmation Modal -->
<div class="modal fade" id="clearCanvasModal" tabindex="-1" aria-labelledby="clearCanvasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clearCanvasModalLabel">Clear Canvas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to clear the canvas? All your current work will be lost.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmClearCanvas">Clear Canvas</button>
            </div>
        </div>
    </div>
</div>

    <!-- Notifications -->
    <div id="notifications"></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Scripts CDN -->
    <script src="https://unpkg.com/grapesjs"></script>
    <script src="https://unpkg.com/grapesjs-preset-webpage"></script>
    <script src="https://unpkg.com/grapesjs-blocks-basic"></script>
    <script src="https://unpkg.com/grapesjs-plugin-forms"></script>
    <script src="https://unpkg.com/grapesjs-tabs"></script>
    <script src="https://unpkg.com/grapesjs-custom-code"></script>
    <script src="https://unpkg.com/grapesjs-tooltip"></script>
    <!-- Add to your head section -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
    <!-- Script principal -->
    <script>
        // === CONFIGURATION ===
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let editor;
        window.currentTemplateId = null;
        let allBlocks = [];
        let allSections = [];
        let dropIndicator = null;

        // === INITIALISATION DE L'ÉDITEUR ===
function initEditor() {
    // Attendre que l'élément #gjs soit disponible dans le DOM
    if (!document.getElementById('gjs')) {
        console.error('Element #gjs not found in DOM');
        setTimeout(initEditor, 100); // Réessayer après 100ms
        return;
    }
    
    console.log('Initializing GrapesJS editor...');
    
    editor = grapesjs.init({
        container: '#gjs',
        height: '100%',
        fromElement: true,
        storageManager: false,
        
        plugins: [
            'grapesjs-preset-webpage',
            'grapesjs-blocks-basic',
            'grapesjs-plugin-forms',
            'grapesjs-tabs',
            'grapesjs-custom-code'
        ],
        
        pluginsOpts: {
            'grapesjs-preset-webpage': {
                blocks: []
            }
        },
        
        styleManager: {
            sectors: [
                {
                    name: 'General',
                    open: false,
                    properties: [
                        'display', 'position', 'float', 'top',
                        'right', 'left', 'bottom'
                    ]
                },
                {
                    name: 'Dimension',
                    open: false,
                    properties: [
                        'width', 'height', 'max-width', 'min-height',
                        'margin', 'padding'
                    ]
                },
                {
                    name: 'Typography',
                    open: false,
                    properties: [
                        'font-family', 'font-size', 'font-weight',
                        'letter-spacing', 'color', 'line-height',
                        'text-align', 'text-shadow'
                    ]
                },
                {
                    name: 'Decorations',
                    open: false,
                    properties: [
                        'border-radius', 'border', 'box-shadow',
                        'background', 'opacity'
                    ]
                },
                {
                    name: 'Extra',
                    open: false,
                    properties: [
                        'transition', 'transform', 'cursor',
                        'overflow', 'z-index'
                    ]
                }
            ]
        },
        
        deviceManager: {
            devices: [
                {
                    name: 'Desktop',
                    width: ''
                },
                {
                    name: 'Tablet',
                    width: '768px',
                    widthMedia: '768px'
                },
                {
                    name: 'Mobile',
                    width: '320px',
                    widthMedia: '480px'
                }
            ]
        },
        
        canvas: {
            styles: [
                'https://unpkg.com/grapesjs/dist/css/grapes.min.css'
            ]
        }
    });

    
    // Initialiser le panneau couches
    initLayersPanel();
    
    // Initialiser les événements de l'éditeur
    initEditorEvents();
    
    // Attendre que GrapesJS soit complètement initialisé avant d'initialiser le drag and drop
    setTimeout(() => {
        if (editor && editor.Canvas) {
            initCustomDragDrop();
        } else {
            console.error('GrapesJS not fully initialized, retrying drag drop init...');
            setTimeout(initCustomDragDrop, 500);
        }
    }, 300);
    
    // Récupérer l'ID du template depuis l'URL
    const templateIdFromURL = getTemplateIdFromURL();
    console.log('Template ID from URL:', templateIdFromURL);
    
    if (templateIdFromURL) {
        window.currentTemplateId = templateIdFromURL;
        console.log('Setting currentTemplateId to:', window.currentTemplateId);

        
    // Initialiser les blocs avec l'interface moderne
    initBlocksModern();
        
        // Attendre que l'éditeur soit complètement initialisé avant de charger
        setTimeout(() => {
            if (editor) {
                loadTemplateOnStart(window.currentTemplateId);
            } else {
                console.error('Editor not initialized, cannot load template');
            }
        }, 800);
    } else {
        console.log('No template ID found, using default content');
        // Attendre que l'éditeur soit initialisé
        setTimeout(() => {
            if (editor) {
                editor.setComponents(`
                    <section style="padding: 100px 20px; background: linear-gradient(135deg, #0f172a, #1e293b); color: white; text-align: center;">
                        <div style="max-width: 800px; margin: 0 auto;">
                            <h1 style="font-size: 3rem; margin-bottom: 20px; background: linear-gradient(135deg, #8b5cf6, #3b82f6); -webkit-background-clip: text; background-clip: text; color: transparent;">
                                Welcome to Web Page Builder
                            </h1>
                            <p style="font-size: 1.2rem; margin-bottom: 40px; opacity: 0.9;">
                                Drag and drop blocks from the left panel to start building your page. Save your designs as templates for later use.
                            </p>
                        </div>
                    </section>
                `);
            }
        }, 800);
    }
    
    showNotification('Editor ready! Start building your website.', 'info');
}

       // === FONCTIONS DE GESTION DES TEMPLATES ===
       async function loadTemplateOnStart(templateId) {
    try {
        console.log('Loading template with ID:', templateId);
        showLoading('Loading template...');
        
        const response = await fetch(`/api/templates/${templateId}`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        console.log('Template API response:', data);
        
        // CORRECTION ICI : Utiliser data.data au lieu de data.template
        if (data.success && data.data) {
            // Charger le HTML et CSS du template
            const htmlContent = data.data.html_content || '';
            const cssContent = data.data.css_content || '';
            
            console.log('HTML content length:', htmlContent.length);
            console.log('CSS content length:', cssContent.length);
            
            if (htmlContent.trim()) {
                // Nettoyer le contenu HTML des échappements
                let cleanHtml = htmlContent
                    .replace(/\\r\\n/g, '\n')
                    .replace(/\\n/g, '\n')
                    .replace(/\\t/g, '\t')
                    .replace(/\\"/g, '"')
                    .replace(/\\'/g, "'")
                    .replace(/\\\\/g, '\\');
                
                // Nettoyer le CSS
                let cleanCss = cssContent
                    .replace(/\\r\\n/g, '\n')
                    .replace(/\\n/g, '\n')
                    .replace(/\\t/g, '\t')
                    .replace(/\\"/g, '"')
                    .replace(/\\'/g, "'")
                    .replace(/\\\\/g, '\\');
                
                console.log('Setting components to editor...');
                
                // Vider d'abord l'éditeur
                editor.setComponents('');
                
                // Définir les composants avec HTML et CSS
                if (cleanCss.trim()) {
                    editor.setComponents(cleanHtml + '<style>' + cleanCss + '</style>');
                } else {
                    editor.setComponents(cleanHtml);
                }
                
                // Définir également le CSS séparément
                if (cleanCss.trim()) {
                    editor.setStyle(cleanCss);
                }
                
                console.log('Template loaded successfully');
            } else {
                console.log('Template HTML is empty');
            }
            
            // Stocker l'ID du template pour la sauvegarde
            window.currentTemplateId = templateId;
            
            // Mettre à jour le titre de la page
            if (data.data.name) {
                document.title = `${data.data.name} - Web Page Builder`;
            }
            
            // Mettre à jour les couches
            updateLayersPanel();
            
            showNotification(`Template "${data.data.name || 'Unnamed'}" loaded`, 'success');
        } else {
            throw new Error(data.message || 'Failed to load template: Invalid response');
        }
    } catch (error) {
        console.error('Error loading template:', error);
        showNotification('Error loading template: ' + error.message, 'error');
        
        // Charger le contenu par défaut en cas d'erreur
        editor.setComponents(`
            <section style="padding: 100px 20px; background: linear-gradient(135deg, #0f172a, #1e293b); color: white; text-align: center;">
                <div style="max-width: 800px; margin: 0 auto;">
                    <h1 style="font-size: 3rem; margin-bottom: 20px; background: linear-gradient(135deg, #8b5cf6, #3b82f6); -webkit-background-clip: text; background-clip: text; color: transparent;">
                        Error Loading Template
                    </h1>
                    <p style="font-size: 1.2rem; margin-bottom: 40px; opacity: 0.9;">
                        Could not load template. Starting with blank canvas.
                    </p>
                </div>
            </section>
        `);
    } finally {
        hideLoading();
    }
}


       async function saveTemplate() {
    try {
        // DEBUG: Vérifier si l'ID est bien défini
        console.log('Current template ID before save:', window.currentTemplateId);
        console.log('URL:', window.location.href);
        
        if (!window.currentTemplateId) {
            // Réessayer de récupérer l'ID depuis l'URL
            window.currentTemplateId = getTemplateIdFromURL();
            console.log('Re-fetched template ID:', window.currentTemplateId);
            
            if (!window.currentTemplateId) {
                showNotification('No template ID found. Cannot save.', 'error');
                return;
            }
        }
        
        showLoading('Saving template...');
        
        // Récupérer le HTML et CSS de l'éditeur
        const htmlContent = editor.getHtml();
        const cssContent = editor.getCss();
        
        // DEBUG: Voir ce qu'on envoie
        console.log('Saving template ID:', window.currentTemplateId);
        console.log('HTML length:', htmlContent.length);
        console.log('CSS length:', cssContent.length);
        
        // Préparer les données
        const formData = {
            html_content: htmlContent,
            css_content: cssContent,
            template_id: window.currentTemplateId
        };
        
        const response = await fetch('/templates/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN
            },
            body: JSON.stringify(formData)
        });
        
        const data = await response.json();
        hideLoading();
        
        if (data.success) {
            showNotification('Template updated successfully!', 'success');
        } else {
            throw new Error(data.message || 'Failed to save template');
        }
    } catch (error) {
        console.error('Error saving template:', error);
        hideLoading();
        showNotification('Error saving template: ' + error.message, 'error');
    }
}

        // === FONCTION POUR RÉCUPÉRER L'ID DU TEMPLATE DEPUIS L'URL ===
function getTemplateIdFromURL() {
    const url = window.location.pathname;
    console.log('Getting template ID from URL:', url);
    
    // Essayer d'abord avec "templates" (au pluriel) - le plus commun
    const pattern1 = /\/templates\/edit\/(\d+)/;
    const match1 = url.match(pattern1);
    
    if (match1 && match1[1]) {
        console.log('Template ID found (pluriel):', match1[1]);
        return parseInt(match1[1]);
    }
    
    // Essayer avec "template" (au singulier)
    const pattern2 = /\/template\/edit\/(\d+)/;
    const match2 = url.match(pattern2);
    
    if (match2 && match2[1]) {
        console.log('Template ID found (singulier):', match2[1]);
        return parseInt(match2[1]);
    }
    
    // Essayer aussi dans les paramètres GET
    const urlParams = new URLSearchParams(window.location.search);
    const templateIdParam = urlParams.get('template_id');
    if (templateIdParam) {
        console.log('Template ID found in query params:', templateIdParam);
        return parseInt(templateIdParam);
    }
    
    console.log('No template ID found in URL');
    return null;
}
        // === FONCTION PREVIEW DANS UN NOUVEL ONGLET ===
        function showPreviewInNewTab() {
            const html = editor.getHtml();
            const css = editor.getCss();
            
            // Créer le HTML complet
            const fullHtml = `<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview - Web Page Builder</title>
    <style>
        ${css}
        
        /* Styles de base pour la prévisualisation */
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: #f8fafc;
        }
        
        .preview-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .preview-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .preview-header h1 {
            color: #1e293b;
            margin: 0;
        }
        
        .preview-note {
            background: #f1f5f9;
            padding: 10px;
            border-radius: 6px;
            margin-top: 10px;
            font-size: 14px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="preview-container">
        <div class="preview-header">
            <h1><i class="fas fa-eye"></i> Preview Mode</h1>
            <div class="preview-note">
                This is a preview of your page. Changes are not saved automatically.
            </div>
        </div>
        ${html}
    </div>
    
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>`;
            
            // Ouvrir dans un nouvel onglet
            const newTab = window.open();
            newTab.document.open();
            newTab.document.write(fullHtml);
            newTab.document.close();
        }

        // === FONCTION PREVIEW DANS MODAL (alternative) ===
        function showPreviewInModal() {
            const html = editor.getHtml();
            const css = editor.getCss();
            
            const previewFrame = document.getElementById('previewFrame');
            if (previewFrame) {
                const previewDoc = previewFrame.contentDocument || previewFrame.contentWindow.document;
                previewDoc.open();
                previewDoc.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Preview</title>
                        <style>${css}</style>
                    </head>
                    <body style="margin: 0; padding: 20px; background: #f8fafc;">${html}</body>
                    </html>
                `);
                previewDoc.close();
                
                const modal = document.getElementById('previewModal');
                if (modal) {
                    modal.style.display = 'block';
                }
            }
        }

        // === DRAG AND DROP PERSONNALISÉ ===
        function initCustomDragDrop() {
    // Vérifier que l'éditeur et le Canvas sont bien initialisés
    if (!editor || !editor.Canvas) {
        console.error('Editor or Canvas not initialized, retrying in 500ms...');
        setTimeout(initCustomDragDrop, 500);
        return;
    }
    
    try {
        // ESSAYER DIFFÉRENTES MÉTHODES POUR OBTENIR LE CANVAS
        let canvas = null;
        
        // Méthode 1: getFrameEl()
        if (editor.Canvas.getFrameEl) {
            canvas = editor.Canvas.getFrameEl();
        }
        
        // Méthode 2: getWindow() puis document
        if (!canvas && editor.Canvas.getWindow) {
            const win = editor.Canvas.getWindow();
            if (win && win.document) {
                canvas = win.document.body;
            }
        }
        
        // Méthode 3: Accéder directement via l'iframe
        if (!canvas) {
            const iframe = document.querySelector('.gjs-frame');
            if (iframe && iframe.contentDocument) {
                canvas = iframe.contentDocument.body;
            }
        }
        
        // Méthode 4: Chercher dans le DOM
        if (!canvas) {
            const frame = document.querySelector('#gjs iframe, .gjs-frame');
            if (frame && frame.contentDocument) {
                canvas = frame.contentDocument.body;
            }
        }
        
        if (!canvas) {
            console.error('Canvas element not found, trying alternative approaches...');
            console.log('Editor Canvas object:', editor.Canvas);
            
            // Essayer de trouver le canvas par ses propriétés
            for (let key in editor.Canvas) {
                if (typeof editor.Canvas[key] === 'function') {
                    console.log('Canvas method:', key);
                }
            }
            
            setTimeout(initCustomDragDrop, 500);
            return;
        }
        
        console.log('Canvas found:', canvas);
        
        // Créer l'indicateur de drop
        dropIndicator = document.createElement('div');
        dropIndicator.className = 'drop-indicator';
        dropIndicator.style.display = 'none';
        
        // Ajouter au parent du canvas ou directement au body
        const canvasContainer = document.querySelector('.gjs-editor-cont');
        if (canvasContainer) {
            canvasContainer.appendChild(dropIndicator);
        } else {
            document.body.appendChild(dropIndicator);
        }
        
        // Événements pour le canvas
        canvas.addEventListener('dragover', handleCanvasDragOver);
        canvas.addEventListener('dragleave', handleCanvasDragLeave);
        canvas.addEventListener('drop', handleCanvasDrop);
        
        console.log('Custom drag and drop initialized successfully');
        
        // Aussi ajouter les événements à l'iframe si nécessaire
        const iframe = document.querySelector('#gjs iframe, .gjs-frame');
        if (iframe) {
            iframe.addEventListener('dragover', handleCanvasDragOver);
            iframe.addEventListener('dragleave', handleCanvasDragLeave);
            iframe.addEventListener('drop', handleCanvasDrop);
        }
        
    } catch (error) {
        console.error('Error initializing custom drag and drop:', error);
        setTimeout(initCustomDragDrop, 500);
    }
}

        function handleCanvasDragOver(e) {
    e.preventDefault();
    e.stopPropagation();
    
    if (!dropIndicator) return false;
    
    // Chercher le conteneur de l'éditeur
    const editorContainer = document.querySelector('.gjs-editor-cont') || document.querySelector('#gjs');
    if (!editorContainer) return false;
    
    const rect = editorContainer.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    
    // Trouver l'élément le plus proche
    const target = document.elementFromPoint(e.clientX, e.clientY);
    const closestComponent = findClosestComponent(target);
    
    if (closestComponent && closestComponent !== editorContainer) {
        const componentRect = closestComponent.getBoundingClientRect();
        const relativeY = e.clientY - componentRect.top;
        const isBefore = relativeY < componentRect.height / 2;
        
        // Positionner l'indicateur
        dropIndicator.style.display = 'block';
        dropIndicator.style.width = componentRect.width + 'px';
        dropIndicator.style.left = (componentRect.left - rect.left) + 'px';
        
        if (isBefore) {
            dropIndicator.style.top = (componentRect.top - rect.top - 1) + 'px';
            dropIndicator.className = 'drop-indicator before';
        } else {
            dropIndicator.style.top = (componentRect.bottom - rect.top - 1) + 'px';
            dropIndicator.className = 'drop-indicator after';
        }
        
        dropIndicator.dataset.targetId = closestComponent.id || '';
        dropIndicator.dataset.position = isBefore ? 'before' : 'after';
    } else {
        // Si aucun composant n'est proche, placer à la fin
        dropIndicator.style.display = 'none';
    }
    
    return false;
}

function handleCanvasDragLeave(e) {
    e.preventDefault();
    e.stopPropagation();
    if (dropIndicator) {
        dropIndicator.style.display = 'none';
    }
    return false;
}

async function handleCanvasDrop(e) {
    e.preventDefault();
    e.stopPropagation();
    
    if (dropIndicator) {
        dropIndicator.style.display = 'none';
    }
    
    // ESSAYER D'ABORD DE LIRE LE HTML DIRECTEMENT
    let blockHtml = e.dataTransfer.getData('text/html');
    const blockId = e.dataTransfer.getData('block-id');
    
    // Si pas de HTML dans 'text/html', essayer 'text/plain'
    if (!blockHtml || blockHtml.trim() === '') {
        blockHtml = e.dataTransfer.getData('text/plain');
    }
    
    if (blockHtml && blockHtml.trim()) {
        // Ajouter le bloc à l'éditeur
        if (dropIndicator && dropIndicator.dataset.targetId && dropIndicator.dataset.position) {
            // Logique d'insertion à une position spécifique
            const targetId = dropIndicator.dataset.targetId;
            const position = dropIndicator.dataset.position;
            
            // Ici vous devrez implémenter la logique d'insertion spécifique
            // Pour l'instant, ajouter simplement à la fin
            editor.addComponents(blockHtml);
        } else {
            // Ajouter à la fin
            editor.addComponents(blockHtml);
        }
        
        // Incrémenter l'utilisation si on a l'ID
        if (blockId) {
            updateBlockUsage(parseInt(blockId));
        }
        
        showNotification('Block added successfully', 'success');
    } else {
        showNotification('Could not add block: No valid HTML found', 'error');
    }
    
    return false;
}

        function findClosestComponent(element) {
            while (element && element !== document) {
                if (element.classList && element.classList.contains('gjs-comp-selected')) {
                    return element;
                }
                element = element.parentElement;
            }
            return null;
        }

        // === FONCTIONS POUR L'INTERFACE MODERNE ===
        async function loadBlocksModern(templateId) {
            try {
                showLoading('Loading blocks library...');
                
                 console.log('Fetching blocks from API with templateId:', templateId);
        
        // MODIFIER L'URL POUR GÉRER LE CAS NULL
        let apiUrl = '/api/blocks/data';
        
        // Ajouter le paramètre template_id seulement s'il n'est pas null
        if (templateId) {
            apiUrl += '?template_id=' + templateId;
        }
        
        console.log('Fetching blocks from:', apiUrl);
        
        const response = await fetch(apiUrl);
                
                if (!response.ok) {
                    throw new Error(`API Error: ${response.status}`);
                }
                
                const responseText = await response.text();
                
                // Vérifier si c'est du HTML (erreur)
                if (responseText.trim().startsWith('<!DOCTYPE') || 
                    responseText.trim().startsWith('<!--') || 
                    responseText.includes('<html')) {
                    console.error('Server returned HTML instead of JSON:', responseText.substring(0, 200));
                    throw new Error('API returned HTML instead of JSON. Check your routes.');
                }
                
                // Parser le JSON
                let data;
                try {
                    data = JSON.parse(responseText);
                } catch (parseError) {
                    console.error('JSON parse error:', parseError);
                    console.error('Response text:', responseText.substring(0, 500));
                    throw new Error('Invalid JSON response from server');
                }
                
                console.log('API response data:', data);
                
                if (data.success) {
                    allBlocks = data.blocks || [];
                    allSections = data.sections || [];
                    
                    console.log(`Loaded ${allBlocks.length} blocks and ${allSections.length} sections`);
                    
                    // Mettre à jour les statistiques
                    updateStats(allBlocks);
                    
                    // Afficher les catégories
                    renderCategories(allSections, allBlocks);
                    
                    // Afficher les blocs
                    renderBlocksModern(allBlocks);
                    
                    // Initialiser les filtres
                    initModernFilters();
                    
                    hideLoading();
                    showNotification(`Loaded ${allBlocks.length} blocks`, 'success');
                    
                } else {
                    throw new Error(data.message || 'Failed to load blocks');
                }
            } catch (error) {
                console.error('Error loading blocks:', error);
                hideLoading();
                showNotification('Error loading blocks: ' + error.message, 'error');
                renderEmptyState();
            }
        }

        function updateStats(blocks) {
            const total = blocks.length;
            const free = blocks.filter(b => b.is_free).length;
            const pro = total - free;
            
            const blocksCount = document.getElementById('blocksCount');
            const freeCount = document.getElementById('freeCount');
            const proCount = document.getElementById('proCount');
            
            if (blocksCount) blocksCount.textContent = total;
            if (freeCount) freeCount.textContent = free;
            if (proCount) proCount.textContent = pro;
        }

        function renderCategories(sections, blocks) {
            const container = document.querySelector('.categories-scroll');
            if (!container) return;
            
            container.innerHTML = '';
            
            // Ajouter "Tous"
            const allCount = blocks.length;
            const allButton = createCategoryTab('all', 'All Blocks', 'fa-layer-group', allCount, true);
            container.appendChild(allButton);
            
            // Ajouter chaque section
            sections.forEach(section => {
                const sectionBlocks = blocks.filter(b => b.section_id === section.id);
                if (sectionBlocks.length > 0) {
                    const button = createCategoryTab(
                        section.slug,
                        section.name,
                        section.icon || 'fa-folder',
                        sectionBlocks.length,
                        false
                    );
                    container.appendChild(button);
                }
            });
            
            // Ajouter catégories par type de site
            const websiteTypes = [...new Set(blocks.map(b => b.website_type))];
            websiteTypes.forEach(type => {
                const typeBlocks = blocks.filter(b => b.website_type === type);
                if (typeBlocks.length > 0 && type !== 'General') {
                    const icon = getWebsiteTypeIcon(type);
                    const button = createCategoryTab(
                        `type-${type.toLowerCase()}`,
                        type,
                        icon,
                        typeBlocks.length,
                        false
                    );
                    container.appendChild(button);
                }
            });
            
            // Initialiser les événements
            initCategoryEvents();
        }

        function createCategoryTab(id, name, icon, count, isActive) {
            const button = document.createElement('button');
            button.className = `category-tab ${isActive ? 'active' : ''}`;
            button.dataset.category = id;
            button.innerHTML = `
                <i class="fas ${icon}"></i>
                <span>${name}</span>
                <span class="category-count">${count}</span>
            `;
            return button;
        }

        function getWebsiteTypeIcon(type) {
            const icons = {
                'SaaS': 'fa-cloud',
                'Ecommerce': 'fa-shopping-cart',
                'Portfolio': 'fa-briefcase',
                'Restaurant': 'fa-utensils',
                'Blog': 'fa-blog',
                'Corporate': 'fa-building',
                'Landing': 'fa-flag',
                'Dashboard': 'fa-chart-line',
                'Editor': 'fa-edit',
                'General': 'fa-globe'
            };
            return icons[type] || 'fa-globe';
        }

        function initCategoryEvents() {
            document.querySelectorAll('.category-tab').forEach(tab => {
                tab.addEventListener('click', () => {
                    // Retirer active de tous
                    document.querySelectorAll('.category-tab').forEach(t => {
                        t.classList.remove('active');
                    });
                    
                    // Ajouter active au cliqué
                    tab.classList.add('active');
                    
                    // Filtrer les blocs
                    const category = tab.dataset.category;
                    filterBlocksByCategory(category);
                });
            });
        }

        function filterBlocksByCategory(category) {
            const blocksGrid = document.getElementById('blocksContainer');
            if (!blocksGrid) return;
            
            const allBlockCards = document.querySelectorAll('.block-card-modern');
            
            allBlockCards.forEach(card => {
                if (category === 'all') {
                    card.style.display = 'block';
                } else if (category.startsWith('type-')) {
                    const type = category.replace('type-', '');
                    const blockType = card.dataset.websiteType || '';
                    card.style.display = blockType.toLowerCase() === type.toLowerCase() ? 'block' : 'none';
                } else {
                    const blockSection = card.dataset.section || '';
                    card.style.display = blockSection === category ? 'block' : 'none';
                }
                
                // Animation de transition
                card.style.opacity = '0';
                card.style.transform = 'translateY(10px)';
                
                setTimeout(() => {
                    if (card.style.display !== 'none') {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }
                }, 10);
            });
            
            // Vérifier si aucun bloc n'est visible
            const visibleBlocks = Array.from(allBlockCards).filter(b => b.style.display !== 'none');
            const emptyState = document.getElementById('blocksEmptyState');
            
            if (visibleBlocks.length === 0 && emptyState) {
                emptyState.style.display = 'block';
                blocksGrid.style.display = 'none';
            } else {
                if (emptyState) emptyState.style.display = 'none';
                blocksGrid.style.display = 'grid';
            }
        }

        function renderBlocksModern(blocks) {
            const container = document.getElementById('blocksContainer');
            if (!container) return;
            
            container.innerHTML = '';
            
            if (!blocks || blocks.length === 0) {
                renderEmptyState();
                return;
            }
            
            // Trier par popularité (usage_count)
            const sortedBlocks = [...blocks].sort((a, b) => (b.usage_count || 0) - (a.usage_count || 0));
            
            sortedBlocks.forEach((block, index) => {
                const card = createBlockCardModern(block, index);
                container.appendChild(card);
            });
        }

        function createBlockCardModern(block, index) {
            const card = document.createElement('div');
            card.className = 'block-card-modern';
            card.dataset.blockId = block.id;
            card.dataset.section = block.section_slug || 'general';
            card.dataset.websiteType = block.website_type || 'General';
            card.dataset.category = block.category || 'Basic';
            card.style.animationDelay = `${index * 0.05}s`;
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            // Animation d'entrée
            setTimeout(() => {
                card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 50);
            
            // Créer la description courte
            const shortDesc = block.description 
                ? block.description.substring(0, 60) + (block.description.length > 60 ? '...' : '')
                : 'No description';
            
            // Déterminer les badges
            const categoryBadge = `<span class="block-badge badge-category">${block.category || 'Basic'}</span>`;
            const proBadge = !block.is_free ? '<span class="block-badge badge-pro">PRO</span>' : '';
            const freeBadge = block.is_free ? '<span class="block-badge badge-free">Free</span>' : '';
            const usageBadge = block.usage_count > 0 ? 
                `<span class="block-badge badge-usage"><i class="fas fa-download"></i> ${block.usage_count}</span>` : '';
            
            card.innerHTML = `
                <div class="block-icon-modern">
                    <i class="fas ${block.icon || 'fa-cube'}"></i>
                </div>
                <div class="block-name">${block.name}</div>
                <div class="block-description">${shortDesc}</div>
                <div class="block-meta-modern">
                    ${categoryBadge}
                    ${proBadge}
                    ${freeBadge}
                    ${usageBadge}
                </div>
                <div class="block-stats">
                    ${block.is_responsive ? 
                        '<div class="block-stat" title="Responsive"><i class="fas fa-mobile-alt"></i></div>' : ''}
                    ${block.views_count > 0 ? 
                        `<div class="block-stat" title="${block.views_count} views">
                            <i class="fas fa-eye"></i>
                        </div>` : ''}
                </div>
            `;
            
            // Drag and drop
            card.draggable = true;
            
            card.addEventListener('dragstart', (e) => {
                // Préparer le HTML COMPLET avec le CSS
                let blockHtml = '';
                
                if (block.html_content) {
                    // D'abord, nettoyer le HTML des caractères d'échappement
                    let cleanHtml = block.html_content
                        .replace(/\\r\\n/g, '\n')
                        .replace(/\\n/g, '\n')
                        .replace(/\\t/g, '\t')
                        .replace(/\\"/g, '"');
                    
                    // Ajouter le CSS dans une balise style si présent
                    if (block.css_content && block.css_content.trim()) {
                        let cleanCss = block.css_content
                            .replace(/\\r\\n/g, '\n')
                            .replace(/\\n/g, '\n')
                            .replace(/\\t/g, '\t')
                            .replace(/\\"/g, '"');
                        
                        blockHtml = cleanHtml + '\n<style>\n' + cleanCss + '\n</style>';
                    } else {
                        blockHtml = cleanHtml;
                    }
                }
                
                // ENVOYER DIRECTEMENT LE HTML, pas du JSON
                e.dataTransfer.setData('text/html', blockHtml);
                e.dataTransfer.setData('text/plain', blockHtml); // Backup au cas où
                
                // Stocker l'ID séparément si besoin pour le suivi d'utilisation
                e.dataTransfer.setData('block-id', block.id.toString());
                
                e.dataTransfer.effectAllowed = 'copy';
                card.classList.add('dragging');
                
                // Effet visuel pendant le drag
                e.dataTransfer.setDragImage(card, 75, 75);
                
                // Animation de prise
                card.style.transform = 'scale(0.95) rotate(2deg)';
                card.style.boxShadow = '0 30px 60px rgba(0, 0, 0, 0.5)';
            });
            
            card.addEventListener('dragend', () => {
                card.classList.remove('dragging');
                card.style.transform = '';
                card.style.boxShadow = '';
            });
            
            // Clic pour ajouter
            card.addEventListener('click', async (e) => {
                if (!e.target.closest('.block-badge')) {
                    await addBlockToEditor(block.id);
                    // Effet visuel
                    card.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        card.style.transform = '';
                    }, 200);
                }
            });
            
            // Animation au survol
            card.addEventListener('mouseenter', () => {
                const icon = card.querySelector('.block-icon-modern i');
                if (icon) {
                    icon.style.transform = 'rotate(10deg) scale(1.1)';
                }
                card.style.zIndex = '10';
            });
            
            card.addEventListener('mouseleave', () => {
                const icon = card.querySelector('.block-icon-modern i');
                if (icon) {
                    icon.style.transform = '';
                }
                card.style.zIndex = '1';
            });
            
            return card;
        }

        async function updateBlockUsage(blockId) {
            try {
                const response = await fetch('/api/blocks/add-to-editor', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify({ block_id: blockId })
                });
                
                const data = await response.json();
                if (data.success) {
                    // Mettre à jour le compteur dans l'interface
                    updateBlockUsageInUI(blockId);
                }
            } catch (error) {
                console.error('Error updating block usage:', error);
            }
        }

        function initModernFilters() {
            // Recherche
            const searchInput = document.getElementById('blockSearch');
            if (searchInput) {
                searchInput.addEventListener('input', debounce((e) => {
                    filterBlocksBySearch(e.target.value);
                }, 300));
            }
            
            // Bouton clear search
            const clearBtn = document.querySelector('.search-clear');
            if (clearBtn) {
                clearBtn.addEventListener('click', clearSearch);
            }
            
            // Filtres rapides
            document.querySelectorAll('.filter-chip').forEach(chip => {
                chip.addEventListener('click', () => {
                    // Toggle active
                    if (chip.classList.contains('active')) {
                        chip.classList.remove('active');
                        filterByQuickFilter('all');
                    } else {
                        document.querySelectorAll('.filter-chip').forEach(c => {
                            c.classList.remove('active');
                        });
                        chip.classList.add('active');
                        filterByQuickFilter(chip.dataset.filter);
                    }
                });
            });
        }

        function filterBlocksBySearch(term) {
            const cards = document.querySelectorAll('.block-card-modern');
            const emptyState = document.getElementById('blocksEmptyState');
            const blocksGrid = document.getElementById('blocksContainer');
            
            // Afficher/masquer le bouton clear
            const clearBtn = document.querySelector('.search-clear');
            if (clearBtn) {
                clearBtn.style.display = term ? 'block' : 'none';
            }
            
            let visibleCount = 0;
            
            cards.forEach(card => {
                const name = card.querySelector('.block-name').textContent.toLowerCase();
                const desc = card.querySelector('.block-description').textContent.toLowerCase();
                const category = card.dataset.category.toLowerCase();
                const websiteType = card.dataset.websiteType.toLowerCase();
                
                const matches = name.includes(term.toLowerCase()) || 
                               desc.includes(term.toLowerCase()) || 
                               category.includes(term.toLowerCase()) ||
                               websiteType.includes(term.toLowerCase());
                
                if (matches) {
                    card.style.display = 'block';
                    visibleCount++;
                    
                    // Animation d'apparition
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(10px)';
                    
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 10);
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Afficher/masquer l'état vide
            if (emptyState && blocksGrid) {
                if (visibleCount === 0) {
                    emptyState.style.display = 'block';
                    blocksGrid.style.display = 'none';
                } else {
                    emptyState.style.display = 'none';
                    blocksGrid.style.display = 'grid';
                }
            }
        }

        function filterByQuickFilter(filter) {
            const cards = document.querySelectorAll('.block-card-modern');
            
            cards.forEach(card => {
                switch(filter) {
                    case 'all':
                        card.style.display = 'block';
                        break;
                    case 'popular':
                        const usageElement = card.querySelector('.badge-usage');
                        const usageText = usageElement ? usageElement.textContent : '';
                        const usageMatch = usageText.match(/\d+/);
                        const usage = usageMatch ? parseInt(usageMatch[0]) : 0;
                        card.style.display = usage > 5 ? 'block' : 'none';
                        break;
                    case 'free':
                        const hasFreeBadge = card.querySelector('.badge-free');
                        card.style.display = hasFreeBadge ? 'block' : 'none';
                        break;
                    case 'responsive':
                        const hasMobileIcon = card.querySelector('.block-stat .fa-mobile-alt');
                        card.style.display = hasMobileIcon ? 'block' : 'none';
                        break;
                }
                
                // Animation
                if (card.style.display !== 'none') {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(10px)';
                    
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 10);
                }
            });
        }

        function renderEmptyState() {
            const container = document.getElementById('blocksContainer');
            const emptyState = document.getElementById('blocksEmptyState');
            
            if (container) {
                container.style.display = 'none';
            }
            
            if (emptyState) {
                emptyState.style.display = 'block';
            }
        }

        function clearSearch() {
            const searchInput = document.getElementById('blockSearch');
            if (searchInput) {
                searchInput.value = '';
                filterBlocksBySearch('');
                searchInput.focus();
            }
        }

        function resetFilters() {
            // Réinitialiser la recherche
            clearSearch();
            
            // Réinitialiser les filtres rapides
            document.querySelectorAll('.filter-chip').forEach(chip => {
                chip.classList.remove('active');
            });
            const allChip = document.querySelector('.filter-chip[data-filter="all"]');
            if (allChip) allChip.classList.add('active');
            
            // Réinitialiser les catégories
            document.querySelectorAll('.category-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            const allTab = document.querySelector('.category-tab[data-category="all"]');
            if (allTab) allTab.classList.add('active');
            
            // Afficher tous les blocs
            filterBlocksByCategory('all');
            filterByQuickFilter('all');
        }

        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar-left');
            const toggleBtn = document.querySelector('.sidebar-toggle i');
            
            if (!sidebar || !toggleBtn) return;
            
            if (sidebar.classList.contains('collapsed')) {
                sidebar.classList.remove('collapsed');
                sidebar.style.width = '380px';
                toggleBtn.className = 'fas fa-chevron-left';
                
                // Réanimer les blocs
                setTimeout(() => {
                    const cards = document.querySelectorAll('.block-card-modern');
                    cards.forEach((card, index) => {
                        card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(10px)';
                        
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, index * 30);
                    });
                }, 300);
            } else {
                sidebar.classList.add('collapsed');
                sidebar.style.width = '60px';
                toggleBtn.className = 'fas fa-chevron-right';
            }
        }

        // === FONCTIONS DE GESTION DES BLOCS ===
        async function addBlockToEditor(blockId) {
            try {
                showLoading('Adding block...');
                
                const response = await fetch('/api/blocks/add-to-editor', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify({ block_id: blockId })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Créer le HTML complet avec CSS
                    let fullHtml = data.block.html;
                    if (data.block.css && data.block.css.trim()) {
                        fullHtml = data.block.html + '\n<style>\n' + data.block.css + '\n</style>';
                    }
                    
                    // Ajouter au canvas
                    editor.addComponents(fullHtml);
                    
                    // Ajouter le JS si disponible
                    if (data.block.js && data.block.js.trim()) {
                        try {
                            const script = document.createElement('script');
                            script.textContent = data.block.js;
                            document.body.appendChild(script);
                        } catch (jsError) {
                            console.warn('Error executing block JS:', jsError);
                        }
                    }
                    
                    // Mettre à jour les couches
                    updateLayersPanel();
                    
                    // Mettre à jour les statistiques visuelles
                    updateBlockUsageInUI(blockId);
                    
                    hideLoading();
                    showNotification('Block added successfully', 'success');
                    
                } else {
                    throw new Error(data.message || 'Failed to add block');
                }
            } catch (error) {
                console.error('Error adding block:', error);
                hideLoading();
                showNotification('Error adding block: ' + error.message, 'error');
            }
        }

        function updateBlockUsageInUI(blockId) {
            // Trouver le bloc dans la sidebar et mettre à jour le compteur
            const blockElement = document.querySelector(`.block-card-modern[data-block-id="${blockId}"]`);
            if (blockElement) {
                const usageElement = blockElement.querySelector('.badge-usage');
                if (usageElement) {
                    const currentCount = parseInt(usageElement.textContent.match(/\d+/)[0]) || 0;
                    usageElement.innerHTML = `<i class="fas fa-download"></i> ${currentCount + 1}`;
                    
                    // Animation du compteur
                    usageElement.style.transform = 'scale(1.2)';
                    setTimeout(() => {
                        usageElement.style.transform = 'scale(1)';
                    }, 300);
                } else {
                    // Créer l'élément si il n'existe pas
                    const metaElement = blockElement.querySelector('.block-meta-modern');
                    if (metaElement) {
                        const usageSpan = document.createElement('span');
                        usageSpan.className = 'block-badge badge-usage';
                        usageSpan.innerHTML = '<i class="fas fa-download"></i> 1';
                        metaElement.appendChild(usageSpan);
                    }
                }
            }
        }


        // === FONCTIONS UTILITAIRES ===
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        function showLoading(message = 'Loading...') {
            let loader = document.getElementById('global-loader');
            if (!loader) {
                loader = document.createElement('div');
                loader.id = 'global-loader';
                loader.className = 'global-loader';
                loader.innerHTML = `
                    <div class="loader-content">
                        <div class="loader-spinner"></div>
                        <div class="loader-text">${message}</div>
                    </div>
                `;
                document.body.appendChild(loader);
            } else {
                loader.querySelector('.loader-text').textContent = message;
            }
            loader.style.display = 'flex';
        }

        function hideLoading() {
            const loader = document.getElementById('global-loader');
            if (loader) {
                loader.style.display = 'none';
            }
        }

        function showNotification(message, type = 'info') {
            // Supprimer les notifications existantes
            document.querySelectorAll('.notification').forEach(n => n.remove());
            
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'}"></i>
                <span>${message}</span>
                <button class="notification-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            document.body.appendChild(notification);
            
            // Animation d'entrée
            setTimeout(() => {
                notification.style.opacity = '1';
                notification.style.transform = 'translateY(0)';
            }, 10);
            
            // Supprimer automatiquement après 4 secondes
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.style.opacity = '0';
                    notification.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        if (notification.parentElement) {
                            notification.remove();
                        }
                    }, 300);
                }
            }, 4000);
        }

        // === FONCTIONS EXISTANTES À CONSERVER ===
       function initBlocksModern() {
    // Utiliser une valeur sécurisée
    const templateId = window.currentTemplateId || null;
    console.log('Initializing blocks with templateId:', templateId);
    loadBlocksModern(templateId);
}

        function initLayersPanel() {
            updateLayersPanel();
            
            editor.on('component:selected', updateLayersPanel);
            editor.on('component:add', updateLayersPanel);
            editor.on('component:remove', updateLayersPanel);
            editor.on('component:update', updateLayersPanel);
        }

        function updateLayersPanel() {
            const layersList = document.getElementById('layersList');
            if (!layersList) return;
            
            const components = editor.DomComponents.getComponents();
            
            layersList.innerHTML = '';
            
            if (components.length === 0) {
                layersList.innerHTML = '<div style="color: #94a3b8; text-align: center; padding: 20px;">No layers yet</div>';
                return;
            }
            
            function renderLayers(components, level = 0) {
                components.forEach(component => {
                    const layerDiv = document.createElement('div');
                    layerDiv.className = 'layer-item';
                    layerDiv.style.paddingLeft = (level * 20) + 'px';
                    
                    const selectedComponent = editor.getSelected();
                    if (selectedComponent && selectedComponent === component) {
                        layerDiv.classList.add('active');
                    }
                    
                    let icon = 'fa-cube';
                    const tagName = component.get('tagName');
                    if (tagName === 'img') icon = 'fa-image';
                    else if (tagName === 'button' || tagName === 'a') icon = 'fa-square';
                    else if (tagName === 'h1' || tagName === 'h2' || tagName === 'h3') icon = 'fa-heading';
                    else if (tagName === 'p') icon = 'fa-paragraph';
                    else if (tagName === 'section' || tagName === 'div') icon = 'fa-square-full';
                    
                    layerDiv.innerHTML = `
                        <div class="layer-icon">
                            <i class="fas ${icon}"></i>
                        </div>
                        <div class="layer-name">
                            ${component.get('type') || tagName || 'Component'}
                        </div>
                        <div class="layer-badge">
                            ${tagName || 'div'}
                        </div>
                    `;
                    
                    layerDiv.addEventListener('click', (e) => {
                        e.stopPropagation();
                        editor.select(component);
                    });
                    
                    layersList.appendChild(layerDiv);
                    
                    const children = component.get('components');
                    if (children && children.length > 0) {
                        renderLayers(children, level + 1);
                    }
                });
            }
            
            renderLayers(components);
        }

        function initEditorEvents() {
            let history = [];
            const maxHistory = 50;
            
            editor.on('component:add component:remove component:update style:property:update', () => {
                const action = {
                    time: new Date().toLocaleTimeString(),
                    html: editor.getHtml(),
                    css: editor.getCss()
                };
                
                history.unshift(action);
                if (history.length > maxHistory) {
                    history.pop();
                }
                
                updateHistoryPanel();
            });
            
            function updateHistoryPanel() {
                const historyList = document.getElementById('historyList');
                if (!historyList) return;
                
                historyList.innerHTML = '';
                
                if (history.length === 0) {
                    historyList.innerHTML = '<div style="color: #94a3b8; text-align: center; padding: 20px;">No history yet</div>';
                    return;
                }
                
                history.slice(0, 10).forEach((action, index) => {
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'history-item';
                    
                    let icon = 'fa-edit';
                    if (index === 0) icon = 'fa-clock';
                    
                    itemDiv.innerHTML = `
                        <div class="history-icon">
                            <i class="fas ${icon}"></i>
                        </div>
                        <div>
                            ${index === 0 ? 'Current' : 'Action ' + index}
                        </div>
                        <div class="history-time">
                            ${action.time}
                        </div>
                    `;
                    
                    historyList.appendChild(itemDiv);
                });
            }
            
            updateHistoryPanel();
        }

        // === INITIALISATION ===
        document.addEventListener('DOMContentLoaded', function() {
            initEditor();
            
            console.log('Modern Web Page Builder initialized');
        });

// === FONCTIONS DE GESTION DES MODALES ===
async function clearCanvas() {
    const { isConfirmed } = await Swal.fire({
        title: 'Clear Canvas?',
        text: 'Are you sure you want to clear the canvas? All your current work will be lost.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, clear it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (isConfirmed) {
        editor.setComponents('');
        showNotification('Canvas cleared', 'info');
        
        // Optional: Show success message
        Swal.fire({
            title: 'Cleared!',
            text: 'Canvas has been cleared.',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
        });
    }
}

        function showPreview() {
            showPreviewInModal();
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'none';
            }
        }

        

        function copyCode() {
            const codeEditor = document.getElementById('codeEditor');
            if (codeEditor) {
                codeEditor.select();
                document.execCommand('copy');
                showNotification('Code copied to clipboard', 'success');
            }
        }


        function previewBlock(blockId) {
            console.log('Preview block:', blockId);
            // Implémentez la prévisualisation
        }

        function showBlockCode(blockId) {
            console.log('Show code for block:', blockId);
            // Implémentez l'affichage du code
        }

        async function importBlocks() {
            console.log('Import blocks');
            // Implémentez l'importation
        }

        async function exportBlocks() {
            console.log('Export blocks');
            // Implémentez l'exportation
        }

        function showAllCategories() {
            console.log('Show all categories');
            // Implémentez l'affichage complet des catégories
        }

        function showRightPanel(panel) {
            console.log('Show panel:', panel);
            // Implémentez le changement de panneau
        }
    </script>
</body>
</html>