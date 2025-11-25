<div
    data-id="{{ $resultData['id'] }}"
    class="border border-[var(--accent)] rounded-md p-4 relative flex flex-col gap-2">

    {{-- image --}}
    <div>
        <a href="/title/{{ $resultData['id'] }}" class="transition duration-300 hover:opacity-70" title="{{ $resultData['overview'] }}">
            <img src="{{ $tmdb_base_path . $resultData['poster_path'] }}" alt="Poster image">
        </a>
    </div>

    {{-- is adult --}}
    @if ($resultData['adult'])
        <span class="absolute top-[10px] right-[10px] text-white rounded-2xl text-sm px-2 py-1 bg-red-500">Adult</span>
    @endif

    {{-- name, year --}}
    <div>
        <a class="font-bold hover:underline" href="/title/{{ $resultData['id'] }}">
            @if ($type === 'movie')
                {{ $resultData['title'] }} 
            @else
                {{ $resultData['name'] }} 
            @endif 

            @if ($type === 'movie' && $resultData['release_date'])
                ({{ substr($resultData['release_date'], 0, 4) }})
            @elseif ($type === 'series' && $resultData['first_air_date'])
                ({{ substr($resultData['first_air_date'], 0, 4) }})
            @endif 
        </a>
    </div>

    {{-- orig lang --}}
    <div class="flex items-center gap-2 text-[12px]">
        <span class="opacity-60">Original Language: </span> {{ strtoupper($resultData['original_language']) }}
    </div>

    {{-- genres --}}
    @if ($resultData['genre_ids'])
        <div class="text-[12px]">
            <span class="opacity-60">Genres: </span> 
            @php
                $genres = [];
                foreach ($resultData['genre_ids'] as $genre_code) {
                    array_push($genres, $genre_interpreter[$genre_code]);
                }
            @endphp
            {{ implode(', ', $genres) }}
        </div>
    @endif
</div>