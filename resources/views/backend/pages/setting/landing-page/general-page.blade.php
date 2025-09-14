@extends('backend.include.app')
@section('title', 'Settings')
@section('content')
    <div class="container-fluid px-4">
        <h4 class="mt-2">Landing Page Setting</h4>

        <div class="my-2 card">
            <div class="card-header">
                <div class="row ">
                    <div class="col-12 d-flex justify-content-between">
                        <div class="d-flex align-items-center"><h5 class="m-0">General Page Setting</h5></div>
                    </div>
                </div>
            </div>
            <div class="card-body pb-0">
                <form action="{{ route('admin.setting.update') }}" id="settingForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Application Name:</label>
                        <div class="col-sm-9">
                            <input type="text" name="application_name" value="{{ Helper::getSettings('application_name') }}" class="form-control" placeholder="Application Name" >
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label for="" class="col-sm-3 col-form-label">Site Logo:</label>
                        <div class="col-sm-9" >
                            <input type="file" class="form-control" onchange="previewFile('settingForm #site_logo', 'settingForm .site_logo_image')" name="site_logo" id="site_logo">
                            <img src="{{ Helper::getSettings('site_logo') ? asset('uploads/settings/'.Helper::getSettings('site_logo')) : asset('assets/img/no-img.jpg')}}" height="80px" width="100px" class="site_logo_image mt-1 border" alt="">
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label for="" class="col-sm-3 col-form-label">Site Favicon:</label>
                        <div class="col-sm-9" >
                            <input type="file" class="form-control" onchange="previewFile('settingForm #site_favicon', 'settingForm .site_favicon_image')" name="site_favicon" id="site_favicon">
                            <img src="{{ Helper::getSettings('site_favicon') ? asset('uploads/settings/'.Helper::getSettings('site_favicon')) : asset('assets/img/no-img.jpg')}}" height="80px" width="80px" class="site_favicon_image mt-1 border" alt="">
                        </div>
                    </div>
         
                    <div class="form-group row">
                        @php
                            $gtms = ['-12', '-11', '-10', '-9', '-8', '-7', '-6', '-5', '-4', '-3', '-2', '-1', '+0', '+1', '+2', '+3', '+4', '+5', '+6', '+7', '+8', '+9', '+10', '+11', '+12'];
                        @endphp
                        <label for="" class="col-sm-3 col-form-label">Select Timezone:</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="application_timezone">
                                <option selected>Select Timezone</option>
                                @foreach ($gtms as $gmt)
                                    <option {{ Helper::getSettings('application_timezone') == 'GMT'.$gmt ? 'selected' : '' }} value="GMT{{ $gmt }}">GMT{{ $gmt }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                               
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Available Section:</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="keyword" id="keyword">
                                <option selected disabled>Select Section</option>
                                @foreach ($setup_section_keywords as $keyword)
                                    <option value="{{ $keyword }}">{{ ucwords(str_replace('-', ' ', $keyword)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- hero section --}}
                    <div id="hero-section"></div>
                    

                    <div class="form-group text-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).on('change', '#keyword', function(e) {
            e.preventDefault();
            let keywordValue = $(this).val();
            console.log(keywordValue);
            $.ajax({
                url: "{{ route('admin.setting.hero.section') }}",
                type: "GET",
                dataType: "json", // Set dataType to json
                data: { keyword: keywordValue },
                success: function(response) {
                    $('#hero-section').html(response.data); // Access response.data
                    
                }
            });
        });
    </script>
@endsection

