@php
    $is_bookmarked_page = request()->path() === 'bookmarked';
@endphp

<div
    data-id="{{ $resultData['id'] }}"
    class="border border-[var(--accent)] rounded-md p-4 relative flex flex-col gap-2 {{ $is_bookmarked_page ? 'relative' : "" }}">

    {{-- remove bookmark btn --}}
    @if ($is_bookmarked_page)
        <form action="{{ route('bookmark.remove') }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="title_id" value="{{$resultData['id']}}">
            <input type="hidden" name="type" value="{{$type}}">
            <button onclick="return confirm('Are you sure you want to delete this bookmark?')" type="submit" class="absolute top-[5px] left-[5px] z-[10] text-sm text-white rounded-xl px-2 py-1 transition duration-200 hover:opacity-100 opacity-30 active:opacity-50 bg-[white]" title="Remove Bookmark">❌</button>
        </form>
    @endif

    {{-- image --}}
    <div>
        <a href="/title/{{ $type === 'movie' ? 'movie' : 'series' }}/{{ $resultData['id'] }}" class="transition duration-300 hover:opacity-70" title="{{ $resultData['overview'] }}">
            <img src="{{ $tmdb_base_path . $resultData['poster_path'] }}" alt="Poster image" class="w-full h-[250px] bg-[#202020]">
        </a>
    </div>

    {{-- is adult --}}
    @if (!empty($resultData['adult']))
        <span class="absolute top-[10px] right-[10px] text-white rounded-2xl text-sm px-2 py-1 bg-red-500">Adult</span>
    @endif

    {{-- name, year --}}
    <div>
        <a class="font-bold hover:underline" href="/title/{{ $type === 'movie' ? 'movie' : 'series' }}/{{ $resultData['id'] }}">
            @if ($type === 'movie')
                {{ $resultData['title'] }} 
            @else
                {{ $resultData['name'] }} 
            @endif 

            @if ($type === 'movie' && $resultData['release_date'])
                <span class="transition duration-300 opacity-60 hover:opacity-100" title="Released years ago: {{ (int) date('Y') - (int) substr($resultData['release_date'], 0, 4) }}">({{ substr($resultData['release_date'], 0, 4) }})</span>
            @elseif ($type === 'series' && $resultData['first_air_date'])
                <span class="transition duration-300 opacity-60 hover:opacity-100" title="Released years ago: {{ (int) date('Y') - (int) substr($resultData['first_air_date'], 0, 4) }}">({{ substr($resultData['first_air_date'], 0, 4) }})</span>
            @endif 
        </a>
    </div>

    {{-- orig lang --}}
    <div class="flex items-center gap-2 text-[12px]">
        <span class="opacity-60">Original Language: </span> {{ strtoupper($resultData['original_language']) }}
    </div>

    {{-- genres --}}
    @if (!empty($resultData['genre_ids']) || !empty($resultData['genres']))
        <div class="text-[12px]">
            <span class="opacity-60">Genres: </span> 
            @php
                $genres = [];
                if (!empty($resultData['genre_ids'])) {
                    foreach ($resultData['genre_ids'] as $genre_code) {
                        array_push($genres, $genre_interpreter[$genre_code]);
                    }
                }
                if (!empty($resultData['genres'])) {
                    foreach ($resultData['genres'] as $genre) {
                        array_push($genres, $genre['name']);
                    }
                }
            @endphp
            {{ implode(', ', $genres) }}
        </div>
    @endif
</div>