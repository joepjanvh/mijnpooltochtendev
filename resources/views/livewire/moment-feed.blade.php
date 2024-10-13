<div class="w-full md:w-3/4 lg:w-4/5 mx-auto space-y-6 max-w-md">
   <!-- Popup voor nieuwe momenten -->
   <div id="newmomentspopup"
   class="fixed top-0 left-0 w-full h-14 bg-green-500 text-white p-4 z-50 cursor-pointer hidden">
   <p>Er zijn nieuwe momenten! Klik hier om te laden.</p>
   <span class="close-btn" style="position: absolute; top: 10px; right: 10px; cursor: pointer;">&times;</span>
</div>
    <div>
        @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
        <!-- Controleer of er momenten zijn -->
       
            <div class="bg-green-700 text-black p-4 rounded-md text-center font-bold	">
                <p>Er zijn nog geen momenten geüpload voor deze editie.</p>
            </div>
        
            @foreach ($moments as $moment)
                <!-- Markeer nieuwe momenten die later zijn dan last_feed_check -->
                <div id="moment-{{ $moment->id }}"
                    class="moment bg-white md:border md:rounded-lg md:p-4 {{ $moment->is_new ? 'new-moment' : '' }}">

                    <!-- Moment Header -->
                    <!-- Moment Header -->
                    <div class="flex items-center pt-10 md:pt-0 justify-between">
                        <div class="flex pl-4 md:pl-0 items-center">
                            <a href="{{ route('profile', ['user' => $moment->user->id]) }}">
                                <img src="{{ $moment->user->profile_photo_url ?? 'https://via.placeholder.com/150' }}"
                                    alt="{{ $moment->user->name }}"
                                    class="w-12 h-12 rounded-full object-cover  drop-shadow-md profile-photo {{ $moment->is_new ? 'new-profile-moment' : '' }}">
                            </a>
                            <div class="ml-4">
                                <div class="font-semibold">
                                    <a
                                        href="{{ route('profile', ['user' => $moment->user->id]) }}">{{ $moment->user->name }}</a>
                                </div>
                                <div class="text-sm text-gray-500">{{ $moment->created_at->diffForHumans() }} •
                                    {{ $moment->location }}
                                </div>

                               <!-- <div class="text-sm text-gray-500">Photo Taken:{{ $moment->photo_taken_at }} </div>-->
                                
                               <!-- <div class="text-sm text-gray-500">created:{{ $moment->created_at }}</div>-->
                                
                                
                                
                            </div>
                        </div>
                        @if ($moment->coordinates)
                            <!-- Controleer de bron van de coördinaten -->
                            @if ($moment->coordinates_source === 'EXIF')
                                <!-- Gebruik coördinaten uit EXIF-gegevens -->
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $moment->coordinates }}"
                                    target="_blank" class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-map-marker-alt"></i> <!-- EXIF Map Marker -->
                                </a>
                            @elseif ($moment->coordinates_source === 'user')
                                <!-- Gebruik coördinaten uit gebruikerslocatie -->
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $moment->coordinates }}"
                                    target="_blank" class="text-green-500 hover:text-green-700">
                                    <i class="fas fa-thumb-tack"></i> <!-- User Location Thumb Tack -->
                                </a>
                            @endif
                        @elseif ($moment->location)
                            <!-- Gebruik locatie als coördinaten niet beschikbaar zijn -->
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($moment->location) }}"
                                target="_blank" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-globe"></i> <!-- Location without coordinates -->
                            </a>
                        @endif
                        <!-- Drie puntjes (alleen zichtbaar voor de gebruiker die de post heeft geplaatst) -->
                        @if ($moment->user_id === Auth::id())
                            <div class="relative">
                                <i class="fas pr-2 md:pr-0 fa-ellipsis-h cursor-pointer"
                                    wire:click="toggleMenu({{ $moment->id }})"></i>

                                <!-- Opties menu, alleen tonen als showMenu true is voor dit moment -->
                                @if (isset($showMenu[$moment->id]) && $showMenu[$moment->id])
                                    <div class="absolute right-0 border mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                                        <ul>
                                      
                                            <li>
                                                <a href="#" onclick="openEditModal({{ $moment->id }}, '{{ addslashes($moment->caption) }}', '{{ addslashes($moment->location) }}')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Moment bewerken</a>


                                                
                                            </li>
                                                
                                            </li>
                                            <li>
                                                <a href="#" onclick="confirmDeleteOrHide({{ $moment->id }})"
                                                    class="block px-4 py-2 text-sm text-red-500 text-gray-700 hover:bg-gray-100">
                                                    Moment verwijderen
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                    

                    <!-- Moment Image/Video -->
    <div class="my-4 relative bg-black flex justify-center items-center">
        @php
            $extension = pathinfo($moment->file_path, PATHINFO_EXTENSION);
        @endphp

        @if (in_array(strtolower($extension), ['mp4', 'avi', 'mkv']))
            <!-- Video weergave -->
            <div class="media-container">
            <video wire:lazy
            controls 
            playsinline 
            autoplay 
            muted 
            loop
            class="responsive-video">
                <source src="{{ asset('storage/' . $moment->file_path) }}" type="video/{{ strtolower($extension) }}">
                   
                Your browser does not support the video tag.
            </video>
        </div>
        @else
            <!-- Afbeelding weergave -->
            <img src="{{ asset('storage/' . $moment->thumbnail_path) }}" alt="Moment Image"
                class="max-w-full max-h-full object-contain rounded-lg">
        @endif
    </div>


                    <!-- moment swiper -->


                    <!-- Moment Actions -->
                    <div class="flex pl-2 md:pl-0 justify-between items-center mt-4">
                        <div class="flex items-center space-x-4 text-sm">
                            @php
                                $likedUsers = $moment->getLikedByUsers();
                                $likesCount = $moment->likesCount();

                                $commentsCount = $moment->comments->count();
                            @endphp
                            @auth
                                <button wire:click="toggleLike({{ $moment->id }})">
                                    @if ($moment->isLikedBy(auth()->user()))
                                        <i class="fas fa-heart text-red-500"></i> <strong
                                            class="ml-3">{{ $likesCount }}</strong><!-- Liked -->
                                    @else
                                        <i class="far fa-heart hover:text-gray-500"></i><strong
                                            class="ml-3">{{ $likesCount }}</strong> <!-- Not Liked -->
                                    @endif
                                </button>
                                <i class="far fa-comment hover:text-gray-500"></i>
                                <strong>{{ $commentsCount }}</strong><!-- Comment Icon -->
                            @endauth
                        </div>
                        @if($moment->hike)
                        <button class="block border rounded center px-1 py-1 text-sm text-gray-500  hover:bg-gray-100 hover:text-red-500">{{ $moment->hike->hike_letter }}-Hike</button>
                               
                        @endif
                    </div>

                    <!-- Likes and Comments -->
                    <div class="mt-2 pl-2 md:pl-0 ">




                        @if ($likesCount > 0)
                            <p class="font-semibold text-sm">
                                Liked by {{ implode(', ', $likedUsers) }}
                                @if ($likesCount > count($likedUsers))
                                    and {{ $likesCount - count($likedUsers) }} others
                                @endif
                            </p>
                        @endif
                        <!-- afkappen tekst na 120 tekens -->
                        @php
                            $maxLength = 120;
                            $caption = $moment->caption;
                            $captionLength = strlen($caption);
                            $truncatedCaption =
                                $captionLength > $maxLength
                                    ? substr($caption, 0, strrpos(substr($caption, 0, $maxLength), ' ')) . '... '
                                    : $caption;
                        @endphp
                        <p class="text-sm text-black">
                            <strong>{{ $moment->user->name }}</strong>

                            @if ($captionLength > $maxLength)
                                @if (isset($showFullCaption[$moment->id]) && $showFullCaption[$moment->id])
                                    <!-- Toon volledige caption -->
                                    <span>{{ $caption }}</span>
                                    <a href="javascript:void(0)"
                                        wire:click="$set('showFullCaption.{{ $moment->id }}', false)"
                                        class="text-sm text-gray-500">Minder</a>
                                @else
                                    <!-- Toon ingekorte caption -->
                                    <span>{{ $truncatedCaption }}</span>
                                    <a href="javascript:void(0)"
                                        wire:click="$set('showFullCaption.{{ $moment->id }}', true)"
                                        class="text-sm text-gray-500">Meer</a>
                                @endif
                            @else
                                <!-- Toon volledige caption als het korter is dan $maxLength -->
                                <span>{{ $caption }}</span>
                            @endif
                        </p>



                        @if ($commentsCount === 0)
                            <p class="text-sm text-gray-500">Geen comments geplaatst</p>
                        @elseif($commentsCount === 1)
                            <p class="text-sm mb-1 text-gray-500">
                                <a href="#" wire:click.prevent="toggleComments({{ $moment->id }})">1 comment
                                    bekijken</a>
                            </p>
                        @else
                            <p class="text-sm mb-1 text-gray-500">
                                <a href="#" wire:click.prevent="toggleComments({{ $moment->id }})">Alle
                                    {{ $commentsCount }} comments bekijken</a>
                            </p>
                        @endif

                        @if (isset($showComments[$moment->id]) && $showComments[$moment->id])
                            @foreach ($moment->comments as $comment)
                                <div class="text-sm mb-1 text-black"><strong>{{ $comment->user->name }}
                                    </strong>{{ $comment->created_at->diffForHumans() }}
                                    <!--{{ $comment->location }}-->
                                </div>
                                <p class="text-sm mb-1 text-black"> {{ $comment->body }}</p>
                            @endforeach
                        @endif




                        <!-- comment form -->
                        @can('post comments')
                            <div class="mt-4">
                                <form wire:submit.prevent="addComment({{ $moment->id }})">
                                    <div class="flex flex-row">
                                        <input type="text" wire:model.defer="activeComment.{{ $moment->id }}"
                                            wire:focus="setActiveComment({{ $moment->id }})"
                                            class="w-full p-2 border-t-0 border-l-0 border-r-0 border-gray-300 focus:outline-none focus:ring-0 focus:bg-slate-100"
                                            style="font-size: 16px;" placeholder="Voeg een comment toe...">

                                        <button type="submit"
                                            class="ml-2 bg-blue-500 mr-1 ml-1 text-white w-14 p-2 rounded-full">
                                            <i class="fas fa-arrow-up"></i>
                                        </button>
                                    </div>
                                    <!-- Emoji knop -->
                                    <div class="relative">
                                        <!--    <button type="button" class="ml-2 text-blue-500 hover:text-blue-700 focus:outline-none" id="emojiButton">
                        <i class="fas fa-smile"></i>
                    </button>-->

                                        <!-- Emoji menu (toggle visibility met JavaScript/Alpine.js) -->
                                        <!--       <div id="emojiMenu" class="absolute z-10 mt-2 bg-white shadow-lg rounded-lg p-2 hidden">
                        <div class="flex flex-wrap space-x-2">
                            <span wire:click="addEmoji('😀')" class="cursor-pointer">😀</span>
                            <span wire:click="addEmoji('😂')" class="cursor-pointer">😂</span>
                            <span wire:click="addEmoji('😍')" class="cursor-pointer">😍</span>
                            <span wire:click="addEmoji('😎')" class="cursor-pointer">😎</span>
                            <span wire:click="addEmoji('🥳')" class="cursor-pointer">🥳</span>
                            <!-- Voeg meer emojis toe hier -->
                                        <!--     </div>
                    </div>
                -->

                                        <!-- Post-knop: Alleen tonen als er tekst of emoji in het invoerveld staat -->


                                    </div>


                                    @error('newComment')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </form>
                            </div>
                        @endcan





                    </div>

                </div>
            @endforeach
           
            
    </div>
