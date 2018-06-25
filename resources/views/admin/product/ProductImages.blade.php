@extends('layouts.master')
@section('title', 'Suril Jain - Product Images')
@section('content')

    <div >
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Product Images
                </h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                    <li><a href="{{ url('/admin/product-management-list') }}">Product List </a></li>
                    <li class="active">Product Images</li>
                </ol>
            </section>
            <section class="content">

                <!--Form controls-->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"> Product Images</h3>
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

                                <form action="{{url('admin/productPost/'.$id)}}" id="imagesform" method="POST" role="form" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                    <div class="col-xs-12 col-sm-6 col-md-12">
                                        <div class="form-group">
                                            <label>Product Images <span class="asterisk red">*</span></label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input type="file" class="form-control" name="image[]" id="image" multiple="true">
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>

                </div>

            </section>

            <section class="content">

                <!--Form controls-->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"> Product Images View</h3>
                            </div>

                        <!--<div id="product_create"></div>-->
                            <div class="box-body" style="padding: 15px;">
                                <div class="contentpanel">
                                    @if(isset($image))
                                        @if(count($image)>0)
                                            @foreach($image as $img)
                                                <div class="col-sm-3 divbutton" >
                                                    <a href="javascript:;" class="btn_delete" style="display: none;" data-image_id="{{$img->id}}" data-img_name="{{$img->image_name}}"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i>
                                                    </a>
                                                    <a class="image-popup-no-margins" href="{{url('/uploads/product')}}/{{$img->image_name}}"><img src="{{url('/uploads/product')}}/{{$img->image_name}}" class="img img-thumbnail" alt="" style="max-height: 200px"></a>
                                                    {{--<br>
                                                    <center><strong>{{$img->image_name}}</strong></center>--}}
                                                </div>
                                            @endforeach
                                        @else
                                            <span class=""> Product images are not available</span>
                                        @endif
                                    @endif
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </section>

        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
@endsection

@push('scripts')

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
<script src="{{ asset('js/jquery.magnific-popup.js') }}"></script>
    <script type="text/javascript">
        $('.btn_delete').click(function(e) {
            if (confirm("Are you sure you want to delete?")) {
                $.ajax({
                    url: '/admin/deleteImage',
                    type: 'POST',
                    data: {image_id: $(this).data('image_id'), img_name: $(this).data('img_name')},
                    headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')},
                }).done(function (data, status) {
                    //alert(data)
                    if (data == 1) {
                        window.location.reload();
                    } else {
                        window.location.reload();
                    }

                })
            }
        });
        $(document).ready(function() {
            $(document).on('mouseenter', '.divbutton', function () {
                $(this).find(".btn_delete").show('slow');
            }).on('mouseleave', '.divbutton', function () {
                $(this).find(".btn_delete").hide('slow');
            });
            $('.image-popup-vertical-fit').magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                mainClass: 'mfp-img-mobile',
                image: {
                    verticalFit: true
                }

            });

            $('.image-popup-fit-width').magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                image: {
                    verticalFit: false
                }
            });

            $('.image-popup-no-margins').magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                closeBtnInside: false,
                fixedContentPos: true,
                mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
                image: {
                    verticalFit: true
                },
                zoom: {
                    enabled: true,
                    duration: 300 // don't foget to change the duration also in CSS
                }
            });

        });
        $('#imagesform').bootstrapValidator({
            excluded: [':disabled'],
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                'image[]': {
                    validators: {
                        notEmpty: {
                            message: 'The Image is required.'
                        },
                        file: {
                            extension: 'jpeg,jpg,png',
                            type: 'image/jpeg,image/png',
                            maxSize: 2097152,
                            message: 'Choose image only and 2 MB at maximum size. '
                        }
                    }
                }
            }
        });
    </script>

    <style type="text/css">
      /* padding-bottom and top for image */
      .mfp-no-margins img.mfp-img {
          padding: 0;
      }
    /* position of shadow behind the image */
    .mfp-no-margins .mfp-figure:after {
        top: 0;
        bottom: 0;
    }
    /* padding for main container */
    .mfp-no-margins .mfp-container {
        padding: 0;
    }


    .mfp-with-zoom .mfp-container,
    .mfp-with-zoom.mfp-bg {
        opacity: 0;
        -webkit-backface-visibility: hidden;
        -webkit-transition: all 0.3s ease-out;
        -moz-transition: all 0.3s ease-out;
        -o-transition: all 0.3s ease-out;
        transition: all 0.3s ease-out;
    }

    .mfp-with-zoom.mfp-ready .mfp-container {
        opacity: 1;
    }
    .mfp-with-zoom.mfp-ready.mfp-bg {
        opacity: 0.8;
    }

    .mfp-with-zoom.mfp-removing .mfp-container,
    .mfp-with-zoom.mfp-removing.mfp-bg {
        opacity: 0;
    }

</style>
@endpush