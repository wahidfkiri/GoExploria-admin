<?php

namespace App\Services\Payment;

use App\Models\BillingRequest;
use App\Models\Customer;
use App\Models\DevisRequest;
use App\Models\Payment;
use App\Models\PaymentGateway;
use App\Models\PaymentTransaction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use RuntimeException;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Throwable;

class DevisPayPalCheckoutService
{
    public function createCheckout(Collection $billingRequests, DevisRequest $devisRequest): string
    {
        $billingRequests = $billingRequests->filter(fn ($request) => $request instanceof BillingRequest)->values();

        if ($billingRequests->isEmpty()) {
            throw new RuntimeException('Aucune demande de devis payable.');
        }

        $amount = $this->totalAmount($billingRequests);
        if ($amount <= 0) {
            throw new RuntimeException('Le montant a payer doit etre superieur a zero.');
        }

        $currency = $this->currencyFor($billingRequests);
        $etablissementId = (int) $billingRequests->first()->etablissement_id;
        $customer = $this->customerFor($devisRequest, $etablissementId);
        $gateway = $this->gatewayFor($etablissementId);
        $requestIds = $billingRequests->pluck('id')->map(fn ($id) => (int) $id)->all();

        $provider = $this->paypalProvider($currency);
        $order = $provider->setRequestHeader('Prefer', 'return=representation')->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'reference_id' => 'devis-' . $devisRequest->id,
                'description' => Str::limit('Demande de devis GoExploria #' . $devisRequest->id, 120, ''),
                'custom_id' => (string) $devisRequest->id,
                'invoice_id' => 'DEVIS-' . $devisRequest->id . '-' . now()->format('YmdHis'),
                'amount' => [
                    'currency_code' => $currency,
                    'value' => $this->paypalAmount($amount),
                ],
            ]],
            'application_context' => [
                'brand_name' => 'GoExploria',
                'locale' => config('paypal.locale', 'fr_CA'),
                'shipping_preference' => 'NO_SHIPPING',
                'user_action' => 'PAY_NOW',
                'return_url' => route('devis.paypal.success'),
                'cancel_url' => route('devis.paypal.cancel'),
            ],
        ]);

        $paypalOrderId = (string) ($order['id'] ?? '');
        $approvalUrl = $this->approvalUrl($order);

        if ($paypalOrderId === '' || $approvalUrl === '') {
            throw new RuntimeException('PayPal n a pas retourne de lien de paiement valide.');
        }

        DB::transaction(function () use ($amount, $currency, $etablissementId, $customer, $gateway, $requestIds, $devisRequest, $paypalOrderId, $order): void {
            $payment = Payment::create([
                'etablissement_id' => $etablissementId,
                'client_id' => $customer->id,
                'payment_date' => now()->toDateString(),
                'amount' => $amount,
                'method' => 'paypal',
                'transaction_id' => $paypalOrderId,
                'status' => 'en_attente',
                'notes' => 'Paiement PayPal cree depuis la page devis.',
                'metadata' => [
                    'source' => 'devis_page',
                    'devis_request_id' => (int) $devisRequest->id,
                    'billing_request_ids' => $requestIds,
                    'paypal_order_id' => $paypalOrderId,
                ],
            ]);

            PaymentTransaction::create([
                'etablissement_id' => $etablissementId,
                'payment_id' => $payment->id,
                'client_id' => $customer->id,
                'payment_gateway_id' => $gateway?->id,
                'gateway_type' => 'paypal',
                'amount' => $amount,
                'currency' => $currency,
                'status' => 'pending',
                'gateway_transaction_id' => $paypalOrderId,
                'gateway_status' => (string) ($order['status'] ?? 'CREATED'),
                'gateway_response' => $order,
                'metadata' => [
                    'source' => 'devis_page',
                    'devis_request_id' => (int) $devisRequest->id,
                    'billing_request_ids' => $requestIds,
                    'customer_email' => $devisRequest->email,
                    'approval_created_at' => now()->toIso8601String(),
                    'receipt_sent' => false,
                ],
            ]);
        });

        return $approvalUrl;
    }

    public function captureCheckout(string $paypalOrderId): array
    {
        $paypalOrderId = trim($paypalOrderId);

        if ($paypalOrderId === '') {
            throw new RuntimeException('Identifiant PayPal manquant.');
        }

        $transaction = PaymentTransaction::query()
            ->with(['payment', 'client'])
            ->where('gateway_type', 'paypal')
            ->where('gateway_transaction_id', $paypalOrderId)
            ->first();

        if (!$transaction) {
            throw new RuntimeException('Transaction PayPal introuvable.');
        }

        if ($transaction->status === 'completed') {
            return [
                'transaction' => $transaction,
                'payment' => $transaction->payment,
                'receipt_sent' => (bool) data_get($transaction->metadata, 'receipt_sent', false),
                'already_completed' => true,
            ];
        }

        $currency = strtoupper((string) $transaction->currency);
        $provider = $this->paypalProvider($currency);
        $captureResponse = $provider->setRequestHeader('Prefer', 'return=representation')->capturePaymentOrder($paypalOrderId);
        $capture = data_get($captureResponse, 'purchase_units.0.payments.captures.0', []);
        $captureStatus = strtoupper((string) ($capture['status'] ?? $captureResponse['status'] ?? ''));

        if ($captureStatus !== 'COMPLETED') {
            $transaction->update([
                'status' => 'failed',
                'gateway_status' => $captureStatus ?: 'FAILED',
                'gateway_response' => $captureResponse,
                'error_message' => 'Capture PayPal non complete.',
            ]);

            $transaction->payment?->update([
                'status' => 'echoue',
                'metadata' => array_merge($transaction->payment->metadata ?? [], [
                    'paypal_capture_status' => $captureStatus,
                ]),
            ]);

            throw new RuntimeException('Le paiement PayPal n a pas ete confirme.');
        }

        $receiptSent = false;

        DB::transaction(function () use ($transaction, $captureResponse, $capture, &$receiptSent): void {
            $captureId = (string) ($capture['id'] ?? data_get($captureResponse, 'id', ''));
            $metadata = array_merge($transaction->metadata ?? [], [
                'paypal_capture_id' => $captureId,
                'paypal_capture_status' => (string) ($capture['status'] ?? 'COMPLETED'),
                'captured_at' => now()->toIso8601String(),
            ]);

            $transaction->update([
                'status' => 'completed',
                'gateway_payment_id' => $captureId,
                'gateway_status' => (string) ($capture['status'] ?? 'COMPLETED'),
                'gateway_response' => $captureResponse,
                'metadata' => $metadata,
                'error_message' => null,
                'error_details' => null,
            ]);

            if ($transaction->payment) {
                $transaction->payment->update([
                    'status' => 'complete',
                    'payment_date' => now()->toDateString(),
                    'transaction_id' => $captureId ?: $transaction->gateway_transaction_id,
                    'metadata' => array_merge($transaction->payment->metadata ?? [], [
                        'paypal_capture_id' => $captureId,
                        'paypal_capture_status' => (string) ($capture['status'] ?? 'COMPLETED'),
                    ]),
                ]);
            }

            $billingRequestIds = collect(data_get($transaction->metadata, 'billing_request_ids', []))
                ->map(fn ($id) => (int) $id)
                ->filter()
                ->values()
                ->all();

            if (!empty($billingRequestIds)) {
                BillingRequest::whereIn('id', $billingRequestIds)->update([
                    'status' => 'closed',
                    'processed_at' => now(),
                ]);
            }
        });

        try {
            $this->sendReceipt($transaction->fresh(['payment', 'client']));
            $receiptSent = true;
            $this->markReceiptSent($transaction, true);
        } catch (Throwable $e) {
            report($e);
            $this->markReceiptSent($transaction, false, Str::limit($e->getMessage(), 500, ''));
        }

        return [
            'transaction' => $transaction->fresh(['payment', 'client']),
            'payment' => $transaction->payment?->fresh(),
            'receipt_sent' => $receiptSent,
            'already_completed' => false,
        ];
    }

    public function cancelCheckout(?string $paypalOrderId): void
    {
        $paypalOrderId = trim((string) $paypalOrderId);

        if ($paypalOrderId === '') {
            return;
        }

        $transaction = PaymentTransaction::query()
            ->with('payment')
            ->where('gateway_type', 'paypal')
            ->where('gateway_transaction_id', $paypalOrderId)
            ->first();

        if (!$transaction || $transaction->status === 'completed') {
            return;
        }

        $transaction->update([
            'status' => 'failed',
            'gateway_status' => 'CANCELLED',
            'notes' => trim(($transaction->notes ? $transaction->notes . "\n" : '') . 'Paiement annule par le client.'),
        ]);

        $transaction->payment?->update([
            'status' => 'echoue',
            'notes' => trim(($transaction->payment->notes ? $transaction->payment->notes . "\n" : '') . 'Paiement PayPal annule par le client.'),
        ]);
    }

    private function paypalProvider(string $currency): PayPalClient
    {
        $provider = new PayPalClient($this->paypalConfig($currency));
        $provider->getAccessToken();

        return $provider;
    }

    private function paypalConfig(string $currency): array
    {
        $config = config('paypal');
        $config['currency'] = strtoupper($currency ?: ($config['currency'] ?? 'CAD'));

        return $config;
    }

    private function approvalUrl(array $order): string
    {
        foreach (($order['links'] ?? []) as $link) {
            if (($link['rel'] ?? '') === 'approve' && !empty($link['href'])) {
                return (string) $link['href'];
            }
        }

        return '';
    }

    private function customerFor(DevisRequest $devisRequest, int $etablissementId): Customer
    {
        return Customer::updateOrCreate(
            [
                'etablissement_id' => $etablissementId,
                'email' => $devisRequest->email,
            ],
            [
                'type' => $devisRequest->company ? 'entreprise' : 'particulier',
                'prenom' => $devisRequest->first_name,
                'nom' => $devisRequest->last_name,
                'telephone' => $devisRequest->phone,
                'entreprise_nom' => $devisRequest->company,
                'ville' => $devisRequest->city,
                'pays' => $devisRequest->country ?: 'Canada',
                'mode_reglement_prefere' => 'paypal',
            ]
        );
    }

    private function gatewayFor(int $etablissementId): ?PaymentGateway
    {
        return PaymentGateway::query()
            ->where('type', 'paypal')
            ->where('is_active', true)
            ->where(function ($query) use ($etablissementId): void {
                $query->where('etablissement_id', $etablissementId)
                    ->orWhere('is_default', true);
            })
            ->orderByRaw('CASE WHEN etablissement_id = ? THEN 0 ELSE 1 END', [$etablissementId])
            ->orderByDesc('is_default')
            ->orderBy('order')
            ->first();
    }

    private function totalAmount(Collection $billingRequests): float
    {
        return round($billingRequests->sum(fn (BillingRequest $request) => (float) $request->total), 2);
    }

    private function currencyFor(Collection $billingRequests): string
    {
        $currency = (string) data_get($billingRequests->first()?->metadata, 'currency', config('paypal.currency', 'CAD'));

        return strtoupper($currency ?: 'CAD');
    }

    private function paypalAmount(float $amount): string
    {
        return number_format(round($amount, 2), 2, '.', '');
    }

    private function sendReceipt(PaymentTransaction $transaction): void
    {
        $payment = $transaction->payment;
        $customer = $transaction->client;
        $email = (string) ($customer?->email ?: data_get($transaction->metadata, 'customer_email', ''));

        if ($email === '') {
            throw new RuntimeException('Adresse email client manquante pour le recu.');
        }

        $billingRequestIds = collect(data_get($transaction->metadata, 'billing_request_ids', []))
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->values()
            ->all();

        $billingRequests = BillingRequest::query()
            ->with('items')
            ->whereIn('id', $billingRequestIds)
            ->get();

        Mail::send('emails.payment-receipt', [
            'transaction' => $transaction,
            'payment' => $payment,
            'customer' => $customer,
            'billingRequests' => $billingRequests,
            'paidAt' => now(),
        ], function ($message) use ($email, $customer, $payment): void {
            $name = trim((string) ($customer?->nom_complet ?? ''));
            $message->to($email, $name !== '' ? $name : null)
                ->subject('Votre recu de paiement GoExploria ' . ($payment?->payment_reference ? '- ' . $payment->payment_reference : ''));
        });
    }

    private function markReceiptSent(PaymentTransaction $transaction, bool $sent, ?string $error = null): void
    {
        $fresh = $transaction->fresh();
        if (!$fresh) {
            return;
        }

        $metadata = array_merge($fresh->metadata ?? [], [
            'receipt_sent' => $sent,
            'receipt_sent_at' => $sent ? now()->toIso8601String() : null,
            'receipt_error' => $error,
        ]);

        $fresh->update(['metadata' => $metadata]);
    }
}
