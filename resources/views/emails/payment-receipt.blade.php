@php
    $amount = number_format((float) ($payment?->amount ?? $transaction->amount ?? 0), 2, ',', ' ');
    $currency = strtoupper((string) ($transaction->currency ?? 'CAD'));
    $customerName = trim((string) ($customer?->nom_complet ?? ''));
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recu de paiement GoExploria</title>
</head>
<body style="margin:0;padding:0;background:#f3f6fb;font-family:Arial,Helvetica,sans-serif;color:#10233f;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#f3f6fb;padding:28px 12px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width:720px;background:#ffffff;border-radius:16px;overflow:hidden;border:1px solid #dce6f4;">
                    <tr>
                        <td style="background:#0f1f3a;color:#ffffff;padding:26px 30px;">
                            <div style="font-size:13px;letter-spacing:.08em;text-transform:uppercase;color:#d4af37;font-weight:700;">GoExploria</div>
                            <h1 style="margin:8px 0 0;font-size:28px;line-height:1.2;">Recu de paiement</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px 30px;">
                            <p style="margin:0 0 14px;font-size:16px;line-height:1.6;">
                                Bonjour {{ $customerName !== '' ? $customerName : 'cher client' }},
                            </p>
                            <p style="margin:0 0 22px;font-size:15px;line-height:1.6;color:#4f617c;">
                                Nous confirmons la reception de votre paiement PayPal pour votre demande de devis.
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;margin:0 0 24px;">
                                <tr>
                                    <td style="padding:12px 0;border-bottom:1px solid #edf2fb;color:#61718a;">Reference paiement</td>
                                    <td align="right" style="padding:12px 0;border-bottom:1px solid #edf2fb;font-weight:700;">{{ $payment?->payment_reference ?? $transaction->transaction_id }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0;border-bottom:1px solid #edf2fb;color:#61718a;">Transaction PayPal</td>
                                    <td align="right" style="padding:12px 0;border-bottom:1px solid #edf2fb;font-weight:700;">{{ $transaction->gateway_payment_id ?: $transaction->gateway_transaction_id }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0;border-bottom:1px solid #edf2fb;color:#61718a;">Date</td>
                                    <td align="right" style="padding:12px 0;border-bottom:1px solid #edf2fb;font-weight:700;">{{ $paidAt->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 0;color:#10233f;font-size:18px;font-weight:700;">Montant paye</td>
                                    <td align="right" style="padding:14px 0;color:#10233f;font-size:22px;font-weight:800;">{{ $amount }} {{ $currency }}</td>
                                </tr>
                            </table>

                            @if($billingRequests->isNotEmpty())
                                <h2 style="margin:0 0 12px;font-size:16px;color:#10233f;">Details de la demande</h2>
                                @foreach($billingRequests as $billingRequest)
                                    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border:1px solid #e4ebf6;border-radius:12px;margin:0 0 14px;border-collapse:separate;overflow:hidden;">
                                        <tr>
                                            <td style="padding:14px 16px;background:#f8fbff;font-weight:700;">
                                                {{ $billingRequest->request_number }}
                                            </td>
                                            <td align="right" style="padding:14px 16px;background:#f8fbff;font-weight:700;">
                                                {{ number_format((float) $billingRequest->total, 2, ',', ' ') }} {{ strtoupper((string) data_get($billingRequest->metadata, 'currency', $currency)) }}
                                            </td>
                                        </tr>
                                        @foreach($billingRequest->items as $item)
                                            <tr>
                                                <td style="padding:10px 16px;border-top:1px solid #edf2fb;color:#4f617c;">
                                                    {{ $item->title }} x{{ $item->quantity }}
                                                </td>
                                                <td align="right" style="padding:10px 16px;border-top:1px solid #edf2fb;color:#10233f;">
                                                    {{ number_format((float) $item->total, 2, ',', ' ') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endforeach
                            @endif

                            <p style="margin:22px 0 0;font-size:13px;line-height:1.6;color:#6b7b93;">
                                Merci pour votre confiance. Notre equipe vous contactera rapidement pour la suite de votre projet.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
