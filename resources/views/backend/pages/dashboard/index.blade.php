@extends('backend.include.app')
@section('title', 'Dashboard')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datepicker/bootstrap-datepicker3.min.css') }}">

    <style>
        .dashboard-card-amount {
            font-size: 32px;
        }
    </style>
@endsection
@section('content')
  
    <div class="container-fluid px-5 pt-4" id="dashboard_data_container"></div>
    <div class="container-fluid px-5 pt-4 mt-4">
        <div class="row">
            <div class="col-lg-6 bg-white rounded">
                <canvas id="myChart"></canvas>
            </div>
            <div class="col-lg-6">
                <div class="budget bg-white p-4 rounded">
                    <h2 class="budget-title mb-5"></h2>
                    <div class="budget-body">
                        <div class="d-flex align-items-center border-bottom pb-2">
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 25 24" fill="none" style="border: 1px solid #843DB9; border-radius: 5px; padding: 5px">
                                <path d="M8.359 13.924C8.724 13.541 9.078 13.109 9.352 12.648C9.783 11.921 9.212 11 8.37 11H4.629C3.786 11 3.216 11.921 3.647 12.648C3.92 13.109 4.275 13.542 4.64 13.924C2.274 15.01 0.5 17.985 0.5 20.511C0.5 22.434 2.07 23.999 4 23.999H9C10.93 23.999 12.5 22.434 12.5 20.511C12.5 17.984 10.724 15.01 8.359 13.924ZM8.999 22H3.999C3.172 22 2.499 21.333 2.499 20.512C2.499 18.217 4.667 15.5 6.499 15.5C8.331 15.5 10.499 18.217 10.499 20.512C10.499 21.333 9.826 22 8.999 22ZM21.499 0H6.998C5.069 0 3.499 1.571 3.499 3.5V8C3.499 8.552 3.947 9 4.499 9C5.051 9 5.499 8.552 5.499 8V3.5C5.499 2.673 6.172 2 6.999 2C7.826 2 8.499 2.673 8.499 3.5C8.499 4.878 9.621 6 10.999 6H19.499V19C19.499 20.654 18.153 22 16.499 22H14.499C13.947 22 13.499 22.448 13.499 23C13.499 23.552 13.947 24 14.499 24H16.499C19.256 24 21.499 21.757 21.499 19V6H21.999C23.377 6 24.499 4.878 24.499 3.5V3C24.499 1.346 23.153 0 21.499 0ZM22.499 3.5C22.499 3.776 22.275 4 21.999 4H10.999C10.723 4 10.499 3.776 10.499 3.5C10.499 2.963 10.377 2.455 10.161 2H21.499C22.05 2 22.499 2.449 22.499 3V3.5Z" fill="#843DB9"/>
                            </svg> --}}
                            <div class="participant ms-2">
                                {{-- <p class="mb-0 text-gray-500">Total </p> --}}
                                {{-- <p class="fs-5 mb-0">{{ number_format($total) }}</p> --}}
                            </div>
                        </div>
                        <div class="d-flex align-items-center border-bottom pb-2">
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none" style="border: 1px solid #EF4444; border-radius: 5px; padding: 5px">
                                <path d="M8.359 13.924C8.724 13.541 9.078 13.109 9.352 12.648C9.783 11.921 9.212 11 8.37 11H4.629C3.786 11 3.216 11.921 3.647 12.648C3.92 13.109 4.275 13.542 4.64 13.924C2.274 15.01 0.5 17.985 0.5 20.511C0.5 22.434 2.07 23.999 4 23.999H9C10.93 23.999 12.5 22.434 12.5 20.511C12.5 17.984 10.724 15.01 8.359 13.924ZM8.999 22H3.999C3.172 22 2.499 21.333 2.499 20.512C2.499 18.217 4.667 15.5 6.499 15.5C8.331 15.5 10.499 18.217 10.499 20.512C10.499 21.333 9.826 22 8.999 22ZM21.499 0H6.998C5.069 0 3.499 1.571 3.499 3.5V8C3.499 8.552 3.947 9 4.499 9C5.051 9 5.499 8.552 5.499 8V3.5C5.499 2.673 6.172 2 6.999 2C7.826 2 8.499 2.673 8.499 3.5C8.499 4.878 9.621 6 10.999 6H19.499V19C19.499 20.654 18.153 22 16.499 22H14.499C13.947 22 13.499 22.448 13.499 23C13.499 23.552 13.947 24 14.499 24H16.499C19.256 24 21.499 21.757 21.499 19V6H21.999C23.377 6 24.499 4.878 24.499 3.5V3C24.499 1.346 23.153 0 21.499 0ZM22.499 3.5C22.499 3.776 22.275 4 21.999 4H10.999C10.723 4 10.499 3.776 10.499 3.5C10.499 2.963 10.377 2.455 10.161 2H21.499C22.05 2 22.499 2.449 22.499 3V3.5Z" fill="#EF4444"/>
                            </svg> --}}
                            <div class="participant ms-2">
                                {{-- <p class="mb-0 text-gray-500">Total </p> --}}
                                {{-- <p class="fs-5 mb-0">{{number_format($total)}}</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('assets/vendor/datepicker/bootstrap-datepicker.min.js') }}"></script>
   
@endsection
