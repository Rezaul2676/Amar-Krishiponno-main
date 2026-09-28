<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductNameToSellerBuyersTable extends Migration
{
    public function up()
    {
        Schema::table('seller_buyers', function (Blueprint $table) {
            $table->string('product_name')->nullable()->after('business_id');
        });
    }

    public function down()
    {
        Schema::table('seller_buyers', function (Blueprint $table) {
            $table->dropColumn('product_name');
        });
    }
}
