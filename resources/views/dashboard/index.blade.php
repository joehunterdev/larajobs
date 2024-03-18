@extends('layouts.app')
@section('content')
<section>
    <div class="container px-4">
        <h1>Dashboard</h1>
        <p>Logged In!</p>
    </div>
    <div class="container mx-auto px-6 p-10">
        @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
        @if($message = session('message'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
        @endif
    </div>
    <div class="container mx-auto px-6 p-10">
        <h2>Created Listings</h2>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Logout</button>
        </form>
        @foreach($listings as $listing)
        <div href="{{ route('listing.show', $listing->slug) }}">
            <div class="card mb-4 d-flex flex-row {{ $listing->is_highlighted ? 'bg-success-subtle' : '' }}">
                <div class="d-flex justify-content-start">
                    <!-- <img class="card-img" src="{{ $listing->logo }}" alt="{{$listing->title}}" style="max-width: 150px;"> -->
                </div>
                <div class="card-body">
                    <h3 class="card-title">{{ $listing->title }}</h3>
                    <p class="card-text">{!! $listing->content !!}</p>
                    <p class="card-text"> @foreach($listing->tags as $tag)
                        <a class="badge border-solid bg-secondary m-2 {{ $tag->slug === request()->get('tag') ? 'btn-primary' : 'btn-secondary' }}">#{{ $tag->name }}</a>
                        @endforeach
                    <p class="card-text">Location: {{ $listing->location }}</p>
                    <p class="card-text">Created: {{ $listing->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
        @endforeach

    </div>

</section>

@endsection