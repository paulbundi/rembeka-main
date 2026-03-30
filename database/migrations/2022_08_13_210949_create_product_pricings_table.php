<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPricingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_pricings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('supplier_id')->constrained();
            $table->foreignId('unit_id')->constrained('unit_measures');
            $table->string('size');
            $table->decimal('supplier_price');
            $table->decimal('mark_up_percentage');
            $table->decimal('vat');
            $table->decimal('listing_amount');
            $table->decimal('amount');
            $table->unsignedInteger('instock')->nullable();
            $table->unsignedInteger('re_order_level')->nullable();
            $table->json('configs');
            $table->unsignedSmallInteger('status')->default(1);
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
        Schema::dropIfExists('product_pricings');
    }
}
