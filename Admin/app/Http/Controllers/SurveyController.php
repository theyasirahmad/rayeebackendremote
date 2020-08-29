<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Survey;
use App\Models\SurveyPublish;
use App\Models\SurveyCategory;
use App\Models\SurveySubCategory;
use App\Models\Costing;
use App\Models\SurveyQuestion;
use App\Models\SurveyAnswer;
use App\Models\children_group;
use App\Models\children_household;
use App\Models\education;
use App\Models\house_hold_sub_category;
use App\Models\occupation;
use App\Models\role_purchasing;
use App\Models\Cities;
use App\Models\SurveyPublishCities;
use \Developifynet\Telenor\TelenorSMS;
use OneSignal;
use Crypt;
use Validator;
use Auth;
use Storage;
use File;
use Session;

class SurveyController extends Controller
{
    public function surveyCategory(){

        if(request()->ajax()){

            $survey = SurveyCategory::get();
            return datatables()->of($survey)
                    ->addColumn('title', function($data){
                        return $data->title;
                    })
                    ->addColumn('discription', function($data){
                        return $data->discription;
                    })
                    ->make(true);

        }

        return view('Admin.survey-category');
    }

    public function surveyCategoryPost(Request $req){
       $req->validate([
           'name' => 'required',
           'discription' => 'required'
       ]);

        if(SurveyCategory::where('title',$req->name)->exists()){
            return 2;
        }
        else{
        $sur = new SurveyCategory();
        $sur->title = $req->name;
        $sur->discription = $req->discription;
        $sur->user = Auth::id();
        if($sur->save()){
            return 1;
        }
        }
    }

    public function surveySubCategory(){
        
        if(request()->ajax()){

            $survey = SurveySubCategory::with(['mainCategory'])->get();
            return datatables()->of($survey)
                    ->addColumn('title', function($data){
                        return $data->title;
                    })
                    ->addColumn('mainCategory', function($data){
                        return $data->mainCategory->title;
                    })
                    ->make(true);

        }
        $sur = SurveyCategory::get();

        return view('Admin.survey-sub-category', ['category' => $sur]);
    }

    public function surveySubCategoryPost(Request $req){
        $req->validate([
            'name' => 'required',
            'mainCategory' => 'required'
        ]);

        if(SurveySubCategory::where('title',$req->name)->exists()){
            return 2;
        }
        else{
        $sur = new SurveySubCategory();
        $sur->title = $req->name;
        $sur->main_category = $req->mainCategory;
        $sur->user = Auth::id();
        if($sur->save()){
            return 1;
        }
        }

    }

    public function Survey(Request $req, $id = null){

        if($id){
          $survey = SurveySubCategory::where('main_category',$id)->get();
          return response()->json(['data' => $survey], 200);
        }
        if(request()->ajax()){

            $survey = Survey::with(['category','subCategory','costing'])->get();
            return datatables()->of($survey)
                    ->addColumn('action', function($data){
                    $v = '';
                    $s = $data->publish == 0 ? "btn-success" : "btn-danger";
                    $que = url('').'/admin/survey-questions/'.Crypt::encrypt($data->id);
                    $url = url('').'/admin/survey-details/'.Crypt::encrypt($data->id);
                    $btn = $data->publish == 0 ? "Publish" : "Hold";
                    $button = '<button type="button" data-id="'.$data->id.'" publish-data="'.$data->publish.'" class="publish btn '.$s.' btnSm">'.$btn.'</button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="'.$url.'" data-id="'.$data->id.'" class="btn btnSm btn-primary">Survey Details</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="'.$que.'" class="btn btnSm btn-info">Questions</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="'.$v.'" name="edit" data-id="'.$data->id.'" class="editUser btn btn-default icon-pencil7"></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="del" data-id="'.$data->id.'" class="deleteUser btn btn-default icon-trash"></button>';
                    return $button;
                    })
                    ->addColumn('title', function($data){
                        return $data->title;
                    })
                    ->addColumn('category', function($data){
                        return $data->category->title;
                    })
                    ->addColumn('subCategory', function($data){
                        return $data->subCategory->title;
                    })
                    ->addColumn('costing', function($data){
                        return 'Rs'.$data->costing->price;
                    })
                    ->addColumn('status', function($data){
                        return $data->publish === 0 ? 'Not Publish' : 'Publish';
                    })
                    // ->addColumn('discription', function($data){
                    //     return $data->discription;
                    // })
                    ->make(true);

        }
        $sur = SurveyCategory::get();
        $cost = Costing::get();
        return view('Admin.survey', ['category' => $sur,
        'costing' => $cost,
        'education' => education::get(),
        'occupation' => occupation::get(),
        'childrenGroup' => children_group::get(),
        'childrenHousehold' => children_household::get(),
        'childrenHouseholdCategory' => house_hold_sub_category::get(),
        'purchasingRole' => role_purchasing::get(),
        'cities' => Cities::get(),
        ]);
    }

