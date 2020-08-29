@extends('master.adminMaster')

@section('header')
       
@endsection

@section('content')
       
<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Dashboard</span> - Survey Question</h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>

					<div class="header-elements d-none">
						<div class="d-flex justify-content-center">
							
						</div>
					</div>
				</div>

				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="javascript:void(0)" class="breadcrumb-item"><i class="icon-home mr-2"></i> Dashboard</a>
							<span class="breadcrumb-item active">Survey Question</span>
						</div>

						<a href="{{url('/admin/dashboard')}}" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>

					<div class="header-elements d-none">
						<div class="breadcrumb justify-content-center">

							
						</div>
					</div>
				</div>
			</div>
            <!-- /page header -->
            
            <div class="content">

            <div class="card" id="form">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Survey Question</h5>
                <div class="header-elements">
                    <div class="list-icons">
                </div>
                    </div>
            </div>
            <form id="surveyQuestionForm">
            <div class="card-body">

                <div class="row">
                    @csrf

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Survey</label>
                            <select class="form-control" name="survey" required id="sur_survey">
                            <option disabled hidden Selected value="">Select Survey</option>
                            @foreach ($survey as $item)
                            <option value="{{ $item->id }}">{{ $item->title }}</option>    
                            @endforeach
                            </select>
                            <small><span class="error_msg" id="survey_msg"></span></small>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Survey Question</label>
                            <input type="text" class="form-control" placeholder="Question" name="question" required id="sur_question">
                            <small><span class="error_msg" id="question_msg"></span></small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Question Type</label>
                            <select class="form-control type" name="type" required id="sur_type">
                            <option disabled hidden Selected value=''>Select Type</option>
                            <option value="question">Question</option>
                            <option value="same">Same</option>
                            <option value="grid">Grid</option>
                            <option value="image">Image</option>
                            <option value="audio">Audio</option>
                            <option value="video">Video</option>
                            <option value="rating">Rating</option>
                            </select>
                            <small><span class="error_msg" id="type_msg"></span></small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Question Status</label>
                            <select class="form-control" name="status" required id="sur_status">
                            <option disabled hidden Selected value="0">Select Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                            </select>
                            <small><span class="error_msg" id="status_msg"></span></small>
                        </div>
                    </div>

                    <div class="col-md-12 typeFile" style="display:none" id="sur_typeFile">
                        <div class="form-group">
                            <label id="typeLabel" class="typeLabel">Select File</label>
                            <input type="text" name="content" class="form-control typeContent"/>
                            <small><span class="error_msg" id="content_msg"></span></small>
                        </div>
                    </div>

                    <div class="row" style="width:100%; display:none; padding-left:10px" id="simpleAnswer">

                    <div class="col-md-12 card-header header-elements-inline">
                        <h5 class="card-title">Survey Answer</h5>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Answer Type</label>
                            <select class="form-control dis" name="answerType" id="answerType">
                            <option disabled hidden Selected>Select Type</option>
                            <option value="radio">Radio</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="text">Text</option>
                            <option value="rating">Rating</option>
                            <option value="link">Link</option>
                            </select>
                            <small><span class="error_msg" id="answerType_msg"></span></small>
                        </div>
                    </div>

                    <div class="col-md-3" id="answerTypeInput" style="display: none">
                        <div class="form-group">
                            <label id="answertypeLabel">Select File</label>
                            <input type="text" name="answerContent" class="form-control dis" id="answerTypeContent"/>
                            <small><span class="error_msg" id="answerContent_msg"></span></small>
                        </div>
                    </div>

                    <div class="col-md-2 imagesBox" style="display:none" id="imageBox">
                        <div class="form-group">
                            <label id="answertypeLabel">Select File</label>
                            <input type="file" name="imageAnswerUpload" id="imageAnswerUpload" class="form-control" />
                            <small><span class="error_msg" id="imageAnswerUpload_msg"></span></small>
                        </div>
                    </div>

                    <div class="col-md-1 imagesBox" style="display:none" id="imageCheckBox">
                    <label style="margin-top:30px">
                        <input type="checkbox" value="1" id="imageUpload" name="imageUpload"/>
                        Image
                        </label>
                    </div>

                    <div class="col-md-1" id="noneDiv" style="display:none">
                        <label style="margin-top:30px">
                        <input type="checkbox" value="1" id="none" name="none"/>
                        None Of These
                        </label>
                    </div>
                    
                    <div class="col-md-1" id="exitDiv" style="display:none">
                        <label style="margin-top:30px">
                        <input type="checkbox" value="1" id="exit" name="exit"/>
                        Exit Ans
                        </label>
                    </div>

                    <div class="col-md-2">
                            <Button type="button" class="btn btnXs btn-success dis" id="answerSubmit" style="margin-top:25px">Add</Button>
                    </div>

                </div>

                <div class="row" id="gridAnswer" style="display:none; width:100%; padding-left:10px">

                    <div class="col-md-12 card-header header-elements-inline">
                        <h5 class="card-title">Survey Grid Answer</h5>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label id="answertypeLabel">Grid Question</label>
                            <input type="text" name="gridQuestion" id="gridQuestion" class="form-control" placeholder="Grid Question ?"/>
                            <small><span class="error_msg" id="gridQuestion_msg"></span></small>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Answer Type</label>
                            <select class="form-control" name="gritAnswerType" id="gridAnswerType">
                            <option disabled hidden Selected value="">Select Type</option>
                            <option value="radio">Radio</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="link">Link</option>
                            </select>
                            <small><span class="error_msg" id="gridAnswerType_msg"></span></small>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label id="answertypeLabel">Total Answer</label>
                            <input type="number" name="gridTotalContent" id="gridTotalContent" class="form-control" placeholder="Enter total no of answer"/>
                            <small><span class="error_msg" id="gridAnswerContent_msg"></span></small>
                        </div>
                    </div>

                    <div class="col-md-2">
                            <Button type="button" class="btn btnXs btn-success dis" id="gridAnswerAdd" style="margin-top:25px">Add</Button>
                    </div>

                    <div class="col-md-12" id="gridAnswerOptions" style="display: none">



                    </div>


                </div>

                    <div class="col-md-12" id="answerTableDiv" style="display:none">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Answer Type</th>
                                <th>Answer Content</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="answerTable"></tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="submit" class="btn btn-sm btn-primary" style="float: right" value="Create"/>
                        </div>
                    </div>

                </div>

            </div>
            </form>
            </div>

    <div class="card" id="questionDiv" style="display: none">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Survey Question</h5>
        <div class="header-elements">
            <div class="list-icons">
            </div>
        </div>
        </div>
        <div class="card-body">

         <table class="table">
            <thead>
                <tr style='background-color:#000; color:#fff'>
                    <th>#</th>
                    <th>Question</th>
                    <th>Type</th>
                    <th>Content</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead> 
            <tbody id="questionTbl"></tbody>    
        </table>   

        </div>
        <div class="card-footer">
            <Button class="btn btn-primary" id="submitSurveyQuestion" style="float:right">Submit Question</Button>
        </div>
    </div>

    <div class="card" id="gridTableDiv" style="display: none">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Survey Question</h5>
        <div class="header-elements">
            <div class="list-icons">
            </div>
        </div>
        </div>
        <div class="card-body">

            <table class="table">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody id="gridTable"><tbody>
            </table> 

        </div>
        <div class="card-footer">
            <Button type="button" class="btn btn-primary" id="submitSurveyGridQuestion" style="float:right">Submit Question</Button>
        </div>
    </div>


            </div>




			
       
