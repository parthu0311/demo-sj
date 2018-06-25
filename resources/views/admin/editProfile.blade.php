@extends('layouts.master')
@section('title', 'Suril Jain - Edit Profile')
@section('content')

<div>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Edit Profile
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                <li class="active">Edit Profile</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
           <!-- <div class="row contentpanel">
                <div class="col-xs-12 text-right margin-bottom">
                     <a href="{{ url('/admin/editProfile') }}"><button class="btn btn-primary" type="button">Edit Profile</button></a>
                     <a href="{{ url('admin/viewProfile') }}"><button class="btn btn-default pull-right" style="margin:0 0 0 5px" type="button">Cancel</button></a>
                </div>
            </div> -->
            <!--Form controls-->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title"> Edit Profile </h3>
                        </div>

                        <form role="form" id="FormControl" method="post" action="{{ url('/admin/updateProfile') }}">
                            {{ csrf_field() }}
                            <div class="box-body">
                                <div class="row">

                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label>First Name <span class="asterisk red">*</span></label>
                                            <input class="form-control" placeholder="First Name" value="{{ $user->first_name }}"  type="text" name="firstname">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label>Last Name <span class="asterisk red">*</span></label>
                                            <input class="form-control" placeholder="Last Name" value="{{ $user->last_name }}"  type="text" name="last_name">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label>Email Address <span class="asterisk red">*</span></label>
                                            <input class="form-control" placeholder="Email Address" value="{{ $user->email_address }}" type="text" name="email_address">
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label>Status <span class="asterisk red">*</span></label>
                                            <select class="form-control select2" style="width: 100%;" name="status">
                                                <option value="">Choose One</option>
                                                <option {{ $user->status == 'Active' ? 'selected="selected"' : '' }} value="Active">Active</option>
                                                <option {{ $user->status == 'Inactive' ? 'selected="selected"' : '' }} value="Inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="box-footer">
                                <a href="{{ url('admin/viewProfile') }}"><button class="btn btn-default pull-right" style="margin:0 0 0 5px" type="button">Cancel</button></a>
                                <button class="btn btn-primary pull-right" type="submit">Save</button>
                            </div>
                        </form>
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
