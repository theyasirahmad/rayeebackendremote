@extends('master.adminMaster')

@section('header')
       
@endsection

@section('content')
       
<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Survey</span> - Survey Details</h4>
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
							<a href="{{url('/admin/survey')}}" class="breadcrumb-item"><i class="icon-user mr-2"></i> Survey</a>
							<span class="breadcrumb-item active">Survey Details</span>
						</div>

						<a href="{{url('/admin/survey')}}" class="header-elements-toggle text-default d-md-none"><i class="icon-newspaper2"></i></a>
					</div>

					<div class="header-elements d-none">
						<div class="breadcrumb justify-content-center">

							
						</div>
					</div>
				</div>
			</div>
            <!-- /page header -->
            
            <div class="content">

            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Survey Details</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
					<table class="table text-center">
                    <?php if($survey->image != ''){ ?>
                    <tr>
                        <td colspan="2"><img src="{{ url('public/storage/surveyImage/').'/'.$survey->image }}" style="width:300px; max-height:300px"/></td>
                    </tr>
                    <?php } ?>

                    <tr>
                        <td>title</td>
                        <td>{{$survey->title}}</td>
                    </tr>

                    <tr>
                        <td>Discription</td>
                        <td>{{$survey->discription}}</td>
                    </tr>

                    <tr>
                        <td>Category</td>
                        <td>{{$survey->category->title}}</td>
                    </tr>
                        
                    <tr>
                        <td>Sub Category</td>
                        <td>{{$survey->subCategory->title}}</td>
                    </tr>

                    <tr>
                        <td>Survey Status</td>
                        <td>{{$survey->publish == 1 ? 'Publish' : 'Hold'}}</td>
                    </tr>

                    <tr>
                        <td>Cost Type</td>
                        <td>{{$survey->costing->type}}</td>
                    </tr>

                    <tr>
                        <td>Cost</td>
                        <td>{{$survey->costing->price}}</td>
                    </tr>

                    <tr>
                        <td>Survey Total Time</td>
                        <td>{{$survey->total_time}} mints</td>
                    </tr>

                    <tr>
                        <td>Survey Avg Time</td>
                        <td>{{@$survey->avg_time}} mints</td>
                    </tr>

                    </table>
                
                </div>

            </div>
            @if (count($question) > 0)
            @php
            $count = 1;
            $i = 0
            @endphp
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Survey Questions</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                        </div>
                    </div>
                </div>
            <div class="card-body">

                <table class="table" style='background-color:#000; color:#fff'>
                    <tr>
                        <th>#</th>
                        <th>Question</th>
                        <th>Question Type</th>
                        <th>Content</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    @foreach ($question as $item)
                    {{ $id = $item['id']}}
                    <tr style='background-color:#e5e5e5; color:#000; font-weight:bold; font-size:16px'>
                        <td>{{ $count }}</td>
                        <td>{{ $item['question'] }}</td>
                        <td>{{ $item['questionType'] }}</td>
                        <td>{{ $item['content'] }}</td>
                        <td>{{ $item['status'] == '1' ? 'Active' : 'Inactive' }}</td>
                    <td><a href="{{ url('/admin/delete-QA').'/'.$id.'/question' }}" class="btn btn-danger btnSm">Delete</a></td>
                    </tr>
                    @foreach ($item['answers'] as $key=>$it)
                    @if ($i == $key)
                    <tr class="text-center" style="background-color:#fff; color:black">
                        <th colspan="2">Answer Type</th>
                        <th colspan="2">Answer Content</th>
                        <th colspan="2">Action</th>
                    </tr>
                    @endif
                    <tr style='background-color:#fff; color:#000' class="text-center">
                        <td colspan="2">{{ $it->answerType }}</td>
                        <td colspan="2">{{ $it->content }}</td>
                        <td colspan="2"><a href="{{ url('/admin/delete-QA').'/'.$it->id.'/answer' }}" class="btn btnSm btn-danger">Delete</a></td>
                    </tr>
                    @endforeach
                    @php
                    $count++
                    @endphp
                    @endforeach
                </table>

            </div>


            </div>
            @endif


            </div>




			
       
@endsection

@section('footer')
       
@endsection
