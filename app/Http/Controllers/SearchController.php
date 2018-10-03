<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TVShow;
use App\Movie;

class SearchController extends Controller
{
    public function get(Request $request){
        $searchString = $request->input('search');
        $movies = Movie::whereNotNull('poster_path')->where('title', 'LIKE', '%'.$searchString.'%')->orderBy('popularity', 'desc')->take(3)->get();
        $tvshows = TVShow::whereNotNull('poster_path')->where('name', 'LIKE', '%'.$searchString.'%')->orderBy('popularity', 'desc')->take(2)->get();
        $json = ['movies' => $movies ? $movies : [], 'tvshows' => $tvshows ? $tvshows : []];
        return  $json;
    }
}
