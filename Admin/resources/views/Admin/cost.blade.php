@extends('master.adminMaster')

@section('header')
       
@endsection

@section('content')
       
<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Dashboard</span> - Costing</h4>
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
							<span class="breadcrumb-item active">Costing Units</span>
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
                    <h5 class="card-title">Create Cost or Gift Units</h5>
                <div class="header-elements">
                    <div class="list-icons">
                    <Button type="button" id="btnClose" class="btn icon-close2 btn-danger"></Button>
                </div>
                    </div>
            </div>
            <form id="costForm">
            <div class="card-body">

                <div class="row">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Cost Title</label>
                            <input type="text" class="form-control" placeholder="Cost Title" name="costTitle" required>
                            <small><span class="error_msg" id="costTitle_msg"></span></small>
                        </div>
                    </div>

                        <div class="col-md-6">
                        <div class="form-group">
                            <label>Cost Type</label>
                            <select class="form-control" name="costType" required>
                            <option disabled hidden Selected>Select Type</option>
                            <option value="gift">Gift</option>
                            <option value="price">Price</option>
                            </select>
                            <small><span class="error_msg" id="costType_msg"></span></small>
                        </div>
                        </div>

                        <div class="col-md-6">
                        <div class="form-group">
                            <label>Cost</label>
                            <input type="number" class="form-control" placeholder="Cost" name="cost" required>
                            <small><span class="error_msg" id="cost_msg"></span></small>
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
                    <h5 class="card-title">Cost Details</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                        <Button type="button" id="btnOpen" class="btn btn-primary icon-add"> Cost</Button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
					<table class="table" id="costTable" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Cost</th>
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
