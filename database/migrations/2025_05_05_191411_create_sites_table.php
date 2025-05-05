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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 255)->nullable();
            $table->string('hotline', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->text('address')->nullable();
            $table->text('link_facebook')->nullable();
            $table->text('link_youtube')->nullable();
            $table->text('link_zalo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
