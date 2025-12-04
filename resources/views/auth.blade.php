@extends('layouts.app')

@section('title', 'Sign Up or Log In')

@section('content')
    <h2 class="mt-12 text-center {{ config('tailwind.page_title') }} mb-8">Sign Up or Log In</h2>

    <div class="{{ config('tailwind.container') }} flex flex-col gap-6">
        @include('partials.auth_forms')
    </div>  
@endsection