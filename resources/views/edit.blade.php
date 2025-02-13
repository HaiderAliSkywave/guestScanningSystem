<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Guest Details') }}
        </h2>
    </x-slot>

    <div class="py-2" id="div_for_guests">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100" id="incoming_guests">
                    @if (session('success'))
                        <div class="mt-5 bg-transparent text-green-700 px-4 py-3 border border-gray-500 rounded relative" role="alert">
                            <span class="block sm:inline"><strong>{{ session('success') }}</strong></span>
                        </div>                        
                    @elseif (session('error'))
                        <div class="mt-5 bg-transparent text-red-700 px-4 py-3 border border-gray-500 rounded relative" role="alert">
                            <span class="block sm:inline"><strong>{{ session('error') }}</strong></span>
                        </div>                        
                    @endif
                <form action="{{ route('edit-guest-details', ['guest' => $guest->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <!-- English Name -->
                    <div class="flex flex-col">
                        <label for="eng_name" class="text-sm font-medium text-gray-700 dark:text-white mb-1">English Name</label>
                        <input
                            type="text"
                            id="eng_name"
                            name="eng_name"
                            value="{{ $guest->eng_name }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-gray-700"
                            required
                        />
                    </div>

                    <!-- Arabic Name -->
                    <div class="flex flex-col">
                        <label for="arabic_name" class="text-sm font-medium text-gray-700 dark:text-white mb-1">Arabic Name</label>
                        <input
                            type="text"
                            id="arabic_name"
                            name="arabic_name"
                            value="{{ $guest->arabic_name }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-gray-700"
                            required
                        />
                    </div>

                    <!-- Title -->
                    <div class="flex flex-col">
                        <label for="title" class="text-sm font-medium text-gray-700 dark:text-white mb-1">Title</label>
                        <select
                            type="text"
                            id="title"
                            name="title"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-gray-700"
                            required
                        >
                            @foreach ($titles as $title)
                                <option value="{{ $title->id }}">{{ $title->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Seat Number -->
                    <div class="flex flex-col">
                        <label for="seat_number" class="text-sm font-medium text-gray-700 dark:text-white mb-1">Seat Number</label>
                        <input
                            type="text"
                            id="seat_number"
                            name="seat_number"
                            value="{{ $guest->seat_number }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-gray-700"
                            required
                        />
                    </div>

                    <!-- Photo Upload -->
                    <div class="flex flex-col">
                        <label for="photo" class="text-sm font-medium text-gray-700 dark:text-white mb-1">Photo</label>
                        <input
                            type="file"
                            id="photo"
                            name="photo"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-gray-700"
                        />
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200"
                        >
                            Update
                        </button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
