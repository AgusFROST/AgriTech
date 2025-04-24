@extends('layouts.backend')

@section('title', 'Users Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">

        <a href="{{ route('users-management.create') }}" class="btn btn-primary">Add User</a>
    </div>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('users-management.index') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="search" name="search" class="form-control" placeholder="Search name or email..."
                value="{{ request('search') }}">
        </div>
        <div class="col-md-auto">
            <button type="submit" class="btn btn-secondary">Search</button>
            <a href="{{ route('users-management.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Users Table --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->name }}</td>
                        <td>
                            <a href="{{ route('users-management.edit', $user->uid) }}"
                                class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('users-management.destroy', $user->uid) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Tidak ada data ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
@endsection
