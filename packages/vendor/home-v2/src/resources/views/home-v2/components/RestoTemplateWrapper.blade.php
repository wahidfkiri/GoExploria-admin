{{-- ============================================================
     TEMPLATE DÉMO — BLOC ACCORD METS & VINS
     Wrapper : topbar · mini-header · contenu · mini-footer · CTA
     ============================================================ --}}
@php(ob_start());@endphp
<div class="goexp-tpl-frame" id="goexpRestoTemplate">

    {{-- Barre indicateur template --}}
    <!-- <div class="goexp-tpl-topbar">
        <span class="goexp-tpl-topbar-badge">
            <i class="fas fa-code"></i> Template Demo
        </span>
        <span class="goexp-tpl-topbar-text">
            Exemple de section "Accords Mets &amp; Vins" — modèle de site restaurant GoExploria
        </span>
        <a href="#" class="goexp-tpl-topbar-link">
            <i class="fas fa-arrow-right"></i> Obtenir ce modèle
        </a>
    </div> -->

    {{-- Mini Header du bloc Mets & Vins --}}
    <header class="goexp-tpl-header">
        <div class="goexp-tpl-header-inner">
            <a href="#menu-accord-section" class="goexp-tpl-logo">
                <div class="goexp-tpl-logo-icon"><i class="fas fa-wine-glass-alt"></i></div>
                <span class="goexp-tpl-logo-name">Resto <span>Graffiti</span></span>
            </a>
            <nav class="goexp-tpl-nav-wrap" id="goexpNavWrap">
                <ul class="goexp-tpl-nav">
                    <li><a href="#amv-menu-section" onclick="goexpCloseNav()"><i class="fas fa-utensils"></i> Notre Menu</a></li>
                    <li><a href="#menu-accord-section" onclick="goexpCloseNav()"><i class="fas fa-wine-glass-alt"></i> Carte des Vins</a></li>
                    <li><a href="#amv-apropos" onclick="goexpCloseNav()"><i class="fas fa-info-circle"></i> À Propos</a></li>
                    <li><a href="#" onclick="openGoExpResaModal('wine'); goexpCloseNav(); return false;" class="goexp-nav-cta wine">
                        <i class="fas fa-wine-bottle"></i> Réserver un Vin
                    </a></li>
                    <li><a href="#" onclick="openGoExpResaModal('table'); goexpCloseNav(); return false;" class="goexp-nav-cta table">
                        <i class="fas fa-calendar-check"></i> Réserver une Table
                    </a></li>
                </ul>
            </nav>
            <div class="goexp-tpl-header-actions">
                <a href="#amv-apropos" class="goexp-tpl-header-info goexp-header-info-desktop">
                    <i class="fas fa-arrow-down"></i> En savoir plus
                </a>
                <button class="goexp-tpl-hamburger" id="goexpHamburger"
                        onclick="goexpToggleNav()" aria-label="Menu" aria-expanded="false">
                    <i class="fas fa-bars" id="goexpHamIcon"></i>
                </button>
            </div>
        </div>
    </header>

    {{-- Contenu principal --}}
    @include('home-v2.components.MenuAccordMetsVinsV2')

    {{-- Mini Footer --}}
    <footer class="goexp-tpl-footer">
        <div class="goexp-tpl-footer-inner">
            <div class="goexp-tpl-footer-brand">
                <h4>Resto <span>Graffiti</span></h4>
                <p>Une expérience gastronomique unique au cœur de Montréal. Cuisine italienne raffinée et accords mets &amp; vins d'exception.</p>
            </div>
            <div class="goexp-tpl-footer-col">
                <h5>Navigation</h5>
                <ul>
                    <li><i class="fas fa-chevron-right"></i> Notre Menu</li>
                    <li><i class="fas fa-chevron-right"></i> Carte des Vins</li>
                    <li><i class="fas fa-chevron-right"></i> Réservations</li>
                    <li><i class="fas fa-chevron-right"></i> Événements</li>
                    <li><i class="fas fa-chevron-right"></i> À propos</li>
                </ul>
            </div>
            <div class="goexp-tpl-footer-col">
                <h5>Informations</h5>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> 123 rue Saint-Denis, Montréal, QC</li>
                    <li><i class="fas fa-phone"></i> (514) 555-0194</li>
                    <li><i class="fas fa-envelope"></i> info@restografitti.ca</li>
                    <li><i class="fas fa-clock"></i> Mar–Ven : 11h30 – 22h00</li>
                    <li><i class="fas fa-clock"></i> Sam–Dim : 10h30 – 23h00</li>
                </ul>
            </div>
            <div class="goexp-tpl-footer-col">
                <h5>Réserver</h5>
                <ul>
                    <li><i class="fas fa-users"></i> Groupes acceptés</li>
                    <li><i class="fas fa-birthday-cake"></i> Événements privés</li>
                    <li><i class="fas fa-wine-bottle"></i> Dégustations privées</li>
                    <li><i class="fas fa-star"></i> Tables VIP disponibles</li>
                </ul>
                <button class="goexp-tpl-header-reserve"
                        style="margin-top:16px;width:100%;justify-content:center;"
                        onclick="openGoExpResaModal('table')">
                    <i class="fas fa-calendar-check"></i> Réserver
                </button>
            </div>
        </div>
        <div class="goexp-tpl-footer-bottom">
            <span>© 2025 Resto Graffiti — Tous droits réservés</span>
            <span>Politique de confidentialité · Mentions légales</span>
        </div>
    </footer>

    {{-- Bannière CTA GoExploria --}}
    <div class="goexp-tpl-cta-banner">
        <div class="goexp-tpl-cta-banner-text">
            <div class="goexp-tpl-cta-icon"><i class="fas fa-rocket"></i></div>
            <div class="goexp-tpl-cta-copy">
                <strong>Ce modèle de site est disponible pour votre restaurant</strong>
                <span>GoExploria conçoit des sites web complets, des templates et des solutions digitales pour l'industrie touristique et gastronomique.</span>
            </div>
        </div>
        <div class="goexp-tpl-cta-actions">
            <a href="#" class="goexp-tpl-cta-btn primary">
                <i class="fas fa-shopping-bag"></i> Obtenir ce template
            </a>
            <a href="#" class="goexp-tpl-cta-btn secondary">
                <i class="fas fa-info-circle"></i> En savoir plus
            </a>
        </div>
    </div>

</div>{{-- /.goexp-tpl-frame --}}

<script>
function goexpToggleNav() {
    var nav  = document.getElementById('goexpNavWrap');
    var btn  = document.getElementById('goexpHamburger');
    var icon = document.getElementById('goexpHamIcon');
    var open = nav.classList.toggle('open');
    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    icon.className = open ? 'fas fa-times' : 'fas fa-bars';
}
function goexpCloseNav() {
    var nav  = document.getElementById('goexpNavWrap');
    var btn  = document.getElementById('goexpHamburger');
    var icon = document.getElementById('goexpHamIcon');
    if (!nav) return;
    nav.classList.remove('open');
    btn.setAttribute('aria-expanded', 'false');
    icon.className = 'fas fa-bars';
}
document.addEventListener('click', function (e) {
    var nav = document.getElementById('goexpNavWrap');
    var btn = document.getElementById('goexpHamburger');
    if (nav && btn && nav.classList.contains('open') &&
        !nav.contains(e.target) && !btn.contains(e.target)) {
        goexpCloseNav();
    }
});
</script>
@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp
