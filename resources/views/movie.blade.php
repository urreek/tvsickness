@extends('layouts.app')
@section('title')
    {{$movie->title}}
@endsection
@section('content')
<div class="movie-layout">
    <div class="movie-header page-header">
        <h1><strong>{{$movie->title}}</strong> <small>{{$movie->release_date}}</small></h1>
        <small>{{$movie->tagline}}</small>
    </div>
    <div class="movie-poster">
        <img class="z-depth-3" src="https://image.tmdb.org/t/p/w500{{$movie->poster_path}}">
    </div>
    <div class="z-depth-3 movie-backdrop" style="background-image: url('https://image.tmdb.org/t/p/w500{{$movie->backdrop_path}}'); ">
    </div>
    <div class="movie-overview z-depth-3">
        <div class="jumbotron">
            <p class="lead">{{$movie->overview}}</p>
            <hr>
            <p><strong>IMDb Rating:</strong> {{$movie->imdb_rating}} <span class="glyphicon glyphicon-star yellow" aria-hidden="true"></span><p>
            <p><strong>Status:</strong> <span class="label label-success">{{$movie->status}}</span></p>
            <p><strong>Release date:</strong> {{$movie->release_date}}<p>
            <hr>
            <p><strong>Runtime:</strong> {{$movie->runtime ? $movie->runtime : "0"}} min<p>
            <p><strong>Budget:</strong> ${{$movie->budget}}<p>
            <p><strong>Revenue:</strong> ${{$movie->revenue}}<p>
        </div>
    </div>
</div>
@endsection