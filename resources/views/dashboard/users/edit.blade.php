@extends('layouts.backend')

@section('title', 'Edit User')

@section('content')
    <form action="{{ route('users-management.update', $user->uid) }}" method="POST">
        @method('PUT')
        @include('partials.backend.users.form')
    </form>
@endsection
