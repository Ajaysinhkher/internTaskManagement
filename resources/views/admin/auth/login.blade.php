@extends('layouts.admin')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Admin Login</h2>

    <form method="POST" action="{{ route('admin.login.post') }}" id="adminLoginForm">
        @csrf

        <div class="mb-4">
            <label for="email" class="block font-semibold">Email</label>
            <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded p-2"  autofocus>
            @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block font-semibold">Password</label>
            <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded p-2" >
            @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Login</button>
    </form>
</div>
<script>
    $(document).ready(function(){
        $('#adminLoginForm').validate({
            rules:{
                email:{
                    required:true,
                    email:true
                },
                password:{
                    required:true,
                    minlength:6
                }
            },
            messages:{
                email:{
                    required:"Please enter your email address.",
                    email:"Please enter a valid email address."
                },
                password:{
                    required:"Please enter your password.",
                    minlength:"Your password must be at least 6 characters long."
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
    })
</script>
@endsection
