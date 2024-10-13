<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Moment;
use Illuminate\Support\Facades\Auth;

class EditMoment extends Component
{
    public $momentId;
    public $caption;
    public $location;
    public $isOpen = false;

    // Listen for the browser event 'open-edit-modal' dispatched from the parent component
    protected $listeners = ['editMoment'];

    public function editMoment($momentId)
    {
        // Zorg ervoor dat je een enkel Moment object ophaalt
        $moment = Moment::findOrFail($momentId);

        // Controleer of de ingelogde gebruiker de eigenaar is
        if (Auth::id() !== $moment->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Vul de modal met gegevens
        $this->momentId = $momentId;
        $this->caption = $moment->caption;
        $this->location = $moment->location;

        // Open de modal
        $this->isOpen = true;
    }

    public function updateMoment()
    {
       
        // Valideer de invoer
        $this->validate([
            'caption' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        // Zoek het moment opnieuw op
        $moment = Moment::findOrFail($this->momentId);

        // Controleer of de ingelogde gebruiker de eigenaar is
        if (Auth::id() !== $moment->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Update het moment
        $moment->update([
            'caption' => $this->caption,
            'location' => $this->location,
        ]);

        // Sluit de modal
        

        // Event dispatchen om de parent component te laten herladen
        $this->dispatch('momentUpdated', ['momentId' => $moment->id]); // Zorgt voor verversing
        
        $this->dispatch('closeSubMenu', ['momentId' => $moment->id]); // Sluit het submenu
        

        // Bevestigingsbericht
        session()->flash('message', 'Moment succesvol bijgewerkt!');
        
        $this->closeModal();
    }
    public function closeModal()
    {
        $this->reset(['momentId', 'caption', 'location', 'isOpen']);
        
    }

    public function render()
    {
        return view('livewire.edit-moment');
    }
}
