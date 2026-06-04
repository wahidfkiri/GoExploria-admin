{{-- Footer Component V2 --}}
<footer class="footer-v2">
    {{-- Newsletter Section --}}
    <div class="footer-v2-newsletter">
        <div class="footer-v2-container">
            <div class="footer-v2-newsletter-content">
                <div class="footer-v2-newsletter-text">
                    <h3 class="footer-v2-newsletter-title">{{ __('home-v2.footer.newsletter_title') }}</h3>
                    <p class="footer-v2-newsletter-subtitle">{{ __('home-v2.footer.newsletter_subtitle') }}</p>
                </div>
                <form class="footer-v2-newsletter-form">
                    <input
                        type="email"
                        class="footer-v2-newsletter-input"
                        placeholder="{{ __('home-v2.footer.newsletter_placeholder') }}"
                        aria-label="{{ __('home-v2.footer.newsletter_aria') }}"
                        required
                    >
                    <button type="submit" class="footer-v2-newsletter-btn">
                        {{ __('home-v2.footer.newsletter_button') }}
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Main Footer Content --}}
    <div class="footer-v2-main">
        <div class="footer-v2-container">
            <div class="footer-v2-grid">
                {{-- Column 1: Logo & About --}}
                <div class="footer-v2-column footer-v2-brand">
                    <a href="#" class="footer-v2-logo">
                        <img src="{{ asset('logo.png') }}" alt="{{ __('home-v2.brand.name_upper') }}" class="footer-v2-logo-img">
                        <div class="footer-v2-logo-text">
                            <div class="footer-v2-logo-name">{{ __('home-v2.brand.name_upper') }}</div>
                            <div class="footer-v2-logo-location">{{ __('home-v2.brand.location') }}</div>
                        </div>
                    </a>
                    <p class="footer-v2-description">{{ __('home-v2.footer.description') }}</p>
                    @php $footerSocialLinks = $socialLinks ?? get_establishment_social_links($etablissement ?? null); @endphp
                    @if(!empty($footerSocialLinks))
                        <div class="footer-v2-social">
                            @foreach($footerSocialLinks as $link)
                                <a href="{{ $link['url'] }}" class="footer-v2-social-link" aria-label="{{ $link['label'] }}" target="_blank" rel="noopener noreferrer">
                                    <i class="{{ $link['icon'] }}"></i>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Column 2: Services --}}
                <div class="footer-v2-column">
                    <h4 class="footer-v2-column-title">{{ __('home-v2.footer.columns.services') }}</h4>
                    <ul class="footer-v2-links">
                        <li><a href="#forfaits-voyage" class="footer-v2-link">{{ __('home-v2.footer.services_links.travel_packages') }}</a></li>
                        <li><a href="#vols-direct" class="footer-v2-link">{{ __('home-v2.footer.services_links.live_flights') }}</a></li>
                        <li><a href="#activites-4-saisons" class="footer-v2-link">{{ __('home-v2.footer.services_links.activities') }}</a></li>
                        <li><a href="#biens-immobiliers" class="footer-v2-link">{{ __('home-v2.footer.services_links.real_estate') }}</a></li>
                        <li><a href="#agence-conseil" class="footer-v2-link">{{ __('home-v2.footer.services_links.agency') }}</a></li>
                        <li><a href="#solutions-web" class="footer-v2-link">{{ __('home-v2.footer.services_links.web') }}</a></li>
                    </ul>
                </div>

                {{-- Column 3: Destinations --}}
                <div class="footer-v2-column">
                    <h4 class="footer-v2-column-title">{{ __('home-v2.footer.columns.destinations') }}</h4>
                    <ul class="footer-v2-links">
                        <li><a href="#quebec" class="footer-v2-link">{{ __('home-v2.footer.destinations_links.quebec') }}</a></li>
                        <li><a href="#montreal" class="footer-v2-link">{{ __('home-v2.footer.destinations_links.montreal') }}</a></li>
                        <li><a href="#ottawa" class="footer-v2-link">{{ __('home-v2.footer.destinations_links.ottawa') }}</a></li>
                        <li><a href="#toronto" class="footer-v2-link">{{ __('home-v2.footer.destinations_links.toronto') }}</a></li>
                        <li><a href="#vancouver" class="footer-v2-link">{{ __('home-v2.footer.destinations_links.vancouver') }}</a></li>
                        <li><a href="#banff" class="footer-v2-link">{{ __('home-v2.footer.destinations_links.banff') }}</a></li>
                    </ul>
                </div>

                {{-- Column 4: Informations --}}
                <div class="footer-v2-column">
                    <h4 class="footer-v2-column-title">{{ __('home-v2.footer.columns.information') }}</h4>
                    <ul class="footer-v2-links">
                        <li><a href="#about" class="footer-v2-link">{{ __('home-v2.footer.information_links.about') }}</a></li>
                        <li><a href="#valeurs" class="footer-v2-link">{{ __('home-v2.footer.information_links.values') }}</a></li>
                        <li><a href="#temoignage" class="footer-v2-link">{{ __('home-v2.footer.information_links.testimonials') }}</a></li>
                        <li><a href="#faq" class="footer-v2-link">{{ __('home-v2.footer.information_links.faq') }}</a></li>
                        <li><a href="#contact" class="footer-v2-link">{{ __('home-v2.footer.information_links.contact') }}</a></li>
                        <li><a href="#careers" class="footer-v2-link">{{ __('home-v2.footer.information_links.careers') }}</a></li>
                    </ul>
                </div>

                {{-- Column 5: Contact --}}
                <div class="footer-v2-column">
                    <h4 class="footer-v2-column-title">{{ __('home-v2.footer.columns.contact') }}</h4>
                    <ul class="footer-v2-contact">
                        <li class="footer-v2-contact-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span>Québec, QC, Canada</span>
                        </li>
                        <li class="footer-v2-contact-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                            <a href="tel:+4185257748">(418) 525-7748</a>
                        </li>
                        <li class="footer-v2-contact-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <a href="mailto:{{ __('home-v2.common.email') }}">{{ __('home-v2.common.email') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="footer-v2-bottom">
        <div class="footer-v2-container">
            <div class="footer-v2-bottom-content">
                <div class="footer-v2-copyright">
                    <p>{{ __('home-v2.footer.copyright', ['year' => date('Y')]) }}</p>
                </div>
                <div class="footer-v2-legal">
                    <a href="{{ route('privacy.policy') }}" class="footer-v2-legal-link">{{ __('home-v2.footer.legal.privacy') }}</a>
                    <span class="footer-v2-separator">|</span>
                    <a href="{{ route('terms.conditions') }}" class="footer-v2-legal-link">{{ __('home-v2.footer.legal.terms') }}</a>
                </div>
            </div>
        </div>
    </div>
</footer>

