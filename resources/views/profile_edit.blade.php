@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="card shadow-lg border-0">
    <div class="card-header bg-dark text-white">
      <h4>Edit profile</h4>
    </div>
    <div class="card-body">
      <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">E-mail</label>
          <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">New password (optional)</label>
          <input type="password" name="password" class="form-control" placeholder="Leave blank to keep previous">
        </div>
        <div class="mb-3">
          <label class="form-label">Repeat the password</label>
          <input type="password" name="password_confirmation" class="form-control" placeholder="Leave blank to keep previous">
        </div>
        <button type="submit" class="btn btn-dark">Save changes</button>
      </form>
    </div>
  </div>
</div>
@endsection
