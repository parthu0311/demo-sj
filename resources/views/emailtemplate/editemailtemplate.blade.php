@extends('layouts.master')
@section('title', 'Suril Jain - Edit Email Template')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Edit Email Template
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="{{ url('admin/emailtemplate/emailtemplatelist') }}">Email Templates</a></li>
            <li class="active">Edit Email Template </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!--Form controls-->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Email Template</h3>
                    </div>
                    <!--  Success flash-->
                    <form role="form" id="frm_staticpages" method="post" action="{{ url('admin/emailtemplate/update/'.$email_template->id) }}">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label>Subject <span class="asterisk red">*</span></label>
                                    <input class="form-control" placeholder="Subject" type="text" name="subject" value="{{ $email_template->subject }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label>Status <span class="asterisk red">*</span></label>
                                    <select class="form-control select2" style="width: 100%;" name="status">
                                        <option value="">Choose Status</option>
                                        <option {{ ($email_template->status == 'Active') ? "selected=selected" : "" }} value="active">Active</option>
                                        <option {{ ($email_template->status == 'Inactive') ? "selected='selected'" : "" }} value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label>Description <span class="asterisk red">*</span></label>
                                    <textarea class="form-control" rows="3" placeholder="Description" name="description" id="content">{{ $email_template->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button class="btn btn-default pull-right" onclick="window.location = '{{ url('admin/emailtemplate/emailtemplatelist') }}';" type="button">Cancel</button>
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
//
    $(document).ready(function () {
        $('#frm_staticpages')
                .bootstrapValidator({
                    excluded: [':disabled'],
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        subject: {
                            validators: {
                                notEmpty: {
                                    message: 'The subject is required'
                                }
                            }
                        },
                        status: {
                            validators: {
                                notEmpty: {
                                    message: 'The Status is required'
                                }
                            }
                        }, 
                    }
                });

    });
</script>
<script src="{{asset('/plugins/ckeditor/ckeditor.js')}}"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('content');
    //bootstrap WYSIHTML5 - text editor
    
  });
</script>  
@endpush