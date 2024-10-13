<div class="flex flex-col min-h-screen h-screen">
    <!-- Filters -->
    <div class="filters flex space-x-4 mb-4 p-4 bg-white shadow" style="height: 120px;">
        <!-- Filter op dagen -->
        <div>
            <label for="day" class="block text-sm pt-4 font-semibold">Filter op dag:</label>
            <select wire:model.live="selectedDay" id="day" class="border p-2 rounded w-full">
                <option value="">Alle dagen</option>
                <option value="woensdag">Woensdag</option>
                <option value="donderdag">Donderdag</option>
                <option value="vrijdag">Vrijdag</option>
                <option value="zaterdag">Zaterdag</option>
            </select>
        </div>

        <!-- Filter op hikes -->
        <div>
            <label class="block text-sm pt-4 font-semibold">Filter op hikes:</label>
            <div class="flex space-x-2">
                @foreach ($hikes as $hike)
                    <div class="inline-flex items-center">
                        <input type="checkbox" value="{{ $hike->id }}" wire:model.live="selectedHikes">
                        <span class="ml-2">{{ $hike->hike_letter }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Map Container -->
    <div class="flex-grow">
        <div id="map" wire:ignore class="w-full mb-2 z-10 h-full"></div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" crossorigin=""></script>
    <script>
        document.addEventListener('livewire:init', function () {
            var map = L.map('map').setView([52.51419096935357, 6.402049362659454], 14); // Standaardlocatie en zoom
    
            // Voeg de kaartlaag toe
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
            }).addTo(map);
    
            var hikeColors = {
                'A': 'red',
                'B': 'blue',
                'C': 'green',
                'D': 'brown',
                'E': 'purple',
                'F': 'yellow',
            };
    
            // Update de markers wanneer de component wordt herladen
            Livewire.on('updateMap', function (data) {
                console.log('Data ontvangen:', data); // Controleer de volledige ontvangen data in de console
    
                // Controleer of 'data[0].posts' bestaat en een array is
                if (data && Array.isArray(data[0].posts) && data[0].posts.length > 0) {
                    var posts = data[0].posts; // Haal de posts array correct op vanuit data[0]
    
                    // Verwijder alle bestaande markers van de kaart
                    map.eachLayer(function (layer) {
                        if (!!layer.toGeoJSON) {
                            map.removeLayer(layer); // Verwijder bestaande markers
                        }
                    });
    
                    // Voeg nieuwe markers toe voor elke post
                    posts.forEach(function (post) {
                        var color = hikeColors[post.hike_letter] || 'black'; // Hike-specifieke kleur of fallback kleur
    
                        // Bepaal de opacity en kleur op basis van de status van de post
                        var fillOpacity = 1; // Standaard doorzichtigheid
                        if (post.time_open) {
                            fillOpacity = 0.5; // Post geopend, volledige kleur
                        }
                        if (post.time_close) {
                            fillOpacity = 0; // Post gesloten, geen invulling
                        }
    
                        // Voeg de cirkel toe als marker
                        var circle = L.circleMarker([post.latitude, post.longitude], {
                            color: color,
                            radius: 15, // De straal van de cirkel aanpassen indien nodig
                            fillOpacity: fillOpacity // Doorzichtigheid van de cirkel gebaseerd op open/closed status
                        }).addTo(map);
    
                        // Voeg postnummer toe aan de marker als tooltip
                        var icon = L.divIcon({
                            className: 'custom-div-icon', // Voeg custom CSS toe voor styling
                            html: `<strong style="color: black; font-weight: bold;">${post.post_number}</strong>`,
                            iconSize: [30, 30],
                            iconAnchor: [10, 10]
                        });
    
                        // Voeg de marker toe met een popup die de dag, geplande starttijd en Google Maps-link toont
                        var marker = L.marker([post.latitude, post.longitude], { icon: icon }).addTo(map)
                            .bindPopup(`
                                <p class="text-base font-semibold"> ${post.post_number} </p>
                                <p class="text-sm font-normal">Dag: ${post.day}</p>
                                <p class="text-sm font-normal">Geplande starttijd: ${post.planned_start_time}</p>                                
                                <a href="https://www.google.com/maps?q=${post.latitude},${post.longitude}" class="text-sm font-semibold" target="_blank" style="color:blue;">Open in Google Maps</a>
                            `);
                    });
                } else {
                    console.error('Posts is not an array or not found in data:', data);
                }
            });
        });
    </script>
    
    
</div>
