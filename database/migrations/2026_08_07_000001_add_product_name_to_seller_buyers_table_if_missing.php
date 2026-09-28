<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductNameToSellerBuyersTableIfMissing extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('seller_buyers', 'product_name')) {
            Schema::table('seller_buyers', function (Blueprint $table) {
                $table->string('product_name')->nullable()->after('business_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('seller_buyers', 'product_name')) {
            Schema::table('seller_buyers', function (Blueprint $table) {
                $table->dropColumn('product_name');
            });
        }
    }
}
