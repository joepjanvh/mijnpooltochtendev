<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Edition;
use App\Models\Hike;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $edition;
    public $hikes = [];
    public $posts = [];
    public $totalDelayPerHike = [];

    public function mount()
    {
        // Haal de actieve editie op
        $this->edition = Edition::where('active', true)->first();

        if (!$this->edition) {
            session()->flash('error', 'Er is momenteel geen actieve editie.');
            return redirect()->route('home'); // Verwijs naar een andere pagina
        }

        // Haal alle hikes van de actieve editie op
        $this->hikes = Hike::where('edition_id', $this->edition->id)->with('posts')->get();

        // Haal de posten op per hike_id en bereken vertraging
        foreach ($this->hikes as $hike) {
            $this->posts[$hike->id] = Post::where('hike_id', $hike->id)
                ->orderBy('post_number')
                ->get();

            // Bereken de vertraging voor elke hike
            $this->totalDelayPerHike[$hike->hike_letter] = $this->calculateHikeDelay($hike);
        }
    }

    public function calculateHikeDelay($hike)
    {
        $totalDelay = 0;

        if (!is_null($hike->override_delay) && $hike->override_delay != 0) {
            return $hike->override_delay;
        }

        foreach ($hike->posts as $post) {
            // Combineer de datum en geplande starttijd van de post
            $postDate = Carbon::parse($post->date);
            $plannedStartTime = $post->planned_start_time;

            // Voeg seconden toe als dat nodig is
            if (strlen($plannedStartTime) === 5) {
                $plannedStartTime .= ':00';
            }

            $plannedStartDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $postDate->format('Y-m-d') . ' ' . $plannedStartTime);

            // Sla gesloten posten over
            if (!is_null($post->time_close)) {
                continue;
            }

            // Bereken de vertraging voor de eerstvolgende open post
            if (is_null($post->time_open) && now()->greaterThan($plannedStartDateTime)) {
                $delayInMinutes = now()->diffInMinutes($plannedStartDateTime);
                $totalDelay += abs($delayInMinutes);
                break; // Stop na de eerste open post
            }
        }

        return $totalDelay;
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'posts' => $this->posts,
            'hikes' => $this->hikes,
            'totalDelayPerHike' => $this->totalDelayPerHike, // Verzamel alle vertragingen per hike
        ])->layout('layouts.app');
    }
}
