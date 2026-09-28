<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsService
{
    public function send(string $phone, string $message): bool
    {
        $provider = config('services.sms.provider', 'log');
        $phone = $this->normalizePhone($phone);

        if ($provider === 'textlocal') {
            return $this->sendViaTextLocal($phone, $message);
        }

        if ($provider === 'log') {
            logger()->info('SMS sent to ' . $phone . ': ' . $message);
            return true;
        }

        return false;
    }

    protected function sendViaTextLocal(string $phone, string $message): bool
    {
        $apiKey = config('services.sms.textlocal_api_key');
        $sender = config('services.sms.textlocal_sender');
        $route = config('services.sms.textlocal_route', '4');

        if (empty($apiKey) || empty($sender)) {
            logger()->warning('TextLocal SMS configuration missing.');
            return false;
        }

        $payload = [
            'apiKey' => $apiKey,
            'sender' => $sender,
            'numbers' => $this->formatBangladeshiPhone($phone),
            'message' => $message,
            'route' => $route,
        ];

        $response = Http::asForm()->post('https://api.textlocal.in/send/', $payload);

        if ($response->failed()) {
            logger()->warning('TextLocal SMS failed: ' . $response->body());
            return false;
        }

        $body = $response->json();

        if (!empty($body['status']) && strtolower($body['status']) === 'success') {
            return true;
        }

        logger()->warning('TextLocal SMS response error: ' . json_encode($body));
        return false;
    }

    protected function normalizePhone(string $phone): string
    {
        $clean = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($clean, '880')) {
            $clean = substr($clean, 3);
        }
        if (str_starts_with($clean, '0')) {
            return $clean;
        }
        return '0' . $clean;
    }

    protected function formatBangladeshiPhone(string $phone): string
    {
        $clean = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($clean, '0')) {
            return '88' . $clean;
        }
        if (str_starts_with($clean, '880')) {
            return $clean;
        }
        return '88' . $clean;
    }
}
