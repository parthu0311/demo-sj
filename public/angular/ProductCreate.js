'use strict';
angular.module('app')
    .controller('ProdctCreateController', function($rootScope,$scope,$location,$resource,$timeout,$http,$compile, ApiService, ApiEndpoint) {
        $scope.image_array = [];
        $scope.MRP = 0;
        $rootScope.main_product_images = [];

        function goToByScroll(id){
            // Reove "link" from the ID
            id = id.replace("link", "");
            // Scroll
            $('html,body').animate({
                    scrollTop: $("#"+id).offset().top},
                'slow');
        };


        $(document).on("click", "#FromSubmit", function(ev) {
            var error = 0;
            if($("#collection_id").val() != "") {

                $("#Main_div_dropzone .form-group").each(function () {

                    if ($(this).find('.is_required').text().trim() === '*') {
                        if ($(this).hasClass('CheckBox-btn') == true) {
                            if ($('.checkbox-group input').is(":checked") == false) {
                                error++;
                                $(this).find('.help-block').html("This is required field.");
                                $(this).addClass('has-feedback has-error')
                            } else {
                                $(this).find('.help-block').html("")
                            }

                        } else if ($(this).hasClass('Select-btn') == true) {
                            if ($(this).find('select').val() == null || $(this).find('select').val() == "") {
                                error++;
                                $(this).find('.help-block').html("This is required field.");
                                $(this).addClass('has-feedback has-error')
                            } else {
                                $(this).find('.help-block').html("")
                            }
                        } else if ($(this).hasClass('TextArea') == true) {
                            if ($(this).find('textarea:eq(1)').val() == '') {
                                error++;
                                $(this).find('.help-block').html("This is required field.");
                                $(this).addClass('has-feedback has-error')
                            } else {
                                $(this).find('.help-block').html("")
                            }
                        } else if ($(this).hasClass('DatePicker-btn') == true) {
                            if ($(this).find('input').val() == '') {
                                error++;
                                $(this).find('.help-block').html("This is required field.");
                                $(this).addClass('has-feedback has-error')
                            } else {
                                $(this).find('.help-block').html("")
                            }
                        } else if ($(this).hasClass('MultiSelect-btn') == true) {
                            if ($(this).find('select').val() == null || $(this).find('select').val() == "") {
                                error++;
                                $(this).find('.help-block').html("This is required field.");
                                $(this).addClass('has-feedback has-error')
                            } else {
                                $(this).find('.help-block').html("")
                            }
                        }
                    } else {
                        $(this).find('.help-block').html("");
                    }

                    /*$('table .tr').each(function (k,v) {
                        if($(this).find('input[name=SKU]').val() == ""){
                            error++;
                            $(this).find('.SKU').html("This is required field.");
                            $(this).find('.SKU').closest('div').addClass('has-feedback has-error');
                        }else {
                            $(this).find('.SKU').html("");
                            $(this).find('.SKU').closest('div').removeClass('has-feedback has-error');
                        }
                        if($(this).find('input[name=Surcharge]').val() == ""){
                            error++;
                            $(this).find('.Surcharge').html("This is required field.");
                            $(this).find('.Surcharge').closest('div').addClass('has-feedback has-error');
                        }else {
                            $(this).find('.Surcharge').html("");
                            $(this).find('.Surcharge').closest('div').removeClass('has-feedback has-error')
                        }
                        if($(this).find('input[name=Weight]').val() == ""){
                            error++;
                            $(this).find('.Weight').html("This is required field.");
                            $(this).find('.Weight').closest('div').addClass('has-feedback has-error');
                        }else {
                            $(this).find('.Weight').html("");
                            $(this).find('.Weight').closest('div').removeClass('has-feedback has-error')
                        }
                        if($(this).find('select[name=Inventory]').val() == ""){
                            error++;
                            $(this).find('.Inventory').html("This is required field.");
                            $(this).find('.Inventory').closest('div').addClass('has-feedback has-error');
                        }else {
                            $(this).find('.Inventory').html("");
                            $(this).find('.Inventory').closest('div').removeClass('has-feedback has-error')
                        }
                        /!*temp_obj['sku'] = ;
                        temp_obj['Price'] = $scope.MRP;
                        temp_obj['surcharge'] = $(this).find('input[name=Surcharge]').val();
                        temp_obj['weight'] = $(this).find('input[name=Weight]').val();
                        temp_obj['inventory'] = $(this).find('select[name=Inventory]').val();
                        temp_obj['status'] = $(this).find('input[name=options]').val();
                        table_arr.push(temp_obj);*!/
                    });*/
                });

                if (error == 0) {
                    var data = [];
                    $("#Main_div_dropzone .form-group").each(function (k, v) {
                        var fiels = {};
                        var field_label_id = $(this).data('field_label_id');
                        /*fiels[k] = [];*/

                        if ($(this).hasClass('Radio-btn') == true) {
                            var temp_val = {};
                            $(this).find('input[type=radio]').each(function (key, val) {
                                if ($(this).is(':checked') == true) {
                                    temp_val[key] = {
                                        'field_label_id': field_label_id,
                                        'value_id': $(this).data('value_id')
                                    };
                                }

                            });
                            fiels = temp_val;
                        } else if ($(this).hasClass('CheckBox-btn') == true) {
                            var temp_val = {};
                            var c = 0;
                            $(this).find('input[type=checkbox]').each(function (key, val) {
                                if ($(this).is(':checked') == true) {
                                    temp_val[c] = {
                                        'field_label_id': field_label_id,
                                        'value_id': $(this).data('value_id')
                                    };
                                    c++;
                                }
                            });
                            fiels = temp_val;
                        } else if ($(this).hasClass('Select-btn') == true) {
                            var temp_val = {};
                            var s = 0;
                            $(this).find('select option').each(function (key, val) {
                                if ($(this).is(':checked') == true) {
                                    temp_val[s] = {
                                        'field_label_id': field_label_id,
                                        'value_id': $(this).data('value_id')
                                    };
                                    s++;
                                }
                            });
                            fiels = temp_val;
                        } else if ($(this).hasClass('MultiSelect-btn') == true) {
                            var temp_val = {};
                            var sm = 0;
                            $(this).find('select option').each(function (key, val) {
                                if ($(this).is(':checked') == true) {
                                    temp_val[sm] = {
                                        'field_label_id': field_label_id,
                                        'value_id': $(this).data('value_id')
                                    };
                                    sm++;
                                }
                            });
                            fiels = temp_val;
                        }
                        data.push(fiels);
                    });
                    if (data.length == 0) {
                        alert("Please select category and Category Type");
                    } else {
                        //console.log(data);
                        var table_arr = [];
                        $('table .tr').each(function (k,v) {
                            var temp_obj = {};
                            temp_obj['combination'] = $(this).find('td:first').text();
                            temp_obj['sku'] = $(this).find('input[name=SKU]').val();
                            /*temp_obj['Price'] = $scope.MRP;*/
                            temp_obj['price'] = $(this).find('input[name=Price]').val();
                            temp_obj['weight'] = $(this).find('input[name=Weight]').val();
                            temp_obj['inventory'] = $(this).find('select[name=Inventory]').val();
                            temp_obj['status'] = $(this).find('input[name=options]').val();
                            temp_obj['images'] = $(this).find('textarea').val();
                            table_arr.push(temp_obj);
                        });
                        $("#json_created").html(JSON.stringify(data));
                        $("#json_created_variant").html(JSON.stringify(table_arr));
                        $("#main_pro_images").html(JSON.stringify($rootScope.main_product_images));
                        if(table_arr.length > 0){
                            $("#FromSubmitbtn").click();
                        }else {
                            alert("You can't able to add product without variant");
                        }

                    }
                } else {
                    //$(document).scrollTo($('#Main_div_dropzone').offset().top);
                    goToByScroll('form_scroll');
                }
            }else {
                $("#FromSubmitbtn").click();
            }
        });

        function variant_val_data() {
            var r = [], arg = arguments[0], max = arg.length - 1;
            //console.log(arg)
            function helper(arr, i) {
                for (var j=0, l=arg[i].length; j<l; j++) {
                    var a = arr.slice(0);
                    a.push(arg[i][j]);
                    console.log("hi"+a);
                    if (i==max){
                        r.push(a);
                    } else {
                        helper(a, i+1);
                    }
                }
            }
            helper([],0);
            return r;
        }

        $scope.variant_count = 0;
        $scope.variant_val_arr = [];
        $rootScope.variant_combination = "";
        $("#category_type_id").change(function () {
            $scope.variant_count = 0;
            $scope.variant_val_arr = [];
            $rootScope.variant_combination = "";
            if($("#category_type_id").find('option:checked').data('filter_id') != null){
                var get_questionnaire_by_id = {
                    questionnaire_type : $(this).find('option:checked').data('filter_id')
                };
                ApiService.postModel(ApiEndpoint.Models.get_questionnaire_by_id, get_questionnaire_by_id).then(function (response) {
                    if (response.SUCCESS == "FALSE") {
                        console.log(response);
                    } else {
                        if(response.html != ""){
                            $("#render_data").html(
                                $compile(response.html)($scope)
                            );
                            $('.basic-single').select2({
                                placeholder: 'Select an option',
                                allowClear: true
                            });
                            $('.Mselect2-edit').select2({
                                placeholder: 'Select an option'
                            });
                            /*var cities = new Bloodhound({
                                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
                                queryTokenizer: Bloodhound.tokenizers.whitespace,
                                prefetch: '../plugins/bootstrap-tagsinput-latest/examples/assets/cities.json'
                            });
                            cities.initialize();*/
                            $("#Main_div_dropzone .form-group").each(function () {
                                if($(this).data('is_variant')== "Yes"){
                                    $scope.variant_count++;
                                    var temp_val = [];
                                    $(this).find('select option').each(function (key, val) {
                                        if ($(this).is(':checked') == true && $(this).val() != "") {
                                            temp_val.push($(this).data('value_id') + "-" + $(this).val());
                                        }
                                    });
                                    if(temp_val.length > 0){
                                        $scope.variant_val_arr.push(temp_val);
                                    }
                                }
                            });
                            $rootScope.variant_combination  = variant_val_data($scope.variant_val_arr);
                            ///console.log($scope.variant_val_arr)
                        }
                    }
                }).then(function () {

                });
            }else {
                alert("This category type dose not have filter, Please assign to category section.")
                $("#render_data").html("");
                $rootScope.variant_combination = [];
                $rootScope.$apply();
            }
        });
        

        $("#collection_id").change(function () {
            if($(this).val() != ""){
                var get_questionnaire_by_id = {
                    questionnaire_type : $(this).val()
                };
                ApiService.postModel(ApiEndpoint.Models.get_questionnaire_by_id, get_questionnaire_by_id).then(function (response) {
                    if (response.SUCCESS == "FALSE") {
                        console.log(response);
                    } else {
                        if(response.html != ""){
                            $("#render_data").html(
                                $compile(response.html)($scope)
                            );
                            $('.basic-single').select2({
                                placeholder: 'Select an option',
                                allowClear: true
                            });
                            $('.Mselect2-edit').select2({
                                placeholder: 'Select an option'
                            });
                        }
                    }
                }).then(function () {

                });
            }else {
                $("#render_data").html("");
            }
        });

        $(document).on("change",".Variant_tool",function () {
            $scope.variant_count = 0;
            $scope.variant_val_arr = [];
            $rootScope.variant_combination = "";
            $("#Main_div_dropzone .form-group").each(function () {
                if($(this).data('is_variant')== "Yes"){
                    $scope.variant_count++;
                    var temp_val = [];
                    var count__ = 0;
                    $(this).find('select option').each(function (key, val) {
                        if ($(this).is(':checked') == true && $(this).val() != "") {
                            temp_val.push($(this).data('value_id') + "-" + $(this).val());
                            count__++;
                        }
                    });
                    //console.log(temp_val)
                    if(count__ > 0){
                        $scope.variant_val_arr.push(temp_val);
                    }
                }
            });
            if($scope.variant_val_arr.length >0 ){
                $rootScope.variant_combination = variant_val_data($scope.variant_val_arr);
                $rootScope.$apply();
            }else {
                $rootScope.variant_combination = [];
                $rootScope.$apply();
            }

            console.log($rootScope.variant_combination)
        });
        
        /*$(document).on("change",".Surcharge",function () {
            //alert("hi")
            var index = $(this).data("index");
            console.log($(this).val())
            $(this).parent('tr').find('#mrp_tr_'+index).html(parseInt($scope.MRP)+parseInt($(this).val()));
        });*/

        $("#btn_main_img").click(function() {
            $('.cropped_image').attr("data-cropped","1");
            $("#modal-img-crop").modal("show");
        });

        $('.cropped_image').on('click', function (ev) {
            //alert();
            $image_crop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (response) {
                if($("#images").val()){
                    $("#load").css("display","block");
                    //alert($('.cropped_image').data('cropped'))
                    if($(this).data('cropped') == 1){
                        $scope.upload_file_for_product(response);
                    }else{
                        $scope.upload_file(response)
                    }
                   /*$.ajax({
                    url: "/admin/upload_image_of_product_main_base64",
                    type: "POST",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    data: {"image":response},
                    success: function (response) {
                        var data = JSON.parse(response);
                        console.log(data);
                       if(data.code == 200){
                        $scope.$watch(function() {
                            $scope.main_product_images.push(data.url);
                        })
                            
                        $("#images").val("");
                        }else {
                            alert("Sorry, Image is not upload, Please try again");
                        }
                            $("#load").css("display","none");

                        }
                });*/
                }
                
            });
        });

        $scope.upload_file_for_product = function (response) {
            //var file = $scope.myFile2;
            //alert(file);

            //if($scope.myFile2 && ($scope.myFile2.type == "image/jpeg" || $scope.myFile2.type == "image/png")) {
            //    var file = $scope.myFile2;
            //}else{
             //   var file = undefined;
            //}
            if(response){
                $("#load").css("display","block");
                //console.log(file);
                var fd = new FormData();
                fd.append('image', response);

                var uploadUrl = "upload_image_of_product_main_base64";
                $http.post(uploadUrl, fd, {
                    transformRequest: angular.identity,
                    headers: {'Content-Type': undefined,'Process-Data': false}
                }).then(function (response) {
                    console.log(response)
                    if(response.data.code == 200){
                        /*$scope.image_array.push(response.data.name);*/
                        $rootScope.main_product_images.push(response.data.url);
                        $("#images").val("");
                        $('#modal-img-crop').modal('hide');
                        //$("input[name=myFile2]").val("");
                    }else {
                        alert("Sorry, Image is not upload, Please try again");
                    }
                    $("#load").css("display","none");
                })
            }else {
                alert("Invalid file selected");
            }
        };
        $scope.remove_img_main = function(img){
            $rootScope.main_product_images.splice($.inArray(img, $rootScope.main_product_images),1);
            //$rootScope.$apply();
        };


        $rootScope.image_data_modal = [];
        $(document).on("click","#open_modal",function () {
            //alert('hii')
            $('.cropped_image').attr("data-cropped","0");
            $rootScope.image_data_modal = [];
            $rootScope.$apply();
            var id_area = $(this).data('id_area');
            if($("#image_arr_"+id_area).val() != "" && $("#image_arr_"+id_area).val() != undefined){
                $rootScope.image_data_modal = JSON.parse($("#image_arr_"+id_area).val());
                $rootScope.$apply();
            }

            $("#modal-default").modal("show");
            $scope.upload_file = function(response){
                //var file = $scope.myFile;
                //alert(file);

                // if($scope.myFile && ($scope.myFile.type == "image/jpeg" || $scope.myFile.type == "image/png")) {
                //     var file = $scope.myFile;
                // }else{
                //     var file = undefined;
                // }
                if(response){
                    $("#load").css("display","block");
                    //console.log(file);
                    var fd = new FormData();
                    fd.append('image', response);

                    var uploadUrl = "upload_image_of_product_base64";
                    $http.post(uploadUrl, fd, {
                        transformRequest: angular.identity,
                        headers: {'Content-Type': undefined,'Process-Data': false}
                    }).then(function (response) {
                        if(response.data.code == 200){
                            /*$scope.image_array.push(response.data.name);*/
                            $rootScope.image_data_modal.push(response.data.url);
                            $("#image_arr_"+id_area).val(JSON.stringify($rootScope.image_data_modal));
                            //console.log(id_area)
                            //$("input[name=file]").val("");
                            $("#images").val("");
                            $('#modal-img-crop').modal('hide');
                        }else {
                            alert("Sorry, Image is not upload, Please try again");
                        }
                        $("#load").css("display","none");
                    })
                }else {
                    alert("Invalid file selected");
                }

            };
            $scope.remove_img = function(img){
                $rootScope.image_data_modal.splice($.inArray(img, $rootScope.image_data_modal),1);
                /*$rootScope.$apply();*/
            }
        });


        $(document).on('click','.delete_image',function () {
            //console.log($scope.image_array);
            var name = $(this).data('name');
            $scope.image_array.splice($.inArray(name, $scope.image_array),1);
            //console.log($scope.image_array);
            $(this).parent().parent().remove();
        });

        $rootScope.delete_pro_image = function(name) {
            //alert(name);
            /*var itemtoRemove = "HTML";
             arr.splice($.inArray(itemtoRemove, arr),1);*/

            $(ev).parent().parent().remove();
        };
        var cities = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '../plugins/bootstrap-tagsinput-latest/examples/assets/cities.json'
        });
        cities.initialize();
        $scope.add_variant = function () {
            var html = "";
                html += '<div class="row box-body" style="border: 1px solid #e1e1e1; margin: 25px">';
                html += '<div class="col-xs-12 col-sm-6 col-md-4">';
                html += '<div class="form-group">';
                html += '<label>Option Name <span class="asterisk red">*</span></label>';
                html += '<input class="form-control" placeholder="Option Name" type="text" name="option_name">';
                html += '</div>';
                html += '</div>';
                html += '<div style="clear:both"></div>';
                html += '<div class="col-xs-12 col-sm-6 col-md-8">';
                html += '<div class="form-group">';
                html += '<label>Option Choices <span class="asterisk red">*</span></label>';
                //html += '<input type="text" id="tag" placeholder="Add colors, pressing 'Enter between each one"/>';
                html += '<div id="dyna_fields">';
                html += '<select multiple data-role="tagsinput" id="select_tag" placeholder="Add option choices, pressing \'Enter\' between each one"></select>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '<div class="col-xs-12 col-sm-6 col-md-4">';
                html += '<div class="form-group">';
                html += '<label>Display as</label><br>';
                html += '<div class="btn-group btn-toggle" data-toggle="buttons">';
                html += '<label class="btn btn-primary btn-sm active" ng-click="change_tag(\'list\')">';
                html += '<input type="radio" name="options" value="list" > List';
                html += '</label>';
                html += '<label class="btn btn-sm btn-default" ng-click="change_tag(\'color\')">';
                html += '<input type="radio" name="options" value="color" checked="" > Color';
                html += '</label>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            $("#render_data_variant").append(
                $compile(html)($scope)
            );
            $('#select_tag').tagsinput();
        };
        $scope.change_tag = function(text){
            //alert(text)
            var html_field = "";
            if(text == "list"){
                html_field = '<select multiple data-role="tagsinput" id="select_tag" placeholder="Add option choices, pressing \'Enter\' between each one"></select>';
                $("#dyna_fields").html(
                    $compile(html_field)($scope)
                );
            }else {
                html_field = '<input type="text" id="tag" placeholder="Add colors, pressing \'Enter between each one"/>';
                $("#dyna_fields").html(
                    $compile(html_field)($scope)
                );
            }
            $('#select_tag').tagsinput();
            var elt = $('#tag');
            elt.tagsinput({
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
        };

        $(".image-checkbox").each(function () {
            if ($(this).find('input[type="checkbox"]').first().attr("checked")) {
                $(this).addClass('image-checkbox-checked');
            }
            else {
                $(this).removeClass('image-checkbox-checked');
            }
        });

        // sync the state to the input
        $(document).on("click",".image-checkbox", function (e) {
            $(this).toggleClass('image-checkbox-checked');
            var $checkbox = $(this).find('input[type="checkbox"]');
            $checkbox.prop("checked",!$checkbox.prop("checked"));

            e.preventDefault();
        });
        /*$rootScope.image_combination = [];
        $scope.image_generation = function () {
            var temp_img = [];
            $(".image-checkbox").each(function () {
                if ($(this).find('input[type="checkbox"]').is(':checked') == true) {
                    temp_img.push($(this).find('input[type="checkbox"]').val());
                }
            });
            $rootScope.image_combination.push(temp_img);
            console.log($rootScope.image_combination)
        };*/

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
                        //scope.upload_file();
                    });
                });
            }
        };
    }]);
