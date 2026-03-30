<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountColumnsToOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('service_pricing', 5, 2)->nullable()->after('appointment_time');
            $table->decimal('provider_cost', 5, 2)->nullable()->after('service_pricing');
            $table->decimal('provider_discount_amount', 5, 2)->nullable()->after('provider_cost');
            $table->decimal('rembeka_discount_amount', 5, 2)->nullable()->after('provider_discount_amount');
            $table->decimal('rembeka_discount', 5, 2)->nullable()->after('rembeka_discount_amount');
            $table->decimal('un_discounted_commission')->nullable()->after('percentage_commission');
            $table->decimal('total_discount', 5, 2)->nullable()->after('un_discounted_commission');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('service_pricing');
            $table->dropColumn('provider_cost');
            $table->dropColumn('provider_discount_amount');
            $table->dropColumn('rembeka_discount_amount');
            $table->dropColumn('rembeka_discount');
            $table->dropColumn('un_discounted_commission');
            $table->dropColumn('total_discount');
        });
    }
}
