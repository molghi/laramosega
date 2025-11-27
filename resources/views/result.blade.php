@php    
    // dd($data);
    if ($type === 'movie') {
        $title = $data['title'] . ' (' . substr($data['release_date'], 0, 4) . ')';
    } else {
        $ended_in = $data['last_air_date'] ? '-' . substr($data['last_air_date'], 0, 4) : '';
        $title = $data['name'] . ' (' . substr($data['first_air_date'], 0, 4) . $ended_in . ')';
    }
@endphp

@extends('layouts.app')

@section('title', $title)

@section('content')
    <x-result-in-details :type="$type" :resultData="$data" />
@endsection