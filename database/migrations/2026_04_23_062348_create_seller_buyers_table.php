<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerBuyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_buyers', function (Blueprint $table) {
            $table->id();
            $table->integer('seller_id')->nullable(); // seller/business owner user_id
            $table->integer('business_id')->nullable(); // business product id
            $table->integer('buyer_id')->nullable(); // buyer user_id
            $table->string('buyer_name')->nullable();
            $table->string('buyer_email')->nullable();
            $table->string('buyer_phone')->nullable();
            $table->text('buyer_address')->nullable();
            $table->string('buyer_state')->nullable();
            $table->string('buyer_post_code')->nullable();
            $table->integer('quantity')->default(0);
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payment_status')->default('pending'); // pending, completed, failed
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seller_buyers');
    }
}
