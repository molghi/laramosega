@php    
    // dd();
@endphp

@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @include('partials.search_form')

    <div class="{{ config('tailwind.container') }} mt-12">
        <div class="grid grid-cols-4 gap-4 mt-[100px]">

            {{-- show movies popular now --}}
            <h2 class="col-span-full text-xl font-bold">Movies Popular Now:</h2>
            @foreach ($popular_now_movies['results'] as $movRez)
                <x-result-item type="movie" :resultData="$movRez" />
            @endforeach

            <hr class="col-span-full mt-14 mb-10" >

            {{-- show series popular now --}}
            <h2 class="col-span-full text-xl font-bold">Series Popular Now:</h2>
            @foreach ($popular_now_series['results'] as $serRez)
                <x-result-item type="series" :resultData="$serRez" />
            @endforeach
        </div>
    </div>
@endsection