<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use App\TVShow;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request){
        $nowPlaying = $this->getNowPlaying();
        $upcoming = $this->getUpcoming();
        $newTVShows = $this->getNewTVShows();
        return view('home', ['nowPlaying' => $nowPlaying, 'upcoming' => $upcoming, 'newTVShows' => $newTVShows]);
    }

    private function getNowPlaying(){
        $end = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        $start = $end->copy()->subMonth(2);
        $nowPlaying = Movie::whereNotNull('poster_path')->whereBetween('release_date', [$start->toDateString(), $end->toDateString()])->orderBy('popularity', 'desc')->take(9)->get();
        return $nowPlaying;
    }

    private function getUpcoming(){
        $start = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        $end = $start->copy()->addMonth(4);
        $upcoming = Movie::whereNotNull('poster_path')->whereBetween('release_date', [$start->toDateString(), $end->toDateString()])->orderBy('popularity', 'desc')->take(9)->get();
        return $upcoming;
    }

    private function getNewTVShows(){
        $today = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        $start = $today->copy()->subMonth(3);
        $end = $today->copy()->addMonth(3);
        $newTVShows = TVShow::whereNotNull('poster_path')->whereBetween('first_air_date', [$start->toDateString(), $end->toDateString()])->orderBy('popularity', 'desc')->take(9)->get();
        return $newTVShows;
    }
}
