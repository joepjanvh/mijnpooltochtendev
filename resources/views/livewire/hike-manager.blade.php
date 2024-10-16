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
                    
                    <li class="bg-gray-100 p-4 rounded-lg shadow hover:bg-gray-200 transition flex flex-col">
                        <div class="flex flex-col md:flex-row justify-between items-center">
                            <span class="font-medium">{{ $hike->hike_letter }}-Hike</span>
                            <div class="md:space-x-4 space-y-2 md:space-y-0 text-center">
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
                        </div>

                        <!-- Vertraging beheer -->
                        <div class="pt-4">
                            <div class="flex flex-row items-center space-x-4">
                                <label for="delay-{{ $hike->hike_letter }}" class="block text-sm font-medium text-gray-900 dark:text-white">Vertraging</label>
                                <input id="delay-{{ $hike->hike_letter }}" 
                                    type="range" value="0" min="-180" max="180" step="5" class="w-full h-1 bg-gray-200 rounded-lg appearance-none cursor-pointer range-sm dark:bg-gray-700"
                                    wire:model.lazy="delays.{{ $hike->id }}"
                                    wire:change="saveDelay('{{ $hike->id }}', $event.target.value)"
                                    oninput="updateSliderValue('{{ $hike->hike_letter }}', this.value)">                             
                                <output 
                                    id="delay-output-{{ $hike->hike_letter }}" 
                                    for="delay-{{ $hike->hike_letter }}" 
                                    class="text-sm basis-20 text-right @if($delays[$hike->id] < 0) text-green-500 @elseif($delays[$hike->id] > 0) text-red-500 @endif">
                                    {{ $delays[$hike->id] }}
                                </output>                        
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<!-- Script voor update van de waarde achter vertraging slider -->
<script>
    function updateSliderValue(hikeLetter, value) {
        const el = document.getElementById('delay-output-' + hikeLetter);
        el.innerText = value;
        if (value < 0) {
            el.classList.add('text-green-500');
            el.classList.remove('text-red-500');
        } else if (value > 0) {
            el.classList.add('text-red-500');
            el.classList.remove('text-green-500');
        } else {
            el.classList.remove('text-red-500', 'text-green-500');
        }
    }
</script>