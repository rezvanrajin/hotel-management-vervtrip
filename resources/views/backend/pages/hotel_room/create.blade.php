@extends('backend.include.app')
@section('title', 'Room Create')
@section('content')
    <div class="container-fluid px-4">
        <h4 class="mt-2">Room Create</h4>

        <div class="card my-2">
            <div class="card-body">
                <form action="{{ route('hotel.room.store') }}" method="post" id="roomForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="roomNumber" class="form-label required-field">Room Number</label>
                                <input type="text" class="form-control" id="roomNumber" name="room_number" placeholder="e.g., 101" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="roomType" class="form-label required-field">Room Type</label>
                                <select class="form-select" id="roomType" name="room_type" required>
                                    <option value="">Select Room Type</option>
                                    <option value="single">Single Room</option>
                                    <option value="double">Double Room</option>
                                    <option value="twin">Twin Room</option>
                                    <option value="suite">Suite</option>
                                    <option value="deluxe">Deluxe Room</option>
                                    <option value="presidential">Presidential Suite</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="price" class="form-label required-field">Price per Night ($)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" placeholder="0.00" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="capacity" class="form-label required-field">Capacity (Guests)</label>
                                <input type="number" class="form-control" id="capacity" name="capacity" min="1" max="10" placeholder="2" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="size" class="form-label">Size (sq ft)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="size" name="size" min="0" placeholder="e.g., 350">
                                    <span class="input-group-text">sq ft</span>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="bedType" class="form-label required-field">Bed Type</label>
                                <select class="form-select" id="bedType" name="bed_type" required>
                                    <option value="">Select Bed Type</option>
                                    <option value="king">King Size</option>
                                    <option value="queen">Queen Size</option>
                                    <option value="double">Double</option>
                                    <option value="twin">Twin</option>
                                    <option value="single">Single</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label required-field">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="available">Available</option>
                                    <option value="occupied">Occupied</option>
                                    <option value="maintenance">Under Maintenance</option>
                                    <option value="cleaning">Cleaning in Progress</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
    <label for="images" class="form-label">Room Images</label>
    <input class="form-control" type="file" id="images" name="images[]" multiple accept="image/*">

    <div class="mt-3 d-flex flex-wrap gap-2" id="previewContainer"></div>
