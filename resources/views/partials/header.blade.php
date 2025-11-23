<header class="bg-gray-900 text-white px-6 py-4">
    {{-- Container --}}
    <div class="{{ config('tailwind.container') }} flex items-center justify-between">

        <!-- Logo -->
        <div class="text-xl font-bold"> {{ $sitename }}: MOvies & SEries </div>

        <!-- Navigation Links -->
        <nav class="flex items-center gap-8">
            @foreach ($navlinks as $link_key => $link_value)
                <a href="{{ $link_value }}" 
                    class="{{ request()->path() === $link_value ? 'font-bold text-yellow-500' : '' }} hover:underline">
                    {{ $link_key }}
                </a>
            @endforeach
        </nav>
    </div>
</header>