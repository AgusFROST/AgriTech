@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
    <h2 class="h4 text-dark mb-3 text-center">Buat Password Baru</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ request()->email }}">

        <div class="mb-3">
            <label for="password">Password Baru</label>
            <input id="password" type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-dark w-100">Reset Password</button>
    </form>
@endsection
