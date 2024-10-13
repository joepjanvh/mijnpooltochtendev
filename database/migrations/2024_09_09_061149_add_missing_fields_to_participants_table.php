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
        Schema::table('participants', function (Blueprint $table) {
            if (!Schema::hasColumn('participants', 'previous_hike')) {
                $table->enum('previous_hike', ['Geen', 'A', 'B', 'C', 'D', 'E', 'F'])->nullable();
            }
            if (!Schema::hasColumn('participants', 'parent_name')) {
                $table->string('parent_name')->nullable();
            }
            if (!Schema::hasColumn('participants', 'parent_phone')) {
                $table->string('parent_phone')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropColumn(['previous_hike', 'parent_name', 'parent_phone']);
        });
    }
};
