@extends('backend.include.app')

@section('title', 'Edit Booking #' . $booking->id . ' - Hotel Paradise')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-edit me-2"></i>
                            Edit Booking: #{{ $booking->id }}
                        </h5>
                        <div>
                            <a href="{{ route('booking.room.view', $booking->id) }}" class="btn btn-outline-secondary btn-sm me-2">
                                <i class="fas fa-arrow-left me-1"></i> Back to View
                            </a>
                            <a href="{{ route('booking.room') }}" class="btn btn-outline-secondary btn-sm me-2">
                                <i class="fas fa-list me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="editBookingForm" method="POST" action="{{ route('booking.room.update', $booking->id) }}">
                   @csrf
                    @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-8">
                                <!-- Guest Information -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Guest Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>First Name *</label>
                                                    <input type="text" name="guest_first_name" class="form-control" 
                                                           value="{{ old('guest_first_name', $booking->guest_first_name) }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Last Name *</label>
                                                    <input type="text" name="guest_last_name" class="form-control" 
                                                           value="{{ old('guest_last_name', $booking->guest_last_name) }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email *</label>
                                                    <input type="email" name="guest_email" class="form-control" 
                                                           value="{{ old('guest_email', $booking->guest_email) }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Phone</label>
                                                    <input type="text" name="guest_phone" class="form-control" 
                                                           value="{{ old('guest_phone', $booking->guest_phone) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <textarea name="guest_address" class="form-control" rows="2">{{ old('guest_address', $booking->guest_address) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <input type="text" name="guest_city" class="form-control" 
                                                           value="{{ old('guest_city', $booking->guest_city) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Country</label>
                                                    <input type="text" name="guest_country" class="form-control" 
                                                           value="{{ old('guest_country', $booking->guest_country) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>ZIP Code</label>
                                                    <input type="text" name="guest_zip_code" class="form-control" 
                                                           value="{{ old('guest_zip_code', $booking->guest_zip_code) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Booking Details -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Booking Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Room *</label>
                                                    <select name="room_id" class="form-control" required>
                                                        <option value="">Select Room</option>
                                                        @foreach($rooms as $room)
                                                            <option value="{{ $room->id }}" 
                                                                {{ $booking->room_id == $room->id ? 'selected' : '' }}>
                                                                {{ $room->room_number }} - {{ $room->room_type }} ({{ $room->bed_type }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Number of Guests *</label>
                                                    <input type="number" name="number_of_guests" class="form-control" 
                                                           value="{{ old('number_of_guests', $booking->number_of_guests) }}" min="1" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Number of Rooms *</label>
                                                    <input type="number" name="number_of_rooms" class="form-control" 
                                                           value="{{ old('number_of_rooms', $booking->number_of_rooms) }}" min="1" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Booking Source</label>
                                                    <select name="booking_source" class="form-control">
                                                        @foreach($booking_sources as $source)
                                                            <option value="{{ $source }}" 
                                                                {{ $booking->booking_source == $source ? 'selected' : '' }}>
                                                                {{ ucfirst(str_replace('_', ' ', $source)) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Check-in Date *</label>
                                                    <input type="date" name="check_in_date" class="form-control" 
                                                           value="{{ old('check_in_date', $booking->check_in_date->format('Y-m-d')) }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Check-out Date *</label>
                                                    <input type="date" name="check_out_date" class="form-control" 
                                                           value="{{ old('check_out_date', $booking->check_out_date->format('Y-m-d')) }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Special Requests -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Special Requests & Notes</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Special Requests</label>
                                            <textarea name="special_requests" class="form-control" rows="3">{{ old('special_requests', $booking->special_requests) }}</textarea>
                                        </div>
                                        @if(auth()->user()->role == 1)
                                        <div class="form-group mt-3">
                                            <label>Admin Notes</label>
                                            <textarea name="admin_notes" class="form-control" rows="3">{{ old('admin_notes', $booking->admin_notes) }}</textarea>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Status & Payment -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Status & Payment</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Status *</label>
                                            <select name="status" class="form-control" required>
                                                @foreach($statuses as $status)
                                                    <option value="{{ $status }}" 
                                                        {{ $booking->status == $status ? 'selected' : '' }}>
                                                        {{ ucfirst($status) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label>Payment Status *</label>
                                            <select name="payment_status" class="form-control" required>
                                                @foreach($payment_statuses as $status)
                                                    <option value="{{ $status }}" 
                                                        {{ $booking->payment_status == $status ? 'selected' : '' }}>
                                                        {{ ucfirst($status) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label>Payment Method</label>
                                            <select name="payment_method" class="form-control">
                                                <option value="">Select Method</option>
                                                @foreach($payment_methods as $method)
                                                    <option value="{{ $method }}" 
                                                        {{ $booking->payment_method == $method ? 'selected' : '' }}>
                                                        {{ ucfirst(str_replace('_', ' ', $method)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label>Currency *</label>
                                            <select name="currency" class="form-control" required>
                                                @foreach($currencies as $code => $name)
                                                    <option value="{{ $code }}" 
                                                        {{ $booking->currency == $code ? 'selected' : '' }}>
                                                        {{ $name }} ({{ $code }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mt-3" id="cancellationReasonField" 
                                             style="{{ $booking->status == 'cancelled' ? '' : 'display: none;' }}">
                                            <label>Cancellation Reason</label>
                                            <textarea name="cancellation_reason" class="form-control" rows="2">{{ old('cancellation_reason', $booking->cancellation_reason) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                           <!-- Pricing Information (Dynamic) -->
<div class="card mb-4">
    <div class="card-header bg-light">
        <h6 class="mb-0">Pricing Information</h6>
        <small class="text-muted">(Automatically calculated)</small>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <span>Room Price/Night:</span>
            <span data-price="room_price">{{ $booking->currency }} {{ number_format($booking->room_price_per_night, 2) }}</span>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <span>Nights:</span>
            <span data-price="nights">{{ $booking->number_of_nights }}</span>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <span>Rooms:</span>
            <span data-price="rooms">{{ $booking->number_of_rooms }}</span>
        </div>
        <hr>
        <div class="d-flex justify-content-between mb-2">
            <span>Subtotal:</span>
            <span data-price="sub_total">{{ $booking->currency }} {{ number_format($booking->sub_total, 2) }}</span>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <span>Tax (10%):</span>
            <span data-price="tax_amount">{{ $booking->currency }} {{ number_format($booking->tax_amount, 2) }}</span>
        </div>
        @if($booking->discount_amount > 0)
        <div class="d-flex justify-content-between mb-2 text-success">
            <span>Discount:</span>
            <span>-{{ $booking->currency }} {{ number_format($booking->discount_amount, 2) }}</span>
        </div>
        @endif
        <hr>
        <div class="d-flex justify-content-between fw-bold">
            <span>Total:</span>
            <span data-price="total_amount">{{ $booking->currency }} {{ number_format($booking->total_amount, 2) }}</span>
        </div>
        
        <!-- Hidden fields to store calculated values for form submission -->
        <input type="hidden" name="number_of_nights" value="{{ $booking->number_of_nights }}">
        <input type="hidden" name="room_price_per_night" value="{{ $booking->room_price_per_night }}">
        <input type="hidden" name="sub_total" value="{{ $booking->sub_total }}">
        <input type="hidden" name="tax_amount" value="{{ $booking->tax_amount }}">
        <input type="hidden" name="total_amount" value="{{ $booking->total_amount }}">
    </div>
</div>

                                <!-- Action Buttons -->
                                <div class="card">
                                    <div class="card-body">
                                        <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                                            <i class="fas fa-save me-2"></i> Update Booking
                                        </button>
                                        <a href="{{ route('booking.room.view', $booking->id) }}" class="btn btn-outline-secondary w-100 mt-2">
                                            <i class="fas fa-times me-2"></i> Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Room prices cache
    const roomPrices = {
        @foreach($rooms as $room)
            {{ $room->id }}: {{ $room->price }},
        @endforeach
    };

    // Exchange rates
    const exchangeRates = {
        'USD': 1.0,
        'EUR': 0.85,
        'GBP': 0.75,
        'INR': 75.0
    };

    // Show/hide cancellation reason based on status
    $('select[name="status"]').change(function() {
        if ($(this).val() === 'cancelled') {
            $('#cancellationReasonField').show();
        } else {
            $('#cancellationReasonField').hide();
        }
    });

    // Calculate and update pricing when relevant fields change
    function updatePricing() {
        const roomId = $('select[name="room_id"]').val();
        const checkInDate = new Date($('input[name="check_in_date"]').val());
        const checkOutDate = new Date($('input[name="check_out_date"]').val());
        const numberOfRooms = parseInt($('input[name="number_of_rooms"]').val()) || 1;
        const currency = $('select[name="currency"]').val();
        
        // Validate dates
        if (!roomId || isNaN(checkInDate) || isNaN(checkOutDate) || checkOutDate <= checkInDate) {
            return;
        }

        // Calculate number of nights
        const oneDay = 24 * 60 * 60 * 1000;
        const numberOfNights = Math.round(Math.abs((checkOutDate - checkInDate) / oneDay));

        // Get room price and convert currency
        const roomPriceUSD = roomPrices[roomId] || 0;
        const roomPrice = roomPriceUSD * (exchangeRates[currency] / exchangeRates['USD']);
        
        // Calculate amounts
        const subTotal = roomPrice * numberOfNights * numberOfRooms;
        const taxAmount = subTotal * 0.1; // 10% tax
        const totalAmount = subTotal + taxAmount;

        // Update the pricing display
        $('[data-price="room_price"]').text(`${currency} ${roomPrice.toFixed(2)}`);
        $('[data-price="nights"]').text(numberOfNights);
        $('[data-price="rooms"]').text(numberOfRooms);
        $('[data-price="sub_total"]').text(`${currency} ${subTotal.toFixed(2)}`);
        $('[data-price="tax_amount"]').text(`${currency} ${taxAmount.toFixed(2)}`);
        $('[data-price="total_amount"]').text(`${currency} ${totalAmount.toFixed(2)}`);
    }

    // Attach event listeners for pricing updates
    $('select[name="room_id"], input[name="check_in_date"], input[name="check_out_date"], input[name="number_of_rooms"], select[name="currency"]')
        .on('change input', updatePricing);

    // Initial pricing calculation
    updatePricing();

   
       $('#editBookingForm').on('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Updating Room',
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                const formData = new FormData(this);
                
                // Add all selected files to FormData
                if (selectedFiles.length > 0) {
                    for (let i = 0; i < selectedFiles.length; i++) {
                        formData.append('images[]', selectedFiles[i]);
                    }
                }
                
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.close();
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{ route('booking.room') }}";
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.close();
                        let errorMessage = 'An error occurred while updating the room.';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = '';
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                errorMessage += value + '<br>';
                            });
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: errorMessage,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
});
</script>
<script>
    // Calculate and update pricing when relevant fields change
function updatePricing() {
    const roomId = $('select[name="room_id"]').val();
    const checkInDate = new Date($('input[name="check_in_date"]').val());
    const checkOutDate = new Date($('input[name="check_out_date"]').val());
    const numberOfRooms = parseInt($('input[name="number_of_rooms"]').val()) || 1;
    const currency = $('select[name="currency"]').val();
    
    // Validate dates
    if (!roomId || isNaN(checkInDate) || isNaN(checkOutDate) || checkOutDate <= checkInDate) {
        return;
    }

    // Calculate number of nights
    const oneDay = 24 * 60 * 60 * 1000;
    const numberOfNights = Math.round(Math.abs((checkOutDate - checkInDate) / oneDay));

    // Get room price and convert currency
    const roomPriceUSD = roomPrices[roomId] || 0;
    const roomPrice = roomPriceUSD * (exchangeRates[currency] / exchangeRates['USD']);
    
    // Calculate amounts
    const subTotal = roomPrice * numberOfNights * numberOfRooms;
    const taxAmount = subTotal * 0.1; // 10% tax
    const totalAmount = subTotal + taxAmount;

    // Update the pricing display
    $('[data-price="room_price"]').text(`${currency} ${roomPrice.toFixed(2)}`);
    $('[data-price="nights"]').text(numberOfNights);
    $('[data-price="rooms"]').text(numberOfRooms);
    $('[data-price="sub_total"]').text(`${currency} ${subTotal.toFixed(2)}`);
    $('[data-price="tax_amount"]').text(`${currency} ${taxAmount.toFixed(2)}`);
    $('[data-price="total_amount"]').text(`${currency} ${totalAmount.toFixed(2)}`);

    // Update hidden form fields for submission
    $('input[name="number_of_nights"]').val(numberOfNights);
    $('input[name="room_price_per_night"]').val(roomPrice.toFixed(2));
    $('input[name="sub_total"]').val(subTotal.toFixed(2));
    $('input[name="tax_amount"]').val(taxAmount.toFixed(2));
    $('input[name="total_amount"]').val(totalAmount.toFixed(2));
}
</script>
@endsection