@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <h2 class="mb-4 fw-bold text-center">Filmu katalogs</h2>

  @if($movies->isEmpty())
    <div class="alert alert-info text-center">
      Nav pievienotu filmu datubāzē.
    </div>
  @else
    <div class="row">
      @foreach($movies as $movie)
        <div class="col-md-3 mb-4">
          <div class="card shadow-sm h-100">
            <img src="https://image.tmdb.org/t/p/w300{{ $movie->poster_path }}"
                 class="card-img-top"
                 alt="{{ $movie->title }}">
            <div class="card-body text-center">
              <h6 class="fw-bold">{{ $movie->title }}</h6>
              <p class="text-muted small mb-2">{{ $movie->release_date }}</p>
              <p class="text-truncate small">{{ $movie->description }}</p>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection
