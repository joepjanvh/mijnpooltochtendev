<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Edition;

class EditionManager extends Component
{
    public $year;
    public $start_date;
    public $end_date;
    public $active = false; // Nieuw veld voor de checkbox
    public $editEditionId = null;
    public $editions;
    // Deze functie wordt uitgevoerd bij het laden van de pagina
    public function mount()
    {
        $this->editions = Edition::all();
    }

    // Functie om een nieuwe editie aan te maken
    public function createEdition()
    {
        $this->validate([
            'year' => 'required|unique:editions,year',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        
        if ($this->active) {
            Edition::where('active', true)->update(['active' => false]); // Alle andere edities inactief maken
        }
        Edition::create([
            'year' => $this->year,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'active' => $this->active,
        ]);

        $this->resetInput();  // Reset het inputveld na toevoegen
        $this->editions = Edition::all();  // Haal de nieuwste data op
    }
    public function editEdition($editionId)
    {
        $edition = Edition::findOrFail($editionId);
        $this->editEditionId = $edition->id;
        $this->year = $edition->year;
        $this->start_date = $edition->start_date;
        $this->end_date = $edition->end_date;
        $this->active = $edition->active;
    }

    public function saveEdition()
    {
        $this->validate([
            'year' => 'required|unique:editions,year,' . $this->editEditionId,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($this->active) {
            Edition::where('active', true)->update(['active' => false]); // Alle andere edities inactief maken
        }

        $edition = Edition::findOrFail($this->editEditionId);
        $edition->update([
            'year' => $this->year,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'active' => $this->active,
        ]);

        $this->resetInput();
        $this->editions = Edition::all();
        $this->editEditionId = null; // Reset after saving
    }
    // Reset de inputvelden
    public function resetInput()
    {
        $this->year = null;
        $this->start_date = null;
        $this->end_date = null;
        $this->active = false;
        $this->editEditionId = null;
    }

    public function render()
    {
        return view('livewire.edition-manager')
            ->layout('layouts.app'); // Zorg dat je de juiste layout gebruikt
    }
    
}
