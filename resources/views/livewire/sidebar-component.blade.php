<nav x-cloak @click.outside="nav = false" class="md:block overflow-x-hidden overflow-y-hidden shadow-2xl bg-white inset-y-0 z-10 fixed md:relative flex-shrink-0 w-64 overflow-y-auto bg-white dark:bg-darkSidebar"
     :class="{'hidden': nav == false}"
     x-data="{add: false}" x-init="
$wire.on('dataAdded', (e) => { add = false});
$wire.on('openEditModal', (e) => { add = true; $nextTick(() => $refs.input.focus());})
"
     @open-delete-modal.window="
     model = event.detail.model
     eventName = event.detail.eventName
Swal.fire({
                title: event.detail.title,
                text: event.detail.text,
                icon: event.detail.icon,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',

            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit(eventName, model )
                }
            })
">
    <a href="{{route('home')}}" class="h-14 border-b dark:border-gray-600 flex px-4 py-2 gap-3">
        <img class="object-cover rounded-full" src="{{ url(asset('unnamed.jpg')) }}" alt="" aria-hidden="true"/>
        <span class="my-auto text-xl text-gray-500 font-mono dark:text-gray-300">       Hranews</span>
    </a>

    <div class="m-2 mt-4 flex">
        <input wire:model.lazy="search" type="search"  class="border dark:border-gray-500 dark:bg-gray-600 dark:placeholder-gray-300 text-gray-600 dark:text-gray-200 text-sm border-gray-300 bg-gray-100 px-2 w-48 h-9 rounded-md rounded-r-none" placeholder="Search">
        <button class="border  dark:bg-gray-600 border-gray-300 dark:border-gray-500 bg-gray-100 rounded-l-none p-2 h-9 rounded-md"><x-h-o-search class="w-5 text-gray-600 dark:text-gray-200"/></button>
    </div>
    <div class="overflow-hidden h-screen scrollbar-none overflow-y-scroll scrollbar-thumb-gray-400 scrollbar-track-white  scrollbar-thin">
        <div x-cloak
             x-show="add"
             x-transition:enter="transition ease-in-out duration-150"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in-out duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
        ></div>
        <div x-cloak x-show="add"  x-on:click.stop class="w-full absolute inset-0 inline-flex items-center justify-center z-50 flex space-x-2 text-gray-500 text-sm mt-5 font-bold"
             x-transition:enter.scale.60
             x-transition:leave.scale.40
        >

            <section class="w-full max-w-2xl px-6 py-2 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800">
                <div class="mt-6 ">
                    <div class="items-center -mx-2 md:flex">
                        <div class="w-full mx-2">
                            <input x-ref="input" id="input" wire:model.lazy="name" placeholder="Enter category" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-opacity-40" type="text">
                            @error('name')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="flex justify-center gap-12">
                        <a href="" class="cursor-pointer" @click.prevent="add=false"><x-h-o-x class="w-8 text-gray-600 dark:text-gray-200"/></a>
                        <button wire:click.prevent="saveData" class="cursor-pointer"><x-h-o-plus-circle class="w-8 text-gray-600 dark:text-gray-200"/></button>
                    </div>
                </div>
            </section>
        </div>
        @auth
            @if(auth()->user()->type==='admin')
                <center><button @click.prevent="add=!add; $nextTick(() => $refs.input.focus());" x-on:click.stop><x-h-o-plus-circle class="h-8 text-gray-600 dark:text-gray-200"/></button></center>
            @endif
        @endauth
        <div class="capitalize">
            @foreach($categories as $category)
            <a href="{{route('category', $category->id)}}" class="navMenuLink {{Route::is('category', $category->id)  && $category->id==request()->segment(count(request()->segments()))?'navActive':'navInactive'}}">
                <x-h-o-chevron-double-right class="w-5"/>
                <div class="flex flex-row gap-8">
                    <span class="">{{__($category->name)}}</span>
                    <span class="justify-end text-purple-600 dark:text-purple-300">{{__($category->posts_count)}}</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</nav>
