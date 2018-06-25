@extends('layouts.master')
@section('title', 'Suril Jain - Create Product Category')
@section('content')

    <div>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Create Product Category
                </h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                    <li><a href="{{ url('/admin/product-category-list') }}">Product Category List</a></li>
                    <li class="active">Create Product Category</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <!--Form controls-->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">Add Product Categories</h3>
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
                            <form role="form" id="FormControlCategories" method="post" action="{{ url('/admin/ProductCategoriesCreatePostData') }}">
                                {{ csrf_field() }}
                                <div class="box-body">
                                    <div class="row">

                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label>Category Name <span class="asterisk red">*</span></label>
                                                <input class="form-control" placeholder="Category Name" type="text" name="categories_name">
                                            </div>
                                        </div>

                                        {{--<div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label>Under the Category<span class="asterisk red"></span></label>
                                                <select class="form-control select2" style="width: 100%;" name="main_cat">
                                                    <option value="">Choose Category</option>
                                                    @foreach($cat as $key=>$value)
                                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>--}}

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

        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
@endsection


@push('scripts')
<script type="text/javascript">
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
</script>

@endpush