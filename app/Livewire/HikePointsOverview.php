<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Group;
use App\Models\Post;
use App\Models\Edition;
use App\Models\Hike;
use App\Exports\HikePointsOverviewExport;
use Maatwebsite\Excel\Facades\Excel;

class HikePointsOverview extends Component
{

    public $hike_id;
    public $hike;
    public $edition;
    public $posts;
    public $pointsOverview;
    public $sortBy = 'group_number'; // Default sorteren op koppelnummer

    public function mount($hikeId)
    {
        $this->hike_id = $hikeId;
         // Stel de hike en edition in
    $this->hike = Hike::find($hikeId);
    $this->edition = Edition::find($this->hike->edition_id);
    $this->posts = Post::where('hike_id', $this->hike_id)->get();
    $this->loadPointsOverview();


    }
    public function updatedSortBy()
    {
        $this->loadPointsOverview();
    }
    public function loadPointsOverview()
    {  
        $groups = Group::where('hike_id', $this->hike_id)
        ->with('posts')
        ->get();

    // Generate points overview
    $this->pointsOverview = $groups->map(function ($group) {
        $totalPoints = 0;
        $pointsPerPost = [];

        foreach ($this->posts as $post) {
            // Controleer of er punten zijn voor deze groep en post
            $groupPost = $group->posts->find($post->id);

            if ($groupPost) {
                // Bereken de punten alleen als ze bestaan
                $postPoints = ($groupPost->pivot->check_in_points ?? 0)
                    + ($groupPost->pivot->attitude_points ?? 0)
                    + ($groupPost->pivot->performance_points ?? 0);
            } else {
                // Als er geen punten zijn, stel het in op 0
                $postPoints = 0;
            }

            $pointsPerPost[$post->id] = $postPoints;
            $totalPoints += $postPoints;
        }

        return [
            'group' => $group,
            'total_points' => $totalPoints,
            'points_per_post' => $pointsPerPost,
        ];
    });

    // Sorteren op de geselecteerde waarde
    if ($this->sortBy == 'total_points') {
        // Sorteren op totale punten
        $this->pointsOverview = $this->pointsOverview->sortByDesc('total_points')->values();
    } elseif ($this->sortBy == 'group_number') {
        // Sorteren op groepsnummer
        $this->pointsOverview = $this->pointsOverview->sortBy(function($overview) {
            return $overview['group']->group_number;
        })->values();
    }
}

    // Voeg de export-functionaliteit toe
    public function exportPointsOverview()
    {
        
    // Fetch the hike and edition
    $hike = Hike::find($this->hike_id);
    $edition = Edition::find($hike->edition_id);

    // Generate the dynamic file name with hike letter and edition year
    $fileName = 'Puntentotaal_' . $hike->hike_letter . '-Hike-' . $edition->year . '.xlsx';

    // Export the data with the dynamic file name
    return Excel::download(new HikePointsOverviewExport($this->hike_id), $fileName);
}
    public function render()
{
    
    return view('livewire.hike-points-overview', [
        'hike' => $this->hike,
        'edition' => $this->edition,
    ])->layout('layouts.app');
}
}
