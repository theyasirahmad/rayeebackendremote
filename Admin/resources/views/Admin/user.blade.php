@extends('master.adminMaster')

@section('header')
    
@endsection

@section('content')
       
<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - User</h4>
						<a href="javascript:void(0)" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>

					<div class="header-elements d-none">
						<div class="d-flex justify-content-center">
							
						</div>
					</div>
				</div>

				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="{{url('/admin/dashboard')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
							<span class="breadcrumb-item active">User</span>
						</div>

						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>

					<div class="header-elements d-none">
						<div class="breadcrumb justify-content-center">

							
						</div>
					</div>
				</div>
			</div>
			<!-- /page header -->

			<div class="content">

				<!-- User datatable -->
				<div class="card">
						<div class="card-header header-elements-inline">
							<h5 class="card-title">Users</h5>
							<div class="header-elements">
								<div class="list-icons">

								</div>
							</div>
						</div>
	
						<table class="table datatable-basic" id="userTable">
							<thead>
								<tr>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Gender</th>
									<th>Email</th>
									<th>Phone</th>
								</tr>
							</thead>
						</table>
					</div>
					<!-- /basic datatable -->
	

			</div>


			
       
@endsection

@section('footer')
<script src="{{url('/public/assets/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
<script src="{{url('/public/assets/global_assets/js/demo_pages/datatables_basic.js')}}"></script>
<script src="{{url('/public/assets/ajax/user.js')}}"></script>  
@endsection
