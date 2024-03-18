@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $listing->title }}</h1>
            {!!$listing->content!!}
            <p><strong>Tags:</strong>
                @foreach($listing->tags as $tag)
                <span class="badge bg-secondary">{{ $tag->name }}</span>
                @endforeach
            </p>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="{{ $listing->logo }}" alt="{{ $listing->title }}" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">{{ $listing->title }}</h5>
                    <p><strong>Company:</strong> {{ $listing->company }}</p>
                    <p><strong>Location:</strong> {{ $listing->location }}</p>
                    <a href="{{ route('listings.apply', $listing->slug) }}" class="btn btn-primary">Apply Now</a>                    {{$listing->slug}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection