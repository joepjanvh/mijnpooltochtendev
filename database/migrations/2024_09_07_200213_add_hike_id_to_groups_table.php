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
        Schema::table('groups', function (Blueprint $table) {
          // Controleer of de foreign key nog niet bestaat
          if (!Schema::hasColumn('groups', 'hike_id')) {
            // Voeg de foreign key toe als deze nog niet bestaat
            $table->foreign('hike_id')->references('id')->on('hikes')->onDelete('cascade');
        }
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropForeign(['hike_id']);
        });
    }
};
