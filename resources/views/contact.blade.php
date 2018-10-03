@extends('layouts.app')
@section('title', 'Contact')

@section('content')
<div id="contact-container">
    @if(count($errors) > 0)
        @foreach($errors->all() as $error)
            <div class="alert alert-danger">
                {{$error}}
            </div>
        @endforeach
    @endif
    @if(session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif
    <h1>Contact</h1>
    <form method="post" action="contact/submit">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Name">
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" name="email" class="form-control" placeholder="Email">
        </div>
        <div class="form-group">
            <label for="message">Message</label>
            <textarea type="text" name="message" class="form-control" rows="6" placeholder="Message"></textarea> 
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form> 
</div>
@endsection