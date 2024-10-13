<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class SendPushNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        //
        // Haal de geregistreerde gebruiker op
        $user = $event->user;

        // Verstuur pushnotificatie met Simplepush
        $response = Http::post('https://api.simplepush.io/send', [
            'key' => env('SIMPLEPUSH_KEY'), // Zorg dat je de key hebt ingesteld in je .env bestand
            'title' => 'MijnPooltochten.nl - Nieuwe Gebruiker!',
            'msg' => "Een nieuwe gebruiker, {$user->name}, heeft zich geregistreerd."
        ]);

        if ($response->failed()) {
            // Foutafhandeling indien nodig
        }
    }
}
