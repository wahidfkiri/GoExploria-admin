@php
    $fmt = static function ($value) use ($currency) {
        return number_format((float) $value, 2, ',', ' ') . ' ' . $currency;
    };
    $taxes = $billingRequest->taxes_breakdown ?? [];
    if (! is_array($taxes)) {
        $taxes = json_decode((string) $taxes, true) ?: [];
    }
    $address  = $client['client_address'] ?? null;
    $zipcode  = $client['client_zipcode'] ?? null;
    $city     = $client['city'] ?? null;
    $country  = $client['country'] ?? null;
    $company  = $client['company'] ?? null;
    $vat      = $client['client_vat_number'] ?? null;
    $phone    = $client['phone'] ?? null;
    $email    = $client['email'] ?? null;
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture {{ $invoiceNumber }}</title>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:Arial,Helvetica,sans-serif;color:#0f1f3a;">
    <div style="max-width:640px;margin:0 auto;padding:24px;">
        <div style="background:#ffffff;border-radius:14px;overflow:hidden;border:1px solid #e2e8f0;">

            <!-- En-tête -->
            <div style="background:linear-gradient(135deg,#0f1f3a,#23457a);color:#fff;padding:26px 28px;">
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td style="vertical-align:top;">
                            <div style="font-size:22px;font-weight:800;letter-spacing:.5px;">GO EXPLORIA</div>
                            <div style="font-size:13px;opacity:.85;margin-top:4px;">Facture / Invoice</div>
                        </td>
                        <td style="vertical-align:top;text-align:right;">
                            <div style="font-size:15px;font-weight:700;">{{ $invoiceNumber }}</div>
                            <div style="font-size:12px;opacity:.85;margin-top:4px;">Émise le {{ $issuedAt->format('d/m/Y') }}</div>
                            <div style="font-size:12px;opacity:.85;">Échéance : {{ $dueAt->format('d/m/Y') }}</div>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Client -->
            <div style="padding:22px 28px;border-bottom:1px solid #edf2f7;">
                <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:8px;">Facturé à</div>
                <div style="font-size:15px;font-weight:700;">{{ $fullName }}</div>
                @if($company)<div style="font-size:13px;color:#334155;">{{ $company }}</div>@endif
                @if($address)<div style="font-size:13px;color:#334155;">{{ $address }}</div>@endif
                @if($zipcode || $city || $country)
                    <div style="font-size:13px;color:#334155;">{{ trim(implode(' ', array_filter([$zipcode, $city]))) }}{{ $country ? ', ' . $country : '' }}</div>
                @endif
                @if($vat)<div style="font-size:13px;color:#334155;">N° TVA/TPS : {{ $vat }}</div>@endif
                <div style="font-size:13px;color:#334155;margin-top:6px;">
                    @if($email){{ $email }}@endif @if($phone) · {{ $phone }}@endif
                </div>
            </div>

            <!-- Lignes -->
            <div style="padding:22px 28px;">
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;font-size:13px;">
                    <thead>
                        <tr style="background:#f8fafc;color:#475569;">
                            <th align="left"  style="padding:10px 8px;border-bottom:2px solid #e2e8f0;">Désignation</th>
                            <th align="center" style="padding:10px 8px;border-bottom:2px solid #e2e8f0;">Qté</th>
                            <th align="right" style="padding:10px 8px;border-bottom:2px solid #e2e8f0;">P.U. HT</th>
                            <th align="right" style="padding:10px 8px;border-bottom:2px solid #e2e8f0;">Total HT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td style="padding:10px 8px;border-bottom:1px solid #edf2f7;">
                                    <div style="font-weight:600;color:#0f1f3a;">{{ $item->title }}</div>
                                    @if(!empty($item->tax_rate))
                                        <div style="font-size:11px;color:#94a3b8;">TVA/taxe {{ number_format((float) $item->tax_rate, 2, ',', ' ') }}%</div>
                                    @endif
                                </td>
                                <td align="center" style="padding:10px 8px;border-bottom:1px solid #edf2f7;">{{ (int) $item->quantity }}</td>
                                <td align="right" style="padding:10px 8px;border-bottom:1px solid #edf2f7;">{{ $fmt($item->unit_price) }}</td>
                                <td align="right" style="padding:10px 8px;border-bottom:1px solid #edf2f7;">{{ $fmt($item->subtotal) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Totaux -->
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-top:16px;font-size:13px;">
                    <tr>
                        <td></td>
                        <td width="240">
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td style="padding:5px 0;color:#475569;">Sous-total HT</td>
                                    <td align="right" style="padding:5px 0;font-weight:600;">{{ $fmt($billingRequest->subtotal) }}</td>
                                </tr>
                                @foreach($taxes as $tax)
                                    <tr>
                                        <td style="padding:5px 0;color:#475569;">{{ $tax['name'] ?? ($tax['code'] ?? 'Taxe') }} ({{ number_format((float) ($tax['rate'] ?? 0), 2, ',', ' ') }}%)</td>
                                        <td align="right" style="padding:5px 0;">{{ $fmt($tax['amount'] ?? 0) }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td style="padding:5px 0;color:#475569;">Total taxes</td>
                                    <td align="right" style="padding:5px 0;">{{ $fmt($billingRequest->tax_total) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 0;border-top:2px solid #0f1f3a;font-weight:800;font-size:15px;">Total TTC</td>
                                    <td align="right" style="padding:10px 0;border-top:2px solid #0f1f3a;font-weight:800;font-size:15px;color:#0f1f3a;">{{ $fmt($billingRequest->total) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Pied -->
            <div style="padding:18px 28px;background:#f8fafc;border-top:1px solid #edf2f7;font-size:12px;color:#64748b;line-height:1.6;">
                <p style="margin:0 0 6px;">Merci pour votre confiance. Cette facture vous est adressée suite à votre demande sur Go Exploria.</p>
                <p style="margin:0;">Pour toute question, répondez simplement à cet email ou contactez-nous à infogoexploria@gmail.com.</p>
            </div>
        </div>
        <div style="text-align:center;color:#94a3b8;font-size:11px;margin-top:16px;">© {{ $issuedAt->format('Y') }} Go Exploria — Tous droits réservés.</div>
    </div>
</body>
</html>
