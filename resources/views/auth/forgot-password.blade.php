@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')
    <h2 class="h4 text-dark mb-3 text-center">Reset Password</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-dark w-100">Kirim Link Reset</button>
    </form>

    <p class="mt-3 text-center"><a href="{{ route('login') }}">Kembali ke login</a></p>
@endsection
