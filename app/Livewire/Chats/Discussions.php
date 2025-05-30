<?php

namespace App\Livewire\Chats;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Chats\Discussion;

class Discussions extends Component
{
    protected $listeners = ['send_message' => 'load_discussions'];
    public $discussions;
    public $discussion_active;

    public function mount()
    {
        $this->load_discussions();
    }

    public function load_discussions()
    {
        $this->discussions = Auth::user()->Discussions ?? [];
    }

    public function set_discussion($id)
    {
        $this->discussion_active =  Discussion::findOrFail($id);
        $this->dispatch('discussion_updated', $this->discussion_active->id);
    }

    public function render()
    {
        return view('dashboard.modules.chats.discussions.index');
    }
}
