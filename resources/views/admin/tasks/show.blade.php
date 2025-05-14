@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Task Details</h2>

    <div class="mb-6">
        <h3 class="text-xl font-semibold">{{ $task->title }}</h3>
        <p class="text-gray-700 mt-2">{{ $task->description }}</p>
        <div class="mt-4 text-sm text-gray-600">
            <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $task->status)) }}</p>
            <p><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</p>
        </div>
    </div>

    <hr class="my-6">

    <h3 class="text-lg font-semibold mb-2">Comments</h3>

    @if ($task->comments->isEmpty())
        <p class="text-gray-500">No comments yet.</p>
    @else
        <div class="space-y-4 mb-6">
            @foreach($task->comments as $comment)
                <div class="bg-gray-100 p-3 rounded">
                    <p class="text-sm text-gray-800">{{ $comment->message }}</p>
                    <div class="text-xs text-gray-600 mt-1">
                        @php
                            $type = class_basename($comment->commentable_type); // e.g., "User" or "Admin"
                        @endphp
                        — {{ $comment->commentable->name ?? 'Unknown' }} ({{ $type }}) | {{ $comment->created_at->diffForHumans() }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.comments.store') }}">
        @csrf
        <input type="hidden" name="task_id" value="{{ $task->id }}">

        <div class="mb-4">
            <label for="message" class="block text-sm font-medium text-gray-700">Add Comment</label>
            <textarea name="message" id="message" rows="3" required
                class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring focus:ring-blue-200"></textarea>
        </div>

        <div class="flex items-center space-x-4 mt-4">
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Submit Comment</button>
            <a href="{{ route('admin.tasks.index')}}" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Cancel</a>
        </div>
    </form>
</div>
@endsection
