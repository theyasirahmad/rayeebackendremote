@extends('master.adminMaster')

@section('header')
       
@endsection

@section('content')
       
<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">User</span> - User Details</h4>
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
							<a href="index.html" class="breadcrumb-item"><i class="icon-user mr-2"></i> User</a>
							<span class="breadcrumb-item active">User Details</span>
						</div>

						<a href="{{url('/admin/user')}}" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
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
                    <h5 class="card-title">User Details</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
					<table class="table text-center">
                    <?php if($user->image != ''){ ?>
                    <tr>
                        <img src="{{ url('public/storage/userImage/').'/'.$user->image }}" style="width:300px; max-height:300px"/>
                    </tr>
                    <?php } ?>

                    <tr>
                        <td>First name</td>
                        <td>{{$user->first_name}}</td>
                    </tr>

                    <tr>
                        <td>First name</td>
                        <td>{{$user->last_name}}</td>
                    </tr>

                    <tr>
                        <td>Gender</td>
                        <td>{{$user->gender == '1' ? 'Male' : 'Female'}}</td>
                    </tr>
                        
                    <tr>
                        <td>Email</td>
                        <td>{{$user->email}}</td>
                    </tr>

                    <tr>
                        <td>Phone</td>
                        <td>{{$user->phone}}</td>
                    </tr>

                    <tr>
                        <td>Mobile Network</td>
                        <td>{{$user->mobile_network}}</td>
                    </tr>

                    <tr>
                        <td>Date Of Birth</td>
                        <td>{{$user->dob}}</td>
                    </tr>

                    <tr>
                        <td>Education</td>
                        <td>{{@$user->education_det->title}}</td>
                    </tr>

                    <tr>
                        <td>Occupation</td>
                        <td>{{@$user->occupation_det->title}}</td>
                    </tr>
    
                    <tr>
                        <td>Marital Status</td>
                        <td>{{$user->marital_status}}</td>
                    </tr>
    
                    <tr>
                        <td>Children</td>
                        <td>{{$user->children}}</td>
                    </tr>
    
                    <tr>
                        <td>Children Group</td>
                        <td>{{@$user->children_group_det->title}}</td>
                    </tr>
    
                    <tr>
                        <td>Children Household</td>
                        <td>{{@$user->children_household_det->title}}</td>
                    </tr>
    
                    <tr>
                        <td>Household</td>
                        <td>{{@$user->house_hold_det->title}}</td>
                    </tr>
    
                    <tr>
                        <td>Role Purchasing</td>
                        <td>{{@$user->role_purchasing_det->title}}</td>
                    </tr>

                    </table>
                
                </div>

            </div>


            </div>




			
       
@endsection

@section('footer')
       
@endsection
