<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('franchise_id');
            $table->unsignedSmallInteger('confirmation_status')->nullable();
            $table->unsignedSmallInteger('reminder_sent')->nullable();
            $table->dateTime('slot_time');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
