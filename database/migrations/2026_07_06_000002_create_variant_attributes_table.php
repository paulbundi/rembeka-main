<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('variant_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_variant_id')->constrained()->cascadeOnDelete();
            $table->string('attribute');
            $table->string('value');
            $table->timestamps();

            $table->index(['product_variant_id', 'attribute']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variant_attributes');
    }
};