<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->decimal('paid', 8, 2);
            $table->decimal('balance', 8, 2);
            $table->unsignedBigInteger('location_id')->nullable();
            $table->string('notes')->nullable();
            $table->unsignedInteger('status')->default(Order::STATUS_PENDING_PAYMENT);
            $table->unsignedInteger('refund_status')->nullable();
            $table->string('cancel_reason')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
