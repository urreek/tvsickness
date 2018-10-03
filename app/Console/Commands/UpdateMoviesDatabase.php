<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Genre;
use App\Movie;
use Config\tmdbapi;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class UpdateMoviesDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateMovies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates movies database';

    private $client;
    private $dbGenres;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->client = new \GuzzleHttp\Client(['SYNCHRONOUS' => true]);
        $this->dbGenres = Genre::all();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->updateDatabase();
    }

    //latest movie - 512059
    public function updateDatabase(){
        $bar = $this->output->createProgressBar(517059-500000);
        for($id = 500000; $id <= 517059; $id++){
            $movie = $this->getMovie($id);
            $this->insertMovie($movie);
            $bar->advance();
        }
    }

    private function getMovie($id, $appendToResponse = "videos,external_ids"){
        $max_attempt = 10;
        $retry = true;
        while($retry && $max_attempt > 0){  
            try {
                $res = $this->client->request('GET', 'https://api.themoviedb.org/3/movie/'.$id.'?api_key='.config('tmdbapi.key').'&language=en-US&append_to_response='.$appendToResponse, ['delay' => 100, 'connect_timeout' => 10]);
                if($res->getStatusCode() == 200){
                    $retry = false;
                    $json = json_decode($res->getBody(), true);
                    return $json;
                }
                else{
                    dump("Else: ".$id);
                    $max_attempt--;
                }

            } catch (ClientException $e) {
                if($e->getResponse()->getStatusCode() == 404){
                    dump("ClientException Request: ".$id);
                    dump("ClientException Response: ".$e->getResponse()->getBody()->getContents());
                    $retry = false;
                }
                else{
                    dump("ClientException Request: ".$id);
                    dump("ClientException Response: ".$e->getResponse()->getBody()->getContents());
                    $max_attempt--;
                }
            } catch (ServerException $e){
                dump("ServerException Request: ".$id);
                dump("ServerException Response: ".$e->getResponse()->getBody()->getContents());
                $max_attempt--;
            }
        }
        return null;
    }

    private function getImdbRating($imdb_id){
        if($imdb_id){
            try {
                $res = $this->client->request('GET', 'http://www.omdbapi.com/?apikey=6565619a&i='.$imdb_id);
                if($res->getStatusCode() == 200){
                    $json = json_decode($res->getBody(), true);
                    if($json['Response'] == 'True'){
                        if($json['imdbRating'] != 'N/A'){
                            return $json['imdbRating'];
                        }
                        else return null;
                    }
                    else return null;
                }
            } catch (ClientException $e) {
                dump("ClientException Request, IMDB");
                return null;
            } catch (ServerException $e){
                dump("ServerException Request, IMDB");
                return null;
            }
        }
        else return null;
    }

    private function insertMovie($movie){
        if($movie && $movie['adult'] == false){
            $movie['imdb_rating'] = $this->getImdbRating($movie['external_ids']['imdb_id']);
            $movie = $this->validate($movie);
            $dbMovie = Movie::firstOrCreate(['id' => $movie['id']],
            [
                'id' => $movie['id'],
                'title' => $movie['title'],
                'budget' => $movie['budget'],
                'backdrop_path' => $movie['backdrop_path'],
                'imdb_id' => $movie['imdb_id'],
                'original_language' => $movie['original_language'],
                'original_title' => $movie['original_title'],
                'overview' => $movie['overview'],
                'popularity' => $movie['popularity'],
                'poster_path' => $movie['poster_path'],
                'release_date' => $movie['release_date'],
                'revenue' => $movie['revenue'],
                'runtime' => $movie['runtime'],
                'status' => $movie['status'],
                'tagline' => $movie['tagline'],
                'video' => $movie['video'],
                'vote_average' => $movie['vote_average'],
                'vote_count' => $movie['vote_count'],
                'imdb_rating' => $movie['imdb_rating']
                ]); 
                $this->insertMovieGenres($movie, $dbMovie);
        }
    }

    private function insertMovieGenres($movie, $dbMovie){
        $genres = [];
        foreach($movie['genres'] as $genre){
            foreach($this->dbGenres as $dbGenre){
                if($genre['id'] == $dbGenre->id){
                    array_push($genres, $dbGenre->id);
                }
            }
        }
        $dbMovie->genres()->sync($genres);
    }  
    
    private function validate($movie){
        $movie['release_date'] = ($movie['release_date'] !== '') ? $movie['release_date'] : null;
        return $movie;
    }
}
