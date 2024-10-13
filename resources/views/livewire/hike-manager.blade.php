<div class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <!-- Titel -->
        <h1 class="text-2xl font-semibold mb-6">Beheer van Hikes voor Editie {{ $edition->year }}</h1>

        <!-- Formulier om een nieuwe hike toe te voegen -->
        @can('add hike')
        <form wire:submit.prevent="createHike" class="mb-6">
            <div class="mb-4">
                <label for="hike_letter" class="block text-sm font-medium text-gray-700">Hike Letter (A-F)</label>
                <input type="text" wire:model="hike_letter" id="hike_letter" maxlength="1" class="mt-1 block w-full sm:w-1/4 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Bijv. A">
                @error('hike_letter') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>
            <button type="submit" class="w-full sm:w-auto inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-white text-base font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Voeg Hike Toe
            </button>
        </form>
        @endcan
        <!-- Lijst met hikes, met 2 knoppen per rij -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Hikes</h2>
            <ul class="space-y-4">
                @foreach($hikes as $hike)
                    
                    <li class="bg-gray-100 p-4 rounded-lg shadow flex justify-between items-center hover:bg-gray-200 transition">
                        <span class="font-medium">{{ $hike->hike_letter }}-Hike</span>
                        <div class="space-x-4">
                            @if($permissions[$hike->hike_letter]['view_points'])
                                <a href="{{ route('hike.points-overview', $hike->id) }}" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-white text-base font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Bekijk puntenoverzicht
                                </a>
                            @endif
                            <!-- Koppel Beheer Knop -->
                            @if($permissions[$hike->hike_letter]['manage_groups'])
                                <a href="/group-manager/{{ $hike->id }}" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-white text-base font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Koppel Beheer
                                </a>
                            @endif
                            <!-- Posten Beheer Knop -->
                            @if($permissions[$hike->hike_letter]['manage_posts'])
                                <a href="/post-manager/{{ $hike->id }}" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-white text-base font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Posten Beheer
                                </a>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
