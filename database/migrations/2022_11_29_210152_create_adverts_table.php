<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adverts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedSmallInteger('type');
            $table->string('call_to_action_url')->nullable();
            $table->string('call_to_action')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedSmallInteger('status')->nullable();
            $table->json('audit')->nullable();
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
        Schema::dropIfExists('adverts');
    }
}
