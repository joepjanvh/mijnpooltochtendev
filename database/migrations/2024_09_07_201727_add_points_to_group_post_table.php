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
        Schema::table('group_post', function (Blueprint $table) {
            $table->integer('check_in_points')->default(0);    // Punten voor aan-/afmelden
            $table->integer('attitude_points')->default(0);    // Punten voor houding
            $table->integer('performance_points')->default(0); // Punten voor uitvoering
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('group_post', function (Blueprint $table) {
            //
        });
    }
};
