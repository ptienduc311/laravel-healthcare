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
        Schema::create('medical_specialties', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->foreignId('image_icon_id')->nullable()->constrained('images')->nullOnDelete();
            $table->foreignId('image_id')->nullable()->constrained('images')->nullOnDelete();
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
        Schema::dropIfExists('medical_specialties');
    }
};
