<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderIdToWalletAudit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wallet_audits', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->nullable()->after('previous_balance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wallet_audits', function (Blueprint $table) {
            $table->dropColumn('order_id');
        });
    }
}
