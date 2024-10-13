<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'hike_id', 
        'post_number', 'date', 'location', 'instructions', 
        'required_workforce',
        'time_open',   // Voeg deze regel toe
        'time_close',   // Voeg deze regel toe als je ook de sluitingstijd wilt updaten
        'planned_start_time',
        'planned_duration',
        'supply_post',
        'supply_adas_hoeve',
        'materials',
        'latitude',
        'longitude',
    ];

    public function hike()
{
    return $this->belongsTo(Hike::class);
}
public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_post')
            ->withPivot('check_in_points', 'attitude_points', 'performance_points', 'arrival_time', 'departure_time');
    }
}
