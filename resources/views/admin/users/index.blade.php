@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Manage Users</h1>
    <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Add New User</a>
</div>

@if (session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
@elseif (session('error'))
    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
        {{ session('error') }}
    </div>
@endif

<table class="min-w-full bg-white shadow-md rounded overflow-hidden">
    <thead class="bg-gray-100 border-b">
        <tr>
            <th class="text-left px-6 py-3">#ID</th>
            <th class="text-left px-6 py-3">Name</th>
            <th class="text-left px-6 py-3">Email</th>
            <th class="text-left px-6 py-3">Role</th>
            <th class="text-left px-6 py-3">Created At</th>
            <th class="text-left px-6 py-3">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
        <tr class="border-b hover:bg-gray-50">
            <td class="px-6 py-4">{{ $user->id }}</td>
            <td class="px-6 py-4">{{ $user->name }}</td>
            <td class="px-6 py-4">{{ $user->email }}</td>
            <td class="px-6 py-4">{{ $user->role ?? 'N/A' }}</td>
            <td class="px-6 py-4">{{ $user->created_at->format('d M Y') }}</td>
            <td class="px-6 py-4 flex space-x-2">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Delete this user?')">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center px-6 py-4">No users found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
