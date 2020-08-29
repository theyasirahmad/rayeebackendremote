<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use PHPMailer\PHPMailer;
use App\Models\User;
use App\Models\Roles;
use App\Models\Verify;
use App\Models\SurveyCategory;
use App\Models\SurveySubCategory;
use App\Models\Survey;
use App\Models\SurveyPublish;
use App\Models\SurveyQuestion;
use App\Models\SurveyAnswer;
use App\Models\children_group;
use App\Models\children_household;
use App\Models\education;
use App\Models\house_hold_sub_category;
use App\Models\occupation;
use App\Models\role_purchasing;
use App\Models\SurveyGridQuestion;
use App\Models\UserSurveyQuestionAnswer;
use App\Models\UserRefferal;
use App\Models\UserSurveyFill;
use \Developifynet\Telenor\TelenorSMS;
use App\Models\SurveyPublishCities;
use Validator;
use Auth;
use Crypt;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function login(Request $req)
    {
        $req->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        
        if(Auth::attempt(['phone' => $req->email, 'password' => $req->password])){
            if(Auth::user()->phone_verified == '0'){
                $code = mt_rand(1000, 9999);
                if(Verify::where(['user_id'=>Auth::id(),'type'=>'phone'])->exists()){
                    Verify::where('user_id', Auth::id())->delete();
                }
                $verify = new Verify();
                $verify->user_id = Auth::id();
                $verify->code = $code;
                $verify->type = 'phone';
                if($verify->save()){
                    
                    $phn = '92'.substr($req->email,1);
                    // $this->urlCall($code,$phn);
                    $url = 'https://raayeresearch.com/deployedSMS/try2.php?msg='.$code.'&number='.$phn;
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_TIMEOUT => 30000,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "GET",
                        CURLOPT_HTTPHEADER => array(
                        	// Set Here Your Requesred Headers
                            'Content-Type: application/json',
                        ),
                    ));
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    curl_close($curl);
                    if ($err) {
                        //return $err;
                    } else {
                       //return $response;
                    }
                }
            }
            $id = Crypt::encrypt(Auth::id());
            $arr = array(
                "token" => $id,
                "fname" => Auth::user()->first_name,
                "lname" => Auth::user()->last_name,
                "email" => Auth::user()->email,
                "phone" => Auth::user()->phone,
                "img" => Auth::user()->image,
                'ref_code' => Auth::user()->ref_code,
                "status" => Auth::user()->phone_verified
            );
            return response()->json(['msg'=>'success','res' => $arr, 'token'=>$id], 200);
        }
        else{
            return response()->json(['msg' => 'Error', 'res' => 'Invalid Mobile Number (03xxxxxxxx) Or Password'], 200);
        }

    }

    public function register(Request $req){

        $exists = [
            'phone' => $req->phone
        ];
        if(User::where($exists)->exists()){

            return response()->json(['msg'=>'Mobile Number already exists','res'=>'Mobile number already exists', 200]);
        }
        else{

            if(User::where(['email'=>$req->email])->exists()){
                return response()->json(['msg'=>'Email already exists','res'=>'Email already exists', 200]);
            }
            elseif(User::where(['cnic'=>$req->cnic])->exists()){
                return response()->json(['msg'=>'CNIC already exists','res'=>'CNIC already exists', 200]);
            }
            elseif($req->ref !== '' && !User::where('ref_code',$req->ref)->exists()){
                return response()->json(['msg'=>"Following referral ".$req->ref." Doesn't exist", 200]);
            }
            else{
                
                $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $ref = $req->fname.'-'.substr(str_shuffle($char),0,5);
                $date = explode('T',$req->dob);
                $role_user = Roles::where('name','User')->first();
                $user = new User();
                $user->first_name = $req->fname;
                $user->last_name = $req->lname;
                $user->dob = $req->dob;
                $user->gender = $req->gender;
                $user->city = $req->city;
                $user->email = $req->email;
                $user->password = bcrypt($req->password);
                $user->phone = $req->phone;
                $user->phone_verified == 1;
                $user->mobile_network = $req->network;
                $user->status = 1;
                $user->coords = $req->coords;
                $user->cnic = $req->cnic;
                $user->education = $req->education;
                $user->occupation = $req->occupation;
                $user->marital_status = $req->marital;
                $user->children = $req->children;
                $user->ref_code = $ref;
                if($user->save()){
                $user->roles()->attach($role_user);
                
                $code = mt_rand(1000, 9999);
                $verify = new Verify();
                $verify->user_id = $user->id;
                $verify->code = $code;
                $verify->type = 'phone';
                $verify->save();
                // if($verify->save()){
                    
                //     $phn = '92'.substr($req->phone,1);
                //     // $this->urlCall($code,$phn);
                //     // $url = 'http://3.20.235.7/deployedsms/try2.php?msg=1234&number=923482010869';
                //     $url = 'http://3.20.235.7/deployedsms/try2.php?msg='.$code.'&number='.$phn;
                //     $curl = curl_init();
                //     curl_setopt_array($curl, array(
                //         CURLOPT_URL => $url,
                //         CURLOPT_RETURNTRANSFER => true,
                //         CURLOPT_ENCODING => "",
                //         CURLOPT_TIMEOUT => 30000,
                //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                //         CURLOPT_CUSTOMREQUEST => "GET",
                //         CURLOPT_HTTPHEADER => array(
                //         	// Set Here Your Requesred Headers
                //             'Content-Type: application/json',
                //         ),
                //     ));
                //     $response = curl_exec($curl);
                //     $err = curl_error($curl);
                //     curl_close($curl);
                //     if ($err) {
                //         //return $err;
                //     } else {
                //       //return $response;
                //     }
                // }
                
                
                if($req->ref !== null){
                $parent_user = User::where('ref_code',$req->ref)->first();
                $ref_usr = new UserRefferal();
                $ref_usr->user = $parent_user->id;
                $ref_usr->ref_user = $user->id;
                $ref_usr->save();
            }

        if(Auth::attempt(['phone' => $req->phone, 'password' => $req->password])){
            $id = Crypt::encrypt(Auth::id());
            $arr = array(
                "token" => $id,
                "fname" => Auth::user()->first_name,
                "lname" => Auth::user()->last_name,
                "email" => Auth::user()->email,
                "phone" => Auth::user()->phone,
                "img" => Auth::user()->image,
                'ref_code' => Auth::user()->ref_code,
                "status" => Auth::user()->phone_verified
            );
            return response()->json(['msg'=>'success','res' => $arr], 200);
        }  

        }
        else{
        return response()->json(['msg' => 'Error While Registering User', 'res' => 'Error While Registering User'], 200);
        }

            }

        }
    }

    public function verify(Request $req){
        
        if($req->id == null){
            $ver = Verify::where(['user_id'=>$req->phone,'type'=>'phone'])->first();
            if($ver->code == $req->code){
                Verify::where('user_id',$req->phone)->delete();
            return response()->json(['msg'=>'success','res' => 'Verification successfull'], 200);
        }
        else{
            return response()->json(['msg'=>'error','res' => 'Invalid verification code'], 200);
        }
        }
        else{

        $id = Crypt::decrypt($req->id);
        $ver = Verify::where(['user_id'=>$id,'type'=>'phone'])->first();
        if($ver->code == $req->code){
            Verify::where('user_id',$id)->delete();
            User::where('id',$id)->update(['phone_verified'=>'1']);

            $user = User::where('id',$id)->first();
                $arr = array(
                    "token" => $req->id,
                    "fname" => $user->first_name,
                    "lname" => $user->last_name,
                    "email" => $user->email,
                    "phone" => $user->phone,
                    "img" => $user->image,
                    'ref_code' => $user->ref_code,
                    "status" => $user->phone_verified
                );
            return response()->json(['msg'=>'success','res' => $arr], 200);
        }
        else{
            return response()->json(['msg' => 'Invalid verification code'], 200);
        }
        }
    }
    
    
    public function phoneVerification(Request $req){
        if(User::where('phone',$req->phone)->exists()){
            return response()->json(['msg' => 'error','res' => 'User with this mobile number already exists'], 200);
        }
        else if(User::where('email',$req->email)->exists()){
            return response()->json(['msg' => 'error','res' => 'User with this email already exists'], 200);
        }
        else{
            if(Verify::where(['user_id'=>$req->phone,'type'=>'phone'])->exists()){
                Verify::where('user_id', $req->phone)->delete();
            }
        $code = mt_rand(1000, 9999);
        $verify = new Verify();
        $verify->user_id = '0'.$req->phone;
        $verify->code = $code;
        $verify->type = 'phone';
        if($verify->save()){

        
        $phn = '92'.substr($req->phone,1);
        $phn = '92'.substr($req->phone,1);
        $url = 'https://raayeresearch.com/deployedSMS/try2.php?msg='.$code.'&number='.$phn;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            //return $err;
        } else {
           //return $response;
        }
        return response()->json(['msg' => 'success','res' => 'An sms has been sent tou your mobile number with verification code'], 200);
        }
        else{
            return response()->json(['msg' => 'error','res' => 'Error while sending verification code'], 200);
        }
        
        }
    }

    public function checkStatus($id){

        $idd =  Crypt::decrypt($id);
        $user = User::where('id', $idd)->first();
        if($user->status == '1'){
            return response()->json(['msg' => 'Success'], 200);
        }
        else{
            return response()->json(['msg' => 'Error'], 200);
        }


    }
    
    public function getData(){
        $about = array(
            'edu_tbl' => education::get(),
            'occ_tbl' => occupation::get(),
            'child_tbl' => children_group::get(),
            'child_household_tbl' => children_household::get(),
            'role_tbl' => role_purchasing::get(),
        );

       return response()->json(['msg' => 'success','res' => $about], 200);
	//  return response()->json(['msg' => 'success'], 200);
    }

    public function profile( $id , $pro ){

	

        $idd =  Crypt::decrypt($id);
        $profile = User::with(['education_det','occupation_det','children_group_det',
        'children_household_det','house_hold_det','role_purchasing_det'])->where('id', $idd)->first();


        $basic = array(
          'image' => $profile->image,
            'avatar' => strtoupper($profile->first_name[0].$profile->last_name[0]),
            'fname' => $profile->first_name,
            'lname' => $profile->last_name,
            'gender' => $profile->gender == '1' ? 'Male' : 'Female',
            'dob' => $profile->dob,
            'email' => $profile->email,
            'phone' => $profile->phone,
            'network' => $profile->mobile_network,
            'phoneveri' => $profile->phone_verified,
        );

        $about = array(
            'education' => ['edu_id' => $profile->education_det['id'], 'edu_title' => $profile->education_det['title']],
            'occupation' => ['occ_id' => $profile->occupation_det['id'], 'occ_title' => $profile->occupation_det['title']],
            'marital_status' => $profile->marital_status,
            'children' => $profile->children == 'Yes' ? $profile->children : 'No',
            //'child' => ['child_id' => $profile->children_group_det['id'], 'child_title' => $profile->children_group_det['title']],
            //'child_household' => ['child_household_id' => $profile->children_household_det['id'], 'child_household_title' => $profile->children_household_det['title']],
            //'role_purchase' => ['role_id' => $profile->role_purchasing_det['id'], 'role_title' => $profile->role_purchasing_det['title']],
            'cnic' => $profile->cnic,
            'edu_tbl' => education::get(),
            'occ_tbl' => occupation::get(),
            //'child_tbl' => children_group::get(),
            //'child_household_tbl' => children_household::get(),
            //'role_tbl' => role_purchasing::get(),
        );

        if($pro == 'profile'){
        return $basic;
        }
        else{
        return $about;
        }
    }

    public function categories(){
        return SurveyCategory::get();
    }

    public function subCategories($id){
        return SurveySubCategory::where('main_Category',$id)->get();
    }

    public function surveyGet($id){
        $a = SurveyPublish::with(['survey' => function($q) use ($id){
            $q->where('sub_category',$id);
        }])->get();

        return $a;
    }

    public function surveyStart($id){
        // $qs = DB::table('survey_questions')->where('survey','=',$id)
        // ->join('survey_answers', 'survey_answers.questionID', '=', 'survey_questions.id')->get();
        // return $qs;
        $url = url('').'/public/storage/surveyQuestionUpload/';
        $uri = url('').'/public/storage/surveyAnswerUpload/';
        $qs = SurveyQuestion::where('survey',$id)->orderBy('rank', 'asc')->get();
        $an = SurveyAnswer::get();
        $arr = array();
        $grid = array();
        foreach ($qs as $q) {

            if($q->questionType == 'grid'){

                $gridQuestion = SurveyGridQuestion::where('question_id',$q->id)->get();
                foreach($gridQuestion as $as){

                   $an = SurveyAnswer::where('grid_question_id',$as->id)->get(); 
                    $array = array(
                        'gridQuestionID' => $as->id,
                        'Question' => $as->question,
                        'questionID' => $as->question_id,
                        'answer' => $an
                    );

                    array_push($grid,$array);

                }

                $ar = array(
                    'questionID' => $q->id,
                    'question' => $q->question,
                    'questionType' => $q->questionType,
                    'content' => $q->content,
                    'url' => $url,
                    'uri' => $uri,
                    'answers' => $grid
                );
                array_push($arr,$ar);


            }
            else{

            $ans = SurveyAnswer::where('questionID',$q->id)->inRandomOrder()->get();
            $ar = array(
                'questionID' => $q->id,
                'question' => $q->question,
                'questionType' => $q->questionType,
                'content' => $q->content,
                'url' => $url,
                'uri' => $uri,
                'answers' => $ans
            );
            array_push($arr,$ar);
            
            }
        
        }

        return $arr;
    }

    public function surveyMain($id){
    $id = Crypt::decrypt($id);
    $url = url('').'/public/storage/surveyImage/';
    $date = date('Y-m-d');
    $arr = [];
    $user = User::where('id',$id)->first();
    $userSurveySubmit = '';
    if(UserSurveyQuestionAnswer::where('user',$id)->exists()){
    $userSurveySubmit = UserSurveyQuestionAnswer::where('user',$id)->select('id','survey','user')
    ->groupBy('survey')->get();
    }
    $surveyPublish = SurveyPublish::orWhere('publish_to','=','all')
    ->orWhere('education','=','all')
    ->orWhere('occupatiion','=','all')
    ->orWhere('children_group','=','all')
    ->orWhere('children_household','=','all')
    ->orWhere('household_category','=','all')
    ->orWhere('purchasing_role','=','all')->get();
    foreach($surveyPublish as $item){

    $citiesPublish = SurveyPublishCities::where(['survey' => $item->survey, 'city_name' => $user->city])->first();
    $surveyTotal = UserSurveyFill::where(['survey' => $item->survey, 'city' => $user->city])->get();
    if($citiesPublish->publishTo > count($surveyTotal)){
        if($item->expiry_date >= $date){
            $start = strtotime($date);
            $end = strtotime($item->expiry_date);
            $days_between = ceil(abs($end - $start) / 86400);
        if(is_array($userSurveySubmit)){
        foreach($userSurveySubmit as $userSubmit){
            $data = [
                'publish_date' => $item->publish_date,
                'expiry_date' => $item->expiry_date,
                'expiry_days' => $days_between,
                'survey_id' => $item->surveyPublish->id,
                'title' => $item->surveyPublish->title,
                'image' => $item->surveyPublish->image,
                'url' => $url,
                'discription' => $item->surveyPublish->discription,
                'price' => $item->surveyPublish->costing->price,
                'cost_type' => $item->surveyPublish->costing->type,
                'attempt' => $userSubmit->survey == $item->survey ? '1' : '0'
            ];
            
        }
    }
    else{
        $data = [
            'publish_date' => $item->publish_date,
            'expiry_date' => $item->expiry_date,
            'expiry_days' => $days_between,
            'survey_id' => $item->surveyPublish->id,
            'title' => $item->surveyPublish->title,
            'image' => $item->surveyPublish->image,
            'url' => $url,
            'discription' => $item->surveyPublish->discription,
            'price' => $item->surveyPublish->costing->price,
            'cost_type' => $item->surveyPublish->costing->type,
            'attempt' => '0'
        ];
    }
        array_push($arr,$data);
    }
}
    }

    $surveyPublishToUser = SurveyPublish::with(['surveyPublish','surveyPublish.costing'])
    ->orWhere('publish_to','=',$user->gender)
    ->orWhere('education','=',$user->education)
    ->orWhere('occupatiion','=',$user->occupation)
    ->orWhere('children_group','=',$user->children_group)
    ->orWhere('children_household','=',$user->children_household)
    ->orWhere('household_category','=',$user->house_hold)
    ->orWhere('purchasing_role','=',$user->role_purchasing)->get();

    foreach($surveyPublishToUser as $item){
        $citiesPublish = SurveyPublishCities::where(['survey' => $item->survey, 'city_name' => $user->city])->first();
    $surveyTotal = UserSurveyFill::where(['survey' => $item->survey, 'city' => $user->city])->get();
    if($citiesPublish->publishTo > count($surveyTotal)){
        if($item->expiry_date >= $date){
        foreach($surveyPublishToUser as $userSubmit){
            $start = strtotime($date);
            $end = strtotime($item->expiry_date);
            $days_between = ceil(abs($end - $start) / 86400);
            $data = [
                'publish_date' => $item->publish_date,
                'expiry_date' => $item->expiry_date,
                'expiry_days' => $days_between,
                'survey_id' => $item->surveyPublish->id,
                'title' => $item->surveyPublish->title,
                'image' => $item->surveyPublish->image,
                'url' => $url,
                'discription' => $item->surveyPublish->discription,
                'price' => $item->surveyPublish->costing->price,
                'cost_type' => $item->surveyPublish->costing->type,
                'attempt' => $userSubmit->survey == $item->survey ? '1' : '0'
            ];
        }
            array_push($arr,$data);
        }
    }
    }
    
    return $arr;
}

    public function surveyFill(Request $req){
        
        if(count($req->an) > 0){
            $user_id = Crypt::decrypt($req->user);
            $city = User::where('id',$user_id)->first();
            $userFill = new UserSurveyFill();
            $userFill->user = $user_id;
            $userFill->city = $city->city;
            $userFill->survey = $req->s;
            $userFill->save();
            foreach ($req->an as $val) {
             UserSurveyQuestionAnswer::create([
                 'questionId' => $val['questionID'],
                 'questionType' => $val['questionType'],
                 'gridQuestion' => $val['gridQuestion'],
                 'answerID' => $val['answerID'],
                 'answerType' => $val['ansType'],
                 'survey' => $req->s,
                 'user' => $user_id,
                 'answer_value' => $val['answerValue']
             ]);

            }

            return response()->json(['msg'=>'Success'], 200);


        }
    }

    public function updateUserData(Request $req){
        $id = Crypt::decrypt($req->id);
        if($req->type == 'name'){
            $data = [
                'first_name' => $req->val,
                'last_name' => $req->val2
            ];
            if(User::where('id',$id)->update($data)){
                return response()->json(['msg'=>'Success'], 200);
            }
            else{
                return response()->json(['msg'=>'Error while updating profile.'], 200);
            }
            
        }
        elseif($req->type == 'dob'){
            $date = explode('T',$req->val);
            $data = [
                'dob' => $date[0],
            ];
            if(User::where('id',$id)->update($data)){
                return response()->json(['msg'=>'success'], 200);
            }
            else{
                return response()->json(['msg'=>'Error while updating profile.'], 200);
            }

        }
        elseif($req->type == 'phone'){
            $data = [
                'phone' => $req->val,
                'mobile_network' => $req->val2,
                'phone_verified' => 0
            ];
            if(User::where(['phone'=>$req->val])->exists()){
                return response()->json(['msg'=>'Phone number already exist.'], 200);
            }
            else{
            if(User::where('id',$id)->update($data)){
                return response()->json(['msg'=>'Success'], 200);
            }
            else{
                return response()->json(['msg'=>'Error while updating profile.'], 200);
            }
        }
        }

    }

    public function updateUserProfile(Request $req){
        $id = Crypt::decrypt($req->id);
        $data = [];
        if($req->type == 'education'){
            $data = [
                'education' => $req->val
            ];
        }
        elseif($req->type == 'occupation'){
            $data = [
                'occupation' => $req->val
            ];
        }
        elseif($req->type == 'marital'){
                $data = [
                    'marital_status' => $req->val,
                    'children' => $req->val2,
                    'children_group' => $req->val3,
                    'children_household' => 0
                ];
        }
        elseif($req->type == 'child'){
            $data = [
                'children' => $req->val,
                'children_group' => $req->val2,
                'children_household' => $req->val3
            ];
        }
        elseif($req->type == 'children'){
            $data = [
                'children_group' => $req->val,
            ];
        }
        elseif($req->type == 'childrenhousehold'){
            $data = [
                'children_household' => $req->val,
            ];
        }
        elseif($req->type == 'role'){
            $data = [
                'role_purchasing' => $req->val,
            ];
        }

        if(User::where('id',$id)->update($data)){
            return response()->json(['msg'=>'Success'], 200);
        }
        else{
            return response()->json(['msg'=>'Error while updating profile.'], 200);
        }


    }

    public function phoneVerify($id,$send,$code=null){
        $id = Crypt::decrypt($id);
        $user = User::where('id',$id)->first();
        $cell = ltrim($user->phone, '0');
        if($send == 'send'){
        $code = mt_rand(1000, 9999);
        if(Verify::where(['user_id'=>$id,'type'=>'phone'])->exists()){
            Verify::where('user_id', $id)->delete();
        }
        $verify = new Verify();
        $verify->user_id = $id;
        $verify->code = $code;
        $verify->type = 'phone';
        //$verify->save();
        // $SMSObj = array(
        //     'username' => 'arif',   // Usually this is mobile number
        //     'password' => 'Arif2020Pakistan12345678',   // User your password here
        //     'to' => $user->phone,                     // You can provide single number as string or an array of numbers
        //     'text' => 'Please verify your mobile number by entering this code '.$code,        // Message string you want to send to provided number(s)
        //     'mask' => 'RAAYE',           // Use a registered mask with Telenor
        //     'test_mode' => '0',                         // 0 for Production, 1 for Mocking as Test
        // );
        // $telenor = new TelenorSMS();
        // $response = $telenor->SendSMS($SMSObj);
        if($verify->save()){
            return $this->urlCall($code,$user->phone);
            //return response()->json(['msg'=>'success'], 200);
        }
        else{
            return response()->json(['msg'=>'Error while sending verification code. Please try again.'], 200);
        }
        }
        elseif($send == 'verify'){

        $ver = Verify::where(['user_id'=>$id,'type'=>'phone'])->first();
        if($ver->code == $code){
            Verify::where(['user_id'=>$id,'type'=>'phone'])->delete();
            User::where('id',$id)->update(['phone_verified'=>'1']);
            return response()->json(['msg' => 'success'], 200);
        }
        else{
            return response()->json(['msg' => 'Error while verifying code'], 200);
        }
        }

    }
    
    public function testing(){
        return $this->urlCall('1234','03482010869');
        return 123;
    }
    
    public function urlCall($code,$num){
        try {
            return redirect('http://103.249.154.246:2200/html/mmlocaltest/try2.php?msg='.$code.'&number='.$num);
        } catch (Exception $e) {
            report($e);

            return false;
        }
    }
    
    public function forgotPassword(Request $req){
        if(User::where('phone',$req->email)->exists()){
            $user = User::where('phone',$req->email)->first();
            if(Verify::where(['user_id'=>$user->id,'type'=>'phone'])->exists()){
                Verify::where('user_id', $user->id)->delete();
            }

            $code = mt_rand(1000, 9999);
            $verify = new Verify();
            $verify->user_id = $user->id;
            $verify->code = $code;
            $verify->type = 'phone';
            if($verify->save()){
                
                $phn = '92'.substr($req->email,1);
                $url = 'https://raayeresearch.com/deployedSMS/try2.php?msg='.$code.'&number='.$phn;
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_TIMEOUT => 30000,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        	// Set Here Your Requesred Headers
                        'Content-Type: application/json',
                    ),
                ));
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                if ($err) {
                    //return $err;
                } else {
                      //return $response;
                }
                return response()->json(['msg' => 'Success'], 200);
            } 


        }
        else{
            return response()->json(['msg' => 'Error'], 200); 
        }
    }
    
    public function forgotPasswordVerify(Request $req){
        

        $user = User::where('phone',$req->email)->first();

        $ver = Verify::where(['user_id'=>$user->id,'type'=>'phone'])->first();
        if($ver->code == $req->code){
            Verify::where('user_id',$user->id)->delete();
            return response()->json(['msg' => 'Success'], 200);
        }
        else{
            return response()->json(['msg' => 'Error'], 200);
        }
    }
    
    public function changePassword(Request $req){
        
        if(User::where('phone',$req->email)->update(['password'=>bcrypt($req->npass)])){
            return response()->json(['msg' => 'success'], 200);
        }
        else{
            return response()->json(['msg' => 'error'], 200);
        }
    }
    
    public function testingg($id){
        
        $id = Crypt::decrypt($id);
        $url = url('').'/public/storage/surveyImage/';
        $date = date('Y-m-d');
        $arr = [];
        $user = User::where('id',$id)->first();
        $userSurveySubmit = UserSurveyQuestionAnswer::where('user',$id)->select('id','survey','user')
        ->groupBy('survey')->get();
        $surveyPublish = SurveyPublish::orWhere('publish_to','=','all')
        ->orWhere('education','=','all')
        ->orWhere('occupatiion','=','all')
        ->orWhere('children_group','=','all')
        ->orWhere('children_household','=','all')
        ->orWhere('household_category','=','all')
        ->orWhere('purchasing_role','=','all')->get();
        foreach($surveyPublish as $item){
            if($item->expiry_date >= $date){
            foreach($userSurveySubmit as $userSubmit){
                $start = strtotime($date);
                $end = strtotime($item->expiry_date);
                $days_between = ceil(abs($end - $start) / 86400);
                $data = [
                    'publish_date' => $item->publish_date,
                    'expiry_date' => $item->expiry_date,
                    'expiry_days' => $days_between,
                    'survey_id' => $item->surveyPublish->id,
                    'title' => $item->surveyPublish->title,
                    'image' => $item->surveyPublish->image,
                    'url' => $url,
                    'discription' => $item->surveyPublish->discription,
                    'price' => $item->surveyPublish->costing->price,
                    'cost_type' => $item->surveyPublish->costing->type,
                    'attempt' => $userSubmit->survey == $item->survey ? '1' : '0'
                ];
                
            }
            array_push($arr,$data);
        }
        }

        $surveyPublishToUser = SurveyPublish::with(['surveyPublish','surveyPublish.costing'])
        ->orWhere('publish_to','=',$user->gender)
        ->orWhere('education','=',$user->education)
        ->orWhere('occupatiion','=',$user->occupation)
        ->orWhere('children_group','=',$user->children_group)
        ->orWhere('children_household','=',$user->children_household)
        ->orWhere('household_category','=',$user->house_hold)
        ->orWhere('purchasing_role','=',$user->role_purchasing)->get();

        foreach($surveyPublishToUser as $item){
            if($item->expiry_date >= $date){
            foreach($surveyPublishToUser as $userSubmit){
                $start = strtotime($date);
                $end = strtotime($item->expiry_date);
                $days_between = ceil(abs($end - $start) / 86400);
                $data = [
                    'publish_date' => $item->publish_date,
                    'expiry_date' => $item->expiry_date,
                    'expiry_days' => $days_between,
                    'survey_id' => $item->surveyPublish->id,
                    'title' => $item->surveyPublish->title,
                    'image' => $item->surveyPublish->image,
                    'url' => $url,
                    'discription' => $item->surveyPublish->discription,
                    'price' => $item->surveyPublish->costing->price,
                    'cost_type' => $item->surveyPublish->costing->type,
                    'attempt' => $userSubmit->survey == $item->survey ? '1' : '0'
                ];
            }
                array_push($arr,$data);
            }
        }
        

        return $arr;
    
    }

}
