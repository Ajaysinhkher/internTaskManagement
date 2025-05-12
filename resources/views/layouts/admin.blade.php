<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">

    {{-- Include navbar only when logged in --}}
    @include('admin.partials.navbar')

    <main class="py-8">
        <div class="container mx-auto">
            @yield('content')
        </div>
    </main>

</body>
</html>
