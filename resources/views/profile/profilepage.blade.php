@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="py-6">
        <!-- Profiel informatie bovenaan -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <img src="https://via.placeholder.com/150" alt="Dummy Profile" class="w-24 h-24 rounded-full">
                <div class="ml-6">
                    <h2 class="text-3xl font-semibold">Dummy User</h2>
                    <p class="text-gray-600">@dummyuser</p>
                </div>
            </div>
            <div>
                <a href="#" class="text-sm px-4 py-2 bg-gray-200 rounded-md">Profiel bewerken</a>
            </div>
        </div>

        <!-- Statistieken -->
        <div class="flex justify-between items-center my-4">
            <div class="text-center">
                <h4 class="font-semibold">7</h4>
                <span>berichten</span>
            </div>
            <div class="text-center">
                <h4 class="font-semibold">288</h4>
                <span>volgers</span>
            </div>
            <div class="text-center">
                <h4 class="font-semibold">701</h4>
                <span>volgend</span>
            </div>
        </div>

        <!-- Grid met geposte afbeeldingen -->
        <div class="grid grid-cols-3 gap-4 mt-6">
            @foreach (range(1, 9) as $index)
                <div class="relative">
                    <img src="https://via.placeholder.com/400x400" alt="Post afbeelding {{ $index }}" class="w-full h-32 object-cover">
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
