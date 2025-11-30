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
                'query' => $search_term,
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

    public function details ($type, $id) {
        // fetch and return
        if ($type === 'movie') {
            // FETCHING A MOVIE
            $response = Http::get("https://api.themoviedb.org/3/movie/$id", [ 'api_key' => env('TMDB_API_KEY') ]);
            // fetch details
            $id = $response['id'];
            $details = Http::get("https://api.themoviedb.org/3/movie/{$id}", [
                'api_key' => env('TMDB_API_KEY'),
                'append_to_response' => 'credits,images,videos'
            ])->json();
        } else {
            // FETCHING A SERIES
            $response = Http::get("https://api.themoviedb.org/3/tv/$id", [ 'api_key' => env('TMDB_API_KEY') ]);
            // fetch details
            $id = $response['id'];
            $details = Http::get("https://api.themoviedb.org/3/tv/{$id}", [
                'api_key' => env('TMDB_API_KEY'),
                'append_to_response' => 'credits,images,videos'
            ])->json();
            $seasonsData = [];
            for ($i = 0; $i < $response['number_of_seasons']; $i++) {
                $num = $i+1;
                $seasonInfo = Http::get("https://api.themoviedb.org/3/tv/$id/season/$num", [ 'api_key' => env('TMDB_API_KEY') ]);
                array_push($seasonsData, $seasonInfo->json());
            }
        }

        $data = $response->json();
        $final_data = [
            'data' => $data, 
            'type' => $type,
            'details' => $details,
            'seasons' => !empty($seasonsData) ? $seasonsData : ''
        ];
        return view('result', $final_data);
    }

    // =================================================================

    public function add_bookmark (Request $request) {
        $title_id = $request['title_id'];
        dd($title_id);
    }

    // =================================================================
}
