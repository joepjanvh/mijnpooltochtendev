<div class="container mx-auto p-4">
 <!-- Voeg Leaflet CSS toe -->
 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-p4BvY4GsC4IGH0l9bPcnXQaPq5mQuK5D3u1lznKpErw=" crossorigin="" />
    <div class="bg-white rounded-lg shadow p-6 mb-8 flex justify-between items-start">
        <div class="flex-grow">
            <h1 class="text-2xl font-semibold mb-4">Post {{ $post->post_number }}</h1>

            <div class="mb-4">
                <p class="text-lg"><strong>Locatie:</strong> {{ $post->location }}</p>
                <p class="text-lg"><strong>Instructies:</strong> {{ $post->instructions }}</p>
                <p class="text-lg"><strong>Aantal benodigde posthouders:</strong> {{ $post->required_workforce }}</p>
                <p class="text-lg"><strong>Geplande Datum:</strong> {{ \Carbon\Carbon::parse($post->date)->translatedFormat('l, d F Y') }}</p>
                <p class="text-lg"><strong>Geplande Starttijd:</strong> {{ $post->planned_start_time }}</p>
                <p class="text-lg"><strong>Geplande Duur:</strong> {{ $post->planned_duration }} minuten</p>
                <p class="text-lg"><strong>Aanvoer Post:</strong> {{ $post->supply_post }}</p>
                <p class="text-lg"><strong>Aanvoer Ada's Hoeve:</strong> {{ $post->supply_adas_hoeve }}</p>
            </div>
            @can('group checkin')
            <a href="/group-check-in/{{ $post->id }}"><button class="w-full sm:w-auto inline-flex justify-center rounded-md border border-transparent shadow-sm m-2 px-4 py-2 bg-blue-600 text-white text-base font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Koppels Aan / Afmelden
            </button></a>
            @endcan
            @can('assign points')
            <a href="/point-assignment/{{ $post->id }}"><button class="w-full sm:w-auto inline-flex justify-center rounded-md border border-transparent shadow-sm m-2 px-4 py-2 bg-blue-600 text-white text-base font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Punten toekennen
            </button></a>
            @endcan
            <!-- Materialen lijst -->
            @if($post->materials)
                <div class="mb-4">
                    <p class="text-lg"><strong>Materialen:</strong></p>
                    <ul class="list-disc list-inside">
                        @foreach(json_decode($post->materials) as $material)
                            <li>{{ $material }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @can('opensluit post')
            <div class="mb-4">
                @if($post->time_open && !$post->time_close)
                    <p class="text-green-600 text-lg mb-4">Post is geopend op {{ $post->time_open }}</p>
                    <button wire:click="closePost({{ $post->id }})" class="w-full sm:w-auto inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-white text-base font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Post Sluiten
                    </button>
                @elseif($post->time_close)
                    <p class="text-gray-600 text-lg">Post is gesloten op {{ $post->time_close }}</p>
                @else
                    <p class="text-yellow-600 text-lg mb-4">Post is nog niet geopend</p>
                    <button wire:click="openPost({{ $post->id }})" class="w-full sm:w-auto inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-white text-base font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Post Openen
                    </button>
                @endif
            </div>
            @endcan
            
            @if($post->latitude && $post->longitude)
            <p>Latitude: {{ $post->latitude }}</p>
            <p>Longitude: {{ $post->longitude }}</p>
            
            <!-- Kaart voor locatie -->
           
    <div class="mb-4">
        <div id="map" wire:ignore style="height: 400px; width: 100%;" class="mb-4"></div>
        <!-- Google Maps knop -->
        <a href="https://www.google.com/maps?q={{ $post->latitude }},{{ $post->longitude }}" target="_blank">
            <button class="mt-2 w-full sm:w-auto inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-white text-base font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Open in Google Maps
            </button>
        </a>
    </div>
@endif

        </div>

        <!-- QR-code -->
        
            
        
    </div>
    <img src="{{ $this->generateQrCode($post->id) }}" alt="QR Code voor Post {{ $post->post_number }}" class="w-32 h-32">

<!-- Voeg de script voor Leaflet en de kaart toe -->
<!-- Voeg Leaflet JavaScript toe -->
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-QVJ+ldh0AqBLxpMRyoZk3IAy0t4DoXUu8k3BBSJiEYk=" crossorigin=""></script>

<script>

    document.addEventListener('DOMContentLoaded', function () {
        @if($post->latitude && $post->longitude)
            // Zorg ervoor dat het element met id 'map' bestaat voordat we de kaart initialiseren
            var mapElement = document.getElementById('map');
            if (mapElement) {
                var map = L.map(mapElement).setView([{{ $post->latitude }}, {{ $post->longitude }}], 16);

                // Voeg een tile layer toe (OpenStreetMap)
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                // Voeg een marker toe op de locatie van de post
                L.marker([{{ $post->latitude }}, {{ $post->longitude }}]).addTo(map)
                    .bindPopup('Post {{ $post->post_number }}: {{ $post->location }}');
            } else {
                console.error('Element met id "map" niet gevonden.');
            }
        @endif
    });
</script>

 
</script>
</div>