@extends('layouts.master')
@section('title', 'Suril Jain - Offers List')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Offers List
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                <li class="active">Offers List</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Search -->

            <div class="box box-primary box-solid">
                <div class="box-header">
                    <h3 class="box-title">Search</h3>
                </div>

                <form role="form" method="POST" id="search-form" class="">
                    <div class="box-body">
                        <div class="row">

                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <div class="form-group nomargin">
                                    <label class="control-label">Type of Coupon </label>
                                    <div class="" id="type_of_coupon_ser">
                                    <span class="filterColumn filter_select">
                                    <select name="type_of_coupon_ser" id="type_of_coupon_ser"  class="search_init select_filter form-control">
                                            <option value="">Choose One</option>
                                            <option value="FLAT_DISCOUNT">FLAT DISCOUNT</option>
                                            <option value="PERCENT_DISCOUNT">PERCENT DISCOUNT</option>
                                            <option value="FREE_SHIPPING">FREE SHIPPING</option>
                                            <option value="SALE_PRICE">SALE PRICE</option>
                                    </select>
                                    </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <div class="form-group nomargin">
                                    <label class="control-label">Coupon Code</label>
                                    <div class="" id="serproduct_name"><span class="filter_column filter_text">
                                        <input type="text" class="search_init text_filter form-control" name="coupon_code_ser" id="coupon_code_ser" placeholder="Search Coupon Code"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <div class="form-group nomargin">
                                    <label class="control-label">Coupon Name</label>
                                    <div class="" id="serproduct_code"><span class="filter_column filter_text">
                                        <input type="text" class="search_init text_filter form-control" name="coupon_name_ser" id="coupon_name_ser" placeholder="Search Coupon Name"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <div class="form-group nomargin">
                                    <label class="control-label">Apply to</label>
                                    <select class="search_init select_filter form-control" style="width: 100%;" name="apply_to_ser" id="apply_to_ser">
                                        <option value="">Choose One</option>
                                        <option value="Specific Product">Specific Product</option>
                                        <option value="Specific Category">Specific Category</option>
                                        <option value="Specific Category Type">Specific Category Type</option>
                                        <option value="Specific Brand">Specific Brand</option>
                                        <option value="Minimum Order Subtotal">Minimum Order Subtotal</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <div class="form-group nomargin">
                                    <label class="control-label">Valid Unlimited</label>
                                    <select class="search_init select_filter form-control" style="width: 100%;" name="valid_unlimited_ser" id="valid_unlimited_ser">
                                        <option value="">Choose One</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <div class="form-group nomargin">
                                    <label class="control-label">Status </label>
                                    <div class="" id="serStatus">
                                    <span class="filterColumn filter_select">
                                    <select name="status_ser" id="status_ser"  class="search_init select_filter form-control">
                                            <option value="">Status</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                    </select>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>


            <div class="row contentpanel">
                <div class="col-xs-12 text-right margin-bottom">
                    <div class="btn-group">
                        <button type="button" class="btn bg-olive">More Action</button>
                        <button type="button" class="btn bg-olive dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="javascript:void(0);" onclick="activeInactiveAll('Active', '', 'all');">Active</a></li>
                            <li class="divider"></li>
                            <li><a href="javascript:void(0);" onclick="activeInactiveAll('InActive', '', 'all');">Inactive</a></li>
                            <li class="divider"></li>
                            <li><a href="javascript:void(0);"  onclick="deleteAll('all', '');">Delete</a></li>
                            {{--<li class="divider"></li>--}}
                        </ul>
                    </div>
                    <a href="javascript:;" id="collection_product"><button class="btn btn-primary" type="button">Click to Create Offer</button></a>

                </div>
            </div>


            <!--Data Table-->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary box-solid">
                        <div class="box-header">
                            <h3 class="box-title">Offers List </h3>
                        </div>

                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="OfferAjaxList" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Type Of Coupon</th>
                                        <th>Coupon Code</th>
                                        <th>Coupon Name</th>
                                        <th>Discount Price</th>
                                        <th>Apply to </th>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th>Category Type</th>
                                        <th>Brand</th>
                                        <th>Minimum Subtotal</th>
                                        <th>Valid From</th>
                                        <th>Valid To</th>
                                        <th>Valid Unlimited</th>
                                        <th>Limit Uses</th>
                                        <th>Limit Uses Unlimited</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>

    <!--Add sub Category-->
    <div class="modal fade" id="modal-collection" style="display: none; padding-right: 15px;">
        <div class="modal-dialog" style="width: 900px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Create Offer</h4>
                </div>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-lg-12 text-center radio_btn">
                            <p>
                                <a href="javascript:;"  onclick="load_data_of_create_offer('FLAT_DISCOUNT')" style="border: 2px solid #EEEEEE;" class="btn btn-sq-lg btn-primary img-check">
                                    <i class="fa fa-rupee fa-5x"></i>
                                    <br/><br/>
                                    <input type="radio" name="radio" checked="checked" value="FLAT_DISCOUNT"> DISCOUNT
                                </a>
                                <a href="javascript:;" onclick="load_data_of_create_offer('PERCENT_DISCOUNT')" style="border: 2px solid #EEEEEE;" class="btn btn-sq-lg img-check">
                                    <i class="fa fa-percent fa-5x"></i>
                                    <br/><br/>
                                    <input type="radio"  name="radio" value="PERCENT_DISCOUNT"> DISCOUNT
                                </a>
                                <a href="javascript:;" onclick="load_data_of_create_offer('FREE_SHIPPING')" class="btn btn-sq-lg img-check" style="border: 2px solid #EEEEEE;">
                                    <i class="fa fa-truck fa-5x"></i>
                                    <br/><br/>
                                    <input type="radio"  name="radio" value="FREE_SHIPPING"> FREE SHIPPING
                                </a>
                                {{--<a href="javascript:;" onclick="load_data_of_create_offer('SALE_PRICE')" class="btn btn-sq-lg img-check" style="border: 2px solid #EEEEEE;">
                                    <i class="fa fa fa-money fa-5x"></i>
                                    <br/><br/>
                                    <input type="radio" name="radio" value="SALE_PRICE"> SALE PRICE
                                </a>--}}
                            </p>
                        </div>
                    </div>
                    <form role="form" id="create_offer" method="post" action="{{ url('/admin/CreateOfferPost') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="type_of_coupon" id="type_of_coupon" value="">
                        <input type="hidden" name="offer_id" id="offer_id" value="">
                        <div id="append_html"></div>
                        <div class="box-footer">
                            <button type="submit" style="display: none;" class="btn_submit_post">Save</button>
                            <button type="button" class="btn btn-primary pull-right" id="click_to_submit">Save</button>
                        </div>
                    </form>

                </section>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--End---->


