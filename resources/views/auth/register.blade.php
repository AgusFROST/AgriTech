@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="text-center mb-4">
        <i class="fas fa-leaf text-secondary mb-2" style="font-size: 2rem;"></i>
        <h2 class="h4 text-dark mb-2">Registrasi ke Sistem</h2>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/register">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Nama lengkap"
                value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="nama@email.com"
                value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="********" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                placeholder="********" required>
        </div>
        <button type="submit" class="btn btn-dark w-100">Daftar</button>
    </form>

    <p class="mt-3 text-center">
        Sudah punya akun? <a href="/">Login di sini</a>
    </p>

@endsection
