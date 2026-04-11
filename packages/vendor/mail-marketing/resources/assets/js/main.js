
/* ── FILTER LOGIC ── */
const tabs  = document.querySelectorAll('.mm-tab');
const cards = document.querySelectorAll('.mcard[data-cat]');
const empty = document.getElementById('emptyState');

function applyFilter(filter) {
  let visible = 0;

  cards.forEach(card => {
    const cat = card.dataset.cat;
    const show = filter === 'all' || cat === filter;

    if (show) {
      card.classList.remove('hidden');
      // re-trigger animation
      card.style.animation = 'none';
      card.offsetHeight; // reflow
      card.style.animation = '';
      visible++;
    } else {
      card.classList.add('hidden');
    }
  });

  // Wide card layout: if only 1 card visible and it's wide, adjust span
  cards.forEach(card => {
    if (!card.classList.contains('hidden') && card.classList.contains('mcard-wide')) {
      if (visible === 1) {
        card.style.gridColumn = '1 / -1';
      } else {
        card.style.gridColumn = '';
      }
    }
  });

  empty.classList.toggle('show', visible === 0);
}

tabs.forEach(tab => {
  tab.addEventListener('click', () => {
    tabs.forEach(t => t.classList.remove('active'));
    tab.classList.add('active');
    applyFilter(tab.dataset.filter);
  });
});

/* ── ENTRANCE ANIMATION ── */
const io = new IntersectionObserver(entries => {
  entries.forEach((e, i) => {
    if (e.isIntersecting) {
      setTimeout(() => {
        e.target.style.opacity = '1';
        e.target.style.transform = 'translateY(0)';
      }, i * 60);
      io.unobserve(e.target);
    }
  });
}, { threshold: 0.08 });

[...cards, ...document.querySelectorAll('.mm-stat,.mm-step')].forEach(el => {
  el.style.opacity = '0';
  el.style.transform = 'translateY(22px)';
  el.style.transition = 'opacity .45s ease, transform .45s ease';
  io.observe(el);
});

/* ── LIVE COUNTDOWN (Vente Flash card) ── */
function tick() {
  const svg = document.querySelector('[data-cat="retail"]:last-of-type svg');
  if (!svg) return;
  const now = new Date();
  const s = 59 - now.getSeconds();
  const m = 59 - now.getMinutes();
  const h = 23 - now.getHours();
  const texts = svg.querySelectorAll('text');
  // Not patching SVG text live here - just show static. Real impl would use JS DOM.
}
