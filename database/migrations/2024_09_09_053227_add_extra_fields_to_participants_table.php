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
            if (!Schema::hasColumn('participants', 'first_name')) {
                $table->string('first_name')->nullable();
            }
            if (!Schema::hasColumn('participants', 'middle_name')) {
                $table->string('middle_name')->nullable();
            }
            if (!Schema::hasColumn('participants', 'last_name')) {
                $table->string('last_name')->nullable();
            }
            if (!Schema::hasColumn('participants', 'street')) {
                $table->string('street')->nullable();
            }
            if (!Schema::hasColumn('participants', 'house_number')) {
                $table->string('house_number')->nullable();
            }
            if (!Schema::hasColumn('participants', 'postal_code')) {
                $table->string('postal_code')->nullable();
            }
            if (!Schema::hasColumn('participants', 'city')) {
                $table->string('city')->nullable();
            }
            if (!Schema::hasColumn('participants', 'membership_number')) {
                $table->string('membership_number')->nullable();
            }
            if (!Schema::hasColumn('participants', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('participants', 'scouting_group')) {
                $table->string('scouting_group')->nullable();
            }
            if (!Schema::hasColumn('participants', 'dietary_preferences')) {
                $table->text('dietary_preferences')->nullable();
            }
            if (!Schema::hasColumn('participants', 'privacy_setting')) {
                $table->enum('privacy_setting', ['A', 'B', 'C'])->nullable();
            }
            if (!Schema::hasColumn('participants', 'parental_consent')) {
                $table->boolean('parental_consent')->nullable();
            }
            if (!Schema::hasColumn('participants', 'agreement_terms')) {
                $table->boolean('agreement_terms')->nullable();
            }
            if (!Schema::hasColumn('participants', 'medicine_use')) {
                $table->boolean('medicine_use')->nullable();
            }
            if (!Schema::hasColumn('participants', 'medicine_details')) {
                $table->text('medicine_details')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            // Hernoem 'first_name' terug naar 'name'
            if (Schema::hasColumn('participants', 'first_name')) {
                $table->renameColumn('first_name', 'name');
            }

            // Drop de toegevoegde kolommen
            $table->dropColumn([
                'middle_name', 'last_name', 'street', 'house_number', 
                'postal_code', 'city', 'membership_number', 'email', 
                'scouting_group', 'dietary_preferences', 'privacy_setting',
                'parental_consent', 'agreement_terms', 'medicine_use', 'medicine_details'
            ]);
        });
    }
};
