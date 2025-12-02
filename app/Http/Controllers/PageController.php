<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PageController extends Controller
{
    // =================================================================

    public function homepage (Request $request) {
        // dd($request);
        $has_query_string = count($request->query());

        if (!$has_query_string) {
            // just show the search form -- with popular now
            $data = [
                'popular_now_movies' => Http::get('https://api.themoviedb.org/3/movie/popular', [
                    'api_key' => env('TMDB_API_KEY'),
                    'language' => 'en-US',
                    'page' => '1',
                ])->json(),
                'popular_now_series' => Http::get('https://api.themoviedb.org/3/tv/popular', [
                    'api_key' => env('TMDB_API_KEY'),
                    'language' => 'en-US',
                    'page' => '1',
                ])->json()
            ];
            return view('home', $data);
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
        // fetch from db
        $db_bookmarks = Bookmark::latest()->select('title_id', 'type')->get()->toArray();
        
        // fetch data from api
        $entries = [];
        foreach($db_bookmarks as $id) {
            $endpoint = $id['type'] === 'movie' ? 'https://api.themoviedb.org/3/movie/' : 'https://api.themoviedb.org/3/tv/';
            $title_id = $id['title_id'];
            $response = Http::get("$endpoint$title_id", ['api_key' => env('TMDB_API_KEY')]);
            $response = $response->json();
            $response['entry_type'] = $id['type'];
            array_push($entries, $response);
        }

        $data = [
            'bookmarked_titles' => $entries
        ];
        return view('bookmarked', $data);
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
            'seasons' => !empty($seasonsData) ? $seasonsData : '',
            'bookmark_ids' => Bookmark::latest()->pluck('title_id')->toArray()
        ];
        return view('result', $final_data);
    }

    // =================================================================

    public function add_bookmark (Request $request) {
        $title_id = $request['title_id'];
        $type = $request['type'];
        Bookmark::create(['title_id' => $title_id, 'type' => $type]);
        return back()->with('message', 'Bookmark added!');
    }

    // =================================================================

    public function remove_bookmark (Request $request) {
        $title_id = $request['title_id'];
        Bookmark::where('title_id', $title_id)->delete();
        return back()->with('message', 'Bookmark removed!');
    }

    // =================================================================

    public function show_personality ($id) {
        $response_bio = Http::get("https://api.themoviedb.org/3/person/$id", [ 'api_key' => env('TMDB_API_KEY') ]);
        $response_titles = Http::get("https://api.themoviedb.org/3/person/$id/combined_credits", [ 'api_key' => env('TMDB_API_KEY') ]);
        $data = [
            'bio' => $response_bio->json(),
            'titles' => $response_titles->json(),
        ];
        // dd($response_bio->json());
        return view('personality', $data);
    }

    // =================================================================

    public function show_collection ($id) {
        $response = Http::get("https://api.themoviedb.org/3/collection/$id", [ 'api_key' => env('TMDB_API_KEY') ]);
        $response = $response->json();
        $data = [
            'collection' => $response
        ];
        return view('collection', $data);
    }

    // =================================================================
}
