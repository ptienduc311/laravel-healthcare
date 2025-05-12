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
            $table->text('address')->nullable()->after('gender');
            $table->string('email', 255)->nullable()->after('address');
            $table->string('phone', 255)->nullable()->after('email');
            $table->text('current_workplace')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn(['address', 'email', 'phone', 'current_workplace']);
        });
    }
};
