@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6">
    <h1 class="text-xl font-semibold mb-5 text-gray-800">Chats with Users</h1>

    @if ($users->count())
        <ul class="space-y-3">
            @foreach ($users as $user)
                <li class="flex justify-between items-center p-3 border border-gray-200 rounded-md shadow-sm hover:shadow transition-shadow duration-200">
                    <span class="text-base text-gray-800">{{ $user->name }}</span>
                    <a href="{{ route('admin.chat.show', $user->id) }}" 
                       class="text-sm text-blue-600 hover:text-blue-800 font-medium hover:underline focus:outline-none focus:ring-1 focus:ring-blue-400 rounded">
                        View Chat
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500 text-sm">No chats with users yet.</p>
    @endif
</div>
@endsection
