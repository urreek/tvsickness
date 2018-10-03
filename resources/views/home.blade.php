@extends('layouts.app')
@section('title', 'Home')
@section('content')

<div class="page-header">
  <h1>Home</h1>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h4>Now Playing Movies</h4>
  </div>
  <div class="panel-body">
    <div class="home-grid">
        @foreach($nowPlaying as $movie)
            <div class="grid-item">
                <a href="/movies/{{$movie->id}}">
                    <img src="https://image.tmdb.org/t/p/w185{{$movie->poster_path}}" class="img-responsive img-thumbnail z-depth-4" alt="No image found">
                </a>
            </div>
        @endforeach
    </div>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h4>Upcoming Movies</h4>
  </div>
  <div class="panel-body">
    <div class="home-grid">
        @foreach($upcoming as $movie)
            <div class="grid-item">
                <a href="/movies/{{$movie->id}}">
                    <img src="https://image.tmdb.org/t/p/w185{{$movie->poster_path}}" class="img-responsive img-thumbnail z-depth-4" alt="No image found">
                </a>
            </div>
        @endforeach
    </div>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h4>New TV Shows</h4>
  </div>
  <div class="panel-body">
    <div class="home-grid">
        @foreach($newTVShows as $tvshow)
            <div class="grid-item">
                <a href="/tvshows/{{$tvshow->id}}">
                    <img src="https://image.tmdb.org/t/p/w185{{$tvshow->poster_path}}" class="img-responsive img-thumbnail z-depth-4" alt="No image found">
                </a>
            </div>
        @endforeach
    </div>
  </div>
</div>
@endsection