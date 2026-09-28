<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class OtpService
{
    protected string $sessionPrefix = 'payment_otp';

    public function generate(string $phone, int $ttlMinutes = 5): array
    {
        $cleanPhone = $this->normalizePhone($phone);
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = now()->addMinutes($ttlMinutes)->timestamp;

        Session::put($this->sessionKey($cleanPhone), [
            'phone' => $cleanPhone,
            'code' => $code,
            'expires_at' => $expiresAt,
        ]);

        Session::forget($this->verifiedSessionKey());

        $smsService = app(SmsService::class);
        $message = "আপনার AgroBd OTP কোড: {$code}. এটি ৫ মিনিটের মধ্যে ব্যবহার করুন।";
        $smsSent = $smsService->send($cleanPhone, $message);

        return [
            'phone' => $cleanPhone,
            'code' => $code,
            'expires_at' => $expiresAt,
            'sms_sent' => $smsSent,
        ];
    }

    public function verify(string $phone, string $code): bool
    {
        $cleanPhone = $this->normalizePhone($phone);
        $payload = Session::get($this->sessionKey($cleanPhone));

        if (!$payload || !isset($payload['code'], $payload['expires_at'])) {
            return false;
        }

        if ((int) $payload['expires_at'] < time()) {
            Session::forget($this->sessionKey($cleanPhone));
            return false;
        }

        $isValid = hash_equals((string) $payload['code'], (string) $code);

        if ($isValid) {
            Session::put($this->verifiedSessionKey(), $cleanPhone);
            Session::forget($this->sessionKey($cleanPhone));
        }

        return $isValid;
    }

    public function isVerified(string $phone): bool
    {
        return Session::get($this->verifiedSessionKey()) === $this->normalizePhone($phone);
    }

    public function clear(string $phone = null): void
    {
        if ($phone) {
            Session::forget($this->sessionKey($this->normalizePhone($phone)));
        }

        Session::forget($this->verifiedSessionKey());
    }

    protected function normalizePhone(string $phone): string
    {
        $normalized = preg_replace('/[^0-9\+]/', '', $phone);
        if (str_starts_with($normalized, '88') && strlen($normalized) === 13) {
            return substr($normalized, 2);
        }
        if (str_starts_with($normalized, '+880') && strlen($normalized) === 14) {
            return substr($normalized, 4);
        }
        return $normalized;
    }

    protected function sessionKey(string $phone): string
    {
        return $this->sessionPrefix . ':' . $phone;
    }

    protected function verifiedSessionKey(): string
    {
        return $this->sessionPrefix . ':verified';
    }
}
