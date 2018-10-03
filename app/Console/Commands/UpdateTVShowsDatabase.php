<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Genre;
use App\Season;
use App\Episode;
use App\TVShow;
use Config\tmdbapi;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class UpdateTVShowsDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateTVShows';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates tvshows database';

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

    public function updateDatabase(){
        $start = 66058;
        $latest = 78686;
        $bar = $this->output->createProgressBar($latest-$start);
        for($id = $start; $id <= $latest; $id++){
            $tvshow = $this->getTVShow($id);
            $this->insertTVShow($tvshow);
            $bar->advance();
        }
        $bar->finish();
    }

    private function getTVShow($id, $appendToResponse = "videos,external_ids"){
        $max_attempt = 10;
        $retry = true;
        while($retry && $max_attempt > 0){  
            try {
                $res = $this->client->request('GET', 'https://api.themoviedb.org/3/tv/'.$id.'?api_key='.config('tmdbapi.key').'&language=en-US&append_to_response='.$appendToResponse, ['delay' => 100, 'connect_timeout' => 10]);
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
                return null;
            } catch (ServerException $e){
                return null;
            }
        }
        else return null;
    }
    
    private function insertTVShow($tvshow){
        if($tvshow){
            $tvshow['imdb_rating'] = $this->getImdbRating($tvshow['external_ids']['imdb_id']);
            $dbTVShow = TVShow::firstOrCreate(['id' => $tvshow['id']],
            [
                'id' => $tvshow['id'],
                'backdrop_path' => $tvshow['backdrop_path'],
                'first_air_date' => $tvshow['first_air_date'],
                'homepage' => $tvshow['homepage'],
                'in_production' => $tvshow['in_production'],
                'last_air_date' => $tvshow['last_air_date'],
                'name' => $tvshow['name'],
                'number_of_episodes' => $tvshow['number_of_episodes'],
                'number_of_seasons' => $tvshow['number_of_seasons'],
                'original_language' => $tvshow['original_language'],
                'original_name' => $tvshow['original_name'],
                'overview' => $tvshow['overview'],
                'popularity' => $tvshow['popularity'],
                'poster_path' => $tvshow['poster_path'],
                'status' => $tvshow['status'],
                'type' => $tvshow['type'],
                'vote_average' => $tvshow['vote_average'],
                'vote_count' => $tvshow['vote_count'],
                'imdb_rating' => $tvshow['imdb_rating']
                ]);

                $this->insertTVShowGenres($tvshow, $dbTVShow);
                $this->insertTVShowSeasons($tvshow, $dbTVShow);
            }
    }

    private function insertTVShowGenres($tvshow, $dbTVShow){
        $genres = [];
        foreach($tvshow['genres'] as $genre){
            foreach($this->dbGenres as $dbGenre){
                if($genre['name'] == 'Sci-Fi & Fantasy'){
                    $genre['name'] = 'Science Fiction & Fantasy';
                }
                if(strpos($genre['name'], $dbGenre->name) !== false) {
                    array_push($genres, $dbGenre->id);
                }
            }
        }
        $dbTVShow->genres()->sync($genres);
    }

    private function insertTVShowSeasons($tvshow, $dbTVShow){
        $appendToResponse = '';
        
        for($i = 1; $i <= $tvshow['number_of_seasons']; $i++){
            $appendToResponse .= 'season/'.$i.',';

            if($i%18 == 0 || $i == $tvshow['number_of_seasons']){
                $tvshow = $this->getTVShow($dbTVShow->id, $appendToResponse);
                $appendToResponse = '';

                //if($tvshow == null) break;

                foreach($tvshow as $key => $data){
                    if(str_contains($key, 'season/')){
                        if(!empty($data['episodes'])){
                            try{
                                Season::firstOrCreate(
                                    [
                                        'tvshow_id' => $tvshow['id'],
                                        'season_id' => $data['season_number'],
                                    ],
                                    [
                                        'tvshow_id' => $tvshow['id'],
                                        'season_id' => $data['season_number'],
                                        'air_date' => $data['air_date'],
                                        'name' => $data['name'],
                                        'overview' => $data['overview'],
                                        'poster_path' => $data['poster_path'],
                                        'season_number' => $data['season_number']
                                    ]);
                            } catch(QueryException $e){
                                return;
                            }

                            foreach($data['episodes'] as $episode){
                                try{
                                    Episode::firstOrCreate(
                                        [
                                            'tvshow_id' => $tvshow['id'],
                                            'season_id' => $data['season_number'],
                                            'episode_id' => $episode['episode_number'],
                                        ],
                                        [
                                            'tvshow_id' => $tvshow['id'],
                                            'season_id' => $data['season_number'],
                                            'episode_id' => $episode['episode_number'],
                                            'air_date' => $episode['air_date'],
                                            'name' => $episode['name'],
                                            'overview' => $episode['overview'],
                                            'still_path' => $episode['still_path'],
                                            'episode_number' => $episode['episode_number'],
                                            'season_number' => $episode['season_number'],
                                            'vote_average' => $episode['vote_average'],
                                            'vote_count' => $episode['vote_count']
                                        ]);
                                } catch(QueryException $e){
                                    return;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
