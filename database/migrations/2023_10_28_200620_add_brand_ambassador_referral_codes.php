<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBrandAmbassadorReferralCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referralcodes', function (Blueprint $table) {
            $table->unsignedSmallInteger('is_ambassador')->after('acquisition_cost')->nullable();
            $table->float('referred_first_visit_discount')->after('is_ambassador')->nullable();
            $table->float('referred_second_visit_discount')->after('referred_first_visit_discount')->nullable();
            $table->float('ambassador_discount')->after('referred_second_visit_discount')->nullable();
            $table->unsignedInteger('max_users')->after('ambassador_discount')->nullable();
            $table->unsignedInteger('used_count')->after('max_users')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referralcodes', function (Blueprint $table) {
            $table->dropColumn('is_ambassador');
            $table->dropColumn('referred_first_visit_discount');
            $table->dropColumn('referred_second_visit_discount');
            $table->dropColumn('ambassador_discount');
            $table->dropColumn('max_users');
            $table->dropColumn('used_count');
        });
    }
}
