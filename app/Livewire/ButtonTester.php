<?php

namespace App\Livewire;

use Livewire\Component;

class ButtonTester extends Component
{
    public function showNotification()
    {
        // Dispatch the browser event
        $this->dispatch('show-popup'); 
    }
    public function render()
    {
        return view('livewire.button-tester');
    }
}
