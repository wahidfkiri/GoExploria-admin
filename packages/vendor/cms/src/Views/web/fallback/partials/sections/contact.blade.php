{{-- Section Contact (formulaire statique → enregistré en base via AJAX + infos établissement) --}}
@php
    $contactTitle = function_exists('get_contact_form_title') ? get_contact_form_title($etablissement->id, 'Nous contacter') : 'Nous contacter';
@endphp
<section class="lp-section alt" id="contact">
    <div class="container">
        <div class="lp-head">
            <div>
                <div class="lp-kicker">Contact</div>
                <h2 class="lp-title">{{ $contactTitle }}</h2>
            </div>
            <p class="lp-sub">Envoyez votre demande directement à l'établissement. Le message est enregistré dans les contacts CMS.</p>
        </div>
        <div class="lp-contact-grid">
            <aside class="lp-info">
                <div class="lp-info-list">
                    @if($phone)<div class="lp-info-item"><i class="fa-solid fa-phone"></i><div><strong>Téléphone</strong><a href="tel:{{ $phoneHref }}">{{ $phone }}</a></div></div>@endif
                    @if($email)<div class="lp-info-item"><i class="fa-solid fa-envelope"></i><div><strong>Courriel</strong><a href="mailto:{{ $email }}">{{ $email }}</a></div></div>@endif
                    @if($address)<div class="lp-info-item"><i class="fa-solid fa-location-dot"></i><div><strong>Adresse</strong><span>{{ $address }}</span></div></div>@endif
                    @if(!empty($workingHours))
                        <div class="lp-info-item">
                            <i class="fa-solid fa-clock"></i>
                            <div>
                                <strong>Horaire</strong>
                                <span>
                                    @foreach($workingHours as $row)
                                        {{ !empty($row['day']) ? $row['day'] . ' : ' : '' }}{{ $row['hours'] ?? '' }}
                                        @if(!$loop->last)<br>@endif
                                    @endforeach
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
                @if(($socialLinks ?? collect())->isNotEmpty())
                    <div class="lp-social">
                        @foreach($socialLinks as $link)
                            <a href="{{ data_get($link, 'url') }}" target="_blank" rel="noopener noreferrer" aria-label="{{ data_get($link, 'label') }}"><i class="{{ data_get($link, 'icon') ?: 'fa-solid fa-share-nodes' }}"></i></a>
                        @endforeach
                    </div>
                @endif
            </aside>
            <form class="lp-form" method="POST" action="{{ route('cms.company.contact.send', ['etablissementId' => $etablissement->id]) }}" data-cms-contact-form data-cms-form-name="landing">
                @csrf
                <div class="lp-form-row">
                    <div class="lp-field"><label>Prénom</label><input name="first_name" type="text" required></div>
                    <div class="lp-field"><label>Nom</label><input name="last_name" type="text"></div>
                </div>
                <div class="lp-form-row">
                    <div class="lp-field"><label>Courriel</label><input name="email" type="email" required></div>
                    <div class="lp-field"><label>Téléphone</label><input name="phone" type="tel"></div>
                </div>
                <div class="lp-field"><label>Message</label><textarea name="message" required placeholder="Votre message…"></textarea></div>
                <button class="lp-submit" type="submit">Envoyer la demande <i class="fa-solid fa-paper-plane"></i></button>
            </form>
        </div>
    </div>
</section>
