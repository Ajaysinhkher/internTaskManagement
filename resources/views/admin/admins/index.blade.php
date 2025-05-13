@extends('layouts.admin')

@section('content')
    <div class="container mx-auto py-6 px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Manage Admins</h1>
            <a href="{{ route('admin.admins.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Add New Admin</a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white border border-gray-200 shadow-sm rounded-lg">
            <table class="min-w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">#</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Role</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $admin)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $admin->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $admin->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $admin->role->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 flex space-x-2">
                                <a href="{{ route('admin.admins.edit', $admin->id) }}" class="text-blue-500 hover:text-blue-700">Edit</a>

                                <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this admin?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($admins->isEmpty())
            <div class="mt-4 text-center text-gray-500">No admins found.</div>
        @endif

      
    </div>
@endsection
