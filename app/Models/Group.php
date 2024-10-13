<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    // Vulbare velden
    protected $fillable = ['hike_id', 'group_name', 'group_number'];

    // Relatie met deelnemers
    public function participants()
    {
        return $this->hasMany(Participant::class);
    }
    public function hike()
{
    return $this->belongsTo(Hike::class);
}
public function posts()
    {
        return $this->belongsToMany(Post::class, 'group_post')
            ->withPivot('check_in_points', 'attitude_points', 'performance_points', 'arrival_time', 'departure_time');
    }

}