@endsection

<div class="modal fade" id="myModal" data-backdrop="static">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Question</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="questionEditForm">
            <div class="modal-body">
              <div class="row">
                  @csrf
                <input type="hidden" id="questionID" name="questionID"/>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Survey Question</label>
                        <input type="text" class="form-control" placeholder="Question" name="question" required id="editQuestion">
                        <small><span class="error_msg" id="question_msgg"></span></small>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Question Type</label>
                        <select class="form-control type" name="type" required id="type">
                        <option value="question" id="question">Question</option>
                        <option value="image" id="image">Image</option>
                        <option value="audio" id="audio">Audio</option>
                        <option value="video" id="video">Video</option>
                        <option value="rating" id="rating">Rating</option>
                        </select>
                        <small><span class="error_msg" id="type_msgg"></span></small>
                    </div>
                </div>

                <div class="col-md-12 typeFile" style="display:none" id="typeFile">
                    <div class="form-group">
                        <label id="typeLabel">Select File</label>
                        <input type="text" name="content" class="form-control typeContent" id="typeContent"/>
                        <small><span class="error_msg" id="content_msgg"></span></small>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Question Status</label>
                        <select class="form-control" name="status" required id="editStatus">
                        <option value="1" id="status1">Active</option>
                        <option value="0" id="status0">Inactive</option>
                        </select>
                        <small><span class="error_msg" id="status_msgg"></span></small>
                    </div>
                </div>

              </div>
            </div>
            <div class="modal-footer">
              <input type="submit" class="btn btn-primary" value="Save" />
            </div>
        </form>
          </div>
        </div>
      </div>

@section('footer')
<script src="{{url('/public/assets/ajax/survey-question.js')}}"></script>
<script>
    $(function(){
        localStorage.clear();
    })
</script>
@endsection
