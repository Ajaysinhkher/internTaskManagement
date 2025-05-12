<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth System</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">

    @auth
        @include('user.partials.navbar')
    @endauth

    <main class="mt-20 py-8">
        <div class="container mx-auto">
            @yield('content')
        </div>
    </main>

</body>
</html>
