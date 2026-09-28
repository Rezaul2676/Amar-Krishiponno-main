<?php

namespace Tests\Unit;

use App\Services\OtpService;
use Tests\TestCase;

class OtpServiceTest extends TestCase
{
    public function test_it_generates_a_six_digit_code_and_verifies_it(): void
    {
        $service = new OtpService();

        $result = $service->generate('01316057864', 5);

        $this->assertSame('01316057864', $result['phone']);
        $this->assertMatchesRegularExpression('/^\d{6}$/', $result['code']);
        $this->assertTrue($service->verify($result['code'], $result['phone'], $result['expires_at']));
    }

    public function test_it_rejects_expired_otps(): void
    {
        $service = new OtpService();

        $result = $service->generate('01316057864', -1);

        $this->assertFalse($service->verify($result['code'], $result['phone'], $result['expires_at']));
    }
}
