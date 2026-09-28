<?php

namespace Tests\Unit;

use App\Services\SuspiciousInputDetector;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function test_location_match_in_state_allows_checkout_to_continue(): void
    {
        $detector = new SuspiciousInputDetector();

        $result = $detector->detect([
            'name' => 'Ayesha Nurjahan',
            'address' => 'Unknown Road',
            'state' => 'Dhaka',
            'post_code' => '1207',
        ]);

        $this->assertFalse($result['is_suspicious']);
    }
}
