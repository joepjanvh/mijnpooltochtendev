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
        Schema::create('hikes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('edition_id'); // Verwijst naar de editie
            $table->string('hike_letter');            // A, B, C, D, E, F hike
            $table->timestamps();
        
            $table->foreign('edition_id')->references('id')->on('editions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hikes');
    }
};
