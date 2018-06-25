@extends('layouts.master')
@section('title', 'Suril Jain - Edit Product Category')
@section('content')

    <div>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Edit Product Category : <b>{{$Categories->name}}</b>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                    <li><a href="{{ url('/admin/product-category-list') }}">Product Category List</a></li>
                    <li class="active">Edit Product Category</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <!--Form controls-->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit Product Categories For : <b>{{$Categories->name}}</b></h3>
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
                            <form role="form" id="FormControlCategories" method="post" action="{{ url('/admin/ProductCategoriesEditPostData/'.$Categories->id) }}">
                                {{ csrf_field() }}
                                <div class="box-body">
                                    <div class="row">

                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label>Category Name <span class="asterisk red">*</span></label>
                                                <input class="form-control" placeholder="Category Name" type="text" name="categories_name" value="{{$Categories->name}}">
                                            </div>
                                        </div>


                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label>Status <span class="asterisk red">*</span></label>
                                                <select class="form-control select2" style="width: 100%;" name="status">
                                                    <option value="">Choose One</option>
                                                    <option {{ $Categories->status == 'Active' ? 'selected="selected"' : '' }} value="Active">Active</option>
                                                    <option {{ $Categories->status == 'Inactive' ? 'selected="selected"' : '' }} value="Inactive">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                                </div>

                                <div class="box-footer">
                                    <a href="{{ url('admin/product-category-list') }}"><button class="btn btn-default pull-right" style="margin:0 0 0 5px" type="button">Cancel</button></a>
                                    <button class="btn btn-primary pull-right" type="submit">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->

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
                                        <label class="control-label">Product Sub Category</label>
                                        <div class="" id="sersub_category_name"><span class="filter_column filter_text">
                                         <input type="text" class="search_init text_filter form-control" name="sub_category_name" id="sub_category_name" placeholder="Search Sub Category Name"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-3">
                                    <div class="form-group nomargin">
                                        <label class="control-label">Filter name</label>
                                        <div class="" id="serfilter_select_option_table">
                                    <span class="filterColumn filter_select">
                                    <select class="form-control select2" style="width: 100%;" name="filter_select_option_table" id="filter_select_option_table">
                                                <option value="">Choose One Filter</option>
                                        @foreach($Questionnaire as $val)
                                            <option value="{{$val->id}}">{{$val->questionnaire_type}}</option>
                                        @endforeach
                                    </select>
                                    </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-3">
                                    <div class="form-group nomargin">
                                        <label class="control-label">Status</label>
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
                        <?php
                        if (Helper::checkActionPermission('admin','product-category-reorder')) { ?>
                        <a href="javascript:;" id="re-order-cat" class="pull-left"><button class="btn btn-primary" type="button">Re-Order Categories</button></a>
                        <?php } ?>
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
                                <li class="divider"></li>
                            </ul>
                        </div>
                        <a href="javascript:;" id="add_sub_cat"><button class="btn btn-primary" type="button">Add</button></a>
                    </div>
                </div>




                <!--Data Table-->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header">
                                <h3 class="box-title">Product Sub Category List For : <b>{{$Categories->name}}</b></h3>
                            </div>

                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="SubCategoryList" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Sub Category Name</th>
                                            <th>Filter Name</th>
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

            <!--Add sub Category-->
            <div class="modal fade" id="modal-add" style="display: none; padding-right: 15px;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Add Sub Category</h4>
                        </div>
                        <form role="form" id="addform" method="post" action="#">
                            <div class="modal-body">
                                <div class="row">
                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Sub Category Name <span class="asterisk red">*</span></label>
                                                    <input class="form-control" placeholder="Sub Category Name" type="text" name="sub_category_name_add" id="sub_category_name_add">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Status <span class="asterisk red">*</span></label>
                                                    <select class="form-control select2" style="width: 100%;" name="status">
                                                        <option value="">Choose One</option>
                                                        <option value="active" selected="selected">Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--End---->

            <!--Add sub Category-->
            <div class="modal fade" id="modal-edit" style="display: none; padding-right: 15px;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Edit Sub Category</h4>
                        </div>
                        <form role="form" id="editform" method="post" action="#">
                            <div class="modal-body">
                                <input type="hidden" id="sub_cat_id">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label>Sub Category Name <span class="asterisk red">*</span></label>
                                            <input class="form-control" placeholder="Sub Category Name" type="text" name="sub_category_name_edit" id="sub_category_name_edit">
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label>Status <span class="asterisk red">*</span></label>
                                            <select class="form-control select2" style="width: 100%;" name="status_edit" id="status_edit">
                                                <option value="">Choose One</option>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--End---->

            <!--Re-Order sub Category-->
            <div class="modal fade" id="modal-ordering" style="display: none; padding-right: 15px;">
                <div class="modal-dialog" style="width: 702px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Re-Order Sub-Category</h4>
                        </div>
                        <div class="modal-body" id="sort_modal_body">
                            <div class="cf nestable-lists">

                            <div class="dd" id="nestable">

                                <?php

                                $query = \Illuminate\Support\Facades\DB::select("select * from sub_categories where category_id = '$Categories->id' order by sort ");

                                $ref   = [];
                                $items = [];
                                /*echo '<pre>';
                                print_r($query); exit;*/
                                foreach($query as $data) {

                                    $thisRef = &$ref[$data->id];

                                    $thisRef['parent'] = $data->parent;
                                    $thisRef['sub_category_name'] = $data->sub_category_name;
                                    $thisRef['id'] = $data->id;

                                    if($data->parent == 0) {
                                        $items[$data->id] = &$thisRef;
                                    } else {
                                        $ref[$data->parent]['child'][$data->id] = &$thisRef;
                                    }

                                }


                                function get_menu($items,$class = 'dd-list') {

                                    $html = "<ol class=\"".$class."\" id=\"menu-id\">";

                                    foreach($items as $key=>$value) {
                                        $html.= '<li class="dd-item dd3-item" data-id="'.$value['id'].'" >
                                                <div class="dd-handle dd3-handle">Drag</div>
                                                <div class="dd3-content"><span id="label_show'.$value['id'].'">'.$value['sub_category_name'].'</span>
                                                    <span class="span-right">&nbsp;&nbsp;
                                                    <a class="del-button" id="'.$value['id'].'"><i class="fa fa-trash"></i></a></span>
                                                </div>';
                                        if(array_key_exists('child',$value)) {
                                            $html .= get_menu($value['child'],'child');
                                        }
                                        $html .= "</li>";
                                    }
                                    $html .= "</ol>";

                                    return $html;

                                }
                                print get_menu($items);
                                ?>

                            </div>
                            <textarea type="text" id="nestable-output" style="display: none;"></textarea>
                        </div>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--End---->

            <!--Add sub Category-->
            <div class="modal fade" id="modal-add-filter" style="display: none; padding-right: 15px;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Edit Sub Category</h4>
                        </div>
                        <form role="form" id="editfilterform" method="post" action="#">
                            <div class="modal-body">
                                <input type="hidden" id="sub_cat_id">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-8">
                                        <div class="form-group">
                                            <label id="filter_labal"> </label>
                                            <select class="form-control select2" style="width: 100%;" name="filter_select_option" id="filter_select_option">
                                                <option value="">Choose One Filter</option>
                                                @foreach($Questionnaire as $val)
                                                    <option value="{{$val->id}}">{{$val->questionnaire_type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--End---->

        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
@endsection


@push('scripts')
    <link rel="stylesheet" href="{{ asset('plugins/jquery-nestable/jquery.nestable.css') }}">
    <script src="{{ asset('plugins/jquery-nestable/jquery.nestable.js') }}" type="text/javascript"></script>

    <script>

        $(document).ready(function()
        {

            var updateOutput = function(e)
            {
                var list   = e.length ? e : $(e.target),
                    output = list.data('output');
                if (window.JSON) {
                    output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
                } else {
                    output.val('JSON browser support required for this demo.');
                }
            };

            // activate Nestable for list 1
            $('#nestable').nestable({
                group: 1,
                maxDepth: 2
            }).on('change', updateOutput);



            // output initial serialised data
            updateOutput($('#nestable').data('output', $('#nestable-output')));

            $('#nestable-menu').on('click', function(e)
            {
                var target = $(e.target),
                    action = target.data('action');
                if (action === 'expand-all') {
                    $('.dd').nestable('expandAll');
                }
                if (action === 'collapse-all') {
                    $('.dd').nestable('collapseAll');
                }
            });


        });
    </script>

    <script>
        $(document).ready(function(){

            /*$("#submit").click(function(){
                $("#load").show();

                var dataString = {
                    label : $("#label").val(),
                    link : $("#link").val(),
                    id : $("#id").val()
                };

                $.ajax({
                    type: "POST",
                    url: "save_menu.php",
                    data: dataString,
                    dataType: "json",
                    cache : false,
                    success: function(data){
                        if(data.type == 'add'){
                            $("#menu-id").append(data.menu);
                        } else if(data.type == 'edit'){
                            $('#label_show'+data.id).html(data.label);
                            $('#link_show'+data.id).html(data.link);
                        }
                        $('#label').val('');
                        $('#link').val('');
                        $('#id').val('');
                        $("#load").hide();
                    } ,error: function(xhr, status, error) {
                        alert(error);
                    },
                });
            });*/

            $('.dd').on('change', function() {
                $("#load").show();

                var dataString = {
                    data : $("#nestable-output").val(),
                };

                $.ajax({
                    type: "POST",
                    url: "/admin/change_order_save",
                    data: dataString,
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    cache : false,
                    success: function(data){
                        $("#load").hide();
                        var msg = "Re-orderd Successfully."
                        var delmsg = '<div class="alert alert-success" style="margin:0px !important;">';
                        delmsg += '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>';
                        delmsg += msg;
                        delmsg += '</div>';
                        $(".alert-success").remove();
                        $("#sort_modal_body").prepend(delmsg);
                        setTimeout(function () {
                            $("#sort_modal_body .alert").hide('slow');
                        },3000);
                    } ,error: function(xhr, status, error) {
                        alert(error);
                    },
                });
            });

            $(document).on("click",".del-button",function() {
                var x = confirm('Delete this menu?');
                var id = $(this).attr('id');
                if(x){
                    $("#load").show();
                    $.ajax({
                        type: "POST",
                        url: "/admin/deleteProSubCate",
                        data: { id : id },
                        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                        cache : false,
                        success: function(data){
                            $("#load").hide();
                            $("li[data-id='" + id +"']").remove();
                        } ,error: function(xhr, status, error) {
                            alert(error);
                        },
                    });
                }
            });

        });

    </script>
    <script type="text/javascript">

        $("#re-order-cat").click(function () {
            $("#modal-ordering").modal("show");
        });

        var selected = [];
        var deleteAjaxSource = '/admin/deleteProSubCate';
        var activeInactiveAjaxSource = '/admin/actInactProductSubCategoryStatus';
        var addEditSource = '<?php echo (Helper::checkActionPermission('admin','product-category-edit')) ? '/admin/product-category-edit' : ''; ?>';

        function showMessage(){
            return '<div id="load" style="display: block"></div>';
        }
        $(document).ready(function () {
            dTable = $('#SubCategoryList').dataTable({
                dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
                "<'row'<'col-xs-12't>>"+
                "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
                processing: true,
                serverSide: true,
                oLanguage: {
                    sProcessing: showMessage()
                },
                ajax: {
                    url: '/admin/productSubCategoryListGet/',
                    data: function (d) {
                        d.sub_category_name = $('input[name=sub_category_name]').val();
                        d.filter_id = $('select[name=filter_select_option_table]').val();
                        d.status = $('select[name=status_ser]').val();
                        d.cat_id = '<?php echo $Categories->id; ?>';
                    }
                },
                columns: [
                    { data : "id", sTitle: "<input type='checkbox' id='checkall' name='checkall'></input>", mDataProp: null, sWidth: "20px", sDefaultContent: "<input type='checkbox' ></input>", bSortable: false, bSearchable: false},
                    { data: 'sub_category_name', name: 'sub_category_name' },
                    { data: 'questionnaire_type', name: 'questionnaire_type' },
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
                            if(row.questionnaire_type == null){
                                return '<a href="javascript:;" data-sub_cat_name="'+row.sub_category_name+'" data-sub_cat_id="'+row.id+'"  class="fa fa-plus-circle add_filter"  title="Click to add filter"> Add filter</a>&nbsp;&nbsp;';
                            }else {
                                return row.questionnaire_type+'&nbsp;&nbsp;<a href="javascript:;" data-sub_cat_name="'+row.sub_category_name+'" data-sub_cat_id="'+row.id+'" data-filter="'+row.filter_id+'"  class="fa fa-pencil add_filter"  title="Click to edit filter"></a>';
                            }

                        },
                        "aTargets": [2]
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
                                html += '<a href="javascript:;" data-id="'+row.id+'" data-sub_category_name="'+row.sub_category_name+'" data-status="'+row.status+'" class="fa fa-edit edit_cat_tbl" title="Edit"></a>&nbsp;&nbsp;';
                            }

                            if (deleteAjaxSource) {

                                html += '<a href="javascript:void(0)" class="fa fa-trash" onclick="deleteAll(\'' + single + '\',' + row.id + ')" title="Click to Delete Record"></a>&nbsp;&nbsp;';

                            }
                            html += '</tr>';
                            html += '</table>';
                            return html;
                        },
                        "aTargets": [4]
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

        function checked_chkbx(chk)
        {
            if ($('#chk_' + chk).is(':checked')) {
                selected.push(chk);
            } else
            {
                selected.pop(chk);
            }
        }

        $('#SubCategoryList_paginate ul li').on('click', function () {
            setTimeout(check_checkbox, 200);
        });

        function check_checkbox()
        {
            for (var i = 0; i < selected.length; i++) {
                $('#chk_' + selected[i]).prop('checked', true);

            }
        }
        $(document).on("click",".add_filter",function () {
            $("#filter_select_option").val("").trigger("change.select2");
            if($(this).data('filter')){
                $("#filter_select_option").val($(this).data('filter')).trigger("change.select2");
            }
            $("#modal-add-filter").modal('show');
            $("#filter_labal").html("Choose Filter For "+$(this).data("sub_cat_name")+" <span class='asterisk red'>*</span>");
            var sub_cat_id =  $(this).data('sub_cat_id');
            $('#editfilterform').bootstrapValidator({
                excluded: [':disabled'],
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    filter_select_option	: {
                        validators: {
                            notEmpty: {
                                message: 'The Filter is required.'
                            }
                        }
                    }
                }
            }).on('success.form.bv', function(e) {

                $.ajax({
                    url: '/admin/AddfilterInSubCategory',
                    type: 'POST',
                    data: {
                            filter_id: $("#filter_select_option").val(),
                            sub_category_id: sub_cat_id
                    },
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                }).done(function(data, status) {
                    if(data == 1){
                        var msg = "Filter added successfully";
                        SuccessMessage(msg);
                        $("#modal-add-filter").modal('hide');
                        dTable.fnDraw(true);
                    }else {
                        var msg = "Filter added failed";
                        ErrorMessage(msg);
                    }

                });

                // If you want to prevent the default handler (bootstrapValidator._onSuccess(e))
                e.preventDefault();
            }).on('success.field.bv', function(e, data) {
                // I don't want to add has-success class to valid field container
                data.element.parents('.form-group').removeClass('has-success');
                // I want to enable the submit button all the time
                data.bv.disableSubmitButtons(false);
            });

        });
        $("#add_sub_cat").click(function () {
            $("#modal-add").modal('show');
        });
        $(document).on("click",".edit_cat_tbl",function () {

            $("#modal-edit").modal('show');
            $("#sub_category_name_edit").val($(this).data('sub_category_name'));
            $("#status_edit").val($(this).data('status')).trigger("change.select2");
            $("#sub_cat_id").val($(this).data('id'));
            $('#editform').bootstrapValidator({
                excluded: [':disabled'],
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    sub_category_name_edit	: {
                        validators: {
                            notEmpty: {
                                message: 'The Sub Category is required.'
                            }
                        }
                    },
                    status_edit: {
                        validators: {
                            notEmpty: {
                                message: 'The status is required'
                            }
                        }
                    }
                }
            }).on('success.form.bv', function(e) {

                $.ajax({
                    url: '/admin/AddSubCategory',
                    type: 'POST',
                    data: { sub_category_name: $("#sub_category_name_edit").val(),
                        status: $("#status_edit").val(),
                        sub_category_id:$("#sub_cat_id").val()},
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                }).done(function(data, status) {
                    //alert(data)
                    if(data == 1){
                        var msg = "Sub Category updated successfully";
                        SuccessMessage(msg);
                        $("#modal-edit").modal('hide');
                        dTable.fnDraw(true);
                        setTimeout(function () {
                            window.location.reload();
                        },3000);
                    }else {
                        var msg = "Sub Category updated failed";
                        ErrorMessage(msg);
                    }

                });
                // If you want to prevent the default handler (bootstrapValidator._onSuccess(e))
                e.preventDefault();
            }).on('success.field.bv', function(e, data) {
                // I don't want to add has-success class to valid field container
                data.element.parents('.form-group').removeClass('has-success');
                // I want to enable the submit button all the time
                data.bv.disableSubmitButtons(false);
            });
        });

        $('#FormControlCategories').bootstrapValidator({
            excluded: [':disabled'],
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                categories_name: {
                    validators: {
                        notEmpty: {
                            message: 'The Category is required.'
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
        $('#addform').bootstrapValidator({
            excluded: [':disabled'],
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                sub_category_name_add	: {
                    validators: {
                        notEmpty: {
                            message: 'The Sub Category is required.'
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
        }).on('success.form.bv', function(e) {

            $.ajax({
                url: '/admin/AddSubCategory',
                type: 'POST',
                data: { sub_category_name: $("#sub_category_name_add").val(),
                        category_id:'{{$Categories->id}}'},
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
            }).done(function(data, status) {
                //alert(data)
                if(data == 1){
                    var msg = "Sub Category added successfully";
                    SuccessMessage(msg);
                    $("#modal-add").modal('hide');
                    dTable.fnDraw(true);
                    $("#sub_category_name_add").val("");
                    setTimeout(function () {
                        window.location.reload();
                    },3000);
                }else {
                    var msg = "Sub Category added failed";
                    ErrorMessage(msg);
                }

            });
            // If you want to prevent the default handler (bootstrapValidator._onSuccess(e))
             e.preventDefault();
        }).on('success.field.bv', function(e, data) {
            // I don't want to add has-success class to valid field container
            data.element.parents('.form-group').removeClass('has-success');
            // I want to enable the submit button all the time
            data.bv.disableSubmitButtons(false);
        });
    </script>

@endpush