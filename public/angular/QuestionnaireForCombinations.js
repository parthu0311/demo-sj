'use strict';
angular.module('app')
    .controller('QuestionnaireForCombinations', function($rootScope,$scope,$location,$resource,$timeout,$http,$compile) {
        $scope.image_array = [];

        function Required(is_required) {
            var label_html = '<div class="col-xs-12 col-sm-6 col-md-6">';
            label_html += ' <div class="form-group">';
            label_html += ' <label>Required</label>';
            label_html += ' <input type="checkbox"  '+is_required+' name="Required" >';
            label_html += ' </div>';
            label_html += '</div>';
            return label_html;
        }
        function Show_Tooltip(is_show) {
            var label_html = '<div class="col-xs-12 col-sm-6 col-md-6">';
            label_html += ' <div class="form-group">';
            label_html += ' <label>Set As Variant</label>';
            label_html += ' <input type="checkbox"  '+is_show+' name="ShowTooltip" >';
            label_html += ' </div>';
            label_html += '</div>';
            return label_html;
        }
        function Show_Filter(is_set) {
            var label_html = '<div class="col-xs-12 col-sm-6 col-md-6">';
            label_html += ' <div class="form-group">';
            label_html += ' <label>Set as filter for front?</label>';
            label_html += ' <input type="checkbox"  '+is_set+' name="ShowFilter" >';
            label_html += ' </div>';
            label_html += '</div>';
            return label_html;
        }
        function label_html(label_value) {
            var label_html = '<div class="col-xs-12 col-sm-6 col-md-12">';
            label_html += ' <div class="form-group">';
            label_html += ' <label>Label</label>';
            label_html += ' <input type="text" name="Label" value="'+label_value+'" placeholder="Label Text"  class="form-control">';
            label_html += ' </div>';
            label_html += '</div>';
            return label_html;
        }
        function Placeholder(Placeholder) {
            var label_html = '<div class="col-xs-12 col-sm-6 col-md-12">';
            label_html += ' <div class="form-group">';
            label_html += ' <label>Placeholder</label>';
            label_html += ' <input type="text" name="Placeholder" value="'+Placeholder+'" placeholder="Placeholder Text"  class="form-control">';
            label_html += ' </div>';
            label_html += '</div>';
            return label_html;
        }
        function Tooltip_html(Tooltip) {
            var label_html = '<div class="col-xs-12 col-sm-6 col-md-12">';
            label_html += ' <div class="form-group">';
            label_html += ' <label>Tooltip</label>';
            label_html += ' <input type="text" name="Tooltip" value="'+Tooltip+'" placeholder="Tooltip Text"  class="form-control">';
            label_html += ' </div>';
            label_html += '</div>';
            return label_html;
        }
        function MaxLength(length) {
            var label_html = '<div class="col-xs-12 col-sm-6 col-md-12">';
            label_html += ' <div class="form-group">';
            label_html += ' <label>Max Length</label>';
            label_html += ' <input type="number" name="MaxLength" min="0" value="'+length+'" class="form-control" >';
            label_html += ' </div>';
            label_html += '</div>';
            return label_html;
        }
        function Radio(array_temp) {
            var Radio = '<div class="col-xs-12 col-sm-6 col-md-12">';
                Radio += '<div class="form-group">';
                Radio += '<label>Options</label>';
                Radio += '<div class="sortable-options-wrap">';
                Radio += '<ol class="sortable-options ui-sortable">';
                $.each(array_temp,function (key,val) {
                    Radio += '<li class="ui-sortable-handle">';
                    /*Radio += '<input type="radio" class="option-selected" value="false" name="">';*/
                    /*Radio += '<input type="text" value="'+val+'" name="" placeholder="Label" >';*/
                    Radio += '<input type="text" data-is_checked="'+val['is_checked']+'" value="'+val['val']+'" name="" placeholder="Value">';
                    if(key > 1){
                        Radio += '<a class="remove btn" title="Remove Element">×</a>';
                    }
                    Radio += '</li>';
                });

                Radio += '</ol>';
                Radio += '<div class="option-actions pull-right"><a href="javascript:;" class="add add-opt">Add Option +</a>';
                Radio += '</div>';
                Radio += '</div>';
                Radio += '</div>';
            return Radio;
        }

        $(document).on("click", ".add-opt",function () {
        var Radio  = '<li class="ui-sortable-handle">';
            /*Radio += '<input type="radio" class="option-selected" value="false" name="">';*/
            /*Radio += '<input type="text" value="" name="" placeholder="Label" >';*/
            Radio += '<input type="text" value="" name="" placeholder="Value">';
            Radio += '<a class="remove btn" title="Remove Element">×</a>';
            Radio += '</li>';
            $('.sortable-options').append(Radio);
        });
        $(document).on("click", ".remove",function () {
            $(this).parent('li').remove();
        });


        $(document).on("click", ".edit-link", function(ev) {
            var $el = $(this).parent().parent();
            var label_value = $el.find('.main-div label:first').text();
            var Tooltip = $el.find('.main-div .textarea-hidden').text();
            var is_show_tooltip = $el.find('.main-div .textarea-hidden').data('is_show_tooltip');
            var is_show_filter = $el.find('.main-div .textarea-hidden').data('is_show_filter');
            var is_required = $el.find('.main-div .is_required').text();
            if(is_required == '*'){
                is_required = "checked='checked'";
            }else{
                is_required = "";
            }
            if(is_show_tooltip == "True"){
                is_show_tooltip = "checked='checked'";
            }else{
                is_show_tooltip = "";
            }
            if(is_show_filter == "True"){
                is_show_filter = "checked='checked'";
            }else{
                is_show_filter = "";
            }

            if($el.hasClass('TextBox') == true || $el.hasClass('TextInputNumber') == true){

                var input_value = $el.find('.main-div input').val();
                var input_placeholder = $el.find('.main-div input').attr('placeholder');
                var input_name = $el.find('.main-div input').attr('placeholder');
                var maxlength = $el.find('.main-div input').attr('maxlength');

                var config = '<div class="row tConfig">';
                config += Required(is_required);
                config += label_html(label_value);
                config += Tooltip_html(Tooltip);
                config += Show_Tooltip(is_show_tooltip);
                config += MaxLength(maxlength);
                config += Placeholder(input_placeholder);
                config += '</div>';
                var $el_copy = $el.clone();

            }else if($el.hasClass('Radio-btn') == true){

                var config = '<div class="row tConfig">';
                config += Required(is_required);
                config += Show_Filter(is_show_filter);

                config += label_html(label_value);
                /*config += Tooltip_html(Tooltip);
                config += Show_Tooltip(is_show_tooltip);*/
                    var array_temp = [];
                    $el.find('.radio-group input').each(function () {
                        var temp = {};
                        temp['val'] = $(this).val();
                        temp['is_checked'] = $(this).is(':checked');
                        array_temp.push(temp)
                    });
                config += Radio(array_temp);
                config += '</div>';
                var $el_copy = $el.clone();
            }else if($el.hasClass('CheckBox-btn') == true){

                var config = '<div class="row tConfig">';
                config += Required(is_required);
                config += Show_Filter(is_show_filter);
                config += label_html(label_value);
                /*config += Tooltip_html(Tooltip);
                config += Show_Tooltip(is_show_tooltip);*/
                var array_temp = [];
                $el.find('.checkbox-group input').each(function () {
                    var temp = {};
                    temp['val'] = $(this).val();
                    temp['is_checked'] = $(this).is(':checked');
                    array_temp.push(temp)
                });
                config += Radio(array_temp);
                config += '</div>';
                var $el_copy = $el.clone();
            }else if($el.hasClass('Select-btn') == true){

                var config = '<div class="row tConfig">';
                config += Required(is_required);
                config += Show_Filter(is_show_filter);
                config += label_html(label_value);
                /*config += Tooltip_html(Tooltip);
                config += Show_Tooltip(is_show_tooltip);*/
                var array_temp = [];
                $el.find('select option').each(function () {
                    var temp = {};
                    if($(this).val() != ""){
                        temp['val'] = $(this).val();
                        temp['is_checked'] = $(this).is(':selected');
                        array_temp.push(temp)
                    }
                });
                config += Radio(array_temp);
                config += '</div>';
                var $el_copy = $el.clone();
            }else if($el.hasClass('TextArea') == true){

                var input_placeholder = $el.find('.main-div textarea:eq(1)').attr('placeholder');
                var config = '<div class="row tConfig">';
                config += Required(is_required);
                config += label_html(label_value);
                config += Tooltip_html(Tooltip);
                /*config += Show_Tooltip(is_show_tooltip);
                config += Placeholder(input_placeholder);*/
                config += '</div>';
                var $el_copy = $el.clone();
            }else if($el.hasClass('DatePicker-btn') == true){

                var input_value = $el.find('.main-div input').val();
                var input_placeholder = $el.find('.main-div input').attr('placeholder');
                var input_name = $el.find('.main-div input').attr('placeholder');

                var config = '<div class="row tConfig">';
                config += Required(is_required);
                config += label_html(label_value);
                config += Tooltip_html(Tooltip);
                config += Show_Tooltip(is_show_tooltip);
                config += Placeholder(input_placeholder);
                config += '</div>';
                var $el_copy = $el.clone();
            }else if($el.hasClass('MultiSelect-btn') == true){

                var config = '<div class="row tConfig">';
                config += Required(is_required);
                config += Show_Tooltip(is_show_tooltip);
                config += Show_Filter(is_show_filter);
                config += label_html(label_value);
                /*config += Tooltip_html(Tooltip);*/

                var array_temp = [];
                $el.find('select option').each(function () {
                    var temp = {};
                    if($(this).val() != "") {
                        temp['val'] = $(this).val();
                        temp['is_checked'] = $(this).is(':selected');
                        array_temp.push(temp)
                    }
                });
                config += Radio(array_temp);
                config += '</div>';
                var $el_copy = $el.clone();
            }else if($el.hasClass('MultiSelect-tag-btn') == true){

                var config = '<div class="row tConfig">';
                config += Required(is_required);
                config += Show_Tooltip(is_show_tooltip);
                config += Show_Filter(is_show_filter);
                config += label_html(label_value);
                /*config += Tooltip_html(Tooltip);*/

                /*var array_temp = [];
                $el.find('select option').each(function () {
                    var temp = {};
                    if($(this).val() != "") {
                        temp['val'] = $(this).val();
                        temp['is_checked'] = $(this).is(':selected');
                        array_temp.push(temp)
                    }
                });
                config += Radio(array_temp);*/
                config += '</div>';
                var $el_copy = $el.clone();

            }
            var $edit_btn = $el_copy.find(".edit-link").parent().remove();
            $(".config").html(config);
            $(".modal").modal("show");

            //console.log($el.find('.main-div label .is_required').text());
            //alert($($edit_btn.html()+' .config').find("input").val());


            $(".btn-success").off().on('click',function () {

                if ($('.tConfig input[name=Label]').val()) {
                    $el.find('.main-div label').text($('.tConfig input[name=Label]').val())
                }
                if ($('.tConfig input[name=Required]').is(':checked') == true) {
                    $el.find('.main-div .is_required').text('*');
                } else {
                    $el.find('.main-div .is_required').text('');
                }
                if ($('.tConfig input[name=Tooltip]').val()) {
                    $el.find('.main-div .textarea-hidden').text($('.tConfig input[name=Tooltip]').val())
                }
                if ($('.tConfig input[name=ShowTooltip]').is(':checked') == true) {
                    $el.find('.main-div .textarea-hidden').data('is_show_tooltip','True');
                } else {
                    $el.find('.main-div .textarea-hidden').data('is_show_tooltip','False');
                }
                if ($('.tConfig input[name=ShowFilter]').is(':checked') == true) {
                    $el.find('.main-div .textarea-hidden').data('is_show_filter','True');
                } else {
                    $el.find('.main-div .textarea-hidden').data('is_show_filter','False');
                }

                if($el.hasClass('TextBox') == true || $el.hasClass('TextInputNumber') == true) {

                    if ($('.tConfig input[name=Placeholder]').val()) {
                        $el.find('.main-div input').attr('placeholder', $('.tConfig input[name=Placeholder]').val())
                    }
                    if ($('.tConfig input[name=MaxLength]').val()) {
                        $el.find('.main-div input').attr('maxlength', $('.tConfig input[name=MaxLength]').val())
                    }
                }else if($el.hasClass('Radio-btn') == true){

                    var name = $el.find('.main-div input').attr('name');
                    var html = '';
                    $('.tConfig ol input').each(function () {
                        var is_check = '';
                        if($(this).data('is_checked') == true){
                            is_check = "checked='checked'";
                        }
                        html += '<div class="radio-inline">';
                        html += '<input type="radio" '+is_check+' value="'+$(this).val()+'" class="" name="'+name+'">';
                        html += '<label>'+$(this).val()+'</label>';
                        html += '</div>';
                    });
                    $el.find('.radio-group').html(html);
                }else if($el.hasClass('CheckBox-btn') == true){

                    var name = $el.find('.main-div input').attr('name');
                    var html = '';
                    $('.tConfig ol input').each(function () {
                        var is_check = '';
                        if($(this).data('is_checked') == true){
                            is_check = "checked='checked'";
                        }
                        html += '<div class="checkbox-inline">';
                        html += '<input type="checkbox" '+is_check+' value="'+$(this).val()+'" class="" name="'+name+'">';
                        html += '<label>'+$(this).val()+'</label>';
                        html += '</div>';
                    });
                    $el.find('.checkbox-group').html(html);
                }else if($el.hasClass('Select-btn') == true){

                    var name = $el.find('.main-div input').attr('name');
                    var html = '';
                    $('.tConfig ol input').each(function () {
                        var is_check = '';
                        if($(this).data('is_checked') == true){
                            is_check = "selected='selected'";
                        }
                        html += '<option value="'+$(this).val()+'" '+is_check+'>'+$(this).val()+'</option>';
                        /*html += '<input type="checkbox" '+is_check+' value="'+$(this).val()+'" class="" name="'+name+'">';
                        html += '<label>'+$(this).val()+'</label>';
                        html += '</div>';*/
                    });
                    $el.find('select').html(html);
                }else if($el.hasClass('TextArea') == true){
                    if ($('.tConfig input[name=Placeholder]').val()) {
                        $el.find('.main-div textarea').attr('placeholder', $('.tConfig input[name=Placeholder]').val())
                    }
                }else if($el.hasClass('DatePicker-btn') == true){
                    if ($('.tConfig input[name=Placeholder]').val()) {
                        $el.find('.main-div input').attr('placeholder', $('.tConfig input[name=Placeholder]').val())
                    }
                }else if($el.hasClass('MultiSelect-btn') == true){
                    var append_id = $el.find('.main-div select').attr('id');
                    var html = '';
                    $('.tConfig ol input').each(function () {
                        var is_check = '';
                        if($(this).data('is_checked') == true){
                            is_check = "selected='selected'";
                        }
                        html += '<option value="'+$(this).val()+'" '+is_check+'>'+$(this).val()+'</option>';
                    });
                    //alert(append_id)
                    $("#"+append_id).html(html);
                    //$el.find('select').html(html);
                    var ids1 = $el.find("select").attr("id");
                    //$('#'+append_id).select2();
                }
                $(".modal").modal("hide");
            })
        });

        function goToByScroll(id){
            // Reove "link" from the ID
            id = id.replace("link", "");
            // Scroll
            $('html,body').animate({
                    scrollTop: $("#"+id).offset().top},
                'slow');
        }

        $(document).on("click", "#FromSubmit", function(ev) {
            var error = 0;


            if(error == 0){
                var data = [];
                $("#Main_div_dropzone .form-group").each(function () {
                var fiels = {};
                fiels['field_label'] = $(this).find('.main-div label:first').text().trim();
                var is_required = 'No';
                if($(this).find('.is_required').text().trim() === '*'){
                    is_required = "Yes";
                }
                fiels['is_required'] = is_required;
                fiels['field_Tooltip'] = $(this).find('textarea:first').text();
                var is_show_tooltip = "No";
                if($(this).find('textarea').data('is_show_tooltip') === 'True'){
                    is_show_tooltip = "Yes";
                }
                var is_show_filter = "No";
                if($(this).find('textarea').data('is_show_filter') === 'True'){
                    is_show_filter = "Yes";
                }
                fiels['is_show_tooltip'] = is_show_tooltip;
                fiels['is_show_filter'] = is_show_filter;
                fiels['field_placeholder'] = '';
                fiels['field_max_length'] = '';
                fiels['field_validation'] = '';
                fiels['value'] = {};
                if($(this).hasClass('TextInput') == true){
                    fiels['field_type'] = 'TextInput';
                    fiels['field_max_length'] = $(this).find('input').attr('maxlength');
                    fiels['field_placeholder'] = $(this).find('input').attr('placeholder');
                    var temp_val = {};
                    temp_val[0] = {
                        'value':$(this).find('input').val(),
                        'is_ckecked': ''
                    };
                    fiels['value'] = temp_val;
                }else if($(this).hasClass('TextInputNumber') == true){
                    fiels['field_type'] = 'TextInputNumber';
                    fiels['field_max_length'] = $(this).find('input').attr('maxlength');
                    fiels['field_placeholder'] = $(this).find('input').attr('placeholder');
                    var temp_val = {};
                    temp_val[0] = {
                        'value':$(this).find('input').val(),
                        'is_ckecked': ''
                    };
                    fiels['value'] = temp_val;
                }else if($(this).hasClass('Radio-btn') == true){
                    fiels['field_type'] = 'Radio-btn';
                    var temp_val = {};
                    $(this).find('input[type=radio]').each(function (key,val) {
                        var checked = "No";
                        if($(this).is(':checked') == true){
                            var checked = "Yes";
                        }
                        temp_val[key] = {
                            'value':$(this).val(),
                            'is_ckecked': checked
                        };
                    });
                    fiels['value'] = temp_val;
                }else if($(this).hasClass('CheckBox-btn') == true){
                    fiels['field_type'] = 'CheckBox-btn';
                    var temp_val = {};
                    $(this).find('input[type=checkbox]').each(function (key,val) {
                        var checked = "No";
                        if($(this).is(':checked') == true){
                            var checked = "Yes";
                        }
                        temp_val[key] = {
                            'value':$(this).val(),
                            'is_ckecked': checked
                        };
                    });
                    fiels['value'] = temp_val;
                }else if($(this).hasClass('Select-btn') == true){
                    fiels['field_type'] = 'Select-btn';
                    var temp_val = {};
                    $(this).find('select option').each(function (key,val) {
                        var checked = "No";
                        if($(this).is(':checked') == true){
                            var checked = "Yes";
                        }
                        if($(this).val() != ""){
                            temp_val[key] = {
                                'value':$(this).val(),
                                'is_ckecked': checked
                            }
                        }

                    });
                    fiels['value'] = temp_val;
                }else if($(this).hasClass('TextArea') == true){
                    fiels['field_type'] = 'TextArea';
                    fiels['field_placeholder'] = $(this).find('textarea:eq(1)').attr('placeholder');
                    var temp_val = {};
                    temp_val[0] = {
                        'value':$(this).find('textarea:eq(1)').val(),
                        'is_ckecked': ''
                    };
                    fiels['value'] = temp_val;
                }else if($(this).hasClass('DatePicker-btn') == true){
                    fiels['field_type'] = 'DatePicker-btn';
                    var temp_val = {};
                    temp_val[0] = {
                        'value':$(this).find('.datepicker').val(),
                        'is_ckecked': ''
                    };
                    fiels['value'] = temp_val;
                }else if($(this).hasClass('MultiSelect-btn') == true){
                    fiels['field_type'] = 'MultiSelect-btn';
                    var temp_val = {};
                    $(this).find('select option').each(function (key,val) {
                        var checked = "No";
                        if($(this).is(':checked') == true){
                            var checked = "Yes";
                        }
                        temp_val[key] = {
                            'value':$(this).val(),
                            'is_ckecked': checked
                        };
                    });
                    fiels['value'] = temp_val;
                }else if($(this).hasClass('MultiSelect-tag-btn') == true){
                    fiels['field_type'] = 'MultiSelect-tag-btn';
                    var temp_val = {};
                    var temp = $(this).find('.tg_input').tagsinput('items');
                    $.each(temp, function (key,val) {
                        /*var checked = "No";
                        if($(this).is(':checked') == true){
                            var checked = "Yes";
                        }*/
                        temp_val[key] = {
                            'value':val.text,
                            'is_ckecked': "Yes"
                        };
                    });
                    console.log(temp_val)
                    fiels['value'] = temp_val;
                }else if($(this).hasClass('FileInput') == true){
                    fiels['field_type'] = 'FileInput';
                    var temp_val = {};
                    temp_val[0] = {
                        'value':$(this).find('input').val(),
                        'is_ckecked': ''
                    };
                    fiels['value'] = temp_val;
                }
                data.push(fiels);
            });
                if(data.length == 0){
                    alert("Please drag and drop element and build the form");
                }else{
                    //console.log(data);
                    $("#json_created").html(JSON.stringify(data));
                    $("#Questionnairebtn").click();
                }
            }else {
                //$(document).scrollTo($('#Main_div_dropzone').offset().top);
                goToByScroll('Main_div_dropzone');
            }
        });
        

    })
    .directive('fileModel', ['$parse', function ($parse) {
        return {
            restrict: 'A',
            link: function(scope, element, attrs) {
                var model = $parse(attrs.fileModel);
                var modelSetter = model.assign;

                element.bind('change', function(){
                    scope.$apply(function(){
                        modelSetter(scope, element[0].files[0]);
                        scope.upload_file();
                    });
                });
            }
        };
    }]);