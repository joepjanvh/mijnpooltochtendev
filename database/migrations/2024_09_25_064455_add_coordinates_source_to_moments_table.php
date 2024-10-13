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
        Schema::table('moments', function (Blueprint $table) {
            $table->string('coordinates_source')->nullable(); // Kan 'EXIF' of 'user' bevatten
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('moments', function (Blueprint $table) {
            $table->dropColumn('coordinates_source');
        });
    }
};
