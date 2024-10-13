<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Moment;
use App\Models\User;

class UserProfile extends Component
{
    public $user;
    public $moments;

    public function mount(User $user)
    {
        $this->user = $user;
        // Haal alle momenten van de gebruiker op
        $this->moments = Moment::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.user-profile')->layout('layouts.app');
    }
}