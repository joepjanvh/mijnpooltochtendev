<div>
    @if (session()->has('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-500 text-white p-4 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="sendPushNotification">
        <div class="mb-4">
            <label for="title" class="block text-gray-700">Titel</label>
            <input type="text" id="title" wire:model="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Voer de titel in (optioneel)">
        </div>

        <div class="mb-4">
            <label for="message" class="block text-gray-700">Bericht</label>
            <textarea id="message" wire:model="message" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Voer het bericht in"></textarea>
        </div>

        <div class="mb-4">
            <label for="event" class="block text-gray-700">Event</label>
            <input type="text" id="event" wire:model="event" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Voer event in (optioneel)">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">
            Verstuur Pushbericht
        </button>
    </form>
</div>
