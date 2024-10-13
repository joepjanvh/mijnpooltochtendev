<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Postenbeheer voor Hike {{ $hike->hike_letter }} - {{ $edition->year }}</h1>

    <!-- Knop om het formulier te tonen of te verbergen -->
    @can('posten aanmaken')
    <div class="mb-4">
        <div id="post-form-section"></div> <!-- Scroll anchor -->
        <button wire:click="{{ $showForm ? 'hideForm' : 'showCreateForm' }}"
            class="{{ $showForm ? 'bg-red-500 hover:bg-red-600' : 'bg-blue-500 hover:bg-blue-600' }} text-white px-4 py-2 rounded-md">
            {{ $showForm ? 'Annuleren' : 'Nieuwe Post Aanmaken' }}
        </button>
    </div>
    @endcan
    <!-- Formulier om een nieuwe post toe te voegen -->
    <!-- Formulier voor het aanmaken of bewerken van een post -->
    @if ($showForm)
        <form wire:submit.prevent="{{ $post_id ? 'updatePost' : 'createPost' }}"
            class="grid grid-cols-1 gap-4 mb-8">



            <div class="col-span-1">
                <label for="post_number" class="block text-sm font-medium text-gray-700">Postnummer</label>
                <input type="text" wire:model="post_number" id="post_number"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Bijv. A01">
                @error('post_number')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-1">
                <label for="selected_day" class="block text-sm font-medium text-gray-700">Dag</label>
                <select wire:model="selected_day" id="selected_day"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Selecteer een dag</option>
                    <option value="woensdag">Woensdag</option>
                    <option value="donderdag">Donderdag</option>
                    <option value="vrijdag">Vrijdag</option>
                    <option value="zaterdag">Zaterdag</option>
                </select>
                @error('selected_day')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>


            <div class="col-span-1">
                <label for="location" class="block text-sm font-medium text-gray-700">Locatie</label>
                <input type="text" wire:model="location" id="location"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Bijv. Ada's Hoeve">
                @error('location')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-1">
                <label for="planned_start_time" class="block text-sm font-medium text-gray-700">Geplande
                    Starttijd</label>
                <input type="time" wire:model="planned_start_time" id="planned_start_time"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('planned_start_time')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-1">
                <label for="planned_duration" class="block text-sm font-medium text-gray-700">Geplande Duur
                    (minuten)</label>
                <input type="number" wire:model="planned_duration" id="planned_duration"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Bijv. 60">
                @error('planned_duration')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <!-- instructies en werkploeg -->
            <div class="col-span-1">
                <label for="required_workforce" class="block text-sm font-medium text-gray-700">Benodigde
                    Posthouders</label>
                <input type="number" wire:model="required_workforce" id="required_workforce"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Bijv. 3">
                @error('required_workforce')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1">
                <label for="instructions" class="block text-sm font-medium text-gray-700">Instructies</label>
                <textarea wire:model="instructions" id="instructions"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    rows="3" placeholder="Voeg instructies toe..."></textarea>
                @error('instructions')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>


            <!-- Aanvoer Post -->
            <div class="col-span-1">
                <label for="supply_adas_hoeve" class="block text-sm font-medium text-gray-700">Aanvoer Ada's
                    Hoeve</label>
                <select wire:model="supply_adas_hoeve" id="supply_adas_hoeve"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Selecteer dienst</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->name }}">{{ $service->name }}</option>
                    @endforeach
                </select>
                @error('supply_adas_hoeve')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1">
                <label for="supply_post" class="block text-sm font-medium text-gray-700">Aanvoer Post</label>
                <select wire:model="supply_post" id="supply_post"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Selecteer dienst</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->name }}">{{ $service->name }}</option>
                    @endforeach
                </select>
                @error('supply_post')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>



            <!-- Materialen -->
            <div class="col-span-1">
                <label for="materials" class="block text-sm font-medium text-gray-700">Materialen</label>
                <div class="flex space-x-2">
                    <input type="text" wire:model="new_material" id="new_material"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Voeg materiaal toe">
                    <button wire:click.prevent="addMaterial"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md">+</button>
                </div>

                <!-- Verbeterde lijst van materialen -->
                <ul class="mt-2 space-y-2">
                    @foreach ($materials as $index => $material)
                        <li class="flex justify-between items-center bg-gray-100 p-4 rounded shadow-md">
                            <span class="text-gray-700 font-semibold">{{ $material }}</span>
                            <button wire:click="removeMaterial({{ $index }})"
                                class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-full shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- Veld voor locatie met Leaflet-kaart -->
         
            <!-- Leaflet kaart veld -->
            <div class="w-full z-0">
                <label for="location" class="block text-sm font-medium text-gray-700">Selecteer Locatie op Kaart</label>
                <div id="map" wire:ignore class="w-full h-72 sm:h-96 mb-4"></div>

                <!-- Invoervelden voor Latitude en Longitude -->
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                    <div class="w-full sm:w-1/2">
                        <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                        <input type="text" wire:model="latitude" id="latitude"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="w-full sm:w-1/2">
                        <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                        <input type="text" wire:model="longitude" id="longitude"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>
            </div>


