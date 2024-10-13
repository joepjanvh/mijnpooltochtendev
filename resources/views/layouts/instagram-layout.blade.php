<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MijnPooltochten.nl</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
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
            <div>
                <i class="fas fa-bars"></i> <!-- Menu icon -->
            </div>
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
                        <a href="{{ url('/') }}" class="flex items-center">
                            <i class="fas fa-home mr-2"></i> Startpagina
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="flex items-center">
                            <i class="fas fa-search mr-2"></i> Zoeken
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
                            <i class="fas fa-fire mr-2"></i> A-Hike <!-- Kampvuur -->
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="flex items-center">
                            <i class="fas fa-compass mr-2"></i> B-Hike <!-- Kompas -->
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="flex items-center">
                            <i class="fas fa-link mr-2"></i> C-Hike <!-- Knoop (Gebruik bijvoorbeeld "fa-rope" of soortgelijk) -->
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="flex items-center">
                            <i class="fas fa-campground mr-2"></i> D-Hike <!-- Bivak -->
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="flex items-center">
                            <i class="fas fa-hiking mr-2"></i> E-Hike <!-- Hiking -->
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="flex items-center">
                            <i class="fas fa-mountain mr-2"></i> F-Hike <!-- Bergbeklimmen -->
                        </a>
                    </li>

                    @auth
                    <!-- Als ingelogd, dashboard link -->
                    <li class="mb-4">
                        <a href="{{ url('/dashboard') }}" class="flex items-center">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                        </a>
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
        <div class="w-full md:w-3/4 lg:w-4/5 mx-auto p-4 space-y-6">
            <main>
                @yield('content') <!-- Gebruik Blade's content section -->
                {{ $slot ?? '' }}  <!-- Alleen gebruiken als er een Livewire-component is -->
            </main>
        </div>
    </div>

    <!-- Bottom Bar (alleen zichtbaar op mobiel) -->
    <div class="fixed inset-x-0 bottom-0 z-10 bg-white md:hidden shadow-lg">
        <div class="flex justify-between px-10 py-2">
            <i class="fas fa-home"></i> <!-- Home icon -->
            <i class="fas fa-search"></i> <!-- Search icon -->
            <i class="fas fa-plus-square"></i> <!-- Add icon -->
            <i class="fas fa-hiking"></i> <!-- Hikes icon -->
            @auth
                <i class="fas fa-tachometer-alt"></i> <!-- Dashboard icon als ingelogd -->
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

    @livewireScripts
    @vite('resources/js/app.js')
</body>
</html>
