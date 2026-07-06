<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDisplayFieldsToColorsTable extends Migration
{
    public function up()
    {
        Schema::table('colors', function (Blueprint $table) {
            $table->string('hex_code')->nullable()->after('slug');
            $table->string('display_type')->default('text')->after('hex_code');
        });
    }

    public function down()
    {
        Schema::table('colors', function (Blueprint $table) {
            $table->dropColumn(['hex_code', 'display_type']);
        });
    }
}