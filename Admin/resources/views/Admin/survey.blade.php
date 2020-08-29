@extends('master.adminMaster')

@section('header')
       
@endsection

@section('content')
       
<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Dashboard</span> - Survey Details</h4>
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
							<span class="breadcrumb-item active">Survey Details</span>
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

            <div class="card" id="form" style="display:none">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Create Survey</h5>
                <div class="header-elements">
                    <div class="list-icons">
                    <Button type="button" id="btnClose" class="btn icon-close2 btn-danger"></Button>
                </div>
                    </div>
            </div>
            <form id="surveyForm">
            <div class="card-body">

                <div class="row">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Survey Title</label>
                            <input type="text" class="form-control" placeholder="Survey Title" name="title" required>
                            <small><span class="error_msg" id="title_msg"></span></small>
                        </div>
                    </div>

                        <div class="col-md-6">
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" name="category" required id="category">
                            <option disabled hidden Selected>Select Category</option>
                            @foreach ($category as $item)
                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                            </select>
                            <small><span class="error_msg" id="category_msg"></span></small>
                        </div>
                        </div>

                        <div class="col-md-6">
                        <div class="form-group">
                            <label>Sub Category</label>
                            <select class="form-control" name="subCategory" required id="subCategory">
                            <option disabled hidden Selected>Select Sub Category</option>
                            </select>
                            <small><span class="error_msg" id="subCategory_msg"></span></small>
                        </div>
                        </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Survey Cost</label>
                            <select class="form-control" name="cost" required>
                                <option disabled hidden Selected>Select Cost</option>
                                @foreach ($costing as $item)
                                <option value="{{ $item->id }}">{{ $item->title }} - {{ $item->type }} - Rs{{ $item->price}}</option>
                                @endforeach
                                </select>
                                <small><span class="error_msg" id="cost_msg"></span></small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select Image</label>
                            <input type="file" name="file" class="form-control" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Survey Total Time</label>
                            <input type="number" class="form-control" placeholder="Total Time" name="totalTime" required>
                            <small><span class="error_msg" id="totalTime_msg"></span></small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Survey Avg Time</label>
                            <input type="number" class="form-control" placeholder="Survey Avg Time" name="avgTime" required>
                            <small><span class="error_msg" id="avgTime_msg"></span></small>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Discription</label>
                            <textarea rows="3" cols="3" class="form-control" placeholder="Discription" required name="discription"></textarea>
                            <small><span class="error_msg" id="discription_msg"></span></small>
                        </div>
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

            <div class="card" id="table">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Survey Details</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                        <Button type="button" id="btnOpen" class="btn btn-primary icon-add"> Survey</Button>
                        <a href="{{url('/admin/survey-category')}}" class="btn btn-primary icon-add"> Category</a>
                        <a href="{{url('/admin/survey-sub-category')}}" class="btn btn-primary icon-add"> Sub Category</a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
					<table class="table" id="surveyTable" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Cost</th>
                                <th>Status</th>
                                {{-- <th>Discription</th> --}}
                                <th>Actions</th>
                            </tr>
                        </thead>

                    </table>
                
                </div>

            </div>


            </div>




			
       
@endsection

