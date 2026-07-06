<?php

namespace App\Services\Payment;

use App\Models\BillingRequest;
use App\Models\Customer;
use App\Models\DevisRequest;
use App\Models\Etablissement;
use App\Models\Payment;
use App\Models\PaymentGateway;
use App\Models\PaymentTransaction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Throwable;

class DevisPayPalCheckoutService
{
    private const DEFAULT_CURRENCY = 'CAD';

    /**
     * Crée une session de paiement PayPal
     */
    public function createCheckout(Collection $billingRequests, DevisRequest $devisRequest, string $paymentMethod = 'paypal'): string
    {
        $billingRequests = $billingRequests->filter(fn ($request) => $request instanceof BillingRequest)->values();

        if ($billingRequests->isEmpty()) {
            throw new RuntimeException('Aucune demande de devis payable.');
        }

        $amount = $this->totalAmount($billingRequests);
        if ($amount <= 0) {
            throw new RuntimeException('Le montant à payer doit être supérieur à zéro.');
        }

        $currency = $this->currencyFor($billingRequests);
        $customer = $this->customerFor($devisRequest);
        $gateway = $this->gatewayFor();
        $requestIds = $billingRequests->pluck('id')->map(fn ($id) => (int) $id)->all();

        $orderPayload = [
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
                'locale' => str_replace('_', '-', config('paypal.locale', 'fr-FR')),
                'shipping_preference' => 'NO_SHIPPING',
                'user_action' => 'PAY_NOW',
                // 'BILLING' affiche d'abord le formulaire carte bancaire (paiement invité),
                // 'LOGIN' affiche d'abord la connexion PayPal.
                'landing_page' => $paymentMethod === 'card' ? 'BILLING' : 'LOGIN',
                'return_url' => route('devis.paypal.success'),
                'cancel_url' => route('devis.paypal.cancel'),
            ],
        ];

