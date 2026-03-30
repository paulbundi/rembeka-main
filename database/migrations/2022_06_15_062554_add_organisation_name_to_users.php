<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrganisationNameToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('organization_name')->nullable()->after('last_name');
            $table->string('first_name')->unsigned()->nullable()->change();
            $table->string('last_name')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('organization_name');
            $table->string('first_name')->unsigned()->nullable(false)->change();
            $table->string('last_name')->unsigned()->nullable(false)->change();
        });
    }
}
