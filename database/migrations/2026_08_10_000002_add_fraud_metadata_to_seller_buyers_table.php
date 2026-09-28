<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFraudMetadataToSellerBuyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seller_buyers', function (Blueprint $table) {
            if (!Schema::hasColumn('seller_buyers', 'fraud_score')) {
                $table->integer('fraud_score')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('seller_buyers', 'fraud_status')) {
                $table->string('fraud_status')->nullable()->after('fraud_score');
            }
            if (!Schema::hasColumn('seller_buyers', 'buyer_ip')) {
                $table->string('buyer_ip', 45)->nullable()->after('fraud_status');
            }
            if (!Schema::hasColumn('seller_buyers', 'payment_gateway')) {
                $table->string('payment_gateway')->nullable()->after('buyer_ip');
            }
            if (!Schema::hasColumn('seller_buyers', 'payment_metadata')) {
                $table->json('payment_metadata')->nullable()->after('payment_gateway');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seller_buyers', function (Blueprint $table) {
            if (Schema::hasColumn('seller_buyers', 'payment_metadata')) {
                $table->dropColumn('payment_metadata');
            }
            if (Schema::hasColumn('seller_buyers', 'payment_gateway')) {
                $table->dropColumn('payment_gateway');
            }
            if (Schema::hasColumn('seller_buyers', 'buyer_ip')) {
                $table->dropColumn('buyer_ip');
            }
            if (Schema::hasColumn('seller_buyers', 'fraud_status')) {
                $table->dropColumn('fraud_status');
            }
            if (Schema::hasColumn('seller_buyers', 'fraud_score')) {
                $table->dropColumn('fraud_score');
            }
        });
    }
}
