@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="text-center mb-4">
        <i class="fas fa-leaf text-secondary mb-2" style="font-size: 2rem;"></i>
        <span>AgriTech</span>
        <h2 class="h4 text-dark mb-2">Login</h2>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif

    <form method="POST" action="/">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="nama@email.com"
                value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="********" required>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                <label class="form-check-label" for="rememberMe">Ingat saya</label>
            </div>
            <a href="#" class="text-muted">Lupa password?</a>
        </div>
        <button type="submit" class="btn btn-dark w-100">Masuk</button>
    </form>

    <p class="mt-3 text-center">
        Belum punya akun? <a href="/register">Daftar di sini</a>
    </p>

@endsection