<!-- Voeg Post Toe Knop -->
<div class="col-span-1">
    <button type="submit"
        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
        {{ $post_id ? 'Update Post' : 'Voeg Post Toe' }}
    </button>

            </div>
        </form>
    @endif


    <!-- Bestaande Posten -->
    <h2 class="text-xl font-semibold mb-4">Postenoverzicht</h2>
    <ul class="space-y-4">
        @foreach ($posts as $post)
            <li class="p-4 bg-white rounded-lg shadow">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold"><a
                                href="/post/{{ $post->id }}">{{ $post->post_number }} - {{ $post->location }}
                                ({{ $post->date }})</a></h3>
                                <p class="text-sm text-gray-500">Dag: {{ \Carbon\Carbon::parse($post->date)->translatedFormat('l') }}</p>
                        <p class="text-sm text-gray-500">Instructies: {{ $post->instructions }}</p>
                        <p class="text-sm text-gray-500">Benodigde Posthouders: {{ $post->required_workforce }}</p>
                        <!-- Edit Button -->


                        @if (!$post->time_open)
                            <p class="text-sm text-red-600">Post is nog niet geopend</p>
                            @can('opensluit post')
                            <button wire:click="openPost({{ $post->id }})"
                                class="text-sm text-white bg-blue-500 hover:bg-blue-600 rounded px-4 py-1">
                                Post Openen
                            </button>
                            @endcan
                        @elseif(!$post->time_close)
                            <p class="text-sm text-green-600">Post is geopend op {{ $post->time_open }}</p>
                            @can('opensluit post')
                            <button wire:click="closePost({{ $post->id }})"
                                class="text-sm text-white bg-red-500 hover:bg-red-600 rounded px-4 py-1">
                                Post Sluiten
                            </button>
                            @endcan
                        @else
                            <p class="text-sm text-gray-600">Post is gesloten op {{ $post->time_close }}</p>
                        @endif
                    </div>
                    <div>
                        <img src="{{ $this->generateQrCode($post->id) }}"
                            alt="QR Code voor Post {{ $post->post_number }}" class="w-24 h-24">
                            @can('edit post')
                            <button wire:click="showEditForm({{ $post->id }})"
                            class="text-sm mt-2 text-white bg-yellow-500 hover:bg-yellow-600 rounded px-4 py-1 edit-post-btn">
                            Post Bewerken
                        </button>
                        @endcan
                    </div>

                </div>
            </li>
        @endforeach
    </ul>
    <!-- Veld voor locatie met Leaflet-kaart -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.6.2/proj4.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4leaflet/1.0.1/proj4leaflet.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = null; // Initialiseer de kaart variabele als null
            var marker = null; // Initialiseer de marker variabele als null

            // Functie om de kaart te initialiseren
            function initMap() {
                if (map) {
                    map.remove(); // Verwijder de bestaande kaart
                    map = null; // Reset de kaart variabele
                }
                // Standaardlocatie (bijv. Utrecht)
                var defaultLatLng = [52.51419096935357, 6.402049362659454];

                // OpenStreetMap tile layer
                var osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                });
                var googleSatLayer = L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}&key=AIzaSyBdzCXuVZvZight65QfVO4HVA6ka7_DK6M', {
    attribution: '© Google',
    maxZoom: 20
});

                // Initieer de kaart met een standaard locatie (bijv. Utrecht)
                map = L.map('map').setView([52.51419096935357, 6.402049362659454], 16);

                // Voeg een tile layer toe (OpenStreetMap)
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
              }).addTo(map);
