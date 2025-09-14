@extends('backend.include.app')
@section('title', 'Hotel Room ')
@section('content')
    <div class="container-fluid px-4">
        <h4 class="mt-2">Room Management</h4>

        <div class="card my-2">
            <div class="card-header">
                <div class="row ">
                    <div class="col-12 d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <h5 class="m-0">Room List</h5>
                        </div>
                        {{-- @if (Helper::hasRight('role.create')) --}}
                            <a href="{{ route('hotel.room.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add</a>
                        {{-- @endif --}}
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered" id="dataTable">
           <thead>
    <tr>
        <th>Room Number</th>
        <th>Room Type</th>
        <th>Price</th>
        <th>Capacity</th>
        <th>Bed Type</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
</thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
    function getRoom(search = null) {
    var table = jQuery('#dataTable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searching: true,
        paging: true,
        bFilter: true,
        bInfo: true,
        ajax: {
            url: "{{ url('admin/hotel-room/get/list') }}",
            type: 'GET',
            data: function(d) {
                // Send the specific filter parameters that your PHP expects
                d.room_number = $('#room_number_search').val();
                d.room_type = $('#room_type_search').val();
                d.bed_type = $('#bed_type_search').val();
                d.status = $('#status_search').val();
                // Also send the global search if needed
                d.search = d.search.value; // This sends the DataTables global search
            },
        },
        aLengthMenu: [
            [25, 50, 100, 500, 5000, -1],
            [25, 50, 100, 500, 5000, "All"]
        ],
        iDisplayLength: 50,
        "order": [
            [0, 'desc']
        ],
        columns: [
            { data: 'room_number', name: 'room_number' },
            { data: 'room_type', name: 'room_type' },
            { data: 'price', name: 'price' },
            { data: 'capacity', name: 'capacity' },
            { data: 'bed_type', name: 'bed_type' },
            { data: 'status', name: 'status' },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: "text-center w-10"
            },
        ]
    });

    // Add search input field for global search
    $('#dataTable_filter').html('<label>Search:<input type="search" class="form-control form-control-sm" placeholder="Global search..." id="globalSearch"></label>');
    
    // Add event listener for global search
    $('#globalSearch').on('keyup', function() {
        table.search(this.value).draw();
    });

    return table;
}

getRoom();

        $(document).on('click', '.delete_btn', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/admin/hotel-room/delete/') }}/" + id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            if (data.success) {
                                $.toast({
                                    heading: 'Success',
                                    text: data.success,
                                    position: 'top-center',
                                    icon: 'success'
                                })
                            } else {
                                $.toast({
                                    heading: 'Error',
                                    text: data.error,
                                    position: 'top-center',
                                    icon: 'error'
                                })
                            }
                            $('#dataTable').DataTable().destroy();
                            getRoom();
                        }
                    })

                }
            })
        })
    </script>

@endsection
