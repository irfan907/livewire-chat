<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=overflow-hidden shadow-xl sm:rounded-lg border-2">
                <div class="grid grid-cols-7 gap-4">
                    
                    <div  class="col-span-2 bg-white p-3 rounded-md">
                        <div>
                            <div class="flex justify-between">
                                <div class="rounded-full bg-gray-50 w-6 h-6 ">
                                    
                                </div>
                                <div>
                                    Name
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-span-5 bg-white p-3 rounded-md">
                       sa 
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    @livewire('chat-master')
</x-app-layout>
