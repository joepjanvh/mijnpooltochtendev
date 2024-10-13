<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Group;
use App\Models\Participant;
use App\Models\Hike;

class GroupManager extends Component
{
    public $hike_id;
    public $group_name;
    public $group_number;
    public $groups;
    public $participants = [];
    public $editMode = false;
    public $selectedGroupId;

    protected $listeners = ['importCompleted' => 'reloadGroups'];

    public function reloadGroups()
    {
        // Herlaad de groepen na de import
        $this->groups = Group::where('hike_id', $this->hike_id)->with('participants')->get();
    }

    public function mount($hikeId)
    {
        $this->hike_id = $hikeId;
        $this->groups = Group::where('hike_id', $hikeId)->with('participants')->get();
    }

    public function createGroup()
    {
        $this->validate([
            'group_name' => 'required',
            'group_number' => 'required|numeric',
        ]);

        $group = Group::create([
            'hike_id' => $this->hike_id,
            'group_name' => $this->group_name,
            'group_number' => $this->group_number,
        ]);

        //$this->groups = Group::where('hike_id', $this->hike_id)->with('participants')->get();
        $this->reloadGroups();
        $this->resetInput();
    }
    public function editGroup($groupId)
    {
        $group = Group::find($groupId);
        $this->selectedGroupId = $groupId;
        $this->group_name = $group->group_name;
        $this->group_number = $group->group_number;
        $this->editMode = true;
    }
    public function updateGroup()
    {
        $this->validate([
            'group_name' => 'required',
            'group_number' => 'required|numeric',
        ]);

        $group = Group::find($this->selectedGroupId);
        $group->update([
            'group_name' => $this->group_name,
            'group_number' => $this->group_number,
        ]);

        //$this->groups = Group::where('hike_id', $this->hike_id)->with('participants')->get();
        $this->reloadGroups();
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->group_name = null;
        $this->group_number = null;
        $this->editMode = false;
        $this->selectedGroupId = null;
    }

    public function render()
    {   
        //render hike met jaartal
        $hike = Hike::with('edition')->find($this->hike_id);

        return view('livewire.group-manager', [
            'hike' => $hike,
        ])->layout('layouts.app');
    }
}
