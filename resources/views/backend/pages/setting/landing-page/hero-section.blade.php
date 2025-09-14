<div class="container-fluid">
    <div class="my-2 card"> 
        <div class="card-header">
            <div class="row ">
                <div class="col-12 d-flex justify-content-between">
                    <div class="d-flex align-items-center"><h5 class="m-0">Hero Section Setting</h5></div>
                </div>
            </div>
        </div>
        <div class="col-12 d-flex justify-content-end p-4">
            <button type="button" class="btn btn-sm btn-primary" id="addSlides">Add Slides <i class="fa fa-plus"></i></button>
        </div>
{{-- 
        <div class="card-body pb-0">
            <div class="form-group row">
                <label for="" class="col-sm-3 col-form-label">Heading</label>
                <div class="col-sm-9">
                    <input type="text" name="heading"  class="form-control" placeholder="" >
                </div>
            </div>
        </div> --}}
        <div id="sliderSection" style="display: none;">
            <div class="card-body pb-0">
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Title Heading</label>
                    <div class="col-sm-9">
                        <input type="text" name="title_heading"  class="form-control" placeholder="" >
                    </div>
                </div>
            </div>
            <div class="card-body pb-0">
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Title Description</label>
                    <div class="col-sm-9">
                        <input type="text" name="title_description"  class="form-control" placeholder="" >
                    </div>
                </div>
            </div>
            <div class="card-body pb-0">
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Image</label>
                    <div class="col-sm-9">
                        <input type="file" name="image"  class="form-control" placeholder="" >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    $(document).ready(function() {
        $('#hero-section #addSlides').on('click', function() {
            $('#sliderSection').css('display', 'block');
        });
    });

</script>


