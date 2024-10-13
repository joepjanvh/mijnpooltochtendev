<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Groepen aan-/afmelden bij Post {{ $post_id }}</h1>

    <!-- Groepenlijst -->
    <ul class="space-y-4">
        @foreach($groups as $group)
            @php
                // Ophalen van check-in data voor deze post
                $checkIn = DB::table('group_post')->where('group_id', $group->id)->where('post_id', $post_id)->first();

                // Ophalen van de laatste post waar deze groep is vertrokken
                $lastCheckOut = DB::table('group_post')
                    ->where('group_id', $group->id)
                    ->whereNotNull('departure_time')
                    ->orderBy('departure_time', 'desc')
                    ->first();

                // Achtergrondkleur bepalen
                $backgroundColor = 'bg-white'; // Standaardkleur
                if ($lastCheckOut && $lastCheckOut->post_id == $post_id) {
                    $backgroundColor = 'bg-gray-300'; // Grijs als ze hier al zijn afgemeld
                } elseif ($lastCheckOut && $lastCheckOut->post_id == ($post_id - 1)) {
                    $backgroundColor = 'bg-blue-300'; // Blauw als ze bij de vorige post zijn vertrokken
                }
            @endphp
            <li class="p-4 rounded-lg shadow {{ $backgroundColor }}">
                <div class="flex justify-between items-center">
                    <!-- Groepsinformatie -->
                    <div>
                        <h3 class="text-lg font-semibold">
                            Koppel: {{ $group->group_number }} - {{ $group->group_name }}
                        </h3>
                        
                        <!-- Laatste post en vertrektijd weergeven -->
                        @if($lastCheckOut)
                            <p class="text-sm text-gray-700">
                                Vertrokken van post {{ $lastCheckOut->post_id }} om {{ $lastCheckOut->departure_time }}
                            </p>
                        @else
                            <p class="text-sm text-gray-500">Nog niet vertrokken van een post</p>
                        @endif

                        <!-- Check-in/check-out informatie -->
                        @if(!$checkIn || !$checkIn->arrival_time)
                            <p class="text-gray-500">Nog niet aangemeld</p>
                        @elseif(!$checkIn->departure_time)
                            <p class="text-green-600">Aangemeld om: {{ $checkIn->arrival_time }}</p>
                        @else
                            <p class="text-gray-600">Vertrokken om: {{ $checkIn->departure_time }}</p>
                        @endif
                    </div>

                    <!-- Actieknoppen -->
                    <div>
                        @if(!$checkIn || !$checkIn->arrival_time)
                            <!-- Aanmelden knop -->
                            <button wire:click="checkIn({{ $group->id }})" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-white text-base font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Aanmelden
                            </button>
                        @elseif(!$checkIn->departure_time)
                            <!-- Afmelden knop -->
                            <button wire:click="checkOut({{ $group->id }})" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-white text-base font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Afmelden
                            </button>
                        @endif
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
