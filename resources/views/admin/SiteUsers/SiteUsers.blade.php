@extends('layouts.master')
@section('title', 'Suril Jain - Manage Site Users List')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Site Users List
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">Site Users List</li>
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
                                <label class="control-label">First Name</label>
                                <div class="" id="serproduct_brand_code"><span class="filter_column filter_text">
                                        <input type="text" class="search_init text_filter form-control" name="first_name" id="first_name" placeholder="Search First Name"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="form-group nomargin">
                                <label class="control-label">Last Name</label>
                                <div class="" id="sercollection_type"><span class="filter_column filter_text">
                                        <input type="text" class="search_init text_filter form-control" name="last_name" id="last_name" placeholder="Search Last Name"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="form-group nomargin">
                                <label class="control-label">Email</label>
                                <div class="" id="sercollection_type"><span class="filter_column filter_text">
                                        <input type="text" class="search_init text_filter form-control" name="email" id="email" placeholder="Search Email"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="form-group nomargin">
                                <label class="control-label">Mobile</label>
                                <div class="" id="sercollection_type"><span class="filter_column filter_text">
                                        <input type="text" class="search_init text_filter form-control" name="mobile" id="mobile" placeholder="Search Mobile"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="form-group nomargin">
                                <label class="control-label">Gender </label>
                                <div class="" id="serStatus">
                                    <span class="filterColumn filter_select">
                                    <select name="gender" id="gender"  class="search_init select_filter form-control">
                                            <option value="">Choose One</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                    </select>
                                    </span>
                                </div>
                            </div>
                        </div>

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
/*                if (Helper::checkActionPermission('admin','brand-create')) { */?><!--
                    <a href="{{ url('/admin/brand-create') }}"><button class="btn btn-primary" type="button">Add Brand</button></a>
                --><?php /*} */?>
            </div>
        </div>




        <!--Data Table-->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary box-solid">
                    <div class="box-header">
                        <h3 class="box-title">Site Users List</h3>
                    </div>

                    <div class="box-body">
						<div class="table-responsive">
							<table id="BrandList" class="table table-bordered table-striped">
								<thead>
									<tr>
                                        <th></th>
										<th>First Name</th>
										<th>Last Name</th>
										<th>Email</th>
										<th>Mobile</th>
										<th>Address</th>
										<th>Gender</th>
										<th>Birth-Date</th>
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



    var deleteAjaxSource = '<?php echo (Helper::checkActionPermission('admin','deleteSiteUsers')) ? 'deleteSiteUsers' : ''; ?>';
    var activeInactiveAjaxSource = '<?php echo (Helper::checkActionPermission('admin','actInactSiteUsersStatus')) ? 'actInactSiteUsersStatus' : ''; ?>';
    var addEditSource = '<?php echo (Helper::checkActionPermission('admin','brand-edit')) ? '/admin/brand-edit' : ''; ?>';

    function showMessage(){
       return '<div id="load" style="display: block"></div>';
    }
    $(document).ready(function () {
         dTable = $('#BrandList').dataTable({
            dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
            "<'row'<'col-xs-12't>>"+
            "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
            processing: true,
            serverSide: true,
            oLanguage: {
                 sProcessing: showMessage()
            },
            ajax: {
                url: '/admin/SiteUsersListAjax/',
                data: function (d) {
                    d.first_name = $('input[name=first_name]').val();
                    d.last_name = $('input[name=last_name]').val();
                    d.email = $('input[name=email]').val();
                    d.mobile = $('input[name=mobile]').val();
                    d.gender = $('select[name=gender]').val();
                    d.status = $('select[name=status]').val();
                }
            },
            columns: [
                { data : "id", sTitle: "<input type='checkbox' id='checkall' name='checkall'></input>", mDataProp: null, sWidth: "20px", sDefaultContent: "<input type='checkbox' ></input>", bSortable: false, bSearchable: false},
                { data: 'first_name', name: 'first_name' },
                { data: 'last_name', name: 'last_name' },
                { data: 'email', name: 'email' },
                { data: 'mobile', name: 'mobile' },
                { data: 'address', name: 'address' },
                { data: 'gender', name: 'gender' },
                { data: 'dob', name: 'dob' },
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
                        /*if (addEditSource) {
                            html += '<a href="' + addEditSource + '/' + row.id + '" class="fa fa-edit" title="Edit"></a>&nbsp;&nbsp;';
                        }*/

                        if (deleteAjaxSource) {

                            html += '<a href="javascript:void(0)" class="fa fa-trash" onclick="deleteAll(\'' + single + '\',' + row.id + ')" title="Click to Delete Record"></a>&nbsp;&nbsp;';

                        }

                        html += '</tr>';
                        html += '</table>';
                        return html;
                    },
                    "aTargets": [9]
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