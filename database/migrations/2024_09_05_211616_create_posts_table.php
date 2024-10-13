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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hike_id');
            $table->string('post_number');           // Postnummer, zoals A02 of D12
            $table->date('date');                    // Datum van de post
            $table->string('location');              // Locatie van de post
            $table->text('instructions');            // Instructies voor de post
            $table->integer('required_workforce');   // Aantal benodigde posthouders
            $table->timestamps();
        
            $table->foreign('hike_id')->references('id')->on('hikes')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
