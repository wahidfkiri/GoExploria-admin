/**
 * Mega Menu Destinations - version statique (sans AJAX)
 * Gère l'ouverture/fermeture et l'expansion des sections
 */

class VerticalDestinationsMegaMenu {
    constructor() {
        this.megaMenu = document.getElementById('verticalDestinationsMega');
        this.trigger = document.querySelector('.vertical-menu-v2-destinations-trigger');
        this.closeBtn = document.getElementById('closeVerticalDestinationsMega');
        this.grid = document.getElementById('vDestinationsGrid');
        this.parentItem = document.querySelector('.vertical-menu-v2-destinations-item');
        this.isOpen = false;
        this.parentMenu = window.verticalMenuDynamic;

        this.init();
    }

    init() {
        if (!this.megaMenu || !this.trigger) return;

        // Ouverture au clic sur le trigger
        this.trigger.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            this.isOpen ? this.hide() : this.show();
        });

        // Fermeture au clic ailleurs
        document.addEventListener('click', (e) => {
            if (!this.megaMenu.contains(e.target) && !this.trigger.contains(e.target)) {
                this.hide();
            }
        });

        // Fermeture avec Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') this.hide();
        });

        // Bouton de fermeture
        if (this.closeBtn) {
            this.closeBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                this.hide();
            });
        }

        // Empêcher la propagation dans le mega menu
        this.megaMenu.addEventListener('click', (e) => {
            e.stopPropagation();
        });

        // Initialiser les toggles d'expansion
        this.initSectionToggles();
    }

    initSectionToggles() {
        this.megaMenu.querySelectorAll('[data-toggle]').forEach(header => {
            header.addEventListener('click', (e) => {
                if (e.target.closest('.vmenu-dest-name-link')) return;
                e.preventDefault();
                const subsection = header.closest('.vmenu-dest-subsection');
                if (subsection) {
                    subsection.classList.toggle('expanded');
                    return;
                }
                const section = header.closest('.vmenu-dest-section');
                if (section) section.classList.toggle('expanded');
            });
        });
    }

    show() {
        if (this.isOpen) return;
        this.isOpen = true;
        this.megaMenu.classList.add('active');
        if (this.parentItem) this.parentItem.classList.add('active');

        if (this.parentMenu && !this.parentMenu.isOpen) {
            this.parentMenu.openMenu();
        }
    }

    hide() {
        this.isOpen = false;
        this.megaMenu.classList.remove('active');
        if (this.parentItem) this.parentItem.classList.remove('active');
    }
}

// ===== Mega Menu Sections (Médias, Next Level, etc.) =====
class VerticalSectionsMegaMenu {
    constructor() {
        this.megaMenu = document.getElementById('verticalSectionsMega');
        this.triggerItems = document.querySelectorAll('.vertical-menu-v2-section-item');
        this.closeBtn = this.megaMenu ? this.megaMenu.querySelector('.vmenu-destinations-mega-close') : null;
        this.isOpen = false;
        this.currentSection = null;
        this.parentMenu = window.verticalMenuDynamic;

        if (!this.megaMenu) return;
        this.init();
    }

    init() {
        // Clic/touch sur chaque item de section
        this.triggerItems.forEach(item => {
            const link = item.querySelector('a');
            if (!link) return;
            let touched = false;
            const handleTouchStart = (e) => {
                touched = true;
                e.preventDefault();
                e.stopImmediatePropagation();
                const section = item.dataset.section;
                if (this.isOpen && this.currentSection === section) {
                    this.hide();
                } else {
                    this.show(section);
                }
            };
            const handleClick = (e) => {
                if (touched) return;
                e.preventDefault();
                e.stopImmediatePropagation();
                const section = item.dataset.section;
                if (this.isOpen && this.currentSection === section) {
                    this.hide();
                } else {
                    this.show(section);
                }
            };
            link.addEventListener('touchstart', handleTouchStart, { passive: false });
            link.addEventListener('click', handleClick);
        });

        // Fermeture au clic ailleurs
        document.addEventListener('click', (e) => {
            if (!this.megaMenu.contains(e.target) && !Array.from(this.triggerItems).some(t => t.contains(e.target))) {
                this.hide();
            }
        });

        // Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') this.hide();
        });

        // Bouton fermeture
        if (this.closeBtn) {
            this.closeBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                this.hide();
            });
        }

        // Empêcher propagation
        this.megaMenu.addEventListener('click', (e) => e.stopPropagation());

        // Initialiser les toggles d'expansion dans le contenu
        this.initToggleListeners();
    }

    show(section) {
        console.log('🔍 VerticalSectionsMegaMenu.show(', section, ')');
        console.log('📦 window.sectionsMenuData keys:', Object.keys(window.sectionsMenuData || {}));
        console.log('📦 window.sectionsMenuData[section]:', window.sectionsMenuData?.[section]);

        this.isOpen = true;
        this.currentSection = section;
        this.megaMenu.classList.add('active');

        // Mettre à jour le contenu
        const grid = this.megaMenu.querySelector('#vSectionsGrid');
        const title = this.megaMenu.querySelector('.vmenu-destinations-mega-title span');
        if (!grid || !title) return;

        const data = window.sectionsMenuData && window.sectionsMenuData[section];
        if (!data) return;

        title.textContent = data.title || section;

        // Générer les cartes
        grid.innerHTML = '';
        if (data.categories) {
            data.categories.forEach(cat => {
                const card = document.createElement('a');
                card.className = 'vmenu-section-card';
                card.href = cat.link || '#';
                card.target = cat.external ? '_blank' : '_self';
                card.innerHTML =
                    '<div class="vmenu-section-card-icon"><i class="' + (cat.icon || 'fas fa-circle') + '"></i></div>' +
                    '<div class="vmenu-section-card-body">' +
                        '<div class="vmenu-section-card-name">' + cat.name + '</div>' +
                        (cat.desc ? '<div class="vmenu-section-card-desc">' + cat.desc + '</div>' : '') +
                    '</div>';
                card.addEventListener('click', (e) => {
                    const href = card.getAttribute('href');
                    if (href && href.startsWith('#')) {
                        e.preventDefault();
                        this.hide();
                        if (this.parentMenu && typeof this.parentMenu.closeMenu === 'function') {
                            this.parentMenu.closeMenu();
                        }
                        const target = document.getElementById(href.substring(1));
                        if (target) {
                            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    }
                });
                grid.appendChild(card);
            });
        }

        // Marquer l'item actif
        this.triggerItems.forEach(i => i.classList.remove('active'));
        const activeItem = document.querySelector('.vertical-menu-v2-section-item[data-section="' + section + '"]');
        if (activeItem) activeItem.classList.add('active');

        if (this.parentMenu && !this.parentMenu.isOpen) {
            this.parentMenu.openMenu();
        }
    }

    hide() {
        this.isOpen = false;
        this.currentSection = null;
        this.megaMenu.classList.remove('active');
        this.triggerItems.forEach(i => i.classList.remove('active'));
    }

    initToggleListeners() {
        // Les futures cartes n'ont pas besoin de toggle, mais on prépare pour d'éventuels expand
    }
}

document.addEventListener('DOMContentLoaded', () => {
    window.verticalDestinationsMegaMenu = new VerticalDestinationsMegaMenu();
    window.verticalSectionsMegaMenu = new VerticalSectionsMegaMenu();
});
