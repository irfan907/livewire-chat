<?php

namespace App\Http\Livewire;

use App\Models\Message;
use App\Models\User;
use Livewire\Component;

class ChatMaster extends Component
{
    public $users;
    public $usersWithChat;
    public $openedUser;
    public $openedUserMessages;
    public $newMessage;

    public $search;

    protected $rules = [
        'newMessage' => 'required',
    ];

    public function mount()
    {
        $this->users=User::all()->except(auth()->id());
        $this->usersWithChat=$this->users;
        $this->openedUser=$this->usersWithChat->first();
        $this->getOpenedUserMessages();
    }

    public function selectOpenedUser($userId)
    {
        $this->openedUser=$this->users->where('id',$userId)->first();
        $this->getOpenedUserMessages();
    }

    public function getOpenedUserMessages()
    {
        if($this->openedUser != null)
        {
            $this->openedUserMessages=Message::where('sender',auth()->id())->where('receiver',$this->openedUser->id)->get();
            $this->openedUserMessages=$this->openedUserMessages->merge(Message::where('receiver',auth()->id())->where('sender',$this->openedUser->id)->get());
            $this->openedUserMessages=$this->openedUserMessages->sortBy('created_at');
            $this->dispatchBrowserEvent('scroll-to-bottom');
        }
    }

    public function sendMessage($receiverId)
    {
        $this->validate();

        $message=new Message();
        $message->message=$this->newMessage;
        $message->sender=auth()->id();
        $message->receiver=$receiverId;
        $message->save();

        $this->openedUserMessages->push($message);

        $this->newMessage=null; 

        $this->dispatchBrowserEvent('scroll-to-bottom');
    }

    public function updatedSearch()
    {
        $this->search();
    }

    public function search()
    {
        if($this->search !=null)
        {
            $userss=$this->usersWithChat->filter(function ($user){
                return preg_match("/$this->search/",$user['name']);
            });
            $this->usersWithChat=$userss;
        }
        else{
            $this->usersWithChat=$this->users;
        }
    }

    public function render()
    {
        return view('livewire.chat-master');
    }
}
