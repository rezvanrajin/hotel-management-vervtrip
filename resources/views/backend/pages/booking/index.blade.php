@extends('backend.include.app')
@section('title', 'Booking Room ')
@section('content')
    <div class="container-fluid px-4">
        <h4 class="mt-2">Booking Management</h4>

        <div class="card my-2">
            <div class="card-header">
                <div class="row ">
                    <div class="col-12 d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <h5 class="m-0">Booking List</h5>
                        </div>
                        {{-- @if (Helper::hasRight('role.create')) --}}
                            <a href="{{ route('home') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Create Booking</a>
                        {{-- @endif --}}
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
            <div class="col-md-3">
                <input type="text" id="booking_id_search" class="form-control form-control-sm search-filter" placeholder="Booking ID">
            </div>
            <div class="col-md-3">
                <input type="text" id="transaction_id_search" class="form-control form-control-sm search-filter" placeholder="Transaction ID">
            </div>
            <div class="col-md-3">
                <input type="text" id="guest_name_search" class="form-control form-control-sm search-filter" placeholder="Guest Name">
            </div>
            <div class="col-md-3">
                <input type="text" id="guest_email_search" class="form-control form-control-sm search-filter" placeholder="Guest Email">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <input type="text" id="room_number_search" class="form-control form-control-sm search-filter" placeholder="Room Number">
            </div>
            <div class="col-md-2">
                <select id="status_search" class="form-control form-control-sm search-filter">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="checked_in">Checked In</option>
                    <option value="checked_out">Checked Out</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <select id="payment_status_search" class="form-control form-control-sm search-filter">
                    <option value="">All Payment Status</option>
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="failed">Failed</option>
                    <option value="refunded">Refunded</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" id="check_in_date_search" class="form-control form-control-sm search-filter" placeholder="Check-in Date">
            </div>
            <div class="col-md-2">
                <input type="date" id="check_out_date_search" class="form-control form-control-sm search-filter" placeholder="Check-out Date">
            </div>
            <div class="col-md-1">
                <button id="applyFilters" class="btn btn-sm btn-primary">Apply</button>
            </div>
        </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered" id="bookingDataTable">
           <thead>
                    <tr>
                    <th>Booking ID</th>
                    <th>Transaction ID</th>
                    <th>Guest Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>User Type</th>
                    <th>Room</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Guests</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Payment Status</th>
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
function getBookings() {
    var table = jQuery('#bookingDataTable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searching: true,
        paging: true,
        bFilter: true,
        bInfo: true,
        ajax: {
            url: "{{ url('admin/booking-room/get/list') }}",
            type: 'GET',
            data: function(d) {
                d.booking_id = $('#booking_id_search').val();
                d.transaction_id = $('#transaction_id_search').val();
                d.guest_name = $('#guest_name_search').val();
                d.guest_email = $('#guest_email_search').val();
                d.room_number = $('#room_number_search').val();
                d.status = $('#status_search').val();
                d.payment_status = $('#payment_status_search').val();
                d.check_in_date = $('#check_in_date_search').val();
                d.check_out_date = $('#check_out_date_search').val();
                d.user_type = $('#user_type_search').val(); // New filter
            },
        },
        aLengthMenu: [
            [10, 25, 50, 100, 500, -1],
            [10, 25, 50, 100, 500, "All"]
        ],
        iDisplayLength: 25,
        "order": [[0, 'desc']],
        columns: [
            { data: 'booking_id', name: 'id', title: 'Booking ID' },
            { data: 'transaction_id', name: 'transaction_id', title: 'Transaction ID' },
            { data: 'guest_name', name: 'guest_name', title: 'Guest Name', orderable: false },
            { data: 'guest_email', name: 'guest_email', title: 'Email' },
            { data: 'guest_phone', name: 'guest_phone', title: 'Phone' },
            { data: 'user_type', name: 'user_id', title: 'User Type' },
            { data: 'room_info', name: 'room.room_number', title: 'Room', orderable: false },
            { data: 'check_in_date', name: 'check_in_date', title: 'Check-in' },
            { data: 'check_out_date', name: 'check_out_date', title: 'Check-out' },
            { data: 'number_of_guests', name: 'number_of_guests', title: 'Guests' },
            { data: 'total_amount', name: 'total_amount', title: 'Total Amount' },
            { data: 'status', name: 'status', title: 'Status' },
            { data: 'payment_status', name: 'payment_status', title: 'Payment Status' },
            { 
                data: 'action', 
                name: 'action', 
                title: 'Actions',
                orderable: false, 
                searchable: false, 
                className: "text-center" 
            },
        ]
    });

    // Add search input field for global search
    $('#bookingDataTable_filter').html('<label>Search:<input type="search" class="form-control form-control-sm" placeholder="Global search..." id="globalSearch"></label>');
    
    // Add event listener for global search
    $('#globalSearch').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Apply filters on button click
    $('#applyFilters').on('click', function() {
        table.draw();
    });

    // Clear filters
    $('#clearFilters').on('click', function() {
        $('.search-filter').val('');
        table.draw();
    });

    return table;
}

getBookings();

      
$(document).on('click', '.delete_btn', function(e) {
    e.preventDefault();
    
    const bookingId = $(this).data('id');
    const transactionId = $(this).data('transaction-id');
    const guestName = $(this).data('guest-name');
    
    Swal.fire({
        title: 'Are you sure?',
        html: `You are about to delete booking:<br>
               <strong>#${bookingId}</strong><br>
               Transaction: <strong>${transactionId}</strong><br>
               Guest: <strong>${guestName}</strong>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return $.ajax({
                url: `{{ url('/admin/booking-room/delete/') }}/${bookingId}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json'
            }).then(response => {
                return response;
            }).catch(error => {
                Swal.showValidationMessage(
                    `Request failed: ${error.responseJSON?.message || error.statusText}`
                );
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            if (result.value.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: result.value.message,
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    if (result.value.redirect) {
                        window.location.href = result.value.redirect;
                    } else {
                        // Reload DataTable if on listing page
                        if (typeof table !== 'undefined') {
                            table.ajax.reload();
                        }
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: result.value.message
                });
            }
        }
    });
});
    </script>

@endsection
