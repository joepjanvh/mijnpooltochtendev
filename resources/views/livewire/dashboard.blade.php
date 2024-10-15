<div class="container mx-auto pt-4">
    <div class="bg-white md:rounded-lg shadow p-2 md:p-6">
        <!-- Titel van de pagina -->
        <h1 class="text-2xl font-semibold mb-6">Overzicht van de posten voor editie {{ $edition->year }}</h1>

        <!-- Tabel met hikes en posten -->
        <div class="overflow-x-auto">

            <div class="flex justify-end">
                <a href="?autorefresh={{ request()->query('autorefresh') == 'true' ? 'false' : 'true'}}" class="text-black px-4 py-2 mb-2 rounded-md md:inline-block hidden">
                    <span>
                        <i class="{{ request()->query('autorefresh') == 'true' ? 'fa-regular fa-square-check' : 'fa-regular fa-square'}}"></i> Automatisch updaten
                    </span>
                </a>   
            </div> 

            <div class="flex flex-col md:flex-row flex-nowrap" 
                @if(request()->query('autorefresh') == 'true') 
                wire:poll.5000ms 
                @endif>        
    
                @foreach($hikes as $hike)
                <div class="grow flex flex-col border border-gray-250 bg-gray-100" data-accordion="open">
                    <div id="accordion-collapse-heading-{{ $hike->hike_letter }}-hike">
                        <button type="button" class="flex items-center flex-row md:flex-col w-full py-4 md:py-2 px-2"  data-accordion-target="#accordion-collapse-body-{{ $hike->hike_letter }}-hike" aria-expanded="false" aria-controls="accordion-collapse-body-{{ $hike->hike_letter }}-hike">
                            <div class="flex-1 text-left">
                                <svg data-accordion-icon class="w-6 h-6 shrink-0 rotate-180 md:hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06 0L10 10.94l3.71-3.73a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 010-1.06z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h3 class="text-1xl font-extrabold px-2 flex-1 text-center">
                                <span class="inline-block md:hidden">{{ $hike->hike_letter }}-Hike</span>
                                <a href="/post-manager/{{ $hike->id }}" class="hover:underline text-black hidden md:inline-block">
                                    {{ $hike->hike_letter }}-Hike
                                </a>
                            </h3>
                            <div class="flex-1 text-right">
                            @if(isset($totalDelayPerHike[$hike->hike_letter]) && $totalDelayPerHike[$hike->hike_letter] > 0)
                                <span class="inline-flex text-sm font-medium px-2.5 py-0.5  h-6 rounded-full bg-red-500 text-white">+ {{ round($totalDelayPerHike[$hike->hike_letter], 2) }}</span>                        
                            @else
                                <span class="inline-flex items-center justify-center w-6 h-6 text-sm font-semibold text-white bg-green-500 rounded-full dark:bg-gray-700 dark:text-gray-300">
                                <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                                </svg>
                                <span class="sr-only">Op tijd</span>
                                </span>
                            @endif
                            </div>                            
                        </button>
                    </div>
                    


                    <div class="hidden md:block flex flex-col items-stretch w-full" id="accordion-collapse-body-{{ $hike->hike_letter }}-hike"  aria-labelledby="accordion-collapse-heading-{{ $hike->hike_letter }}-hike">
                        @php
                            // Bepaal het maximum aantal posten voor alle hikes
                            $maxRows = max(array_map(fn($posts) => $posts->count(), $posts));
                        @endphp

                        @for($i = 0; $i < $maxRows; $i++)
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
                                    @endphp
                                    <div class="{{ $backgroundColor }} text-center border-b first:border-t last:border-0 py-4 md:py-1">
                                        <a href="/post/{{ $post->id ?? '' }}" class="text-black hover:underline">
                                            {{ $post->post_number ?? '' }}
                                        </a>
                                    </div>     
                                    @php                               
                                } else {
                                    @endphp
                                    <div class="{{ $backgroundColor }} text-center border-b first:border-t last:border-0 py-4 md:py-1 hidden md:block">
                                        &nbsp;
                                    </div>     
                                    @php                                     
                                }
                            @endphp
                        @endfor
                        <div class="bg-blue-500 text-white inline-block md:hidden text-center">
                            <a href="/post-manager/{{ $hike->id }}" class="inline-block text-white py-4">
                                {{ $hike->hike_letter }}-Hike postenbeheer
                            </a>
                        </div>
                    </div>                    
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
