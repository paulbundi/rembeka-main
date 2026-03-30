<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoOfUseToReferralCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referralcode_user', function (Blueprint $table) {
            $table->unsignedInteger('redeemed_times')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referralcode_user', function (Blueprint $table) {
            $table->dropColumn('redeemed_times');
        });
    }
}
