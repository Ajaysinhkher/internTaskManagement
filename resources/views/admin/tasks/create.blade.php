@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-semibold mb-4">Create New Task</h2>

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.tasks.store') }}" id="createTaskForm">
        @csrf

        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full mt-1 border rounded p-2" >
            @error('title')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4" class="w-full mt-1 border rounded p-2" >{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="w-full mt-1 border rounded p-2" >
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            @error('status')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
            <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" class="w-full mt-1 border rounded p-2" >
            @error('due_date')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="user_id" class="block text-sm font-medium text-gray-700">Assign to Users</label>
            <select name="user_id[]" id="user_id" class="w-full mt-1 border rounded p-2" multiple >
                <option value="">-- Select Users --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ in_array($user->id, old('user_id', [])) ? 'selected' : '' }}>
                        {{ $user->name }} 
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>
        

        <div class="mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create Task</button>
            <a href="{{ route('admin.tasks.index') }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#createTaskForm').validate({
            rules: {
                title: {
                    required: true,
                    minlength: 3
                },
                description: {
                    required: true,
                    minlength: 5
                },
                status: {
                    required: true
                },
                due_date: {
                    required: true,
                    date: true
                },
                'user_id[]': {
                    required: true
                }
            },
            messages: {
                title: {
                    required: "Please enter a title.",
                    minlength: "Title must be at least 3 characters long."
                },
                description: {
                    required: "Please enter a description.",
                    minlength: "Description must be at least 5 characters long."
                },
                status: {
                    required: "Please select a status."
                },
                due_date: {
                    required: "Please select a due date.",
                    date: "Please enter a valid date."
                },
                'user_id[]': {
                    required: "Please select at least one user."
                }
            },
            errorElement: 'span',
            errorClass: 'text-red-500 text-sm',
            highlight: function (element) {
                $(element).addClass('border-red-500');
            },
            unhighlight: function (element) {
                $(element).removeClass('border-red-500');
            }
        });
    });
</script>
@endsection
