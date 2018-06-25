@extends('layouts.master')
@section('title', 'Suril Jain - Create Filter')
@section('content')

    <div ng-controller="QuestionnaireForCombinations">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Create Filter
                </h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                    <li><a href="{{ url('/admin/collection-type-list') }}">Filter Type List </a></li>
                    <li class="active">Create Filter</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <!--Form controls-->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"> Create Filter</h3>
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

                                <form role="form" id="FormControlQuestionnaire" method="post" action="{{ url('/admin/collectionForCombinations') }}">
                                    {{ csrf_field() }}
                                    <div class="box-body">
                                        <div class="row">

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label>Filter Type <span class="asterisk red">*</span></label>
                                                    <input class="form-control" placeholder="Filter Type" type="text" name="questionnaire_type">
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
                                    <textarea style="display: none;" id="json_created" name="json"></textarea>
                                    <button type="submit" id="Questionnairebtn" style="display: none;"></button>
                                </form>

                                <div class="row">

                                    <div class="col-md-3" >
                                        <div class="cstm-card">
                                            <h3>Elements</h3>
                                            <form role="form">
                                                {{--<div class="form-group draggable TextBox TextInput cstm-frmgrp">
                                                    <div class="tag">
                                                        <label for="label" >
                                                            <i class="flaticon flaticon-type-box"></i> Text Input
                                                        </label>
                                                    </div>
                                                    <div class="main-div" style="display: none">
                                                        <textarea class="textarea-hidden" data-is_show_tooltip="false" style="display: none;"></textarea>
                                                        <label for="label" >Text Input</label><span class="is_required"></span>
                                                        <input type="text" class="form-control" id="TextInput-1" placeholder="Enter Text" value="" Name="TextInput-1" maxlength="">
                                                        <span class="text-danger pull-right"></span>
                                                    </div>
                                                </div>--}}
                                                {{--<div class="form-group draggable TextInputNumber cstm-frmgrp">
                                                    <div class="tag">
                                                        <label for="label" >
                                                            <i class="flaticon flaticon-hash"></i> Text Input Number
                                                        </label>
                                                    </div>
                                                    <div class="main-div" style="display: none">
                                                        <textarea class="textarea-hidden" data-is_show_tooltip="false" style="display: none;"></textarea>
                                                        <label for="label" >Text Input Number</label><span class="is_required"></span>
                                                        <input type="text" class="form-control" id="TextInputNumber-1" onkeyup="TrooTech.only('digit',$(this).attr('id'))" placeholder="Enter Number" value="" Name="TextInputNumber-1" maxlength="">
                                                        <span class="text-danger pull-right"></span>
                                                    </div>
                                                </div>--}}
                                                <div class="form-group draggable redio Radio-btn cstm-frmgrp">
                                                    <div class="tag_label">
                                                        <label for="label" >
                                                            <i class="flaticon flaticon-list"></i> Radio Group
                                                        </label>
                                                    </div>
                                                    <div class="main-div" style="display: none">
                                                        <textarea class="textarea-hidden" data-is_show_tooltip="false" data-is_show_filter="false" style="display: none;"></textarea>
                                                        <label for="label" >Radio Group</label><span class="is_required"></span>
                                                        <div class="radio-group">
                                                            <div class="radio-inline">
                                                                <input name="radio-group-1" class=""  value="option-1" type="radio" checked="checked">
                                                                <label>Option 1</label>
                                                            </div>
                                                            <div class="radio-inline">
                                                                <input name="radio-group-1" class=""  value="option-3" type="radio">
                                                                <label>Option 3</label>
                                                            </div>
                                                            <span class="text-danger pull-right"></span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="form-group draggable CheckBox-btn cstm-frmgrp">
                                                    <div class="tag_label">
                                                        <label for="label" >
                                                            <i class="flaticon flaticon-list-1"></i> CheckBox Group
                                                        </label>
                                                    </div>
                                                    <div class="main-div" style="display: none">
                                                        <textarea class="textarea-hidden" data-is_show_tooltip="false" data-is_show_filter="false" style="display: none;"></textarea>
                                                        <label for="label" >CheckBox Group</label><span class="is_required"></span>
                                                        <div class="checkbox-group">
                                                            <div class="checkbox-inline">
                                                                <input name="checkbox-group-1-[]" class=""  value="option-1" type="checkbox" >
                                                                <label>Option 1</label>
                                                            </div>
                                                            <div class="checkbox-inline">
                                                                <input name="checkbox-group-1-[]" class=""  value="option-3" type="checkbox">
                                                                <label>Option 3</label>
                                                            </div>

                                                        </div>
                                                        <span class="text-danger pull-right"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group draggable Select-btn cstm-frmgrp">
                                                    <div class="tag_label">
                                                        <label for="label" >
                                                            <i class="flaticon flaticon-drop-down-list"></i> Select
                                                        </label>
                                                    </div>
                                                    <div class="main-div" style="display: none">
                                                        <textarea class="textarea-hidden" data-is_show_tooltip="false" data-is_show_filter="false" style="display: none;"></textarea>
                                                        <label for="label" >Select</label><span class="is_required"></span>
                                                        <select class="form-control" name="select-1" id="select-1">
                                                            <option value=""></option>
                                                            <option value="option-1">Option 1</option>
                                                            <option value="option-2">Option 2</option>
                                                            <option value="option-3">Option 3</option>
                                                        </select>
                                                        <span class="text-danger pull-right"></span>
                                                    </div>
                                                </div>
                                                {{--<div class="form-group draggable TextArea cstm-frmgrp">
                                                    <div class="tag">
                                                        <label for="label" >
                                                            <i class="flaticon flaticon-signs"></i> Text Area
                                                        </label>
                                                    </div>
                                                    <div class="main-div" style="display: none">
                                                        <textarea class="textarea-hidden" data-is_show_tooltip="false" style="display: none;"></textarea>
                                                        <label for="label" >Text Area</label><span class="is_required"></span>
                                                        <textarea type="textarea" placeholder="Enter Description" class="form-control" name="textarea-1" ></textarea>
                                                        <span class="text-danger pull-right"></span>
                                                    </div>
                                                </div>--}}
                                                {{--<div class="form-group draggable DatePicker-btn cstm-frmgrp">
                                                    <div class="tag">
                                                        <label for="label" >
                                                            <i class="flaticon flaticon-calendar"></i> DatePicker
                                                        </label>
                                                    </div>
                                                    <div class="main-div" style="display: none">
                                                        <textarea class="textarea-hidden" data-is_show_tooltip="false" style="display: none;"></textarea>
                                                        <label for="label" >DatePicker</label><span class="is_required"></span>
                                                        <input type="text" class="form-control datepicker" name="datepicker-1" id="datepicker-1" placeholder="Select Date">
                                                        <span class="text-danger pull-right"></span>
                                                    </div>
                                                </div>--}}
                                                <div class="form-group draggable MultiSelect-btn cstm-frmgrp">
                                                    <div class="tag_label">
                                                        <label for="label" >
                                                            <i class="flaticon flaticon-drop-down-list"></i> Multi Select
                                                        </label>
                                                    </div>
                                                    <div class="main-div" style="display: none">
                                                        <textarea class="textarea-hidden" data-is_show_tooltip="false" data-is_show_filter="false" style="display: none;"></textarea>
                                                        <label for="label" >Multi Select</label><span class="is_required"></span>
                                                        <select class="form-control Mselect2" name="multiselect-1-[]" id="multiselect-1" multiple="multiple">
                                                            <option value=""></option>
                                                            <option value="option-1">Option 1</option>
                                                            <option value="option-2">Option 2</option>
                                                            <option value="option-3">Option 3</option>
                                                        </select>
                                                        <span class="text-danger pull-right"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group draggable MultiSelect-tag-btn cstm-frmgrp">
                                                    <div class="tag_label">
                                                        <label for="label" >
                                                            <i class="flaticon flaticon-drop-down-list"></i> Multi Select Color
                                                        </label>
                                                    </div>
                                                    <div class="main-div" style="display: none">
                                                        <textarea class="textarea-hidden" data-is_show_tooltip="false" data-is_show_filter="false" style="display: none;"></textarea>
                                                        <label for="label" >Multi Select Color</label><span class="is_required"></span>
                                                        <input type="text" class="form-control tg_input" id="tag-input-1" placeholder="Add colors, pressing 'Enter between each one" value="Red,Black"/>
                                                        <span class="text-danger pull-right"></span>
                                                    </div>
                                                </div>
                                                {{--<div class="form-group draggable FileInput cstm-frmgrp">
                                                    <div class="tag">
                                                        <label for="label" >
                                                            <i class="flaticon flaticon-arrows"></i> File Upload
                                                        </label>
                                                    </div>
                                                    <div class="main-div" style="display: none">
                                                        <textarea class="textarea-hidden" data-is_show_tooltip="false" style="display: none;"></textarea>
                                                        <label for="label" >File Input</label><span class="is_required"></span>
                                                        <input type="file" class="form-control" id="FileInput-1"  Name="FileInput-1" maxlength="">
                                                        <span class="text-danger pull-right"></span>
                                                    </div>
                                                </div>--}}

                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-md-9" >
                                        <div style="background-color: #fff; border-radius: 5px; padding: 20px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175); ">
                                            <div class="text-muted empty-form text-center" style="font-size: 24px;">Drag & Drop elements to build Filter.</div>
                                            <div class="row form-body">
                                                <div class="col-md-12 droppable sortable dropzone" id="Main_div_dropzone">

                                                    @if(isset($data) && !empty($data['questionnaire_for_combinations']))
                                                        <?php $data2 = json_decode($data['questionnaire_for_combinations'], true); ?>
                                                        @foreach($data2 as $key=>$val)
                                                            @if($val['field_type'] == 'TextInput')
                                                                <div class="form-group TextBox TextInput ui-draggable" style="cursor: move">
                                                                    <div class="main-div" >
                                                                            <textarea class="textarea-hidden"
                                                                                      data-is_show_tooltip="<?php if($val['is_show_tooltip'] == 'Yes'){ echo 'True'; }else{ echo 'false'; } ?>" style="display: none;">{{$val['field_Tooltip']}}</textarea>
                                                                        <label for="label" >{{$val['field_label']}}</label><span class="is_required"><?php if($val['is_required'] == 'Yes'){ echo '*'; } ?></span>
                                                                        <input type="text" class="form-control" id="TextInput-edit-{{\App\Http\Helper::randomString()}}"
                                                                               placeholder="{{$val['field_placeholder']}}"
                                                                               value="<?php if(!empty($val['value'])){ echo $val['value'][0]['value']; } ?>"
                                                                               Name="TextInput-edit-{{\App\Http\Helper::randomString()}}"
                                                                               maxlength="<?php if($val['field_max_length'] != 0){ echo $val['field_max_length']; } ?>">
                                                                        <span class="text-danger pull-right"></span>
                                                                    </div>
                                                                    <p class="tools"><a class="edit-link">Edit HTML</a><a> | </a><a class="remove-link">Remove</a></p>
                                                                </div>
                                                            @elseif($val['field_type'] == 'TextInputNumber')
                                                                <div class="form-group TextInputNumber ui-draggable" style="cursor: move">
                                                                    <div class="main-div" >
                                                                            <textarea class="textarea-hidden"
                                                                                      data-is_show_tooltip="<?php if($val['is_show_tooltip'] == 'Yes'){ echo 'True'; }else{ echo 'false'; } ?>" style="display: none;">{{$val['field_Tooltip']}}</textarea>
                                                                        <label for="label" >{{$val['field_label']}}</label><span class="is_required"><?php if($val['is_required'] == 'Yes'){ echo '*'; } ?></span>
                                                                        <input type="text" class="form-control" id="TextInputNumber-edit-{{$key}}"
                                                                               placeholder="{{$val['field_placeholder']}}"
                                                                               value="<?php if(!empty($val['value'])){ echo $val['value'][0]['value']; } ?>"
                                                                               Name="TextInputNumber-edit-{{$key}}"
                                                                               maxlength="<?php if($val['field_max_length'] != 0){ echo $val['field_max_length']; } ?>"
                                                                               onkeyup="TrooTech.only('digit',$(this).attr('id'))">
                                                                        <span class="text-danger pull-right"></span>
                                                                    </div>
                                                                    <p class="tools"><a class="edit-link">Edit HTML</a><a> | </a><a class="remove-link">Remove</a></p>
                                                                </div>
                                                            @elseif($val['field_type'] == 'Radio-btn')
                                                                <div class="form-group redio Radio-btn  ui-draggable" style="cursor: move">
                                                                    <div  class="main-div">
                                                                            <textarea style="display: none;"
                                                                                      data-is_show_tooltip="<?php if($val['is_show_tooltip'] == 'Yes'){ echo 'True'; }else{ echo 'false'; } ?>" class="textarea-hidden">{{$val['field_Tooltip']}}</textarea>
                                                                        <label for="label">{{$val['field_label']}}</label><span class="is_required"><?php if($val['is_required'] == 'Yes'){ echo '*'; } ?></span>
                                                                        <div class="radio-group">
                                                                            @foreach($val['value'] as $single)
                                                                                <div class="radio-inline">
                                                                                    <input type="radio" value="{{$single['value']}}"
                                                                                           <?php if($single['is_ckecked'] == "Yes"){echo "checked='checked'"; } ?>
                                                                                           class="" name="radio-group-edit-{{$key}}-[]">
                                                                                    <label>{{$single['value']}}</label>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                        <span class="text-danger pull-right"></span>
                                                                    </div>
                                                                    <p class="tools"><a class="edit-link">Edit HTML</a><a> | </a><a class="remove-link">Remove</a></p>
                                                                </div>
                                                            @elseif($val['field_type'] == 'CheckBox-btn')
                                                                <div class="form-group CheckBox-btn  ui-draggable" style="cursor: move">
                                                                    <div  class="main-div">
                                                                            <textarea style="display: none;"
                                                                                      data-is_show_tooltip="<?php if($val['is_show_tooltip'] == 'Yes'){ echo 'True'; }else{ echo 'false'; } ?>" class="textarea-hidden">{{$val['field_Tooltip']}}</textarea>
                                                                        <label for="label">{{$val['field_label']}}</label><span class="is_required"><?php if($val['is_required'] == 'Yes'){ echo '*'; } ?></span>
                                                                        <div class="checkbox-group">
                                                                            @foreach($val['value'] as $single)
                                                                                <div class="checkbox-inline">
                                                                                    <input type="checkbox" value="{{$single['value']}}"
                                                                                           <?php if($single['is_ckecked'] == "Yes"){echo "checked='checked'"; } ?>
                                                                                           class="" name="checkbox-group-edit-{{$key}}-[]">
                                                                                    <label>{{$single['value']}}</label>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                        <span class="text-danger pull-right"></span>
                                                                    </div>
                                                                    <p class="tools"><a class="edit-link">Edit HTML</a><a> | </a><a class="remove-link">Remove</a></p>
                                                                </div>
                                                            @elseif($val['field_type'] == 'Select-btn')
                                                                <div class="form-group Select-btn  ui-draggable" style="cursor: move">
                                                                    <div  class="main-div">
                                                                            <textarea style="display: none;"
                                                                                      data-is_show_tooltip="<?php if($val['is_show_tooltip'] == 'Yes'){ echo 'True'; }else{ echo 'false'; } ?>" class="textarea-hidden">{{$val['field_Tooltip']}}</textarea>
                                                                        <label for="label">{{$val['field_label']}}</label><span class="is_required"><?php if($val['is_required'] == 'Yes'){ echo '*'; } ?></span>
                                                                        <select id="select-edit-{{$key}}" name="select-edit-{{$key}}" class="form-control basic-single">
                                                                            <option value=""></option>
                                                                            @foreach($val['value'] as $single)
                                                                                <option value="{{$single['value']}}"
                                                                                <?php if($single['is_ckecked'] == "Yes"){echo "selected"; } ?>>{{$single['value']}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <span class="text-danger pull-right"></span>
                                                                    </div>
                                                                    <p class="tools"><a class="edit-link">Edit HTML</a><a> | </a><a class="remove-link">Remove</a></p>
                                                                </div>
                                                            @elseif($val['field_type'] == 'TextArea')
                                                                <div class="form-group TextArea ui-draggable" style="cursor: move">
                                                                    <div class="main-div" >
                                                                            <textarea class="textarea-hidden"
                                                                                      data-is_show_tooltip="<?php if($val['is_show_tooltip'] == 'Yes'){ echo 'True'; }else{ echo 'false'; } ?>" style="display: none;">{{$val['field_Tooltip']}}</textarea>
                                                                        <label for="label" >{{$val['field_label']}}</label><span class="is_required"><?php if($val['is_required'] == 'Yes'){ echo '*'; } ?></span>
                                                                        <textarea name="textarea-edit-{{$key}}" class="form-control"
                                                                                  placeholder="{{$val['field_placeholder']}}" type="textarea"><?php if(!empty($val['value'])){ echo $val['value'][0]['value']; } ?></textarea>
                                                                        <span class="text-danger pull-right"></span>
                                                                    </div>
                                                                    <p class="tools"><a class="edit-link">Edit HTML</a><a> | </a><a class="remove-link">Remove</a></p>
                                                                </div>
                                                            @elseif($val['field_type'] == 'DatePicker-btn')
                                                                <div class="form-group DatePicker-btn ui-draggable" style="cursor: move">
                                                                    <div class="main-div" >
                                                                            <textarea class="textarea-hidden"
                                                                                      data-is_show_tooltip="<?php if($val['is_show_tooltip'] == 'Yes'){ echo 'True'; }else{ echo 'false'; } ?>" style="display: none;">{{$val['field_Tooltip']}}</textarea>
                                                                        <label for="label" >{{$val['field_label']}}</label><span class="is_required"><?php if($val['is_required'] == 'Yes'){ echo '*'; } ?></span>
                                                                        <input type="text"
                                                                               placeholder="{{$val['field_placeholder']}}" id="datepicker-edit-{{$key}}"
                                                                               name="datepicker-edit-{{$key}}"
                                                                               value="<?php if(!empty($val['value'])){ echo $val['value'][0]['value']; } ?>"
                                                                               class="form-control datepicker">
                                                                        <span class="text-danger pull-right"></span>
                                                                    </div>
                                                                    <p class="tools"><a class="edit-link">Edit HTML</a><a> | </a><a class="remove-link">Remove</a></p>
                                                                </div>
                                                            @elseif($val['field_type'] == 'MultiSelect-btn')
                                                                <div class="form-group MultiSelect-btn ui-draggable" style="cursor: move">
                                                                    <div class="main-div" >
                                                                            <textarea class="textarea-hidden"
                                                                                      data-is_show_tooltip="<?php if($val['is_show_tooltip'] == 'Yes'){ echo 'True'; }else{ echo 'false'; } ?>"
                                                                                      style="display: none;">{{$val['field_Tooltip']}}</textarea>
                                                                        <label for="label" >{{$val['field_label']}}</label><span class="is_required"><?php if($val['is_required'] == 'Yes'){ echo '*'; } ?></span>
                                                                        <select id="select-edit-{{$key}}" name="multiselect-edit-{{$key}}-[]" id="multiselect-edit-{{$key}}" class="form-control Mselect2 Mselect2-edit" multiple>
                                                                            <option value=""></option>
                                                                            @foreach($val['value'] as $single)
                                                                                <option value="{{$single['value']}}"
                                                                                <?php if($single['is_ckecked'] == "Yes"){echo "selected"; } ?>>
                                                                                    {{$single['value']}}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <span class="text-danger pull-right"></span>
                                                                    </div>
                                                                    <p class="tools"><a class="edit-link">Edit HTML</a><a> | </a><a class="remove-link">Remove</a></p>
                                                                </div>
                                                            @elseif($val['field_type'] == 'FileInput')
                                                                <div class="form-group FileInput ui-draggable" style="cursor: move">
                                                                    <div class="main-div" >
                                                                        <textarea class="textarea-hidden"
                                                                                  data-is_show_tooltip="<?php if($val['is_show_tooltip'] == 'Yes'){ echo 'True'; }else{ echo 'false'; } ?>" style="display: none;">{{$val['field_Tooltip']}}</textarea>
                                                                        <label for="label" >{{$val['field_label']}}</label><span class="is_required"><?php if($val['is_required'] == 'Yes'){ echo '*'; } ?></span>
                                                                        <input type="file" class="form-control" id="FileInput-edit-{{$key}}"
                                                                               Name="FileInput-edit-{{$key}}">
                                                                        <span class="text-danger pull-right"></span>
                                                                    </div>
                                                                    <p class="tools"><a class="edit-link">Edit HTML</a><a> | </a><a class="remove-link">Remove</a></p>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="box-footer">
                                    <a href="{{ url('/admin/questionnaire-type-list') }}"><button class="btn btn-default pull-right" style="margin:0 0 0 5px" type="button">Cancel</button></a>
                                    <button type="button" class="btn btn-primary pull-right"  id="FromSubmit">Save</button>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>



            </section>
            <!-- /.content -->


        </div>
        <!-- /.content-wrapper -->

        <div class="modal" style="overflow: auto;" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <a type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
                        <h4 class="modal-title">Edit HTML</h4>
                    </div>
                    <div class="modal-body ui-front config">

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" >Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./wrapper -->
@endsection

<style type="text/css">

    .droppable-active { background-color: #ffe !important; }
    .tools a { cursor: pointer; font-size: 80%; }
    .form-body .col-md-6, .form-body .col-md-12 { min-height: 400px; }
    .draggable { cursor: move; }
</style>
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker-1.6.4/css/bootstrap-datepicker.css') }}">

@push('scripts')
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-tagsinput-latest/dist/bootstrap-tagsinput.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-tagsinput-latest/examples/assets/app.css') }}">
<script src="{{ asset('plugins/bootstrap-tagsinput-latest/src/bootstrap-tagsinput.js') }}"></script>
<script src="http://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.min.js"></script>

<script src="{{ asset('angular/QuestionnaireForCombinations.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<!--<script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>-->
<script src="{{ asset('plugins/form-builder/js/jquery.ui.min.js') }}"></script>
<script src="{{ asset('plugins/form-builder/js/bootstrap.js') }}"></script>
<script src="{{ asset('plugins/form-builder/js/beautifyhtml.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-datepicker-1.6.4/js/bootstrap-datepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
<script type="text/javascript">

    $(document).ready(function() {
        //$(".dropzone").append($('.email').html());
        setup_draggable();
        $('.datepicker').datepicker({});
        $('.Mselect2-edit').select2({
            placeholder: 'Select an option',
            allowClear: true
        });
        $('.basic-single').select2({
            placeholder: 'Select an option',
            allowClear: true
        });
    });


    var cities = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: $("#json_url").val()
    });
    cities.initialize();

    var setup_draggable = function() {
        $( ".draggable" ).draggable({
            appendTo: "body",
            helper: "clone"
        });
        $( ".droppable" ).droppable({
            accept: ".draggable",
            helper: "clone",
            hoverClass: "droppable-active",
            drop: function( event, ui ) {
                //$(".empty-form").remove();
                var $orig = $(ui.draggable);
                if(!$(ui.draggable).hasClass("dropped")) {

                    var $el = $orig
                        .clone()
                        .addClass("dropped")
                        .css({"position": "static", "left": null, "right": null})
                        .appendTo(this);

                    // update id
                    //console.log($(this));
                    $(this).find(".tag_label").css("display",'none');
                    $(this).find(".main-div").css("display",'block');
                    if($el.hasClass('TextBox') == true){
                        var id = $orig.find("input").attr("id");
                        if(id) {
                            id = id.split("-").slice(0,-1).join("-") + "-"
                                + (parseInt(id.split("-").slice(-1)[0]) + 1);

                            $orig.find("input").attr("id", id);
                            $orig.find("label").attr("for", id);
                        }
                    }else if($el.hasClass('TextInputNumber') == true){
                        var id = $orig.find("input").attr("id");
                        if(id) {
                            id = id.split("-").slice(0,-1).join("-") + "-"
                                + (parseInt(id.split("-").slice(-1)[0]) + 1);

                            $orig.find("input").attr("id", id);
                            $orig.find("label").attr("for", id);
                        }
                    }else if($el.hasClass('Radio-btn') == true){
                        var id = $orig.find("input").attr("name");
                        id = id.split("-").slice(0,-1).join("-") + "-"
                            + (parseInt(id.split("-").slice(-1)[0]) + 1);
                        $orig.find("input").attr("name", id);

                    }else if($el.hasClass('CheckBox-btn') == true){
                        var id = $orig.find("input").attr("name");
                        id = id.split("-").slice(0,-2).join("-") + "-"
                            + (parseInt(id.split("-").slice(-2)[0]) + 1)+ "-[]";
                        $orig.find("input").attr("name", id);
                    }else if($el.hasClass('Select-btn') == true){
                        var id = $orig.find("select").attr("name");
                        var ids = $orig.find("select").attr("name");
                        id = id.split("-").slice(0,-1).join("-") + "-"
                            + (parseInt(id.split("-").slice(-1)[0]) + 1);
                        $orig.find("select").attr("name", id);
                        $orig.find("select").attr("id", id);
                        $('#'+ids).select2({
                            placeholder: 'Select an option',
                            allowClear: true
                        });
                    }else if($el.hasClass('TextArea') == true){
                        var id = $orig.find("textarea:eq(1)").attr("name");
                        id = id.split("-").slice(0,-1).join("-") + "-"
                            + (parseInt(id.split("-").slice(-1)[0]) + 1);
                        $orig.find("textarea").attr("name", id);
                    }else if($el.hasClass('DatePicker-btn') == true){
                        var id = $orig.find("input").attr("name");
                        if(id) {
                            id = id.split("-").slice(0,-1).join("-") + "-"
                                + (parseInt(id.split("-").slice(-1)[0]) + 1);

                            $orig.find("input").attr("id", id);
                            $orig.find("label").attr("for", id);
                        }
                        $('.datepicker').datepicker({});
                    }else if($el.hasClass('MultiSelect-btn') == true){
                        var id = $orig.find("select").attr("name");
                        id = id.split("-").slice(0,-2).join("-") + "-"
                            + (parseInt(id.split("-").slice(-2)[0]) + 1)+ "-[]";
                        $orig.find("select").attr("name", id);
                        var ids = $orig.find("select").attr("id");
                        var ids1 = $orig.find("select").attr("id");
                        ids = ids.split("-").slice(0,-1).join("-") + "-"
                            + (parseInt(ids.split("-").slice(-1)[0]) + 1);
                        $orig.find("select").attr("id", ids);
                        $('#'+ids1).select2({
                            placeholder: 'Select an option',
                            allowClear: true
                        });
                    }else if($el.hasClass('MultiSelect-tag-btn') == true){
                        var id = $orig.find("input").attr("id");
                        var id_old = $orig.find("input").attr("id");
                        if(id) {
                            id = id.split("-").slice(0,-1).join("-") + "-"
                                + (parseInt(id.split("-").slice(-1)[0]) + 1);

                            $orig.find("input").attr("id", id);
                            $orig.find("input").addClass(id);
                            $orig.find("label").attr("for", id);
                            var eltq = $('#'+id_old);
                            var el_value = $('#'+id_old).val();
                            eltq.tagsinput({
                                tagClass: function(item) {
                                    return 'label '+item.color;
                                },
                                itemValue: 'value',
                                itemText: 'text',
                                typeaheadjs: {
                                    name: 'cities',
                                    displayKey: 'text',
                                    source: cities.ttAdapter()
                                }
                            });
                            var _data = cities.index.datums;
                            $.each(_data,function (key,val) {
                               if(jQuery.inArray(val.text, el_value.split(',')) !== -1){
                                   eltq.tagsinput('add', val);
                               }
                            });
                            $('.twitter-typeahead').find("input").css("vertical-align","unset");
                        }

                    }else if($el.hasClass('FileInput') == true){
                        var id = $orig.find("input").attr("id");
                        if(id) {
                            id = id.split("-").slice(0,-1).join("-") + "-"
                                + (parseInt(id.split("-").slice(-1)[0]) + 1);

                            $orig.find("input").attr("id", id);
                            $orig.find("label").attr("for", id);
                        }
                    }

                    // tools
                    $('<p class="tools">\
						<a class="edit-link">Edit HTML<a> | \
						<a class="remove-link">Remove</a></p>').appendTo($el);
                }
                /*else {
                 if($(this)[0]!=$orig.parent()[0]) {
                 var $el = $orig
                 .clone()
                 .css({"position": "static", "left": null, "right": null})
                 .appendTo(this);
                 $orig.remove();
                 }
                 }*/
            }
        }).sortable();

    };

    var get_modal = function(content) {
        var modal = $('<div class="modal" style="overflow: auto;" tabindex="-1">\
			<div class="modal-dialog">\
				<div class="modal-content">\
					<div class="modal-header">\
						<a type="button" class="close"\
							data-dismiss="modal" aria-hidden="true">&times;</a>\
						<h4 class="modal-title">Edit HTML</h4>\
					</div>\
					<div class="modal-body ui-Front config">\
						'+content+'\
						<button class="btn btn-success">Update</button>\
					</div>\
				</div>\
			</div>\
			</div>').appendTo(document.body);

        return modal;
    };


    $(document).on("click", ".remove-link", function(ev) {
        $(this).parent().parent().remove();
    });

    $('#FormControlQuestionnaire').bootstrapValidator({
        excluded: [':disabled'],
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            questionnaire_type: {
                validators: {
                    notEmpty: {
                        message: 'The Questionnaire Type is required.'
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

    /*function cartesian() {
        var r = [], arg = arguments, max = arg.length-1;
        function helper(arr, i) {
            for (var j=0, l=arg[i].length; j<l; j++) {
                var a = arr.slice(0);
                a.push(arg[i][j]);
                if (i==max)
                    r.push(a);
                else
                    helper(a, i+1);
            }
        }
        helper([], 0);
        return r;
    }
    var data = cartesian(['s','m','l'], ['green','white']);
    console.log(data);*/

</script>

@endpush