        try {
            $provider = $this->paypalProvider($currency);
            $order = $provider->setRequestHeader('Prefer', 'return=representation')->createOrder($orderPayload);
        } catch (Throwable $e) {
            Log::error('PayPal createOrder exception for devis', [
                'devis_request_id' => $devisRequest->id ?? null,
                'billing_request_ids' => $requestIds,
                'amount' => $amount,
                'currency' => $currency,
                'customer_email' => $devisRequest->email ?? null,
                'payload' => $orderPayload,
                'exception_message' => $e->getMessage(),
                'exception_class' => \get_class($e),
                'exception_trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }

        $paypalOrderId = (string) ($order['id'] ?? '');
        $approvalUrl = $this->approvalUrl($order);

        if ($paypalOrderId === '' || $approvalUrl === '') {
            Log::error('PayPal returned invalid order/approval link for devis', [
                'devis_request_id' => $devisRequest->id ?? null,
                'billing_request_ids' => $requestIds,
                'amount' => $amount,
                'currency' => $currency,
                'order' => $order,
            ]);

            throw new RuntimeException('PayPal n\'a pas retourné de lien de paiement valide.');
        }

        $etablissementId = $gateway?->etablissement_id ?? Etablissement::first()?->id;

        try {
            DB::transaction(function () use ($amount, $currency, $customer, $gateway, $requestIds, $devisRequest, $paypalOrderId, $order, $etablissementId): void {
                $payment = Payment::create([
                    'etablissement_id' => $etablissementId,
                    'payment_date' => now()->toDateString(),
                    'amount' => $amount,
                    'method' => 'paypal',
                    'transaction_id' => $paypalOrderId,
                    'status' => 'en_attente',
                    'notes' => 'Paiement PayPal créé depuis la page devis.',
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
        } catch (Throwable $e) {
            Log::error('Failed to persist PayPal payment/transaction for devis', [
                'devis_request_id' => $devisRequest->id ?? null,
                'billing_request_ids' => $requestIds,
                'amount' => $amount,
                'currency' => $currency,
                'paypal_order' => $order,
                'exception_message' => $e->getMessage(),
                'exception_class' => \get_class($e),
                'exception_trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }

        return $approvalUrl;
    }

    /**
     * Capture le paiement PayPal
     */
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

        try {
            $captureResponse = $provider->setRequestHeader('Prefer', 'return=representation')->capturePaymentOrder($paypalOrderId);
        } catch (Throwable $e) {
            Log::error('PayPal capturePaymentOrder exception', [
                'paypal_order_id' => $paypalOrderId,
                'transaction_id' => $transaction->id ?? null,
                'currency' => $currency,
                'exception_message' => $e->getMessage(),
                'exception_class' => \get_class($e),
                'exception_trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }

        $capture = data_get($captureResponse, 'purchase_units.0.payments.captures.0', []);
        $captureStatus = strtoupper((string) ($capture['status'] ?? $captureResponse['status'] ?? ''));

        if ($captureStatus !== 'COMPLETED') {
            Log::warning('PayPal capture returned non-COMPLETED status', [
                'paypal_order_id' => $paypalOrderId,
                'transaction_id' => $transaction->id ?? null,
                'capture_status' => $captureStatus,
                'capture_response' => $captureResponse,
            ]);

            $transaction->update([
                'status' => 'failed',
                'gateway_status' => $captureStatus ?: 'FAILED',
                'gateway_response' => $captureResponse,
                'error_message' => 'Capture PayPal non complète.',
            ]);

            $transaction->payment?->update([
                'status' => 'echoue',
                'metadata' => array_merge($transaction->payment->metadata ?? [], [
                    'paypal_capture_status' => $captureStatus,
                ]),
            ]);

            throw new RuntimeException('Le paiement PayPal n\'a pas été confirmé.');
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

    /**
     * Annule le paiement PayPal
     */
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
            'notes' => trim(($transaction->notes ? $transaction->notes . "\n" : '') . 'Paiement annulé par le client.'),
        ]);

        $transaction->payment?->update([
            'status' => 'echoue',
            'notes' => trim(($transaction->payment->notes ? $transaction->payment->notes . "\n" : '') . 'Paiement PayPal annulé par le client.'),
        ]);
    }

    /**
     * Récupère le provider PayPal
     */
    private function paypalProvider(string $currency): PayPalClient
    {
        try {
            $provider = new PayPalClient($this->paypalConfig($currency));
            $provider->getAccessToken();

            return $provider;
        } catch (Throwable $e) {
            Log::error('PayPal provider initialization failed', [
                'currency' => $currency,
                'paypal_mode' => config('paypal.mode'),
                'exception_message' => $e->getMessage(),
                'exception_class' => \get_class($e),
                'exception_trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }

    /**
     * Configuration PayPal
     */
    private function paypalConfig(string $currency): array
    {
        $config = config('paypal');
        $config['currency'] = strtoupper($currency ?: ($config['currency'] ?? self::DEFAULT_CURRENCY));

        return $config;
    }

    /**
     * Extrait l'URL d'approbation PayPal
     */
    private function approvalUrl(array $order): string
    {
        foreach (($order['links'] ?? []) as $link) {
            if (($link['rel'] ?? '') === 'approve' && !empty($link['href'])) {
                return (string) $link['href'];
            }
        }

        return '';
    }

    /**
     * Crée ou récupère un client
     */
    private function customerFor(DevisRequest $devisRequest): Customer
    {
        return Customer::updateOrCreate(
            [
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

    /**
     * Récupère la passerelle de paiement
     */
    private function gatewayFor(): ?PaymentGateway
    {
        return PaymentGateway::query()
            ->where('type', 'paypal')
            ->where('is_active', true)
            ->where('is_default', true)
            ->orderBy('order')
            ->first();
    }

    /**
     * Calcule le montant total
     */
    private function totalAmount(Collection $billingRequests): float
    {
        return round($billingRequests->sum(fn (BillingRequest $request) => (float) $request->total), 2);
    }

    /**
     * Récupère la devise
     */
    private function currencyFor(Collection $billingRequests): string
    {
        $currency = (string) data_get($billingRequests->first()?->metadata, 'currency', config('paypal.currency', self::DEFAULT_CURRENCY));

        return strtoupper($currency ?: self::DEFAULT_CURRENCY);
    }

    /**
     * Formate le montant pour PayPal
     */
    private function paypalAmount(float $amount): string
    {
        return number_format(round($amount, 2), 2, '.', '');
    }

    /**
     * Envoie le reçu de paiement
     */
    private function sendReceipt(PaymentTransaction $transaction): void
    {
        $payment = $transaction->payment;
        $customer = $transaction->client;
        $email = (string) ($customer?->email ?: data_get($transaction->metadata, 'customer_email', ''));

        if ($email === '') {
            throw new RuntimeException('Adresse email client manquante pour le reçu.');
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
                ->subject('Votre reçu de paiement GoExploria ' . ($payment?->payment_reference ? '- ' . $payment->payment_reference : ''));
        });
    }

    /**
     * Marque l'envoi du reçu
     */
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