@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Create Admin</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.admins.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   class="w-full border border-gray-300 px-4 py-2 rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"
                   class="w-full border border-gray-300 px-4 py-2 rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" id="password"
            class="w-full border border-gray-300 px-4 py-2 rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
        </div>

        <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation"
           class="w-full border border-gray-300 px-4 py-2 rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
        </div>

        <div>
            <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
            <select name="role_id" id="role_id"
                    class="w-full border border-gray-300 px-4 py-2 rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
                <option value="">Select Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.admins.index') }}" class="px-4 py-2 text-gray-700 border border-gray-300 rounded hover:bg-gray-100">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create Admin</button>
        </div>
    </form>
</div>
@endsection
