@php
    $is_bookmarked = in_array($resultData['id'], $bookmarkIds);
    // dd($type);
@endphp

<div class="{{ config('tailwind.container') }} mt-16">
    <div class="grid grid-cols-[30%_70%] gap-6">
        {{-- col 1 --}}
        <div class="flex flex-col gap-6">
            {{-- poster --}}
            <div class="bg-gray-800 p-4 rounded overflow-hidden">
                <img src="{{ $tmdb_base_path . $resultData['poster_path'] }}" alt="Poster" class="poster hover:scale-125 transition">
            </div>

            {{-- tagline --}}
            @if ($resultData['tagline'])
                <div title="Slogan" class="bg-gray-800 p-4 rounded text-sm italic">{{ $resultData['tagline'] }}</div>
            @endif
        </div>

        {{-- col 2 --}}
        <div class="column-2 bg-gray-900 p-4 rounded flex flex-col gap-3 relative">
            {{-- add to/remove from favorites --}}
            <form action="{{ $is_bookmarked ? route('bookmark.remove') : route('bookmark.add') }}" method="POST">
                @csrf
                @if ($is_bookmarked)
                    @method('DELETE')
                @endif
                <input type="hidden" name="title_id" value="{{$resultData['id']}}">
                <input type="hidden" name="type" value="{{$type}}">
                <button type="submit" class="absolute top-[-45px] right-0 text-sm text-white rounded-xl px-3 py-1 transition duration-200 hover:opacity-100 opacity-50 active:opacity-50 {{ $is_bookmarked ? 'bg-red-400' : 'bg-blue-700' }}">{{ $is_bookmarked ? 'Remove from Bookmarks' : 'Add to Bookmarks' }}</button>
            </form>

            {{-- backdrop --}}
            <div class="backdrop absolute z-[0] top-[0] left-[0] w-full h-full h-64 overflow-hidden">
                <img src="{{ $tmdb_base_path . $resultData['backdrop_path'] }}"
                    class="w-full h-full object-cover opacity-10 transition duration-1000">
            </div>

            <div class="relative z-[1] flex flex-col gap-3">
                {{-- name --}}
                <div class="text-2xl font-bold mb-4">
                    {{ $type === 'series' ? $resultData['name'] : $resultData['title'] }}
                </div>

                {{-- is adult --}}
                @if ($resultData['adult'])
                    <span class="absolute top-[10px] right-[10px] text-white rounded-2xl text-sm px-2 py-1 bg-red-500">Adult</span>
                @endif

                {{-- release date --}}
                <div class="flex justify-between gap-x-4 gap-y-2 flex-wrap">
                    @if ($type === 'series' && $resultData['first_air_date'])
                        <div title="{{$resultData['first_air_date']}}">
                            <span class="font-bold opacity-50">First Aired: </span> {{ substr($resultData['first_air_date'], 0, 4) }}
                            <span class="opacity-50 italic">(Years ago: {{ (int) date('Y') - (int) substr($resultData['first_air_date'], 0, 4) }})</span>
                        </div>
                        @if ($resultData['last_air_date'])
                            <div title="{{$resultData['last_air_date']}}">
                                <span class="font-bold opacity-50">Last Aired: </span> {{ substr($resultData['last_air_date'], 0, 4) }}
                                <span title="Status" class="opacity-50 italic">({{ $resultData['status'] }}{{$resultData['in_production'] ? ', In Production' : ''}})</span>
                            </div>
                        @endif
                    @else
                        @if (!empty($resultData['release_date']))
                        <div title="Release Date: {{ $resultData['release_date'] }}">
                            <span class="font-bold opacity-50">Release Year: </span> {{ substr($resultData['release_date'], 0, 4) }}
                            @if ((int) date('Y') - (int) substr($resultData['release_date'], 0, 4) > -1)
                            <span class="opacity-50 italic">(Years ago: {{ (int) date('Y') - (int) substr($resultData['release_date'], 0, 4) }})</span>
                            @endif
                        </div>
                        @endif
                    @endif
                </div>

                {{-- country, language --}}
                <div class="flex gap-10">
                    @if ($resultData['origin_country'])
                    <div>
                        <span class="font-bold opacity-50">Origin Country: </span> {{ implode(', ', $resultData['origin_country']) }}
                    </div>
                    @endif 

                    @if ($resultData['original_language'])
                    <div>
                        <span class="font-bold opacity-50">Original Language: </span> {{ strtoupper($resultData['original_language']) }}
                    </div>
                    @endif
                </div>

                {{-- genres --}}
                @if ($resultData['genres'])
                    <div>
                        <span class="font-bold opacity-50">Genres: </span> 
                        @php
                            $genres = [];
                            $genres_codes = [];
                            foreach ($resultData['genres'] as $genre) {
                                array_push($genres, $genre['name']);
                                array_push($genres_codes, $genre['id']);
                            }
                            $markup = [];
                            foreach ($genres as $index => $genre) {
                                $code = $genres_codes[$index];
                                array_push($markup, "<a href='/genre/$type/$code' class='border-b-2 border-dotted hover:border-[transparent]'>$genre</a>");
                            }
                        @endphp
                        {!! implode(', ', $markup) !!}
                    </div>
                @endif

                {{-- overview --}}
                @if ($resultData['overview'])
                <div>
                    <span class="font-bold opacity-50">About: </span> {{ $resultData['overview'] }}
                </div>
                @endif

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
                @if ($type === 'movie' && $resultData['runtime'])
                <div>
                    <span class="font-bold opacity-50">Runtime: </span> 
                    @php
                        $value = $resultData['runtime'];
                        $hours = floor($value/60);
                        $minutes = floor($value%60);
                        echo $hours . 'h ' . $minutes . 'm';
                    @endphp
                </div>
                @endif

                {{-- vote / popularity --}}
                @if ($resultData['vote_average'] || $resultData['popularity'])
                    <div class="flex gap-8">
                        @if ($resultData['vote_average'])
                        <div>
                            <span class="font-bold opacity-50">Community Vote: </span> 
                            {{ round($resultData['vote_average'], 1) }} 
                            <span title="Number of votes">({{ $resultData['vote_count'] }})</span>
                        </div>
                        @endif

                        @if ($resultData['popularity'])
                        <div>
                            <span class="font-bold opacity-50">Popularity: </span> 
                            {{ round($resultData['popularity'], 1) }} 
                        </div>
                        @endif
                    </div>
                @endif

                {{-- created by --}}
                @php
                    $directors = [];
                    foreach ($details['credits']['crew'] as $person) {
                        if ($person['job'] === 'Director') array_push($directors, $person);
                    }
                @endphp
                @if (!empty($resultData['created_by']) || count($directors) > 0)
                <div>
                    <span class="font-bold opacity-50">Created By: </span> 
                        @php    
                        $directors2 = [];
                        if (!empty($resultData['created_by'])) {
                            foreach ($resultData['created_by'] as $person) {
                                $classes = 'personality border-b-2 border-dotted hover:border-[transparent]';
                                $photo = $tmdb_base_path . $person['profile_path'];
                                $id = $person['id'];
                                $href = "/personality/$id";
                                $name = $person['name'];
                                $entry = "<span class='relative'><a class='$classes' data-photo='$photo' href='$href'>$name</a></span>";
                                array_push($directors2, $entry);
                            }
                        }
                        if (count($directors) > 0) {
                            foreach ($directors as $person) {
                                $classes = 'personality border-b-2 border-dotted hover:border-[transparent]';
                                $photo = $tmdb_base_path . $person['profile_path'];
                                $id = $person['id'];
                                $href = "/personality/$id";
                                $name = $person['name'];
                                $entry = "<span class='relative'><a class='$classes' data-photo='$photo' href='$href'>$name</a></span>";
                                array_push($directors2, $entry);
                            }
                        }
                        @endphp
                        {!! implode(', ', $directors2) !!}
                </div>
                @endif

                {{-- cast --}}
                @if (!empty($details['credits']) && count($details['credits']['cast']) > 0)
                <div>
                    <span class="font-bold opacity-50">Cast: </span> 
                        @php    
                        $cast = [];
                        foreach ($details['credits']['cast'] as $key => $person) {
                            if ($key < 15) {
                                $classes = 'personality';
                                $photo = $tmdb_base_path . $person['profile_path'];
                                $id = $person['id'];
                                $href = "/personality/$id";
                                $name = $person['name'];
                                $character = $person['character'];
                                $characterElement = !$character ? '' : "<span class='opacity-50'> ($character)</span>";
                                $entry = "<span class='relative'>
                                            <span class='$classes'> 
                                                <a data-photo='$photo' href='$href' class='border-b-2 border-dotted hover:border-[transparent]'>$name</a>
                                                <span>$characterElement</span>
                                            </span>
                                        </span>";
                                array_push($cast, $entry);
                            }
                        }
                        @endphp
                        {!! implode(', ', $cast) !!}
                </div>
                @endif

                {{-- prod companies --}}
                @if ($resultData['production_companies'])
                <div>
                    @php
                        $companies = [];
                        foreach ($resultData['production_companies'] as $key => $val) {
                            if ($key < 3) {
                                $name = $val['name'];
                                array_push($companies, "<span>$name</span>");
                            }
                        }
                    @endphp
                    <span class="font-bold opacity-50">Production Companies: </span> {!! implode(', ', $companies) !!}
                </div>
                @endif

                {{-- last-next episode date --}}
                <div class="flex items-center gap-6">
                    @if (!empty($resultData['last_episode_to_air']))
                    <div class="test-sm">
                        <span class="font-bold opacity-50" title="Last Episode Aired">Last Episode: </span> {{ $resultData['last_episode_to_air']['air_date'] }} 
                        <span class="opacity-50 italic">{{ $resultData['last_episode_to_air']['episode_type'] && $resultData['last_episode_to_air']['episode_type'] === 'finale' ? ' (' . ucwords($resultData['last_episode_to_air']['episode_type']) . ')' : '' }}</span>
                    </div>
                    @endif
                    
                    @if (!empty($resultData['next_episode_to_air']))
                    <div>
                        <span class="font-bold opacity-50" title="Next Episode to Air">Next Episode: </span> {{ $resultData['next_episode_to_air']['air_date'] }} 
                        {{ $resultData['next_episode_to_air']['episode_type'] && $resultData['next_episode_to_air']['episode_type'] === 'finale' ? ' (' . ucwords($resultData['next_episode_to_air']['episode_type']) . ')' : '' }}
                    </div>
                    @endif
                </div>

                {{-- belongs to collection --}}
                @if (!empty($resultData['belongs_to_collection']))
                <div>
                    <span class="font-bold opacity-50">Belongs to Collection: </span> 
                    <a class="underline hover:no-underline" href="/collection/{{ $resultData['belongs_to_collection']['id'] }}">{{ $resultData['belongs_to_collection']['name'] }}</a>
                </div>
                @endif

                {{-- homepage --}}
                @if (!empty($resultData['homepage']))
                <div>
                    <span class="font-bold opacity-50">Homepage: </span> <a href="{{ $resultData['homepage'] }}" class="underline hover:no-underline" target="_blank">Visit</a>
                </div>
                @endif

            </div>

        </div>
    </div>

    {{-- gallery --}}
    @if (!empty($details['images']['backdrops']) || !empty($details['videos']['results']))
        <h3 class="text-2xl font-bold mt-10 mb-4">Gallery</h3>
    @endif 

    {{-- images --}}
    <div class="grid gap-8 grid-cols-4 mb-8">
        @if (!empty($details['images']))
            @foreach ($details['images']['backdrops'] as $index => $item)
                @if ($index < 20)
                    <div>
                        <a href="{{ $tmdb_base_path . $item['file_path'] }}" class="glightbox" data-gallery="gallery">
                            <img class="transition duration-700 hover:scale-125" src="{{ $tmdb_base_path . $item['file_path'] }}" alt="Gallery Image" />
                        </a>
                    </div>
                @endif
            @endforeach
        @endif
    </div>

    {{-- videos --}}
    <div class="grid gap-8 grid-cols-4">
        @if (!empty($details['videos']))
            @foreach ($details['videos']['results'] as $index => $item)
                @if ($index < 8)
                    <div class="border border-[gold] p-4 rounded-md text-sm text-center flex flex-col gap-2 items-center justify-center">
                        <a class="underline hover:no-underline glightbox" data-type="video" data-gallery="gallery" href="https://youtu.be/{{ $item['key'] }}" target="_blank">
                            {{ $item['name'] }} 
                        </a>
                        <span class="opacity-50 hover:opacity-100">({{ $item['site'] }}, {{ $item['type'] }})</span>
                    </div>
                @endif
            @endforeach
        @endif
    </div>

    {{-- seasons & episodes info --}}
    @if (!empty($seasons))
        <h3 class="text-2xl font-bold mt-20 mb-6">Seasons & Episodes</h3>
        <div class="seasons grid grid-cols-3 gap-6">
        @foreach ($seasons as $season)
            <div class="flex flex-col gap-2">
                {{-- name --}}
                <span>{{ $season['name'] }}</span> 

                {{-- poster --}}
                {{-- @if (!empty($season['poster_path'])) --}}
                <div class="overflow-hidden">
                    <img alt="Poster missing" src="{{$tmdb_base_path . $season['poster_path']}}" class="w-full h-[400px] bg-[#202020] text-center transition duration-700 hover:scale-110" />
                </div>
                {{-- @endif --}}

                {{-- aired --}}
                {{-- @if (!empty($season['air_date'])) --}}
                <div>
                    <span class="font-bold opacity-50">
                        {{ !empty(!empty($season['air_date'])) ? 'First air date:' : 'Air date:' }}    
                    </span> 
                    {{ !empty($season['air_date']) ? $season['air_date'] : 'Unknown' }}
                </div>
                {{-- @endif --}}

                {{-- overview --}}
                @if (!empty($season['overview']))
                    <div>
                        <span class="font-bold opacity-50">Season Overview: </span> 
                        <button class="overview-toggler underline hover:no-underline active:opacity-50">View</button>
                        <div class="episode-overview text-[12px] hidden">{{$season['overview'] }}</div>
                    </div>
                @endif

                {{-- total runtime --}}
                @if (!empty($season['episodes'][0]['runtime']))
                    <div>
                        <span class="font-bold opacity-50">Total Runtime: </span> 
                        @php
                            $total = 0;
                            foreach ($season['episodes'] as $ep) {
                                $total += (int) $ep['runtime'];
                            }
                            $total_hours = floor($total/60);
                            $total_minutes = floor($total%60);
                            echo $total_hours . 'h ' . $total_minutes . 'm';
                        @endphp
                    </div>
                @endif

                {{-- episode list --}}
                @if (!empty($season['episodes']))
                    <div>
                        <span class="font-bold opacity-50">Episode List: </span> <button class="episode-toggler underline hover:no-underline active:opacity-50">View</button>
                    </div>
                    <ol class="episode-list list-decimal list-inside hidden">
                        @foreach ($season['episodes'] as $ep)
                            <li class="episode relative text-sm hover:border-none mb-2" data-img="{{$tmdb_base_path . $ep['still_path']}}">
                                <span class="border-b-2 border-dotted border-[silver] cursor-pointer hover:border-none">{{ $ep['name'] }}</span>
                                @if ($ep['runtime'])
                                    <span class="transition opacity-50 hover:opacity-100" title="Episode Runtime">({{$ep['runtime']}}m)</span>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                @endif

            </div>
        @endforeach
    </div>
    @endif
    
