@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6">
    <h1 class="text-xl font-semibold mb-4 text-gray-800">Chat with {{ $user->name }}</h1>

    <div id="chat-messages" class="border border-gray-300 rounded-lg p-4 mb-5 h-72 overflow-y-scroll bg-white shadow-sm">
        @foreach ($messages as $message)
            @php
                $isAdmin = $message->sender_id === auth('admin')->id() && $message->sender_type === get_class(auth('admin')->user());
            @endphp

            <div class="mb-3 flex {{ $isAdmin ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-xs px-4 py-2 rounded-lg {{ $isAdmin ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-900' }}">
                    <p class="mb-1 text-sm leading-snug">
                        <strong class="font-semibold">{{ class_basename($message->sender_type) }}:</strong>
                        <span>{{ $message->message }}</span>
                    </p>
                    <small class="text-[10px] block text-right text-gray-300">{{ $message->created_at->format('d M Y H:i') }}</small>
                </div>
            </div>
        @endforeach
    </div>

    <form id="chat-form" class="space-y-2">
    @csrf
    <textarea 
        name="message" 
        rows="2" 
        required 
        placeholder="Type your message..." 
        class="w-full border border-gray-300 rounded-md px-3 py-2 resize-none focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
    ></textarea>
    <button 
        type="submit" 
        class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition text-sm"
    >
        Send
    </button>
</form>

</div>

<script>





    $(document).ready(function() {
        const receiverType = "{{ class_basename(get_class(auth('admin')->user())) }}"; // Admin
        const senderId = {{ auth('admin')->id() }};
        const receiverId = {{ $user->id }}
        const chatChannel = `chat.${Math.min(senderId, receiverId)}.${Math.max(senderId, receiverId)}`;
        console.log('channel name: ', chatChannel);

        // Laravel Echo listener
        window.Echo.channel(chatChannel)
        .listen('MessageSent', (e) => {
            console.log('Message received:', e);
            const container = document.getElementById('chat-messages');
            const isAdmin = e.sender_id === senderId && e.sender_type === 'Admin';

            const messageHTML = `
                <div class="mb-3 flex ${isAdmin ? 'justify-end' : 'justify-start'}">
                    <div class="max-w-xs px-4 py-2 rounded-lg ${isAdmin ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-900'}">
                        <p class="mb-1 text-sm leading-snug">
                            <strong class="font-semibold">${e.sender_type}:</strong>
                            <span>${e.message}</span>
                        </p>
                        <small class="text-[10px] block text-right text-gray-300">${new Date(e.created_at).toLocaleString()}</small>
                    </div>
                </div>
            `;

            container.innerHTML += messageHTML;
            container.scrollTop = container.scrollHeight;
        });

        // jQuery AJAX form submission
            $('#chat-form').on('submit', function(e) {
            e.preventDefault();

            const form = $(this);
            const messageInput = form.find('textarea[name="message"]');
            const message = messageInput.val().trim();
            if (!message) return;

        $.ajax({
            url: "{{ route('admin.chat.store', $user->id) }}",
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                const messageData = response.message;

                const messageHTML = `
                    <div class="mb-3 flex justify-end">
                        <div class="max-w-xs px-4 py-2 rounded-lg bg-blue-600 text-white">
                            <p class="mb-1 text-sm leading-snug">
                                <strong class="font-semibold">${messageData.sender_type.split('\\').pop()}:</strong>
                                <span>${messageData.message}</span>
                            </p>
                            <small class="text-[10px] block text-right text-gray-300">${new Date(messageData.created_at).toLocaleString()}</small>
                        </div>
                    </div>
                `;

                const container = document.getElementById('chat-messages');
                container.innerHTML += messageHTML;
                container.scrollTop = container.scrollHeight;

                messageInput.val('');
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Message sending failed!');
            }
        });
    });

    });


</script>

@endsection
