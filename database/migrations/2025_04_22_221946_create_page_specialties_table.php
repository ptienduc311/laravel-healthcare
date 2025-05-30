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
        Schema::create('page_specialties', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->foreignId('medical_specialty_id')->nullable()->constrained('medical_specialties')->nullOnDelete();
            $table->integer('created_date_int');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_specialties');
    }
};
