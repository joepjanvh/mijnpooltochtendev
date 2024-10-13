@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-semibold mb-6">Admin Dashboard</h1>

        <ul class="space-y-4">

            <li>
                <a href="{{ route('hike-dashboard') }}" class="block bg-blue-500 text-white text-center font-medium py-3 rounded-md hover:bg-blue-600">
                    Dashboard Overzicht
                </a>
            </li>
            <li>
                <a href="{{ route('edition-manager') }}" class="block bg-green-500 text-white text-center font-medium py-3 rounded-md hover:bg-green-600">
                    Beheer Editions
                </a>
            </li>
            <!-- Andere links zonder parameters kunnen hier worden toegevoegd -->
        </ul>
    </div>
</div>
@endsection
