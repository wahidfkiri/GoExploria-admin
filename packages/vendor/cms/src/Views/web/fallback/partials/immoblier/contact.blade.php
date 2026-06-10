<section class="pc-section pc-contact" id="contact">
    <div class="pc-container pc-contact-grid">
        <div class="pc-reveal">
            @php
                $immoblierContactTitle = function_exists('get_contact_form_title')
                    ? get_contact_form_title($etablissement->id, 'Planifiez une visite')
                    : 'Planifiez une visite';
            @endphp
            <span class="pc-eyebrow">Contact</span>
            <h2 class="pc-title">{{ $immoblierContactTitle }}</h2>
            <p class="pc-desc">Remplissez le formulaire pour demander les disponibilités, poser une question ou organiser une visite personnalisée.</p>
            <form class="pc-form" method="POST" action="{{ route('cms.company.contact.send', ['etablissementId' => $etablissement->id]) }}" data-cms-contact-form data-cms-form-name="landing_immoblier">
                @csrf
                <div class="pc-form-grid">
                    <div class="pc-field"><label for="pc-firstname">Prénom</label><input id="pc-firstname" name="first_name" type="text" placeholder="Votre prénom" required></div>
                    <div class="pc-field"><label for="pc-lastname">Nom</label><input id="pc-lastname" name="last_name" type="text" placeholder="Votre nom"></div>
                </div>
                <div class="pc-form-grid">
                    <div class="pc-field"><label for="pc-email">Courriel</label><input id="pc-email" name="email" type="email" placeholder="votre@email.com" required></div>
                    <div class="pc-field"><label for="pc-phone">Téléphone</label><input id="pc-phone" name="phone" type="tel" placeholder="(418) 000-0000"></div>
                </div>
                <div class="pc-field">
                    <label for="pc-unit">Type de logement</label>
                    <select id="pc-unit" name="service">
                        <option value="">Sélectionnez une option</option>
                        <option>3 1/2</option>
                        <option>4 1/2</option>
                        <option>5 1/2</option>
                        <option>Produit ou unité à vendre</option>
                    </select>
                </div>
                <div class="pc-field"><label for="pc-message">Message</label><textarea id="pc-message" name="message" placeholder="Expliquez vos besoins, votre date souhaitée et vos questions." required></textarea></div>
                <button class="pc-btn pc-btn-dark" type="submit">Envoyer la demande <i class="fa-solid fa-paper-plane"></i></button>
            </form>
        </div>
        <div class="pc-contact-info pc-reveal">
            <div class="pc-info-card"><i class="fa-solid fa-phone"></i><div><h3>Téléphone</h3><a href="tel:{{ $phoneDial }}">{{ $phone }}</a></div></div>
            <div class="pc-info-card"><i class="fa-solid fa-envelope"></i><div><h3>Courriel</h3><a href="mailto:{{ $email }}">{{ $email }}</a></div></div>
            <div class="pc-info-card"><i class="fa-solid fa-location-dot"></i><div><h3>Adresse</h3><p>{{ $address }}</p></div></div>
            <div class="pc-info-card"><i class="fa-solid fa-clock"></i><div><h3>Horaire</h3><p>@foreach($workingHours as $row){{ !empty($row['day']) ? $row['day'] . ' : ' : '' }}{{ $row['hours'] ?? '' }}@if(!$loop->last)<br>@endif @endforeach</p></div></div>
        </div>
    </div>
</section>
