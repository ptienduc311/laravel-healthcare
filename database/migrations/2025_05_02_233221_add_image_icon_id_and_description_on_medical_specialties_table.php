<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('medical_specialties', function (Blueprint $table) {
            $table->foreignId('image_icon_id')->nullable()->after('slug')->constrained('images')->nullOnDelete();
            $table->text('description')->nullable()->after('image_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_specialties', function (Blueprint $table) {
            $table->dropForeign(['image_icon_id']);
            $table->dropColumn(['image_icon_id', 'description']);
        });
    }
};
