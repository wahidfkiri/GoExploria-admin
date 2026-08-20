{{-- ═══════════════════════════════════════════════════════════════════════
     Média principal de la fiche d'un bien : photo, ou vidéo.

     CE QU'IL REMPLACE

     Le gabarit met toujours une photo dans la grande vue de sa fiche. Quand
     le commerçant a choisi « vidéo » pour ce bien, ce bloc y met un lecteur —
     iframe pour YouTube et Vimeo, balise <video> pour un fichier hébergé.

     LES VIGNETTES RESTENT DES PHOTOS

     Seule la grande vue change. Les deux vignettes latérales gardent les
     photos de la galerie, et la carte de la grille aussi : une page de
     vignettes vidéo serait lourde à charger et illisible.

     D'OÙ VIENT L'INFORMATION

     De `window.GX_IMMO`, déjà posé par gx-immo-data — même source que le
     reste de la fiche. Aucune requête supplémentaire.

     RIEN N'EST CHARGÉ AVANT LE CLIC

     Une iframe YouTube exécute son script dès qu'elle existe. On affiche
     donc l'affiche de la vidéo, et le lecteur ne s'installe qu'au clic :
     la fiche s'ouvre aussi vite qu'avant, et rien n'est déposé chez le
     visiteur tant qu'il ne demande rien.
     ═══════════════════════════════════════════════════════════════════════ --}}
<style>
    .gxvid { position: relative; width: 100%; height: 100%; min-height: 220px;
             border-radius: var(--im-radius-sm, 12px); overflow: hidden; background: #000; }
    .gxvid iframe, .gxvid video { width: 100%; height: 100%; display: block; border: 0; }
    .gxvid__affiche {
        position: absolute; inset: 0; width: 100%; height: 100%;
        object-fit: cover; cursor: pointer;
    }
    .gxvid__lire {
        position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;
        border: 0; background: transparent; cursor: pointer; padding: 0;
    }
    .gxvid__lire span {
        display: flex; align-items: center; justify-content: center;
        width: 66px; height: 66px; border-radius: 50%;
        background: rgba(255, 255, 255, .92); color: #111;
        font-size: 22px; line-height: 1; padding-left: 5px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .35);
        transition: transform .16s ease;
    }
    .gxvid__lire:hover span { transform: scale(1.07); }
    .gxvid__mention {
        position: absolute; left: 12px; bottom: 12px; padding: 5px 10px;
        border-radius: 999px; background: rgba(0, 0, 0, .6); color: #fff;
        font-size: 11.5px; font-weight: 700; letter-spacing: .03em; pointer-events: none;
    }
</style>

<script>
(function () {
    'use strict';

    if (window.__gxImmoMedia) { return; }
    window.__gxImmoMedia = true;

    function fiche() {
        return document.querySelector('[data-im-detail]');
    }

    /* Le bien affiché, tel que le gabarit le désigne : « p12 » dans
       GX_IMMO, l'attribut de la fiche pouvant porter l'un ou l'autre. */
    function bienAffiche() {
        var racine = fiche();
        if (!racine) { return null; }

        var brut = racine.getAttribute('data-im-detail-id')
            || racine.getAttribute('data-property-id');
        if (!brut) { return null; }

        var donnees = window.GX_IMMO;
        if (!donnees || !Array.isArray(donnees.properties)) { return null; }

        var cible = String(brut);
        var nu = cible.replace(/^p/, '');

        for (var i = 0; i < donnees.properties.length; i++) {
            var p = donnees.properties[i];
            if (String(p.id) === cible || String(p.id).replace(/^p/, '') === nu) { return p; }
        }

        return null;
    }

    function lecteur(bien) {
        var video = bien.video || {};
        var zone = document.createElement('div');
        zone.className = 'gxvid';
        zone.setAttribute('data-gxvid', '');

        // L'affiche : la couverture du bien, déjà calculée côté serveur (elle
        // retombe sur l'affiche YouTube quand aucune photo n'est fournie).
        if (bien.cover) {
            var affiche = document.createElement('img');
            affiche.className = 'gxvid__affiche';
            affiche.src = bien.cover;
            affiche.alt = bien.title || 'Vidéo du bien';
            affiche.loading = 'lazy';
            zone.appendChild(affiche);
        }

        var bouton = document.createElement('button');
        bouton.type = 'button';
        bouton.className = 'gxvid__lire';
        bouton.setAttribute('aria-label', 'Lire la vidéo du bien');
        bouton.innerHTML = '<span>&#9654;</span>';
        zone.appendChild(bouton);

        var mention = document.createElement('div');
        mention.className = 'gxvid__mention';
        mention.textContent = video.provider === 'youtube' ? 'Vidéo YouTube'
                            : video.provider === 'vimeo' ? 'Vidéo Vimeo'
                            : 'Vidéo';
        zone.appendChild(mention);

        bouton.addEventListener('click', function () {
            zone.innerHTML = '';

            if (video.provider === 'fichier') {
                var balise = document.createElement('video');
                balise.src = video.embed;
                balise.controls = true;
                balise.autoplay = true;
                balise.setAttribute('playsinline', '');
                if (bien.cover) { balise.poster = bien.cover; }
                zone.appendChild(balise);

                return;
            }

            var cadre = document.createElement('iframe');
            // autoplay=1 : le visiteur vient de cliquer, c'est ce qu'il demande.
            cadre.src = video.embed + (video.embed.indexOf('?') === -1 ? '?' : '&') + 'autoplay=1';
            cadre.title = bien.title || 'Vidéo du bien';
            cadre.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; picture-in-picture; fullscreen';
            cadre.setAttribute('allowfullscreen', '');
            cadre.setAttribute('loading', 'lazy');
            zone.appendChild(cadre);
        });

        return zone;
    }

    function installer() {
        var racine = fiche();
        if (!racine) { return; }

        var galerie = racine.querySelector('.im-detail-gallery');
        if (!galerie) { return; }

        var grande = galerie.firstElementChild;
        if (!grande) { return; }

        var bien = bienAffiche();
        var enVideo = !!(bien && bien.mediaType === 'video' && bien.video && bien.video.embed);

        // Rien à faire, et surtout : rendre sa photo au bien précédent si la
        // fiche affiche maintenant un bien sans vidéo.
        if (!enVideo) {
            if (grande.__gxvidPhoto) {
                grande.innerHTML = '';
                grande.appendChild(grande.__gxvidPhoto);
                grande.__gxvidPhoto = null;
                grande.__gxvidBien = null;
            }

            return;
        }

        if (grande.__gxvidBien === bien.id) { return; }

        // La photo d'origine est mise de côté, pas détruite : le gabarit la
        // remplit à chaque ouverture, et un autre bien peut en avoir besoin.
        if (!grande.__gxvidPhoto) {
            var photo = grande.querySelector('img');
            if (photo) { grande.__gxvidPhoto = photo; }
        }

        grande.innerHTML = '';
        grande.appendChild(lecteur(bien));
        grande.__gxvidBien = bien.id;
    }

    function surveiller() {
        installer();

        var racine = fiche();
        if (!racine || typeof MutationObserver === 'undefined') { return; }

        new MutationObserver(function () { installer(); })
            .observe(racine, { attributes: true, attributeFilter: ['aria-hidden', 'class', 'data-im-detail-id'] });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', surveiller);
    } else {
        surveiller();
    }
})();
</script>