    public function surveyDetails($id){
        $id = Crypt::decrypt($id);
        $survey = Survey::with(['category','subCategory','costing'])->where('id',$id)->first();

        $qs = SurveyQuestion::where('survey',$id)->get();
        $an = SurveyAnswer::get();
        $arr = array();
        foreach ($qs as $q) {
            $ans = SurveyAnswer::where('questionID',$q->id)->get();
            $ar = array(
                'id' => $q->id,
                'question' => $q->question,
                'questionType' => $q->questionType,
                'content' => $q->content,
                'status' => $q->status,
                'answers' => $ans
            );
            array_push($arr,$ar);
        }


        return view('Admin.survey-details',['survey'=>$survey,'question'=>$arr]);
    }

    public function surveyPost(Request $req){
        $req->validate([
            'title' => 'required',
            'category' => 'required',
            'subCategory' => 'required',
            'cost' => 'required',
            'avgTime' => 'required',
            'totalTime' => 'required',
            'discription' => 'required',
        ]);
        $filename = '';

        if($req->hasfile('file')){
            $file = $req->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = $file->getFilename();
            $filename = md5(rand()).'.'.$extension;
            $file->move('public/storage/surveyImage/', $filename);
        }

        if(Survey::where('title',$req->title)->exists()){
            return 2;
        }
        else{
        $res = new Survey();
        $res->title = $req->title;
        $res->discription = $req->discription;
        $res->image = $filename;
        $res->main_category = $req->category;
        $res->sub_category = $req->subCategory;
        $res->cost = $req->cost;
        $res->total_time = $req->totalTime;
        $res->avg_time = $req->avgTime;
        $res->user = Auth::id();
        if($res->save()){
            return 1;
        }
    }
    }

    public function publishSurvey(Request $req, $id = null){
        
        if(!$id){
        $req->validate([
            'survey' => 'required',
            'expiry' => 'required',
            'notificationMsg' => 'required',
        ]);

        $pub = new SurveyPublish();
        $pub->publish_to = $req->publish;
        $pub->publish_date = date("Y-m-d");
        $pub->expiry_date = $req->expiry;
        $pub->survey = $req->survey;
        $pub->education = $req->education;
        $pub->occupatiion = $req->occupation;
        $pub->children_group = $req->childrenGroup;
        $pub->children_household = $req->childrenHousehold;
        $pub->household_category = $req->householdCategory;
        $pub->purchasing_role = $req->purchasingRole;
        $pub->user = Auth::id();
        if($pub->save()){
            Survey::where('id',$req->survey)->update(['publish'=>'1']);
            $cities = json_decode($req->cities);
            if(count($cities) > 0){
                foreach($cities as $city){
                    SurveyPublishCities::create([
                        'city' => $city->city,
                        'city_name' => $city->cityName,
                        'publishTo' => $city->publishTo,
                        'survey' => $req->survey,
                    ]);
                }
            }
            OneSignal::sendNotificationToAll(
                $req->notificationMsg, 
                $url = null, 
                $data = null, 
                $buttons = null, 
                $schedule = null
            );
            return 1;
        }
    }
    else{
    Survey::where('id',$id)->update(['publish'=>'0']);
    if(SurveyPublish::where('survey',$id)->delete()){
        SurveyPublishCities::where('survey',$id)->delete();
        return 1;
    }
    }
    }

