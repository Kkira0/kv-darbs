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

      <div class="bg-light p-4 rounded text-center border">
        <p class="text-muted mb-2">Nav atzīmēta neviena jau noskatīta filma.</p>
        <button class="btn btn-dark">Pievienot filmu</button>
      </div>
    </div>
  </div>
</div>
@endsection
