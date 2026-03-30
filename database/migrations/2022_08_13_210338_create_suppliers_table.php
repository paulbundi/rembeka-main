<?php

use App\Models\Supplier;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->tinyInteger('status')->nullable()->default(Supplier::STATUS_ACTIVE);
            $table->double('rating', 2, 1)->default(Supplier::DEFAULT_RATING);
            $table->string('slug')->nullable();
            $table->string('national_id')->nullable();
            $table->string('kra_pin');
            $table->string('address');
            $table->string('description');
            $table->smallInteger('type');
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
        Schema::dropIfExists('suppliers');
    }
}
