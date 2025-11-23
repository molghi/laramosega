<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    // =================================================================

    public function homepage () {
        return view('home');
    }

    // =================================================================

    public function bookmarked () {
        return view('bookmarked');
    }

    // =================================================================

    public function about () {
        return view('about');
    }

    // =================================================================
}
