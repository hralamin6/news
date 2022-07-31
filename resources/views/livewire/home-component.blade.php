<div x-data="{add: false}" x-init="
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

        <section class="w-full max-w-2xl px-6 py-4 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800">
            <div class="mt-6 ">
                <div class="items-center -mx-2 md:flex">
                    <div class="w-full mx-2">
                        <input x-ref="input" id="input" wire:model.lazy="question" placeholder="Enter Question" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-opacity-40" type="text">
                        @error('question')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="w-full mx-2 mt-4 md:mt-0">
                        <input wire:model.lazy="image" placeholder="Enter image url" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-opacity-40" type="text">
                        @error('image')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="w-full mx-2 mt-4 md:mt-0">
                        <select wire:model.lazy="category_id" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-opacity-40">
                            <option value="0">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                </div>
                <div class="w-full mt-4">
                    <textarea wire:model.lazy="answer" placeholder="Enter Answer" class="block w-full h-40 px-4 py-2 text-gray-700 bg-white border rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40"></textarea>
                    @error('answer')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
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
    <div class="grid grid-cols-1 gap-2 md:gap-4 mt-3 xl:gap-8 md:grid-cols-2 lg:grid-cols-3">
        @foreach($posts as  $post)
            <div class="max-w-2xl w-full px-3 py-2 mx-auto bg-white rounded-lg shadow-md dark:bg-gray-800 border hover:border-indigo-700 dark:hover:border-pink-600">
                <div class="flex flex-row items-center justify-between">
                    <a href="{{route('category', $post->category)}}" class="px-3 py-1 text-xs text-blue-800 uppercase bg-blue-200 rounded-full dark:bg-blue-300 dark:text-blue-900">
                        {{$post->category->name}}</a>
                    <span class="text-sm font-light text-gray-600 dark:text-gray-400">{{$post->created_at->format('M d, Y')}}</span>
                    <div class="flex items-center">
                        <x-h-o-eye class="h-6 text-indigo-500 pt-1 dark:text-purple-200"/>
                        <span class="pl-2 text-gray-600 dark:text-gray-400">{{$post->views}}</span>
                    </div>
                </div>
                <div class="grid grid grid-cols-2 gap-1">
                    <a href="" class="m-auto py-2">
                        <img class="object-cover object-center w-36 rounded-md shadow" src="{{$post->image}}" alt="">
                    </a>
                        <div class="mt-2">
                            <a href="{{route('post', $post)}}" class="text-lg lg:text-xl font-bold text-gray-700 dark:text-white hover:text-green-600 dark:hover:text-blue-300 hover:underline">
                                {{$post->question}}</a>
                        </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="items-center text-center mx-auto my-8">
        {{ $posts->links() }}
    </div>

</div>
