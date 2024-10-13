<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hike extends Model
{
    use HasFactory;
    //moet onderstaande regel hier staan?
    protected $fillable = ['edition_id', 'hike_letter'];

    public function edition()
{
    return $this->belongsTo(Edition::class);
    
}

public function posts()
{
    return $this->hasMany(Post::class);
}
}
