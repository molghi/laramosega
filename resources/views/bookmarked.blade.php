@php
    // dd($bookmarked_titles);
@endphp

@extends('layouts.app')

@section('title', 'Bookmarked Titles')

@section('content')
    <h2 class="mt-12 text-center {{ config('tailwind.page_title') }} mb-8">Bookmarked Titles</h2>

    @if (!empty($bookmarked_titles) && count($bookmarked_titles))
        <div class="{{ config('tailwind.container') }} mt-12">
            <div class="grid grid-cols-4 gap-4">
                @foreach ($bookmarked_titles as $title)
                    @php
                        $type = $title['entry_type'];
                    @endphp
                    <x-result-item :type="$type" :resultData="$title" />
                @endforeach
            </div>
        </div>
    @else 
        <div class="text-center my-10">You haven't bookmarked anything yet.</div>
    @endif
@endsection