@php    
    // dd($visited_pages);
    // dd($visited_types);
@endphp

@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @include('partials.search_form')

    <div class="{{ config('tailwind.container') }} mt-12">
        <div class="grid grid-cols-4 gap-4 mt-[100px]">

            {{-- show movies popular now --}}
            <h2 class="col-span-full text-xl font-bold">Movies Popular Now:</h2>
            <div class="col-span-full">
                <div id="slider1" class="splide">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach ($popular_now_movies['results'] as $movRez)
                                <div class="splide__slide">
                                    <x-result-item type="movie" :resultData="$movRez" />
                                </div>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <hr class="col-span-full my-10" >

            {{-- show series popular now --}}
            <h2 class="col-span-full text-xl font-bold">Series Popular Now:</h2>
            <div class="col-span-full">
                <div id="slider2" class="splide">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach ($popular_now_series['results'] as $serRez)
                                <div class="splide__slide">
                                    <x-result-item type="series" :resultData="$serRez" />
                                </div>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <hr class="col-span-full my-10" >

            {{-- show recently visited pages --}}
            @if (!empty($visited_pages) && count($visited_pages) > 0)
                <h2 class="col-span-full text-xl font-bold">Recently Visited Pages:</h2>
                <div class="col-span-full">
                    <div id="slider3" class="splide">
                        <div class="splide__track">
                            <ul class="splide__list">
                                @foreach ($visited_pages as $ind => $item)
                                    @if ($visited_types[$ind] === 'movie')
                                        <div class="splide__slide">
                                            <x-result-item type="movie" :resultData="$item" />
                                        </div>
                                    @elseif ($visited_types[$ind] === 'series')
                                        <div class="splide__slide">
                                            <x-result-item type="series" :resultData="$item" />
                                        </div>
                                    @else
                                        <div class="splide__slide">
                                            <x-result-item type="personality" :resultData="$item" />
                                        </div>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif 
            {{-- visited_pages --}}

        </div>
    </div>

    <style>
        .splide__pagination {
            position: relative;
            bottom: -25px;   /* move slider dots lower */
            margin-top: 12px;
        }
    </style>

    {{-- frontend slider functionality --}}
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/js/splide.min.js"></script>
    <script>
    document.addEventListener( 'DOMContentLoaded', function () {
        // first slider
        new Splide( '#slider1', {
        type      : 'loop',
        perPage   : 4,          // desktop default
        perMove   : 1,
        gap       : '1rem',
        autoplay  : true,
        pauseOnHover: true,
        interval  : 3000,
        arrows: false,
        breakpoints: {
            1280: { perPage: 4 },
            1024: { perPage: 3 },
            768:  { perPage: 2 },
            480:  { perPage: 1 }
        }
        } ).mount();

        // second slider
        new Splide( '#slider2', {
        type      : 'loop',
        perPage   : 4,          // desktop default
        perMove   : 1,
        gap       : '1rem',
        autoplay  : true,
        pauseOnHover: true,
        interval  : 3000,
        arrows: false,
        breakpoints: {
            1280: { perPage: 4 },
            1024: { perPage: 3 },
            768:  { perPage: 2 },
            480:  { perPage: 1 }
        }
        } ).mount();

        // third slider
        new Splide( '#slider3', {
        type      : 'loop',
        perPage   : 4,          // desktop default
        perMove   : 1,
        gap       : '1rem',
        autoplay  : true,
        pauseOnHover: true,
        interval  : 3000,
        arrows: false,
        breakpoints: {
            1280: { perPage: 4 },
            1024: { perPage: 3 },
            768:  { perPage: 2 },
            480:  { perPage: 1 }
        }
        } ).mount();
    } );
    </script>
@endsection