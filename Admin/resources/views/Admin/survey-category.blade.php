@extends('master.adminMaster')

@section('header')
       
@endsection

@section('content')
       
<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Dashboard</span> - Category Details</h4>
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
							<span class="breadcrumb-item active">Category Details</span>
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
                    <h5 class="card-title">Create Category</h5>
                <div class="header-elements">
                    <div class="list-icons">
                    <Button type="button" id="btnClose" class="btn btn-sm btn-danger">Close</Button>
                </div>
                    </div>
            </div>
            <form id="surveyCategory">
            <div class="card-body">

                <div class="row">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" placeholder="Category Name" name="name" required>
                            <small><span class="error_msg" id="name_msg"></span></small>
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
                    <h5 class="card-title">Survey Category Details</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                        <Button type="button" id="btnOpen" class="btn btn-sm btn-primary">Add Category</Button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
					<table class="table" id="surveyCategoryTable" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Category Discription</th>
                            </tr>
                        </thead>

                    </table>
                
                </div>

            </div>


            </div>




			
       
@endsection

@section('footer')
<script src="{{url('/public/assets/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
<script src="{{url('/public/assets/global_assets/js/demo_pages/datatables_basic.js')}}"></script>
<script src="{{url('/public/assets/ajax/survey-category.js')}}"></script>
@endsection
