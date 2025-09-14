<!DOCTYPE html>
<html lang="en">

<head>
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @hasSection('title')
            @yield('title')
        @else
            Dashboard 
        @endif
    </title>

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/backend/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/backend/toastr.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/backend/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/backend/sweetalert2.js') }}" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendor/summernote/summernote.min.css') }}">
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <script src="{{ asset('assets/js/backend/jquery.min.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
    {{-- <link rel="shortcut icon" href="{{ asset('uploads/settings/' . Helper::getSettings('site_favicon')) }}" /> --}}

    <!-- Include jQuery Editable Select Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-editable-select/1.7.1/jquery-editable-select.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-editable-select/1.7.1/jquery-editable-select.min.css">
        <!-- Buttons extension (for export buttons) -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

        <style>
            .dt-buttons {
                margin-bottom: 15px;
            }
        </style>
        
    @yield('css')
</head>

<body class="sb-nav-fixed">
    <div id="loader_container" class="d-none">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    @include('backend.include.topbar')
    <div id="layoutSidenav">
        @include('backend.include.sidebar')
        <div id="layoutSidenav_content">
            <main class="pt-4">
                @yield('content')
            </main>
            <div class="footer py-2 px-4 d-flex flex-lg-column position-sticky bottom-0" style="background: #F9FAFB;">
                <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <div class="text-muted">
                        {{-- <span>All Rights Reserved</span>
                        <span class="text-muted fw-bold me-1">&copy {{ date('Y') }}</span>
                        <a data-turbo="false" href="{{ url('/') }}" class="text-hover-primary">{{ config('app.name') }}</a> --}}
                        <div class="copyrights-menu copyright-links nobottommargin" style="margin-top: 6px">
                            Copyrights © {{ date('Y') }} All Rights Reserved by
                            <a class="link" href="#"
                                style="color: #669900 !important;"> Rezvan Rajin</a>
                        </div>
                    </div>
                    <div class="text-muted order-2 order-md-1">
                        <div class="copyrights-menu copyright-links nobottommargin" style="margin-top: 6px">
                            Developed By
                            <svg width="14" height="14" viewBox="0 -2 24 24">
                                <path
                                    d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z"
                                    fill="red"></path>
                            </svg>
                            by <a class="link" href="#"> Rezvan Rajin</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/backend/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/backend/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/backend/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/backend/validator.js') }}"></script>
    <script src="{{ asset('assets/js/backend/scripts.js') }}"></script>


    <script>
        $(document).ajaxStart(function() {
            $('#loader_container').removeClass('d-none').addClass('d-flex');
        });
        $(document).ajaxComplete(function() {
            $('#loader_container').removeClass('d-flex').addClass('d-none');

        });
    </script>

    <script>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                $.toast({
                    heading: 'Error',
                    text: "{{ $error }}",
                    position: 'top-center',
                    icon: 'error'
                })
            @endforeach
        @endif

        @if (session()->has('success'))
            $.toast({
                heading: 'Success',
                text: "{{ session()->get('success') }}",
                position: 'top-center',
                icon: 'success'
            })
        @endif

        // previous image preview
        // function previewImage(input, previewContainerClass) {
        //     var preview = document.querySelector(previewContainerClass);
        //     console.log(preview);
        //     if (input.files && input.files[0]) {
        //         var reader = new FileReader();
        //         reader.onload = function(e) {
        //             preview.src = e.target.result;
        //         };
        //         reader.readAsDataURL(input.files[0]);
        //     }
        // }

        function previewImage(input, previewContainerSelector) {
            var preview = document.querySelector(previewContainerSelector);
            console.log(preview);
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';  // Make sure the image is visible
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '';
                preview.style.display = 'none';  // Hide the image if no file is selected
            }
        }


        function initSummerNote() {
            $('.tinymceText').summernote({
                height: 200,
            });
        }

        initSummerNote();

        function addRow(className, element, event) {
            event.preventDefault();

            // Get the first row element in the team_area
            var row = document.querySelector('.' + className).cloneNode(true);

            // Clear the input values in the cloned row
            row.querySelectorAll('input').forEach(input => input.value = '');

            // Append the cloned row to the container
            document.querySelector('.' + className).parentNode.appendChild(row);
        }

        function removeRow(element, event, className) {
            event.preventDefault();

            // Only remove the row if there is more than one row present
            if (document.querySelectorAll('.'+className).length > 1) {
                element.closest('.'+className).remove();
            }
        }
    </script>

    @yield('script')
</body>

</html>
