<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;
    // Vulbare velden
   // Vulbare velden
   protected $fillable = [
    'group_id', 
    'first_name', 
    'middle_name', 
    'last_name', 
    'street', 
    'house_number', 
    'postal_code', 
    'city', 
    'membership_number', 
    'email', 
    'scouting_group', 
    'previous_hike', // Zorg ervoor dat deze in de migratie zit
    'parent_name', 
    'parent_phone', 
    'dietary_preferences', 
    'privacy_setting', 
    'parental_consent', 
    'agreement_terms', 
    'medicine_use', 
    'medicine_details'
];


    // Relatie met groep
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}

