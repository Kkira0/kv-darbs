@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="card shadow-lg border-0">
    <div class="card-header bg-dark text-white">
      <h4>Rediģēt profilu</h4>
    </div>
    <div class="card-body">
      <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label">Vārds</label>
          <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">E-pasts</label>
          <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Jauna parole (pēc izvēles)</label>
          <input type="password" name="password" class="form-control" placeholder="Atstājiet tukšu, lai saglabātu iepriekšējo">
        </div>
        <div class="mb-3">
          <label class="form-label">Atkārtoti parole</label>
          <input type="password" name="password_confirmation" class="form-control" placeholder="Atstājiet tukšu, lai saglabātu iepriekšējo">
        </div>
        <button type="submit" class="btn btn-dark">Saglabāt izmaiņas</button>
      </form>
    </div>
  </div>
</div>
@endsection
