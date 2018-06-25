<?php
$PrivilagesData = $view_data['PrivilagesData'];
$Privilages = $view_data['Privilages'];
$AdminRoleArray = $view_data['AdminRole'];
$roleId = $view_data['UserType'];
?>

@extends('layouts.master')
@section('title', 'Suril Jain - Manage Admin Users')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Permission
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">Permission</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!--Form controls-->
        <div class="row">
            <div class="col-xs-12 text-right margin-bottom">
                <?php 
                if (Helper::checkActionPermission('admin','addRole')) { ?>
               {{-- <a href="{{ url('admin/addRole') }}" class="btn btn-primary">Add</a>--}}
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary box-solid">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form role="form" id="frm_admin" method="post" action="{{ url('/admin/privileges') }}">
                        <input type="hidden" name="role_name" value="{{  isset($_REQUEST['role_name']) ? $_REQUEST['role_name'] :'' }}">
                        {{ csrf_field() }}
                        <div class="box-header with-border">
                            <div class="col-sm-3">
                                <h3 class="box-title"> Permission</h3>
                                <div class="form-group {{ $errors->has('UserType') ? 'has-error' : '' }}">
                                    <select name="UserType" id="UserType_DP" class="form-control" data-placeholder="Choose role" required="" onchange="redirectUrlto(this);">
                                        <option value="">Choose Role</option>
                                        @foreach($AdminRoleArray as $Role)
                                        <?php
                                        $selected = ''; 
                                        if ($roleId == $Role->role_id) {
                                            $selected = 'selected="selected"';
                                        }
                                        ?>
                                        <option value="{{ $Role->role_id }}" <?php echo $selected; ?>>{!!  str_replace('_',' ',$Role->role_name); !!}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->first('UserType') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px">
                            <?php
                            if (isset($PrivilagesData) && !empty($PrivilagesData)) {
                                foreach ($PrivilagesData as $key => $val) {
                                    if ($key != 'CommanAction' && isset($val['SubAction']) && !empty($val['SubAction'])) {
                                        $style = '';
                                        if ($key == 'Permission') {
                                            $style = 'display:none;';
                                        }
                                        ?>
                                        <div class="col-sm-6 col-md-12" style="<?php echo $style; ?>">
                                            <div class="form-group">
                                                <div class="col-sm-6 col-md-2">
                                                    <label class="col-sm-12 control-label"><strong><?php echo $key; ?></strong></label>
                                                </div>
                                                <div class="col-sm-4 col-md-10">
                                                    <?php
                                                    foreach ($val['SubAction'] as $act) {
                                                       $checked = '';
                                                       if (isset($Privilages[0]->Permission) && ($Privilages[0]->Permission != "null")) {
                                                            $Permission = json_decode($Privilages[0]->Permission);
                                                                    if (in_array($act['Id'], $Permission)) {
                                                                        $checked = 'checked="checked"';
                                                                    }
                                                        }
                                                       
                                                        $style = '';
                                                        if ($act['Visible'] == 'No') {
                                                            $style = 'display:none;';
                                                        }
                                                        ?>
                                                        <div class="col-sm-8 col-md-3" style="<?php echo $style; ?>">
                                                            <div class="checkbox block styleshcheckbox">
                                                                <input type="checkbox"> 
                                                                <?php
                                                                $cls = '';
                                                                if ($act['ParentActionId'] > 0) {
                                                                    $cls = 'act_' . $act['ParentActionId'];
                                                                }
                                                                ?>
                                                                <input type="checkbox" value="{{ $act['Id'] }}" name="actionId[]" {{$checked}} id="act_{{ $act['Id'] }}" class="{{ $cls }}" onclick="CheckAction(this.id)"> 
                                                                <label><?php echo ucfirst(str_replace("Ajax", "(ajax)", $act['ActionName'])); ?></label></div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <hr/>
                                        </div>
                                        <?php
                                    } else {
                                        if (isset($PrivilagesData['CommanAction']) && !empty($PrivilagesData['CommanAction'])) {
                                            foreach ($PrivilagesData['CommanAction'] as $val1) {
                                                ?>
                                                <input type="checkbox" value="{{ $val1['Id'] }}" checked="checked" name="actionId[]" id="act_{{ $val1['Id'] }}" class="{{ $cls }}" onclick="CheckAction(this.id)" style="display:none;"> 
                                                <?php
                                            }
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>

                        <div class="box-footer">
                            <button onclick="window.location = '{{ url('admin/privileges') }}';" class="btn btn-default pull-right" type="button">Cancel</button>
                            <button class="btn btn-primary pull-right" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    function redirectUrlto(val) {
        var selectedText = val.options[val.selectedIndex].innerHTML;
        var selectedValue = val.value;

        window.location.href = '<?php url('admin/privileges'); ?>?type=' + selectedValue + '&role_name=' + selectedText;
        //$("#role_name").val(selectedText);
    }
    function CheckAction(id) {
        if ($('#' + id).prop('checked')) {
            $('.' + id).prop("checked", true);
            // something when checked
        } else {
            $('.' + id).prop("checked", false);
            // something else when not
        }
    }

</script>
@endPush