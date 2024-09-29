<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ auth()->user()->name }} :
                    {{ __("You're logged in!!") }}
                </div>
                <div
                    class=" from-purple-400 via-pink-500 to-red-500 min-h-screen flex items-center justify-center p-4">
                    <div class="max-w-4xl w-full">
                        <h1 class="text-4xl font-semibold text-white mb-8 text-center">User List</h1>
                        <ul class="space-y-4">


                            @foreach ($users as $user)
                                <li class="flex flex-col flex-grow bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg rounded-xl overflow-hidden border hover:shadow-xl transition-shadow duration-300">
                                    <div class="px-6 py-4">
                                        <div class="flex items-center justify-between">
                                            <a href="{{ route('chat', ['friend' => $user['id']]) }}">
                                            <div>
                                                <h2 class="text-xl font-semibold ">{{ $user['name'] }}</h2>
                                                <p class="text-sm text-gray-700">{{ $user['email'] }}</p>
                                            </div>
                                            <span class="px-3 py-1 text-sm font-medium bg-opacity-30 rounded-full

                                            ">
                                           {{  \Carbon\Carbon::parse($user['created_at'])->diffForHumans() }}
                                            </span>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
{{--        @include('partials.footer')--}}

    </div>

</x-app-layout>
