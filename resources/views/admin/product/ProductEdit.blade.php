@extends('layouts.master')
@section('title', 'Suril Jain - Edit GST Management')
@section('content')

    <div ng-controller="ProdctEditController">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Create GST Management
                </h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                    <li><a href="{{ url('/admin/product-management-list') }}">Product Management List </a></li>
                    <li class="active">Edit Product Management</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <!--Form controls-->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"> Edit Product Management</h3>
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

                                <form role="form" id="GSTManagementEditPost" method="post" action="{{ url('/admin/ProductManagementEditPost/'.$Product->id) }}">
                                    {{ csrf_field() }}
                                    <textarea id="json_created_variant" name="json_created_variant" style="display: none"></textarea>
                                    <textarea id="json_created" name="json_created" style="display: none"></textarea>
                                    <textarea id="main_pro_images" name="main_pro_images" style="display: none"></textarea>
                                    <input type="hidden" name="pro_id" id="pro_id" value="{{$Product->id}}">
                                    <div class="box-body">
                                        <div class="row">

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Product Name <span class="asterisk red">*</span></label>
                                                    <input class="form-control" placeholder="Product Name" type="text" name="product_name" value="{{$Product->product_name}}">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Product Code <span class="asterisk red"></span></label>
                                                    <input class="form-control" placeholder="Product Code" type="text" name="product_code" value="{{$Product->product_code}}">
                                                </div>
                                            </div>

                                            {{--<div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Product Remark <span class="asterisk red"></span></label>
                                                    <textarea class="form-control" placeholder="Product Remark" name="product_description">{{$Product->product_description}}</textarea>
                                                </div>
                                            </div>--}}
                                            <div style="clear:both"></div>
                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Vendor Price <span class="asterisk red">*</span></label>
                                                    <input class="form-control" placeholder="Vendor Price" type="number" name="vendor_price" value="{{$Product->vendor_price}}">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>MRP <span class="asterisk red">*</span></label>
                                                    <input type="hidden" id="hidden_mrp" value="{{$Product->mrp}}">
                                                    <input class="form-control" placeholder="MRP" type="number" name="mrp" value="{{$Product->mrp}}">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Sell Price <span class="asterisk red">*</span></label>
                                                    <input class="form-control" placeholder="Sell Price" type="number" name="sell_price" value="{{$Product->sell_price}}">
                                                </div>
                                            </div>
                                            <div style="clear:both"></div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea class="form-control" rows="3" placeholder="Description" name="product_description" id="product_description">{{$Product->product_description}}</textarea>
                                                </div>
                                            </div>
                                            <div style="clear:both"></div>
                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Brand <span class="asterisk red">*</span></label>
                                                    <select class="form-control select2" style="width: 100%;" name="brand_id">
                                                        <option value="">Choose One Brand</option>
                                                        @foreach($brand as $key=>$val)
                                                            <option value="{{$val->id}}" <?php if($Product->brand_id == $val->id){ echo "selected='selected'";} ?> >{{$val->product_brand_name}}</option>
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
                                                            <option value="{{$val->id}}" <?php if($Product->gst_type_id == $val->id){ echo "selected='selected'";} ?>>{{$val->type_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Status <span class="asterisk red">*</span></label>
                                                    <select class="form-control select2" style="width: 100%;" name="status">
                                                        <option value="">Choose One</option>
                                                        <option {{ $Product->status == 'Active' ? 'selected="selected"' : '' }} value="Active">Active</option>
                                                        <option {{ $Product->status == 'Inactive' ? 'selected="selected"' : '' }} value="Inactive">Inactive</option>
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
                                                            <option value="{{$val->id}}" <?php if($Product->category_id == $val->id){ echo "selected='selected'";} ?>>{{$val->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Sub-Category <span class="asterisk red">*</span></label>
                                                    <select class="form-control select2" style="width: 100%;" <?php if(count($subcategory) == 0){ echo "disabled";}?>  name="sub_category_id" id="subcategory">
                                                        <option value="">Choose One Sub-Category</option>
                                                        <?php if(count($subcategory) >0){ ?>
                                                        @foreach($subcategory as $key=>$val)
                                                            <option value="{{$val->id}}" data-filter_id="<?php if($Product->sub_category_id == $val->id){ echo $val->filter_id;} ?>" <?php if($Product->sub_category_id == $val->id){ echo "selected='selected'";} ?>>{{$val->sub_category_name}}</option>
                                                        @endforeach
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Category Type <span class="asterisk red">*</span></label>
                                                    <select class="form-control select2" style="width: 100%;" <?php if(count($subcategory_type) == 0){ echo "disabled";}?>  name="category_type_id" id="category_type">
                                                        <option value="" >Choose One Category Type</option>
                                                        <?php if(count($subcategory_type) >0){ ?>
                                                        @foreach($subcategory_type as $key=>$val)
                                                            <option value="{{$val->id}}" data-filter_id="<?php  echo $val->filter_id; ?>" <?php if($Product->category_type_id == $val->id){ echo "selected='selected'";} ?>>{{$val->sub_category_name}}</option>
                                                        @endforeach
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div style="clear:both"></div>
                                            <div id="render_data" style=""></div>
                                        </div>

                                    </div>
                                    <div class="box-footer">
                                        <a href="{{ url('/admin/product-management-list') }}"><button class="btn btn-default pull-right" style="margin:0 0 0 5px" type="button">Cancel</button></a>
                                        <button type="button" id="FromSubmit" class="btn btn-primary pull-right" >Save</button>
                                        <button type="submit" id="FromSubmitbtn" style="display: none" ></button></div>
                                </form>
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
                                        @foreach ($ProductVariant as $key=>$val)
                                            <tr class="tr">
                                                {{--<td><% $index %></td>--}}
                                                <td>{{$val->combination}}</td>
                                                <span style="display: none;" class="val_of_combination"><% vari %></span>
                                                <td>
                                                    <div class="form-group">
                                                        <input class="form-control" value="{{$val->sku}}" placeholder="SKU" type="text" name="SKU">
                                                        <small class="help-block SKU"></small>
                                                    </div>
                                                </td>
                                                {{--<td>
                                                    Rs. <%MRP%>
                                                </td>--}}
                                                <td>
                                                    <div class="form-group">
                                                        <input class="form-control Price" value="{{$val->price}}" placeholder="Price"  type="number" name="Price">
                                                        <small class="help-block Price"></small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input class="form-control" value="{{$val->weight}}" placeholder="Weight" type="text" name="Weight">
                                                        <small class="help-block Weight"></small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <select class="form-control select2" style="width: 100%;" name="Inventory">
                                                            <option value="">Choose One</option>
                                                            <option value="In stock" <?php if($val->inventory == 'In stock'){echo "selected='selected'";} ?>>In stock</option>
                                                            <option value="Out Of Stock" <?php if($val->inventory == 'Out Of Stock'){echo "selected='selected'";} ?>>Out Of Stock</option>
                                                        </select>
                                                        <small class="help-block Inventory"></small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php
                                                        $temp_img = [];
                                                        if(count($val->Image) > 0){
                                                            foreach ($val->Image as $im){
                                                                array_push($temp_img,asset('uploads/product').'/'.$im->image);
                                                            }
                                                        }
                                                    ?>
                                                    <textarea id="image_arr_{{$val->id}}{{$val->product_id}}" style="display: none;">
                                                        <?php if(count($temp_img) > 0){ echo json_encode($temp_img);}else{ echo "[]";} ?>
                                                    </textarea>
                                                    <a href="javascript:;" id="open_modal" data-id_area="{{$val->id}}{{$val->product_id}}"><i class="fa fa-image"></i></a>
                                                    <a href="javascript:;" class="btn_delete" data-v_id="{{$val->id}}"><i class="fa fa-trash-o"></i></a>
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
                                        @endforeach

                                        <tr ng-repeat="vari in variant_combination" ng-if="vari|myfilter" class="tr">
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
                                </div>
                                <div class="row box-body">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label>Product Images </label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input type="file" class="form-control" file-model="myFile2" name="myFile2">
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-primary" ng-click="upload_file_for_product()">Add Image</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if(count($ProductImages) > 0)
                                    @foreach($ProductImages as $k=>$v)
                                        <div class="col-md-2 text-center" style="margin-right: 5px;border: 1px solid;" >
                                            <img class="img-responsive" src="{{asset('uploads/main_product').'/'.$v->image_name}}" width="190" height="250"/>
                                            <span><a href="javascript:;" ng-click="remove_img_server('{{$v->id}}','{{$v->image_name}}')">delete</a></span>
                                        </div>
                                    @endforeach
                                    @endif

                                    <div class="col-md-2 text-center" style="margin-right: 5px;border: 1px solid;" ng-repeat="img in main_product_images">
                                        <img class="img-responsive" ng-src="<%img%>" width="190" height="250"/>
                                        <span><a href="javascript:;" ng-click="remove_img_main(img)">delete</a></span>
                                    </div>
                                </div>
                                <?php
                                $temp_com = array();
                                foreach ($ProductVariant as $sing){
                                    array_push($temp_com,preg_replace('/\s+/', '', $sing->combination));
                                }
                                ?>
                                <textarea id="json_comb" style="display: none;">
                                    <?php echo json_encode($temp_com); ?>
                                </textarea>
                            <?php
                                /*echo '<pre>';
                                print_r(); exit;*/
                                ?>
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
                                <img height="160px" src="<%img%>?crop=entropy&fit=crop&fm=jpg&h=400&ixjsv=2.1.0&ixlib=rb-0.3.5&q=80&w=600" alt="" />
                                <span><a href="javascript:;" ng-click="remove_img(img)">delete</a></span>
                                {{--<figcaption>Daytona Beach <small>United States</small></figcaption>--}}
                            </figure>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-12">
                                <div class="form-group">
                                    <label>Product Images <span class="asterisk red">*</span></label>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input type="file" class="form-control" file-model="myFile" name="file">
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-primary" ng-click="upload_file()">Submit</button>
                                        </div>
                                    </div>
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
    </div>
    <!-- ./wrapper -->
@endsection

@push('scripts')
    <script src="{{ asset('angular/ProductEdit.js') }}"></script>
    <!--<script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
    <script src="{{asset('/plugins/ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            CKEDITOR.replace('product_description');
            /*elt.tagsinput('add', { "value": 1 , "text": "Navy"   , "color": "bg-navy"    });
            elt.tagsinput('add', { "value": 2 , "text": "Blue"  , "color": "bg-blue"   });*/

        });
        $(document).on("click",'.btn_delete',function () {
            if (confirm("Are you sure you want to delete?")) {
                $("#load").css("display","block");
                $.ajax({
                    url: '/admin/deleteVariant',
                    type: 'POST',
                    data: {v_id: $(this).data('v_id')},
                    headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')},
                }).done(function (data, status) {
                    //alert(data)
                    if (data == 1) {
                        window.location.reload();
                    } else {
                        window.location.reload();
                    }
                    $("#load").css("display","none");
                })
            }
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
                        /*$.each(data.Result, function (key,val) {
                            html += '<option value="'+val.id+'">'+val.name+'</option>';
                        });*/
                        $.each(data.Result, function (key,val) {
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
                            $("#category_type").prop("disabled",false);
                            $.each(data.Result, function (key,val) {
                                html += '<option value="'+val.id+'" data-filter_id="'+val.filter_id+'">'+val.sub_category_name+'</option>';
                            });
                            $("#category_type").html(html);
                        }else {
                            $("#category_type").prop("disabled",true);
                            $("#category_type").html(html);
                            alert(data.MESSAGE);
                        }
                        $("#load").css("display","none");
                    }
                });
            }else {
                $("#category_type").prop("disabled",true);
                var html = '<option value="">Choose One Category type</option>';
                $("#category_type").html(html);
                alert("Please select a Sub-Category");
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
            category_type_id: {
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

@endpush