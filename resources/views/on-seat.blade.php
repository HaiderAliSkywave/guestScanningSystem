<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Guests on Seat') }}
        </h2>
    </x-slot>

    <div class="py-2" id="div_for_guests">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100" id="incoming_guests">
                    <table id="guests-on-seat" class="display">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Arabic Name</th>
                                <th>Title</th>
                                <th>Seat Number</th>
                                <th>Photo</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($guests as $guest)
                                <tr>
                                    <td>{{ $guest->eng_name }}</td>
                                    <td>{{ $guest->arabic_name }}</td>
                                    <td>{{ $guest->title->name }}</td>
                                    <td>{{ $guest->seat_number }}</td>
                                    <td><img onclick="openImage(`{{$guest->photo}}`)" src="{{ $guest->photo }}" alt="{{ $guest->eng_name }}" class="w-28 h-28"/></td>
                                    <td>
                                        {{ $guest->id }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                table = $('#guests-on-seat').DataTable({
                    order: [[3, 'asc']],
                    pageLength: 100,
                    paging: true,
                    searching: true,
                    ordering: true,
                    responsive: true,
                    columns: [
                        { data: 'eng_name', name: 'eng_name' }, // Column 1: Name
                        { data: 'arabic_name', name: 'arabic_name' }, // Column 2: Arabic Name
                        { data: 'title.name', name: 'title.name' }, // Column 3: Title
                        { data: 'seat_number', name: 'seat_number' }, // Column 4: Seat Number
                        { data: 'photo', name: 'photo', orderable: false, searchable: false }, // Column 5: Photo
                        { data: 'actions', name: 'actions', orderable: false, searchable: false } // Column 6: Actions
                    ],
                    columnDefs: [
                        {
                            targets: -1, // Targets the last column (Edit column)
                            render: function(guest) {
                                return `<a onclick="confirm(${guest})" href="javascript:void(0)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Off Seat</a>`;
                            }
                        }
                    ]
                });
            });

            // confirm guest
            function confirm(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, confirm it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ route('revert-guest-status') }}?guest=${id}`,
                            type: 'GET',
                            success: function(response) {
                                if(response.success) {
                                    Swal.fire({
                                        title: response.success,
                                        icon: 'success',
                                        showConfirmButton: false,
                                        showCancelButton: false,
                                    });

                                    location.reload();
                                } else {
                                    Swal.fire({
                                        title: response.error,
                                        icon: 'error',
                                        showConfirmButton: false,
                                        showCancelButton: false,
                                    });
                                }
                            }
                        });
                    }
                });
            }

            // open image
            function openImage(src) {
                Swal.fire({
                    imageUrl: src,
                    imageWidth: 400,
                    imageHeight: 400,
                    imageAlt: 'Guest Image',
                    showConfirmButton: true,
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#2196F3',
                });
            }
        </script>
    @endpush
</x-app-layout>
