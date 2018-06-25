@extends('layouts.master')
@section('title', 'Suril Jain - Create Product')
@section('content')

    <div ng-controller="ProdctCreateController">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Create Product
                </h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                    <li><a href="{{ url('/admin/product-management-list') }}">Product List </a></li>
                    <li class="active">Create Product</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <!--Form controls-->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"> Product Management</h3>
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
                            <div class="box-body" style="padding: 15px;" id="form_scroll">

                                <form role="form" id="productCreatePostData" method="post" action="{{ url('/admin/productCreatePostData') }}">
                                    {{ csrf_field() }}
                                    <textarea id="json_created" name="json_created" style="display: none"></textarea>
                                    <textarea id="json_created_variant" name="json_created_variant" style="display: none"></textarea>
                                    <textarea id="main_pro_images" name="main_pro_images" style="display: none"></textarea>
                                    <div class="box-body">
                                        <div class="row">

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Product Name <span class="asterisk red">*</span></label>
                                                    <input class="form-control" placeholder="Product Name" type="text" name="product_name">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Product Code <span class="asterisk red"></span></label>
                                                    <input class="form-control" placeholder="Product Code" type="text" name="product_code">
                                                </div>
                                            </div>

                                            {{--<div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Product Remark <span class="asterisk red"></span></label>
                                                    <textarea class="form-control" placeholder="Product Remark" name="product_description"></textarea>
                                                </div>
                                            </div>--}}
                                            <div style="clear:both"></div>
                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Vendor Price <span class="asterisk red">*</span></label>
                                                    <input class="form-control" placeholder="Vendor Price" type="number" name="vendor_price">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>MRP <span class="asterisk red">*</span></label>
                                                    <input class="form-control" placeholder="MRP" ng-model="MRP" type="number" name="mrp">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Sell Price <span class="asterisk red">*</span></label>
                                                    <input class="form-control" placeholder="Sell Price" type="number" name="sell_price">
                                                </div>
                                            </div>
                                            <div style="clear:both"></div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea class="form-control" rows="3" placeholder="Description" name="product_description" id="product_description"></textarea>
                                                </div>
                                            </div>
                                            <div style="clear:both"></div>
                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Brand <span class="asterisk red">*</span></label>
                                                    <select class="form-control select2" style="width: 100%;" name="brand_id">
                                                        <option value="">Choose One Brand</option>
                                                        @foreach($brand as $key=>$val)
                                                        <option value="{{$val->id}}">{{$val->product_brand_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>GST Type <span class="asterisk red">*</span></label>
                                                    <select class="form-control select2" style="width: 100%;" name="gst_type_id" id="gst_type_id">
                                                        <option value="">Choose One GST Type</option>
                                                        @foreach($ProductGST as $key=>$val)
                                                            <option value="{{$val->id}}">{{$val->type_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Status <span class="asterisk red">*</span></label>
                                                    <select class="form-control select2" style="width: 100%;" name="status">
                                                        <option value="">Choose One</option>
                                                        <option value="active" selected="selected">Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div style="clear:both"></div>

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Category <span class="asterisk red">*</span></label>
                                                    <select class="form-control select2" style="width: 100%;" name="category_id" id="categoty">
                                                        <option value="">Choose One Category</option>
                                                        @foreach($category as $key=>$val)
                                                            <option value="{{$val->id}}">{{$val->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Sub-Category <span class="asterisk red">*</span></label>
                                                    <select class="form-control select2" style="width: 100%;" disabled name="sub_category_id" id="subcategory">
                                                        <option value="">Choose One Sub-Category</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Category Type<span class="asterisk red">*</span></label>
                                                    <select class="form-control select2" style="width: 100%;" disabled name="category_type" id="category_type_id">
                                                        <option value="">Category Type</option>
                                                    </select>
                                                </div>
                                            </div>

                                            {{--<div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Collection <span class="asterisk red">*</span></label>
                                                    <select class="form-control select2" style="width: 100%;" name="collection_id" id="collection_id">
                                                        <option value="">Choose One Collection</option>
                                                        @foreach($collection as $key=>$val)
                                                            <option value="{{$val->id}}">{{$val->questionnaire_type}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>--}}
                                            <div style="clear:both"></div>


                                        </div>
                                        <div id="render_data" style=""></div>
                                    </div>



                                    <div class="box-footer">
                                        <a href="{{ url('/admin/product-management-list') }}"><button class="btn btn-default pull-right" style="margin:0 0 0 5px" type="button">Cancel</button></a>
                                        <button type="button" id="FromSubmit" class="btn btn-primary pull-right" >Save</button>
                                        {{--<button type="button" ng-click="add_variant()" class="btn btn-primary pull-right" >Add Variant </button>--}}
                                        <button type="submit" id="FromSubmitbtn" style="display: none" ></button>
                                        
                                    </div>


                                </form>
                                <div id="render_data_variant" style=""></div>
                                <div class="row box-body" ng-if="variant_combination.length > 0">
                                    <table class="table table-bordered">
                                        <tbody><tr>
                                            {{--<th style="width: 10px">#</th>--}}
                                            <th>OPTIONS</th>
                                            <th>SKU</th>
                                            {{--<th>Price</th>--}}
                                            <th>Price</th>
                                            <th>Weight</th>
                                            <th>Inventory</th>
                                            <th>Action</th>

                                        </tr>
                                        <tr ng-repeat="vari in variant_combination" class="tr">
                                            {{--<td><% $index %></td>--}}
                                            <td><span ng-repeat="d in vari"><% d.split('-')[1] %> <% !$last?' | ':'' %></span></td>
                                            <span style="display: none;" class="val_of_combination"><% vari %></span>
                                            <td>
                                                <div class="form-group">
                                                    <input class="form-control" placeholder="SKU" type="text" name="SKU">
                                                    <small class="help-block SKU"></small>
                                                </div>
                                            </td>
                                            {{--<td>
                                                Rs. <%MRP%>
                                            </td>--}}
                                            <td>
                                                <div class="form-group">
                                                    <input class="form-control Price" data-index="<%$index%>" placeholder="Price"  type="number" name="Price">
                                                    <small class="help-block Price"></small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input class="form-control" placeholder="Weight" type="text" name="Weight">
                                                    <small class="help-block Weight"></small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <select class="form-control select2" style="width: 100%;" name="Inventory">
                                                        <option value="">Choose One</option>
                                                        <option value="In stock" selected="selected">In stock</option>
                                                        <option value="Out Of Stock">Out Of Stock</option>
                                                    </select>
                                                    <small class="help-block Inventory"></small>
                                                </div>
                                            </td>
                                            <td>
                                                <textarea id="image_arr_<%$index%>" style="display: none;"></textarea>
                                                <a href="javascript:;" id="open_modal" data-id_area="<%$index%>"><i class="fa fa-image"></i></a>
                                                {{--<div class="form-group">
                                                    <div class="btn-group btn-toggle" data-toggle="buttons">
                                                        <label class="btn btn-primary btn-xs active">
                                                            <input type="radio" name="options" value="ON" > ON
                                                        </label>
                                                        <label class="btn btn-xs btn-default">
                                                            <input type="radio" name="options" value="OFF" checked="" > OFF
                                                        </label>
                                                    </div>
                                                </div>--}}
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                    {{--<button type="button" id="tbl_save" class="btn btn-primary pull-right" >Save</button>--}}
                                </div>

                                <div class="row box-body">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label>Product Images </label> &nbsp;&nbsp;&nbsp;   
                                            <button type="button" class="btn btn-primary" id="btn_main_img">Image crop</button>
                                            <!-- <div class="row">
                                                <div class="col-md-4">
                                                    <input type="file" class="form-control" file-model="myFile2" name="myFile2">
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-primary" ng-click="upload_file_for_product()">Add Image</button>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>

                                    <div class="col-md-2 text-center" style="margin-right: 5px;border: 1px solid;" ng-repeat="img in main_product_images">
                                        <img class="img-responsive" ng-src="<%img%>" width="190" height="250"/>
                                        <span><a href="javascript:;" ng-click="remove_img_main(img)">delete</a></span>
                                    </div>
                                </div>

                                {{--<div class="row box-body" ng-repeat="img in image_combination">
                                    <div class="col-md-2" ng-repeat="ig in img track by $index">
                                        <img class="img-responsive" width="50px" src="<%ig%>" />
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control select2 vari" multiple style="width: 100%;" name="vari">
                                            <option value="">Choose Variant</option>
                                        </select>
                                    </div>
                                </div>--}}

                            </div>

                        </div>

                    </div>

                </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <div class="modal fade" id="modal-default" style="display: none; padding-right: 15px;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Images</h4>
                    </div>
                    <div class="modal-body">
                        <div class="gallery">
                            <figure class="text-center pull-left" ng-repeat="img in image_data_modal">
                                <img height="160px" ng-src="<%img%>?crop=entropy&fit=crop&fm=jpg&h=400&ixjsv=2.1.0&ixlib=rb-0.3.5&q=80&w=600" alt="" />
                                <span><a href="javascript:;" ng-click="remove_img(img)">delete</a></span>
                                {{--<figcaption>Daytona Beach <small>United States</small></figcaption>--}}
                            </figure>

                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-12">
                                <div class="form-group">
                                    <label>Product Images <span class="asterisk red">*</span></label>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-img-crop">Image crop</button>
                                    <!-- <div class="row">
                                        <div class="col-md-8">
                                            <input type="file" class="form-control" file-model="myFile" name="file">
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-primary" ng-click="upload_file()">Submit</button>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- model image cropper -->
        <div class="modal fade" id="modal-img-crop" style="display: none; padding-right: 15px;">
            <div class="modal-dialog" style="width: 900px !important">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Images</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                                <div class="col-md-8 text-center">
                                    <div id="upload-image"></div>
                                </div>
                                <div class="col-md-4">
                                    <strong>Select Image:</strong>
                                    <br/>
                                    <input type="file" id="images">
                                    <br/>
                                    <button class="btn btn-success cropped_image" data-cropped='1'>Upload Image</button>
                                </div>          
                                <!-- <div class="col-md-4 crop_preview">
                                    <div id="upload-image-i"></div>
                                </div> -->
                            </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- End -->

    </div>
    
    <!-- ./wrapper -->
@endsection

@push('scripts')
    <style type="text/css">
        .nopad {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        /*image gallery*/
        .image-checkbox {
            cursor: pointer;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            border: 4px solid transparent;
            margin-bottom: 0;
            outline: 0;
        }
        .image-checkbox input[type="checkbox"] {
            display: none;
        }

        .image-checkbox-checked {
            border-color: #4783B0;
        }
        .image-checkbox .fa {
            position: absolute;
            color: #4A79A3;
            background-color: #fff;
            padding: 10px;
            top: 0;
            right: 0;
        }
        .image-checkbox-checked .fa {
            display: block !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-tagsinput-latest/dist/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-tagsinput-latest/examples/assets/app.css') }}">
    <script src="{{ asset('plugins/bootstrap-tagsinput-latest/src/bootstrap-tagsinput.js') }}"></script>
    <script src="http://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.min.js"></script>

    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-tagsinput-latest/dist/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-tagsinput-latest/examples/assets/app.css') }}">
    <script src="{{ asset('plugins/bootstrap-tagsinput-latest/src/bootstrap-tagsinput.js') }}"></script>
    <script src="http://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.min.js"></script>

    <script src="{{ asset('angular/ProductCreate.js') }}"></script>
    <!--<script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
    <script src="{{asset('/plugins/ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript">
        $(document).on('click','.btn-toggle',function() {
            $(this).find('.btn').toggleClass('active');

            if ($(this).find('.btn-primary').size()>0) {
                $(this).find('.btn').toggleClass('btn-primary');
            }
            if ($(this).find('.btn-danger').size()>0) {
                $(this).find('.btn').toggleClass('btn-danger');
            }
            if ($(this).find('.btn-success').size()>0) {
                $(this).find('.btn').toggleClass('btn-success');
            }
            if ($(this).find('.btn-info').size()>0) {
                $(this).find('.btn').toggleClass('btn-info');
            }

            $(this).find('.btn').toggleClass('btn-default');

        });


        $(document).ready(function () {
            CKEDITOR.replace('product_description');
            /*elt.tagsinput('add', { "value": 1 , "text": "Navy"   , "color": "bg-navy"    });
            elt.tagsinput('add', { "value": 2 , "text": "Blue"  , "color": "bg-blue"   });*/

        });


    $("#categoty").change(function () {
        if($(this).val() != ""){
            $("#load").css("display","block");
            $.ajax({
                url: '/admin/get_sub_cat_by_cat',
                type: 'POST',
                data: { categoty_id: $(this).val() },
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                success: function(data) {
                    var data = JSON.parse(data);
                    var html = '<option value="">Choose One Sub-Category</option>';
                    if(data.Result.length > 0){
                        $("#subcategory").prop("disabled",false);
                        $.each(data.Result, function (key,val) {
                            console.log(val);
                            html += '<option value="'+val.id+'" data-filter_id="'+val.filter_id+'">'+val.sub_category_name+'</option>';
                        });
                        $("#subcategory").html(html);
                    }else {
                        $("#subcategory").prop("disabled",true);
                        $("#subcategory").html(html);
                        alert(data.MESSAGE);
                    }
                    $("#load").css("display","none");
                }
            });
        }else {
            $("#subcategory").prop("disabled",true);
            var html = '<option value="">Choose One Sub-Category</option>';
            $("#subcategory").html(html);
            alert("Please select a Category");
        }

    });

        $("#subcategory").change(function () {
            if($(this).val() != ""){
                $("#load").css("display","block");
                $.ajax({
                    url: '/admin/get_sub_cat_type_by_cat',
                    type: 'POST',
                    data: { categoty_id: $(this).val() },
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success: function(data) {
                        var data = JSON.parse(data);
                        var html = '<option value="">Choose One Category Type</option>';
                        if(data.Result.length > 0){
                            $("#category_type_id").prop("disabled",false);
                            $.each(data.Result, function (key,val) {
                                html += '<option value="'+val.id+'" data-filter_id="'+val.filter_id+'">'+val.sub_category_name+'</option>';
                            });
                            $("#category_type_id").html(html);
                        }else {
                            $("#category_type_id").prop("disabled",true);
                            $("#category_type_id").html(html);
                            $("#category_type_id").val("").trigger('change');
                            alert(data.MESSAGE);
                        }
                        $("#load").css("display","none");
                    }
                });
            }else {
                $("#category_type_id").val("").trigger('change');
                $("#category_type_id").prop("disabled",true);
                var html = '<option value="">Choose One Category type</option>';
                $("#category_type_id").html(html);
                alert("Please sub select a Category");
            }

        });

    $('#productCreatePostData').bootstrapValidator({
        excluded: [':disabled'],
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            product_name: {
                validators: {
                    notEmpty: {
                        message: 'The Product Name is required.'
                    }
                }
            },
            category_id: {
                validators: {
                    notEmpty: {
                        message: 'The Category is required.'
                    }
                }
            },
            sub_category_id: {
                validators: {
                    notEmpty: {
                        message: 'The Sub-Category is required.'
                    }
                }
            },
            category_type: {
                validators: {
                    notEmpty: {
                        message: 'The Category Type is required.'
                    }
                }
            },
            brand_id: {
                validators: {
                    notEmpty: {
                        message: 'The Brand is required.'
                    }
                }
            },
            vendor_price: {
                validators: {
                    notEmpty: {
                        message: 'The Vender is required.'
                    }
                }
            },
            mrp: {
                validators: {
                    notEmpty: {
                        message: 'The MRP is required.'
                    }
                }
            },
            sell_price: {
                validators: {
                    notEmpty: {
                        message: 'The Sell Price is required.'
                    }
                }
            },
            gst_type_id: {
                validators: {
                    notEmpty: {
                        message: 'The GST Type is required.'
                    }
                }
            },
            collection_id: {
                validators: {
                    notEmpty: {
                        message: 'The Collection is required.'
                    }
                }
            },
            status: {
                validators: {
                    notEmpty: {
                        message: 'The status is required'
                    }
                }
            }
        }
    });

    </script>
    <script>
        popup = {
            init: function(){
                $('figure').click(function(){
                    popup.open($(this));
                });

                $(document).on('click', '.popup img', function(){
                    return false;
                }).on('click', '.popup', function(){
                    popup.close();
                })
            },
            open: function($figure) {
                $('.gallery').addClass('pop');
                $popup = $('<div class="popup"/>').appendTo($('body'));
                $fig = $figure.clone().appendTo($('.popup'));
                $bg = $('<div class="bg" />').appendTo($('.popup'));
                $close = $('<div class="close"><svg><use xlink:href="#close"></use></svg></div>').appendTo($fig);
                $shadow = $('<div class="shadow" />').appendTo($fig);
                src = $('img', $fig).attr('src');
                $shadow.css({backgroundImage: 'url(' + src + ')'});
                $bg.css({backgroundImage: 'url(' + src + ')'});
                setTimeout(function(){
                    $('.popup').addClass('pop');
                }, 10);
            },
            close: function(){
                $('.gallery, .popup').removeClass('pop');
                setTimeout(function(){
                    $('.popup').remove()
                }, 100);
            }
        }

        popup.init()

    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $image_crop = $('#upload-image').croppie({
                enableExif: true,
                viewport: {
                    width: 210,
                    height: 283,
                    type: 'square'
                },
                boundary: {
                    width: 400,
                    height: 400
                }
            });
            $('#images').on('change', function () { 
                var reader = new FileReader();
                reader.onload = function (e) {
                    $image_crop.croppie('bind', {
                        url: e.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                    });         
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@endpush