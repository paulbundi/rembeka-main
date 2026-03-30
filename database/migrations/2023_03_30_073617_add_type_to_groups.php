<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->unsignedSmallInteger('type')->nullable()->after('user_id');
            $table->string('filter_criteria')->nullable()->after('type');
            $table->unsignedBigInteger('product_id')->nullable()->after('filter_criteria');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('filter_criteria');
            $table->dropColumn('product_id');
        });
    }
}