</div>

                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label">Amenities</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-check amenity-checkbox">
                                        <input class="form-check-input" type="checkbox" value="wifi" id="wifi" name="amenities[]">
                                        <label class="form-check-label" for="wifi">
                                            <i class="fas fa-wifi me-2"></i>Wi-Fi
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check amenity-checkbox">
                                        <input class="form-check-input" type="checkbox" value="tv" id="tv" name="amenities[]">
                                        <label class="form-check-label" for="tv">
                                            <i class="fas fa-tv me-2"></i>TV
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check amenity-checkbox">
                                        <input class="form-check-input" type="checkbox" value="ac" id="ac" name="amenities[]">
                                        <label class="form-check-label" for="ac">
                                            <i class="fas fa-snowflake me-2"></i>Air Conditioning
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check amenity-checkbox">
                                        <input class="form-check-input" type="checkbox" value="heating" id="heating" name="amenities[]">
                                        <label class="form-check-label" for="heating">
                                            <i class="fas fa-temperature-high me-2"></i>Heating
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check amenity-checkbox">
                                        <input class="form-check-input" type="checkbox" value="minibar" id="minibar" name="amenities[]">
                                        <label class="form-check-label" for="minibar">
                                            <i class="fas fa-glass-cheers me-2"></i>Minibar
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check amenity-checkbox">
                                        <input class="form-check-input" type="checkbox" value="safe" id="safe" name="amenities[]">
                                        <label class="form-check-label" for="safe">
                                            <i class="fas fa-lock me-2"></i>Safe
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check amenity-checkbox">
                                        <input class="form-check-input" type="checkbox" value="balcony" id="balcony" name="amenities[]">
                                        <label class="form-check-label" for="balcony">
                                            <i class="fas fa-home me-2"></i>Balcony
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check amenity-checkbox">
                                        <input class="form-check-input" type="checkbox" value="view" id="view" name="amenities[]">
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
                        <textarea class="tinymceText form-control" id="description" name="description" rows="4" placeholder="Enter room description..."></textarea>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-save me-2"></i>Save Room
                        </button>
                        <button type="reset" class="btn btn-outline-secondary btn-lg px-4" id="resetForm">
                            <i class="fas fa-eraser me-2"></i>Clear Form
                        </button>
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
    const fileInput = document.getElementById('images');
    const previewContainer = document.getElementById('previewContainer');

    fileInput.addEventListener('change', function() {
        // Clear old previews
        previewContainer.innerHTML = '';

        // Loop over selected files
        Array.from(this.files).forEach(file => {
            if (!file.type.startsWith('image/')) return; // only images

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-thumbnail');
                img.style.height = '100px';
                img.style.width = '100px';
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
</script>

    {{-- <script>
        $(document).ready(function() {
        

                $('#roomForm').on('submit', function(e) {
                e.preventDefault();
                
                // Show loading indicator
                Swal.fire({
                    title: 'Processing',
                    text: 'Creating room...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Create FormData object to handle file uploads
                const formData = new FormData(this);
                
        
                
                // Ajax request
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Reset form and redirect or clear form
                                    $('#roomForm')[0].reset();
                                    selectedFiles = [];
                                    updateImagePreviews();
                                    
                                    // Optional: Redirect to room list page
                                    window.location.href = "{{ route('hotel.room') }}";
                                }
                            });
                        } else {
                            // Show validation errors
                            if (response.errors) {
                                let errorMessages = '';
                                $.each(response.errors, function(key, value) {
                                    errorMessages += value + '<br>';
                                });
                                
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Validation Error',
                                    html: errorMessages,
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                    confirmButtonText: 'OK'
                                });
                            }
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred while creating the room.';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script> --}}
    
    <script>
$(document).ready(function() {
    const fileInput = $('#images');
    const previewContainer = $('#imagePreviewContainer');
    
    // Function to update image previews
    function updateImagePreviews() {
        previewContainer.empty();
        
        if (fileInput[0].files.length === 0) {
            previewContainer.addClass('empty');
            return;
        }
        
        previewContainer.removeClass('empty');
        
        // Add each image to the preview
        for (let i = 0; i < fileInput[0].files.length; i++) {
            const file = fileInput[0].files[i];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const previewItem = $(
                    '<div class="image-preview">' +
                        '<img src="' + e.target.result + '" alt="Preview">' +
                        '<span class="remove-image" data-index="' + i + '">&times;</span>' +
                    '</div>'
                );
                
                previewContainer.append(previewItem);
            };
            
            reader.readAsDataURL(file);
        }
    }
    
    // Handle click on the custom button to trigger file input
    $('.file-input-wrapper button').click(function(e) {
        e.preventDefault();
        fileInput.click();
    });
    
    // Handle file selection
    fileInput.on('change', function() {
        updateImagePreviews();
    });
    
    // Handle adding more images
    $('#addMoreImages').click(function() {
        fileInput.click();
    });
    
    // Handle removing all images
    $('#removeAllImages').click(function() {
        fileInput.val('');
        updateImagePreviews();
    });
    
    // Handle removing individual images
    previewContainer.on('click', '.remove-image', function() {
        const index = $(this).data('index');
        const dataTransfer = new DataTransfer();
        const files = fileInput[0].files;
        
        // Add all files except the one to remove
        for (let i = 0; i < files.length; i++) {
            if (i !== index) {
                dataTransfer.items.add(files[i]);
            }
        }
        
        fileInput[0].files = dataTransfer.files;
        updateImagePreviews();
    });
    
    // Handle drag and drop
    previewContainer.on('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('bg-light');
    });
    
    previewContainer.on('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('bg-light');
    });
    
    previewContainer.on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('bg-light');
        
        const files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            // Replace current files with dropped files
            const dataTransfer = new DataTransfer();
            for (let i = 0; i < files.length; i++) {
                dataTransfer.items.add(files[i]);
            }
            fileInput[0].files = dataTransfer.files;
            updateImagePreviews();
        }
    });
    
    // Handle form reset
    $('button[type="reset"]').click(function() {
        fileInput.val('');
        updateImagePreviews();
    });

    // Ajax form submission
    $('#roomForm').on('submit', function(e) {
        e.preventDefault();
        
        // Show loading indicator
        Swal.fire({
            title: 'Processing',
            text: 'Creating room...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Create FormData object - files are already in the form data
        // because we're working directly with the file input
        const formData = new FormData(this);
        
        // Ajax request
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.close();
                
                if (response.success) {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Reset form
                            $('#roomForm')[0].reset();
                            fileInput.val('');
                            updateImagePreviews();
                            
                            // Redirect to room list page
                            window.location.href = "{{ route('hotel.room') }}";
                        }
                    });
                } else {
                    // Show validation errors
                    if (response.errors) {
                        let errorMessages = '';
                        $.each(response.errors, function(key, value) {
                            errorMessages += value + '<br>';
                        });
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            html: errorMessages,
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                    }
                }
            },
            error: function(xhr) {
                Swal.close();
                
                let errorMessage = 'An error occurred while creating the room.';
                
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