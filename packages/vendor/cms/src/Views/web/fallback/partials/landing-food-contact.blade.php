{{-- ═══════════════════════════════════════════════════════════════════════
     Section « Contact » de la landing commerce-alimentaire.
     Coordonnées de l'établissement + formulaire de demande envoyé via le
     handler mutualisé landing-contact-ajax. Utilise les classes .food-*
     définies dans landing-commerce-alimentaire.blade.php.
     Nécessite : $etablissement, $address, $phone, $email.
     ═══════════════════════════════════════════════════════════════════════ --}}
<section class="food-section food-section-pad" id="contact" style="padding:20px;">
    <div class="food-contact-grid">
        <div>
            @php
                $foodContactTitle = function_exists('get_contact_form_title')
                    ? get_contact_form_title($etablissement->id, 'Planifiez une commande ou une demande de devis')
                    : 'Planifiez une commande ou une demande de devis';
            @endphp
            <span class="food-kicker">Contact</span>
            <h2 class="food-title">{{ $foodContactTitle }}</h2>
            <p class="food-copy">{{ $address }}</p>
            @if($phone)<p><strong>Téléphone :</strong> <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}">{{ $phone }}</a></p>@endif
            @if($email)<p><strong>Courriel :</strong> <a href="mailto:{{ $email }}">{{ $email }}</a></p>@endif
            <form class="food-form" id="foodContactForm" method="POST" action="{{ route('cms.company.contact.send', ['etablissementId' => $etablissement->id]) }}" data-cms-contact-form data-cms-form-name="landing_commerce_alimentaire">
                @csrf
                <div class="food-form-row">
                    <input name="first_name" placeholder="Prénom" required>
                    <input name="last_name" placeholder="Nom">
                </div>
                <div class="food-form-row">
                    <input name="email" type="email" placeholder="Courriel" required>
                    <input name="phone" placeholder="Téléphone">
                </div>
                <select name="service">
                    <option>Produits frais</option>
                    <option>Plateaux et coffrets</option>
                    <option>Commande spéciale</option>
                    <option>Demande de partenariat</option>
                </select>
                <textarea name="message" placeholder="Décrivez votre besoin" required></textarea>
                <button class="food-btn food-btn-primary" type="submit">Envoyer ma demande</button>
            </form>
        </div>
    </div>
</section>
