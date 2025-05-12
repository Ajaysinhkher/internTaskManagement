<nav class="bg-white shadow fixed top-0 inset-x-0 z-50">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <!-- Left: Logo or Brand -->
        <div class="text-xl font-semibold text-blue-600">
            Task Management
        </div>

        <!-- Center: Navigation Links -->
        <div class="space-x-6 text-gray-700 font-medium">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            <a href="{{ route('tasks.index') }}" class="hover:text-blue-600">Tasks</a>
            {{-- <a href="{{ route('chat.index') }}" class="hover:text-blue-600">Chat</a> --}}
          
        </div>

        <!-- Right: Welcome + Logout -->
        <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-600">Welcome, {{ Auth::user()->name }}</span>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-red-600 hover:underline">Logout</button>
            </form>
        </div>
    </div>
</nav>
