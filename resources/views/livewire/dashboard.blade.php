<div class="container mx-auto pt-4" wire:poll.5000ms>
    <div class="bg-white md:rounded-lg shadow p-2 md:p-6">
        <!-- Titel van de pagina -->
        <h1 class="text-2xl font-semibold mb-6">Overzicht van de posten voor editie {{ $edition->year }}</h1>

        <!-- Tabel met hikes en posten -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 table-fixed">
                <thead class="bg-gray-100">
                    <tr class="flex">
                        @foreach($hikes as $hike)
                        <th class="py-2 px-4 text-left text-sm font-medium text-gray-900 flex-1">
                            <a href="/post-manager/{{ $hike->id }}" class="hover:underline text-blue-600">
                                {{ $hike->hike_letter }}-Hike
                            </a>

                            <!-- Bereken de vertraging voor deze specifieke hike -->
                            @if(isset($totalDelayPerHike[$hike->hike_letter]) && $totalDelayPerHike[$hike->hike_letter] > 0)
                            <div class="bg-red-500 text-white text-center p-2 rounded mb-4 w-32 mx-auto whitespace-nowrap overflow-hidden text-ellipsis">
                                    + {{ round($totalDelayPerHike[$hike->hike_letter], 2) }} min
                            </div>
                            @else
                                <div class="bg-green-500 text-white text-center p-2 rounded mb-4 w-32 mx-auto whitespace-nowrap overflow-hidden text-ellipsis">
                                    Op tijd
                                </div>
                            @endif
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Bepaal het maximum aantal posten voor alle hikes
                        $maxRows = max(array_map(fn($posts) => $posts->count(), $posts));
                    @endphp

                    @for($i = 0; $i < $maxRows; $i++)
                        <tr class="flex">
                            @foreach($hikes as $hike)
                                @php
                                    $post = $posts[$hike->id][$i] ?? null;
                                    $backgroundColor = 'bg-white'; // Standaardkleur

                                    if ($post) {
                                        // Bepaal de kleur op basis van de status
                                        if ($post->time_close) {
                                            $backgroundColor = 'bg-green-500 text-white'; // Post is gesloten
                                        } elseif ($post->time_open) {
                                            $backgroundColor = 'bg-orange-500 text-white'; // Post is geopend maar niet gesloten
                                        } elseif (\Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($post->planned_time))) {
                                            $backgroundColor = 'bg-red-500 text-white'; // Post had al geopend moeten zijn
                                        }
                                    }
                                @endphp
                                <td class="py-1 px-4 {{ $backgroundColor }} text-center border flex-1">
                                    <a href="/post/{{ $post->id ?? '' }}" class="text-black hover:underline">
                                        {{ $post->post_number ?? '' }}
                                    </a>
                                </td>
                            @endforeach
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>
