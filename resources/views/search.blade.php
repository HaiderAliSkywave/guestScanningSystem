<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Search Guests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div>
                        <input type="text" id="search_guests" name="search_guests" class="w-full rounded text-gray-900" placeholder="Type the name of guest"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2" id="div_for_guests">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100" id="guests">
                    Start typing to see results...
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $('#search_guests').on('input', function() {
                var guests = '';
                var search_guests = $(this).val();
                    $.ajax({
                        url: `{{ route('search-guests') }}?name=${search_guests}`,
                        type: 'GET',
                        success: function(response) {
                            if(response.guests.length > 0) {
                                response.guests.forEach(guest => {
                                guests +=
                                    `<div class="my-5 border border-gray-500 rounded p-5">
                                        <div class="flex flex-col justify-center items-center">
                                            <img src="${guest.photo}" alt="${guest.name}" class="mb-2 rounded overflow-hidden w-80 h-80"/>
                                            <p><strong>${guest.eng_name}, ${guest.arabic_name}</strong></p>
                                            <p>${guest.title.name}</p>
                                            <p>Seat Number: ${guest.seat_number}</p>
                                        </div>
                                        <div class="flex justify-end items-center">
                                            <button onclick="confirm(${guest.id})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                Confirm!
                                            </button>
                                        </div>
                                    </div>`;
                                });
                                $('#guests').html('');
                                $('#guests').append(guests);
                            } else {
                                $('#guests').html('Start typing to see results...');
                            }
                        }
                    });
                });

                function confirm(id) {
                    console.log(id);
                }
        </script>
    @endpush
</x-app-layout>
