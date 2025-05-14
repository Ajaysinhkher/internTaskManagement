@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Register</h2>

        <form method="POST" action="{{ route('register.post') }}" id="registerForm">
            @csrf

            <div class="mb-4">
                <label class="block">Name</label>
                <input type="text" name="name" class="w-full border p-2 rounded" value="{{ old('name') }}" >
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block">Email</label>
                <input type="email" name="email" class="w-full border p-2 rounded" value="{{ old('email') }}" >
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block">Password</label>
                <input type="password" name="password" class="w-full border p-2 rounded" >
                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full border p-2 rounded" >
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Register
            </button>
        </form>
    </div>

    <script>
        $(document).ready(function(){
            $('#registerForm').validate({
                rules:{
                    name:{
                        required:true,
                        minlength:2
                    },
                    email:{
                        required:true,
                        email:true
                    },
                    password:{
                        required:true,
                        minlength:6
                    },
                    password_confirmation:{
                        required:true,
                        equalTo: '[name="password"]'
                    }
                },
                messages:{
                    name:{
                        required:"Please enter your name.",
                        minlength:"Your name must be at least 2 characters long."
                    },
                    email:{
                        required:"Please enter your email address.",
                        email:"Please enter a valid email address."
                    },
                    password:{
                        required:"Please enter your password.",
                        minlength:"Your password must be at least 6 characters long."
                    },
                    password_confirmation:{
                        required:"Please confirm your password.",
                        equalTo:"Password does not match."
                    }
                },
                errorElement: 'span',
                errorClass: 'text-red-500 text-sm',
                highlight:function(element){
                    $(element).addClass('border-red-500');
                },
                unhighlight:function(element){
                    $(element).removeClass('border-red-500');
                }
            });
        })
    </script>
@endsection
