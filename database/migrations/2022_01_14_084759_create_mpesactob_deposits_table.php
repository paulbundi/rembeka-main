<?php

use App\Models\MpesactobDeposit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMpesactobDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpesactob_deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->decimal('amount', 12, 4);
            $table->string('trans_id')->nullable();
            $table->string('transaction_number')->nullable();
            $table->string('trans_time')->nullable();
            $table->string('mpesa_transaction_type')->nullable();
            $table->string('bill_ref_no')->nullable();
            $table->string('business_short_code')->nullable();
            $table->string('invoice_number')->nullable();
            $table->decimal('org_account_balance', 12, 4)->nullable();
            $table->string('third_party_trans_id')->nullable();
            $table->string('phone');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('status')->default(MpesactobDeposit::STATUS_PENDING);
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
        Schema::dropIfExists('mpesactob_deposits');
    }
}
