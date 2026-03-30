<?php

use App\Models\MpesaTopUpTransaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMpesaTopUpTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpesa_top_up_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained();
            $table->decimal('amount', 12, 4);
            $table->string('active_phone_number');
            $table->tinyInteger('status')->default(MpesaTopUpTransaction::STATUS_PENDING);
            $table->string('trans_id')->nullable();
            $table->string('transaction_number')->nullable()->comment('from call back, receipt number sent to user');
            $table->string('trans_time')->nullable();
            $table->string('merchant_request_id');
            $table->string('checkout_request_id');
            $table->string('response_code');
            $table->string('response_description');
            $table->string('customer_message');
            $table->string('reference_id');
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
        Schema::dropIfExists('mpesa_top_up_transactions');
    }
}
