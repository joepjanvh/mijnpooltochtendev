<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Styles -->
    @vite(['resources/css/app.css'])
    @livewireStyles
</head>
<body class="bg-gray-100">

    <!-- Top Bar (mobiel) -->
    <div class="fixed inset-x-0 top-0 z-10 bg-white shadow-lg md:hidden">
        <div class="flex justify-between px-4 py-2">
            <div class="text-xl font-semibold">MijnPooltochten</div>
            <div>
                <i class="fas fa-bars"></i> <!-- Menu icon -->
            </div>
        </div>
    </div>

    <!-- Sidebar (desktop) -->
    <div class="hidden md:flex md:w-1/4 lg:w-1/5 bg-white h-screen border-r sticky top-0 flex-col">
        <div class="p-4 flex flex-col h-full">
            <div class="shrink-0 flex items-center">
                <x-application-mark class="block h-12 w-auto" />
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
                <li class="mb-4">
                    <a href="#" class="flex items-center">
                        <i class="fas fa-envelope mr-2"></i> Berichten
                    </a>
                </li>
                <li class="mb-4">
                    <a href="#" class="flex items-center">
                        <i class="fas fa-bell mr-2"></i> Meldingen
                    </a>
                </li>
                <li class="mb-4">
                    <a href="#" class="flex items-center">
                        <i class="fas fa-plus mr-2"></i> Maken
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ url('/profile') }}" class="flex items-center">
                        <i class="fas fa-user mr-2"></i> Profiel
                    </a>
                </li>
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

    <!-- Main Content -->
    <div class="w-full md:w-3/4 lg:w-4/5 mx-auto p-4">
        @yield('content')
        {{ $slot ?? '' }}  <!-- Alleen gebruiken als er een Livewire-component is -->
    </div>

    <!-- Bottom Bar (mobiel) -->
    <div class="fixed inset-x-0 bottom-0 z-10 bg-white md:hidden shadow-lg">
        <div class="flex justify-between px-10 py-2">
            <i class="fas fa-home"></i> <!-- Home icon -->
            <i class="fas fa-search"></i> <!-- Search icon -->
            <i class="fas fa-plus-square"></i> <!-- Add icon -->
            <i class="fas fa-user"></i> <!-- Profile icon -->
        </div>
    </div>

    @livewireScripts
    @vite('resources/js/app.js')
</body>
</html>
