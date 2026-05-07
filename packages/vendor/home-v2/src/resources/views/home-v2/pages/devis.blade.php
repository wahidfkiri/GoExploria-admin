@php
    use Illuminate\Support\Str;

    $plans = collect($plans ?? []);
    $serviceSubjects = $serviceSubjects ?? [];
    $servicesCatalog = $servicesCatalog ?? [];

    $planColors = ['plan-card-a', 'plan-card-b', 'plan-card-c', 'plan-card-d', 'plan-card-e'];

    $iconClass = static function ($icon): string {
        $raw = trim((string) ($icon ?? ''));
        if ($raw === '') {
            return 'fas fa-layer-group';
        }
        if (str_contains($raw, ' ')) {
            return $raw;
        }
        if (str_starts_with($raw, 'fa-')) {
            return 'fas ' . $raw;
        }
        return 'fas fa-' . ltrim($raw, '-');
    };

    $formatPrice = static function ($plan): string {
        $price = $plan->getAttributes()['price'] ?? $plan->price;
        if ($price === null || $price === '' || (float) $price <= 0) {
            return 'Sur demande';
        }
        $cycle = $plan->billing_cycle === 'yearly' ? '/an' : '/mois';
        return number_format((float) $price, 0, ',', ' ') . ' ' . ($plan->currency ?: 'CAD') . ' ' . $cycle;
    };
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de devis | GoExploria</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home-v2/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/navigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/services-mega-menu-v2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-mega-menu-modern.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-destinations-mega.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/footer.css') }}">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(180deg, #eef3fb 0%, #f8fbff 100%);
            color: #0f1f3a;
        }
        .quote-shell {
            max-width: 1380px;
            margin: 132px auto 0;
            padding: 36px 26px 72px;
        }
        .quote-head {
            background: linear-gradient(135deg, #0f1f3a 0%, #1e3a66 100%);
            border-radius: 18px;
            padding: 24px 26px;
            color: #fff;
            margin-bottom: 22px;
            box-shadow: 0 16px 40px rgba(15, 31, 58, 0.22);
        }
        .quote-head h1 {
            margin: 0 0 6px;
            font-size: clamp(30px, 2.8vw, 44px);
            font-weight: 900;
            letter-spacing: .02em;
            text-transform: uppercase;
        }
        .quote-head p {
            margin: 0;
            color: rgba(255, 255, 255, 0.84);
            font-size: 17px;
            line-height: 1.55;
            max-width: 920px;
        }
        .quote-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 360px;
            gap: 20px;
            align-items: start;
        }
        .quote-form-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #dde7f6;
            box-shadow: 0 10px 24px rgba(28, 56, 98, 0.08);
            padding: 24px;
        }
        .alert {
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 13px;
            margin-bottom: 14px;
        }
        .alert-ok {
            border: 1px solid #88d7ae;
            background: #ebf9f1;
            color: #146c43;
        }
        .alert-ko {
            border: 1px solid #efb1b1;
            background: #fff0f0;
            color: #981b1b;
        }
        .form-block + .form-block {
            margin-top: 18px;
        }
        .block-title {
            margin: 0 0 12px;
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: #12284a;
            padding-bottom: 9px;
            border-bottom: 1px solid #edf2fb;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .block-title .step {
            width: 24px;
            height: 24px;
            border-radius: 999px;
            background: #d4af37;
            color: #12284a;
            font-size: 12px;
            font-weight: 900;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 10px;
        }
        .form-group label {
            font-size: 13px;
            font-weight: 700;
            color: #4a5b77;
            letter-spacing: .04em;
            text-transform: uppercase;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            border-radius: 10px;
            border: 1px solid #d4dfef;
            background: #fff;
            color: #10233f;
            padding: 13px 14px;
            font-size: 15px;
            font-family: inherit;
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
        }
        .field-error {
            font-size: 12px;
            color: #b42318;
        }
        .services-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .service-item {
            border: 1px solid #dbe5f5;
            border-radius: 12px;
            background: #f9fbff;
            padding: 10px 12px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .service-item input {
            margin-top: 2px;
            accent-color: #d4af37;
        }
        .service-item strong {
            font-size: 14px;
            color: #10233f;
            display: block;
            margin-bottom: 3px;
        }
        .service-item small {
            font-size: 12.5px;
            color: #6a7a95;
            line-height: 1.45;
        }
        .consent {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            font-size: 12px;
            color: #556784;
            margin-top: 6px;
        }
        .consent input {
            margin-top: 2px;
            accent-color: #d4af37;
        }
        .submit-btn {
            margin-top: 14px;
            width: 100%;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #0f1f3a 0%, #23457a 100%);
            color: #fff;
            font-size: 15px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .05em;
            padding: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(15, 31, 58, 0.25);
        }
        .plans-column {
            position: sticky;
            top: 88px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .plans-title {
            background: #fff;
            border: 1px solid #dde7f6;
            border-radius: 14px;
            padding: 14px;
            box-shadow: 0 8px 20px rgba(22, 48, 83, 0.08);
        }
        .plans-title h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 900;
            color: #12284a;
            text-transform: uppercase;
            letter-spacing: .04em;
        }
        .plans-title p {
            margin: 6px 0 0;
            font-size: 14px;
            color: #6a7a95;
        }
        .plan-card {
            display: block;
            text-decoration: none;
            color: #fff;
            border-radius: 14px;
            padding: 14px;
            box-shadow: 0 10px 24px rgba(12, 30, 58, 0.18);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .plan-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 28px rgba(12, 30, 58, 0.26);
        }
        .plan-card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .plan-card-head i {
            font-size: 18px;
        }
        .plan-card h4 {
            margin: 0 0 6px;
            font-size: 16px;
            font-weight: 900;
            line-height: 1.35;
        }
        .plan-card p {
            margin: 0;
            font-size: 13px;
            line-height: 1.5;
            color: rgba(255, 255, 255, 0.88);
        }
        .plan-price {
            margin-top: 10px;
            font-size: 14px;
            font-weight: 800;
            color: #fff7d8;
        }
        .plan-card-a { background: linear-gradient(135deg, #0b5fb3 0%, #0e84d8 100%); }
        .plan-card-b { background: linear-gradient(135deg, #126d67 0%, #2cae9f 100%); }
        .plan-card-c { background: linear-gradient(135deg, #824a12 0%, #d2912f 100%); }
        .plan-card-d { background: linear-gradient(135deg, #5d2d91 0%, #8f56c4 100%); }
        .plan-card-e { background: linear-gradient(135deg, #842f52 0%, #ca4d85 100%); }

        @media (max-width: 1080px) {
            .quote-grid { grid-template-columns: 1fr; }
            .plans-column { position: static; }
        }
        @media (max-width: 760px) {
            .quote-shell { padding: 28px 14px 60px; margin-top: 112px; }
            .quote-form-card { padding: 16px; }
            .grid-2, .grid-3, .services-grid { grid-template-columns: 1fr; }
            .quote-head { padding: 18px; }
        }
    </style>
</head>
<body>
@include('home-v2.components.VerticalMenu')
@include('home-v2.components.Header')

<div class="quote-shell">
    <div class="quote-head">
        <h1>Demande de devis personnalisée</h1>
        <p>
            Décrivez votre besoin, sélectionnez vos services et recevez une proposition claire par notre équipe.
            Nous traitons votre demande rapidement et vous accompagnons vers le plan le plus adapté.
        </p>
    </div>

    <div class="quote-grid">
        <div class="quote-form-card">
            @if (session('success'))
                <div class="alert alert-ok">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-ko">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-ko">
                    Merci de corriger les champs en erreur avant d’envoyer votre demande.
                </div>
            @endif

            <form method="POST" action="{{ route('devis.submit') }}">
                @csrf

                <div class="form-block">
                    <h2 class="block-title"><span class="step">1</span> Informations client</h2>
                    <div class="grid-2">
                        <div class="form-group">
                            <label for="first_name">Prénom *</label>
                            <input id="first_name" name="first_name" type="text" value="{{ old('first_name') }}" required>
                            @error('first_name')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="last_name">Nom *</label>
                            <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" required>
                            @error('last_name')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required>
                            @error('email')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Téléphone *</label>
                            <input id="phone" name="phone" type="text" value="{{ old('phone') }}" required>
                            @error('phone')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="grid-3">
                        <div class="form-group">
                            <label for="company">Entreprise</label>
                            <input id="company" name="company" type="text" value="{{ old('company') }}">
                            @error('company')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="city">Ville</label>
                            <input id="city" name="city" type="text" value="{{ old('city') }}">
                            @error('city')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="country">Pays</label>
                            <input id="country" name="country" type="text" value="{{ old('country') }}">
                            @error('country')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="preferred_contact">Mode de contact préféré *</label>
                        <select id="preferred_contact" name="preferred_contact" required>
                            <option value="email" @selected(old('preferred_contact') === 'email')>Email</option>
                            <option value="phone" @selected(old('preferred_contact') === 'phone')>Téléphone</option>
                            <option value="whatsapp" @selected(old('preferred_contact') === 'whatsapp')>WhatsApp</option>
                            <option value="zoom" @selected(old('preferred_contact') === 'zoom')>Zoom / visio</option>
                        </select>
                        @error('preferred_contact')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-block">
                    <h2 class="block-title"><span class="step">2</span> Sujet et services sélectionnés</h2>

                    <div class="form-group">
                        <label for="service_subject">Sujet de votre demande *</label>
                        <select id="service_subject" name="service_subject" required>
                            <option value="">Sélectionner un sujet</option>
                            @foreach($serviceSubjects as $subject)
                                <option value="{{ $subject }}" @selected(old('service_subject') === $subject)>{{ $subject }}</option>
                            @endforeach
                        </select>
                        @error('service_subject')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="services-grid">
                        @foreach($servicesCatalog as $service)
                            @php $checked = in_array($service['label'], old('selected_services', []), true); @endphp
                            <label class="service-item">
                                <input
                                    type="checkbox"
                                    name="selected_services[]"
                                    value="{{ $service['label'] }}"
                                    @checked($checked)
                                >
                                <span>
                                    <strong>{{ $service['label'] }}</strong>
                                    <small>{{ $service['description'] }}</small>
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('selected_services')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-block">
                    <h2 class="block-title"><span class="step">3</span> Détails du projet</h2>

                    <div class="grid-3">
                        <div class="form-group">
                            <label for="plan_interest">Plan envisagé</label>
                            <select id="plan_interest" name="plan_interest">
                                <option value="">Aucun plan sélectionné</option>
                                @foreach($plans as $plan)
                                    <option value="{{ $plan->name }}" @selected(old('plan_interest') === $plan->name)>
                                        {{ $plan->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('plan_interest')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="budget">Budget estimatif</label>
                            <select id="budget" name="budget">
                                <option value="">À définir</option>
                                @foreach (['Moins de 2 000 CAD', '2 000 - 5 000 CAD', '5 000 - 10 000 CAD', '10 000 - 20 000 CAD', 'Plus de 20 000 CAD'] as $budget)
                                    <option value="{{ $budget }}" @selected(old('budget') === $budget)>{{ $budget }}</option>
                                @endforeach
                            </select>
                            @error('budget')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="project_deadline">Échéance souhaitée</label>
                            <input id="project_deadline" name="project_deadline" type="date" value="{{ old('project_deadline') }}">
                            @error('project_deadline')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="project_details">Description de votre besoin *</label>
                        <textarea id="project_details" name="project_details" rows="6" required placeholder="Décrivez précisément vos attentes, objectifs, délais et contraintes.">{{ old('project_details') }}</textarea>
                        @error('project_details')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <label class="consent">
                        <input type="checkbox" name="consent" value="1" @checked(old('consent'))>
                        <span>J’accepte que mes informations soient utilisées pour le traitement de ma demande de devis.</span>
                    </label>
                    @error('consent')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i>
                    Envoyer ma demande de devis
                </button>
            </form>
        </div>

        <aside class="plans-column">
            <div class="plans-title">
                <h3>Plans disponibles</h3>
                <p>Comparez rapidement nos plans et choisissez la formule adaptée à votre projet.</p>
            </div>

            @forelse($plans as $index => $plan)
                @php
                    $color = $planColors[$index % count($planColors)];
                    $url = !empty($plan->slug) ? url('/plan-detail/' . $plan->slug) : url('/plans-detail');
                @endphp
                <a href="{{ $url }}" class="plan-card {{ $color }}" target="_blank" rel="noopener noreferrer">
                    <div class="plan-card-head">
                        <i class="{{ $iconClass($plan->icon) }}"></i>
                        <i class="fas fa-arrow-up-right-from-square"></i>
                    </div>
                    <h4>{{ $plan->name }}</h4>
                    <p>{{ Str::limit(strip_tags((string) $plan->description), 95) ?: 'Plan professionnel pour accélérer votre croissance digitale.' }}</p>
                    <div class="plan-price">{{ $formatPrice($plan) }}</div>
                </a>
            @empty
                <a href="{{ url('/plans-detail') }}" class="plan-card plan-card-a" target="_blank" rel="noopener noreferrer">
                    <div class="plan-card-head">
                        <i class="fas fa-layer-group"></i>
                        <i class="fas fa-arrow-up-right-from-square"></i>
                    </div>
                    <h4>Plans GoExploria</h4>
                    <p>Découvrez nos offres Business, Destinations, Partenaires et Espaces médias.</p>
                    <div class="plan-price">Sur demande</div>
                </a>
            @endforelse
        </aside>
    </div>
</div>

@include('home-v2.components.Footer')

<script src="{{ asset('js/home-v2/navigation.js') }}"></script>
<script src="{{ asset('js/home-v2/menu-api-service.js') }}"></script>
<script src="{{ asset('js/home-v2/mega-menu-service.js') }}"></script>
<script src="{{ asset('js/home-v2/vertical-menu-dynamic.js') }}"></script>
<script src="{{ asset('js/home-v2/vertical-menu.js') }}"></script>
<script src="{{ asset('js/home-v2/vertical-destinations-mega.js') }}"></script>
<script src="{{ asset('js/home-v2/mega-menu.js') }}"></script>
<script src="{{ asset('js/home-v2/destinations-mega-menu.js') }}"></script>
<script src="{{ asset('js/home-v2/search-bar.js') }}"></script>
</body>
</html>
