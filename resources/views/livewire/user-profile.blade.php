<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="py-6">
        <!-- Profielinformatie bovenaan -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full">
                <div class="ml-6">
                    <h2 class="text-3xl font-semibold">{{ $user->name }}</h2>
                    <p class="text-gray-600">{{ $user->username }}</p>
                </div>
            </div>
            <div>
                <a href="#" class="text-sm px-4 py-2 bg-gray-200 rounded-md">Profiel bewerken</a>
            </div>
        </div>

        <!-- Statistieken -->
        <div class="flex justify-between items-center my-4">
            <div class="text-center">
                <h4 class="font-semibold">{{ $moments->count() }}</h4>
                <span>berichten</span>
            </div>
            <!-- Voeg andere statistieken toe indien nodig -->
        </div>

        <!-- Grid met geposte afbeeldingen -->
        <div class="grid grid-cols-3 gap-4 mt-6">
            @foreach ($moments as $moment)
                <div class="relative">
                    <!-- Thumbnail -->
                    <img src="{{ Storage::url($moment->thumbnail_path) }}" alt="Moment thumbnail" 
                         class="w-full h-32 object-cover cursor-pointer" 
                         onclick="openModal('{{ Storage::url($moment->thumbnail_path) }}', '{{ $moment->caption }}', '{{ $moment->created_at }}')">
                </div>
            @endforeach
        </div>
    </div>



    <!-- Modal voor grotere afbeelding en details -->
<div id="imageModal" class="fixed z-50 inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden max-w-4xl w-full">
        <div class="flex">
            <!-- Grote afbeelding -->
            <div class="w-2/3">
                <img id="modalImage" src="" alt="Grote afbeelding" class="w-full h-full object-cover">
            </div>
            <!-- Details en comments -->
            <div class="w-1/3 p-4">
                <h2 id="modalCaption" class="text-xl font-bold"></h2>
                <p id="modalDate" class="text-sm text-gray-500"></p>
                <button onclick="closeModal()" class="mt-6 bg-red-500 text-white px-4 py-2 rounded">Sluiten</button>
                
            </div>
            
        </div>
    </div>
    <script>
        function openModal(imageSrc, caption, createdAt) {
            console.log("Modal geopend met afbeelding:", imageSrc); // Test om te zien of de klik werkt
    
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('modalCaption').textContent = caption || 'Geen bijschrift';
            document.getElementById('modalDate').textContent = new Date(createdAt).toLocaleDateString();
            
    
            // Toon de modal
            document.getElementById('imageModal').classList.remove('hidden');
        }
    
        function closeModal() {
            // Verberg de modal
            document.getElementById('imageModal').classList.add('hidden');
        }
    </script>
</div>
