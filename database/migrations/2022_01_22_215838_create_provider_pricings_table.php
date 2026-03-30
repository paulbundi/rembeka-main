<?php

use App\Models\ProviderPricing;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderPricingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_pricings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('provider_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->unsignedInteger('location_id')->nullable();
            $table->double('commission', 4, 2);
            $table->decimal('service_pricing', 8, 2);
            $table->decimal('amount', 8, 2);
            $table->tinyInteger('status')->default(ProviderPricing::STATUS_ACTIVE);
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
        Schema::dropIfExists('provider_pricings');
    }
}
