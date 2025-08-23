<?php

namespace App\Livewire\Chats;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;
use App\Models\Chats\Discussion;
use App\Models\Chats\Message;

class Messages extends Component
{
    public $discussion;
    public $messages;
    public $contenu;
    public $reponse;

    protected $listeners = ['send_message' => 'load_messages', 'discussion_updated' => 'update_discussion'];


    public function mount()
    {
        $this->load_messages();
    }


    public function send_message()
    {
        if (empty($this->contenu)) {
            return;
        }
        $message = new Message();
        $message->discussion_id = $this->discussion->id;
        $message->user_id = Auth::user()->id;
        $message->contenu = $this->contenu;
        $message->reponse_id = $this->reponse->id ?? null;
        $message->statut = 'UNREAD';
        $message->save();

        $this->contenu = '';
        $this->reponse = null;
        $this->dispatch('send_message');
    }

    public function reply_to($message_id)
    {
        $this->reponse = Message::findOrFail($message_id);
    }

    public function close_reply()
    {
        $this->reponse = null;
    }


    public function update_discussion($id)
    {
        $this->discussion = Discussion::findOrFail($id);
        $this->load_messages();
    }

    public function load_messages($messages = null)
    {
        if (!$messages) {
            $this->messages = $this->discussion->Messages;
        } else {
            $this->messages = $messages;
        }
        $this->mark_as_read();
    }

    public function delete_message($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();
        $this->load_messages();
        $this->dispatch('send_message');
    }

    public function mark_as_read()
    {
        if (!$this->discussion) {
            return;
        }

        Message::where('discussion_id', $this->discussion->id)
            ->where('user_id', '!=', Auth::id())
            ->where('statut', 'UNREAD')
            ->update(['statut' => 'READ']);

        // $this->load_messages();
    }


    public function render()
    {
        return view('dashboard.pages.chats.messages.index');
    }
}
