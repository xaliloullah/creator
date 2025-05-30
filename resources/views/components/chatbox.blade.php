<a data-toggle="modal" data-target="#chatbox" class=""><img src="{{ asset('assets/images/chatbot.jpg') }}"
        alt="user-image" class="rounded-circle chatbox-btn">
</a>
<div id="chatbox" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="fullWidthModalLabel">Chatbot</h4>
                <a type="button" class="fas fa-times" data-dismiss="modal" aria-hidden="true"></a>
            </div>
            <div class="modal-body">
                <div class="dialogue">
                    <div id="messages"></div>
                </div>

                <div id="chatbot"></div>
            </div>
            <div class="modal-footer">
                <div class="input-container">
                    <input id="input-chatbot" required="" placeholder="Entrer votre message" type="text"
                        autofocus>
                    <button type="button" id="send" class="send-btn">
                        <i class="fa fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
