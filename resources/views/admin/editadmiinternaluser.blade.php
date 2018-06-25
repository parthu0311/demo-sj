@extends('layouts.master')
@section('title', 'Suril Jain - Edit Admin Internal Users')
@section('content')
<div>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Edit Admin Internal User
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                <li><a href="{{ url('admin/adminusers') }}">Admin User</a></li>
                <li class="active">Edit User</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!--Form controls-->

            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title"> Edit Form controls</h3>
                        </div>

                           <form role="form" id="FormControl" method="post" action="{{ url('/admin/updateInternalUser', $user->id) }}">
                            {{ csrf_field() }}
                            <div class="box-body">
                                <div class="row">

                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label>First Name <span class="asterisk red">*</span></label>
                                            <input class="form-control" placeholder="First Box" value="{{ $user->first_name }}"  type="text" name="firstname">
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
                                            <input class="form-control" placeholder="Email Address" value="{{ $user->email }}" type="text" name="email_address">
                                        </div>
                                    </div>

                                    @if(empty($user->id))
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label>Password <span class="asterisk red">*</span></label>
                                            <input class="form-control" placeholder="Password" type="password" name="password">
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label>Confirm Password<span class="asterisk red">*</span></label>
                                            <input class="form-control" placeholder="Confirm Password" type="password" name="cnfpassword">
                                        </div>
                                    </div>
                                    @endif

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
                                     <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label>Admin Role<span class="asterisk red">*</span></label>
                                            <select class="form-control select2" style="width: 100%;" name="role_id">
                                                <option value="">Select Admin Role</option>
                                                @foreach($AdminRole as $Role)
                                                <option {{ ($user->role_id == $Role->role_id) ? 'selected="selected"' : '' }} value="{{ $Role->role_id }}">{{ $Role->role_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label>Profile Picture<span class="asterisk red">*</span></label>
                                            <input id="file" type="file" name="profile_picture">
                                            <div>
                                                @if(!empty($user->profile_picture))
                                                    <img src="{{ asset('uploads/internal_user_images/'.$user->profile_picture) }}" height="80" width="150"/>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box-footer">
                                <a href="{{ url('admin/adminusers') }}"><button class="btn btn-default pull-right" style="margin:0 0 0 5px" type="button">Cancel</button></a>
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
@push('scripts')
<script type="text/javascript">
    // set up select2
    $('#FormControl').bootstrapValidator({
        excluded: [':disabled'],
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            firstname: {
                validators: {
                    notEmpty: {
                        message: 'The First Name is required.'
                    }
                }
            },
            last_name: {
                validators: {
                    notEmpty: {
                        message: 'The Last Name is required.'
                    }
                }
            },
            email_address: {
                validators: {
                    notEmpty: {
                        message: 'The Email Address is required.'
                    }, emailAddress: {
                        message: 'Please Enter Correct Email Address'
                    }
                }
            }, password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required'
                    },
                    identical: {
                        field: 'cnfpassword',
                        message: 'Password and confirmpassword Not match'
                    },
                }
            },
            cnfpassword: {
                validators: {
                    notEmpty: {
                        message: 'The Confirm password is required'
                    },
                    identical: {
                        field: 'password',
                        message: 'Password and confirmpassword Not match'
                    },
                }
            },
            role_id: {
                validators: {
                    notEmpty: {
                        message: 'The Role is required'
                    }
                }
            },
            status: {
                validators: {
                    notEmpty: {
                        message: 'The status is required'
                    }
                }
            },
        }
    });

</script>
@endpush