<footer class="bg-gray-900 text-gray-300 px-6 py-6 mt-12">
  <div class="{{ config('tailwind.container') }} flex flex-col md:flex-row justify-between items-center">
        <!-- Footer Logo  -->
        <div class="text-lg font-bold"> {{ $sitename }} </div>

        <!-- Footer Nav Links -->
        <nav class="space-x-4">
            @foreach ($navlinks as $link_key => $link_value)
                <a href="{{ $link_value }}" 
                    class="{{ request()->path() === $link_value ? 'font-bold underline' : '' }} hover:underline">
                    {{ $link_key }}</a>
            @endforeach
        </nav>
        
        {{-- Footer Copyright --}}
        <div class="text-center text-sm text-gray-500">
            &copy; Nov 2025 {{ $sitename }}. All rights reserved.
        </div>
    </div>
</footer>