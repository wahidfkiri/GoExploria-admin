{{-- ==========================================================================
     FILTRE HIÉRARCHIQUE DE LA CARTE

     Une cascade de champs calquée sur le fil d'Ariane : choisir une province
     charge ses régions, choisir une région charge ses secteurs, etc. Chaque
     sélection recentre la carte sur l'entité et recharge ses points d'intérêt.

     Ce module ne connaît PAS le moteur de carte : il passe par le contrat
     `window.GX_DEST_MAP` ({focus, render, fitAll}) que publient les deux
     branches de map-scripts.blade.php (Google Maps et Leaflet). C'est ce qui
     lui permet de fonctionner alors que l'ancien filtre géographique, écrit
     dans la seule branche Leaflet, restait inerte dès qu'une clé Google était
     configurée.

     Balisage attendu : landing/partials/map-filter — voir map-section.blade.php.
     ========================================================================== --}}
<script>
(function () {
  'use strict';

  var chain = document.getElementById('mapFilterChain');
  if (!chain) return;

  var resetBtn = document.getElementById('mapFilterReset');

  var CONF = {
    {{-- ⚠ json_encode explicite, pas @json : la directive coupe ses arguments
         sur la dernière virgule et prendrait le « false » de route() pour
         ses propres options, ce qui tronque l'appel. --}}
    pointsUrl: {!! json_encode(route('travel-destination.map-points', ['type' => $normalizedType, 'slug' => $slug], false)) !!},
    // Gabarit d'URL : le niveau sélectionné n'est connu qu'au clic.
    childrenUrl: {!! json_encode(route('travel-destination.children', ['type' => '__TYPE__', 'slug' => '__SLUG__'], false)) !!},
    labels: @json($typeLabels ?? []),
    home: {
      lat: {{ is_numeric($entity->latitude ?? null) ? (float) $entity->latitude : 'null' }},
      lng: {{ is_numeric($entity->longitude ?? null) ? (float) $entity->longitude : 'null' }}
    }
  };

  /* Sélection courante : c'est elle qui pilote le rechargement des points. */
  var selected = null;   // {type, slug, name, latitude, longitude, zoom}
  var pending = 0;       // sérialise les réponses réseau

  function childrenUrlFor(type, slug) {
    return CONF.childrenUrl
      .replace('__TYPE__', encodeURIComponent(type))
      .replace('__SLUG__', encodeURIComponent(slug));
  }

  /* Comparaison tolérante aux accents et à la casse : « quebec » doit trouver
     « Québec ». */
  function normalise(v) {
    return String(v || '')
      .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
      .toLowerCase().trim();
  }

  function map() {
    return window.GX_DEST_MAP || null;
  }

  /* ------------------------------------------------------------------
     Rechargement des points d'intérêt pour la sélection courante.
     L'API accepte filter_type / filter_slug : c'est elle qui restreint la
     zone, on ne filtre pas côté client.
  ------------------------------------------------------------------ */
  function reloadPoints() {
    var m = map();
    if (!m) return;

    var url = CONF.pointsUrl;
    if (selected) {
      url += (url.indexOf('?') > -1 ? '&' : '?')
           + 'filter_type=' + encodeURIComponent(selected.type)
           + '&filter_slug=' + encodeURIComponent(selected.slug);
    }

    var ticket = ++pending;
    chain.classList.add('is-loading');

    fetch(url, { headers: { 'Accept': 'application/json' } })
      .then(function (r) { return r.json(); })
      .then(function (res) {
        // Une réponse plus ancienne ne doit pas écraser une sélection récente.
        if (ticket !== pending) return;
        m.render((res && res.success && res.data) ? res.data : []);
      })
      .catch(function (err) { console.error('Filtre carte — points :', err); })
      .finally(function () {
        if (ticket === pending) chain.classList.remove('is-loading');
      });
  }

  /* ------------------------------------------------------------------
     Champs
  ------------------------------------------------------------------ */
  function fieldsBelow(field) {
    var out = [];
    var n = field.nextElementSibling;
    while (n) {
      if (n.classList.contains('map-filterfield')) out.push(n);
      n = n.nextElementSibling;
    }
    return out;
  }

  /* Un niveau plus large vient d'être rechoisi : les niveaux plus fins ne
     veulent plus rien dire. */
  function dropBelow(field) {
    fieldsBelow(field).forEach(function (f) { f.remove(); });
  }

  function buildField(level) {
    var wrap = document.createElement('div');
    wrap.className = 'map-filterfield';
    wrap.setAttribute('data-level', level.type);

    var label = document.createElement('label');
    label.className = 'map-filterfield__label';
    label.setAttribute('for', 'mapFilter-' + level.type);
    label.textContent = level.label || level.type;

    var input = document.createElement('input');
    input.type = 'text';
    input.className = 'map-filterfield__input';
    input.id = 'mapFilter-' + level.type;
    input.setAttribute('role', 'combobox');
    input.setAttribute('aria-expanded', 'false');
    input.setAttribute('autocomplete', 'off');
    input.placeholder = 'Tous — ' + String(level.label || level.type).toLowerCase() + 's';
    input.setAttribute('aria-label', 'Filtrer par ' + String(level.label || level.type).toLowerCase());

    var list = document.createElement('div');
    list.className = 'map-filterfield__list';
    list.setAttribute('role', 'listbox');

    wrap.appendChild(label);
    wrap.appendChild(input);
    wrap.appendChild(list);

    wireField(wrap, level.items || []);
    return wrap;
  }

  /* Charge le niveau suivant et l'ajoute à la chaîne. Un niveau sans enfant
     (une ville sans arrondissement) n'ajoute simplement rien. */
  function appendNextLevel(entry) {
    fetch(childrenUrlFor(entry.type, entry.slug), { headers: { 'Accept': 'application/json' } })
      .then(function (r) { return r.json(); })
      .then(function (res) {
        if (!res || !res.success || !res.type || !res.items || !res.items.length) return;
        chain.appendChild(buildField({
          type: res.type,
          label: res.label || CONF.labels[res.type] || res.type,
          items: res.items
        }));
      })
      .catch(function (err) { console.error('Filtre carte — niveau suivant :', err); });
  }

  function wireField(field, options) {
    var input = field.querySelector('.map-filterfield__input');
    var list = field.querySelector('.map-filterfield__list');
    if (!input || !list) return;

    function close() {
      list.classList.remove('is-open');
      input.setAttribute('aria-expanded', 'false');
    }

    function open() {
      render(input.value);
      list.classList.add('is-open');
      input.setAttribute('aria-expanded', 'true');
    }

    function choose(opt) {
      input.value = opt ? opt.name : '';
      field.classList.toggle('is-active', !!opt);
      close();
      dropBelow(field);

      if (!opt) {
        // « Tous » sur ce niveau : on remonte au parent, c'est-à-dire au
        // niveau encore sélectionné juste au-dessus, sinon à la destination.
        var above = null;
        var prev = field.previousElementSibling;
        while (prev && !above) {
          if (prev.classList.contains('map-filterfield') && prev.__gxSelection) above = prev.__gxSelection;
          prev = prev.previousElementSibling;
        }
        field.__gxSelection = null;
        applySelection(above);
        return;
      }

      field.__gxSelection = opt;
      applySelection(opt);
      appendNextLevel(opt);
    }

    function render(filter) {
      var q = normalise(filter);
      list.innerHTML = '';

      var all = document.createElement('button');
      all.type = 'button';
      all.className = 'map-filterfield__option is-all';
      all.setAttribute('role', 'option');
      all.textContent = 'Tous';
      all.addEventListener('mousedown', function (e) { e.preventDefault(); choose(null); });
      list.appendChild(all);

      var shown = 0;
      options.forEach(function (opt) {
        if (q && normalise(opt.name).indexOf(q) === -1) return;
        // Au-delà de quelques dizaines d'entrées la liste devient illisible :
        // on invite à affiner la recherche plutôt que tout déverser.
        if (shown >= 60) return;
        shown++;

        var el = document.createElement('button');
        el.type = 'button';
        el.className = 'map-filterfield__option';
        el.setAttribute('role', 'option');
        el.textContent = opt.name;
        if (opt.latitude === null || opt.longitude === null) {
          el.classList.add('is-nogeo');
          el.title = 'Coordonnées inconnues : la carte ne peut pas s\'y recentrer';
        }
        // mousedown : le blur de l'input ne doit pas fermer la liste avant le clic.
        el.addEventListener('mousedown', function (e) { e.preventDefault(); choose(opt); });
        list.appendChild(el);
      });

      if (!shown && q) {
        var empty = document.createElement('div');
        empty.className = 'map-filterfield__empty';
        empty.textContent = 'Aucun résultat';
        list.appendChild(empty);
      }
    }

    input.addEventListener('focus', open);
    input.addEventListener('input', open);
    input.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') { close(); input.blur(); }
      if (e.key === 'Enter') {
        e.preventDefault();
        var first = list.querySelector('.map-filterfield__option:not(.is-all)');
        if (first) first.dispatchEvent(new MouseEvent('mousedown'));
      }
    });
    input.addEventListener('blur', function () { setTimeout(close, 150); });
  }

  /* ------------------------------------------------------------------
     Application d'une sélection : recentrage + rechargement des points
  ------------------------------------------------------------------ */
  function applySelection(entry) {
    selected = entry || null;
    if (resetBtn) resetBtn.hidden = !selected;

    var m = map();
    if (m) {
      if (selected && selected.latitude !== null && selected.longitude !== null) {
        m.focus(selected.latitude, selected.longitude, selected.zoom);
      } else if (!selected && CONF.home.lat !== null) {
        m.fitAll();
      }
    }

    reloadPoints();
  }

  function resetAll() {
    // ⚠ Compter parmi les seuls champs interrogeables : les niveaux figés
    // occupent les premières places de la chaîne, et les inclure dans le
    // décompte ferait supprimer le premier champ, celui rendu par le serveur.
    var interrogeables = 0;

    chain.querySelectorAll('.map-filterfield').forEach(function (f) {
      if (f.classList.contains('map-filterfield--fixed')) return;

      interrogeables++;

      // Au-delà du premier, les champs viennent de la cascade : ils n'ont plus
      // de raison d'être une fois la sélection effacée.
      if (interrogeables > 1) {
        f.remove();
        return;
      }

      f.__gxSelection = null;
      f.classList.remove('is-active');
      var input = f.querySelector('.map-filterfield__input');
      if (input) input.value = '';
    });

    applySelection(null);
  }

  if (resetBtn) resetBtn.addEventListener('click', resetAll);

  // Champs rendus côté serveur : leurs options voyagent en data-options.
  chain.querySelectorAll('.map-filterfield[data-level]').forEach(function (field) {
    var input = field.querySelector('.map-filterfield__input');
    var raw = input ? input.getAttribute('data-options') : null;
    var options = [];
    try { options = raw ? JSON.parse(raw) : []; } catch (e) { options = []; }
    wireField(field, options);
  });

  // Le premier rendu des points est fait par le moteur lui-même ; on ne
  // recharge qu'à partir de la première sélection de l'utilisateur.
})();
</script>
