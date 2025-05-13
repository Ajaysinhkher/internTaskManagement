@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Create Role</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.roles.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Role Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   class="w-full border border-gray-300 px-4 py-2 rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
        </div>

        <div>
            <label class="flex items-center space-x-2">
                <input type="checkbox" name="is_super_admin" value="1" {{ old('is_super_admin') ? 'checked' : '' }}
                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring focus:ring-blue-200">
                <span class="text-sm text-gray-700">Is Super Admin</span>
            </label>
        </div>
        <div>
            <h2 class="text-sm font-medium text-gray-700 mb-2">Assign Permissions</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
                @foreach($permissions as $permission)
                    <label class="flex items-center space-x-2 bg-gray-50 p-2 rounded border">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                               {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                               class="text-blue-600 border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200">
                        <span class="text-sm text-gray-800">{{ $permission->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 text-gray-700 border border-gray-300 rounded hover:bg-gray-100">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create Role</button>
        </div>
    </form>
</div>
@endsection
