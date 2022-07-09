<div>
    <div class="container mx-auto">
        <div class="min-w-full rounded lg:grid lg:grid-cols-3">
          <div class="lg:col-span-1 overflow-auto flex flex-col rounded-2xl" style="height: 85vh;">
            <div class="sticky top-0 p-2 bg-gray-100">
                <div class="p-2 m-2 bg-white rounded-2xl">
                    <div class="relative text-gray-600">
                      <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          viewBox="0 0 24 24" class="w-6 h-6 text-gray-300" wire:target="search" wire:loading.class="animate-ping">
                          <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                      </span>
                      <input type="search" class="block w-full py-2 pl-10 bg-white rounded outline-none focus:outline-none border-0" name="search"
                        wire:model.debounce.500ms="search" wire:keydown.enter="search()"
                        placeholder="Search" required />
                    </div>
                  </div>
            </div>
  
            <ul class="flex flex-col flex-auto mx-2">
              <h2 class="mb-2 ml-2 text-lg text-gray-600">Chats</h2>
              <li class="flex-auto overflow-auto bg-white rounded-2xl" id="users-list">
                  @foreach($usersWithChat as $user)
                <a wire:click="selectOpenedUser({{ $user->id }})" id="user-{{ $user->id }}"
                  class="flex items-center px-3 py-2 text-sm transition duration-150 ease-in-out border-b border-gray-300 cursor-pointer hover:bg-gray-100 focus:outline-none
                  @if($openedUser !=null && $user->id == $openedUser->id) bg-gray-200 @endif">
                  <img class="object-cover w-10 h-10 rounded-full"
                    src="{{ $user->profile_photo_url }}" />
                  <div class="w-full pb-2">
                    <div class="flex justify-between">
                      <span class="block ml-2 font-semibold text-gray-600 capitalize">{{ $user->name }}</span>
                      <span class="block ml-2 text-sm text-gray-600">25 minutes</span>
                    </div>
                    <span class="block ml-2 text-sm text-gray-600 message">{{ $user->lastMessageWithSender() != null ? $user->lastMessageWithSender()->message:'' }}</span>
                  </div>
                </a>
                @endforeach
              </li>
            </ul>
          </div>
          <div class="hidden lg:col-span-2 lg:block overflow-auto rounded-2xl m-4" style="height: 85vh;">
            @if($openedUser !=null)
            <div class="w-full h-full flex flex-col">
                <div class="relative flex items-center p-3 border-b bg-gray-200 shadow sticky top-0">
                  <img class="object-cover w-10 h-10 rounded-full"
                    src="{{ $openedUser->profile_photo_url }}" alt="username" />
                  <span class="block ml-2 font-bold text-gray-600 capitalize">{{ $openedUser->name }}</span>
                  <span class="absolute w-3 h-3 bg-green-600 rounded-full left-10 top-3">
                  </span>
                </div>
                <div class="relative w-full flex-auto p-6 overflow-y-auto bg-white" id="messages-div">
                  <ul class="space-y-2" id="messages-list">
                      @foreach($openedUserMessages as $message)
                        @if($message->sender == auth()->id())
                          <li class="flex justify-end sent-message">
                            <div class="relative max-w-xl px-4 py-2 text-gray-700 bg-gray-100 rounded shadow">
                              <span class="block message">{{ $message->message }}</span>
                            </div>
                          </li>
                        @else
                            <li class="flex justify-start received-message">
                                <div class="relative max-w-xl px-4 py-2 text-gray-700 rounded shadow">
                                <span class="block message">{{ $message->message }}</span>
                                </div>
                            </li>
                        @endif
                    @endforeach
                  </ul>
                </div>
    
                <div class="flex items-center justify-between w-full p-3 border-t border-gray-300 bg-gray-200 sticky bottom-0">
                  <button>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </button>
                  <button>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                    </svg>
                  </button>
    
                  <input type="text" wire:model.defer="newMessage" placeholder="Message" wire:keydown.enter="sendMessage({{ $openedUser->id }})"
                    class="block w-full py-2 pl-4 mx-3 bg-gray-100 rounded-full outline-none focus:text-gray-700
                    @error('newMessage') @enderror"
                    name="message" required wire:target="sendMessage" wire:loading.attr="disabled" />
                  <button>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                    </svg>
                  </button>
                  <button wire:click="sendMessage({{ $openedUser->id }})">
                    <svg wire:target="sendMessage" wire:loading.class="hidden" class="w-5 h-5 text-gray-500 origin-center transform rotate-90" xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20" fill="currentColor">
                      <path
                        d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                    </svg>
                    <svg wire:loading wire:target="sendMessage" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 origin-center animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                      </svg>
                  </button>
                </div>
            </div>
            @else
            <div class="flex h-full bg-white items-center justify-center">
                Select a chat to open Conversation
            </div>
            @endif
          </div>
        </div>
      </div>
      <script>
        var openedUserId='';

        document.addEventListener('livewire:load', function () {
            function scrollToBottom()
            {
                var objDiv = document.getElementById("messages-div");
                objDiv.scrollTop = objDiv.scrollHeight;
            }

            window.addEventListener('scroll-to-bottom', event => {
                scrollToBottom();  
            })

            window.addEventListener('openedUserChanged', event => {
              openedUserId=event.detail.openedUserId
            })

            function playSound() {
                const audio = new Audio("{{ asset('sounds/message-notification.mp3') }}");
                audio.play();
            }

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                showCancelButton: false,
                //timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
              })

        
            Echo.private("receive-messages."+"{{auth()->id()}}")
            .listen('ReceiveMessage', (e) => {
                
                //console.log(e.message);
                playSound();
                Toast.fire({
                    title: 'New Message',
                    text: e.message.message,
                  })
                  
                  //add message to user sidebar
                  $('#user-'+e.message.sender).find('.message').html('<strong>'+e.message.message+'</strong>');
                  //dont'know about this line
                  $('#user-'+e.message.sender).prependTo("#users-list");
                  //clone a recieve message block and replace message text 
                  var messageBlock=$('.received-message:last').clone();
                  //if sender chat is opened, append message to it
                  if(openedUserId == e.message.sender){
                    messageBlock.find('.message').html(e.message.message);
                    $('#messages-list').append(messageBlock);
                  }
                  scrollToBottom();
                  
            });

        })
    </script>
</div>
