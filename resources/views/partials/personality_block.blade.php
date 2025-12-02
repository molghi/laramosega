@php
// dd($bio);
// dd($titles);
$is_director = $bio['known_for_department'] === 'Directing';
if ($is_director) {
    $titles_directed = [];
    foreach ($titles['crew'] as $title) {
        if ($title['job'] === 'Director') array_push($titles_directed, $title);
    }
    usort($titles_directed, function ($a, $b) {
        $key_name1 = $a['media_type'] === 'movie' ? 'release_date' : 'first_air_date';
        $key_name2 = $b['media_type'] === 'movie' ? 'release_date' : 'first_air_date';
        return strtotime($b[$key_name2]) <=> strtotime($a[$key_name1]);
    });
} else {
    $titles_starred_in = [];
    foreach ($titles['cast'] as $title) {
        // if ($title['job'] === 'Actor' || $title['job'] === 'Actress') 
        if (!in_array(10767, $title['genre_ids'])) array_push($titles_starred_in, $title);
    }
    usort($titles_starred_in, function ($a, $b) {
        $key_name1 = $a['media_type'] === 'movie' ? 'release_date' : 'first_air_date';
        $key_name2 = $b['media_type'] === 'movie' ? 'release_date' : 'first_air_date';
        return strtotime($b[$key_name2]) <=> strtotime($a[$key_name1]);
    });
    // dd($titles_starred_in);
}
@endphp

<div class="{{ config('tailwind.container') }} mt-16">
    {{-- 2 cols --}}
    {{-- <div class="grid grid-cols-[30%_70%] items-start gap-9 "> --}}
    <div class="w-full mb-[70px]">
        <!-- Left column: profile img -->
        <div class="bg-gray-800 p-4 rounded overflow-hidden w-[260px] float-left mr-9 mb-4">
            <img src="{{ $tmdb_base_path . $bio['profile_path'] }}" alt="Profile Image" class="w-full h-full object-fit mb-4 hover:scale-125 transition poster">
        </div>

        <!-- Right column: details -->
        <div class="space-y-2">
            {{-- name --}}
            <h1 class="text-2xl font-bold mb-5">{{ $bio['name'] }}</h1>

            {{-- known for --}}
            <p class="mb-7"><strong class="font-bold opacity-50">Known For:</strong> {{ $bio['known_for_department'] }}</p>

            {{-- years of life --}}
            <div class="flex justify-between items-center gap-6">
                <p><strong class="font-bold opacity-50">
                    Born On:</strong> {{ $bio['birthday'] }}
                    @if (!$bio['deathday'])
                        <span class="text-sm italic opacity-50 transition duration-300 hover:opacity-100">({{ (int) date('Y') - explode('-', $bio['birthday'])[0] }} years old)</span>
                    @endif
                </p>
                @if ($bio['deathday'])
                    <div class="flex gap-4">
                        <p><strong class="font-bold opacity-50">Died On:</strong> {{ $bio['deathday'] }}</p>
                        <span class="text-sm italic opacity-50 transition duration-300 hover:opacity-100">({{ explode('-', $bio['deathday'])[0] - explode('-', $bio['birthday'])[0] }} years old)</span>
                    </div>
                @endif
            </div>

            {{-- born where --}}
            @if (!empty($bio['place_of_birth']))
                <p><strong class="font-bold opacity-50">Place of Birth:</strong> {{ $bio['place_of_birth'] }}</p>
            @endif

            {{-- website --}}
            @if ($bio['homepage'])
            <p><strong class="font-bold opacity-50">Website:</strong> <a href="{{$bio['homepage']}}" class="text-blue-500 underline hover:no-underline">Visit</a></p>
            @endif

            {{-- is adult actor --}}
            @if ($bio['adult'])
                <p><strong class="font-bold opacity-50">Adult Movies Star:</strong> YES</p>
            @endif
            
            {{-- bio --}}
            <div>
                <strong class="font-bold opacity-50">Bio:</strong>
                <span class="mt-1 text-justify text-sm">{!! nl2br(e($bio['biography'])) !!}</span>
            </div>
        </div>

        <div class="clear-both"></div>
    </div>

    {{-- 1 col --}}
    <div class="grid grid-cols-4 gap-8">
        @if ($is_director) 
            <h2 class="text-2xl col-span-full font-bold mb-2">Titles Directed ({{ count($titles_directed) }})</h2>
            @foreach ($titles_directed as $title)   
                @php
                    $type = $title['media_type']
                @endphp
                <x-result-item :type="$type" :resultData="$title" />
            @endforeach
        @else
            <h2 class="text-2xl col-span-full font-bold mb-2">Titles Appeared In ({{ count($titles_starred_in) }})</h2>
            @foreach ($titles_starred_in as $title)   
                @php
                    $type = $title['media_type']
                @endphp
                <x-result-item :type="$type" :resultData="$title" />
            @endforeach
        @endif
    </div>
</div>