@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container mt-5" style="max-width: 600px;">
    <h2 class="mb-4">Reģistrācija</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Lietotāja vārds</label>
            <input name="username" class="form-control" value="{{ old('username') }}" required />
        </div>

        <div class="mb-3">
            <label class="form-label">E-pasts</label>
            <input name="email" type="email" class="form-control" value="{{ old('email') }}" required />
        </div>

        <div class="mb-3">
            <label class="form-label">Parole</label>
            <input name="password" type="password" class="form-control" required minlength="6" />
        </div>

        <div class="mb-3">
            <label class="form-label">Atkārtoti parole</label>
            <input name="password_confirmation" type="password" class="form-control" required minlength="6" />
        </div>

        <button type="submit" class="btn btn-primary w-100">Reģistrēties</button>
    </form>

    <p class="mt-3 text-center">
        Jau eksistē konts? <a href="{{ route('login') }}">Login</a>
    </p>
</div>
@endsection
