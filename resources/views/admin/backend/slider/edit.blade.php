@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Update Slider Page </h4><br><br>


                        <form method="post" action="{{ route('slider.update', $slider->id) }}" id="myForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $slider->id }}">
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Title</label>
                                <div class="form-group col-sm-10">
                                    <input name="title" class="form-control" type="text" value="{{ $slider->title}}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Image</label>
                                <div class="form-group col-sm-10">
                                    <input name="image" class="form-control" type="file">
                                </div>
                            </div>
                            <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Image Preview</label>
                                <img src="{{ asset($slider->image) }}" alt="{{ $slider->image }}" class="img-thumbnail" style="height: 200px; width:200px;">
                            </div>
                            <!-- end row -->
                            <input type="submit" class="btn btn-info waves-effect waves-light" value="Update">
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                name: {
                    required : true,
                }, 
                mobile_no: {
                    required : true,
                }, 
                email: {
                    required : true,
                }, 
                address: {
                    required : true,
                }, 
            },
            messages :{
                name: {
                    required : 'Please Enter Your Name',
                },
                mobile_no: {
                    required : 'Please Enter Your Mobile no',
                },
                email: {
                    required : 'Please Enter Your Email',
                },
                address: {
                    required : 'Please Enter Your Address',
                },
            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
    
</script>

 
@endsection 
