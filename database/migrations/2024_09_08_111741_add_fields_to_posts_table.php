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
        Schema::table('posts', function (Blueprint $table) {
            $table->time('planned_start_time')->nullable();
            $table->integer('planned_duration')->nullable();
            $table->string('supply_post')->nullable();
            $table->string('supply_adas_hoeve')->nullable();
            $table->json('materials')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['planned_start_time', 'planned_duration', 'supply_post', 'supply_adas_hoeve', 'materials']);
        });
    }
};
