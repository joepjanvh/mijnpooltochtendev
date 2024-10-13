<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Editiebeheer</h1>

    <!-- Formulier om een nieuwe editie toe te voegen of een bestaande editie aan te passen -->
    <form wire:submit.prevent="{{ $editEditionId ? 'saveEdition' : 'createEdition' }}" class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
        <div class="col-span-1">
            <label for="year" class="block text-sm font-medium text-gray-700">Jaar</label>
            <input type="text" wire:model="year" id="year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Bijv. 2024">
            @error('year') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="col-span-1">
            <label for="start_date" class="block text-sm font-medium text-gray-700">Startdatum</label>
            <input type="date" wire:model="start_date" id="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('start_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="col-span-1">
            <label for="end_date" class="block text-sm font-medium text-gray-700">Einddatum</label>
            <input type="date" wire:model="end_date" id="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('end_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="col-span-1 sm:col-span-2">
            <label for="active" class="flex items-center">
                <input type="checkbox" wire:model="active" id="active" class="mr-2">
                Deze editie actief maken
            </label>
        </div>

        <!-- Conditional button: Voeg toe of Opslaan -->
        <div class="col-span-1 sm:col-span-2">
            @if($editEditionId)
                <!-- Knop om wijzigingen op te slaan -->
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:text-sm">
                    Wijzigingen Opslaan
                </button>
            @else
                <!-- Knop om een nieuwe editie toe te voegen -->
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                    Voeg Editie Toe
                </button>
            @endif
        </div>
    </form>

    <!-- Bestaande Edities -->
    <h2 class="text-xl font-semibold mb-4">Bestaande Edities</h2>
    <ul class="space-y-4">
        @foreach($editions as $edition)
            <li class="p-4 bg-white rounded-lg shadow">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold">
                            <a href="/hike-manager/{{ $edition->id }}" class="text-blue-600 hover:text-blue-800">
                                Editie {{ $edition->year }}
                            </a>
                        </h3>
                        <p>Startdatum: {{ $edition->start_date }}</p>
                        <p>Einddatum: {{ $edition->end_date }}</p>
                    </div>

                    <div class="flex items-center">
                        <!-- Toon een groen vinkje als deze editie actief is -->
                        @if($edition->active)
                            <svg class="w-6 h-6 text-green-600 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        @endif
                        <!-- Aanpassen-knop -->
                        <button wire:click="editEdition({{ $edition->id }})" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md">Aanpassen</button>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
