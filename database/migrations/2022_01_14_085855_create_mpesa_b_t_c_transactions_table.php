<?php

use App\Models\MpesaBTCTransaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMpesaBTCTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpesa_b_t_c_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('transaction_time')->nullable();
            $table->float('amount');
            $table->string('bill_reference_number');
            $table->float('organisation_account_balance')->nullable();
            $table->string('conversation_id')->nullable();
            $table->string('originator_conversation_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('transaction_receipt')->nullable();
            $table->string('error_code')->nullable();
            $table->string('error_message')->nullable();
            $table->json('transaction_response')->nullable();
            $table->integer('status')->default(MpesaBTCTransaction::INITIATED);
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
        Schema::dropIfExists('mpesa_b_t_c_transactions');
    }
}
