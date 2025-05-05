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
        Schema::table('doctors', function (Blueprint $table) {
            $table->tinyInteger('is_outstanding')->default(2)->after('status')->comment('1 là nổi bật, 2 là không nổi bật');
            $table->tinyInteger('gender')->nullable()->after('image_id')->comment('1 là nam 2 là nữ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn(['is_outstanding', 'gender']);
        });
    }
};
