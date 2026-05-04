<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h3>{{ get_site_name() }}</h3>
                <p>{{ get_site_description() ?? 'Fraîcheur et diversité depuis plus de 20 ans. Épicerie multi-services au cœur de Saint-Ambroise.' }}</p>
                <div class="footer-social">
                    @foreach(get_social_links() as $network => $data)
                        <a href="{{ $data['url'] }}" target="_blank" rel="noopener noreferrer" title="{{ $data['name'] }}">
                            <i class="{{ $data['icon'] }}"></i>
                        </a>
                    @endforeach
                </div>
            </div>
            
            <div class="footer-col">
                <h3>Liens rapides</h3>
                @foreach(theme_menu('footer_menu', theme_menu('main_menu')) as $item)
                    <p><a href="{{ $item['url'] }}">{{ $item['label'] }}</a></p>
                @endforeach
            </div>
            
            <div class="footer-col">
                <h3>Infos pratiques</h3>
                @php $address = theme_setting('address'); @endphp
                @if($address)
                    <p><i class="fas fa-map-pin"></i> {{ $address }}</p>
                @else
                    <p><i class="fas fa-map-pin"></i> Saint-Ambroise, Saguenay</p>
                @endif
                
                @php $phone = theme_setting('phone'); @endphp
                @if($phone)
                    <p><i class="fas fa-phone"></i> {{ $phone }}</p>
                @else
                    <p><i class="fas fa-phone"></i> (418) 672-4792</p>
                @endif
                
                @if(has_whatsapp())
                    <p><i class="fab fa-whatsapp"></i> WhatsApp disponible</p>
                @endif
                
                @php $email = theme_setting('email'); @endphp
                @if($email)
                    <p><i class="fas fa-envelope"></i> {{ $email }}</p>
                @endif
            </div>
            
            <div class="footer-col footer-newsletter">
                <h3>Restez informé</h3>
                <p>Recevez nos offres et nouveautés</p>
                <form action="{{ url('api/cms/' . getCurrentEtablissementId() . '/newsletter/subscribe') }}" method="POST">
                    @csrf
                    <input type="email" name="email" placeholder="Votre adresse email" required>
                    <button type="submit">S'inscrire</button>
                </form>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} {{ get_site_name() }} — Tous droits réservés</p>
            <div class="footer-bottom-links">
                @foreach(theme_menu('legal_menu', []) as $item)
                    <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
                @endforeach
            </div>
        </div>
    </div>
</footer>