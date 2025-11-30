@extends('layouts.app')

@section('title', 'About')

@section('content')
    <h2 class="mt-12 text-center {{ config('tailwind.page_title') }} mb-8">About This App</h2>

    <div class="{{ config('tailwind.container') }} flex flex-col gap-6">
        <p class="bg-gray-800 p-4 rounded"><strong>MOSE</strong> (<i class="opacity-50">Movies and Series</i>) is a small web platform that enables users to search for <strong>movies and TV series</strong> through an external data source. It retrieves detailed information about each title, including visuals, release data, and basic metadata. The search is immediate, and results can be browsed in a clear, structured layout.</p>

        <p class="bg-gray-800 p-4 rounded">Users may also view <strong>full detail pages</strong> for individual movies or series. These pages present an expanded set of attributes, allowing the user to examine a title more thoroughly. The interface remains minimal and functional to keep interaction straightforward.</p>

        <p class="bg-gray-800 p-4 rounded">A <strong>bookmarking feature</strong> is included so users can save titles they find interesting. Bookmarked items are stored and can be accessed through a dedicated section, providing a simple personal catalog. The overall goal of the application is to offer quick discovery and lightweight tracking of films and series.</p>
    </div>
@endsection