    public function cost(){
    if(request()->ajax()){

        $cost = Costing::get();
        return datatables()->of($cost)
                    ->addColumn('title', function($data){
                        return $data->title;
                    })
                    ->addColumn('type', function($data){
                        return $data->type;
                    })
                    ->addColumn('price', function($data){
                        return 'Rs '.$data->price;
                    })
                    ->make(true);

    }
    return view('Admin.cost');
    }

    public function costPost(Request $req){
        $req->validate([
            'costTitle' => 'required',
            'costType' => 'required',
            'cost' => 'required'
        ]);
 
         if(Costing::where('title',$req->costTitle)->exists()){
             return 2;
         }
         else{
             $cost = new Costing();
             $cost->title = $req->costTitle;
             $cost->type = $req->costType;
             $cost->price = $req->cost;
             $cost->user = Auth::id();
             if($cost->save()){
                 return 1;
             }
             else{
                 return 0;
             }
         }
    }

    public function surveyQuestions($id){
        if(request()->ajax()){
            $id = Crypt::decrypt($id);
            $tbl = SurveyQuestion::where('survey',$id)->get();
            return datatables()->of($tbl)
                ->addColumn('question', function($data){
                    return $data->question;
                })
                ->addColumn('type', function($data){
                    return $data->questionType;
                })
                ->addColumn('rank', function($data){
                    return $data->rank;
                })
                ->addColumn('action', function($data) use ($id){
                    $total = SurveyQuestion::where('survey',$id)->get();
                    $a = 0;
                    $select = '<select class="selectOrder">';
                    $select .= '<option hidden>Change Order</option>';
                    foreach ($total as $value) {
                        $a++;
                        $data->rank == $a ? '' : $select .= '<option value="'.$a.'" data-order="'.$data->rank.'" data-id="'.$data->id.'">'.$a.'</option>';
                    }
                    $select .= '</select>';
                    return $select;
                })
                ->make(true);
            }
        return view('Admin.survey-question-order');
    }

    public function questionOrderUpdate($survey,$id,$current,$value){
        $survey = Crypt::decrypt($survey);
        SurveyQuestion::where(['survey' => $survey, 'rank' => $value])->update(['rank' => $current]);
        SurveyQuestion::where(['survey' => $survey, 'id' => $id])->update(['rank' => $value]);
    }

    public function SendSms(){
        // $SMSObj = array(
        //     'username' => 923405258574,   // Usually this is mobile number
        //     'password' => '2020',   // User your password here
        //     'to' => '923482010869',                     // You can provide single number as string or an array of numbers
        //     'text' => 'PUT_YOUR_MESSAGE_HERE',        // Message string you want to send to provided number(s)
        //     'mask' => 'Raaye',           // Use a registered mask with Telenor
        //     'test_mode' => '0',                         // 0 for Production, 1 for Mocking as Test
        // );
        
        // $telenor = new TelenorSMS();
        // $response = $telenor->SendSMS($SMSObj);
        // dd($response);
        // $survey = 15;
        // $total = count(SurveyQuestion::where('survey',$survey)->get());
        // $a = 1;
        // $sur = SurveyQuestion::where('survey',$survey)->get();
        // for($i=0; $i < $total; $i++){
        //     echo $a.' -- '.$sur[$i]['id'].'<br>';
        //     SurveyQuestion::where(['survey' => $survey, 'id' => $sur[$i]['id']])->update(['rank' => $a]);
        //     $a++;
        // }
        // Session::push(['id' => 1,'id' => 2],'Key');
        $a = Session::get('questionData');
        return SurveyQuestion::where('survey',6)->max('rank');
        return count(SurveyQuestion::where('survey',$a[0]['survey'])->get());
        return $a[0];
    }
}
