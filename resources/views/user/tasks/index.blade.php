@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow-md">
    <h2 class="text-2xl font-semibold mb-4">My Tasks</h2>

    @if ($tasks->isEmpty())
        <p class="text-gray-600">You have no tasks assigned yet.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Description</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Due Date</th>
                        <th class="px-4 py-3">Assigned By</th>
                        <th class="px-4 py-3">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr class="border-t text-sm text-gray-700 hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $task->title }}</td>
                            <td class="px-4 py-3">{{$task->description}}</td>
                            {{-- <td class="px-4 py-3">{{$task->assignedBy->name ?? 'Unknown'}}</td> --}}
                            <td class="px-4 py-3">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'in_progress' => 'bg-blue-100 text-blue-800',
                                        'completed' => 'bg-green-100 text-green-800'
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$task->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</td>
                            <td class="px-4 py-3">{{$task->assignedBy->name ?? 'Unknown'}}</td>
                            <td class="px-4 py-3"><a href = "{{ route('tasks.show',$task->id) }} "> View Details </td>
                    
                      

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
 

</div>
@endsection