<!-- Laad hier de EditMoment Livewire-component -->

    <!-- "Load More" Trigger Element -->
    <!-- "Load More" Trigger Element -->
    <div id="load-more-trigger" class="py-4"></div>

    <!-- Javascript voor de popup balk -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let options = {
                root: null,
                rootMargin: '0px',
                threshold: 0.40
            };

            let observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        Livewire.dispatch('loadMore');
                    }
                });
            }, options);

            let trigger = document.getElementById('load-more-trigger');
            observer.observe(trigger);
        });
    </script>


   <script>
    document.addEventListener('livewire:init', function () {
    Livewire.on('closeSubMenu', (payload) => {
        const momentId = payload.momentId;
        const menu = document.querySelector(`#moment-${momentId} .submenu-class`);
        if (menu) {
            menu.classList.add('hidden'); // Zorg ervoor dat het menu verborgen wordt
        }
    });
});

   </script>

    <style>
        .new-moment {
            border-left: 3px solid darkgreen;
            /* Groene rand */

            /* Zorg voor ruimte tussen de afbeelding en de rand */
        }

        .new-profile-moment {
            border-image: 3px solid darkgreen;

            /* Groene rand */

            /* Zorg voor ruimte tussen de afbeelding en de rand */
        }
    </style>
    <!-- At the end of your moment-feed.blade.php -->

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:init', function() {
            Livewire.on('show-popup', () => {
                Swal.fire({
                    title: 'Post verwijderd!',
                    text: 'Het is gelukt, je post is verwijderd.',
                    icon: 'success',
                    confirmButtonText: 'Oké'
                });
            });
        });
    </script>

