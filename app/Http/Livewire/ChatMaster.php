<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class ChatMaster extends Component
{
    public $users;
    public $usersWithChat;
    public $openedUser;

    public function mount()
    {
        $this->users=User::all();
        $this->usersWithChat=$this->users;
        $this->openedUser=$this->usersWithChat->first();
    }

    public function selectOpenedUser($userId)
    {
        $this->openedUser=$this->users->where('id',$userId)->first();
    }

    public function render()
    {
        return view('livewire.chat-master');
    }
}
