<?php

namespace App\Http\Controllers;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Genre;
use Config\tmdbapi;

class GenreController extends Controller
{

    public function updateDatabase(){
        $client = new \GuzzleHttp\Client();

        $movieGenres = $this->getGenres($client, config('tmdbapi.genres.movie'));
        $this->updateDatabaseGenres($movieGenres);

        $tvshowGenres = $this->getGenres($client, config('tmdbapi.genres.tvshow'));
        $this->updateDatabaseGenres($tvshowGenres);

        return redirect('/')->with('success', 'Database genres updated.');
    }

    private function getGenres($client, $url){
        $res = $client->request('GET', $url);
        if($res->getStatusCode() == 200){
            $json = json_decode($res->getBody(), true);
            return $json['genres'];
        }
        return null;
    }

    private function updateDatabaseGenres($genres){
        foreach($genres as $genre){
            Genre::firstOrCreate(['id' => $genre['id'], 'name' => $genre['name']]);
        }
    }
}
