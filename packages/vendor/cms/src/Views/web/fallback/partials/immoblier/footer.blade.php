<footer class="pc-footer">
    <div class="pc-container">
        <div class="pc-footer-grid">
            <div>
                <h3>{{ $siteName }}</h3>
                <p>{{ $siteDescription }}</p>
            </div>
            <div>
                <h4>Navigation</h4>
                <ul>
                    <li><a href="#accueil">Accueil</a></li>
                    <li><a href="#logements">Logements</a></li>
                    <li><a href="#galerie">Galerie</a></li>
                    <li><a href="#services">Services</a></li>
                </ul>
            </div>
            <div>
                <h4>Services</h4>
                <ul>
                    <li>Location résidentielle</li>
                    <li>Visites sur rendez-vous</li>
                    <li>Produits à vendre</li>
                    <li>Gestion des demandes</li>
                </ul>
            </div>
            <div>
                <h4>Coordonnées</h4>
                <ul>
                    <li><a href="tel:{{ $phoneDial }}">{{ $phone }}</a></li>
                    <li><a href="mailto:{{ $email }}">{{ $email }}</a></li>
                    <li>{{ $address }}</li>
                </ul>
            </div>
        </div>
        <div class="pc-footer-bottom">
            <span>© {{ date('Y') }} {{ $siteName }}. Tous droits réservés.</span>
            <span>Propulsé par GoExploria Business</span>
        </div>
    </div>
</footer>
