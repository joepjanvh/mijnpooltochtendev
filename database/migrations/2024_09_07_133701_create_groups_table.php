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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hike_id'); // Verwijst naar de hike
            $table->string('group_name');          // Naam van het groepje
            $table->integer('group_number');       // Uniek nummer voor het groepje
            $table->timestamps();
        
            $table->foreign('hike_id')->references('id')->on('hikes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
