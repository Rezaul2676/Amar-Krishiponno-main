<?php

namespace Tests\Unit;

use App\Services\FraudDetectionService;
use PHPUnit\Framework\TestCase;

class FraudDetectionServiceTest extends TestCase
{
    public function test_it_flags_suspicious_orders_with_high_score(): void
    {
        $service = new FraudDetectionService();

        $result = $service->score([
            'user_id' => null,
            'amount' => 60000,
            'address' => 'test address',
            'state' => 'Unknown district',
            'post_code' => '123',
            'name' => '12',
            'ip' => '203.0.113.10',
        ]);

        $this->assertTrue($result['is_suspicious']);
        $this->assertSame('high', $result['risk_level']);
    }
}