<!-- sweetalert voor edit moments-->
<script>
  function openEditModal(momentId, caption, location) {
        Swal.fire({
            title: 'Moment bewerken',
            html: `
                <p>Caption: <input id="swal-input1" class="w-2/3 text-sm swal2-input" value="${caption}" placeholder="Caption"></p>
                <p>Location: <input id="swal-input2" class="w-2/3 text-sm swal2-input" value="${location}" placeholder="Location"></p>
            `,
            focusConfirm: false,
            showCancelButton: true,
            
            preConfirm: () => {
                return {
                    
                    caption: document.getElementById('swal-input1').value,
                    location: document.getElementById('swal-input2').value,

                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(momentId);
                Livewire.dispatch('updateMoment', {
                id: momentId, 
                caption: result.value.caption,
                location: result.value.location
                });
                //console.log(result.value.caption, result.value.location, momentId);
            }
        });
    };


</script>



<script>
     function confirmDeleteOrHide(momentId) {
    Swal.fire({
  title: "Wil je je post verwijderen?",
  showDenyButton: true,
  showCancelButton: true,
  confirmButtonText: "Verwijderen",
  denyButtonText: `Verbergen`
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
    console.log(momentId);
    Livewire.dispatch('deleteMoment', {momentId} );
    Swal.fire("Verwijderd!", "", "success");
  } else if (result.isDenied) {
    console.log(momentId);
    Livewire.dispatch('toggleVisibility', {momentId} );
    Swal.fire("Verborgen", "", "info");
  }
});
     }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let lazyVideos = [].slice.call(document.querySelectorAll('video.lazy-video'));

        if ('IntersectionObserver' in window) {
            let lazyVideoObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(video) {
                    if (video.isIntersecting) {
                        for (let source in video.target.children) {
                            let videoSource = video.target.children[source];
                            if (typeof videoSource.tagName === 'string' && videoSource.tagName === 'SOURCE') {
                                videoSource.src = videoSource.dataset.src;
                            }
                        }

                        video.target.load();
                        video.target.classList.remove('lazy-video');
                        lazyVideoObserver.unobserve(video.target);
                    }
                });
            });

            lazyVideos.forEach(function(lazyVideo) {
                lazyVideoObserver.observe(lazyVideo);
            });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const videos = document.querySelectorAll('video');

        // Create an IntersectionObserver
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.intersectionRatio > 0.75) {
                    entry.target.play();  // Play when 75% or more of the video is in view
                } else {
                    entry.target.pause(); // Pause when less than 75% is visible
                }
            });
        }, { threshold: [0.75] }); // The video will only play if 75% or more is visible

        // Observe each video
        videos.forEach(video => {
            observer.observe(video);
        });
    });
</script>
<style>
   .media-container {
    width: 100%; /* Vul de breedte van het scherm */
    max-width: 1080px; /* Maximaal 1080px breed */
    aspect-ratio: 1080 / 1350; /* Houd dezelfde verhouding als de afbeeldingen */
    position: relative;
    background-color: black; /* Zwarte achtergrond voor de balken */
}

.responsive-video {
    width: 100%; /* Vul de breedte van de container */
    height: 100%; /* Vul de hoogte van de container */
    object-fit: contain; /* Zorg dat de video niet vervormt */
}

</style>
</div>
