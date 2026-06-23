@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="card shadow-lg" style="max-width: 400px; width: 100%;">
        <div class="card-body p-5">
            <h1 class="text-center mb-4">UNIMUS EduConnect</h1>
            <h3 class="text-center text-muted mb-4">Login</h3>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
            </form>
            
            <hr>
            <p class="text-center text-muted small">Demo Credentials:</p>
            <p class="text-center small">
                <strong>Admin:</strong> admin@unimus.ac.id<br>
                <strong>Dosen:</strong> dosen@unimus.ac.id<br>
                <strong>Mahasiswa:</strong> mahasiswa@unimus.ac.id<br>
                <strong>Password:</strong> password
            </p>
        </div>
    </div>
</div>
@endsection
