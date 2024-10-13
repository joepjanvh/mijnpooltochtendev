<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Groepenbeheer voor Hike {{ $hike->hike_letter }} (Editie {{ $hike->edition->year }})</h1>
<!-- Importeer Gegevens Knop -->

<div class="mb-4">
    <button type="button" wire:click="$dispatch('openImportModal')" class="bg-green-600 text-white px-4 py-2 rounded-md">
        Importeer Gegevens
    </button>
    <!-- Formulier om een nieuwe groep toe te voegen of te bewerken -->
    <form wire:submit.prevent="{{ $editMode ? 'updateGroup' : 'createGroup' }}" class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
        <!-- Groepsnummer -->
        <div class="col-span-1">
            <label for="group_number" class="block text-sm font-medium text-gray-700">Groepsnummer</label>
            <input type="number" wire:model="group_number" id="group_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Bijv. 1">
            @error('group_number') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Groepsnaam -->
        <div class="col-span-1">
            <label for="group_name" class="block text-sm font-medium text-gray-700">Groepsnaam</label>
            <input type="text" wire:model="group_name" id="group_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Bijv. De Scouting Groep">
            @error('group_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Toevoegen/Bewerken knop -->
        <div class="col-span-1 sm:col-span-2">
            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                {{ $editMode ? 'Update Groep' : 'Voeg Groep Toe' }}
            </button>
        </div>
    </form>

    <!-- Bestaande Groepen -->
    <h2 class="text-xl font-semibold mb-4">Bestaande Groepen</h2>
    <ul class="space-y-4">
        @foreach($groups as $group)
            <li class="p-4 bg-white rounded-lg shadow">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold"><a href="/participant-manager/{{ $group->id }}">Koppel {{ $group->group_number }}</a> - {{ $group->group_name }}</h3>
                        <p class="text-sm text-gray-500">{{ $group->participants->count() }} deelnemers</p>
                    </div>
                    <div>
                        <button wire:click="editGroup({{ $group->id }})" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-white text-base font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Bewerken</button>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>`
    
    <livewire:participant-import :hikeId="$hike_id" />

</div>
