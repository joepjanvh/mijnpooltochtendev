<div class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <!-- Titel -->
        <h1 class="text-2xl font-semibold mb-6">Upload een Moment</h1>

        <!-- Succesbericht -->
        @if (session()->has('message'))
            <div class="text-green-500 mb-4">
                {{ session('message') }}
            </div>
        @endif
 
        <!-- Moment Upload Formulier -->
        <form wire:submit.prevent="uploadMoment" class="mb-6">
            <!-- Bestand Upload -->
            <div class="mb-4">
                <label for="file" class="block text-sm font-medium text-gray-700">Selecteer Afbeelding (video moet nog geimplementeerd worden en lukt nog niet momenteel)</label>
                <input type="file" wire:model="file" id="file"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                       accept="image/*,video/*">
               
            </div>
            @if ($file)
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Voorvertoning</label>
                @if (in_array($file->getClientOriginalExtension(), ['mp4']))
                    <video controls class="mt-2 rounded-lg shadow-md max-w-72">
                        <source src="{{ $file->temporaryUrl() }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <img src="{{ $file->temporaryUrl() }}" alt="Voorvertoning" class="mt-2 rounded-lg shadow-md max-w-72">
                @endif
            </div>
        @endif
        


            <!-- Bijschrift -->
            <div class="mb-4">
                <label for="caption" class="block text-sm font-medium text-gray-700">Bijschrift</label>
                <textarea wire:model="caption" id="caption"
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                          placeholder="Bijschrift toevoegen..."></textarea>
                @error('caption')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Hike Selectie (Optioneel) -->
            <div class="mb-4">
                <label for="hike_id" class="block text-sm font-medium text-gray-700">Selecteer een Hike (optioneel)</label>
                <select wire:model="hike_id" id="hike_id"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Geen Hike</option>
                    @foreach($hikes as $hike)
                        <option value="{{ $hike->id }}">{{ $hike->hike_letter }}</option>
                    @endforeach
                </select>
                @error('hike_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Locatie -->
            <div class="mb-4">
                <label for="location" class="block text-sm font-medium text-gray-700">Locatie</label>
                <input type="text" wire:model="location" id="location"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                       placeholder="Locatie">
                @error('location')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
<!-- Laadindicator -->
<div wire:loading wire:target="file" class="flex items-center space-x-2 text-blue-500">
    <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
    </svg>
    <span>Uploaden bezig...</span>
</div>
            <!-- Moment Upload Knop -->
            <div>
                <button type="submit" 
                class="w-full sm:w-auto inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-white text-base font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                wire:click="uploadMoment"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-50 cursor-not-allowed">
                <span wire:loading.remove>Moment Uploaden</span>
                <span wire:loading>Moment aan het uploaden...</span>
            </button>
            
        <div wire:loading wire:target="uploadMoment" class="flex items-center space-x-2 text-blue-500">
            <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
            <span>Video wordt geconverteerd, even geduld...</span>
        </div>
            </div>
        </form>
    </div>

<!-- Modaal voor de Date & Time Picker -->
<div x-data="{ showModal: @entangle('showModal') }">
    <template x-if="showModal">
        <div class="fixed inset-0 z-50  flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded w-4/5 min-h-60 shadow-lg">
                <p class="text-base font-semibold">Foto bevat geen datum en tijd info, stel deze hier in!</p>
                
                <input type="datetime-local" id="photoTime" wire:model="photo_taken_at" class="mt-2 p-2 border rounded">
                <div class="mt-4">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded" wire:click="savePhotoTime">Opslaan</button>
                    <button class="bg-gray-500 text-white px-4 py-2 rounded hidden" @click="showModal = true">Annuleren</button>
                </div>
            </div>
        </div>
    </template>
</div>





<script>
    document.addEventListener('livewire:init', function () {
            Livewire.on('showDateTimePicker', function () {
            document.getElementById('dateTimeModal').style.display('flex');
            document.getElementById('dateTimeModal').classList.remove('hidden');
        });
    });
        document.addEventListener('livewire:init', function () {
        Livewire.on('closeDateTimePicker', function () {
            document.getElementById('dateTimeModal').style.display('none');
            document.getElementById('dateTimeModal').classList.add('hidden');
        });
    });
</script>
<script>
    document.addEventListener('livewire:init', function () {
    Livewire.on('requestUserLocation', () => {
        console.log("userlocation requested");
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                Livewire.dispatch('setUserLocation', [position.coords.latitude, position.coords.longitude]);
                console.log(position.coords.latitude, position.coords.longitude);
            }, function (error) {
                console.error('Error getting location: ', error);
                Livewire.dispatch('setUserLocation', [null, null]); // Geen locatie beschikbaar
                console.log("error getting location");
            });
        } else {
            console.error('Geolocation is not supported by this browser.');
            Livewire.dispatch('setUserLocation', [null, null]);
            console.log("location not supported");
        }
    });
});

    </script>




</div>
