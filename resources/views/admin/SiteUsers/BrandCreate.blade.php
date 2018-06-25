@extends('layouts.master')
@section('title', 'Suril Jain - Create Brand')
@section('content')

    <div>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Create Brand
                </h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                    <li><a href="{{ url('/admin/brand-list') }}">Brand List </a></li>
                    <li class="active">Create Brand</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <!--Form controls-->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"> Create Brand</h3>
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
                            <div class="box-body" style="padding: 15px;">

                                <form role="form" id="brandCreatePostData" method="post" action="{{ url('/admin/brandCreatePostData') }}">
                                    {{ csrf_field() }}
                                    <div class="box-body">
                                        <div class="row">

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Brand Code <span class="asterisk red">*</span></label>
                                                    <input class="form-control" placeholder="Brand Code" type="text" name="product_brand_code">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Brand Name <span class="asterisk red">*</span></label>
                                                    <input class="form-control" placeholder="Brand Name" type="text" name="product_brand_name">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Status <span class="asterisk red">*</span></label>
                                                    <select class="form-control select2" style="width: 100%;" name="status">
                                                        <option value="">Choose One</option>
                                                        <option value="active">Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <a href="{{ url('/admin/brand-list') }}"><button class="btn btn-default pull-right" style="margin:0 0 0 5px" type="button">Cancel</button></a>
                                        <button type="submit" class="btn btn-primary pull-right" >Save</button>
                                    </div>
                                </form>


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

@push('scripts')
<script type="text/javascript">

    $('#brandCreatePostData').bootstrapValidator({
        excluded: [':disabled'],
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            product_brand_code: {
                validators: {
                    notEmpty: {
                        message: 'The Brand Code is required.'
                    }
                }
            },
            product_brand_name: {
                validators: {
                    notEmpty: {
                        message: 'The Brand Name is required.'
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