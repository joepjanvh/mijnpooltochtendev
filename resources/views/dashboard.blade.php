@extends('layouts.app')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @section('content')
    <div class="py-12">
        <!--<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full md:w-3/4 lg:w-4/5 mx-auto space-y-6 max-w-md">-->
                <x-welcome />
       <!--     </div>
        </div>-->
    </div>
    @endsection



 
