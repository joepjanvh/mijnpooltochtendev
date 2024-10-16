<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Hike;
use App\Models\Edition; 
use Illuminate\Support\Facades\Auth;

class HikeManager extends Component
{
    public $edition_id;
    public $hike_letter;
    public $hikes;
    public $permissions = [];
    public $delays = [];

    public function mount($editionId)
    {
        $this->edition_id = $editionId;
        $this->hikes = Hike::where('edition_id', $editionId)->get();
        // Controleer permissies voor elke hike
        foreach ($this->hikes as $hike) {
            $this->permissions[$hike->hike_letter] = [
                'view_points' => Auth::user()->can("bekijk puntenoverzicht {$hike->hike_letter}"),
                'manage_groups' => Auth::user()->can("koppel beheer {$hike->hike_letter}"),
                'manage_posts' => Auth::user()->can("posten beheer {$hike->hike_letter}")
            ];
            $this->delays[$hike->id] = $hike->override_delay ?? 0;
        }
    }

    public function createHike()
    {
        $this->validate([
            'hike_letter' => 'required|max:1|in:A,B,C,D,E,F', // Hikes van A tot F
        ]);

        Hike::create([
            'edition_id' => $this->edition_id,
            'hike_letter' => $this->hike_letter,
        ]);

        $this->resetInput();
        $this->hikes = Hike::where('edition_id', $this->edition_id)->get();
    }

    public function resetInput()
    {
        $this->hike_letter = null;
    }

    public function saveDelay($hikeId, $value)
    {

        $hike = Hike::where('id', $hikeId)->first();

        if ($hike) {
            $hike->update(['override_delay' => (int)$value]);
            $this->delays[$hikeId] = (int)$value;
            $hike->refresh();  // Refresh the model instance
            
        }
    }

    public function render()
    {
        return view('livewire.hike-manager', [
            'edition' => Edition::find($this->edition_id),
'permissions' => $this->permissions, // Geef de permissies door aan de Blade-view
        ])->layout('layouts.app'); // Verwijst naar de juiste layout (bijv. layouts.app)
    }
}
