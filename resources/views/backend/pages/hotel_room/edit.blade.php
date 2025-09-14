@extends('backend.include.app')
@section('title', 'Room Edit')
@section('content')
    <div class="container-fluid px-4">
        <h4 class="mt-2">Room Create</h4>

        <div class="card my-2">
            <div class="card-body">
                   <form action="{{ route('hotel.room.update', $room->id) }}" method="post" id="roomEditForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="roomNumber" class="form-label required-field">Room Number</label>
                                <input type="text" class="form-control" id="roomNumber" name="room_number" value="{{ $room->room_number }}" placeholder="e.g., 101" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="roomType" class="form-label required-field">Room Type</label>
                                <select class="form-select" id="roomType" name="room_type" required>
                                    <option value="">Select Room Type</option>
                                    <option value="single" {{ $room->room_type == 'single' ? 'selected' : '' }}>Single Room</option>
                                    <option value="double" {{ $room->room_type == 'double' ? 'selected' : '' }}>Double Room</option>
                                    <option value="twin" {{ $room->room_type == 'twin' ? 'selected' : '' }}>Twin Room</option>
                                    <option value="suite" {{ $room->room_type == 'suite' ? 'selected' : '' }}>Suite</option>
                                    <option value="deluxe" {{ $room->room_type == 'deluxe' ? 'selected' : '' }}>Deluxe Room</option>
                                    <option value="presidential" {{ $room->room_type == 'presidential' ? 'selected' : '' }}>Presidential Suite</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="price" class="form-label required-field">Price per Night ($)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="price" name="price" value="{{ $room->price }}" min="0" step="0.01" placeholder="0.00" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="capacity" class="form-label required-field">Capacity (Guests)</label>
                                <input type="number" class="form-control" id="capacity" name="capacity" value="{{ $room->capacity }}" min="1" max="10" placeholder="2" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="size" class="form-label">Size (sq ft)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="size" name="size" value="{{ $room->size }}" min="0" placeholder="e.g., 350">
                                    <span class="input-group-text">sq ft</span>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="bedType" class="form-label required-field">Bed Type</label>
                                <select class="form-select" id="bedType" name="bed_type" required>
                                    <option value="">Select Bed Type</option>
                                    <option value="king" {{ $room->bed_type == 'king' ? 'selected' : '' }}>King Size</option>
                                    <option value="queen" {{ $room->bed_type == 'queen' ? 'selected' : '' }}>Queen Size</option>
                                    <option value="double" {{ $room->bed_type == 'double' ? 'selected' : '' }}>Double</option>
                                    <option value="twin" {{ $room->bed_type == 'twin' ? 'selected' : '' }}>Twin</option>
                                    <option value="single" {{ $room->bed_type == 'single' ? 'selected' : '' }}>Single</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label required-field">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="occupied" {{ $room->status == 'occupied' ? 'selected' : '' }}>Occupied</option>
                                    <option value="maintenance" {{ $room->status == 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                                    <option value="cleaning" {{ $room->status == 'cleaning' ? 'selected' : '' }}>Cleaning in Progress</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="images" class="form-label">Room Images</label>
                                <div class="file-input-wrapper">
                                    <button type="button" class="btn btn-primary mb-3">
                                        <i class="fas fa-plus me-2"></i>Add Images
                                    </button>
                                    <input class="form-control d-none" type="file" id="images" name="images[]" multiple accept="image/*">
                                </div>
                                <div class="form-text">You can select multiple images or drag & drop them</div>
                                
                                <!-- Image Preview Container -->
                                <div class="image-preview-container mt-3" id="imagePreviewContainer">
                                    <!-- Existing images -->
                                    @if($room->images)
    @php
        $roomImages = json_decode($room->images, true);
    @endphp
    @if(is_array($roomImages) && count($roomImages) > 0)
        @foreach($roomImages as $image)
            @if(!empty($image))
                <div class="image-preview">
                    <img src="{{ asset($image) }}" alt="Room Image" onerror="this.style.display='none'">
                    <input type="hidden" name="existing_images[]" value="{{ $image }}">
                    <span class="remove-existing-image" data-image="{{ $image }}">&times;</span>
                </div>
            @endif
        @endforeach
    @endif
@endif
                                </div>
                                
                                <div class="image-actions mt-2">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="addMoreImages">
                                        <i class="fas fa-plus me-1"></i>Add More
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm" id="removeAllImages">
                                        <i class="fas fa-trash me-1"></i>Remove All
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label">Amenities</label>
                            <div class="row">
                                @php
                                    $amenities = $room->amenities ? json_decode($room->amenities, true) : [];
                                @endphp
                                <div class="col-md-3">
                                    <div class="form-check amenity-checkbox">
                                        <input class="form-check-input" type="checkbox" value="wifi" id="wifi" name="amenities[]" {{ in_array('wifi', $amenities) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="wifi">
                                            <i class="fas fa-wifi me-2"></i>Wi-Fi
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check amenity-checkbox">
                                        <input class="form-check-input" type="checkbox" value="tv" id="tv" name="amenities[]" {{ in_array('tv', $amenities) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tv">
                                            <i class="fas fa-tv me-2"></i>TV
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check amenity-checkbox">
                                        <input class="form-check-input" type="checkbox" value="ac" id="ac" name="amenities[]" {{ in_array('ac', $amenities) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ac">
                                            <i class="fas fa-snowflake me-2"></i>Air Conditioning
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check amenity-checkbox">
                                        <input class="form-check-input" type="checkbox" value="heating" id="heating" name="amenities[]" {{ in_array('heating', $amenities) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="heating">
                                            <i class="fas fa-temperature-high me-2"></i>Heating
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check amenity-checkbox">
                                        <input class="form-check-input" type="checkbox" value="minibar" id="minibar" name="amenities[]" {{ in_array('minibar', $amenities) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="minibar">
                                            <i class="fas fa-glass-cheers me-2"></i>Minibar
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check amenity-checkbox">
                                        <input class="form-check-input" type="checkbox" value="safe" id="safe" name="amenities[]" {{ in_array('safe', $amenities) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="safe">
                                            <i class="fas fa-lock me-2"></i>Safe
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check amenity-checkbox">
                                        <input class="form-check-input" type="checkbox" value="balcony" id="balcony" name="amenities[]" {{ in_array('balcony', $amenities) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="balcony">
                                            <i class="fas fa-home me-2"></i>Balcony
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check amenity-checkbox">
                                        <input class="form-check-input" type="checkbox" value="view" id="view" name="amenities[]" {{ in_array('view', $amenities) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="view">
                                            <i class="fas fa-mountain me-2"></i>View
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="tinymceText form-control" id="description" name="description" rows="4" placeholder="Enter room description...">{{ $room->description }}</textarea>
                   
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-save me-2"></i>Update Room
                        </button>
                        <a href="{{ route('hotel.room') }}" class="btn btn-outline-secondary btn-lg px-4">
                            <i class="fas fa-arrow-left me-2"></i>Back to List
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
       .image-preview-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 15px;
}
.image-preview {
    position: relative;
    width: 100px;  /* Change this value to adjust width */
    height: 100px; /* Change this value to adjust height */
    border: 2px dashed #ddd;
    border-radius: 6px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.image-preview img {
    width: 10px;
    height: 10px;
    object-fit: cover;
}
.remove-image {
    position: absolute;
    top: 3px;
    right: 3px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-weight: bold;
    color: #ff0000;
    font-size: 14px;
}
        .upload-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            cursor: pointer;
            height: 100%;
        }
        .upload-placeholder i {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        .image-preview-container.empty:after {
            content: "No images selected. Click 'Add Images' or drag & drop images here.";
            display: block;
            width: 10px;
            text-align: center;
            color: #6c757d;
            padding: 20px;
        }
        .image-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
        .required-field::after {
            content: "*";
            color: red;
            margin-left: 4px;
        }
    </style>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Store the selected files
            let selectedFiles = [];
            
            // File input element
            const fileInput = $('#images');
            const previewContainer = $('#imagePreviewContainer');
            
            // Function to handle file selection
            function handleFileSelect(e) {
                const files = e.target.files;
                
                if (files.length > 0) {
                    for (let i = 0; i < files.length; i++) {
                        selectedFiles.push(files[i]);
                    }
                    updateImagePreviews();
                }
            }
            
            // Function to update image previews
            function updateImagePreviews() {
                // Don't clear existing images, just add new ones
                selectedFiles.forEach((file, index) => {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const previewItem = $(
                            '<div class="image-preview">' +
                                '<img src="' + e.target.result + '" alt="Preview">' +
                                '<span class="remove-image" data-index="' + index + '">&times;</span>' +
                            '</div>'
                        );
                        
                        previewContainer.append(previewItem);
                    };
                    
                    reader.readAsDataURL(file);
                });
            }
            
            // Handle click on the custom button to trigger file input
            $('.file-input-wrapper button').click(function(e) {
                e.preventDefault();
                fileInput.click();
            });
            
            // Handle file selection
            fileInput.on('change', handleFileSelect);
            
            // Handle adding more images
            $('#addMoreImages').click(function() {
                fileInput.click();
            });
            
            // Handle removing all new images
            $('#removeAllImages').click(function() {
                selectedFiles = [];
                $('.image-preview:not(:has(.remove-existing-image))').remove();
                fileInput.val('');
            });
            
            // Handle removing individual new images
            previewContainer.on('click', '.remove-image', function() {
                const index = $(this).data('index');
                selectedFiles.splice(index, 1);
                $(this).parent().remove();
                
                const dataTransfer = new DataTransfer();
                selectedFiles.forEach(file => dataTransfer.items.add(file));
                fileInput[0].files = dataTransfer.files;
            });
            
            // Handle removing existing images
            previewContainer.on('click', '.remove-existing-image', function() {
                const imagePath = $(this).data('image');
                $(this).parent().remove();
                // Add hidden input to track removed images
                $('<input>').attr({
                    type: 'hidden',
                    name: 'removed_images[]',
                    value: imagePath
                }).appendTo('#roomEditForm');
            });
            
            // Ajax form submission
            $('#roomEditForm').on('submit', function(e) {
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
                                    window.location.href = "{{ route('hotel.room') }}";
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
@endsection