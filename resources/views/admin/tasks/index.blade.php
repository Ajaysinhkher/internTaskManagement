@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Manage Tasks</h1>
    <a href="{{ route('admin.tasks.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Create Task</a>
</div>

@if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
@endif

<table class="min-w-full bg-white shadow-md rounded overflow-hidden">
    <thead class="bg-gray-100 border-b">
        <tr>
            <th class="text-left px-6 py-3">Title</th>
            <th class="text-left px-6 py-3">Description</th>
            <th class="text-left px-6 py-3">Status</th>
            <th class="text-left px-6 py-3">Due Date</th>
            <th class="text-left px-6 py-3">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($tasks as $task)
        <tr class="border-b hover:bg-gray-50">
            <td class="px-6 py-4">{{ $task->title }}</td>
            <td class="px-6 py-4">{{ Str::limit($task->description, 50) }}</td>
            <td class="px-6 py-4">{{ ucfirst($task->status) }}</td>
            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}</td>
            <td class="px-6 py-4 flex space-x-2">
                <a href="{{ route('admin.tasks.edit', $task->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                <form method="POST" action="{{ route('admin.tasks.destroy', $task->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Delete</button>
                </form>

                <a href="{{ route('admin.tasks.show', $task->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">View</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center px-6 py-4">No tasks found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
