@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-3 py-4">
    <h1 class="text-xl font-semibold mb-4 text-gray-900">Chat with Admins</h1>

    <ul class="space-y-2">
        @foreach ($admins as $admin)
            <li class="flex justify-between items-center p-3 border border-gray-200 rounded-md shadow-sm hover:shadow transition-shadow duration-200">
                <span class="text-base text-gray-800">{{ $admin->name }}</span>
                <a href="{{ route('chat.show', $admin->id) }}" 
                   class="text-sm text-blue-600 hover:text-blue-800 font-medium hover:underline focus:outline-none focus:ring-1 focus:ring-blue-400 rounded">
                    View Chat
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
