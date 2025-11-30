@php
    $count = (int) count($movie_results['results']) + (int) count($series_results['results']);
@endphp

<div class="{{ config('tailwind.container') }} mt-12">
  <!-- Title -->
  <h1 class="text-2xl font-bold mb-4">Search Results</h1>

  <!-- Flexbox -->
  <div class="flex justify-between items-center gap-4 mb-6">
    <div class="italic transition duration-300 opacity-60 hover:opacity-100">Showing relevant results: {{ $count }} entries</div>
    {{-- <div class="">~~~~~</div> --}}
  </div>

  <!-- Grid with four elements in a row -->
  <div class="grid grid-cols-4 gap-4">
    {{-- movies --}}
    <h2 class="col-span-full text-xl font-bold">Movies:</h2>
    @foreach ($movie_results['results'] as $movRez)
      <x-result-item type="movie" :resultData="$movRez" />
    @endforeach

    <hr class="col-span-full mt-14 mb-10" >

    {{-- series --}}
    <h2 class="col-span-full text-xl font-bold">Series:</h2>
    @foreach ($series_results['results'] as $serRez)
      <x-result-item type="series" :resultData="$serRez" />
    @endforeach
  </div>
</div>