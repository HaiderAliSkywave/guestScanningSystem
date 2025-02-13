<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Incoming Guests') }}
        </h2>
    </x-slot>

    <div class="py-2" id="div_for_guests">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100" id="incoming_guests">
                    No incoming guests...
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            var incoming_guests = '';
                setInterval(() =>
                    $.ajax({
                    url: `{{ route('incoming-guests') }}`,
                    type: 'GET',
                    success: function(response) {
                        var guests = '';
                        if(response.guests.length > 0) {
                            response.guests.forEach(guest => {
                            guests +=
                                `<div id="guest-div-${guest.id}" class="my-5 border border-gray-500 rounded p-5">
                                    <div class="flex flex-col justify-center items-center">
                                        <img src="{{ asset('storage/${guest.photo}') }}" alt="${guest.name}" class="mb-2 rounded overflow-hidden w-80 h-80"/>
                                        <p><strong>${guest.eng_name}, ${guest.arabic_name}</strong></p>
                                        <p>${guest.title.name}</p>
                                        <p>Seat Number: ${guest.seat_number}</p>
                                    </div>
                                    <div class="flex justify-end items-center">
                                        <button id="guest-button-${guest.id}" onclick="onSeat(${guest.id})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            On seat!
                                        </button>
                                    </div>
                                </div>`;
                            });
                            $('#incoming_guests').html('');
                            $('#incoming_guests').append(guests);
                        } else {
                            $('#incoming_guests').html('No incoming guests...');
                        }
                    }
                })
                , 2000);

            function onSeat(id) {
                $('#guest-button-' + id).attr('disabled', true);
                $('#guest-button-' + id).html('Processing...');
                $.ajax({
                        url: `{{ route('on-seat') }}?guest=${id}`,
                        type: 'GET',
                        success: function(response) {
                            if(response.success) {
                                $('#guest-button-' + id).html(response.success);
                                $('#guest-button-' + id).removeClass('bg-blue-500 hover:bg-blue-700');
                                $('#guest-button-' + id).addClass('bg-green-500');
                            } else {
                                $('#guest-button-' + id).html(response.error);
                                $('#guest-button-' + id).removeClass('bg-blue-500 hover:bg-blue-700');
                                $('#guest-button-' + id).addClass('bg-red-500');
                            }
                        }
                    });
            }
        </script>
    @endpush
</x-app-layout>
