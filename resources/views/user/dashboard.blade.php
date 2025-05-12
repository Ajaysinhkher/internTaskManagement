
@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow mt-15">
        <h2 class="text-2xl font-bold mb-4">Dashboard</h2>

        <p class="mb-4">Welcome, {{ Auth::user()->name }}!</p>

        <h3 class="text-xl font-semibold mb-2">Your Tasks</h3>
        {{-- @if($tasks->isEmpty())
            <p>No tasks available.</p>
        @else
            <ul class="list-disc pl-5">
                @foreach($tasks as $task)
                    <li class="mb-2">{{ $task->title }}</li>
                @endforeach
            </ul>
        @endif --}}
    </div>