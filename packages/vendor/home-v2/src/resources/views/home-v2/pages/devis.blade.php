@php
    use Illuminate\Support\Str;

    $plans = collect($plans ?? []);
    $serviceSubjects = $serviceSubjects ?? [];
    $servicesCatalog = collect($billingServices ?? $servicesCatalog ?? []);
    $oldServiceQuantities = collect(old('service_quantities', []))
        ->mapWithKeys(fn ($quantity, $serviceId) => [(string) $serviceId => max(0, (int) $quantity)])
        ->all();
    $servicesCatalogJson = $servicesCatalog->values()->toJson(JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG);
    $activeTaxes = collect($activeTaxes ?? []);
    $activeTaxesJson = $activeTaxes->values()->toJson(JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG);

    // Récupérer les discounts disponibles
    $availableDiscounts = \App\Models\BillingDiscount::query()
        ->active()
        ->orderBy('id')
        ->get(['id', 'name', 'code', 'type', 'value', 'description']);
    $availableDiscountsJson = $availableDiscounts->values()->toJson(JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG);

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
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            grid-template-columns: 1fr;
            gap: 14px;
        }
        .service-card {
            border: 1px solid #dbe5f5;
            border-radius: 16px;
            background: #f9fbff;
            overflow: hidden;
            display: grid;
            grid-template-columns: minmax(240px, 32%) minmax(0, 1fr);
            min-height: 210px;
            transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
        }
        .service-card.is-selected {
            border-color: #d4af37;
            box-shadow: 0 14px 30px rgba(21, 44, 83, .12);
            transform: translateY(-1px);
        }
        .service-media {
            position: relative;
            background: linear-gradient(135deg, #12284a, #1d4f85);
            min-height: 210px;
            overflow: hidden;
        }
        .service-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            cursor: pointer;
            transition: transform 0.3s ease, filter 0.3s ease;
        }
        .service-media img:hover {
            transform: scale(1.03);
            filter: brightness(1.05);
        }
        .service-media::after {
            content: '\f00e';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            bottom: 12px;
            right: 12px;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            border-radius: 50%;
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .service-media:hover::after {
            opacity: 1;
        }
        .service-media-placeholder {
            width: 100%;
            height: 100%;
            min-height: 210px;
            display: grid;
            place-items: center;
            color: rgba(255,255,255,.88);
            font-size: 44px;
        }
        .service-body {
            padding: 18px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .service-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }
        .service-title {
            font-size: 14px;
            font-weight: 900;
            color: #10233f;
            line-height: 1.35;
        }
        .service-description {
            font-size: 12.5px;
            color: #6a7a95;
            line-height: 1.45;
        }
        .service-price {
            white-space: nowrap;
            text-align: right;
            color: #0f1f3a;
            font-weight: 900;
            font-size: 14px;
        }
        .service-price small {
            display: block;
            color: #73839d;
            font-size: 11px;
            font-weight: 700;
            margin-top: 2px;
        }
        .service-meta {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            font-size: 11px;
            color: #556784;
        }
        .service-pill {
            display: none !important;
        }
        .qty-control {
            margin-top: auto;
            display: grid;
            grid-template-columns: 34px 58px 34px minmax(92px, 1fr);
            gap: 8px;
            align-items: center;
        }
        .qty-btn {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            border: 1px solid #d4dfef;
            background: #fff;
            color: #10233f;
            font-weight: 900;
            cursor: pointer;
            transition: background 0.2s ease;
        }
        .qty-btn:hover {
            background: #f0f4fe;
        }
        .qty-input {
            height: 34px;
            text-align: center;
            border-radius: 10px;
            border: 1px solid #d4dfef;
            font-weight: 900;
        }
        .line-total {
            text-align: right;
            font-size: 12px;
            color: #50617d;
            font-weight: 800;
        }
        .empty-services {
            border: 1px dashed #b9c7dc;
            border-radius: 14px;
            background: #f8fbff;
            padding: 18px;
            color: #5d6d88;
            line-height: 1.6;
        }
        .quote-summary {
            margin-top: 14px;
            border-radius: 14px;
            background: #0f1f3a;
            color: #fff;
            padding: 16px;
            position: sticky;
            top: 96px;
        }
        .quote-summary h3 {
            margin: 0 0 12px;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: .05em;
        }
        .summary-line {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255,255,255,.12);
            color: rgba(255,255,255,.84);
            font-size: 13px;
        }
        .summary-line strong {
            color: #fff;
        }
        .summary-line.is-hidden {
            display: none;
        }
        .summary-line.total {
            border-bottom: 0;
            font-size: 18px;
            font-weight: 900;
            color: #fff;
            padding-top: 12px;
            border-top: 2px solid rgba(255,255,255,.2);
        }
        .summary-tax-list {
            margin: 10px 0 4px;
            padding: 10px 12px;
            border-radius: 10px;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.12);
        }
        .summary-tax-title {
            color: rgba(255,255,255,.72);
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: 6px;
        }
        .summary-tax-row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            color: rgba(255,255,255,.86);
            font-size: 12px;
            padding: 3px 0;
        }
        .summary-tax-row strong {
            color: #fff;
            white-space: nowrap;
        }
        .summary-help {
            margin: 10px 0 0;
            color: rgba(255,255,255,.7);
            font-size: 12px;
            line-height: 1.5;
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
        .form-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 14px;
        }
        .form-actions .submit-btn {
            margin-top: 0;
        }
        .submit-btn--request {
            background: linear-gradient(135deg, #0f1f3a 0%, #23457a 100%);
        }
        .submit-btn--paypal {
            background: linear-gradient(135deg, #ffc439 0%, #f4ad18 100%);
            color: #10233f;
        }
        .submit-btn--paypal:hover {
            box-shadow: 0 14px 28px rgba(244, 173, 24, 0.28);
        }
        .submit-btn.is-loading {
            pointer-events: none;
            opacity: .7;
        }
        .submit-btn.is-loading::after {
            content: '';
            width: 16px;
            height: 16px;
            border: 2px solid transparent;
            border-top-color: currentColor;
            border-radius: 50%;
            animation: devis-spin .6s linear infinite;
            display: inline-block;
        }
        @keyframes devis-spin {
            to { transform: rotate(360deg); }
        }
        .field-error {
            color: #e74c3c;
            font-size: 13px;
            display: block;
            margin-top: 4px;
        }
        .is-invalid {
            border-color: #e74c3c !important;
        }
        #devis-toast {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 99999;
            background: #27ae60;
            color: #fff;
            padding: 16px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 8px 30px rgba(39,174,96,.35);
            transform: translateX(120%);
            transition: transform .35s cubic-bezier(.22,.68,0,1);
            max-width: 420px;
            display: flex;
            align-items: center;
            gap: 10px;
            line-height: 1.4;
        }
        #devis-toast.is-visible {
            transform: translateX(0);
        }
        #devis-toast i {
            font-size: 20px;
            flex-shrink: 0;
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
        .plans-title ul {
            margin: 8px 0 0;
            padding-left: 18px;
            color: #6a7a95;
        }
        .plans-title ul li {
            font-size: 13px;
            padding: 2px 0;
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

        /* Styles pour le sélecteur de discount */
        .discount-selector {
            margin-top: 12px;
            padding: 12px 14px;
            background: rgba(255,255,255,0.05);
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .discount-selector label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: rgba(255,255,255,0.7);
            margin-bottom: 6px;
        }
        .discount-selector select {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid rgba(255,255,255,0.15);
            background: rgba(255,255,255,0.08);
            color: #fff;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            cursor: pointer;
            transition: border-color 0.2s ease;
        }
        .discount-selector select:focus {
            border-color: #d4af37;
        }
        .discount-selector select option {
            background: #1a2a4a;
            color: #fff;
        }
        .discount-selector .discount-info {
            font-size: 11px;
            color: rgba(255,255,255,0.6);
            margin-top: 4px;
            font-style: italic;
        }
        .discount-selector .discount-info strong {
            color: #d4af37;
        }

        /* Modal pour l'affichage des images */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.88);
            z-index: 99999;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            backdrop-filter: blur(8px);
            animation: modalFadeIn 0.3s ease;
            padding: 20px;
        }
        .modal-overlay.is-active {
            display: flex;
        }
        .modal-content {
            max-width: 92vw;
            max-height: 92vh;
            position: relative;
            animation: modalZoomIn 0.3s ease;
            cursor: default;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .modal-image-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            min-height: 200px;
        }
        .modal-image-wrapper img {
            max-width: 92vw;
            max-height: 80vh;
            object-fit: contain;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
            display: block;
            background: #1a1a2e;
            transition: transform 0.3s ease;
        }
        .modal-image-wrapper img.zoomed-in {
            transform: scale(1.8);
            cursor: grab;
        }
        .modal-image-wrapper img.zoomed-in:active {
            cursor: grabbing;
        }
        .modal-controls {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            transform: translateY(-50%);
            display: flex;
            justify-content: space-between;
            padding: 0 10px;
            pointer-events: none;
            z-index: 10;
        }
        .modal-controls button {
            pointer-events: auto;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }
        .modal-controls button:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }
        .modal-controls button:active {
            transform: scale(0.95);
        }
        .modal-controls button.zoom-btn {
            width: 44px;
            height: 44px;
            font-size: 16px;
        }
        .modal-top-controls {
            position: absolute;
            top: -56px;
            right: 0;
            display: flex;
            gap: 10px;
            align-items: center;
            z-index: 10;
        }
        .modal-top-controls button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }
        .modal-top-controls button:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }
        .modal-close {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }
        .modal-close:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(90deg);
        }
        .modal-caption {
            margin-top: 12px;
            text-align: center;
            color: rgba(255, 255, 255, 0.85);
            font-size: 14px;
            font-weight: 500;
            padding: 10px 16px;
            background: rgba(0, 0, 0, 0.4);
            border-radius: 8px;
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            max-width: 90%;
        }
        .modal-zoom-indicator {
            position: absolute;
            bottom: -40px;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255, 255, 255, 0.5);
            font-size: 12px;
            background: rgba(0, 0, 0, 0.3);
            padding: 4px 12px;
            border-radius: 12px;
            backdrop-filter: blur(4px);
            white-space: nowrap;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .modal-zoom-indicator.visible {
            opacity: 1;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes modalZoomIn {
            from { transform: scale(0.92); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        @media (max-width: 1080px) {
            .quote-grid { grid-template-columns: 1fr; }
            .plans-column { position: static; }
        }
        @media (max-width: 760px) {
            .quote-shell { padding: 28px 14px 60px; margin-top: 112px; }
            .quote-form-card { padding: 16px; }
            .grid-2, .grid-3, .services-grid { grid-template-columns: 1fr; }
            .service-card { grid-template-columns: 1fr; }
            .service-media, .service-media-placeholder { min-height: 180px; }
            .quote-summary { position: static; }
            .quote-head { padding: 18px; }
            .form-actions { grid-template-columns: 1fr; }
            .modal-image-wrapper img {
                max-width: 95vw;
                max-height: 75vh;
            }
            .modal-image-wrapper img.zoomed-in {
                transform: scale(1.5);
            }
            .modal-caption {
                font-size: 12px;
                padding: 8px 12px;
                margin-top: 8px;
            }
            .modal-controls button {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }
            .modal-controls button.zoom-btn {
                width: 36px;
                height: 36px;
                font-size: 14px;
            }
            .modal-top-controls {
                top: -48px;
            }
            .modal-top-controls button {
                width: 34px;
                height: 34px;
                font-size: 14px;
            }
            .modal-close {
                width: 38px;
                height: 38px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
@include('home-v2.components.VerticalMenu')
@include('home-v2.components.Header')

<div class="quote-shell">
    <div class="quote-head">
        <h1>AFFICHEZ-VOUS personnalisée</h1>
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
                    Merci de corriger les champs en erreur avant d'envoyer votre demande.
                </div>
            @endif

            <div id="devis-alerts"></div>
            <form method="POST" action="{{ route('devis.submit') }}" enctype="multipart/form-data">
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
                    <h2 class="block-title"><span class="step">2</span> Services sélectionnés</h2>

                    @if($servicesCatalog->isNotEmpty())
                        <div class="services-grid" id="servicesGrid">
                            @foreach($servicesCatalog as $service)
                                @php
                                    $serviceId = (string) data_get($service, 'id');
                                    $quantity = $oldServiceQuantities[$serviceId] ?? 0;
                                    $price = (float) data_get($service, 'unit_price', 0);
                                @endphp
                                <article class="service-card {{ $quantity > 0 ? 'is-selected' : '' }}" data-service-card data-service-id="{{ $serviceId }}">
                                    <div class="service-media">
                                        @if(data_get($service, 'image_url'))
                                            <img src="{{ data_get($service, 'image_url') }}" alt="{{ data_get($service, 'title') }}" loading="lazy">
                                        @else
                                            <div class="service-media-placeholder"><i class="fas fa-briefcase"></i></div>
                                        @endif
                                    </div>
                                    <div class="service-body">
                                        <div class="service-top">
                                            <div>
                                                <div class="service-title">{{ data_get($service, 'title') }}</div>
                                                @if(data_get($service, 'description'))
                                                    <div class="service-description">{{ Str::limit(strip_tags((string) data_get($service, 'description')), 110) }}</div>
                                                @endif
                                            </div>
                                            <div class="service-price">
                                                {{ number_format($price, 2, ',', ' ') }} CAD
                                                <small>HT / {{ data_get($service, 'billing_unit', 'forfait') }}</small>
                                            </div>
                                        </div>
                                        <div class="service-meta">
                                            @if(data_get($service, 'etablissement_name'))
                                                <span class="service-pill">{{ data_get($service, 'etablissement_name') }}</span>
                                            @endif
                                        </div>
                                        <div class="qty-control">
                                            <button class="qty-btn" type="button" data-qty-minus data-service-id="{{ $serviceId }}">-</button>
                                            <input
                                                class="qty-input"
                                                type="number"
                                                min="0"
                                                max="999"
                                                step="1"
                                                name="service_quantities[{{ $serviceId }}]"
                                                value="{{ $quantity }}"
                                                data-service-qty
                                                data-service-id="{{ $serviceId }}"
                                                aria-label="Quantite {{ data_get($service, 'title') }}"
                                            >
                                            <button class="qty-btn" type="button" data-qty-plus data-service-id="{{ $serviceId }}">+</button>
                                            <div class="line-total" data-line-total="{{ $serviceId }}">0,00 CAD HT</div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <!-- Sélecteur de discount -->
                        <div class="quote-summary" id="quoteSummary">
                            <h3>Calcul automatique</h3>
                            <div class="summary-line"><span>Total services HT</span><strong data-summary="gross">0,00 CAD</strong></div>
                            <div class="summary-line is-hidden" data-discount-line><span data-discount-label>Remise</span><strong data-summary="discount">0,00 CAD</strong></div>
                            <div class="summary-line"><span>Frais</span><strong data-summary="fees">0,00 CAD</strong></div>
                            <div class="summary-line"><span>Total HT après remise</span><strong data-summary="subtotal">0,00 CAD</strong></div>

                            @if($activeTaxes->isNotEmpty())
                                <div class="summary-tax-list">
                                    <div class="summary-tax-title">Taxes actives (appliquées globalement)</div>
                                    @foreach($activeTaxes as $tax)
                                        <div class="summary-tax-row">
                                            <span>{{ $tax->name }} ({{ $tax->code }})</span>
                                            <strong>{{ number_format((float) $tax->rate, 2, ',', ' ') }}%</strong>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div id="taxBreakdownContainer" style="margin-top:8px;">
                                <div class="summary-line">
                                    <span>TVA / taxes (globales)</span>
                                    <strong data-summary="tax">0,00 CAD</strong>
                                </div>
                                <div id="taxBreakdownList" style="margin-top:6px;color:rgba(255,255,255,.84);font-size:12px;">
                                    <!-- breakdown inserted here -->
                                </div>
                            </div>

                            <div class="summary-line total"><span>Total TTC</span><strong data-summary="total">0,00 CAD</strong></div>

                            <!-- Sélecteur de discount -->
                            <div class="discount-selector">
                                <label for="discount_select">Code de réduction</label>
                                <select id="discount_select" name="discount_id">
                                    <option value="">Aucune remise</option>
                                    @foreach($availableDiscounts as $discount)
                                        <option value="{{ $discount->id }}" 
                                            data-type="{{ $discount->type }}" 
                                            data-value="{{ $discount->value }}"
                                            data-name="{{ $discount->name }}">
                                            {{ $discount->name }} 
                                            ({{ $discount->type === 'fixed' ? number_format($discount->value, 2, ',', ' ') . ' CAD' : number_format($discount->value, 2, ',', ' ') . '%' }})
                                            @if($discount->code) - {{ $discount->code }} @endif
                                        </option>
                                    @endforeach
                                </select>
                                <div class="discount-info" id="discountInfo">
                                    Sélectionnez un code de réduction pour l'appliquer à votre commande
                                </div>
                            </div>

                            <p class="summary-help">✓ Les taxes sont appliquées UNIQUEMENT sur le total global HT après remise.<br>
                            ✓ Chaque ligne affiche son montant HT sans taxe individuelle.</p>
                        </div>
                    @else
                        <div class="empty-services">
                            Aucun service de devis n'est configuré actuellement dans <strong>billing_request_services</strong>.
                            Ajoutez des services actifs avec prix, image et taxe pour les afficher ici.
                        </div>
                    @endif
                    @error('service_quantities')<span class="field-error">{{ $message }}</span>@enderror
                    @error('service_quantities.*')<span class="field-error">{{ $message }}</span>@enderror
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
                        <label for="project_details">Description de votre besoin</label>
                        <textarea id="project_details" name="project_details" rows="6" placeholder="Décrivez précisément vos attentes, objectifs, délais et contraintes.">{{ old('project_details') }}</textarea>
                        @error('project_details')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <label class="consent">
                        <input type="checkbox" name="consent" value="1" checked>
                        <span style="color:#ffc439;font-size:15px;font-weight:700;">J'accepte que mes informations soient utilisées pour le traitement de ma demande de devis.</span>
                    </label>
                    @error('consent')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-block">
                    <h2 class="block-title"><span class="step">4</span> Médias et documents</h2>
                    <div class="form-group">
                        <label for="media_files">Fichiers joints (images, PDF, XLSX, CSV, DOC...)</label>
                        <input id="media_files" name="media_files[]" type="file" multiple accept=".jpg,.jpeg,.png,.gif,.webp,.bmp,.svg,.pdf,.csv,.txt,.xls,.xlsx,.ods,.doc,.docx,.ppt,.pptx,.zip,.rar">
                        <small style="color:#6a7a95;">Maximum 10 fichiers, 20 Mo par fichier.</small>
                        @error('media_files')<span class="field-error">{{ $message }}</span>@enderror
                        @error('media_files.*')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <!-- Champ caché pour le discount sélectionné -->
                <input type="hidden" name="selected_discount_id" id="selected_discount_id" value="">

                <div class="form-actions">
                    <button type="submit" name="checkout_action" value="request" class="submit-btn submit-btn--request">
                        <i class="fas fa-paper-plane"></i>
                        Envoyer ma demande de devis
                    </button>
                    <button type="submit" name="checkout_action" value="pay_now" class="submit-btn submit-btn--paypal">
                        <i class="fab fa-paypal"></i>
                        Payer maintenant
                    </button>
                </div>
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

            @if(!empty($activeTaxes) && $activeTaxes->isNotEmpty())
                <div class="plans-title" style="margin-top:12px;">
                    <h3>Taxes actives</h3>
                    <p>Taxes globales actuellement actives</p>
                    <ul>
                        @foreach($activeTaxes as $tax)
                            <li>{{ $tax->name }} ({{ $tax->code }}): {{ number_format($tax->rate, 2, ',', ' ') }}%</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($availableDiscounts->isNotEmpty())
                <div class="plans-title" style="margin-top:12px;">
                    <h3>Codes promo disponibles</h3>
                    <p>Codes de réduction actifs</p>
                    <ul>
                        @foreach($availableDiscounts as $discount)
                            <li>
                                <strong>{{ $discount->name }}</strong>
                                @if($discount->code) ({{ $discount->code }}) @endif
                                : {{ $discount->type === 'fixed' ? number_format($discount->value, 2, ',', ' ') . ' CAD' : number_format($discount->value, 2, ',', ' ') . '%' }}
                                @if($discount->description) - {{ $discount->description }} @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </aside>
    </div>
</div>

@include('home-v2.components.Footer')

<div id="devis-toast"><i class="fas fa-check-circle"></i><span id="devis-toast-msg"></span></div>

<!-- Modal pour l'affichage des images -->
<div class="modal-overlay" id="imageModal" onclick="closeImageModal(event)">
    <div class="modal-content" onclick="event.stopPropagation();">
        <div class="modal-top-controls">
            <button onclick="zoomOutImage()" title="Réduire" aria-label="Réduire">
                <i class="fas fa-search-minus"></i>
            </button>
            <button onclick="zoomInImage()" title="Agrandir" aria-label="Agrandir">
                <i class="fas fa-search-plus"></i>
            </button>
            <button class="modal-close" onclick="closeImageModal()" aria-label="Fermer">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-image-wrapper" id="modalImageWrapper">
            <img id="modalImage" src="" alt="Aperçu du service">
            <div class="modal-controls">
                <button onclick="zoomOutImage()" title="Réduire" aria-label="Réduire" class="zoom-btn">
                    <i class="fas fa-minus"></i>
                </button>
                <button onclick="zoomInImage()" title="Agrandir" aria-label="Agrandir" class="zoom-btn">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="modal-zoom-indicator" id="zoomIndicator">100%</div>
        </div>
        <div class="modal-caption" id="modalCaption"></div>
    </div>
</div>

<script src="{{ asset('js/home-v2/navigation.js') }}"></script>
<script src="{{ asset('js/home-v2/menu-api-service.js') }}"></script>
<script src="{{ asset('js/home-v2/mega-menu-service.js') }}"></script>
<script src="{{ asset('js/home-v2/vertical-menu-dynamic.js') }}"></script>
<script src="{{ asset('js/home-v2/vertical-menu.js') }}"></script>
<script src="{{ asset('js/home-v2/vertical-destinations-mega.js') }}"></script>
<script src="{{ asset('js/home-v2/mega-menu.js') }}"></script>
<script src="{{ asset('js/home-v2/destinations-mega-menu.js') }}"></script>
<script src="{{ asset('js/home-v2/search-bar.js') }}"></script>
<script>
    window.devisBillingServices = {!! $servicesCatalogJson ?: '[]' !!};
    window.devisActiveTaxes = {!! $activeTaxesJson ?: '[]' !!};
    window.availableDiscounts = {!! $availableDiscountsJson ?: '[]' !!};

    (function () {
        const services = new Map((window.devisBillingServices || []).map((service) => [String(service.id), service]));
        const activeTaxes = Array.isArray(window.devisActiveTaxes) ? window.devisActiveTaxes : [];
        const availableDiscounts = Array.isArray(window.availableDiscounts) ? window.availableDiscounts : [];
        const firstCurrency = (window.devisBillingServices || []).find((service) => service.currency)?.currency || 'CAD';
        const currency = /^[A-Z]{3}$/.test(String(firstCurrency).toUpperCase()) ? String(firstCurrency).toUpperCase() : 'CAD';
        const formatter = new Intl.NumberFormat('fr-CA', { style: 'currency', currency: currency });
        const summary = document.getElementById('quoteSummary');
        const discountSelect = document.getElementById('discount_select');
        const discountInfo = document.getElementById('discountInfo');
        const selectedDiscountId = document.getElementById('selected_discount_id');

        let selectedDiscount = null;

        function parseRate(val) {
            if (val === null || val === undefined) return 0;
            const s = String(val).trim();
            if (s === '') return 0;
            const cleaned = s.replace(/\s*%\s*$/,'').replace(',', '.').replace('%', '');
            const num = parseFloat(cleaned);
            return Number.isFinite(num) ? num : 0;
        }

        function money(value) {
            return formatter.format(Number.isFinite(value) ? value : 0);
        }

        function quantityInput(id) {
            return document.querySelector('[data-service-qty][data-service-id="' + id + '"]');
        }

        function setQuantity(id, value) {
            const input = quantityInput(id);
            if (!input) return;
            input.value = Math.max(0, Math.min(999, parseInt(value || 0, 10) || 0));
            recalculate();
        }

        function getDiscountFromSelect() {
            const select = discountSelect;
            if (!select) return null;
            const selectedOption = select.options[select.selectedIndex];
            if (!selectedOption || !selectedOption.value) return null;
            
            return {
                id: parseInt(selectedOption.value),
                name: selectedOption.dataset.name || 'Remise',
                type: selectedOption.dataset.type || 'percentage',
                value: parseFloat(selectedOption.dataset.value) || 0
            };
        }

        function updateDiscountInfo(discount) {
            if (!discountInfo) return;
            if (!discount) {
                discountInfo.innerHTML = 'Sélectionnez un code de réduction pour l\'appliquer à votre commande';
                return;
            }
            const value = discount.type === 'fixed' ? money(discount.value) : discount.value.toFixed(2) + '%';
            discountInfo.innerHTML = `<strong>${discount.name}</strong> : ${value} de réduction appliquée sur le total HT`;
        }

        function recalculate() {
            let gross = 0;
            let discountTotal = 0;
            let feesTotal = 0;
            let subtotal = 0;
            let tax = 0;
            let total = 0;
            const groups = new Map();
            const taxRates = {};
            const taxNames = {};
            const taxesByCode = {};

            // Récupérer le discount sélectionné
            selectedDiscount = getDiscountFromSelect();
            updateDiscountInfo(selectedDiscount);

            services.forEach((service, id) => {
                const input = quantityInput(id);
                const qty = Math.max(0, parseInt(input?.value || 0, 10) || 0);
                const unit = Number(service.unit_price || 0);
                const lineGross = unit * qty;
                const groupId = String(service.etablissement_id || 'global');
                if (!groups.has(groupId)) {
                    groups.set(groupId, {
                        gross: 0,
                        shipping: Number(service.shipping_fees || 0),
                        administration: Number(service.administration_fees || 0),
                        services: [],
                        totalGross: 0
                    });
                }
                const group = groups.get(groupId);
                group.services = group.services || [];
                group.services.push({ service, qty, lineGross });
                group.totalGross = (group.totalGross || 0) + lineGross;
            });

            // Calcul des remises
            let globalDiscountAmount = 0;
            const discountRule = selectedDiscount;
            
            // Calcul du total brut global
            groups.forEach((group) => {
                gross += group.totalGross;
            });

            // Application de la remise globale
            if (discountRule && gross > 0) {
                const value = Math.max(0, discountRule.value);
                if (discountRule.type === 'fixed') {
                    globalDiscountAmount = Math.min(gross, value);
                } else {
                    globalDiscountAmount = gross * (Math.min(100, value) / 100);
                }
                discountTotal = globalDiscountAmount;
            }

            // Calcul détaillé par service
            services.forEach((service, id) => {
                const input = quantityInput(id);
                const qty = Math.max(0, parseInt(input?.value || 0, 10) || 0);
                const unit = Number(service.unit_price || 0);
                const lineGross = unit * qty;
                const group = groups.get(String(service.etablissement_id || 'global'));
                
                // Répartition proportionnelle de la remise
                const lineDiscount = group && group.totalGross > 0 && globalDiscountAmount > 0 
                    ? globalDiscountAmount * (lineGross / group.totalGross) 
                    : 0;
                const lineSubtotal = lineGross - lineDiscount;

                subtotal += lineSubtotal;

                document.querySelector('[data-line-total="' + id + '"]')?.replaceChildren(document.createTextNode(money(lineSubtotal) + ' HT'));
                document.querySelector('[data-service-card][data-service-id="' + id + '"]')?.classList.toggle('is-selected', qty > 0);
            });

            // Ajout des frais
            groups.forEach((group) => {
                if (group.totalGross <= 0) return;
                const fees = Math.max(0, group.shipping) + Math.max(0, group.administration);
                if (fees > 0) {
                    feesTotal += fees;
                    subtotal += fees;
                }
            });

            // Calcul des taxes globales
            if (activeTaxes.length > 0) {
                activeTaxes.forEach(function(tax) {
                    const code = String(tax.code || 'TAX');
                    const rate = parseRate(tax.rate);
                    if (rate > 0 && subtotal > 0) {
                        taxRates[code] = rate;
                        taxNames[code] = taxNames[code] || tax.name || code;
                    }
                });
            }

            let computedTaxTotal = 0;
            Object.keys(taxRates).forEach(function(code) {
                const rate = Number(taxRates[code] || 0);
                if (rate > 0 && subtotal > 0) {
                    let amount = subtotal * (rate / 100);
                    amount = Math.round(amount * 100) / 100;
                    taxesByCode[code] = { 
                        name: taxNames[code] || code, 
                        code: code, 
                        rate: rate, 
                        amount: amount 
                    };
                    computedTaxTotal += amount;
                }
            });

            tax = Math.round(computedTaxTotal * 100) / 100;
            total = Math.round((subtotal + tax) * 100) / 100;

            // Mise à jour du résumé
            if (!summary) return;
            summary.querySelector('[data-summary="gross"]').textContent = money(gross);
            summary.querySelector('[data-summary="discount"]').textContent = discountTotal > 0 ? '- ' + money(discountTotal) : '0,00 CAD';
            summary.querySelector('[data-summary="fees"]').textContent = money(feesTotal);
            summary.querySelector('[data-summary="subtotal"]').textContent = money(subtotal);
            summary.querySelector('[data-summary="tax"]').textContent = money(tax);
            summary.querySelector('[data-summary="total"]').textContent = money(total);
            
            const discountLine = summary.querySelector('[data-discount-line]');
            if (discountLine) {
                discountLine.classList.toggle('is-hidden', discountTotal <= 0);
                const label = summary.querySelector('[data-discount-label]');
                if (label && discountRule) {
                    label.textContent = discountRule.name || 'Remise';
                }
            }

            // Mise à jour du breakdown des taxes
            const breakdownContainer = document.getElementById('taxBreakdownList');
            if (breakdownContainer) {
                breakdownContainer.replaceChildren();
                const codes = Object.keys(taxesByCode);
                if (codes.length > 0) {
                    codes.forEach(function (code) {
                        const item = taxesByCode[code];
                        const div = document.createElement('div');
                        div.style.display = 'flex';
                        div.style.justifyContent = 'space-between';
                        div.style.padding = '2px 0';
                        const labelSpan = document.createElement('span');
                        labelSpan.textContent = `${item.name} (${item.code}) ${Number(item.rate).toFixed(2)}%`;
                        const valueSpan = document.createElement('strong');
                        valueSpan.textContent = money(item.amount);
                        valueSpan.style.color = '#fff';
                        div.appendChild(labelSpan);
                        div.appendChild(valueSpan);
                        breakdownContainer.appendChild(div);
                    });
                } else {
                    const div = document.createElement('div');
                    div.textContent = 'Aucune taxe appliquée';
                    div.style.color = 'rgba(255,255,255,0.6)';
                    div.style.fontStyle = 'italic';
                    breakdownContainer.appendChild(div);
                }
            }

            // Mettre à jour le champ caché avec l'ID du discount sélectionné
            if (selectedDiscountId) {
                selectedDiscountId.value = selectedDiscount ? selectedDiscount.id : '';
            }
        }

        // === Gestion des événements ===
        document.addEventListener('click', function (event) {
            const plus = event.target.closest('[data-qty-plus]');
            const minus = event.target.closest('[data-qty-minus]');
            if (plus) {
                const id = plus.getAttribute('data-service-id');
                const input = quantityInput(id);
                setQuantity(id, (parseInt(input?.value || 0, 10) || 0) + 1);
            }
            if (minus) {
                const id = minus.getAttribute('data-service-id');
                const input = quantityInput(id);
                setQuantity(id, (parseInt(input?.value || 0, 10) || 0) - 1);
            }
        });

        document.addEventListener('input', function (event) {
            if (event.target.matches('[data-service-qty]')) {
                recalculate();
            }
        });

        // Écouter le changement de discount
        if (discountSelect) {
            discountSelect.addEventListener('change', function() {
                recalculate();
            });
        }

        // === Gestion du modal d'images avec zoom ===
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const modalCaption = document.getElementById('modalCaption');
        const imageWrapper = document.getElementById('modalImageWrapper');
        const zoomIndicator = document.getElementById('zoomIndicator');
        let currentZoom = 1;
        const minZoom = 0.5;
        const maxZoom = 3;
        let isDragging = false;
        let startX, startY, translateX = 0, translateY = 0;

        function updateZoom() {
            if (!modalImg) return;
            const zoom = currentZoom;
            modalImg.style.transform = `scale(${zoom}) translate(${translateX}px, ${translateY}px)`;
            modalImg.classList.toggle('zoomed-in', zoom > 1);
            if (zoomIndicator) {
                zoomIndicator.textContent = Math.round(zoom * 100) + '%';
                zoomIndicator.classList.add('visible');
                clearTimeout(zoomIndicator._timeout);
                zoomIndicator._timeout = setTimeout(function() {
                    zoomIndicator.classList.remove('visible');
                }, 2000);
            }
        }

        window.zoomInImage = function() {
            if (currentZoom < maxZoom) {
                currentZoom = Math.min(currentZoom + 0.25, maxZoom);
                updateZoom();
            }
        };

        window.zoomOutImage = function() {
            if (currentZoom > minZoom) {
                currentZoom = Math.max(currentZoom - 0.25, minZoom);
                if (currentZoom === 1) {
                    translateX = 0;
                    translateY = 0;
                }
                updateZoom();
            }
        };

        function resetZoom() {
            currentZoom = 1;
            translateX = 0;
            translateY = 0;
            updateZoom();
        }

        function startDrag(e) {
            if (currentZoom <= 1) return;
            isDragging = true;
            const touch = e.touches ? e.touches[0] : e;
            startX = touch.clientX - translateX;
            startY = touch.clientY - translateY;
            modalImg.style.cursor = 'grabbing';
            e.preventDefault();
        }

        function moveDrag(e) {
            if (!isDragging) return;
            const touch = e.touches ? e.touches[0] : e;
            translateX = touch.clientX - startX;
            translateY = touch.clientY - startY;
            updateZoom();
            e.preventDefault();
        }

        function endDrag() {
            isDragging = false;
            modalImg.style.cursor = 'grab';
        }

        modalImg?.addEventListener('mousedown', startDrag);
        document.addEventListener('mousemove', moveDrag);
        document.addEventListener('mouseup', endDrag);
        modalImg?.addEventListener('touchstart', startDrag, { passive: false });
        document.addEventListener('touchmove', moveDrag, { passive: false });
        document.addEventListener('touchend', endDrag);

        modalImg?.addEventListener('wheel', function(e) {
            e.preventDefault();
            if (e.deltaY < 0) {
                window.zoomInImage();
            } else {
                window.zoomOutImage();
            }
        }, { passive: false });

        window.openImageModal = function(imageSrc, imageAlt) {
            if (!modal || !modalImg) return;
            resetZoom();
            modalImg.src = imageSrc;
            modalImg.alt = imageAlt || 'Aperçu du service';
            if (modalCaption) {
                modalCaption.textContent = imageAlt || 'Service GoExploria';
            }
            modal.classList.add('is-active');
            document.body.style.overflow = 'hidden';
        };

        window.closeImageModal = function(event) {
            if (event && event.target !== event.currentTarget) return;
            if (!modal) return;
            modal.classList.remove('is-active');
            document.body.style.overflow = '';
            resetZoom();
        };

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImageModal();
            }
            if (event.key === '+' || event.key === '=') {
                if (modal.classList.contains('is-active')) {
                    event.preventDefault();
                    zoomInImage();
                }
            }
            if (event.key === '-') {
                if (modal.classList.contains('is-active')) {
                    event.preventDefault();
                    zoomOutImage();
                }
            }
        });

        modal?.addEventListener('wheel', function(event) {
            if (event.target === modalImg) return;
            event.stopPropagation();
        }, { passive: true });

        function initImageClickHandlers() {
            document.querySelectorAll('.service-media img').forEach(function(img) {
                const card = img.closest('.service-card');
                const title = card?.querySelector('.service-title')?.textContent?.trim() || img.alt || 'Service GoExploria';
                img.style.cursor = 'pointer';
                img.title = 'Cliquez pour agrandir';
                
                img.removeEventListener('click', imageClickHandler);
                img.addEventListener('click', imageClickHandler);
                img.dataset.serviceTitle = title;
            });
        }

        function imageClickHandler(event) {
            event.stopPropagation();
            const img = event.currentTarget;
            const src = img.getAttribute('src');
            if (!src) return;
            const title = img.dataset.serviceTitle || img.alt || 'Service GoExploria';
            openImageModal(src, title);
        }

        const observer = new MutationObserver(function() {
            initImageClickHandlers();
        });

        document.addEventListener('DOMContentLoaded', function() {
            initImageClickHandlers();
            const servicesGrid = document.getElementById('servicesGrid');
            if (servicesGrid) {
                observer.observe(servicesGrid, {
                    childList: true,
                    subtree: true,
                    attributes: false
                });
            }
            recalculate();
        });

        window.addEventListener('load', function() {
            initImageClickHandlers();
            recalculate();
        });

        window.recalculate = recalculate;
    })();
</script>
<script>
(function() {
    var toast = document.getElementById('devis-toast');
    var toastMsg = document.getElementById('devis-toast-msg');
    var toastTimer;

    function showToast(msg) {
        toastMsg.textContent = msg;
        toast.classList.add('is-visible');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function() { toast.classList.remove('is-visible'); }, 5000);
    }

    var form = document.querySelector('form[action*="devis"]');
    if (!form) return;

    var alertsContainer = document.getElementById('devis-alerts');
    var lastClickBtn = null;

    form.querySelectorAll('button[type="submit"]').forEach(function(btn) {
        btn.addEventListener('click', function() { lastClickBtn = this; });
    });

    function showAlert(type, message) {
        var div = document.createElement('div');
        div.className = type === 'success' ? 'alert alert-ok' : 'alert alert-ko';
        div.textContent = message;
        alertsContainer.replaceChildren(div);
        div.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function clearFieldErrors() {
        form.querySelectorAll('.field-error').forEach(function(el) { el.remove(); });
        form.querySelectorAll('.is-invalid').forEach(function(el) { el.classList.remove('is-invalid'); });
    }

    function showFieldErrors(errors) {
        for (var field in errors) {
            if (!errors.hasOwnProperty(field)) continue;
            var baseField = field.split('.')[0];
            var input = form.querySelector('[name="' + field + '"]')
                || form.querySelector('[name="' + baseField + '"]')
                || form.querySelector('[name="' + baseField + '[]"]')
                || form.querySelector('[name^="' + baseField + '["]');
            if (!input) continue;
            input.classList.add('is-invalid');
            var span = document.createElement('span');
            span.className = 'field-error';
            span.textContent = errors[field][0] || 'Erreur';
            input.parentNode.appendChild(span);
        }
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        var submitter = e.submitter || lastClickBtn;
        if (!submitter) {
            form.submit();
            return;
        }
        lastClickBtn = null;

        var formData = new FormData(form);
        if (submitter.name) {
            formData.append(submitter.name, submitter.value);
        }

        form.querySelectorAll('button[type="submit"]').forEach(function(btn) { btn.disabled = true; });
        submitter.classList.add('is-loading');
        clearFieldErrors();

        try {
            var response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData,
            });

            var data = await response.json();

            if (!response.ok) {
                if (response.status === 422 && data.errors) {
                    showFieldErrors(data.errors);
                    if (data.message) showAlert('error', data.message);
                } else if (data.error) {
                    showAlert('error', data.error);
                } else {
                    showAlert('error', 'Une erreur est survenue. Veuillez réessayer.');
                }
                return;
            }

            if (data.paypal_url) {
                window.location.href = data.paypal_url;
                return;
            }

            if (data.success) {
                form.reset();
                if (window.recalculate) window.recalculate();
                showToast(data.success);
            }
        } catch (err) {
            showAlert('error', 'Erreur de connexion. Veuillez vérifier votre réseau et réessayer.');
        } finally {
            form.querySelectorAll('button[type="submit"]').forEach(function(btn) { btn.disabled = false; });
            submitter.classList.remove('is-loading');
        }
    });
})();
</script>
</body>
</html>