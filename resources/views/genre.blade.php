@php    
    $item_type = $type === 'movie' ? 'Movies' : 'Series';
@endphp

@extends('layouts.app')

@section('title', "$genre $item_type")

@section('content')
    <h2 class="mt-12 text-center {{ config('tailwind.page_title') }} mb-8">{{ $genre . ' ' . $item_type }}</h2>

    <div class="{{ config('tailwind.container') }}">
        <div class="grid grid-cols-4 gap-4 mt-[60px]">

            <h3 class="col-span-full text-xl font-bold mb-4">Titles: {{ $data['total_results'] }}</h3>

            @if ($type === 'movie')
                @foreach ($data['results'] as $movRez)
                    <x-result-item type="movie" :resultData="$movRez" />
                @endforeach 
            @else 
                @foreach ($data['results'] as $serRez)
                    <x-result-item type="series" :resultData="$serRez" />
                @endforeach 
            @endif

            {{-- enable pagination --}}
            <div class="mt-[50px]">
                {{ $results->links() }}
            </div>
        </div>
    </div>

    <style>
        nav[role="navigation"] div:nth-child(2) > div:first-child { display: none; }
    </style>

@endsection