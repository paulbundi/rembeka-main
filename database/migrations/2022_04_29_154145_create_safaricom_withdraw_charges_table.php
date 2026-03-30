<?php

use App\Models\SafaricomWithdrawCharge;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSafaricomWithdrawChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('safaricom_withdraw_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->unsignedBigInteger('mpesa_withdraw_id');
            $table->decimal('withdrawing_amount');
            $table->decimal('transaction_cost');
            $table->tinyInteger('status')->default(SafaricomWithdrawCharge::TRANSACTION_SUCCESSFUL);
            $table->timestamps();

            $table->foreign('mpesa_withdraw_id')->references('id')->on('mpesa_b_t_c_transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('safaricom_withdraw_charges');
    }
}
