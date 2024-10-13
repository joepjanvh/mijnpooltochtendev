<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Hike;
use App\Models\Post;
use App\Models\Edition;
use Carbon\Carbon;

class MapComponent extends Component
{
    public $activeEdition;
    public $hikes = [];
    public $selectedHikes = []; // Gebruiker kan hikes aan- of uitzetten
    public $selectedDay = null; // Voor filtering op dag (woensdag, donderdag, vrijdag, zaterdag)
    public $posts = [];

    public function mount()
    {
        // Haal de actieve editie op
        $this->activeEdition = Edition::where('active', true)->first();

        // Haal hikes op van de actieve editie
        if ($this->activeEdition) {
            $this->hikes = Hike::where('edition_id', $this->activeEdition->id)->with('posts')->get();
            $this->selectedHikes = $this->hikes->pluck('id')->toArray(); // Alle hikes standaard geselecteerd
            $this->loadPosts(); // Laad direct alle posten
        }
    }
   
    public function updatedSelectedDay($day)
    {
        $this->selectedDay = $day;
        $this->loadPosts();
    }

   
    public function updatedSelectedHikes()
    {
        $this->loadPosts();
    }


    public function loadPosts()
{
    // Controleer of er hikes zijn geselecteerd
    if (!empty($this->selectedHikes)) {
        // Haal de posten op van de geselecteerde hikes
        $postsQuery = Post::whereIn('hike_id', $this->selectedHikes);
    } else {
        // Als er geen hikes zijn geselecteerd, haal alle posten op van de actieve editie
        $postsQuery = Post::whereHas('hike', function ($query) {
            $query->where('edition_id', $this->activeEdition->id);
        });
    }

    // Haal de posts op zonder dagfiltering
    $this->posts = $postsQuery->with('hike')->get();

    // Filter posts op basis van de geselecteerde dag, gebruikmakend van PHP/Carbon
    if ($this->selectedDay) {
        $dayMap = [
            'woensdag' => Carbon::WEDNESDAY,
            'donderdag' => Carbon::THURSDAY,
            'vrijdag' => Carbon::FRIDAY,
            'zaterdag' => Carbon::SATURDAY,
        ];

        $dayOfWeek = $dayMap[$this->selectedDay] ?? null;

        if ($dayOfWeek !== null) {
            // Gebruik Carbon om de posts te filteren op de dag van de week
            $this->posts = $this->posts->filter(function ($post) use ($dayOfWeek) {
                return Carbon::parse($post->date)->dayOfWeek === $dayOfWeek;
            })->values(); // Reset de sleutels van de collectie om ervoor te zorgen dat het een array is
        }
    }

    // Controleer of er posts zijn en stuur deze naar de kaart via het event
    if ($this->posts->isNotEmpty()) {
        // Haal de data van de posts op en stuur ze naar de kaart
        $mappedPosts = $this->posts->map(function ($post) {
            return [
                'latitude' => $post->latitude,
                'longitude' => $post->longitude,
                'post_number' => $post->post_number ?? 'Onbekend',
                'hike_letter' => $post->hike->hike_letter ?? 'Onbekend',
                'time_open' => $post->time_open,
                'time_close' => $post->time_close,
                'planned_start_time' => $post->planned_start_time,
                'date' => $post->date,
                'day' => Carbon::parse($post->date)->translatedFormat('l'), // Dag van de week in tekst
            ];
        })->toArray();

        // Stuur de posts door naar het JavaScript via dispatch
        $this->dispatch('updateMap', ['posts' => $mappedPosts]); // Zorg dat 'posts' een array is
    } else {
        // Geen posts om te tonen
        $this->dispatch('updateMap', ['posts' => []]);
    }
}




    public function render()
    {
        return view('livewire.map-component', [
            'posts' => $this->posts,
            'hikes' => $this->hikes,
        ]);
    }
}
