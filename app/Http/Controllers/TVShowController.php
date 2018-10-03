<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Genre;
use App\Season;
use App\Episode;
use App\TVShow;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Config\tmdbapi;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class TVShowController extends Controller
{
    private $client;
    private $dbGenres;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client(['SYNCHRONOUS' => true]);
        $this->dbGenres = Genre::all();
    }

    public function index(Request $request){
        $start = microtime(true);
        $inputGenres = $request->input('genres');
        $genres = Genre::whereNotIn('id', [10759, 10765, 10768, 10770])->orderBy('name', 'asc')->get();
        if($inputGenres){
            $tvshows = TVShow::whereNotNull('poster_path')->whereHas('genres', function($genre) use($inputGenres) {
                $genre->where('id', $inputGenres);
            })->orderBy('popularity', 'desc')->paginate(24);
        }
        else{
            $tvshows = TVShow::whereNotNull('poster_path')->orderBy('popularity', 'desc')->paginate(24);
        }
        $time_elapsed_secs = microtime(true) - $start;

        return view('tvshows', ['genres' => $genres, 'tvshows' => $tvshows]);
    }

    public function details($id){
        $tvshow = TVShow::find($id);
        $tvshow->overview = str_limit($tvshow->overview, 250, '...');
        $season = $tvshow->seasons()->orderBy('season_number', 'desc')->first();
        $nextEpisode = $season ? Episode::where('tvshow_id', $id)->where('season_id', $season->season_number)->whereDate('air_date', '>=', date("Y-m-d"))->first() : null;
        $previousEpisode = Episode::where('tvshow_id', $id)->whereDate('air_date', '<', date("Y-m-d"))->orderBy('air_date', 'desc')->first();

        return view('tvshow', ['tvshow' => $tvshow, 'nextEpisode' => $nextEpisode, 'previousEpisode' => $previousEpisode]);
    }
}
