@extends('layouts.app')

@section('title', $title)

@section('content')
    @include('partials.search_form')
    @include('partials.results_block')
@endsection