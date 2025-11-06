@extends('layouts.app')

@section('title', $movie->title)

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-4">
            <img src="https://image.tmdb.org/t/p/w500{{ $movie->poster_path }}"
                 class="img-fluid rounded shadow-sm"
                 alt="{{ $movie->title }}">
        </div>

        <div class="col-md-8">
            <h2 class="fw-bold">{{ $movie->title }}</h2>
            <p class="fw-bold text-muted mb-1">Iznākšanas datums: {{ $movie->release_date }}</p>
            <p><strong>Reitings:</strong> {{ $movie->vote_average }}/10</p>
            <p><strong>Žanri:</strong> {{ implode(', ', $movie->genres->pluck('name')->toArray()) }}</p>

            <hr>

            <p class="mt-3">{{ $movie->description ?? 'Apraksts nav pieejams.' }}</p>
        </div>
    </div>

    <hr class="my-4">

    <div class="row">
        <div class="col-md-6">
            <h4 class="fw-bold mb-3 text-info">Aktieri</h4>
            <ul class="ps-3">
                @forelse ($movie->actors as $actor)
                    <li>
                        {{ $actor->name }}
                        @if($actor->pivot->character)
                            <span class="text-muted small">kā <em>{{ $actor->pivot->character }}</em></span>
                        @endif
                    </li>
                @empty
                    <li class="text-muted">Nav pieejama informācija par aktieriem.</li>
                @endforelse
            </ul>
        </div>

        <div class="col-md-6">
            <h4 class="fw-bold mb-3 text-info">Komanda</h4>
            <ul class="ps-3">
                @forelse ($movie->crew as $member)
                    <li>
                        {{ $member->name }}
                        <span class="text-muted small">— {{ $member->pivot->role }}</span>
                    </li>
                @empty
                    <li class="text-muted">Nav pieejama informācija par komandu.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
