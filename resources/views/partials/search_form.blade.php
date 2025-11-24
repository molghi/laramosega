@php
  $mode = !empty($search_term) ? 'search' : 'initial';
@endphp

<div class="max-w-lg mx-auto mt-12">
  <!-- Title -->
  <h2 class="{{ config('tailwind.page_title') }} mb-8">Search for a Movie or Series</h2>

  <!-- Form -->
  <form class="flex items-center gap-4">
    <input type="text" 
      placeholder="Enter title..." 
      name="search"
      class="search-input bg-gray-800 flex-1 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300"
      value="{{ $mode === 'search' ? $search_term : '' }}"
      {{ $mode !== 'search' ? 'autofocus' : '' }}
    >

    <button type="submit" 
      class="px-4 py-2 bg-blue-600 text-white rounded hover:opacity-70 transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
    >
      Search
    </button>

  </form>
</div>