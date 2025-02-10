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
                    <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-5">
                            <label for="file" class="mr-4">Upload a file</label>
                            <input type="file" id="excelSheet" name="excelSheet" class="hover:cursor-pointer" required/>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Upload</button>
                    </form>
                    @if (session('success'))
                        <div class="mt-5 bg-transparent text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline"><strong>{{ session('success') }}</strong></span>
                        </div>                        
                    @endif
                    @if (session('error'))
                        <div class="mt-5 bg-transparent text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline"><strong>{{ session('error') }}</strong></span>
                        </div>                        
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
