@extends('layouts.master')
@section('title', 'Suril Jain - Product List')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Product List
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">Product List</li>
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
                                <label class="control-label">Product Name</label>
                                <div class="" id="serproduct_name"><span class="filter_column filter_text">
                                        <input type="text" class="search_init text_filter form-control" name="product_name" id="product_name" placeholder="Search Product Name"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="form-group nomargin">
                                <label class="control-label">Product Code</label>
                                <div class="" id="serproduct_code"><span class="filter_column filter_text">
                                        <input type="text" class="search_init text_filter form-control" name="product_code" id="product_code" placeholder="Search Product Code"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="form-group nomargin">
                                <label class="control-label">Category Name</label>
                                <div class="" id="sercategory_name"><span class="filter_column filter_text">
                                        <input type="text" class="search_init text_filter form-control" name="category_name" id="category_name" placeholder="Search Category Name"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="form-group nomargin">
                                <label class="control-label">Sub-Category Name</label>
                                <div class="" id="sersub_category_name"><span class="filter_column filter_text">
                                        <input type="text" class="search_init text_filter form-control" name="sub_category_name" id="sub_category_name" placeholder="Search Sub-Category Name"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="form-group nomargin">
                                <label class="control-label">Brand Name</label>
                                <div class="" id="serbrand_name"><span class="filter_column filter_text">
                                        <input type="text" class="search_init text_filter form-control" name="brand_name" id="brand_name" placeholder="Search Brand Name"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="form-group nomargin">
                                <label class="control-label">GST Type</label>
                                <div class="" id="sergst_type"><span class="filter_column filter_text">
                                        <input type="text" class="search_init text_filter form-control" name="gst_type" id="gst_type" placeholder="Search GST Type"></span>
                                </div>
                            </div>
                        </div>

                        {{--<div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="form-group nomargin">
                                <label class="control-label">Collection Name</label>
                                <div class="" id="sercollection_name"><span class="filter_column filter_text">
                                        <input type="text" class="search_init text_filter form-control" name="collection_name" id="collection_name" placeholder="Search Collection Name"></span>
                                </div>
                            </div>
                        </div>--}}

                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="form-group nomargin">
                                <label class="control-label">Status </label>
                                <div class="" id="serStatus">
                                    <span class="filterColumn filter_select">
                                    <select name="status" id="status"  class="search_init select_filter form-control">
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
                <?php
                if (Helper::checkActionPermission('admin','product-management-create')) { ?>
                    <a href="{{ url('/admin/product-management-create') }}"><button class="btn btn-primary" type="button">Add Products</button></a>
                <?php } ?>
            </div>
        </div>




        <!--Data Table-->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary box-solid">
                    <div class="box-header">
                        <h3 class="box-title">Product List</h3>
                    </div>

                    <div class="box-body">
						<div class="table-responsive">
							<table id="ProductList" class="table table-bordered table-striped">
								<thead>
									<tr>
                                        <th></th>
										<th>Product Name</th>
										<th>Product Code</th>
										<th>Category Name</th>
										<th>Sub-Category Name</th>
										<th>Brand Name</th>
										<th>GST Type</th>
										<th>Vender Price</th>
										<th>MRP</th>
										<th>Sell Price</th>
										{{--<th>Collection</th>--}}
										{{--<th>Product Description</th>--}}
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


@endsection

@push('scripts')
<!-- /.content-wrapper -->
<script type="text/javascript">
    var selected = [];
    //var status = '';



    var deleteAjaxSource = '<?php echo (Helper::checkActionPermission('admin','deleteProductManagement')) ? 'deleteProductManagement' : ''; ?>';
    var activeInactiveAjaxSource = '<?php echo (Helper::checkActionPermission('admin','actInactProductManagementStatus')) ? 'actInactProductManagementStatus' : ''; ?>';
    var addEditSource = '<?php echo (Helper::checkActionPermission('admin','product-management-edit')) ? '/admin/product-management-edit' : ''; ?>';
    var Images = '<?php echo (Helper::checkActionPermission('admin','product-images')) ? '/admin/product-images' : ''; ?>';

    function showMessage(){
       return '<div id="load" style="display: block"></div>';
    }
    $(document).ready(function () {
         dTable = $('#ProductList').dataTable({
            dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
            "<'row'<'col-xs-12't>>"+
            "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
            processing: true,
            serverSide: true,
            oLanguage: {
                 sProcessing: showMessage()
            },
            ajax: {
                url: '/admin/ProductListAjax/',
                data: function (d) {
                    d.product_name = $('input[name=product_name]').val();
                    d.product_code = $('input[name=product_code]').val();
                    d.category_name = $('input[name=category_name]').val();
                    d.sub_category_name = $('input[name=sub_category_name]').val();
                    d.brand_name = $('input[name=brand_name]').val();
                    d.gst_type = $('input[name=gst_type]').val();
                    d.vendor_price = $('input[name=vendor_price]').val();
                    d.mrp = $('input[name=mrp]').val();
                    d.sell_price = $('input[name=sell_price]').val();
                    /*d.collection_name = $('input[name=collection_name]').val();*/
                    d.product_description = $('input[name=product_description]').val();
                    d.status = $('select[name=status]').val();
                }
            },
            columns: [
                { data : "id", sTitle: "<input type='checkbox' id='checkall' name='checkall'></input>", mDataProp: null, sWidth: "20px", sDefaultContent: "<input type='checkbox' ></input>", bSortable: false, bSearchable: false},
                { data: 'product_name', name: 'product_name' },
                { data: 'product_code', name: 'product_code' },
                { data: 'category_name', name: 'category_name' },
                { data: 'sub_category_name', name: 'sub_category_name' },
                { data: 'brand_name', name: 'brand_name' },
                { data: 'gst_type', name: 'gst_type' },
                { data: 'vendor_price', name: 'vendor_price' },
                { data: 'mrp', name: 'mrp' },
                { data: 'sell_price', name: 'sell_price' },
                /*{ data: 'collection_name', name: 'collection_name' },*/
                /*{ data: 'product_description', name: 'product_description' },*/
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

                        var html = '';

                        html += '<table border="0" style="width:90px;">';
                        html += '<tr>';

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
                        if (addEditSource) {
                            html += '<a href="' + addEditSource + '/' + row.id + '" class="fa fa-edit" title="Edit"></a>&nbsp;&nbsp;';
                        }

                        if (deleteAjaxSource) {
                            html += '<a href="javascript:void(0)" class="fa fa-trash" onclick="deleteAll(\'' + single + '\',' + row.id + ')" title="Click to Delete Record"></a>&nbsp;&nbsp;';
                        }
                        /*if (Images) {
                            html += '<a href="' + Images + '/' + row.id + '" class="fa fa-image"  title="Product Images"></a>&nbsp;&nbsp;';
                        }*/

                        html += '</tr>';
                        html += '</table>';
                        return html;
                    },
                    "aTargets": [11]
                }


                ]
        });

        $('#search-form input').on('keyup', function(e) {
            dTable.fnDraw(true)
            e.preventDefault();
        });
        $('#search-form select').on('change', function(e) {
            dTable.fnDraw(true)
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

    function checked_chkbx(chk)
    {
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

    function check_checkbox()
    {
        for (var i = 0; i < selected.length; i++) {
            $('#chk_' + selected[i]).prop('checked', true);

        }
    }




</script>

@endpush