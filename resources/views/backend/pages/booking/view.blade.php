@extends('backend.include.app')

@section('title', 'Booking #' . $booking->id . ' - Hotel Paradise')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-receipt me-2"></i>
                            Booking Details: #{{ $booking->id }}
                        </h5>
                        <div>
                            <a href="{{ route('booking.room') }}" class="btn btn-outline-secondary btn-sm me-2">
                                <i class="fas fa-arrow-left me-1"></i> Back to List
                            </a>
                            @if($canEdit)
                                <a href="{{ route('booking.room.edit', $booking->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit me-1"></i> Edit Booking
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Booking Status Card -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Booking Status</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Status:</strong>
                                            <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'checked_in' ? 'primary' : ($booking->status === 'checked_out' ? 'info' : ($booking->status === 'cancelled' ? 'danger' : 'warning'))) }} ms-2">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Payment Status:</strong>
                                            <span class="badge bg-{{ $booking->payment_status === 'paid' ? 'success' : ($booking->payment_status === 'pending' ? 'warning' : 'danger') }} ms-2">
                                                {{ ucfirst($booking->payment_status) }}
                                            </span>
                                        </div>
                                    </div>
                                    @if($booking->transaction_id)
                                        <div class="mt-2">
                                            <strong>Transaction ID:</strong> {{ $booking->transaction_id }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Guest Information Card -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Guest Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Name:</strong> {{ $booking->guest_first_name }} {{ $booking->guest_last_name }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Email:</strong> {{ $booking->guest_email }}
                                        </div>
                                    </div>
                                    @if($booking->guest_phone)
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <strong>Phone:</strong> {{ $booking->guest_phone }}
                                            </div>
                                        </div>
                                    @endif
                                    @if($booking->guest_address || $booking->guest_city || $booking->guest_country)
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <strong>Address:</strong><br />
                                                @if($booking->guest_address){{ $booking->guest_address }}, @endif
                                                @if($booking->guest_city){{ $booking->guest_city }}, @endif
                                                @if($booking->guest_country){{ $booking->guest_country }}@endif
                                                @if($booking->guest_zip_code), {{ $booking->guest_zip_code }}@endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Booking Details Card -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Booking Details</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Check-in:</strong> {{ \Carbon\Carbon::parse($booking->check_in_date)->format('F d, Y') }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Check-out:</strong> {{ \Carbon\Carbon::parse($booking->check_out_date)->format('F d, Y') }}
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <strong>Nights:</strong> {{ $booking->number_of_nights }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Guests:</strong> {{ $booking->number_of_guests }}
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <strong>Rooms:</strong> {{ $booking->number_of_rooms }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Booking Source:</strong> {{ ucfirst(str_replace('_', ' ', $booking->booking_source)) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Special Requests Card -->
                            @if($booking->special_requests)
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Special Requests</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0">{{ $booking->special_requests }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Admin Notes Card -->
                            @if($booking->admin_notes)
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Admin Notes</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0 text-muted">{{ $booking->admin_notes }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <!-- Room Information Card -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Room Information</h6>
                                </div>
                                <div class="card-body">
                                    @if($booking->room)
                                        <div class="text-center mb-3">
     @php
    $images = is_string($booking->room->images) 
                ? json_decode($booking->room->images, true) 
                : $booking->room->images;
    $images = is_array($images) ? $images : [];
@endphp

@if(count($images) > 0)
    <div class="text-center mb-3">
        {{-- Main image --}}
        <img src="{{ asset($images[0]) }}" 
             alt="{{ $booking->room->room_type }}" 
             class="img-fluid rounded mb-3" 
             style="max-height: 300px; object-fit: cover;">

        {{-- Thumbnails --}}
        @if(count($images) > 1)
            <div class="d-flex flex-wrap justify-content-center gap-2">
                @foreach($images as $key => $image)
                    @if($key > 0)
                        <img src="{{ asset($image) }}" 
                             alt="Room image {{ $key + 1 }}" 
                             class="img-thumbnail" 
                             style="width: 100px; height: 80px; object-fit: cover;">
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@else
    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
        <i class="fas fa-image fa-3x text-muted"></i>
    </div>
@endif


                                        </div>
                                        <h6>{{ $booking->room->room_type }} Room</h6>
                                        <p class="mb-1"><strong>Room Number:</strong> {{ $booking->room->room_number }}</p>
                                        <p class="mb-1"><strong>Bed Type:</strong> {{ $booking->room->bed_type }}</p>
                                        <p class="mb-1"><strong>Capacity:</strong> {{ $booking->room->capacity }} Guests</p>
                                        <p class="mb-0"><strong>Price per Night:</strong> {{ $booking->currency }} {{ number_format($booking->room_price_per_night, 2) }}</p>
                                    @else
                                        <p class="text-muted">Room information not available</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Pricing Card -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Pricing Details</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Room Charges:</span>
                                        <span>{{ $booking->currency }} {{ number_format($booking->sub_total, 2) }}</span>
                                    </div>
                                    @if($booking->tax_amount > 0)
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Tax ({{ $booking->sub_total > 0 ? number_format(($booking->tax_amount / $booking->sub_total) * 100, 2) : 0 }}%):</span>
                                            <span>{{ $booking->currency }} {{ number_format($booking->tax_amount, 2) }}</span>
                                        </div>
                                    @endif
                                    @if($booking->discount_amount > 0)
                                        <div class="d-flex justify-content-between mb-2 text-success">
                                            <span>Discount:</span>
                                            <span>-{{ $booking->currency }} {{ number_format($booking->discount_amount, 2) }}</span>
                                        </div>
                                    @endif
                                    <hr />
                                    <div class="d-flex justify-content-between fw-bold">
                                        <span>Total Amount:</span>
                                        <span>{{ $booking->currency }} {{ number_format($booking->total_amount, 2) }}</span>
                                    </div>
                                    <div class="mt-2 small text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Payment Method: {{ $booking->payment_method ? ucfirst(str_replace('_', ' ', $booking->payment_method)) : 'Not specified' }}
                                    </div>
                                    @if($booking->payment_date)
                                        <div class="mt-1 small text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            Paid on: {{ \Carbon\Carbon::parse($booking->payment_date)->format('F d, Y') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Timeline Card -->
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Booking Timeline</h6>
                                </div>
                                <div class="card-body">
                                    <div class="timeline">
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-primary"></div>
                                            <div class="timeline-content">
                                                <small class="text-muted">Created</small>
                                                <p class="mb-0">{{ $booking->created_at->format('M d, Y h:i A') }}</p>
                                            </div>
                                        </div>
                                        @if($booking->checked_in_at)
                                            <div class="timeline-item">
                                                <div class="timeline-marker bg-success"></div>
                                                <div class="timeline-content">
                                                    <small class="text-muted">Checked In</small>
                                                    <p class="mb-0">{{ \Carbon\Carbon::parse($booking->checked_in_at)->format('M d, Y h:i A') }}</p>
                                                </div>
                                            </div>
                                        @endif
                                        @if($booking->checked_out_at)
                                            <div class="timeline-item">
                                                <div class="timeline-marker bg-info"></div>
                                                <div class="timeline-content">
                                                    <small class="text-muted">Checked Out</small>
                                                    <p class="mb-0">{{ \Carbon\Carbon::parse($booking->checked_out_at)->format('M d, Y h:i A') }}</p>
                                                </div>
                                            </div>
                                        @endif
                                        @if($booking->cancelled_at)
                                            <div class="timeline-item">
                                                <div class="timeline-marker bg-danger"></div>
                                                <div class="timeline-content">
                                                    <small class="text-muted">Cancelled</small>
                                                    <p class="mb-0">{{ \Carbon\Carbon::parse($booking->cancelled_at)->format('M d, Y h:i A') }}</p>
                                                    @if($booking->cancellation_reason)
                                                        <small class="text-muted">Reason: {{ $booking->cancellation_reason }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}
.timeline-item {
    position: relative;
    margin-bottom: 20px;
}
.timeline-marker {
    position: absolute;
    left: -30px;
    top: 5px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
}
.timeline-content {
    margin-left: 10px;
}
.timeline-item:not(:last-child):before {
    content: '';
    position: absolute;
    left: -23px;
    top: 21px;
    bottom: -21px;
    width: 2px;
    background-color: #dee2e6;
}
</style>
@endsection