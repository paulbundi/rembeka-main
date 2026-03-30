<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeProductReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_reviews', function (Blueprint $table) {
            $table->dropForeign('product_reviews_provider_pricing_id_foreign');
            $table->unsignedBigInteger('provider_pricing_id')->nullable()->change();
            $table->unsignedBigInteger('provider_id')->nullable()->change();
            $table->text('comment')->change();
            $table->smallInteger('is_visible')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_reviews', function (Blueprint $table) {
            $table->foreign('provider_pricing_id')->references('id')->on('provider_pricings');
            $table->unsignedBigInteger('provider_id')->nullable(false)->change();
            $table->string('comment')->change();
            $table->dropColumn('is_visible');
        });
    }
}
