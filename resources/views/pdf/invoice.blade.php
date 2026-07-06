@php
    $fmt = static function ($value) use ($currency) {
        return number_format((float) $value, 2, ',', ' ') . ' ' . $currency;
    };
    $taxes = $billingRequest->taxes_breakdown ?? [];
    if (! is_array($taxes)) {
        $taxes = json_decode((string) $taxes, true) ?: [];
    }
    $address = $client['client_address'] ?? null;
    $zipcode = $client['client_zipcode'] ?? null;
    $city    = $client['city'] ?? null;
    $country = $client['country'] ?? null;
    $company = $client['company'] ?? null;
    $vat     = $client['client_vat_number'] ?? null;
    $phone   = $client['phone'] ?? null;
    $email   = $client['email'] ?? null;
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        * { font-family: DejaVu Sans, Arial, sans-serif; }
        body { margin: 0; color: #0f1f3a; font-size: 12px; }
        .wrap { padding: 24px 28px; }
        .header { background: #0f1f3a; color: #fff; padding: 18px 20px; border-radius: 8px; }
        .brand { font-size: 20px; font-weight: bold; letter-spacing: .5px; }
        .brand-sub { font-size: 11px; color: #c7d2fe; }
        .muted { color: #64748b; }
        .label { font-size: 10px; text-transform: uppercase; letter-spacing: .06em; color: #64748b; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; }
        .items th { background: #f1f5f9; color: #475569; text-align: left; padding: 8px; border-bottom: 2px solid #cbd5e1; font-size: 11px; }
        .items td { padding: 8px; border-bottom: 1px solid #e2e8f0; }
        .right { text-align: right; }
        .center { text-align: center; }
        .totrow td { padding: 4px 8px; }
        .total-final td { border-top: 2px solid #0f1f3a; font-weight: bold; font-size: 14px; padding-top: 8px; }
    </style>
</head>
<body>
<div class="wrap">
    <!-- Header -->
    <table class="header">
        <tr>
            <td style="vertical-align:top;">
                <div class="brand">GO EXPLORIA BUSINESS</div>
                <div class="brand-sub">Facture / Invoice</div>
            </td>
            <td class="right" style="vertical-align:top;color:#fff;">
                <div style="font-size:14px;font-weight:bold;">{{ $invoiceNumber }}</div>
                <div style="font-size:11px;color:#c7d2fe;">Émise le {{ $issuedAt->format('d/m/Y') }}</div>
                <div style="font-size:11px;color:#c7d2fe;">Échéance : {{ $dueAt->format('d/m/Y') }}</div>
            </td>
        </tr>
    </table>

    <!-- Client -->
    <table style="margin-top:18px;">
        <tr>
            <td style="vertical-align:top;width:60%;">
                <div class="label">Facturé à</div>
                <div style="font-size:14px;font-weight:bold;margin-top:4px;">{{ $fullName }}</div>
                @if($company)<div>{{ $company }}</div>@endif
                @if($address)<div>{{ $address }}</div>@endif
                @if($zipcode || $city || $country)
                    <div>{{ trim(implode(' ', array_filter([$zipcode, $city]))) }}{{ $country ? ', ' . $country : '' }}</div>
                @endif
                @if($vat)<div>N° TVA/TPS : {{ $vat }}</div>@endif
                <div class="muted" style="margin-top:4px;">
                    @if($email){{ $email }}@endif @if($phone) · {{ $phone }}@endif
                </div>
            </td>
            <td style="vertical-align:top;width:40%;" class="right">
                <div class="label">Émetteur</div>
                <div style="font-size:13px;font-weight:bold;margin-top:4px;">Go Exploria Business</div>
                <div class="muted">info@goexploriabusiness.com</div>
            </td>
        </tr>
    </table>

    <!-- Lignes -->
    <table class="items" style="margin-top:20px;">
        <thead>
            <tr>
                <th>Désignation</th>
                <th class="center">Qté</th>
                <th class="right">P.U. HT</th>
                <th class="right">Total HT</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->title }}</strong>
                        @if(!empty($item->tax_rate))
                            <div class="muted" style="font-size:10px;">TVA/taxe {{ number_format((float) $item->tax_rate, 2, ',', ' ') }}%</div>
                        @endif
                    </td>
                    <td class="center">{{ (int) $item->quantity }}</td>
                    <td class="right">{{ $fmt($item->unit_price) }}</td>
                    <td class="right">{{ $fmt($item->subtotal) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totaux -->
    <table style="margin-top:14px;">
        <tr>
            <td style="width:58%;"></td>
            <td style="width:42%;">
                <table>
                    <tr class="totrow"><td class="muted">Sous-total HT</td><td class="right">{{ $fmt($billingRequest->subtotal) }}</td></tr>
                    @foreach($taxes as $tax)
                        <tr class="totrow"><td class="muted">{{ $tax['name'] ?? ($tax['code'] ?? 'Taxe') }} ({{ number_format((float) ($tax['rate'] ?? 0), 2, ',', ' ') }}%)</td><td class="right">{{ $fmt($tax['amount'] ?? 0) }}</td></tr>
                    @endforeach
                    <tr class="totrow"><td class="muted">Total taxes</td><td class="right">{{ $fmt($billingRequest->tax_total) }}</td></tr>
                    <tr class="total-final"><td>Total TTC</td><td class="right">{{ $fmt($billingRequest->total) }}</td></tr>
                </table>
            </td>
        </tr>
    </table>

    <div style="margin-top:28px;font-size:11px;color:#64748b;">
        Merci pour votre confiance. Pour toute question : info@goexploriabusiness.com.<br>
        © {{ $issuedAt->format('Y') }} Go Exploria Business — Tous droits réservés.
    </div>
</div>
</body>
</html>
