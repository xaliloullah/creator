<div>
    {{-- wire:poll='load_messages' --}}
    <div id="chat-box" class="scrollbar scrollbar-lg">
        <div class="card card-ghost shadow-lg sticky-top top-0">
            <div class="card-body p-0">
                <img src="{{ asset('storage/images/' . $discussion->Membre()->image()) }}" alt="profil"
                    class="image-preview rounded-circle img-xs img-square m-1 shadow-lg" />
                <label class="">
                    {{ $discussion->Membre()->prenom ?? '' }} {{ $discussion->Membre()->nom ?? '' }}
                </label>
            </div>
        </div>

        {{-- <div wire:poll='load_messages'> --}}
        <div class="">
            @forelse ($messages ?? [] as $message)
                @include('dashboard.modules.chats.messages.view', ['message' => $message])
            @empty
        </div>
        <div class="text-center p-4 my-3 bg-light border rounded-lg shadow-sm">
            <i class="bi bi-chat-dots fs-1 text-primary me-3"></i>
            <p class="fw-bold text-dark mb-1">Lancez la conversation !</p>
            <p class="text-muted">Envoyez un message pour démarrer cette discussion.</p>
        </div>
        @endforelse
        <div class="card card-ghost shadow-lg sticky-bottom">
            <div class="card-body p-1">
                @include('dashboard.modules.chats.messages.create')
            </div>
        </div>
    </div>
    <script>
        function scrollHeight() {
            let chatbox = document.getElementById("chat-box");
            chatbox.scrollTop = chatbox.scrollHeight;
        }
        scrollHeight();
    </script>
</div>
@script
    <script wire:poll>
        // document.addEventListener('send_message', () => {
        scrollHeight();
        // setTimeout(() => {
        // }, 10);
        // })
    </script>
@endscript
