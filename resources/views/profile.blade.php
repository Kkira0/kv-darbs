@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="card shadow-lg border-0">
    <div class="card-header bg-dark text-white">
      <h4 class="mb-0">Mans profils</h4>
    </div>
    <div class="card-body">
      <div class="row mb-4">
        <div class="col-md-6">
          <h5 class="fw-bold">Vārds:</h5>
          <p>{{ Auth::user()->name }}</p>
        </div>
        <div class="col-md-6">
          <h5 class="fw-bold">E-pasts:</h5>
          <p>{{ Auth::user()->email }}</p>
        </div>
        <a href="{{ route('profile.edit') }}" class="btn btn-dark mb-3">Rediģēt profilu</a>
      </div>

      <hr>

      <h5 class="fw-bold mb-3">Redzētas filmas</h5>

      @if ($watchedMovies->isEmpty())
        <div class="bg-light p-4 rounded text-center border">
          <p class="text-muted mb-2">Nav atzīmēta neviena jau noskatīta filma.</p>
        </div>
      @else
        <div class="row">
          @foreach ($watchedMovies as $entry)
            <div class="col-md-3 mb-4">
              <div class="card shadow-sm">
                <img src="https://image.tmdb.org/t/p/w300{{ $entry->movie->poster_path }}" class="card-img-top" alt="{{ $entry->movie->title }}">
                <div class="card-body text-center">
                  <h6>{{ $entry->movie->title }}</h6>
                  <p class="text-muted small">{{ $entry->movie->release_date }}</p>

                  <form action="{{ route('movie.unmarkWatched') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="movie_id" value="{{ $entry->movie->id }}">
                    <button type="submit" class="btn btn-sm btn-outline-danger mt-2"
                        onclick="return confirm('Vai tiešām vēlaties noņemt šo filmu no redzēto saraksta?')">
                        Noņemt no redzētajām
                    </button>
                  </form>

                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif

      <hr>

      <h5 class="fw-bold mb-3 mt-4">Plānots skatīties</h5>

      @if ($plannedMovies->isEmpty())
          <div class="bg-light p-4 rounded text-center border">
              <p class="text-muted mb-2">Nav pievienota neviena filma plānā skatīties.</p>
          </div>
      @else
          <div class="row">
              @foreach ($plannedMovies as $entry)
                  <div class="col-md-3 mb-4">
                      <div class="card shadow-sm">
                          <img src="https://image.tmdb.org/t/p/w300{{ $entry->movie->poster_path }}" class="card-img-top">
                          <div class="card-body text-center">
                              <h6>{{ $entry->movie->title }}</h6>
                              <p class="text-muted small">{{ $entry->movie->release_date }}</p>
                              <form action="{{ route('movie.convertPlanToWatched') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $entry->id }}">
                                <button type="submit" class="btn btn-sm btn-outline-success mt-2">
                                    Atzīmēt kā noskatītu
                                </button>
                            </form>
                          </div>
                      </div>
                  </div>
              @endforeach
          </div>
      @endif
    </div>
  </div>
</div>
@endsection
