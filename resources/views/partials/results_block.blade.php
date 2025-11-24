@php
    $count = (int) count($movie_results['results']) + (int) count($series_results['results']);
    // dd($movie_results);
    // dd($series_results);
@endphp

<div class="{{ config('tailwind.container') }} mt-12">
  <!-- Title -->
  <h1 class="text-2xl font-bold mb-4">Search Results</h1>

  <!-- Flexbox -->
  <div class="flex justify-between items-center gap-4 mb-6">
    <div class="italic transition duration-300 opacity-60 hover:opacity-100">Showing relevant movies & series: {{ $count }} entries</div>
    <div class="">Item 2</div>
  </div>

  <!-- Grid with four elements in a row -->
  <div class="grid grid-cols-4 gap-4">
    <div class="border border-[var(--accent)] rounded-md p-4 text-center">Grid Item 1</div>
    <div class="border border-[var(--accent)] rounded-md p-4 text-center">Grid Item 2</div>
    <div class="border border-[var(--accent)] rounded-md p-4 text-center">Grid Item 3</div>
    <div class="border border-[var(--accent)] rounded-md p-4 text-center">Grid Item 4</div>
  </div>
</div>