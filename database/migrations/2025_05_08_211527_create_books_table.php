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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('book_code', 255);
            $table->string('name', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('birth', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->string('date_examination', 255)->nullable();
            $table->text('address')->nullable();
            $table->text('reason')->nullable();
            $table->integer('created_date_int');
            $table->tinyInteger('status')->default(1)->comment('1-chưa xác nhận, 2-đã xác nhận, 3-hủy, 4-đang khám, 5-đang đợi kết quả, 6-đã có kết quả');
            $table->foreignId('province_id')->nullable()->constrained('provinces')->nullOnDelete();
            $table->foreignId('district_id')->nullable()->constrained('districts')->nullOnDelete();
            $table->foreignId('ward_id')->nullable()->constrained('wards')->nullOnDelete();
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->nullOnDelete();
            $table->foreignId('specialty_id')->nullable()->constrained('medical_specialties')->nullOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained('doctors')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
