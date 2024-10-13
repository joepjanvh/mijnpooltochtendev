<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class PointAssignment extends Component
{
    public $post_id;
    public $groups;

    public $checkInPoints = [];
    public $attitudePoints = [];
    public $performancePoints = [];

    public $successMessage = '';  // Voeg een succesboodschap toe

    public function mount($postId)
    {
        $this->post_id = $postId;
        $this->groups = DB::table('groups')
            ->join('group_post', 'groups.id', '=', 'group_post.group_id')
            ->where('group_post.post_id', $postId)
            ->select('groups.*', 'group_post.check_in_points', 'group_post.attitude_points', 'group_post.performance_points')
            ->get();
    
        // Voor elke groep de bestaande punten laden
        foreach ($this->groups as $group) {
            $this->checkInPoints[$group->id] = $group->check_in_points;
            $this->attitudePoints[$group->id] = $group->attitude_points;
            $this->performancePoints[$group->id] = $group->performance_points;
        }
    }

    public function assignPoints($groupId)
    {
        $group = DB::table('groups')->where('id', $groupId)->first();
        DB::table('group_post')
            ->where('group_id', $groupId)
            ->where('post_id', $this->post_id)
            ->update([
                'check_in_points' => $this->checkInPoints[$groupId] ?? 0,
                'attitude_points' => $this->attitudePoints[$groupId] ?? 0,
                'performance_points' => $this->performancePoints[$groupId] ?? 0,
            ]);
 // Toon een succesboodschap
     // Toon een succesboodschap met groepsnaam en -nummer
     $this->successMessage = "Punten voor koppel {$group->group_number} - {$group->group_name} succesvol opgeslagen!";
        
        // Vernieuw de lijst met groepen en hun punten
        $this->groups = DB::table('groups')
            ->join('group_post', 'groups.id', '=', 'group_post.group_id')
            ->where('group_post.post_id', $this->post_id)
            ->select('groups.*', 'group_post.check_in_points', 'group_post.attitude_points', 'group_post.performance_points')
            ->get();
    }

    public function render()
    {
        return view('livewire.point-assignment', [
            'groups' => $this->groups
        ])->layout('layouts.app');
    }
}
