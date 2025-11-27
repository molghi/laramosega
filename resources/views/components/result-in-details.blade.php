<div class="{{ config('tailwind.container') }} mt-12">

    <div class="grid grid-cols-[30%_70%] gap-6">
        {{-- col 1 --}}
        <div class="flex flex-col gap-6">
            {{-- poster --}}
            <div class="bg-gray-800 p-4 rounded">
                <img src="{{ $tmdb_base_path . $resultData['poster_path'] }}" alt="Poster">
            </div>

            {{-- tagline --}}
            @if ($resultData['tagline'])
                <div title="Slogan" class="bg-gray-800 p-4 rounded text-sm italic">{{ $resultData['tagline'] }}</div>
            @endif
        </div>

        {{-- col 2 --}}
        <div class="bg-gray-900 p-4 rounded flex flex-col gap-3 relative">
            {{-- backdrop --}}
            <div class="absolute top-[0] left-[0] w-full h-full h-64">
                <img src="{{ $tmdb_base_path . $resultData['backdrop_path'] }}"
                    class="w-full h-full object-cover opacity-5">
            </div>

            {{-- name --}}
            <div class="text-2xl font-bold mb-4">
                {{ $type === 'series' ? $resultData['name'] : $resultData['title'] }}
            </div>

            {{-- release date --}}
            <div class="flex justify-between gap-x-4 gap-y-2 flex-wrap">
                @if ($type === 'series')
                    <div>
                        <span class="font-bold opacity-50">First Aired: </span> {{ substr($resultData['first_air_date'], 0, 4) }}
                        <span class="opacity-50 italic">(Years ago: {{ (int) date('Y') - (int) substr($resultData['first_air_date'], 0, 4) }})</span>
                    </div>
                    @if ($resultData['last_air_date'])
                        <div>
                            <span class="font-bold opacity-50">Last Aired: </span> {{ substr($resultData['last_air_date'], 0, 4) }}
                            <span class="opacity-50 italic">({{ $resultData['status'] }})</span>
                        </div>
                    @endif
                @else
                    <div>
                        <span class="font-bold opacity-50">Release Date: </span> {{ substr($resultData['release_date'], 0, 4) }}
                        <span class="opacity-50 italic">(Years ago: {{ (int) date('Y') - (int) substr($resultData['release_date'], 0, 4) }})</span>
                    </div>
                @endif
            </div>

            {{-- country, language --}}
            <div class="flex gap-10">
                <div>
                    <span class="font-bold opacity-50">Origin Country: </span> {{ implode(', ', $resultData['origin_country']) }}
                </div>
                <div>
                    <span class="font-bold opacity-50">Original Language: </span> {{ strtoupper($resultData['original_language']) }}
                </div>
            </div>

            {{-- genres --}}
            @if ($resultData['genres'])
                <div>
                    <span class="font-bold opacity-50">Genres: </span> 
                    @php
                        $genres = [];
                        foreach ($resultData['genres'] as $genre) {
                            array_push($genres, $genre['name']);
                        }
                    @endphp
                    {{ implode(', ', $genres) }}
                </div>
            @endif

             {{-- overview --}}
            <div>
                <span class="font-bold opacity-50">About: </span> {{ $resultData['overview'] }}
            </div>

            {{-- seasons, episodes --}}
            @if ($type === 'series')
                <div class="flex gap-10">
                    <div>
                        <span class="font-bold opacity-50">Seasons: </span> {{ $resultData['number_of_seasons'] }}
                    </div>
                    <div>
                        <span class="font-bold opacity-50">Episodes: </span> {{ $resultData['number_of_episodes'] }}
                    </div>
                </div>
            @endif

            {{-- runtime --}}
            @if ($type === 'movie')
            <div>
                <span class="font-bold opacity-50">Runtime: </span> {{ $resultData['runtime'] }} minutes
            </div>
            @endif

        </div>
    </div>
    
</div>



{{-- 

array:32 [▼ // resources/views/components/result-in-details.blade.php
  "adult" => false
  "backdrop_path" => "/yUOFocKDW7MCC5isx4FK8A68QFp.jpg"
  "created_by" => array:3 [▶]
  "episode_run_time" => []
  "homepage" => "http://abc.go.com/shows/lost"
  "id" => 4607
  "in_production" => false
  "last_episode_to_air" => array:13 [▶]
  "next_episode_to_air" => null
  "networks" => array:1 [▶]
  "popularity" => 62.1605
  "seasons" => array:7 [▶]
]


array:26 [▼ // resources/views/components/result-in-details.blade.php
  "adult" => false
  "belongs_to_collection" => array:4 [▶]
  "homepage" => ""
  "id" => 9529
  "imdb_id" => "tt0103919"
  "popularity" => 8.5535
  "status" => "Released"
  "video" => false
  "vote_average" => 6.649
  "vote_count" => 1728
]

--}}