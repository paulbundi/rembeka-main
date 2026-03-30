<?php

use App\Models\OrderItem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('provider_id')->constrained();
            $table->integer('quantity');
            $table->date('appointment_date')->nullable();
            $table->time('appointment_time')->nullable();
            $table->decimal('amount');
            $table->tinyInteger('status')->default(OrderItem::STATUS_PENDING);
            $table->tinyInteger('discounted')->default(OrderItem::DISCOUNTED);
            $table->decimal('discount_amount');
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
        Schema::dropIfExists('order_items');
    }
}
