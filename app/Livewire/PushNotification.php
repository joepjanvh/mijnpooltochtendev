<?php

namespace App\Livewire;

use Livewire\Component;
use GuzzleHttp\Client;

class PushNotification extends Component
{
    public $key;
    public $title;
    public $message;
    public $event;

    public function sendPushNotification()
    {
        $client = new Client();
        $key = env('SIMPLEPUSH_KEY');
        // Verstuur het pushbericht via een POST request naar Simplepush
        $response = $client->post('https://simplepu.sh', [
            'json' => [
                'key' => $key,
                'title' => $this->title,
                'msg' => $this->message,
                'event' => $this->event
            ]
        ]);

        // Response verwerken
        if ($response->getStatusCode() == 200) {
            session()->flash('success', 'Pushbericht succesvol verzonden!');
            
        } else {
            session()->flash('error', 'Er ging iets mis bij het versturen van het pushbericht.');
            
        }
    }

    public function render()
    {
        return view('livewire.push-notification')->layout('layouts.app');
    }
}

