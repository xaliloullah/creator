<?php
use App\Events\MessageSent;
use Illuminate\Support\Facades\Log;
use Livewire\Livewire;

protected $listen = [
    MessageSent::class => [
        function ($event) {
            // Log pour voir si l'événement est bien capté (optionnel)
            Log::info("Message reçu : " . $event->message->contenu);

            // Envoyer l'événement à tous les composants Livewire
            Livewire::emit('messageReceived');
        }
    ],
];
