<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;
use App\Models\Comment;
class Moment extends Model
{
    use HasFactory;
    
    // Vulbare velden
    protected $fillable = [
        'user_id', 
        'file_path', 
        'caption', 
        'tags', 
        'location', 
        'coordinates', 
        'hike_id', // Zorg ervoor dat hike_id hier is opgenomen
        'photo_taken_at',
        'edition_id',
        'coordinates_source',
        'thumbnail_path' // Voeg het nieuwe veld toe
    ];

    // Relatie met User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Moment model
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
public function isPortrait()
{
    $imagePath = storage_path('app/public/' . $this->file_path);
    list($width, $height) = getimagesize($imagePath);
    return $height > $width;
    
}
// Relatie voor de likes
// Relatie voor de likes
public function likes(): BelongsToMany
{
    return $this->belongsToMany(User::class, 'likes')->withTimestamps();
}

// Controleer of een gebruiker deze post heeft geliked
public function isLikedBy(?User $user): bool
{
    if (!$user) {
        return false;
    }

    return $this->likes->contains($user);
}
//public function hike()
//{
//    return $this->belongsTo(Hike::class);
//}
public function hike()
{
    return $this->belongsTo(Hike::class, 'hike_id');
}




// Haal de namen van de gebruikers die hebben geliked (bijvoorbeeld de eerste 2)
public function getLikedByUsers(): array
{
    return $this->likes()->take(2)->pluck('name')->toArray();
}

// Haal het totale aantal likes op
public function likesCount(): int
{
    return $this->likes()->count();
}




}


