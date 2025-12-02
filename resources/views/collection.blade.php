@php
    // dd($collection);
    usort($collection['parts'], function ($a, $b) {
        $key_name1 = $a['media_type'] === 'movie' ? 'release_date' : 'first_air_date';
        $key_name2 = $b['media_type'] === 'movie' ? 'release_date' : 'first_air_date';
        return strtotime($b[$key_name2]) <=> strtotime($a[$key_name1]);
    });
@endphp

@extends('layouts.app')

@section('title', $collection['name'])

@section('content')
    <h2 class="mt-12 text-center {{ config('tailwind.page_title') }} mb-8">{{$collection['name']}}</h2>

        <div class="{{ config('tailwind.container') }} mt-12">
            <div class="flex gap-8 mb-16">
                {{-- img --}}
                <div class="basis-1/2 rounded-md overflow-hidden">
                    <img src="{{$tmdb_base_path . $collection['backdrop_path']}}" alt="Image Backdrop Path" class="w-full h-full object-fit mb-4 hover:scale-125 transition poster" />
                </div>
                {{-- desc --}}
                <div class="basis-1/2 mb-8">{{$collection['overview']}}</div>
            </div>

            <div class="grid grid-cols-4 gap-4">
                <h3 class="col-span-full text-xl font-bold mb-4">Titles: {{ count($collection['parts']) }}</h3>
                @foreach ($collection['parts'] as $title)
                    @php
                        $type = $title['media_type'];
                    @endphp
                    <x-result-item :type="$type" :resultData="$title" />
                @endforeach
            </div>
        </div>
@endsection