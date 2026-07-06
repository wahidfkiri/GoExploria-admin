class VerticalMenuController {
  constructor() {
    this.menu = document.getElementById('verticalMenuV2');
    this.overlay = document.getElementById('verticalMenuOverlay');
    this.openBtn = document.getElementById('openVerticalMenu');
    this.closeBtn = document.getElementById('closeVerticalMenu');
    this.menuList = document.getElementById('verticalMenuList');
    this.isOpen = false;

    if (!this.menu || !this.overlay) return;
    this.init();
  }

  init() {
    this.bindEvents();
    this.loadVideos();
  }

  bindEvents() {
    if (this.openBtn) {
      this.openBtn.addEventListener('click', (e) => { e.stopPropagation(); this.openMenu(); });
    }
    if (this.closeBtn) {
      this.closeBtn.addEventListener('click', () => this.closeMenu());
    }
    this.overlay.addEventListener('click', () => this.closeMenu());

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && this.isOpen) this.closeMenu();
    });

    this.menu.addEventListener('click', (e) => e.stopPropagation());

    document.querySelectorAll('.vertical-menu-v2-accordion-trigger').forEach(el => {
      el.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        const parent = el.closest('.vertical-menu-v2-accordion');
        if (!parent) return;
        document.querySelectorAll('.vertical-menu-v2-accordion').forEach(a => {
          if (a !== parent) a.classList.remove('active');
        });
        parent.classList.toggle('active');
      });
    });

    document.querySelectorAll('.vertical-menu-v2-sublink, .vertical-menu-v2-link:not(.vertical-menu-v2-accordion-trigger):not(.vertical-menu-v2-destinations-trigger):not(.vertical-menu-v2-section-item a)').forEach(el => {
      const isSectionItem = el.closest('.vertical-menu-v2-section-item');
      if (!isSectionItem) {
        el.addEventListener('click', () => this.closeMenu());
      }
    });

    const destTrigger = document.querySelector('.vertical-menu-v2-destinations-trigger');
    if (destTrigger && window.verticalDestinationsMegaMenu) {
      destTrigger.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        window.verticalDestinationsMegaMenu.isOpen
          ? window.verticalDestinationsMegaMenu.hide()
          : window.verticalDestinationsMegaMenu.show();
      });
    }

    if (this.menuList && window.verticalSectionsMegaMenu) {
      this.menuList.addEventListener('click', (e) => {
        const item = e.target.closest('.vertical-menu-v2-section-item');
        if (!item) return;
        e.preventDefault();
        e.stopImmediatePropagation();
        const section = item.dataset.section;
        const mm = window.verticalSectionsMegaMenu;
        if (mm.isOpen && mm.currentSection === section) {
          mm.hide();
        } else {
          mm.show(section);
        }
      });
    }

    const panelMap = [
      { v: 'vmenuTriggerInfo',    p: 'vmenuPanelInfo' },
      { v: 'vmenuTriggerTourisme', p: 'vmenuPanelTourisme' },
      { v: 'vmenuTriggerBusiness', p: 'vmenuPanelBusiness' },
      { v: 'vmenuTriggerEE',       p: 'vmenuPanelEE' },
      { v: 'vmenuTriggerED',       p: 'vmenuPanelED' },
      { v: 'vmenuTriggerMP',       p: 'vmenuPanelMP' },
      { v: 'vmenuTriggerCar',      p: 'vmenuPanelCar' },
      { v: 'vmenuTriggerPlane',    p: 'vmenuPanelPlane' },
      { v: 'vmenuTriggerPlanGo',   p: 'vmenuPanelPlanGo' },
    ];
    panelMap.forEach(({ v, p }) => {
      const el = document.getElementById(v);
      if (el) {
        el.addEventListener('click', (e) => { e.preventDefault(); e.stopPropagation(); this.togglePanel(p); });
      }
    });

    document.querySelectorAll('.vmenu-inline-close').forEach(el => {
      el.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        const panelId = el.dataset.panel;
        if (panelId) this.hidePanel(panelId);
      });
    });

    this.menu.addEventListener('click', (e) => {
      const catItem = e.target.closest('.cat-mega-cat-item');
      if (!catItem) return;
      const panel = catItem.closest('.cat-mega-panel');
      if (!panel) return;
      if (!panel.closest('.vmenu-inline-panel')) return;
      e.preventDefault();
      e.stopPropagation();

      const right = panel.querySelector('.cat-mega-right');
      if (right) right.style.display = 'none';

      const acts = panel.querySelector('#cat-acts-' + catItem.dataset.catId);
      // État courant : la catégorie est-elle déjà ouverte ?
      const isOpen = catItem.classList.contains('active') && acts && acts.classList.contains('vmenu-open');

      // Réinitialise toutes les catégories
      panel.querySelectorAll('.cat-mega-cat-item').forEach(i => i.classList.remove('active'));
      panel.querySelectorAll('.cat-mega-activities').forEach(a => {
        a.classList.remove('visible', 'vmenu-open');
        a.style.display = 'none';
      });

      // Toggle : un second clic sur la même catégorie referme sa liste
      if (isOpen) return;

      catItem.classList.add('active');
      if (acts) {
        const next = catItem.nextElementSibling;
        if (next !== acts) {
          catItem.parentNode.insertBefore(acts, next);
        }
        acts.style.display = '';
        acts.classList.add('vmenu-open');
      }

      const viewAll = panel.querySelector('.cat-mega-view-all');
      if (viewAll && catItem.dataset.catHref) viewAll.href = catItem.dataset.catHref;
    });
  }

  openMenu() {
    this.isOpen = true;
    this.menu.classList.add('active');
    this.overlay.classList.add('active');
    if (this.openBtn) this.openBtn.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  closeMenu() {
    this.isOpen = false;
    this.menu.classList.remove('active');
    this.overlay.classList.remove('active');
    if (this.openBtn) this.openBtn.classList.remove('active');
    document.body.style.overflow = '';
    this.hideAllPanels();
    if (window.verticalDestinationsMegaMenu) window.verticalDestinationsMegaMenu.hide();
    if (window.verticalSectionsMegaMenu) window.verticalSectionsMegaMenu.hide();
  }

  toggleMenu() {
    this.isOpen ? this.closeMenu() : this.openMenu();
  }

  get activePanel() {
    return this.menu ? this.menu.querySelector('.vmenu-inline-panel.active') : null;
  }

  get sourceContainer() {
    return this.menu ? this.menu.querySelector('.vmenu-components-source') : null;
  }

  get sourcePanels() {
    return {
      vmenuPanelInfo:     { id: 'infoMegaMenuV2',        isInfo: true },
      vmenuPanelTourisme: { id: 'catMegaPanelTourisme',   isInfo: false },
      vmenuPanelBusiness: { id: 'catMegaPanelBusiness',   isInfo: false },
      vmenuPanelEE:       { id: 'hqmEE',                  isInfo: false },
      vmenuPanelED:       { id: 'hqmED',                  isInfo: false },
      vmenuPanelMP:       { id: 'hqmMP',                  isInfo: false },
      vmenuPanelCar:      { id: 'hqmCar',                 isInfo: false },
      vmenuPanelPlane:    { id: 'hqmPlane',               isInfo: false },
      vmenuPanelPlanGo:   { id: 'hqmPlanNGo',             isInfo: false },
    };
  }

  showPanel(panelId) {
    const panel = document.getElementById(panelId);
    if (!panel) return;
    this.hideAllPanels();

    const src = this.sourcePanels[panelId];
    const content = panel.querySelector('.vmenu-panel-content');
    const source = this.sourceContainer ? this.sourceContainer.querySelector('#' + src.id) : null;

    if (source && content) {
      source.removeAttribute('style');
      source.classList.remove('active', 'open');
      content.appendChild(source);
    }

    panel.classList.add('active');
  }

  hidePanel(panelId) {
    const panel = document.getElementById(panelId);
    if (!panel) return;

    const content = panel.querySelector('.vmenu-panel-content');
    const child = content ? content.firstElementChild : null;
    if (child && this.sourceContainer) {
      child.removeAttribute('style');
      child.classList.remove('active', 'open');
      this.sourceContainer.appendChild(child);
    }

    panel.classList.remove('active');
  }

  hideAllPanels() {
    if (!this.menu) return;
    this.menu.querySelectorAll('.vmenu-inline-panel.active').forEach(p => {
      this.hidePanel(p.id);
    });
  }

  togglePanel(panelId) {
    const panel = document.getElementById(panelId);
    if (!panel) return;
    if (panel.classList.contains('active')) {
      this.hidePanel(panelId);
    } else {
      this.showPanel(panelId);
    }
  }

  loadVideos() {
    const sub = document.getElementById('submenu-videos');
    if (!sub) return;
    const data = [
      { id: 1, title: 'Découvrez les merveilles du Québec', cat: 'Tourisme', date: '15 Mars 2024', dur: '12:45', thumb: 'https://img.youtube.com/vi/dQw4w9WgXcQ/mqdefault.jpg' },
      { id: 2, title: 'Guide complet des restaurants de Montréal', cat: 'Gastronomie', date: '12 Mars 2024', dur: '8:30', thumb: 'https://img.youtube.com/vi/dQw4w9WgXcQ/mqdefault.jpg' },
      { id: 3, title: "Activités d'hiver au Canada", cat: 'Aventure', date: '10 Mars 2024', dur: '15:20', thumb: 'https://img.youtube.com/vi/dQw4w9WgXcQ/mqdefault.jpg' },
      { id: 4, title: 'Hébergements de luxe à Québec', cat: 'Hôtels', date: '8 Mars 2024', dur: '10:15', thumb: 'https://img.youtube.com/vi/dQw4w9WgXcQ/mqdefault.jpg' },
      { id: 5, title: "Événements culturels de l'été", cat: 'Culture', date: '5 Mars 2024', dur: '11:40', thumb: 'https://img.youtube.com/vi/dQw4w9WgXcQ/mqdefault.jpg' },
      { id: 6, title: 'Parcs nationaux du Québec', cat: 'Nature', date: '2 Mars 2024', dur: '14:25', thumb: 'https://img.youtube.com/vi/dQw4w9WgXcQ/mqdefault.jpg' },
      { id: 7, title: 'Histoire et patrimoine de Montréal', cat: 'Histoire', date: '28 Fév 2024', dur: '9:50', thumb: 'https://img.youtube.com/vi/dQw4w9WgXcQ/mqdefault.jpg' },
      { id: 8, title: 'Activités familiales au Québec', cat: 'Famille', date: '25 Fév 2024', dur: '13:10', thumb: 'https://img.youtube.com/vi/dQw4w9WgXcQ/mqdefault.jpg' },
    ];

    sub.innerHTML = data.map(v => `
      <div class="vertical-menu-v2-video-item" data-video-id="${v.id}">
        <div class="vertical-menu-v2-video-thumbnail">
          <img src="${v.thumb}" alt="${v.title}" loading="lazy">
          <div class="vertical-menu-v2-video-play-icon"><svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg></div>
          <span class="vertical-menu-v2-video-duration">${v.dur}</span>
        </div>
        <div class="vertical-menu-v2-video-info">
          <h4 class="vertical-menu-v2-video-title">${v.title}</h4>
          <div class="vertical-menu-v2-video-meta">
            <span class="vertical-menu-v2-video-category"><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>${v.cat}</span>
            <span class="vertical-menu-v2-video-date">${v.date}</span>
          </div>
        </div>
      </div>
    `).join('');

    sub.querySelectorAll('.vertical-menu-v2-video-item').forEach(el => {
      el.addEventListener('click', () => {
        const modal = document.getElementById('videoModal');
        if (!modal) return;
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        ['modalVideoPlayer','modalTitle','modalBadge','modalDate','modalDescription'].forEach(id => {
          const el = document.getElementById(id);
          if (el && id === 'modalVideoPlayer') el.src = 'https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1';
        });
      });
    });
  }
}

document.addEventListener('DOMContentLoaded', () => {
  if (window.__vmInit) return;
  window.__vmInit = true;
  const ctrl = new VerticalMenuController();
  window.vmController = ctrl;
  window.verticalMenuDynamic = ctrl;
});
