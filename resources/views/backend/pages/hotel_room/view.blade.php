@extends('backend.include.app')
@section('title', 'Room Details')
@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mt-2"><i class="fas fa-hotel me-2"></i> Room Details</h4>
                    <p class="lead mb-0">Complete information about the room</p>
                </div>
                <div>
                    <a href="{{ route('hotel.room') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                    <a href="{{ route('hotel.room.edit', $room->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Room
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Room Details Card -->
    <div class="row">
        <div class="col-lg-8">
            <!-- Basic Information Card -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-primary">Room Number</label>
                                <p class="form-control-static bg-light p-2 rounded">{{ $room->room_number }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-primary">Room Type</label>
                                <p class="form-control-static bg-light p-2 rounded text-capitalize">{{ $room->room_type }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-primary">Price per Night</label>
                                <p class="form-control-static bg-light p-2 rounded">${{ number_format($room->price, 2) }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-primary">Capacity</label>
                                <p class="form-control-static bg-light p-2 rounded">{{ $room->capacity }} Guest(s)</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-primary">Bed Type</label>
                                <p class="form-control-static bg-light p-2 rounded text-capitalize">{{ $room->bed_type }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-primary">Room Size</label>
                                <p class="form-control-static bg-light p-2 rounded">{{ $room->size ? $room->size . ' sq ft' : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-primary">Status</label>
                                <p class="form-control-static">
                                    @if($room->status == 'available')
                                        <span class="badge bg-success fs-6">Available</span>
                                    @elseif($room->status == 'occupied')
                                        <span class="badge bg-primary fs-6">Occupied</span>
                                    @elseif($room->status == 'maintenance')
                                        <span class="badge bg-warning fs-6">Under Maintenance</span>
                                    @elseif($room->status == 'cleaning')
                                        <span class="badge bg-info fs-6">Cleaning in Progress</span>
                                    @else
                                        <span class="badge bg-secondary fs-6">Unknown</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-primary">Created Date</label>
                                <p class="form-control-static bg-light p-2 rounded">{{ $room->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Card -->
            @if($room->description)
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-align-left me-2"></i>Description</h5>
                </div>
                <div class="card-body">
                    <div class="bg-light p-3 rounded">
                      {!! $room->description !!}
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Amenities Card -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-star me-2"></i>Amenities</h5>
                </div>
                <div class="card-body">
                    @if(count($room->amenities) > 0)
                    <div class="row">
                        @foreach($room->amenities as $amenity)
                        <div class="col-md-6 mb-2">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success-soft text-success me-2">✓</span>
                                <span class="text-capitalize">{{ $amenity }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-info-circle fa-2x mb-2"></i>
                        <p>No amenities added</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Room Images Card -->
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0"><i class="fas fa-images me-2"></i>Room Images</h5>
                </div>
                <div class="card-body">
                    @if(count($room->images) > 0)
                    <div class="row g-2">
                        @foreach($room->images as $image)
                        <div class="col-6 col-md-4">
                            <a href="{{ asset($image) }}" data-fancybox="gallery" data-caption="Room Image">
                                <img src="{{ asset($image) }}" alt="Room Image" class="img-fluid rounded shadow-sm" style="height: 100px; width: 100%; object-fit: cover;">
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-camera fa-2x mb-2"></i>
                        <p>No images uploaded</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card">
                <div class="card-header ">
                    <h5 class="card-title mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('hotel.room.edit', $room->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Room
                        </a>
                        <button class="btn btn-outline-danger" onclick="confirmDelete({{ $room->id }})">
                            <i class="fas fa-trash me-2"></i>Delete Room
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
    .form-control-static {
        min-height: 44px;
        display: flex;
        align-items: center;
        border: 1px solid #e9ecef;
    }
    .card {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border-radius: 0.75rem;
    }
    .card-header {
        border-radius: 0.75rem 0.75rem 0 0 !important;
        font-weight: 600;
    }
    .bg-success-soft {
        background-color: rgba(25, 135, 84, 0.1) !important;
    }
    .img-thumb {
        transition: transform 0.3s ease;
    }
    .img-thumb:hover {
        transform: scale(1.05);
    }
</style>
<!-- Include Fancybox for image gallery -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
@endsection

@section('script')
<!-- Include Fancybox for image gallery -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    // Initialize Fancybox
    Fancybox.bind("[data-fancybox]", {
        // Your custom options
    });

    function confirmDelete(roomId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/hotel-room') }}/" + roomId,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Deleted!',
                                'Room has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.href = "{{ route('hotel.room') }}";
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Failed to delete room.',
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>
@endsection