// Voeg een laagcontrole toe voor het wisselen tussen OSM en Satellietweergave
var baseMaps = {
                    "OpenStreetMap": osmLayer,
                    "Satelliet": googleSatLayer
                };
    
                L.control.layers(baseMaps).addTo(map);





                // Bij klikken op de kaart: update de marker en de invoervelden
                map.on('click', function(e) {
                    var lat = e.latlng.lat;
                    var lng = e.latlng.lng;

                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;
                    @this.set('latitude', lat);
                    @this.set('longitude', lng);

                    updateMarker(lat, lng);
                });
            }

            // Functie om de marker op de kaart te plaatsen of te updaten
            function updateMarker(lat, lng) {
                if (!isNaN(lat) && !isNaN(lng)) {
                    // Als de marker al bestaat, verplaats deze
                    if (marker) {
                        console.log("moving marker");
                        marker = L.marker([lat, lng]).addTo(map);
                        marker.setLatLng([lat, lng]);
                    } else {
                        console.log("making marker");
                        // Als de marker niet bestaat, maak een nieuwe aan
                        marker = L.marker([lat, lng]).addTo(map);
                    }
                    // Zoom de kaart naar de nieuwe locatie
                    map.setView([lat, lng], 18);
                } else {
                    console.error('Invalid coordinates:', lat, lng);
                }
            }
            // Luister naar het juiste Livewire-event om de marker te updaten
            Livewire.on('updateMarker', (coordinates) => {
                //initMap();
                // Controleer of het een object is en haal de lat en lng eruit
                //var lat = parseFloat(coordinates.lat);
                //var lng = parseFloat(coordinates.lng);
                //console.log(coordinates);
                var lat = (coordinates.lat);
                var lng = (coordinates.lng);
                console.log('Received marker update:', lat, lng);
                updateMarker(lat, lng); // Update de marker met de juiste coördinaten
            });

            // Luister naar het Livewire-event om de kaart te initialiseren wanneer het formulier zichtbaar is
            Livewire.on('initMap', () => {
                setTimeout(function() { // Gebruik setTimeout om er zeker van te zijn dat de kaart correct wordt geladen
                    initMap();
                    // Herinitialiseer de marker als de coördinaten al bestaan
                    var lat = parseFloat(document.getElementById('latitude').value);
                    var lng = parseFloat(document.getElementById('longitude').value);
                    if (!isNaN(lat) && !isNaN(lng)) {
                        updateMarker(lat, lng);
                    }
                }, 200); // Wacht een fractie van een seconde om de kaart goed te laden
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('scrollToForm', () => {
                const formSection = document.getElementById('post-form-section');
                if (formSection) {
                    formSection.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
    <script>
        let lastScrollPosition = 0;

        document.addEventListener('DOMContentLoaded', function() {
            // Sla de huidige scrollpositie op wanneer "Post Bewerken" wordt geklikt
            document.querySelectorAll('.edit-post-btn').forEach(button => {
                button.addEventListener('click', function() {
                    lastScrollPosition = window.pageYOffset; // Sla de huidige scrollpositie op
                });
            });

            // Scroll terug naar de opgeslagen positie wanneer het formulier gesloten wordt of na een actie
            Livewire.on('scrollBackToPosition', () => {
                window.scrollTo({
                    top: lastScrollPosition,
                    behavior: 'smooth'
                });
            });
        });
    </script>


</div>
