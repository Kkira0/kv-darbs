@extends('layouts.app')

@section('title', 'Home')

@section('content')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<div class="container mt-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Sveicināti KILM!</h1>
        <p class="lead">Atrodiet filmas, kurās Jūs iemīlēsieties. Izvēlieties pēc iemīļotām kategorijām vai ģenerējiet nejaušu filmu.</p>
    </div>

    <ul class="nav nav-tabs mb-4" id="selectionTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="genre-tab" data-bs-toggle="tab" data-bs-target="#genre" type="button" role="tab">Žanri</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="rating-tab" data-bs-toggle="tab" data-bs-target="#rating" type="button" role="tab">Reitings</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="year-tab" data-bs-toggle="tab" data-bs-target="#year" type="button" role="tab">Izlaišanas gads</button>
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
        <h5>Izvēlētās kategorijas:</h5>
        <p id="selected-summary" class="text-muted fst-italic">Nekas nav vēl izvēlēts.</p>
    </div>

    <div class="text-center mb-5">
        <button type="button" class="btn btn-primary btn-lg shadow">Ģenerēt</button>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm film-card">
                <img src="{{ asset('pictures/placeholder.png') }}" class="card-img-top" alt="Film Poster">
                <div class="card-body">
                    <h5 class="card-title">Filmas virsraksts</h5>
                    <p class="card-text">Ģenerētās filmas informācija parādīsies, kad uzpiedīsiet pogu "Ģenerēt".</p>
                </div>
            </div>
             @auth
            <div class="text-center mt-3">
                <button id="markWatchedBtn" class="btn btn-success d-none">Atzīmēt kā noskatītu</button>
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
    const filmCard = document.querySelector('.film-card');
    const filmImg = filmCard.querySelector('img');
    const filmTitle = filmCard.querySelector('.card-title');
    const filmText = filmCard.querySelector('.card-text');
    @auth
    const markWatchedBtn = document.getElementById('markWatchedBtn');
    @endauth



    cards.forEach(card => card.addEventListener('click', () => {
        const { type, value } = card.dataset;
        const allCards = document.querySelectorAll(`[data-type="${type}"]`);


        if (value === 'Any') {
            if (selected[type].includes('Any')) {
                selected[type] = [];
                card.classList.remove('selected');
            } else {
                selected[type] = ['Any'];
                allCards.forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
            }
        }

        else {
            selected[type] = selected[type].filter(v => v !== 'Any');
            card.classList.toggle('selected');

            if (card.classList.contains('selected')) selected[type].push(value);
            else selected[type] = selected[type].filter(v => v !== value);
        }

        updateSummary();
    }));


    const updateSummary = () => {
        const g = selected.genre.length ? selected.genre.join(', ') : 'Any';
        const r = selected.rating.length ? selected.rating.join(', ') : 'Any';
        const y = selected.year.length ? selected.year.join(', ') : 'Any';
        summary.textContent = `Genre: ${g} • Rating: ${r} • Year: ${y}`;
    };


    generateBtn.addEventListener('click', async () => {
        try {
            const res = await fetch('{{ route("generate.film") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(selected)
            });

            const data = await res.json();

            if (data.error) return alert(data.error);

            filmImg.src = data.poster_path
                ? `https://image.tmdb.org/t/p/w600_and_h900_bestv2${data.poster_path}`
                : '{{ asset("pictures/placeholder.png") }}';
            filmTitle.textContent = data.title || 'Untitled';
            filmText.textContent = data.description || 'No description available.';
             @auth
            markWatchedBtn.dataset.movieId = data.id;
            markWatchedBtn.classList.remove('d-none');
            @endauth
        } catch (err) {
            console.error('Error:', err);
        }
    });

     @auth
    markWatchedBtn.addEventListener('click', async () => {
        const movieId = markWatchedBtn.dataset.movieId;
        try {
            const res = await fetch('{{ route("movie.markWatched") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ movie_id: movieId })
            });
            const data = await res.json();
            alert(data.message);
        } catch (err) {
            console.error('Error marking watched:', err);
        }
    });
    @endauth
});

</script>
@endsection
