@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto mt-6 bg-white p-6 rounded shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Create New User</h2>

    @if (session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST" id="createUserForm" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="block font-medium text-gray-700">Full Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('name')
                <small class="text-red-500">{{ $message }}</small>
            @enderror
        </div>

        <div>
            <label for="email" class="block font-medium text-gray-700">Email Address <span class="text-red-500">*</span></label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" 
                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('email')
                <small class="text-red-500">{{ $message }}</small>
            @enderror
        </div>

        <div>
            <label for="password" class="block font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
            <input type="password" name="password" id="password" 
                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('password')
                <small class="text-red-500">{{ $message }}</small>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block font-medium text-gray-700">Confirm Password <span class="text-red-500">*</span></label>
            <input type="password" name="password_confirmation" id="password_confirmation" 
                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        {{-- <div>
            <label for="role" class="block font-medium text-gray-700">Role (optional)</label>
            <input type="text" name="role" id="role" value="{{ old('role') }}"
                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('role')
                <small class="text-red-500">{{ $message }}</small>
            @enderror
        </div> --}}

        <div class="flex space-x-3">
            <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700">Create User</button>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-300 text-gray-800 px-5 py-2 rounded hover:bg-gray-400">Cancel</a>
        </div>
    </form>
</div>

<script>
    $(document).ready(function(){
        $('#createUserForm').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                }
            },
            messages: {
                name: {
                    required: "Please enter your full name.",
                    minlength: "Your name must be at least 3 characters long."
                },
                email: {
                    required: "Please enter your email address.",
                    email: "Please enter a valid email address."
                },
                password: {
                    required: "Please enter your password.",
                    minlength: "Your password must be at least 6 characters long."
                },
                password_confirmation: {
                    required: "Please confirm your password.",
                    equalTo: "Passwords do not match."
                }
            },
            errorElement: 'small',
            errorClass: 'text-red-500',
            highlight: function (element) {
                $(element).addClass('border-red-500');
            },
            unhighlight: function (element) {
                $(element).removeClass('border-red-500');
            }
        });
    })
</script>
@endsection
