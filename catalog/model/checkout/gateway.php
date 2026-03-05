<?php
namespace Reamur\Catalog\Model\Checkout;

class Gateway extends \Reamur\System\Engine\Model {
    private function stripeSecret(): string {
        return getenv('STRIPE_SECRET') ?: ($this->config->get('payment_stripe_secret') ?? '');
    }
    private function stripePublic(): string {
        return getenv('STRIPE_PUBLIC') ?: ($this->config->get('payment_stripe_public') ?? '');
    }
    private function mpToken(): string {
        return getenv('MP_ACCESS_TOKEN') ?: ($this->config->get('payment_mp_access_token') ?? '');
    }

    public function createStripeCheckout(float $amount, string $currency, string $description, string $success_url, string $cancel_url, string $destination_account = '', float $platform_fee_percent = 20.0): array {
        $secret = $this->stripeSecret();
        if (!$secret) return ['id' => null, 'url' => null];
        if (!$platform_fee_percent && $this->config->get('payment_platform_fee')) {
            $platform_fee_percent = (float)$this->config->get('payment_platform_fee');
        }
        $body = http_build_query([
            'mode' => 'payment',
            'success_url' => $success_url,
            'cancel_url' => $cancel_url,
            'line_items[0][price_data][currency]' => strtolower($currency ?: 'brl'),
            'line_items[0][price_data][product_data][name]' => $description,
            'line_items[0][price_data][unit_amount]' => (int)round($amount * 100),
            'line_items[0][quantity]' => 1
        ]);
        if ($destination_account) {
            $fee = (int)round($amount * ($platform_fee_percent / 100) * 100);
            $body .= '&transfer_data[destination]=' . urlencode($destination_account) . '&application_fee_amount=' . $fee;
        }
        $resp = $this->curl('https://api.stripe.com/v1/checkout/sessions', $body, ['Authorization: Bearer ' . $secret]);
        $data = json_decode($resp, true);
        return [
            'id' => $data['id'] ?? null,
            'url' => $data['url'] ?? null
        ];
    }

    public function verifyStripeSession(string $session_id): bool {
        $secret = $this->stripeSecret();
        if (!$secret) return true; // fallback: treat as paid
        $resp = $this->curl('https://api.stripe.com/v1/checkout/sessions/' . urlencode($session_id), '', ['Authorization: Bearer ' . $secret], 'GET');
        $data = json_decode($resp, true);
        return (($data['payment_status'] ?? '') === 'paid');
    }

    public function getStripeSession(string $session_id): array {
        $secret = $this->stripeSecret();
        if (!$secret || !$session_id) return [];
        $resp = $this->curl('https://api.stripe.com/v1/checkout/sessions/' . urlencode($session_id), '', ['Authorization: Bearer ' . $secret], 'GET');
        return json_decode($resp, true) ?: [];
    }

    public function getStripePaymentIntent(string $pi_id): array {
        $secret = $this->stripeSecret();
        if (!$secret || !$pi_id) return [];
        $resp = $this->curl('https://api.stripe.com/v1/payment_intents/' . urlencode($pi_id), '', ['Authorization: Bearer ' . $secret], 'GET');
        return json_decode($resp, true) ?: [];
    }

    public function createMpPreference(float $amount, string $currency, string $title, string $success_url, string $cancel_url, string $receiver_user_id = '', float $platform_fee_percent = 20.0): array {
        $token = $this->mpToken();
        if (!$token) return ['id' => null, 'init_point' => null];
        if (!$platform_fee_percent && $this->config->get('payment_platform_fee')) {
            $platform_fee_percent = (float)$this->config->get('payment_platform_fee');
        }
        $marketplace_fee = $platform_fee_percent > 0 ? round($amount * ($platform_fee_percent / 100), 2) : 0;
        $payload = json_encode([
            'items' => [
                ['title' => $title, 'quantity' => 1, 'unit_price' => (float)$amount, 'currency_id' => strtoupper($currency ?: 'BRL')]
            ],
            'back_urls' => [
                'success' => $success_url,
                'failure' => $cancel_url,
                'pending' => $cancel_url
            ],
            'auto_return' => 'approved'
        ]);
        if ($receiver_user_id) {
            $payload = json_decode($payload, true);
            $payload['payer'] = new \stdClass();
            $payload['marketplace_fee'] = $marketplace_fee;
            $payload['collector_id'] = (int)$receiver_user_id;
            $payload = json_encode($payload);
        }
        $resp = $this->curl('https://api.mercadopago.com/checkout/preferences', $payload, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);
        $data = json_decode($resp, true);
        return [
            'id' => $data['id'] ?? null,
            'init_point' => $data['init_point'] ?? null
        ];
    }

    public function verifyMpPayment(string $preference_id): bool {
        $token = $this->mpToken();
        if (!$token) return true; // fallback
        $resp = $this->curl('https://api.mercadopago.com/checkout/preferences/' . urlencode($preference_id), '', [
            'Authorization: Bearer ' . $token
        ], 'GET');
        $data = json_decode($resp, true);
        $payments = $data['payments'] ?? [];
        foreach ($payments as $p) {
            if (($p['status'] ?? '') === 'approved') return true;
        }
        // fallback: treat as paid when preference is approved
        return false;
    }

    // Stripe transfer after platform capture
    public function stripeTransfer(string $secret, string $destination, int $amount_cents, string $currency, string $source_txn, string $desc = ''): ?string {
        if (!$secret || !$destination || $amount_cents <= 0) return null;
        $body = http_build_query([
            'amount' => $amount_cents,
            'currency' => strtolower($currency ?: 'brl'),
            'destination' => $destination,
            'source_transaction' => $source_txn,
            'description' => $desc
        ]);
        $resp = $this->curl('https://api.stripe.com/v1/transfers', $body, ['Authorization: Bearer ' . $secret]);
        $data = json_decode($resp, true);
        return $data['id'] ?? null;
    }

    private function curl(string $url, string $body, array $headers = [], string $method = 'POST'): string {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($method !== 'GET') curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        if ($headers) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $resp = curl_exec($ch);
        curl_close($ch);
        return $resp ?: '';
    }
}
