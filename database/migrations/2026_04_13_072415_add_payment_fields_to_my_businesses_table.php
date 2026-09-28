<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentFieldsToMyBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_businesses', function (Blueprint $table) {
            $table->string('payment_gateway')->default('sslcommerz')->nullable(); // sslcommerz, bkash, bank
            $table->string('store_id')->nullable();
            $table->string('store_password')->nullable();
            $table->string('bkash_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_routing')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('my_businesses', function (Blueprint $table) {
            $table->dropColumn(['payment_gateway', 'store_id', 'store_password', 'bkash_number', 'bank_name', 'bank_account', 'bank_routing']);
        });
    }
}
