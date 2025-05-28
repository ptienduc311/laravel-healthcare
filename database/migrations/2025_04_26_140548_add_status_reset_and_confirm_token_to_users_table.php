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
            $table->tinyInteger('status')->default(1)->comment('1: hoạt động, 2: bị chặn')->nullable()->after('password');
            $table->string('reset_token')->nullable()->after('remember_token');
            $table->string('confirm_token')->nullable()->after('reset_token'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['status', 'reset_token', 'confirm_token']);
        });
    }
};
