<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

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
                ])->json(),

                'popular_now_series' => Http::get('https://api.themoviedb.org/3/tv/popular', [
                    'api_key' => env('TMDB_API_KEY'),
                    'language' => 'en-US',
                ])->json()
            ];
            return view('home', $data);
        } else {
            // show search form & search results
            return $this->fetch_search_results($request);
        }
    }

    // =================================================================

    public function fetch_search_results ($request) {
        // show search form & search results
            $search_term = $request->query()['search']; // get form data
            $movie_search = 'https://api.themoviedb.org/3/search/movie'; // movies endpoint
            $series_search = 'https://api.themoviedb.org/3/search/tv'; // series endpoint

            // fetch movies
            $response_movies = Http::get($movie_search, [
                'api_key' => env('TMDB_API_KEY'), 
                'query' => $search_term,
                'page' => request()->get('page', 1)
            ])->json();

            // fetch series
            $response_series = Http::get($series_search, [
                'api_key' => env('TMDB_API_KEY'), 
                'query' => $search_term,
                'page' => request()->get('page', 1)
            ])->json();

            // laravel pagination on externally fetched data
            // $perPage = 20;
            // $page = request()->get('page', 1); // current page, 1 by def

            // $paginator = new LengthAwarePaginator(
            //     $response['results'], // slice
            //     $response['total_results'], // total
            //     $perPage,
            //     $page,
            //     ['path' => Paginator::resolveCurrentPath()]
            // );

            $data = [
                'movie_results' => $response_movies,
                'series_results' => $response_series,
                // 'results' => $paginator,
                'search_term' => $search_term,
                'title' => 'Search Results'
            ];

            return view('results', $data);
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

    public function show_movie_by_genre ($id) {
        $response = Http::get('https://api.themoviedb.org/3/discover/movie', [
            'api_key' => env('TMDB_API_KEY'),
            'with_genres' => $id,
            'page' => request()->get('page', 1)
        ])->json();

        // laravel pagination on externally fetched data
        $perPage = 20;
        $page = request()->get('page', 1); // current page, 1 by def

        $paginator = new LengthAwarePaginator(
            $response['results'], // slice
            $response['total_results'], // total
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()]
        );

        $data = [
            'data' => $response,
            'results' => $paginator,
            'type' => 'movie',
            'genre' => config('app.genre_interpreter')[$id]
        ];

        return view('genre', $data);
    }

    // =================================================================

    public function show_series_by_genre ($id) {
        $response = Http::get('https://api.themoviedb.org/3/discover/tv', [
            'api_key' => env('TMDB_API_KEY'),
            'with_genres' => $id,
            'page' => request()->get('page', 1)
        ])->json();

        // laravel pagination on externally fetched data
        $perPage = 20;
        $page = request()->get('page', 1); // current page, 1 by def

        $paginator = new LengthAwarePaginator(
            $response['results'], // slice
            $response['total_results'], // total
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()]
        );

        $data = [
            'data' => $response,
            'results' => $paginator,
            'type' => 'series',
            'genre' => config('app.genre_interpreter')[$id]
        ];

        return view('genre', $data);
    }

    // =================================================================
}