@section('footer')

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Publish Survey</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="publishForm">
            <div class="modal-body">
              <div class="row">
                  @csrf
                <input type="hidden" id="survey" name="survey"/>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Gender</label>
                        <select class="form-control" name="publish" required>
                        <option disabled hidden Selected>Select Publish</option>
                        <option value="all">All</option>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                        </select>
                        <small><span class="error_msg" id="publish_msg"></span></small>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Education</label>
                        <select class="form-control" name="education" required>
                        <option disabled hidden Selected>Select Education</option>
                        <option value="all">All</option>
                        @foreach ($education as $item)
                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach
                        </select>
                        <small><span class="error_msg" id="education_msg"></span></small>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Occupation</label>
                        <select class="form-control" name="occupation" required>
                        <option disabled hidden Selected>Select Occupation</option>
                        <option value="all">All</option>
                        @foreach ($occupation as $item)
                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach
                        </select>
                        <small><span class="error_msg" id="occupation_msg"></span></small>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Children Group</label>
                        <select class="form-control" name="childrenGroup" required>
                        <option disabled hidden Selected>Select Children Group</option>
                        <option value="all">All</option>
                        @foreach ($childrenGroup as $item)
                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach
                        </select>
                        <small><span class="error_msg" id="childrenGroup_msg"></span></small>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Children Household</label>
                        <select class="form-control" name="childrenHousehold" required>
                        <option disabled hidden Selected>Select Children Household</option>
                        <option value="all">All</option>
                        @foreach ($childrenHousehold as $item)
                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach
                        </select>
                        <small><span class="error_msg" id="childrenHousehold_msg"></span></small>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Household Category</label>
                        <select class="form-control" name="householdCategory" required>
                        <option disabled hidden Selected>Select Household Category</option>
                        <option value="all">All</option>
                        @foreach ($childrenHouseholdCategory as $item)
                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach
                        </select>
                        <small><span class="error_msg" id="householdCategory_msg"></span></small>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Purchasing Role</label>
                        <select class="form-control" name="purchasingRole" required>
                        <option disabled hidden Selected>Select Purchasing Role</option>
                        <option value="all">All</option>
                        @foreach ($purchasingRole as $item)
                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach
                        </select>
                        <small><span class="error_msg" id="purchasingRole_msg"></span></small>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Survey Notification Message</label>
                        <input type="text" class="form-control" placeholder="Notification Message" required name="notificationMsg"/>
                        <small><span class="error_msg" id="notificationMsg_msg"></span></small>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Survey Expiry Date</label>
                        <input type="date" class="form-control" placeholder="Expiry Date" required name="expiry"/>
                        <small><span class="error_msg" id="expiry_msg"></span></small>
                    </div>
                </div>


                <div class="col-md-5">
                    <div class="form-group">
                        <label>Select City</label>
                        <select class="form-control" name="city" id="city">
                        <option value='' selected hidden>Select City</option>
                        @foreach($cities as $city)
                        <option value='{{$city->id}}'>{{$city->city}}</option>
                        @endforeach
                        </select>
                        <small><span class="error_msg" id="city_msg"></span></small>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="form-group">
                        <label>Publish To</label>
                        <input type="number" class="form-control" placeholder="50" name="publishTo" id="publishTo"/>
                        <small><span class="error_msg" id="publishTo_msg"></span></small>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <button type="button" class="btn btn-primary btn-sm" id="publishCity" style="margin-top:20px">Add</button>
                    </div>
                </div>

              </div>
            </div>
            <div class="modal-footer">
              <input type="submit" class="btn btn-primary" value="Publish" />
            </div>
        </form>
          </div>
        </div>
      </div>

<script src="{{url('/public/assets/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
<script src="{{url('/public/assets/global_assets/js/demo_pages/datatables_basic.js')}}"></script>
<script src="{{url('/public/assets/ajax/survey-category.js')}}"></script>

<script>


$('#publishCity').click(function(){
    $('.error_msg').html('')
    var city = $('#city').val()
    var cityName = $('#city option:selected').text()
    alert(cityName)
    var publishTo = $('#publishTo').val()
    if(city == ''){
        $('#city_msg').html('Please select city')
    }
    else if(publishTo == ''){
        $('#publishTo_msg').html('Please add number of people to publish')
    }
    else{
        var getCities = JSON.parse(localStorage.getItem('cities'))
        var array = []
        var obj = { "city":city, "cityName":cityName, "publishTo":publishTo }
        if(getCities == null){
            array.push(obj)
            localStorage.setItem('cities',JSON.stringify(array))
            swal('success','City Added','success')
        }
        else{
            array.push(obj)
            getCities.map((v,i) => {
                if(parseInt(v.city) !== parseInt(city)){
                    array.push(v)
                } 
            })
            localStorage.setItem('cities',JSON.stringify(array))
            swal('success','City Added','success')
        }
    }
})

</script>
@endsection
