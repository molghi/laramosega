<header class="bg-gray-900 text-white px-6 py-4">
    {{-- Container --}}
    <div class="{{ config('tailwind.container') }} flex items-center justify-between">

        <!-- Logo -->
        <div class="text-xl font-bold"> {{ $sitename }}</div>

        <!-- Navigation Links -->
        <nav class="flex items-center gap-8">
            {{-- @foreach ($navlinks as $link_key => $link_value)
                <a href="{{ $link_value }}" 
                    class="{{ request()->path() === $link_value ? 'font-bold text-yellow-500' : '' }} hover:underline">
                    {{ $link_key }}
                </a>
            @endforeach --}}
            @auth
                @foreach ($navlinks as $link_key => $link_value)
                    @php
                        $current_path = trim(request()->path(), '/');    // slash sliced out
                        $link_path = trim($link_value, '/');             // slash sliced out
                        $active = $link_path === ''
                            ? ($current_path === '')
                            : ($current_path === $link_path || str_starts_with($current_path, $link_path.'/'));
                    @endphp

                    <a href="{{ $link_value }}"
                    class="{{ $active ? 'font-bold text-yellow-500' : '' }} {{$link_key === 'Logout' ? 'opacity-30 hover:opacity-100' : ''}} hover:underline">
                        {{ $link_key }}
                    </a>
                @endforeach
            @else
                <a href="/auth" class="hover:underline {{request()->path()==='auth' ? 'font-bold underline text-[var(--accent)]' : ''}}">Sign Up / Log In</a>
            @endauth
        </nav>
    </div>
</header>