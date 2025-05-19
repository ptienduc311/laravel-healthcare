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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 255)->nullable()->after('email');
            $table->string('birth', 255)->nullable()->after('phone');
            $table->tinyInteger('gender')->default(1)->after('birth')->comment('1 là nam 2 là nữ');
            $table->string('address', 255)->nullable()->after('gender');
            $table->foreignId('province_id')->nullable()->after('gender')->constrained('provinces')->nullOnDelete();
            $table->foreignId('district_id')->nullable()->after('province_id')->constrained('districts')->nullOnDelete();
            $table->foreignId('ward_id')->nullable()->after('district_id')->constrained('wards')->nullOnDelete();
            $table->string('google_id')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['province_id']);
            $table->dropForeign(['district_id']);
            $table->dropForeign(['ward_id']);
            
            $table->dropColumn(['phone', 'birth', 'gender', 'address', 'province_id', 'district_id', 'ward_id', 'google_id']);
        });
    }
};
