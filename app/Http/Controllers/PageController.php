<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PageController extends Controller
{
    // =================================================================

    public function homepage (Request $request) {
        // dd($request);
        $has_query_string = count($request->query());

        if (!$has_query_string) {
            // just show the search form
            return view('home');
        } else {
            // show search form & search results
            $search_term = $request->query()['search']; // get form data
            $movie_search = 'https://api.themoviedb.org/3/search/movie'; // movies endpoint
            $series_search = 'https://api.themoviedb.org/3/search/tv'; // series endpoint

            // fetch movies
            $response = Http::get($movie_search, [
                'api_key' => env('TMDB_API_KEY'), 
                'query' => $search_term
            ]);
            // return movies json
            $data_movies = $response->json();

            // fetch series
            $response = Http::get($series_search, [
                'api_key' => env('TMDB_API_KEY'), 
                'query' => $search_term
            ]);
            // return series json
            $data_series = $response->json();

            $data = [
                'movie_results' => $data_movies,
                'series_results' => $data_series,
                'search_term' => $search_term,
                'title' => 'Search Results'
            ];

            return view('results', $data);
        }
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

    public function run_search (Request $request) {
        dd($request);
    }

    // =================================================================
}
