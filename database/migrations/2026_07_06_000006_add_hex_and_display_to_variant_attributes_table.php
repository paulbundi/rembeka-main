<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('variant_attributes', function (Blueprint $table) {
            $table->string('hex_code')->nullable()->after('value');
            $table->string('display_type')->default('pill')->after('hex_code');
        });
    }

    public function down(): void
    {
        Schema::table('variant_attributes', function (Blueprint $table) {
            $table->dropColumn(['hex_code', 'display_type']);
        });
    }
};