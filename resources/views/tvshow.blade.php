@extends('layouts.app')
@section('title')
    {{$tvshow->name}}
@endsection
@section('content')
<div class="tvshow-layout">
    <div class="tvshow-header page-header">
        <h1><strong>{{$tvshow->name}}</strong> <small>{{$tvshow->first_air_date}}</small></h1>
    </div>
    <div class="tvshow-poster z-depth-3">
        <img src="https://image.tmdb.org/t/p/w500{{$tvshow->poster_path}}" alt="No image found">
    </div>
    <div class="z-depth-3 tvshow-backdrop" style="background-image: url('https://image.tmdb.org/t/p/w500{{$tvshow->backdrop_path}}'); ">
    </div>
    <div class="tvshow-overview z-depth-3">
        <div class="jumbotron">
            <p class="lead">{{$tvshow->overview}}</p>
            <hr>
            <p><strong>IMDb Rating:</strong> {{$tvshow->imdb_rating}} <span class="glyphicon glyphicon-star yellow" aria-hidden="true"></span><p>
            <p><strong>Next Episode:</strong>
                @if($nextEpisode)
                    <span class="label label-success">{{$nextEpisode->air_date}}</span>
                @else
                    @if($tvshow->status == 'Canceled')  
                        <span class="label label-danger">Canceled</span>
                    @elseif($tvshow->status == 'Ended')  
                        <span class="label label-warning">Ended</span>
                    @elseif($tvshow->status == 'Returning Series')
                        <span class="label label-success">Returning</span>
                    @endif
                @endif              
            </p>
            @if($previousEpisode)
                <p><strong>Previous Episode:</strong> <span class="label label-primary">{{$previousEpisode->air_date}}</span></p>
            @endif 
            <hr>
            <!--<p><strong>Network:</strong> Netflix</p>-->
            <p><strong>Seasons:</strong> {{$tvshow->number_of_seasons}}</p>
            <p><strong>Episodes:</strong> {{$tvshow->number_of_episodes}}</p>
        </div>
    </div>
</div>
@endsection