<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Genre;
use App\Movie;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class MovieController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client(['SYNCHRONOUS' => true]);
    }

    public function index(Request $request){
        $start = microtime(true);
        $inputGenres = $request->input('genres');
        $genres = Genre::whereNotIn('id', [10759, 10762, 10763, 10764, 10765, 10766, 10767, 10768, 10770])->orderBy('name', 'asc')->get();
        if($inputGenres){
            $movies = Movie::whereNotNull('poster_path')->whereHas('genres', function($genre) use($inputGenres) {
                $genre->where('id', $inputGenres);
            })->where('vote_count', '>', '100')->orderBy('imdb_rating', 'desc')->paginate(24);
        }
        else{
            $movies = Movie::whereNotNull('poster_path')->where('vote_count', '>', '100')->orderBy('imdb_rating', 'desc')->paginate(24);
        }
        $time_elapsed_secs = microtime(true) - $start;

        return view('movies', ['genres' => $genres, 'movies' => $movies]);
    }

    public function details($id){
        $movie = Movie::find($id);
        $movie->overview = str_limit($movie->overview, 250, '...');
        return view('movie', ['movie' => $movie]);
    }
}
