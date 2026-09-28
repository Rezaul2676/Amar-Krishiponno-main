<?php

namespace Tests\Unit;

use App\Services\BangladeshLocationValidator;
use PHPUnit\Framework\TestCase;

class BangladeshLocationValidatorTest extends TestCase
{
    public function test_valid_bangladesh_location_names_are_accepted(): void
    {
        $this->assertTrue(BangladeshLocationValidator::isValidState('Dhaka'));
        $this->assertTrue(BangladeshLocationValidator::isValidState('Gazipur Sadar'));
        $this->assertTrue(BangladeshLocationValidator::isValidState('Savar'));
        $this->assertTrue(BangladeshLocationValidator::isValidState('Narayanganj'));

        $this->assertTrue(BangladeshLocationValidator::isValidAddress('House 12, Road 4, Savar, Dhaka'));
    }

    public function test_accepts_bangla_thana_names_and_combined_location_texts(): void
    {
        $this->assertTrue(BangladeshLocationValidator::isValidState('মিরপুর'));
        $this->assertTrue(BangladeshLocationValidator::isValidState('উত্তরা'));
        $this->assertTrue(BangladeshLocationValidator::isValidState('মিরপুর, ঢাকা'));
        $this->assertTrue(BangladeshLocationValidator::isValidAddress('বাড়ি ১২, রোড ৪, মিরপুর, ঢাকা'));
    }

    public function test_invalid_random_text_is_rejected(): void
    {
        $this->assertFalse(BangladeshLocationValidator::isValidState('xkqwerjlnm'));
        $this->assertFalse(BangladeshLocationValidator::isValidState('qqqqqq qqqqqq'));
        $this->assertFalse(BangladeshLocationValidator::isValidAddress('abc xyz qwe rty uiop asdf'));
    }
}
