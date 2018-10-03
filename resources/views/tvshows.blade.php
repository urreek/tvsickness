@extends('layouts.app')
@section('title', 'TVShows')
@section('content')
<div class="page-header">
  <h1>TV Shows</h1>
</div>
<div class="sidebar-layout">
  <div class="sidebar">
    <div class="panel panel-default z-depth-3">
      <div class="panel-heading">
        <h2 class="panel-title">Genres</h2>
      </div>
      <ul>
        @foreach($genres as $genre)
          <li>
            <a class="btn-link btn-sm" href="/tvshows?genres={{$genre->id}}">{{$genre->name}}</a>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
  <div class="content">
    <div class="grid">
      @foreach($tvshows as $tvshow)
        <div class="grid-item">
          <a href="/tvshows/{{$tvshow->id}}">
            <img src="https://image.tmdb.org/t/p/w185{{$tvshow->poster_path}}" class="img-responsive img-thumbnail z-depth-4" alt="No image found">
          </a>
        </div>
      @endforeach
    </div>
    <div class="text-center">
      {{$tvshows->appends(request()->except('page'))->links()}}
    </div>
  </div>
</div>
@endsection