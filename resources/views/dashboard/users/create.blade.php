@extends('layouts.backend')

@section('title', 'Create User')

@section('content')
    <form action="{{ route('users-management.store') }}" method="POST">
        @include('partials.backend.users.form')
    </form>
@endsection
