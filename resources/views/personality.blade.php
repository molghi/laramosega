@extends('layouts.app')

@section('title', $bio['name'])

@section('content')
    @include('partials.flash_msg')
    @include('partials.personality_block')
@endsection