<?php

namespace Tests\Feature;

use App\Http\Controllers\SslCommerzPaymentController;
use App\Models\Business\MyBusiness;
use App\Models\OrderPayment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BkashPaymentConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_bkash_payment_confirmation_updates_order_payment_status(): void
    {
        $seller = User::factory()->create();
        $business = MyBusiness::create([
            'user_id' => $seller->id,
            'name' => 'Test Seller',
            'product_name' => 'Rice',
            'price' => '120',
            'payment_gateway' => 'bkash',
            'bkash_number' => '01700000000',
            'status' => 1,
        ]);

        $order = OrderPayment::create([
            'user_id' => $seller->id,
            'invoice_no' => 'INV-1001',
            'payment_type' => 'bKash',
            'total' => '500',
            'subtotal' => '500',
            'status' => 0,
        ]);

        DB::table('payments')->insert([
            'order_id' => $order->id,
            'user_id' => $seller->id,
            'name' => 'Buyer',
            'email' => 'buyer@example.com',
            'phone' => '01712345678',
            'amount' => '500',
            'status' => 'Pending',
            'address' => 'Test Address',
            'state' => 'Dhaka',
            'post_code' => 1200,
            'transaction_id' => 'tran_bkash_123',
            'currency' => 'BDT',
            'description' => 'bKash payment to seller Test Seller for Rice (2 kg)',
            'business_id' => $business->id,
            'seller_id' => $seller->id,
            'quantity' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $request = new Request([
            'transaction_id' => 'tran_bkash_123',
            'bkash_transaction_ref' => 'REF-123456',
            'business_id' => $business->id,
            'amount' => 500,
            'quantity' => 2,
        ]);

        $controller = new SslCommerzPaymentController();
        $response = $controller->confirmBkashPayment($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertSame(0, OrderPayment::find($order->id)->status);
        $this->assertSame('Completed', DB::table('payments')->where('transaction_id', 'tran_bkash_123')->value('status'));
    }
}
