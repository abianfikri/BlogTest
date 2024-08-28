<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('post.store') }}" method="post" class="">
                        @csrf
                        @method('post')
                        <div class="mb-6">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" name="title" type="text" class="block w-full mt-1"
                                required autofocus autocomplete="title" />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>
                        <div class="mb-6">
                            <x-input-label for="content" :value="__('Content')" />
                            <x-text-input id="content" name="content" type="text" class="block w-full mt-1"
                                required autofocus autocomplete="content" />
                            <x-input-error class="mt-2" :messages="$errors->get('content')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button> {{ __('Save') }} </x-primary-button>
                            <a href="{{ route('post.index') }}"
                                class="inline-flex items-center px-4 py-2 text-xs font-medium tracking-widest
                                        text-gray-700 uppercase transition duration-150 ease-in-out
                                        bg-white border border-gray-300 rounded-md shadow-sm dark:bg-gray-800
                                        dark:border-gray-500 dark:text-gray-300 hover:bg-gray-50
                                        dark:hover:bg-gray-700 focus:outline-none focus:ring-2
                                        focus:ring-indigo-500 focus:ring-offset-2
                                        dark:focus:ring-offset-gray-800 disabled:opacity-25">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
