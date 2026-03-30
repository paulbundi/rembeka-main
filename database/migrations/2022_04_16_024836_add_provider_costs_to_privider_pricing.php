<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProviderCostsToPrividerPricing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provider_pricings', function (Blueprint $table) {
            $table->decimal('cost_of_labour', 8, 2)->after('provider_id');
            $table->decimal('provider_cost', 8, 2)->after('provider_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('provider_pricings', function (Blueprint $table) {
            $table->dropColumn('cost_of_labour');
            $table->dropColumn('provider_cost');
        });
    }
}
