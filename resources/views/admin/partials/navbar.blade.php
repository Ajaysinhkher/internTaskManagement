@auth('admin')
<nav class="bg-gray-800 p-4 text-white shadow">
    <div class="container mx-auto flex justify-between items-center">
        <a href="{{ route('admin.dashboard') }}" class="font-bold text-xl">Admin Panel</a>

        <div class="flex space-x-6 items-center">
            <a href="{{ route('admin.dashboard') }}" class="hover:underline">Dashboard</a>
            {{-- <a href="{{ route('admin.roles.index') }}" class="hover:underline">Manage Roles</a> --}}
            {{-- <a href="{{ route('admin.admins.index') }}" class="hover:underline">Manage Admins</a> --}}
            <a href="{{ route('admin.tasks.index') }}" class="hover:underline">Manage Tasks</a>
            <a href="{{ route('admin.users.index') }}" class="hover:underline">Manage Users</a>

            {{-- <span class="ml-4">Welcome, {{ Auth::guard('admin')->user()->name }}</span> --}}

            <form method="POST" action="{{ route('admin.logout') }}" class="inline ml-4">
                @csrf
                <button type="submit" class="hover:underline text-red-300">Logout</button>
            </form>
        </div>
    </div>
</nav>
@endauth
