<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Group;
use App\Models\Participant;

class ParticipantManager extends Component
{
    public $group_id;
    public $group;  // Om de groep te kunnen laden
    public $first_name;
    public $middle_name;
    public $last_name;
    public $street;
    public $house_number;
    public $postal_code;
    public $city;
    public $membership_number;
    public $email;
    public $scouting_group;
    public $dietary_preferences;
    public $privacy_setting;
    public $parental_consent = 0;
    public $agreement_terms = 0;
    public $medicine_use = 0;
    public $medicine_details;
    public $participants;
    public $previous_hike;
    public $parent_name;
    public $parent_phone;
    public $editMode = false;
    public $selectedParticipantId;
    public $showImportModal = false;
    public $showForm = false;

    public function mount($groupId)
    {
        $this->group_id = $groupId;
        $this->group = Group::with('participants')->find($groupId);
        $this->participants = $this->group->participants;
        $this->privacy_setting = 'A'; 
        $this->showImportModal = false;  // Initialiseer de variabele
    }

    public function showCreateForm()
    {
        $this->resetInput();
        $this->showForm = true;
        $this->dispatch('scrollToForm');
    }

    public function showEditForm($participantId)
    {
        $this->editParticipant($participantId);
        $this->showForm = true;
        $this->dispatch('scrollToForm');
    }

    public function hideForm()
    {
        $this->showForm = false;
        $this->dispatch('scrollBackToPosition');
    }


    public function openImportModal()
    {
        
        $this->dispatch('openImportModal')->to('participant-import');
        
    }

    public function updatedMedicineUse($value)
{
    $this->medicine_use = filter_var($value);
}



public function closeImportModal()
{
    $this->showImportModal = false;
}

    public function addParticipant()
    { 
            // Zet de default waarden als ze nog niet zijn ingesteld
    $this->privacy_setting = $this->privacy_setting ?? 'C';
    $this->parental_consent = $this->parental_consent ?? 1;
    $this->agreement_terms = $this->agreement_terms ?? 1;
    $this->medicine_use = $this->medicine_use ?? 0;

        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'parent_name' => 'required',
            'parent_phone' => 'required',
            'email' => 'required|email',
            'parental_consent' => 'required|boolean',
            'agreement_terms' => 'required|boolean',
            'medicine_use' => 'required',
            'privacy_setting' => 'required|in:A,B,C', // Voeg deze regel toe
        ]);
        
        Participant::create([
            'group_id' => $this->group_id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'street' => $this->street,
            'house_number' => $this->house_number,
            'postal_code' => $this->postal_code,
            'city' => $this->city,
            'membership_number' => $this->membership_number,
            'email' => $this->email,
            'scouting_group' => $this->scouting_group,
            'previous_hike' => $this->previous_hike,
            'parent_name' => $this->parent_name,
            'parent_phone' => $this->parent_phone,
            'dietary_preferences' => $this->dietary_preferences,
            'privacy_setting' => $this->privacy_setting,
            'parental_consent' => $this->parental_consent,
            'agreement_terms' => $this->agreement_terms,
            'medicine_use' => $this->medicine_use,
            'medicine_details' => $this->medicine_details,
        ]);
        //dd($participant);
        // Vernieuw de lijst van deelnemers na het toevoegen
        $this->participants = Group::with('participants')->find($this->group_id)->participants;

        $this->resetInput();
        $this->showForm = false;
        
    }

    // Functie om een deelnemer te bewerken
    public function editParticipant($participantId)
    {   
        $participant = Participant::find($participantId);
        
        $this->selectedParticipantId = $participantId;
        $this->first_name = $participant->first_name;
        $this->middle_name = $participant->middle_name;
        $this->last_name = $participant->last_name;
        $this->street = $participant->street;
        $this->house_number = $participant->house_number;
        $this->postal_code = $participant->postal_code;
        $this->city = $participant->city;
        $this->membership_number = $participant->membership_number;
        $this->email = $participant->email;
        $this->scouting_group = $participant->scouting_group;
        $this->dietary_preferences = $participant->dietary_preferences;
        $this->privacy_setting = $participant->privacy_setting;
        $this->previous_hike = $participant->previous_hike;
        $this->parental_consent = $participant->parental_consent;
        $this->agreement_terms = $participant->agreement_terms;
        $this->parent_name = $participant->parent_name;
        $this->parent_phone = $participant->parent_phone;
        $this->medicine_use = $participant->medicine_use;
        $this->medicine_details = $participant->medicine_details;
        
        $this->editMode = true;
    }
    
 // Functie om een deelnemer bij te werken
 public function updateParticipant()
 {  
     $this->validate([
         'first_name' => 'required',
         'last_name' => 'required',
         'email' => 'required|email',
         'parental_consent' => 'required|boolean',
         'agreement_terms' => 'required|boolean',
         'medicine_use' => 'required',
         'privacy_setting' => 'required|in:A,B,C', // Voeg deze regel toe
     ]);
    

     
     $participant = Participant::find($this->selectedParticipantId);
     $participant->update([
        'group_id' => $this->group_id,
        'first_name' => $this->first_name,
        'middle_name' => $this->middle_name,
        'last_name' => $this->last_name,
        'street' => $this->street,
        'house_number' => $this->house_number,
        'postal_code' => $this->postal_code,
        'city' => $this->city,
        'membership_number' => $this->membership_number,
        'email' => $this->email,
        'scouting_group' => $this->scouting_group,
        'previous_hike' => $this->previous_hike,
        'parent_name' => $this->parent_name,
        'parent_phone' => $this->parent_phone,
        'dietary_preferences' => $this->dietary_preferences,
        'privacy_setting' => $this->privacy_setting,
        'parental_consent' => $this->parental_consent,
        'agreement_terms' => $this->agreement_terms,
        'medicine_use' => $this->medicine_use,
        'medicine_details' => $this->medicine_details,
     ]);

     // Vernieuw de lijst van deelnemers na het bijwerken
     $this->participants = Group::with('participants')->find($this->group_id)->participants;

     $this->resetInput();
     $this->showForm = false;
     $this->dispatch('scrollBackToPosition');
 }

 public function resetInput()
 {
    $this->first_name = null;
    $this->middle_name = null;
    $this->last_name = null;
    $this->street = null;
    $this->house_number = null;
    $this->postal_code = null;
    $this->city = null;
    $this->membership_number = null;
    $this->email = null;
    $this->scouting_group = null;
    $this->dietary_preferences = null;
    $this->privacy_setting = 'C';  // Default waarde
    $this->previous_hike = null;
    $this->parental_consent = 1;  // Default waarde
    $this->agreement_terms = 1;  // Default waarde
    $this->parent_name = null;
    $this->parent_phone = null;
    $this->medicine_use = 0;  // Default waarde
    $this->medicine_details = null;
    $this->editMode = false;
    $this->selectedParticipantId = null;
 }


    public function render()
    {
        return view('livewire.participant-manager', [
            'group' => $this->group,
        ])->layout('layouts.app');
    }
}