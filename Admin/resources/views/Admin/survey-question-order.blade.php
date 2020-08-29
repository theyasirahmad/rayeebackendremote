@extends('master.adminMaster')

@section('header')
       
@endsection

@section('content')
       
<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Survey</span> - Survey Questions</h4>
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
							<span class="breadcrumb-item active">Survey Questions</span>
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

            
                <div class="card" id="table">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Survey Question</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                            {{-- <Button type="button" id="btnOpen" class="btn btn-primary icon-add"> Cost</Button> --}}
                            </div>
                        </div>
                    </div>
    
                    <div class="table-responsive">
                        <table class="table" id="questionTable" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Question</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
    
                        </table>
                    
                    </div>
    
                </div>


            </div>




			
       
@endsection

@section('footer')

{{-- <script src="{{url('/public/assets/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script> --}}
{{-- <script src="{{url('/public/assets/global_assets/js/demo_pages/datatables_basic.js')}}"></script> --}}
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js"></script>
<script>

$(function(){

    getData()

})
    
function getData(){
    
    $('#questionTable').DataTable().destroy();
        var userTable = $('#questionTable').DataTable({
          processing: true,
          serverSide: true,
          responsive: false,
          rowReorder: true,
          language: { 
              search: "",
              searchPlaceholder: "Search records"
         },
          ajax:{ 
              url: '{{url("")}}/admin/survey-questions/{{Request::segment(3)}}'
           },
          columns: [
            { data: 'rank', name: 'rank' },
            { data: 'question', name: 'question' },
            { data: 'type', name: 'type' },
            { data: 'action', name: 'action'}
            
        ]
    
    });
   
}

$(document).on('change','.selectOrder',function(){
    var val = $(this).val()
    var current = $(this).find(':selected').attr('data-order')
    var id = $(this).find(':selected').attr('data-id')
    var survey = "{{Request::segment(3)}}"
    $.ajax({
        url:`{{url('admin/survey-question-order-update')}}/${survey}/${id}/${current}/${val}`,
        type:'GET',
        success:function(res){
            getData()
        }
    })
    
})

// window.addEventListener("beforeunload", function (e) {        
//       alert()
//     });


</script>


       
@endsection
