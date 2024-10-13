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
        Schema::create('moments', function (Blueprint $table) {
            $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('file_path');
    $table->string('caption')->nullable();
    $table->foreignId('hike_id')->constrained('hikes')->onDelete('cascade');
    $table->json('group_ids')->nullable(); // voor meerdere koppels
    $table->foreignId('post_id')->nullable()->constrained('posts')->onDelete('cascade');
    $table->string('tags')->nullable();
    $table->string('location')->nullable(); // locatie als tekst
    $table->string('coordinates')->nullable(); // locatie coördinaten vanuit EXIF
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moments');
    }
};
