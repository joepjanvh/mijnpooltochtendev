<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edition extends Model
{
    use HasFactory;
    //moet de regel hier onder hier staan?
   // Vulbare velden
   protected $fillable = ['year', 'start_date', 'end_date', 'active'];

    public function hikes()
{
    return $this->hasMany(Hike::class);
}
}
