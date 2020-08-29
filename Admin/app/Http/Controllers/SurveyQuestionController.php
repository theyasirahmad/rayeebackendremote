<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\SurveyAnswer;
use App\Models\SurveyCategory;
use App\Models\SurveySubCategory;
use App\Models\SurveyGridQuestion;
use Crypt;
use Validator;
use Auth;
use Storage;
use File;
use Session;
use DB;

class SurveyQuestionController extends Controller
{

    public function question(){
        $survey = Survey::get();
        return view('Admin.survey-question', ['survey'=>$survey]);
    }

    public function questionPost(Request $req, $id = null){

        if(count(Session::get('tempData')) > 0){
        $survey = $id == null ? $req->survey : $id;
        $req->validate([
            'survey' => 'required',
            'type' => 'required',
            'status' => 'required',
            'question' => 'required|max:255',
        ]);

        $filename = '';
        if($req->hasfile('content')){
            $req->validate([
                'content' => 'max:2000'
            ]);
            $file = $req->file('content');
            $extension = $file->getClientOriginalExtension();
            $filename = $file->getFilename();
            $filename = md5(rand()).'.'.$extension;
            $file->move('public/storage/surveyQuestionUpload/', $filename);
        }
        $content = $filename == '' ? $req->content : $filename;
        $qs = new SurveyQuestion();
        $qs->survey = $survey;
        $qs->question = $req->question;
        $qs->questionType = $req->type;
        $qs->content = $content;
        $qs->status = $req->status;
        $qs->user = Auth::id();
        if($qs->save()){
        $id = $qs->id;
        foreach (Session::get('tempData') as $item) {
            SurveyAnswer::create([
                'answerType' => $item['type'],
                'content' => $item['content'],
                'questionID' => $id,
                'user' => Auth::id()
            ]);
        }
        session()->forget('tempData');
        return 1;
        }
    }
    else{
        return 2;
    }

    }

    public function surveyQuestion(Request $req){
        if(count(Session::get('tempData')) > 0){
        $req->validate([
            'survey' => 'required',
            'type' => 'required',
            'status' => 'required',
            'question' => 'required|max:255',
        ]);  
        $filename = '';
        if($req->hasfile('content')){
            $req->validate([
                'content' => 'max:2000'
            ]);
            $file = $req->file('content');
            $extension = $file->getClientOriginalExtension();
            $filename = $file->getFilename();
            $filename = md5(rand()).'.'.$extension;
            $file->move('public/storage/surveyQuestionUpload/', $filename);
        }
        $content = $filename == '' ? $req->content : $filename;
        $ans = Session::get('tempData');
        $questionData = [
            'survey' => $req->survey,
            'type' => $req->type,
            'question' => $req->question,
            'status' => $req->status,
            'content' => $content,
            'answer' => $ans
        ];

        Session::push('questionData',$questionData);
        session()->forget('tempData');
        return response()->json(['msg'=>1,'data'=>Session::get('questionData')], 200);
    }
    else{
        return response()->json(['msg'=>2], 200);
    }

    }

    public function surveyAnswer(Request $req){
        $filename = '';
        if($req->hasfile('content')){
            $req->validate([
                'content' => 'max:2000'
            ]);
            $file = $req->file('content');
            $extension = $file->getClientOriginalExtension();
            $filename = $file->getFilename();
            $filename = md5(rand()).'.'.$extension;
            $file->move('public/storage/surveyAnswerUpload/', $filename); 
        }
        $image = null;
        if($req->isImageUpload == 'true'){
            if($req->hasfile('answerImageUpload')){
            $file = $req->file('answerImageUpload');
            $extension = $file->getClientOriginalExtension();
            $image = $file->getFilename();
            $image = md5(rand()).'.'.$extension;
            $file->move('public/storage/surveyAnswerUpload/', $image); 
            }
            else{
                $image = null;
            }
        }

        $content = $filename == '' ? $req->content : $filename;
        $tempData = [
            'type' => $req->type,
            'content' => $content,
            'none' => $req->none,
            'exit' => $req->exit,
            'isImageUpload' => $req->isImageUpload,
            'image' => $image
        ];
        Session::push('tempData',$tempData);
        return response()->json(['msg'=>1], 200);

    }

    public function getQuestion(){
        return response()->json(['data'=>Session::get('questionData'), 'msg'=>1]);
    }

    public function getAnswer(){
        return response()->json(['data'=>Session::get('tempData'), 'msg'=>1]);
    }

    public function deleteAnswer($id){
        $val = Session::get('tempData')[$id];
        if($val['type'] == 'image'){
            File::delete('public/storage/surveyAnswerUpload/'.$val['content']);
            Session::pull('tempData.'.$id);
            return response()->json(['msg'=>1], 200); 
        }
        else{
            Session::pull('tempData.'.$id);
            return response()->json(['msg'=>1], 200);
        }
    }

