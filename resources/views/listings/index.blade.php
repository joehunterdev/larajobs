@extends('layouts.app')
@section('content')
<x-hero></x-hero>

<section class="container mx-auto px-6 p-10">
    <h2 class="text-4xl font-bold text-center text-gray-800 mb-8">
        Latest job listings
    </h2>

    <div class="container px-4 d-flex justify-content-center flex-wrap">
        
        @foreach($tags as $tag)
        <a href="{{ route('listing.index', ['tag' => $tag->slug]) }}" class="btn btn-default background-default-subtle border-solid bg-none m-2 {{ $tag->slug === request()->get('tag') ? 'btn-primary' : 'btn-secondary' }}">#{{ $tag->name }}</a>
        @endforeach
    </div>
    <div class="container px-4">

        @foreach($listings as $listing)
        <div class="card mb-4 d-flex flex-row {{ $listing->is_highlighted ? 'bg-success-subtle' : '' }}">
            <div class="d-flex justify-content-start">
                <img class="card-img" src="{{ $listing->logo }}" alt="{{$listing->title}}" style="max-width: 150px;">
            </div>
            <div class="card-body">
                <h3 class="card-title">{{ $listing->title }}</h3>
                <p class="card-text">{{ $listing->description }}</p>
                <p class="card-text"> @foreach($listing->tags as $tag)
                    <a class="btn btn-default border-solid bg-none m-2 {{ $tag->slug === request()->get('tag') ? 'btn-primary' : 'btn-secondary' }}">#{{ $tag->name }}</a>
                    @endforeach
                <p class="card-text">Location: {{ $listing->location }}</p>
                <p class="card-text">Created: {{ $listing->created_at->diffForHumans() }}</p>
            </div>
        </div>
        @endforeach

    </div>
</section>
@endsection