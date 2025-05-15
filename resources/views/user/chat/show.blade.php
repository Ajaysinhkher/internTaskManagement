@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6">
    <h1 class="text-xl font-semibold mb-4 text-gray-800">Chat with {{ $admin->name }}</h1>

    <div id="chat-messages" class="border border-gray-300 rounded-md p-3 mb-5 h-72 overflow-y-auto bg-white space-y-3">
        @foreach ($messages as $message)
            @php
                $isUser = $message->sender_id === auth()->id() && $message->sender_type === get_class(auth()->user());
            @endphp

            <div class="flex {{ $isUser ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-xs px-3 py-2 rounded-lg text-sm {{ $isUser ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-900' }}">
                    <p class="mb-1">
                        <strong>{{ class_basename($message->sender_type) }}:</strong> {{ $message->message }}
                    </p>
                    <span class="block text-xs text-right text-gray-300">{{ $message->created_at->format('d M Y H:i') }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <form id="chat-form" class="space-y-3">
        @csrf
        <textarea 
            name="message" 
            rows="3" 
            required 
            placeholder="Type your message here..." 
            class="w-full border border-gray-300 rounded-md px-3 py-2 resize-none text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
        ></textarea>
        <button 
            type="submit" 
            class="bg-blue-600 text-white text-sm px-4 py-2 rounded-md hover:bg-blue-700 transition-colors"
        >
            Send
        </button>
    </form>
</div>

{{-- jQuery AJAX for sending messages --}}
<script>
    $(document).ready(function () {
        $('#chat-form').on('submit', function (e) {
            e.preventDefault();

            const form = $(this);
            const messageInput = form.find('textarea[name="message"]');
            const message = messageInput.val();

            if (!message.trim()) return;

            $.ajax({
                url: "{{ route('chat.store', $admin->id) }}",
                type: 'POST',
                data: form.serialize(),
                success: function (response) {
                    const messageData = response.message;

                    const messageHTML = `
                        <div class="flex justify-end">
                            <div class="max-w-xs px-3 py-2 rounded-lg text-sm bg-blue-600 text-white">
                                <p class="mb-1">
                                    <strong>${messageData.sender_type.split('\\').pop()}:</strong> ${messageData.message}
                                </p>
                                <span class="block text-xs text-right text-gray-300">${new Date(messageData.created_at).toLocaleString()}</span>
                            </div>
                        </div>
                    `;

                    const container = document.getElementById('chat-messages');
                    container.innerHTML += messageHTML;
                    container.scrollTop = container.scrollHeight;

                    messageInput.val('');
                },
                error: function (xhr) {
                    alert('Message failed to send.');
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

{{-- Laravel Echo listener for real-time messages --}}
<script>
    const userType = "{{ class_basename(get_class(auth()->user())) }}"; // e.g., "User"
    const userId = {{ auth()->id() }}; // e.g., 5

    const channelName = `chat.${userType}.${userId}`;
    console.log("Listening on:", channelName);

    
    
    window.Echo.channel(channelName)
        .listen('.MessageSent', (e) => {
            console.log("New message received:", e);
            
            const isUser = e.sender_id === userId && e.sender_type === userType;

            const messageHTML = `
                <div class="flex ${isUser ? 'justify-end' : 'justify-start'}">
                    <div class="max-w-xs px-3 py-2 rounded-lg text-sm ${isUser ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-900'}">
                        <p class="mb-1">
                            <strong>${e.sender_type.split('\\').pop()}:</strong> ${e.message}
                        </p>
                        <span class="block text-xs text-right text-gray-300">${new Date(e.created_at).toLocaleString()}</span>
                    </div>
                </div>
            `;

            const container = document.getElementById('chat-messages');
            container.innerHTML += messageHTML;
            container.scrollTop = container.scrollHeight;
        });
</script>
@endsection
