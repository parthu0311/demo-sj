<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\validate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use App\Http\Helper;
use Mail;
use Folklore\Image\Facades\Image as Image;


use App\Questionnaire;
use App\QuestionnaireFields;
use App\QuestionnaireFieldsValues;

use App\GeneralSettings;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class AdminQuestionnaireController extends Controller {

    public function __construct() {

    }
    
   
    public function CombinationCreate(Request $request) {
        $permission = Helper::checkActionPermission('admin', 'collection-for-combinations');
        if ($permission === 0) {
            return view('error.301');
        }
        $combinations = GeneralSettings::select('questionnaire_for_combinations')->first();
        if(isset($combinations->questionnaire_for_combinations) && count(json_decode($combinations->questionnaire_for_combinations)) > 0){
            $combinations = json_decode($combinations->questionnaire_for_combinations);
        }else{
            $combinations = "";
        }
        /*echo '<pre>';
        print_r(json_decode($product->questionnaire_for_combinations));
        echo '</pre>';
        exit;*/
        return view('admin/combination/CombinationCreate')->with(['questionnaire'=>$combinations ]);
    }

    public function CombinationCreatePost(Request $request){

        $this->validate($request, [
            'combination_name' => 'required|max:255',
            'status' => 'required',
        ]);

        $UserId = $request->session()->get('userData');
        $user_id = $UserId->id;
        $assign_questions = "";
        if(isset($request->assign_questions) && !empty($request->assign_questions)){
            $assign_questions = json_encode($request->assign_questions);
        }
        $combination = DB::table('combination')->insertGetId(
            [
                'combination_name' => $request->combination_name,
                'assign_questions' => $assign_questions,
                'status' => $request->status,
                'created_date' => Helper::get_curr_datetime(),
                'created_by' => $user_id
            ]
        );

        $message = 'Collection is added.';
        return redirect('/admin/collection-type-list')->with('message', $message);
    }

    public function QuestionnaireEdit($id){
        $permission = Helper::checkActionPermission('admin', 'collection-type-edit');
        if ($permission === 0) {
            return view('error.301');
        }
        $Questionnaire = Questionnaire::with('QuesWithFields')->where('id', $id)->first();

        $data = [];
        if(isset($Questionnaire->QuesWithFields) && !empty($Questionnaire->QuesWithFields)){
            $data = $Questionnaire->QuesWithFields->toarray();
            foreach ($data as $key=>$fields){
                $values = QuestionnaireFieldsValues::where('questionnaire_fields_id',$fields['id'])->get()->toArray();
                $data[$key]['value'] = $values;
            }
        }
        /*echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit;*/
        return view('admin/questionnaire_for_combinations/QuestionnaireForCombinationsEdit')->with(
            ['data'=>$data,'Questionnaire'=>$Questionnaire ]);
    }

    public function Questionnaireview(){
        $permission = Helper::checkActionPermission('admin', 'questionnaire-type-list');
        if ($permission === 0) {
            return view('error.301');
        }
        return view('admin/questionnaire_for_combinations/QuestionnaireList');
    }

    public function questionnaireList(Request $request){
        $Products = Questionnaire::select(['id','questionnaire_type','status'])->get();

        return Datatables::of($Products)
            ->filter(function ($instance) use ($request) {

                if ($request->has('questionnaire_type')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['questionnaire_type'], $request->get('questionnaire_type')) ? true : false;
                    });
                }

                if ($request->has('status')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['status'], $request->get('status')) ? true : false;
                    });
                }
            })->make(true);
    }

    public function activeInactiveQuestionnaireStatus(Request $request){

        $permission = Helper::checkActionPermission('admin', 'activeInactivecollectionStatus');
        if ($permission === 0) {
            return view('error.301');
        }
        $id = $request->id;
        $status = $request->status;
        $mode = $request->mode;

        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'questionnaire');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here
        $ids = explode(',',$id);
        $Update_status = Questionnaire::whereIn('id', $ids)->update(['status' => $status]);


        if (count($Update_status) == 1) {
            echo count($Update_status);
        } else {
            echo 0;
        }
        exit;
    }

    public function deleteQuestionnaire(Request $request){
        $permission = Helper::checkActionPermission('admin', 'deletecollection');
        if ($permission === 0) {
            return view('error.301');
        }
        $id = $request->id;
        //Code to check if the id from the url exists in the table or not starts here.
        //If id does not exists, redirect it to 404 page.
        $id_exists = Helper::check_id_exists($id, 'questionnaire');
        if (!$id_exists)
            redirect_404();
        //Code to check id ends here


        $ids = explode(',',$id);
        $del_user = Questionnaire::whereIn('id', $ids)->delete();

        if ($del_user) {
            echo '1';
        } else {
            echo '0';
        }
        exit;
    }

    public function GetQuestionnaireForCombinations(Request $request){
        $permission = Helper::checkActionPermission('admin', 'collection-type-list');
        if ($permission === 0) {
            return view('error.301');
        }
        //$questionnaire_for_combinations = GeneralSettings::select('questionnaire_for_combinations')->get()->toArray();
        /*echo '<pre>';
        print_r($general_set_of_questions);
        echo '</pre>';
        exit;*/
        $questionnaire_for_combinations = [];
        return view('admin/questionnaire_for_combinations/QuestionnaireForCombinations', ['data' => $questionnaire_for_combinations]);
    }

    public function QuestionnaireForCombinations(Request $request,$id =""){
        if($id == ""){
            $all_data = $request->json;

            $this->validate($request, [
                'questionnaire_type' => 'required|max:255',
                'status' => 'required',
            ]);

            $UserId = $request->session()->get('userData');
            $user_id = $UserId->id;

            $Questionnaire = new Questionnaire();
            $Questionnaire->questionnaire_type = $request->questionnaire_type;
            $Questionnaire->data = $all_data;
            $Questionnaire->status = $request->status;
            $Questionnaire->created_date = Helper::get_curr_datetime();
            $Questionnaire->created_by = $user_id;
            $Questionnaire->save();

            foreach (json_decode($all_data) as $key=>$data){

                $QuestionnaireFields = new QuestionnaireFields();
                $QuestionnaireFields->questionnaire_id = $Questionnaire->id;
                $QuestionnaireFields->field_type = $data->field_type;
                $QuestionnaireFields->field_label = $data->field_label;
                $QuestionnaireFields->is_required = $data->is_required;
                $QuestionnaireFields->field_Tooltip = $data->field_Tooltip;
                $QuestionnaireFields->is_show_filter = $data->is_show_filter;
                $QuestionnaireFields->is_show_tooltip = $data->is_show_tooltip;
                $QuestionnaireFields->field_max_length = empty($data->field_max_length)? 0 : $data->field_max_length;
                $QuestionnaireFields->field_placeholder = $data->field_placeholder;
                $QuestionnaireFields->field_validation = $data->field_validation;
                $QuestionnaireFields->status = 'Active';
                $QuestionnaireFields->created_date = Helper::get_curr_datetime();
                $QuestionnaireFields->created_by = $user_id;
                $QuestionnaireFields->save();

                if( isset($data->value) && !empty($data->value) ){
                    foreach ($data->value as $single){
                        $QuestionnaireFieldsValues = new QuestionnaireFieldsValues();
                        $QuestionnaireFieldsValues->questionnaire_id = $Questionnaire->id;
                        $QuestionnaireFieldsValues->questionnaire_fields_id = $QuestionnaireFields->id;
                        $QuestionnaireFieldsValues->value = $single->value;
                        $QuestionnaireFieldsValues->is_ckecked = $single->is_ckecked;
                        $QuestionnaireFieldsValues->created_date = Helper::get_curr_datetime();
                        $QuestionnaireFieldsValues->created_by = $user_id;
                        $QuestionnaireFieldsValues->save();
                    }
                }

            }

            $message = 'Collection is added.';
            return redirect('/admin/collection-type-list')->with('message', $message);
        }else{

            $this->validate($request, [
                'questionnaire_type' => 'required|max:255',
                'status' => 'required',
            ]);

            $UserId = $request->session()->get('userData');
            $user_id = $UserId->id;

            $Questionnaire = Questionnaire::where('id', '=', $id)->update(
                [
                    'questionnaire_type' => $request->questionnaire_type,
                    'data' => "",
                    'status' => $request->status,
                    'updated_date' => Helper::get_curr_datetime(),
                    'updated_by' => $user_id
                ]
            );
            $temp_field_ids = [];
            $temp_field_value_ids = [];
            if(isset($request->json) && !empty($request->json)){
                $all_data = json_decode($request->json);
                foreach ($all_data as $data){
                    if(isset($data->field_label_id) && !empty($data->field_label_id)){
                        $QuestionnaireFields = QuestionnaireFields::find($data->field_label_id);
                        $QuestionnaireFields->questionnaire_id = $id;
                        $QuestionnaireFields->field_type = $data->field_type;
                        $QuestionnaireFields->field_label = $data->field_label;
                        $QuestionnaireFields->is_required = $data->is_required;
                        $QuestionnaireFields->field_Tooltip = $data->field_Tooltip;
                        $QuestionnaireFields->is_show_filter = $data->is_show_filter;
                        $QuestionnaireFields->is_show_tooltip = $data->is_show_tooltip;
                        $QuestionnaireFields->field_max_length = empty($data->field_max_length)? 0 : $data->field_max_length;
                        $QuestionnaireFields->field_placeholder = $data->field_placeholder;
                        $QuestionnaireFields->field_validation = $data->field_validation;
                        $QuestionnaireFields->status = 'Active';
                        $QuestionnaireFields->updated_date = Helper::get_curr_datetime();
                        $QuestionnaireFields->updated_by = $user_id;
                        $QuestionnaireFields->save();
                    }else{
                        $QuestionnaireFields = new QuestionnaireFields();
                        $QuestionnaireFields->questionnaire_id = $id;
                        $QuestionnaireFields->field_type = $data->field_type;
                        $QuestionnaireFields->field_label = $data->field_label;
                        $QuestionnaireFields->is_required = $data->is_required;
                        $QuestionnaireFields->field_Tooltip = $data->field_Tooltip;
                        $QuestionnaireFields->is_show_filter = $data->is_show_filter;
                        $QuestionnaireFields->is_show_tooltip = $data->is_show_tooltip;
                        $QuestionnaireFields->field_max_length = empty($data->field_max_length)? 0 : $data->field_max_length;
                        $QuestionnaireFields->field_placeholder = $data->field_placeholder;
                        $QuestionnaireFields->field_validation = $data->field_validation;
                        $QuestionnaireFields->status = 'Active';
                        $QuestionnaireFields->created_date = Helper::get_curr_datetime();
                        $QuestionnaireFields->created_by = $user_id;
                        $QuestionnaireFields->save();
                    }
                    array_push($temp_field_ids,$QuestionnaireFields->id);
                    if( isset($data->value) && !empty($data->value) ){
                        foreach ($data->value as $single){
                            if(isset($single->value_id) && !empty($single->value_id)){
                                $QuestionnaireFieldsValues = QuestionnaireFieldsValues::find($single->value_id);
                                $QuestionnaireFieldsValues->questionnaire_id = $id;
                                $QuestionnaireFieldsValues->questionnaire_fields_id = $QuestionnaireFields->id;
                                $QuestionnaireFieldsValues->value = $single->value;
                                $QuestionnaireFieldsValues->is_ckecked = $single->is_ckecked;
                                $QuestionnaireFieldsValues->updated_date = Helper::get_curr_datetime();
                                $QuestionnaireFieldsValues->updated_by = $user_id;
                                $QuestionnaireFieldsValues->save();
                            }else{
                                $QuestionnaireFieldsValues = new QuestionnaireFieldsValues();
                                $QuestionnaireFieldsValues->questionnaire_id = $id;
                                $QuestionnaireFieldsValues->questionnaire_fields_id = $QuestionnaireFields->id;
                                $QuestionnaireFieldsValues->value = $single->value;
                                $QuestionnaireFieldsValues->is_ckecked = $single->is_ckecked;
                                $QuestionnaireFieldsValues->created_date = Helper::get_curr_datetime();
                                $QuestionnaireFieldsValues->created_by = $user_id;
                                $QuestionnaireFieldsValues->save();
                            }
                            array_push($temp_field_value_ids,$QuestionnaireFieldsValues->id);
                        }
                    }
                }
            }
            if(count($temp_field_ids) >0 ){
                $QuestionnaireFields = QuestionnaireFields::where('questionnaire_id',$id)->whereNotIn('id', $temp_field_ids)->get();
                if(count($QuestionnaireFields)>0){
                    $temp_id_q = [];
                    foreach ($QuestionnaireFields as $v){
                        array_push($temp_id_q,$v->id);
                    }
                    if(count($temp_id_q) > 0){
                        QuestionnaireFields::whereIn('id', $temp_id_q)->delete();
                    }
                }
            }

            if(count($temp_field_value_ids) >0){
                $QuestionnaireFieldsValues = QuestionnaireFieldsValues::where('questionnaire_id',$id)->whereNotIn('id', $temp_field_value_ids)->get();
                if(count($QuestionnaireFieldsValues)>0){
                  $temp_id = [];
                  foreach ($QuestionnaireFieldsValues as $v){
                    array_push($temp_id,$v->id);
                  }
                  if(count($temp_id) > 0){
                      QuestionnaireFieldsValues::whereIn('id', $temp_id)->delete();
                  }
                }
            }

            $message = 'Collection is Updated.';
            return redirect('/admin/collection-type-list')->with('message', $message);
        }


    }


}
