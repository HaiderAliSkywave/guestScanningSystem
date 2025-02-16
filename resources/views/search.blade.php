<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Search Guests') }}
        </h2>
    </x-slot>

    
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="mt-5 bg-transparent text-green-700 px-4 py-3 border border-gray-500 rounded relative" role="alert">
                            <span class="block sm:inline"><strong>{{ session('success') }}</strong></span>
                        </div>                        
                    @elseif (session('error'))
                        <div class="mt-5 bg-transparent text-red-700 px-4 py-3 border border-gray-500 rounded relative" role="alert">
                            <span class="block sm:inline"><strong>{{ session('error') }}</strong></span>
                        </div>                        
                    @endif
                    <table id="guests-table" class="display">
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
                                        {{ $guest->id }}|{{ request()->user()->role }}
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
                table = $('#guests-table').DataTable({
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
                            render: function(data) {
                                const [guest, role] = data.split('|');
                                return role === 'admin'
                                ? `
                                    <a href="/edit-guest/${guest}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                    <a onclick="confirm(${guest})" href="javascript:void(0)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Confirm</a>
                                    `
                                : `
                                    <a onclick="confirm(${guest})" href="javascript:void(0)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Confirm</a>
                                  `
                                ;
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
                            url: `{{ route('confirm-guest') }}?guest=${id}`,
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
