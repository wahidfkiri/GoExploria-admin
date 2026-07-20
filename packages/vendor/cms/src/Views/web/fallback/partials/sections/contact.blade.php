{{-- Section Contact — pilotée par la config CMS (admin → « Configuration du
     formulaire de contact »). Mêmes champs/labels/couleurs/required que le
     widget modal. Envoi AJAX mutualisé (data-cms-contact-form) → contacts CMS. --}}
@php
    $cfg   = \Vendor\Cms\Support\ContactFormConfig::for($etablissement ?? null);
    $cfgF  = $cfg['fields'] ?? [];
@endphp

@once
<style>
    .lp-contact-form { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; align-items: start; }
    .lp-contact-form .lp-field { grid-column: 1 / -1; }
    .lp-contact-form .lp-field--half { grid-column: auto; }
    .lp-contact-form .lp-submit { grid-column: 1 / -1; }
    .lp-contact-form .lp-req { color: #ef4444; }
    .lp-contact-form .lp-check { display: flex; align-items: flex-start; gap: 9px; font-weight: 500; cursor: pointer; }
    .lp-contact-form .lp-check input { margin-top: 4px; }
    @media (max-width: 640px) { .lp-contact-form { grid-template-columns: 1fr; } }
</style>
@endonce

<section class="lp-section alt" id="contact">
    <div class="container">
        <div class="lp-head">
            <div>
                <div class="lp-kicker">Contact</div>
                <h2 class="lp-title" style="color:{{ $cfg['title_color'] }};">{{ $cfg['title'] }}</h2>
            </div>
            @if(($cfg['subtitle'] ?? '') !== '')
                <p class="lp-sub" style="color:{{ $cfg['subtitle_color'] }};">{{ $cfg['subtitle'] }}</p>
            @endif
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

            <form class="lp-form lp-contact-form"
                  method="POST"
                  enctype="multipart/form-data"
                  action="{{ route('cms.company.contact.send', ['etablissementId' => $etablissement->id]) }}"
                  data-cms-contact-form
                  data-cms-form-name="landing"
                  data-loading-text="Envoi en cours...">
                @csrf

                @foreach($cfgF as $key => $f)
                    @continue(empty($f['enabled']))
                    @php
                        $type = $f['type'] ?? 'text';
                        $isCheckbox = $type === 'checkbox';
                        $isTextarea = $type === 'textarea';
                        $half = !empty($f['half']) && !$isCheckbox && !$isTextarea;
                        $label = $f['label'] ?? '';
                        $required = !empty($f['required']);
                        $placeholder = (string) ($f['placeholder'] ?? '');
                        $default = (string) ($f['default'] ?? '');
                    @endphp

                    @if($isCheckbox)
                        <div class="lp-field">
                            <label class="lp-check">
                                <input type="checkbox" name="{{ $key }}" value="1" @if($required) required @endif>
                                <span>{{ $label }}</span>
                            </label>
                        </div>
                    @elseif($isTextarea)
                        <div class="lp-field">
                            <label>{{ $label }} @if($required)<span class="lp-req">*</span>@endif</label>
                            <textarea name="{{ $key }}" placeholder="{{ $placeholder }}" @if($required) required @endif>{{ $default }}</textarea>
                        </div>
                    @else
                        <div class="lp-field {{ $half ? 'lp-field--half' : '' }}">
                            <label>{{ $label }} @if($required)<span class="lp-req">*</span>@endif</label>
                            <input type="{{ $type }}" name="{{ $key }}" placeholder="{{ $placeholder }}" value="{{ $default }}" @if($required) required @endif>
                        </div>
                    @endif
                @endforeach

                <button class="lp-submit" type="submit">{{ $cfg['submit_label'] ?? 'Envoyer la demande' }} <i class="fa-solid fa-paper-plane"></i></button>
            </form>
        </div>
    </div>
</section>
