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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('slug_name', 255);
            $table->foreignId('image_id')->nullable()->constrained('images')->nullOnDelete();
            $table->foreignId('specialty_id')->nullable()->constrained('medical_specialties')->nullOnDelete();
            $table->string('experience', 255)->nullable();
            $table->tinyInteger('academic_title')->nullable();
            $table->tinyInteger('degree')->nullable();
            $table->text('regency')->nullable();
            $table->text('introduce')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1: hoạt động, 2: tạm dừng, 3: xóa');
            $table->integer('created_date_int');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
