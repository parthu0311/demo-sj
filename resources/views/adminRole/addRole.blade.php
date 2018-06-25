@extends('layouts.master')
@section('title', 'Suril Jain - Add Admin Users')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add User Role
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>          
            <li class="active">   Add User Role </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!--Form controls-->

        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"> Add User Role</h3>
                    </div>
                    <form role="form" id="frm_admin" method="post" action="{{ url('/admin/storeRole') }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label>Role Name <span class="asterisk red">*</span></label>
                                        <input class="form-control" placeholder="Role Name" value=""  type="text" name="role_name">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button class="btn btn-default pull-right" onclick="window.location = '{{ url('admin/privileges') }}';" type="button">Cancel</button>
                            <button class="btn btn-primary pull-right" type="submit">Save</button> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#frm_admin')
                .bootstrapValidator({
                    excluded: [':disabled'],
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        role_name: {
                            validators: {
                                notEmpty: {
                                    message: 'The Role Name is required'
                                }
                            }
                        },
                    }
                });
    });
</script>
@endpush