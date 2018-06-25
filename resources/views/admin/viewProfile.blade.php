@extends('layouts.master')
@section('title', 'Suril Jain - View Profile')
@section('content')

<div>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                View Profile
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                <li><a href="{{ url('admin/viewProfile') }}">View Profile</a></li>

            </ol>
        </section>
        
        <!-- Main content --> 
        <section class="content">
            <div class="row contentpanel">
                <div class="col-xs-12 text-right margin-bottom">
                    <a href="{{ url('/admin/editProfile') }}"><button class="btn btn-primary" type="button">Edit Profile</button></a>
                    <?php if (Helper::checkActionPermission('admin','profilechangePassword')) { ?>
                    <a href="{{ url('/admin/profilechangePassword') }}"><button class="btn btn-primary" type="button">Change Password</button></a>
                    <?php } ?>
                </div>
            </div> 
            <!--Form controls-->
            @if(Session::has('message'))
            <p class="alert alert-danger">{{ Session::get('message') }}</p>
            @endif
            @if(Session::has('success'))
            <p class="alert alert-success">{{ Session::get('success') }}</p>
            @endif
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title"> View Profile</h3>
                        </div>
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">

                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label>First Name</label><br>
                                        {{ $user->first_name }}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label>Last Name</label><br>
                                        {{ $user->last_name }}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label>Email Address </label><br>
                                        {{ $user->email_address }}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label>Status </label><br>
                                        {{ $user->status }}
                                    </div>
                                </div>

                            </div>
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
