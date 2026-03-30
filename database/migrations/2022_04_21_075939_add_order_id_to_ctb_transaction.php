<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderIdToCtbTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mpesactob_deposits', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->after('invoice_number')->nullable();
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mpesactob_deposits', function (Blueprint $table) {
            $table->dropConstrainedForeignId('order_id');
            $table->dropColumn('order_id');
        });
    }
}
