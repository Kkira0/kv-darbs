@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="card shadow-lg border-0">
    <div class="card-header bg-dark text-white">
      <h4 class="mb-0">My profile</h4>
    </div>
    <div class="card-body">
      <div class="row mb-4">
        <div class="col-md-6">
          <h5 class="fw-bold">Name:</h5>
          <p>{{ Auth::user()->name }}</p>
        </div>
        <div class="col-md-6">
          <h5 class="fw-bold">E-mail:</h5>
          <p>{{ Auth::user()->email }}</p>
        </div>
        <a href="{{ route('profile.edit') }}" class="btn btn-dark mb-3">Edit profile</a>
      </div>

      <hr>

      <h5 class="fw-bold mb-3">Movies seen</h5>

      @if ($watchedMovies->isEmpty())
        <div class="bg-light p-4 rounded text-center border">
          <p class="text-muted mb-2">No movies have been marked as already watched.</p>
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
                        onclick="return confirm('Are you sure you want to remove this movie from your watched list?')">
                        Remove from seen
                    </button>
                  </form>

                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif

      <hr>

      <h5 class="fw-bold mb-3 mt-4">Planned to watch</h5>

      @if ($plannedMovies->isEmpty())
          <div class="bg-light p-4 rounded text-center border">
              <p class="text-muted mb-2">No movies have been added to the plan to watch.</p>
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
                                    Mark as watched
                                </button>
                            </form>
                          </div>
                      </div>
                  </div>
              @endforeach
          </div>
      @endif

      <hr>

      <h5 class="fw-bold mb-3 mt-4">Liked movies</h5>

      @if ($likedMovies->isEmpty())
          <div class="bg-light p-4 rounded text-center border">
              <p class="text-muted mb-2">You haven't liked any movies yet.</p>
          </div>
      @else
          <div class="row">
              @foreach ($likedMovies as $entry)
                  <div class="col-md-3 mb-4">
                      <div class="card shadow-sm">
                          <img src="https://image.tmdb.org/t/p/w300{{ $entry->movie->poster_path }}"
                              class="card-img-top" alt="{{ $entry->movie->title }}">

                          <div class="card-body text-center">
                              <h6>{{ $entry->movie->title }}</h6>
                              <p class="text-muted small">{{ $entry->movie->release_date }}</p>

                              <!-- Remove Like = set preference to 0 -->
                              <form action="{{ route('movie.setPreference') }}" method="POST">
                                  @csrf
                                  <input type="hidden" name="movie_id" value="{{ $entry->movie->id }}">
                                  <input type="hidden" name="preference" value="0">
                                  <button type="submit" class="btn btn-sm btn-outline-danger mt-2">
                                      Remove like
                                  </button>
                              </form>

                          </div>
                      </div>
                  </div>
              @endforeach
          </div>
      @endif

      <hr>

      <h5 class="fw-bold mb-3 mt-4">Disliked movies</h5>

      @if ($dislikedMovies->isEmpty())
          <div class="bg-light p-4 rounded text-center border">
              <p class="text-muted mb-2">You haven't disliked any movies yet.</p>
          </div>
      @else
          <div class="row">
              @foreach ($dislikedMovies as $entry)
                  <div class="col-md-3 mb-4">
                      <div class="card shadow-sm">
                          <img src="https://image.tmdb.org/t/p/w300{{ $entry->movie->poster_path }}"
                              class="card-img-top" alt="{{ $entry->movie->title }}">

                          <div class="card-body text-center">
                              <h6>{{ $entry->movie->title }}</h6>
                              <p class="text-muted small">{{ $entry->movie->release_date }}</p>

                              <!-- Remove dislike = set preference to 0 -->
                              <form action="{{ route('movie.setPreference') }}" method="POST">
                                  @csrf
                                  <input type="hidden" name="movie_id" value="{{ $entry->movie->id }}">
                                  <input type="hidden" name="preference" value="0">
                                  <button type="submit" class="btn btn-sm btn-outline-danger mt-2">
                                      Remove dislike
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