</div>


{{-- ==================================================================================================== --}}
{{-- ==================================================================================================== --}}
{{-- ==================================================================================================== --}}

<script>
    // hover on and show person photo
    document.querySelector('.column-2').addEventListener('mouseover', function (e) {
        if (e.target.tagName === 'A') {
            const imgPath = e.target.dataset.photo;
            e.target.closest('span').insertAdjacentHTML('beforeend', `<span class="bg-gray-800 inline-flex items-center justify-center text-center absolute z-[100] top-[115%] left-[0]">
                <img src="${imgPath}" alt="Person Image" class="person-photo bg-black text-sm w-[100px] h-[150px] rounded-md" />
            </span>`);
        }
    });

    // hover out and hide it
    document.querySelector('.column-2').addEventListener('mouseout', function (e) {
        if (e.target.tagName === 'A') {
            document.querySelectorAll('.person-photo').forEach(x => x.remove())
        }
    });

    // hover over episode and see screenshot
    if (document.querySelector('.seasons')) {
        document.querySelector('.seasons').addEventListener('mouseover', function(e) {
            if (e.target.closest('li.episode')) {
                const imgPath = e.target.closest('li.episode').dataset.img;
                if (!imgPath) return;
                e.target.closest('li.episode').insertAdjacentHTML('beforeend', `<img src="${imgPath}" alt="Episode Image" class="episode-image absolute top-[103%] left-[23px] z-[10] bg-[#202020] max-w-[200px] w-full h-[110px]" />`)
            }
        })

        // hide ep screenshot
        document.querySelector('.seasons').addEventListener('mouseout', function(e) {
            document.querySelectorAll('.episode-image').forEach(x => x.remove());
        })

        // view/hide episode list
        document.querySelector('.seasons').addEventListener('click', function (e) {
            if (e.target.closest('button.episode-toggler')) {
                const btnText = e.target.closest('button.episode-toggler').textContent;
                e.target.closest('button.episode-toggler').textContent = btnText === 'View' ? 'Hide' : 'View';
                e.target.closest('div').nextElementSibling.classList.toggle('hidden');
            }

            if (e.target.closest('button.overview-toggler')) {
                const btnText = e.target.closest('button.overview-toggler').textContent;
                e.target.closest('button.overview-toggler').textContent = btnText === 'View' ? 'Hide' : 'View';
                e.target.closest('button.overview-toggler').nextElementSibling.classList.toggle('hidden');
            }
        });
    }
</script>

{{-- <script>
  const lightbox = GLightbox({
    selector: '.glightbox',
    loop: true,
    touchNavigation: true
  });
</script> --}}

<script>
  document.querySelectorAll('.glightbox').forEach(el => {
    el.addEventListener('click', function(e) {
      e.preventDefault(); // prevent page scroll
    });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    GLightbox({ selector: '.glightbox', loop: true });
  });
</script>
