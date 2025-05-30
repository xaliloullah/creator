<form wire:submit.prevent="send_message">
    @if ($reponse ?? null)
        <div class="card-ghost mb-1">
            <div class="card-body">
                <div class="float-end">
                    <button class="btn-close" wire:click="close_reply"></button>
                </div>
                {{-- <i class="bi bi-reply fs-5 text-white-emphasis"></i> --}}
                <img src="{{ asset('storage/images/' . $reponse->User->image()) }}" alt="profil"
                    class="image-preview rounded-circle img-xs img-square m-1 shadow-lg" />
                <label class="">

                    {{ $reponse->User->prenom ?? '' }} {{ $reponse->User->nom ?? '' }}
                </label>
                <div class="card-text">{!! $reponse->contenu !!}</div>
            </div>
        </div>
    @endif
    <div class="d-flex gap-2">
        <button class="btn btn-outline-dark" type="button" title="Add attachment">
            <i class="bi bi-paperclip"></i>
        </button>

        <input type="text" class="form-control card-ghost" placeholder="Type a message..."
            aria-label="Type a message" wire:model="contenu" />

        <button class="btn btn-outline-dark" type="button" title="Choose emoji">
            <i class="bi bi-emoji-smile"></i>
        </button>

        <button class="btn btn-success" type="submit" title="Send message">
            <i class="bi bi-send"></i>
        </button>
    </div>
</form>


{{-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        let chatForm = document.querySelector("form");
        let chatInput = document.getElementById("chat-input");
        let chatBox = document.getElementById("chat-box");

        chatForm.addEventListener("submit", function(event) {
            event.preventDefault();

            let message = chatInput.value.trim();
            if (message === "") return;

            let formData = new FormData(chatForm);

            axios.post(chatForm.action, formData, {
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                })
                .then(response => {
                    // Clear the input field after the message is sent
                    chatInput.value = "";
                    // console.log(response);
                    // console.log(window.Echo);

                })
                .catch(error => {
                    console.error("There was an error sending the message:", error);
                });
        });
        window.Echo.channel('chat')
            .listen('.message.sent', (event) => {
                console.log(event);
                // let newMessage =
                //     `<p><strong>${event.message.User.prenom}:</strong> ${event.message.contenu}</p>`;
                // chatBox.innerHTML += newMessage;
                // chatBox.scrollTop = chatBox.scrollHeight;
            });
    });
</script> --}}