    public function editTempQuestion($id){
        $val = Session::get('questionData')[$id];
        return response()->json(['msg'=>1,'data'=>$val,'id'=>$id], 200);
    }

    public function tempQuestionEdit(Request $req){

        $req->validate([
            'type' => 'required',
            'status' => 'required',
            'question' => 'required|max:255',
        ]);

        $filename = '';
        if($req->hasfile('content')){
            $req->validate([
                'content' => 'max:2000'
            ]);
            $file = $req->file('content');
            $extension = $file->getClientOriginalExtension();
            $filename = $file->getFilename();
            $filename = md5(rand()).'.'.$extension;
            $file->move('public/storage/surveyQuestionUpload/', $filename);
        }
        $content = $filename == '' ? $req->content : $filename;

        $old = Session::get('questionData')[$req->questionID];
        if($old['type'] == 'image' || $old['type'] == 'audio' || $old['type'] == 'video'){
            File::delete('public/storage/surveyQuestionUpload/'.$old['content']);   
        }
        
        $questionData = [
            'type' => $req->type,
            'question' => $req->question,
            'status' => $req->status,
            'content' => $content,
            'answer' => $old['answer']
        ];
        Session::push('questionData',$questionData);
        Session::pull('questionData.'.$req->questionID);
        return  response()->json(['msg'=>1], 200);
    }

    public function deleteTempQuestion($id){
        $val = Session::get('questionData')[$id];
        if($val['type'] == 'image' || $val['type'] == 'audio' || $val['type'] == 'video'){
            File::delete('public/storage/surveyQuestionUpload/'.$val['content']);
            Session::pull('questionData.'.$id);
            return response()->json(['msg'=>1], 200); 
        }
        else{
            Session::pull('questionData.'.$id);
            return response()->json(['msg'=>1], 200);
        } 
    }

    public function deleteTempQuestionAnswer($main,$sub){
       $val = Session::get('questionData')[$main]['answer'];
        Session::pull($val.[$sub]);
        return response()->json(['msg'=>1], 200); 
    }

    public function submitquestion(){
        if(count(Session::get('questionData')) > 0){
        $a = 0;
        $sur = Session::get('questionData');
        $survey = count(SurveyQuestion::where('survey',$sur[0]['survey'])->get());
        if($survey > 0){
            $great = SurveyQuestion::where('survey',$sur[0]['survey'])->max('rank');
            $a = (int)$great + 1;
        }
        else{
            $a = 1;
        }
        foreach(Session::get('questionData') as $item){
            $id = DB::table('survey_questions')->insertGetId([
                'survey' => $item['survey'],
                'question' => $item['question'],
                'questionType' => $item['type'],
                'content' => $item['content'],
                'status' => $item['status'],
                'rank' => $a,
                'user' => Auth::id()
            ]);

            foreach($item['answer'] as $it){
                SurveyAnswer::create([
                    'answerType' => $it['type'],
                    'content' => $it['content'],
                    'questionID' => $id,
                    'user' => Auth::id(),
                    'none' => $it['none'],
                    'exit_ans' => $it['exit'],
                    'isImageUpload' => $it['isImageUpload'],
                    'image' => $it['image']
                ]);
            }
            $a++;
        }
        session()->forget('questionData');
        session()->forget('tempData');
        return response()->json(['msg'=>1], 200); 

    }
    else{
        return response()->json(['msg'=>0], 200); 
    }

    }

    public function gridQuestionSubmit(Request $req){

        $var = false;

        foreach($req->data as $val){

            $id = DB::table('survey_questions')->insertGetId([
                'survey' => $val['survey'],
                'question' => $val['question'],
                'questionType' => $val['type'],
                'status' => $val['status'],
                'user' => Auth::id()
            ]);

            foreach ($val['answer'] as $key) {
                $grid_id = DB::table('survey_grid_questions')->insertGetId([
                    'question' => $key['question'],
                    'question_id' => $id
                ]); 

                foreach($key['answer'] as $data){
                    $ans_id = DB::table('survey_answers')->insertGetId([
                        'answerType' => $key['ansType'],
                        'content' => $data,
                        'questionID' => $id,
                        'user' => Auth::id(),
                        'grid_question_id' => $grid_id,
                    ]);  
                }
            }

            $var = true;
        }

        if($var){
            return 1;
        }
        

    }

    public function DeleteQA($id,$type){

        if($type === 'question'){
            SurveyQuestion::where('id',$id)->delete();
            SurveyAnswer::where('questionID',$id)->delete();
            return back();
        }
        elseif($type === 'answer'){
            SurveyAnswer::where('id',$id)->delete();
            return back();
        }

    }

    
}
