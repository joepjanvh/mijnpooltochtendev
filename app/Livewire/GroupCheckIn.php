<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Group;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class GroupCheckIn extends Component
{
    public $post_id;
    public $groups;
    public $post;

    public function mount($postId)
    {
        $this->post_id = $postId;
        $this->post = Post::find($postId);
        $this->groups = Group::whereHas('hike', function ($query) use ($postId) {
            $query->whereHas('posts', function ($postQuery) use ($postId) {
                $postQuery->where('id', $postId);
            });
        })->get();
    }

    public function checkIn($groupId)
    {
        // Maak een nieuw record aan voor elke check-in
        DB::table('group_post')->insert([
            'group_id' => $groupId,
            'post_id' => $this->post_id,
            'arrival_time' => now(),
        ]);

        // Vernieuw de lijst met groepen
        $this->refreshGroups();
    }

    public function checkOut($groupId)
    {
        // Update het meest recente record van de groep op deze post met de vertrektijd
        DB::table('group_post')
            ->where('group_id', $groupId)
            ->where('post_id', $this->post_id)
            ->whereNull('departure_time') // Update alleen als de groep nog niet is afgemeld
            ->update(['departure_time' => now()]);

        // Vernieuw de lijst met groepen
        $this->refreshGroups();
    }

    public function refreshGroups()
    {
        $this->groups = Group::whereHas('hike', function ($query) {
            $query->whereHas('posts', function ($postQuery) {
                $postQuery->where('id', $this->post_id);
            });
        })->get();
    }

    public function render()
    {
        return view('livewire.group-check-in', [
            'groups' => $this->groups,
            'post' => $this->post,
        ])->layout('layouts.app');
    }
}
