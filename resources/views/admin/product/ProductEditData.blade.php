
<div class="Main_div_dropzone" id="Main_div_dropzone">
        @if(isset($data) && !empty($data))
            <?php /*$data2 = json_decode($data, true);*/ ?>
            @foreach($data as $key=>$val)
                @if($val['field_type'] == 'Radio-btn')
                    <div class="col-xs-12 col-sm-6 col-md-4 form-group redio Radio-btn "  data-field_label_id="{{$val['id']}}" data-is_variant="{{$val['is_show_tooltip']}}">
                        <div  class="main-div">
                                                                <textarea style="display: none;"
                                                                          data-is_show_tooltip="<?php if($val['is_show_tooltip'] == 'Yes'){ echo 'True'; }else{ echo 'false'; } ?>" class="textarea-hidden">{{$val['field_Tooltip']}}</textarea>
                            <label for="label">{{$val['field_label']}}</label><span class="is_required asterisk red"><?php if($val['is_required'] == 'Yes'){ echo '*'; } ?></span> <?php if($val['is_show_tooltip'] == "Yes"){echo "( Variant )";} ?>
                            <div class="radio-group">
                                @foreach($val['value'] as $single)
                                <?php $selected_id = isset($single['Product_que_ans']['questionnaire_fields_values_id']) ? $single['Product_que_ans']['questionnaire_fields_values_id'] : ""; ?>
                                    <div class="radio-inline">
                                        <input type="radio" value="{{$single['value']}}"
                                               <?php if($single['is_ckecked'] == "Yes" || ($single['id'] == $selected_id)){echo "checked='checked'"; } ?>
                                               class="" name="radio-group-edit-{{$key}}-[]" data-value_id="{{$single['id']}}">
                                        <label>{{$single['value']}}</label>
                                    </div>
                                @endforeach
                            </div>
                            <small class="help-block "></small>
                        </div>
                    </div>
                @elseif($val['field_type'] == 'CheckBox-btn')
                    <div class="col-xs-12 col-sm-6 col-md-4 form-group CheckBox-btn"  data-field_label_id="{{$val['id']}}" data-is_variant="{{$val['is_show_tooltip']}}">
                        <div  class="main-div">
                                                                <textarea style="display: none;"
                                                                          data-is_show_tooltip="<?php if($val['is_show_tooltip'] == 'Yes'){ echo 'True'; }else{ echo 'false'; } ?>" class="textarea-hidden">{{$val['field_Tooltip']}}</textarea>
                            <label for="label">{{$val['field_label']}}</label><span class="is_required asterisk red"><?php if($val['is_required'] == 'Yes'){ echo '*'; } ?></span> <?php if($val['is_show_tooltip'] == "Yes"){echo "( Variant )";} ?>
                            <div class="checkbox-group">
                                @foreach($val['value'] as $single)
                                    <?php $selected_id = isset($single['Product_que_ans']['questionnaire_fields_values_id']) ? $single['Product_que_ans']['questionnaire_fields_values_id'] : ""; ?>
                                    <div class="checkbox-inline">
                                        <input type="checkbox" value="{{$single['value']}}"
                                               <?php if($single['is_ckecked'] == "Yes" || ($single['id'] == $selected_id)){echo "checked='checked'"; } ?>
                                               class="" name="checkbox-group-edit-{{$key}}-[]" data-value_id="{{$single['id']}}">
                                        <label>{{$single['value']}}</label>
                                    </div>
                                @endforeach
                            </div>
                            <small class="help-block "></small>
                        </div>
                    </div>
                @elseif($val['field_type'] == 'Select-btn')
                    <div class="col-xs-12 col-sm-6 col-md-4 form-group Select-btn "  data-field_label_id="{{$val['id']}}" data-is_variant="{{$val['is_show_tooltip']}}">
                        <div  class="main-div">
                                                                <textarea style="display: none;"
                                                                          data-is_show_tooltip="<?php if($val['is_show_tooltip'] == 'Yes'){ echo 'True'; }else{ echo 'false'; } ?>" class="textarea-hidden">{{$val['field_Tooltip']}}</textarea>
                            <label for="label">{{$val['field_label']}}</label><span class="is_required asterisk red"><?php if($val['is_required'] == 'Yes'){ echo '*'; } ?></span> <?php if($val['is_show_tooltip'] == "Yes"){echo "( Variant )";} ?>
                            <select id="select-edit-{{$key}}" name="select-edit-{{$key}}" class="form-control basic-single <?php if($val['is_show_tooltip'] == "Yes"){echo "Variant_tool";} ?>">
                                <option value=""></option>
                                @foreach($val['value'] as $single)
                                 <?php $selected_id = isset($single['Product_que_ans']['questionnaire_fields_values_id']) ? $single['Product_que_ans']['questionnaire_fields_values_id'] : ""; ?>
                                 <option value="{{$single['value']}}"
                                            <?php if($single['is_ckecked'] == "Yes" || ($single['id'] == $selected_id) ){echo "selected"; } ?> data-value_id="{{$single['id']}}">{{$single['value']}}</option>
                                @endforeach
                            </select>
                            <small class="help-block "></small>
                        </div>
                    </div>
                @elseif($val['field_type'] == 'MultiSelect-btn')
                    <div class="col-xs-12 col-sm-6 col-md-4 form-group MultiSelect-btn "  data-field_label_id="{{$val['id']}}" data-is_variant="{{$val['is_show_tooltip']}}">
                        <div class="main-div" >
                                                                <textarea class="textarea-hidden"
                                                                          data-is_show_tooltip="<?php if($val['is_show_tooltip'] == 'Yes'){ echo 'True'; }else{ echo 'false'; } ?>"
                                                                          style="display: none;">{{$val['field_Tooltip']}}</textarea>
                            <label for="label" >{{$val['field_label']}}</label><span class="is_required asterisk red"><?php if($val['is_required'] == 'Yes'){ echo '*'; } ?></span> <?php if($val['is_show_tooltip'] == "Yes"){echo "( Variant )";} ?>
                            <select id="select-edit-{{$key}}" name="multiselect-edit-{{$key}}-[]" id="multiselect-edit-{{$key}}" class="form-control Mselect2 Mselect2-edit <?php if($val['is_show_tooltip'] == "Yes"){echo "Variant_tool";} ?>" multiple>
                                <option value=""></option>
                                @foreach($val['value'] as $single)
                                    <?php $selected_id = isset($single['Product_que_ans']['questionnaire_fields_values_id']) ? $single['Product_que_ans']['questionnaire_fields_values_id'] : ""; ?>
                                    <option value="{{$single['value']}}"
                                            <?php if($single['is_ckecked'] == "Yes" || ($single['id'] == $selected_id)){echo "selected"; } ?> data-value_id="{{$single['id']}}">
                                        {{$single['value']}}
                                    </option>
                                @endforeach
                            </select>
                            <small class="help-block "></small>
                        </div>
                    </div>
                    @elseif($val['field_type'] == 'MultiSelect-tag-btn')
                        <div class="col-xs-12 col-sm-6 col-md-4  form-group MultiSelect-btn "  data-field_label_id="{{$val['id']}}" data-is_variant="{{$val['is_show_tooltip']}}">
                            <div class="main-div" >
                                            <textarea class="textarea-hidden"
                                                      data-is_show_tooltip="<?php if($val['is_show_tooltip'] == 'Yes'){ echo 'True'; }else{ echo 'false'; } ?>"
                                                      style="display: none;">{{$val['field_Tooltip']}}</textarea>
                                <label for="label" >{{$val['field_label']}}</label><span class="is_required asterisk red"><?php if($val['is_required'] == 'Yes'){ echo '*'; } ?></span> <?php if($val['is_show_tooltip'] == "Yes"){echo "( Variant )";} ?>
                                <select id="select-edit-{{$key}}" name="multiselect-edit-{{$key}}-[]" id="multiselect-edit-{{$key}}" class="form-control Mselect2 Mselect2-edit <?php if($val['is_show_tooltip'] == "Yes"){echo "Variant_tool";} ?>" multiple>
                                    <option value=""></option>
                                    @foreach($val['value'] as $single)
                                        <?php $selected_id = isset($single['Product_que_ans']['questionnaire_fields_values_id']) ? $single['Product_que_ans']['questionnaire_fields_values_id'] : ""; ?>
                                        <option value="{{$single['value']}}"
                                                <?php if($single['is_ckecked'] == "Yes" || ($single['id'] == $selected_id)){echo "selected"; } ?> data-value_id="{{$single['id']}}">
                                            {{$single['value']}}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="help-block "></small>
                            </div>
                        </div>
                @endif
            @endforeach
        @endif
    </div>


