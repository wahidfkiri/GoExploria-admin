/** Categories / Hero Quick Mega Menus — light interaction controller
 *  Exposes: window.initCatMegaPanel() (legacy compat) & helpers catMegaSelect/hqmSelect
 *  Handles hover panels, keyboard/focus out closing and inline mobile accordions.
 */
(function () {
  'use strict';

  const activePanels = new Set();
  let hideTimer = null;

  function getPanel(triggerId) {
    return document.getElementById(triggerId)?.closest('.cat-mega-panel');
  }

  function closeAllPanels() {
    activePanels.forEach(panel => panel.classList.remove('open'));
    activePanels.clear();
  }

  function openPanel(panel) {
    if (!panel) return;
    closeAllPanels();
    panel.classList.add('open');
    activePanels.add(panel);
  }

  function hidePanel(panel) {
    panel.classList.remove('open');
    activePanels.delete(panel);
  }

  function positionPanel(trigger, panel) {
    const rect = trigger.getBoundingClientRect();
    const vw = window.innerWidth;
    const panelWidth = 820;
    let left = rect.left + window.scrollX;
    if (left + panelWidth > vw - 12) {
      left = Math.max(12, vw - panelWidth - 12);
    }
    panel.style.top = (rect.bottom + window.scrollY + 8) + 'px';
    panel.style.left = left + 'px';
  }

  function initCatMegaPanel(triggerId, panelId, viewAllId) {
    const trigger = document.getElementById(triggerId);
    const panel = document.getElementById(panelId);
    if (!trigger || !panel) return;

    const show = () => {
      clearTimeout(hideTimer);
      positionPanel(trigger, panel);
      openPanel(panel);
    };
    const hide = () => {
      hideTimer = setTimeout(() => hidePanel(panel), 80);
    };

    trigger.addEventListener('mouseenter', show);
    trigger.addEventListener('mouseleave', hide);
    trigger.addEventListener('focus', show);
    trigger.addEventListener('blur', hide);

    panel.addEventListener('mouseenter', () => clearTimeout(hideTimer));
    panel.addEventListener('mouseleave', hide);
    panel.addEventListener('focusin', () => clearTimeout(hideTimer));
    panel.addEventListener('focusout', hide);
  }

  function selectCategory(el, suppressDefault) {
    if (!el) return;
    const panel = el.closest('.cat-mega-panel');
    if (!panel) return;

    const actsId = 'cat-acts-' + el.dataset.catId;
    const hasActs = el.dataset.hasActivities === '1';

    panel.querySelectorAll('.cat-mega-cat-item').forEach(i => i.classList.remove('active'));
    el.classList.add('active');

    panel.querySelectorAll('.cat-mega-activities').forEach(a => a.classList.remove('visible'));
    const acts = document.getElementById(actsId);
    if (acts) acts.classList.add('visible');

    const viewAll = panel.querySelector('.cat-mega-view-all');
    if (viewAll && el.dataset.catHref) viewAll.href = el.dataset.catHref;

    if (suppressDefault && !el.closest('.vmenu-inline-panel')) {
      if (hasActs) return; // let click navigate to category if no activities shown
    }
  }

  function catMegaSelect(e, el) {
    if (!el) return;
    // In hero panels / vertical inline panels prevent navigation and switch tab
    if (!el.closest('.vmenu-inline-panel')) {
      if (e && e.preventDefault) e.preventDefault();
    }
    selectCategory(el);
  }

  function hqmSelect(e, el) {
    catMegaSelect(e, el);
  }

  // Event delegation: toggle inline accordion behaviour inside the vertical menu
  document.addEventListener('click', function (e) {
    const catItem = e.target.closest('.cat-mega-cat-item');
    if (!catItem) return;
    const panel = catItem.closest('.cat-mega-panel');
    if (!panel || !panel.closest('.vmenu-inline-panel')) return;
    e.preventDefault();
    e.stopPropagation();

    const left = panel.querySelector('.cat-mega-left');
    const right = panel.querySelector('.cat-mega-right');
    if (right) right.style.display = 'block';
    if (left) left.classList.add('cat-mega-left--has-open');

    selectCategory(catItem);
  });

  window.initCatMegaPanel = initCatMegaPanel;
  window.catMegaSelect = catMegaSelect;
  window.hqmSelect = hqmSelect;

  document.addEventListener('DOMContentLoaded', function () {
    if (window.__catMegaInit) return;
    window.__catMegaInit = true;

    ['catMegaTriggerTourisme','catMegaTriggerBusiness'].forEach(function (tid, i) {
      const panelId = i === 0 ? 'catMegaPanelTourisme' : 'catMegaPanelBusiness';
      initCatMegaPanel(tid, panelId, 'catMegaViewAll' + (i === 0 ? 'Tourisme' : 'Business'));
    });
  });
})();
