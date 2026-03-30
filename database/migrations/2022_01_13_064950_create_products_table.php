<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->string('name');
            $table->foreignId('menu_id')->references('id')->on('menus');
            $table->tinyInteger('type');
            $table->string('description');
            $table->string('keywords');
            $table->string('seo_title');
            $table->string('seo_description');
            $table->string('sku')->nullable();
            $table->longText('product_used')->nullable();
            $table->string('duration_of_style')->nullable();
            $table->string('durability')->nullable();
            $table->decimal('cost_of_labour', 8, 2);
            $table->decimal('provider_cost', 8, 2);
            $table->decimal('commission', 4, 2);
            $table->decimal('platform_fee', 8, 2);
            $table->decimal('digital_tax', 8, 2);
            $table->smallInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
