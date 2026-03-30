<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounteds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->tinyInteger('discount_type');
            $table->decimal('discount_amount', 8, 2);
            $table->decimal('product_price', 8, 2);
            $table->float('payable', 8, 2);
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
        Schema::dropIfExists('discounteds');
    }
}
