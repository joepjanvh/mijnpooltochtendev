<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel Admin') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            <!-- Fonts -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
            <!-- Scripts -->
            @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.9.1/dist/cdn.min.js"></script>


    <!-- Voeg Leaflet JavaScript toe -->
    <!--<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-QVJ+ldh0AqBLxpMRyoZk3IAy0t4DoXUu8k3BBSJiEYk=" crossorigin=""></script>-->
    
            <!-- Styles --><!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <!-- Styles -->
  



    @vite(['resources/css/app.css'])

    @livewireStyles
</head>
<body class="bg-gray-100">
    <!-- Top Bar (alleen zichtbaar op mobiel) -->
    <div class="fixed inset-x-0 top-0 z-10 bg-white shadow-lg md:hidden">
        <div class="flex justify-between px-4 py-2">
            <div>
                <button class="font-semibold">Voor jou</button> <!-- Dropdown als je op "Voor jou" klikt -->
            </div>
           
<!--            <div>
                <i class="fas fa-bars"></i> 
            </div>-->

            <!-- start profile menu -->

            @if (Route::has('login'))
            
                @auth
                    <!-- authorised user menu -->
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                            {{ Auth::user()->name }}
                    
                                            <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            </x-slot>
                    
                            <x-slot name="content">
                                <x-dropdown-link href="{{ route('hike-dashboard') }}">
                                    {{ __('Hike Dashboard') }}
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('edition-manager') }}">
                                    {{ __('Edition Manager') }}
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('hike-manager', ['editionId' => 4]) }}">
                                    Editie 2024
                                </x-dropdown-link>
                                <div class="border-t border-gray-200 dark:border-gray-600"></div>
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                </div>
                    
                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                    
                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                        {{ __('API Tokens') }}
                                    </x-dropdown-link>
                                @endif
                                @can('view admin menu')    
                                <div class="border-t border-gray-200 dark:border-gray-600"></div>
                                    <x-dropdown-link href="{{ route('user.management') }}">
                                        {{ __('User Manager') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link href="{{ route('roles-permissions') }}">
                                        {{ __('Roles & Permissions') }}
                                    </x-dropdown-link>
                                @endcan
                                <div class="border-t border-gray-200 dark:border-gray-600"></div>
                    
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                    
                                    <x-dropdown-link href="{{ route('logout') }}"
                                             @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>

                @else

                
                    
                    @if (Route::has('register'))
                    
                    @endif
                @endauth
            </nav>
        @endif

            <!-- Settings Dropdown -->

</div>
            <!-- end profile menu-->


        </div>
    </div>
    

    <div class="flex">
        <!-- Sidebar (alleen zichtbaar op desktop, blijft vast) -->
        <div class="hidden md:flex md:w-1/4 lg:w-1/5 bg-white h-screen border-r sticky top-0 flex-col">
            <div class="p-4 flex flex-col h-full">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block h-16 mb-3 w-auto" />
                    </a>
                </div>
                
                <ul class="mt-4 flex-1">
                    <li class="mb-4">
                        <a href="{{ route('home') }}" class="flex items-center">
                            <i class="fas fa-home mr-2"></i> Startpagina
                        </a>
                    </li>
                    <li class="mb-4 mr-2">
                        <a href="#" class="flex items-center">
                            <livewire:button-tester  /> Zoeken
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="flex items-center">
                            <i class="fas fa-play mr-2"></i> Reels
                        </a>
                    </li>
                    <!-- Hikes met iconen -->
                    <li class="mb-4">
                        <a href="#" class="flex items-center">
                            <i class="fas fa-hiking mr-2"></i> Hikes</a>
                    </li>
                 <!--   <li class="mb-4">
                        <a href="#" class="flex items-center">
                            <i class="fas fa-compass mr-2"></i> B-Hike 
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="flex items-center">
                            <i class="fas fa-link mr-2"></i> C-Hike 
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="flex items-center">
                            <i class="fas fa-campground mr-2"></i> D-Hike 
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="flex items-center">
                            <i class="fas fa-fire  mr-2"></i> E-Hike 
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="flex items-center">
                            <i class="fas fa-mountain mr-2"></i> F-Hike
                        </a>
                    </li> -->

                    @auth
                    <!-- Als ingelogd, dashboard link -->
                    <li class="mb-4">
                        <a href="{{ url('/dashboard') }}" class="flex items-center">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                        </a>
                    </li>


                    

                    <li class="mb-4" x-data="{ open: false }">
                        <!-- Hoofdknop voor het profiel -->
                        <a href="javascript:void(0);" @click="open = !open" class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-user mr-2"></i> Profile
                            </div>
                            <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                        </a>
                
                        <!-- Submenu-items voor Profile (zichtbaar wanneer open == true) -->
                        <ul x-show="open" x-transition class="ml-4 mt-2 space-y-2">
                            <li>
                                <a href="{{ route('profile') }}" class="flex items-center">
                                    <i class="fas fa-user-circle mr-2"></i> Mijn profiel
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('profile.show') }}" class="flex items-center">
                                    <i class="fas fa-cog mr-2"></i> Instellingen
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('hike-dashboard') }}" class="flex items-center">
                                    <i class="fas fa-cog mr-2"></i> Hike Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('edition-manager') }}" class="flex items-center">
                                    <i class="fas fa-cog mr-2"></i> Editie Manager
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('hike-manager', ['editionId' => 4]) }}" class="flex items-center">
                                    <i class="fas fa-cog mr-2"></i> Editie 2024
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.management') }}" class="flex items-center">
                                    <i class="fas fa-cog mr-2"></i> User Manager
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('roles-permissions') }}" class="flex items-center">
                                    <i class="fas fa-cog mr-2"></i> Rollen en Rechten
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{ route('profile.show') }}" class="flex items-center">
                                    <i class="fas fa-shield-alt mr-2"></i> Privacy-instellingen
                                </a>
                            </li>
                            <li>
                                
                                <a href="{{ route('logout') }}" class="flex items-center">
                                    <i class="fas fa-cog mr-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                    @else
                    <!-- Als niet ingelogd, login en register links -->
                    <li class="mb-4">
                        <a href="{{ route('login') }}" class="flex items-center">
                            <i class="fas fa-sign-in-alt mr-2"></i> Log in
                        </a>
                    </li>
                    @if (Route::has('register'))
                    <li class="mb-4">
                        <a href="{{ route('register') }}" class="flex items-center">
                            <i class="fas fa-user-plus mr-2"></i> Register
                        </a>
                    </li>
                    @endif
                    @endauth
                </ul>

                <!-- Meer knop altijd onderaan -->
                <ul class="mt-auto">
                    <li>
                        <a href="#" class="flex items-center">
                            <i class="fas fa-ellipsis-h mr-2"></i> Meer
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <div class="w-full md:w-3/4 lg:w-4/5 mx-auto pt-6 md:p-4 space-y-6">
            <main>
                @yield('content') 
                <!-- Gebruik Blade's content section -->
                {{ $slot ?? '' }}  <!-- Alleen gebruiken als er een Livewire-component is -->
            </main>
        </div>
    </div>

    <!-- Bottom Bar (alleen zichtbaar op mobiel) -->
    <div class="fixed inset-x-0 bottom-0 z-10 bg-white md:hidden shadow-lg">
        <div class="flex justify-between px-10 py-2">
            <a href="{{ route('home') }}" class="flex items-center">
                <i class="fas fa-home"></i> <!-- Home icon -->
            </a>
            
            <livewire:button-tester  /><!-- Search icon -->
            <i class="fas fa-plus-square"></i> <!-- Add icon -->
            <a href="{{ route('hike-dashboard') }}" class="flex items-center">
                <i class="fas fa-hiking"></i> <!-- Hikes icon -->
            </a>
            
            @auth
            <a href="{{ route('profile') }}" class="flex items-center">
                <i class="fas fa-tachometer-alt"></i> <!-- Dashboard icon als ingelogd -->
            </a>
            <a href="{{ route('dashboard') }}" class="flex items-center">
               <!-- <i class="fas fa-tachometer-alt">-->
                <i class="fas">
                    dash
                </i> <!-- Dashboard icon als ingelogd -->
            </a>    
            @else
            <a href="{{ route('login') }}" class="flex items-center">
                <i class="fas fa-sign-in-alt"></i> <!-- Login icon als niet ingelogd -->
            </a>
            <a href="{{ route('register') }}" class="flex items-center">
                <i class="fas fa-user-plus"></i> <!-- Register icon als niet ingelogd -->
            </a>    
                
            @endauth
        </div>
    </div>
    @stack('modals')

    

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:init', function () {
            Livewire.on('show-popup', () => {
                Swal.fire({
                    title: 'Klik!',
                    text: 'Deze knop werkt, maar heeft nog geen functie',
                    icon: 'info',
                    confirmButtonText: 'Oké'
                });
            });
        });
    </script>
    
    
    @livewireScripts
    @vite('resources/js/app.js')
</body>
</html>