@endsection

@push('scripts')
    <style type="text/css">
        .check
        {
            opacity:0.5;
            color:#996;

        }
        .btn-sq-lg {
            width: 150px !important;
            height: 150px !important;
        }
        .help-block {
            color: #dd4b39 !important;
        }

    </style>
    <!-- /.content-wrapper -->
    <script type="text/javascript">
        function load_data_of_create_offer(text) {
            //alert($("input[name=radio]:checked").val())
            $("#load").css("display","block");
            $.ajax({
                url: '/admin/get_Offer_creation',
                type: 'POST',
                data: { type: text },
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                success: function(data) {
                    $("#type_of_coupon").val(text);
                    $("#append_html").html(data.html);
                    $("#load").css("display","none");
                    setTimeout(function () {
                        $('.date').datepicker({
                            format :'mm-dd-yyyy'
                        });
                    },300)
                }
            });
        }
        $("#click_to_submit").off().on("click",function () {
            var error = 0;
            if($("#coupon_code").val() == ""){
                error++;
                $(".coupon_code").html("Coupon Code is required.");
            }else {
                $(".coupon_code").html("");
            }

            if($("#coupon_name").val() == ""){
                error++;
                $(".coupon_name").html("Coupon Name is required.");
            }else {
                $(".coupon_name").html("");
            }


            if($("#apply_to").val() == ""){
                error++;
                $(".apply_to").html("Apply to is required.");
            }else {
                $(".apply_to").html("");
            }

            if($("#product").val() != undefined){
                if($("#product").val() == ""){
                    error++;
                    $(".apply_to_on").html("This Field is required.");
                }else {
                    $(".apply_to_on").html("");
                }
            }
            if($("#categories").val() != undefined){
                if($("#categories").val() == ""){
                    error++;
                    $(".apply_to_on").html("This Field is required.");
                }else {
                    $(".apply_to_on").html("");
                }
            }
            if($("#sub_category_type").val() != undefined){
                if($("#sub_category_type").val() == ""){
                    error++;
                    $(".apply_to_on").html("This Field is required.");
                }else {
                    $(".apply_to_on").html("");
                }
            }
            if($("#brand").val() != undefined){
                if($("#brand").val() == ""){
                    error++;
                    $(".apply_to_on").html("This Field is required.");
                }else {
                    $(".apply_to_on").html("");
                }
            }
            if($("#valid_from").val() == ""){
                error++;
                $(".valid_from").html("Valid From is required.");
            }else {
                $(".valid_from").html("");
            }
            if($("#valid_to").val() == "" && $("#valid_unlimited").is(":checked") == false){
                error++;
                $(".valid_to").html("Valid To is required.");
            }else {
                $(".valid_to").html("");
            }
            if($("#limit_uses").val() == "" && $("#limit_uses_unlimited").is(":checked") == false){
                error++;
                $(".limit_uses").html("Valid To is required.");
            }else {
                $(".limit_uses").html("");
            }
            //alert($("input[name=radio]:checked").val())
            if($("input[name=radio]:checked").val() == "FLAT_DISCOUNT"){
                if($("#discount").val() == ""){
                    error++;
                    $(".discount").html("Discount is required.");
                }else {
                    $(".discount").html("");
                }
            }else if($("input[name=radio]:checked").val() == "PERCENT_DISCOUNT"){
                if($("#discount").val() == ""){
                    error++;
                    $(".discount").html("Discount is required.");
                }else {
                    $(".discount").html("");
                }
            }else if($("input[name=radio]:checked").val() == "SALE_PRICE"){
                if($("#discount").val() == ""){
                    error++;
                    $(".discount").html("Discount is required.");
                }else {
                    $(".discount").html("");
                }
            }
            if(error == 0){
                $(".btn_submit_post").click();
            }
        });
        function rhtmlspecialchars(str) {
             if (typeof(str) == "string") {
              str = str.replace(/&gt;/ig, ">");
              str = str.replace(/&lt;/ig, "<");
              str = str.replace(/&#039;/g, "'");
              str = str.replace(/&quot;/ig, '"');
              str = str.replace(/&amp;/ig, '&'); /* must do &amp; last */
              }
             return str;
         }
        $(document).on("change","#apply_to",function () {
            $("#load").css("display","block");
            if($(this).val() == "Specific Product"){
                var product = '<?php echo rawurlencode(\App\Product::where('status','Active')->get()); ?>';
                product = JSON.parse(decodeURIComponent(product));
                var html = '<div class="form-group">';
                html += '<label>Select Product <span class="asterisk red">*</span></label>';
                html += '<select class="form-control select2" style="width: 100%;" name="product[]" id="product" multiple>';
                html += '<option value="">Choose One</option>';
                $.each(product,function (key,val) {
                    html += '<option value="'+val.id+'">'+val.product_name+'</option>';
                });
                html += '</select>';
                html += '<small class="help-block apply_to_on"></small>';
                html += '</div>';
                $("#append_apply_to").html(html);
                $("#product").select2();
                $("#load").css("display","none");
            }else if($(this).val() == "Specific Category"){
                var Categories = '<?php echo rawurlencode( \App\Categories::where('status','Active')->get()); ?>'
                Categories = JSON.parse(decodeURIComponent(Categories));
                var html = '<div class="form-group">';
                html += '<label>Select Categories <span class="asterisk red">*</span></label>';
                html += '<select class="form-control select2" style="width: 100%;" name="categories" id="categories">';
                html += '<option value="">Choose One</option>';
                $.each(Categories,function (key,val) {
                    html += '<option value="'+val.id+'">'+val.name+'</option>';
                });
                html += '</select>';
                html += '<small class="help-block apply_to_on"></small>';
                html += '</div>';
                $("#append_apply_to").html(html);
                $("#categories").select2();
                $("#load").css("display","none");
            }else if($(this).val() == "Specific Category Type"){
                var SubCategories = '<?php echo rawurlencode( \App\SubCategories::where('parent','!=',0)->where('status','Active')->get()); ?>'
                SubCategories = JSON.parse(decodeURIComponent(SubCategories));
                var html = '<div class="form-group">';
                html += '<label>Select Categories Type<span class="asterisk red">*</span></label>';
                html += '<select class="form-control select2" style="width: 100%;" name="sub_category_type" id="sub_category_type">';
                html += '<option value="">Choose One</option>';
                $.each(SubCategories,function (key,val) {
                    html += '<option value="'+val.id+'">'+val.sub_category_name+'</option>';
                });
                html += '</select>';
                html += '<small class="help-block apply_to_on"></small>';
                html += '</div>';
                $("#append_apply_to").html(html);
                $("#sub_category_type").select2();
                $("#load").css("display","none");
            }else if($(this).val() == "Specific Brand"){
                var Brand = '<?php echo \App\Brand::where('status','Active')->get(); ?>'
                Brand = JSON.parse(Brand);
                var html = '<div class="form-group">';
                html += '<label>Select Brand<span class="asterisk red">*</span></label>';
                html += '<select class="form-control select2" style="width: 100%;" name="brand" id="brand">';
                html += '<option value="">Choose One</option>';
                $.each(Brand,function (key,val) {
                    html += '<option value="'+val.id+'">'+val.product_brand_name+'</option>';
                });
                html += '</select>';
                html += '<small class="help-block apply_to_on"></small>';
                html += '</div>';
                $("#append_apply_to").html(html);
                $("#brand").select2();
                $("#load").css("display","none");
            }else if($(this).val() == "Minimum Order Subtotal"){
                var html = '<div class="form-group">';
                html += '<label>Minimum subtotal<span class="asterisk red">*</span></label>';
                html += '<input class="form-control" placeholder="Minimum subtotal" type="text" name="minimum_subtotal" id="minimum_subtotal">';
                html += '<small class="help-block apply_to_on"></small>';
                html += '</div>';
                $("#append_apply_to").html(html);
                $("#load").css("display","none");
            }else if($(this).val() == "Specific Collection"){
                var home_collection = '<?php echo rawurlencode( \App\HomeCollection::where('status','Active')->get()); ?>'
                home_collection = JSON.parse(decodeURIComponent(home_collection));
                var html = '<div class="form-group">';
                html += '<label>Select Collection<span class="asterisk red">*</span></label>';
                html += '<select class="form-control select2" style="width: 100%;" name="specific_collection" id="specific_collection">';
                html += '<option value="">Choose One</option>';
                $.each(home_collection,function (key,val) {
                    html += '<option value="'+val.id+'">'+val.collection_for+'</option>';
                });
                html += '</select>';
                html += '<small class="help-block apply_to_on"></small>';
                html += '</div>';
                $("#append_apply_to").html(html);
                $("#brand").select2();
                $("#load").css("display","none");
            }else {
                $("#append_apply_to").html("");
                $("#load").css("display","none");
            }

        });

        $(document).ready(function(e){
            $('.date').datepicker({
                format :'mm-dd-yyyy'
            });
            $(".img-check").click(function(){
                $(".radio_btn").find("a").removeClass("btn-primary");
                $(this).addClass('btn-primary');
                $(this).find("input").prop("checked",true);
            });
        });
        $("#collection_product").click(function () {
            $(".modal-title").html("Create Offer");
            $(".radio_btn").css("display",'block');
            $("#modal-collection").modal("show");
            $("#offer_id").val("");
            load_data_of_create_offer('FLAT_DISCOUNT');
        });


        var selected = [];
        //var status = '';
        var deleteAjaxSource = '<?php echo (Helper::checkActionPermission('admin','deleteOffer')) ? 'deleteOffer' : ''; ?>';
        var activeInactiveAjaxSource = '<?php echo (Helper::checkActionPermission('admin','actInactOfferStatus')) ? 'actInactOfferStatus' : ''; ?>';
        var addEditSource = '<?php echo (Helper::checkActionPermission('admin','offer-edit')) ? '/admin/offer-edit' : ''; ?>';

        function showMessage(){
            return '<div id="load" style="display: block"></div>';
        }
        $(document).ready(function () {
            dTable = $('#OfferAjaxList').dataTable({
                dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
                "<'row'<'col-xs-12't>>"+
                "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
                processing: true,
                serverSide: true,
                oLanguage: {
                    sProcessing: showMessage()
                },
                ajax: {
                    url: '/admin/OfferListAjax/',
                    data: function (d) {
                        d.type_of_coupon = $('select[name=type_of_coupon_ser]').val();
                        d.coupon_code = $('input[name=coupon_code_ser]').val();
                        d.coupon_name = $('input[name=coupon_name_ser]').val();
                        d.apply_to = $('select[name=apply_to_ser]').val();
                        d.valid_unlimited = $('select[name=valid_unlimited_ser]').val();
                        d.status = $('select[name=status_ser]').val();
                    }
                },
                columns: [
                    { data : "id", sTitle: "<input type='checkbox' id='checkall' name='checkall'></input>", mDataProp: null, sWidth: "20px", sDefaultContent: "<input type='checkbox' ></input>", bSortable: false, bSearchable: false},
                    { data: 'type_of_coupon', name: 'type_of_coupon' },
                    { data: 'coupon_code', name: 'coupon_code' },
                    { data: 'coupon_name', name: 'coupon_name' },
                    { data: 'discount', name: 'discount' },
                    { data: 'apply_to', name: 'apply_to' },
                    { data: 'product_name', name: 'product_name' },
                    { data: 'category_name', name: 'category_name' },
                    { data: 'sub_category_name', name: 'sub_category_name' },
                    { data: 'product_brand_name', name: 'product_brand_name' },
                    { data: 'minimum_subtotal', name: 'minimum_subtotal' },
                    { data: 'valid_from', name: 'valid_from' },
                    { data: 'valid_to', name: 'valid_to' },
                    { data: 'valid_unlimited', name: 'valid_unlimited' },
                    { data: 'limit_uses', name: 'limit_uses' },
                    { data: 'limit_uses_unlimited', name: 'limit_uses_unlimited' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                aoColumnDefs: [
                    {
                        "mRender": function (data, type, full) {

                            return '<input type="checkbox" name="usercheck" class="checkbox case" onClick="checked_chkbx(' + data + ')" value="' + data + '" id="chk_' + data + '"> ';
                        },
                        "aTargets": [0]
                    },
                    {
                        "mRender": function (data, type, row) {

                            if (row.status == 'Active') {

                                status = 'Inactive';
                            } else {
                                status = 'Active';
                            }
                            var single = 'single';
                            var html = '';

                            html += '<table border="0" style="width:90px;">';
                            html += '<tr>';
                            if (addEditSource) {
                                html += '<a href="javascript:;" onclick="edit_offer(\'' + row.type_of_coupon + '\',' + row.id + ')" class="fa fa-edit" title="Edit"></a>&nbsp;&nbsp;';
                            }
                            if (activeInactiveAjaxSource) {
                                var active = 'Active';
                                var inactive = 'Inactive';
                                var single = 'single';
                                if (status == 'Active') {
                                    html += '<a href="javascript:void(0)" class="fa fa-eye-slash" onclick="activeInactiveAll(\'' + active + '\',' + row.id + ',\'' + single + '\');" title="Click to Active Record"></a>&nbsp;&nbsp;';
                                }
                                if (status == 'Inactive') {
                                    html += '<a href="javascript:void(0)" class="fa fa-eye" onclick="activeInactiveAll(\'' + inactive + '\',' + row.id + ',\'' + single + '\')" title="Click to InActive Record"></a>&nbsp;&nbsp;';
                                }
                            }
                            if (deleteAjaxSource) {

                                html += '<a href="javascript:void(0)" class="fa fa-trash" onclick="deleteAll(\'' + single + '\',' + row.id + ')" title="Click to Delete Record"></a>&nbsp;&nbsp;';

                            }

                            html += '</tr>';
                            html += '</table>';
                            return html;
                        },
                        "aTargets": [17]
                    }


                ]
            });

            $('#search-form input').on('keyup', function(e) {
                dTable.fnDraw(true);
                e.preventDefault();
            });
            $('#search-form select').on('change', function(e) {
                dTable.fnDraw(true);
                e.preventDefault();
            });

            $("#checkall").click(function () {
                $(".case").prop('checked', $(this).prop('checked'));
            });

            $(document).on("click", ".case", function(t) {
                if($(".case").length == $(".case:checked").length) {
                    $("#checkall").prop("checked", true);
                }else {
                    $("#checkall").prop("checked", false);
                }
            });
        });


        function checked_chkbx(chk) {
            if ($('#chk_' + chk).is(':checked')) {
                selected.push(chk);
            } else
            {
                selected.pop(chk);
            }
        }

        $('#CategoriesList_paginate ul li').on('click', function () {
            setTimeout(check_checkbox, 200);
        });

        function check_checkbox() {
            for (var i = 0; i < selected.length; i++) {
                $('#chk_' + selected[i]).prop('checked', true);

            }
        }

        function edit_offer(type_of_coupon,id) {
            /*alert(type_of_coupon);
            alert(id)*/
            $(".modal-title").html("Edit Offer");
            $("#load").css("display","block");
            $.ajax({
                url: '/admin/get_Offer_edit',
                type: 'POST',
                data: { type_of_coupon: type_of_coupon,id:id },
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                success: function(data) {
                    $("#offer_id").val(id);
                    $(".radio_btn").css("display",'none');
                    $("#type_of_coupon").val(type_of_coupon);
                    $("#append_html").html(data.html);
                    $("#load").css("display","none");
                    setTimeout(function () {
                        $('.date').datepicker({
                            format :'mm-dd-yyyy'
                        });
                    },300);
                    $("#modal-collection").modal("show");
                    $(".select2").select2();
                }
            });
        }
        /*========================================*/

    </script>

@endpush