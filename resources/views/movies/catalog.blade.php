@extends('layouts.app')

@section('title', 'Katalogs')

@section('content')
<div class="container mt-5">
    <h1 class="fw-bold mb-4 text-center">Filmu katalogs</h1>

    <div class="row">
        @foreach ($movies as $movie)
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm h-100">

                    <a href="{{ route('movies.show', $movie->id) }}" class="text-decoration-none text-dark">
                        <img
                            src="https://image.tmdb.org/t/p/w300{{ $movie->poster_path }}"
                            class="card-img-top"
                            alt="{{ $movie->title }}"
                            style="cursor: pointer;"
                        >

                        <div class="card-body text-center">
                            <h6 class="fw-bold text-light" style="cursor: pointer;">
                                {{ $movie->title }}
                            </h6>
                            <p class="fw-bold text-secondary">{{ $movie->release_date }}</p>
                            <p class="fw-bold text-secondary">
                                {{ implode(', ', $movie->genres->pluck('name')->toArray()) }}
                            </p>
                        </div>
                    </a>

                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
