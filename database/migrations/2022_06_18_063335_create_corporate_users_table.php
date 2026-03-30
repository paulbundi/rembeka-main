<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorporateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporate_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('corporate_id');
            $table->unsignedBigInteger('user_id');
            $table->float('spend_limit')->nullable();
            $table->string('limit_period')->nullable();
            $table->tinyInteger('limit_hit')->nullable();
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
        Schema::dropIfExists('corporate_users');
    }
}
