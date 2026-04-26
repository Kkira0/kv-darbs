@extends('layouts.app')

@section('title', 'Home')

@section('content')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<div class="container mt-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Welcome to KILM!</h1>
        <p class="lead">Find movies you'll fall in love with. Choose by favorite categories or generate a random movie.</p>
    </div>

    <ul class="nav nav-tabs mb-4" id="selectionTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="genre-tab" data-bs-toggle="tab" data-bs-target="#genre" type="button" role="tab">Genres</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="rating-tab" data-bs-toggle="tab" data-bs-target="#rating" type="button" role="tab">Rating</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="year-tab" data-bs-toggle="tab" data-bs-target="#year" type="button" role="tab">Release year</button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="genre" role="tabpanel">
            <div class="row g-4 mb-4">
                @php
                    $genres = ['Any', 'Adventure', 'Fantasy', 'Animation', 'Drama', 'Horror', 'Action', 'Comedy',
                    'History', 'Western', 'Thriller', 'Crime', 'Documentary', 'Science Fiction', 'Mystery',
                    'Music', 'Romance', 'Family', 'War', 'TV Movie'];
                @endphp
                @foreach ($genres as $genre)
                <div class="col-6 col-md-3">
                    <div class="card h-100 text-center shadow-sm selection-card" style="cursor: pointer;" data-type="genre" data-value="{{ $genre }}">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5 class="card-title">{{ $genre }}</h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="tab-pane fade" id="rating" role="tabpanel">
            <div class="row g-4 mb-4">
                @php
                    $ratings = [
                        'Any',
                        '9+ (Excellent)',
                        '8+ (Great)',
                        '7+ (Good)',
                        '6+ (Average)',
                        'Below 6 (Low Rated)'
                    ];
                @endphp
                @foreach ($ratings as $rating)
                <div class="col-6 col-md-3">
                    <div class="card h-100 text-center shadow-sm selection-card" style="cursor: pointer;" data-type="rating" data-value="{{ $rating }}">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5 class="card-title">{{ $rating }}</h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="tab-pane fade" id="year" role="tabpanel">
            <div class="row g-4 mb-4">
                @php
                    $years = ['Any', '2025', '2024', '2023', '2022', '2021', '2020', '2019', '2018', 'Before 2018'];
                @endphp
                @foreach ($years as $year)
                <div class="col-4 col-md-2">
                    <div class="card h-100 text-center shadow-sm selection-card" style="cursor: pointer;" data-type="year" data-value="{{ $year }}">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5 class="card-title">{{ $year }}</h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="text-center my-4">
        <h5>Selected categories:</h5>
        <p id="selected-summary" class="text-muted fst-italic">Nothing has been selected yet.</p>
    </div>

    <div class="text-center mb-5">
        <button type="button" class="btn btn-primary btn-lg shadow">Generate</button>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm film-card">
                <img src="{{ asset('pictures/placeholder.png') }}" class="card-img-top" alt="Film Poster">
                <div class="card-body">
                    <h5 class="card-title">Movie title</h5>
                    <p class="card-text">The generated movie information will appear when you click the "Generate" button.</p>
                </div>
            </div>
             @auth
            <div class="text-center mt-3">
                <button id="markWatchedBtn" class="btn btn-primary d-none">Mark as watched</button>
            </div>
            <div class="text-center mt-3">
                <button id="planBtn" class="btn btn-warning d-none">
                    Plan to watch
                </button>
            </div>
            <div class="text-center mt-3">
                <button id="likeBtn" class="btn btn-success d-none">Like</button>
                <button id="dislikeBtn" class="btn btn-danger d-none">Dislike</button>
            </div>
            @endauth
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const selected = { genre: [], rating: [], year: [] };

    const summary = document.getElementById('selected-summary');
    const cards = document.querySelectorAll('.selection-card');
    const generateBtn = document.querySelector('.btn.btn-primary');

    const filmImg = document.querySelector('.film-card img');
    const filmTitle = document.querySelector('.film-card .card-title');
    const filmText = document.querySelector('.film-card .card-text');

    let currentMovieId = null;

    @auth
    const markWatchedBtn = document.getElementById('markWatchedBtn');
    const planBtn = document.getElementById('planBtn');
    const likeBtn = document.getElementById('likeBtn');
    const dislikeBtn = document.getElementById('dislikeBtn');
    @endauth

    async function send(url, data) {
        const res = await axios.post(url, data);
        return res.data;
    }

    function updateSummary() {
        const g = selected.genre.length ? selected.genre.join(', ') : 'Any';
        const r = selected.rating.length ? selected.rating.join(', ') : 'Any';
        const y = selected.year.length ? selected.year.join(', ') : 'Any';
        summary.textContent = `Genre: ${g} • Rating: ${r} • Year: ${y}`;
    }

    cards.forEach(card => {
        card.addEventListener('click', () => {

            const type = card.dataset.type;
            const value = card.dataset.value;
            const allCards = document.querySelectorAll(`[data-type="${type}"]`);

            if (value === 'Any') {
                selected[type] = selected[type].includes('Any') ? [] : ['Any'];
                allCards.forEach(c => c.classList.remove('selected'));
                if (selected[type].length) card.classList.add('selected');
            } else {
                selected[type] = selected[type].filter(v => v !== 'Any');
                card.classList.toggle('selected');

                if (card.classList.contains('selected'))
                    selected[type].push(value);
                else
                    selected[type] = selected[type].filter(v => v !== value);
            }

            updateSummary();
        });
    });

    generateBtn.addEventListener('click', async () => {

        let data;

        try {
            const url = @auth 
                '{{ route("generate.film.auth") }}' 
            @else 
                '{{ route("generate.film") }}' 
            @endauth;

            data = await send(url, selected);
        } catch (e) {
            alert('Error loading movie');
            return;
        }

        if (data.error) {
            alert(data.error);
            return;
        }

        currentMovieId = data.id;

        filmImg.src = data.poster_path
            ? `https://image.tmdb.org/t/p/w600_and_h900_bestv2${data.poster_path}`
            : '{{ asset("pictures/placeholder.png") }}';

        filmTitle.textContent = data.title || 'Untitled';
        filmText.textContent = data.description || 'No description';

        @auth
        markWatchedBtn.dataset.movieId = data.id || "";
        planBtn.dataset.movieId = data.id || "";
        likeBtn.dataset.movieId = data.id || "";
        dislikeBtn.dataset.movieId = data.id || "";

        markWatchedBtn.classList.remove('d-none');
        planBtn.classList.remove('d-none');
        likeBtn.classList.remove('d-none');
        dislikeBtn.classList.remove('d-none');
        @endauth
    });

    filmImg.style.cursor = 'pointer';

    filmImg.addEventListener('click', () => {
        if (currentMovieId) {
            window.location.href = `/movie/${currentMovieId}`;
        }
    });

    @auth
    async function action(url, movieId, extra = {}, type = '') {
        try {
            const data = await send(url, { movie_id: movieId, ...extra });
            
             if (data.status === 'exists') {
                const messages = {
                    watched: 'Already marked as watched',
                    like: 'Already liked',
                    dislike: 'Already disliked',
                    plan: 'Already in plan to watch'
                };

                filmText.textContent = messages[type] || 'Already exists';
                return;
            }
        } catch (e) {
            alert('Error');
        }
    }

    markWatchedBtn.onclick = () =>
        action('{{ route("movie.markWatched") }}', markWatchedBtn.dataset.movieId, {}, 'watched');

    planBtn.onclick = () =>
        action('{{ route("movie.togglePlan") }}', planBtn.dataset.movieId, {}, 'plan');

    likeBtn.onclick = () =>
        action('{{ route("movie.setPreference") }}', likeBtn.dataset.movieId, { preference: 1 }, 'like');

    dislikeBtn.onclick = () =>
        action('{{ route("movie.setPreference") }}', dislikeBtn.dataset.movieId, { preference: -1 }, 'dislike');
    @endauth

});
</script>

@endsection