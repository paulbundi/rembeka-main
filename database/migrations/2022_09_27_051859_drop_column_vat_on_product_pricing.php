<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnVatOnProductPricing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_pricings', function (Blueprint $table) {
            $table->dropColumn('vat');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('digital_tax');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_pricings', function (Blueprint $table) {
            $table->decimal('vat')->nullable();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->decimal('digital_tax')->nullable();
        });
    }
}
