@extends('layouts.app')
@section('content')
<section>
    <div class="container px-4">
        <h1>Dashboard</h1>
        <p>Logged In!</p>
    </div>
    <div class="container mx-auto px-6 p-10">
        <h2>Created Listings</h2>
        <ul>
            {{$listings}}
            @foreach($listings as $listing)
            <li><a href="/listings/{{$listing->slug}}">{{$listing->title}}</a></li>
            @endforeach
    </div>
</section>

@endsection