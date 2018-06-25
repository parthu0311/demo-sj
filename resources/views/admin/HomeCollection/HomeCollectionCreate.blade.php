@extends('layouts.master')
@section('title', 'Suril Jain - Create Home Collection')
@section('content')

    <div>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Create Home Collection
                </h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                    <li><a href="{{ url('/admin/home-collection-list') }}">Home Collection List </a></li>
                    <li class="active">Create Home Collection</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <!--Form controls-->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"> Create Home Collection</h3>
                            </div>
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(Session::has('message'))
                                <p class="alert alert-danger">{{ Session::get('message') }}</p>
                            @endif
                            <!--<div id="product_create"></div>-->
                            <div class="box-body" style="padding: 15px;">

                                <form role="form" id="HomeSliderCreatePostData" method="post" action="{{ url('/admin/HomeCollectionCreatePostData') }}" enctype='multipart/form-data'>
                                    {{ csrf_field() }}
                                    <div class="box-body">
                                        <div class="row">

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Home Collection For <span class="asterisk red">*</span></label>
                                                    <input class="form-control" placeholder="Home Collection For" type="text" name="collection_for">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Home Collection Summery <span class="asterisk red">*</span></label>
                                                    <input class="form-control" placeholder="Home Collection Summery" type="text" name="collection_summery">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Status <span class="asterisk red">*</span></label>
                                                    <select class="form-control select2" style="width: 100%;" name="status">
                                                        <option value="">Choose One</option>
                                                        <option value="active">Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Home Collection Image/Banner (270 * 386 and must be jpg/jpeg)</label>
                                                    <input type="file" class="form-control" name="image_banner" id="image_banner">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <a href="{{ url('/admin/home-collection-list') }}"><button class="btn btn-default pull-right" style="margin:0 0 0 5px" type="button">Cancel</button></a>
                                        <button type="submit" class="btn btn-primary pull-right" >Save</button>
                                    </div>
                                </form>


                            </div>

                        </div>

                    </div>

                </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
@endsection

@push('scripts')
    <script src="{{asset('/plugins/ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript">

    $('#HomeSliderCreatePostData').bootstrapValidator({
        excluded: [':disabled'],
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            collection_for: {
                validators: {
                    notEmpty: {
                        message: 'The Home Collection For is required.'
                    }
                }
            },
            collection_summery: {
                validators: {
                    notEmpty: {
                        message: 'The Home Collection Summery is required.'
                    }
                }
            },
            status: {
                validators: {
                    notEmpty: {
                        message: 'The status is required'
                    }
                }
            },
            image_banner: {
                validators: {
                    notEmpty: {
                        message: 'The Image is required.'
                    },
                    file: {
                        extension: 'jpeg,jpg',
                        type: 'image/jpeg,image/png',
                        maxSize: 2097152,
                        message: 'Choose image only and 2 MB at maximum size. '
                    }
                }
            }
        }
    });
    $(function () {
        $("#image_banner").on("change", function () {
            //Get reference of FileUpload.
            var fileUpload = $("#image_banner")[0];
            console.log(fileUpload)
            //Check whether the file is valid Image.
            var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg)$");
            if (regex.test(fileUpload.value.toLowerCase())) {
                //Check whether HTML5 is supported.
                if (typeof (fileUpload.files) != "undefined") {
                    //Initiate the FileReader object.
                    var reader = new FileReader();
                    //Read the contents of Image File.
                    reader.readAsDataURL(fileUpload.files[0]);
                    reader.onload = function (e) {
                        //Initiate the JavaScript Image object.
                        var image = new Image();
                        //Set the Base64 string return from FileReader as source.
                        image.src = e.target.result;
                        image.onload = function () {
                            //Determine the Height and Width.
                            var height = this.height;
                            var width = this.width;
                            //alert(height +'--'+width)
                            if (height != 386 || width != 270) {
                                alert("Height and Width must 270px * 386px.");
                                 $("#image_banner").val("");
                                return false;
                            }
                            //alert("Uploaded image has valid Height and Width.");
                            return true;
                        };
                    }
                } else {
                    alert("This browser does not support HTML5.");
                    $("#image_banner").val("");
                    return false;
                }
            } else {
                $("#image_banner").val("");
                alert("Please select a valid Image file.");
                return false;
            }
            setTimeout(function () {
                $('#HomeSliderCreatePostData').bootstrapValidator('revalidateField', 'image_banner');
            },300);

        });
    });
</script>

@endpush