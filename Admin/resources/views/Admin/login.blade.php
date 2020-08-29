<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>RAAYE - Admin Login</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{url('/public/assets/global_assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{url('/public/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{url('/public/assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{url('/public/assets/css/layout.min.css" rel="stylesheet')}}" type="text/css">
	<link href="{{url('/public/assets/css/components.min.css" rel="stylesheet')}}" type="text/css">
    <link href="{{url('/public/assets/css/colors.min.css" rel="stylesheet')}}" type="text/css">
    <link rel="stylesheet" href="{{url('/public/assets/sweetalert2/dist/sweetalert2.min.css')}}" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{url('/public/assets/global_assets/js/main/jquery.min.js')}}"></script>
    <script src="{{url('/public/assets/global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
    <script src="{{url('/public/assets/sweetalert2/dist/sweetalert2.min.js')}}"></script>
	<script src="{{url('/public/assets/global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
	<script src="{{url('/public/assets/global_assets/js/plugins/ui/ripple.min.js')}}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{url('/public/assets/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>

	<script src="{{url('/public/assets/js/app.js')}}"></script>
	<script src="{{url('/public/assets/global_assets/js/demo_pages/login.js')}}"></script>
	<!-- /theme JS files -->
    <style>
   
        .error_msg{
            color:red;
        }
            
    </style>
</head>

<body class="" style="background-color:#37474f">

	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content d-flex justify-content-center align-items-center">

				<!-- Login card -->
                    <div class="card" style="width:400px; margin-top:10%">
                        <form id="login">
                                {{ csrf_field() }}
						<div class="card-body">
							<div class="text-center mb-3">
                                <img src="{{url('/public/assets/img/icon.png')}}" style="width:160px; height:70px"/><br><br>
								<h5 class="mb-0">Login to your account</h5>
								<span class="d-block text-muted">Your credentials</span>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="text" class="form-control" placeholder="email" name="email">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
                                </div>
                                <small><span class="error_msg" id="email_msg"></span></small>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="password" class="form-control" placeholder="Password" placeholder="Password" name="password">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
                                </div>
                                <small><span class="error_msg" id="password_msg"></span></small>
							</div>

							<div class="form-group">
                                <input type="submit" class="btn btn-primary btn-block" value="Sign in"/>
							</div>
                        </div>
                    </form>
					</div>
				<!-- /login card -->

			</div>
			<!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->
<script>


$(function() {

$('#login').on('submit',function(e) {
  $(".error_msg").html("");
  e.preventDefault();
  const formData = new FormData(this);

  const email = $('#email').val();
  const password = $('#password').val();

  if(email === ''){
    $('#email_msg').html('Email field is required')
  }
  else{

    if(password === ''){
      $('#password_msg').html('Password field is required')
    }
    else{
      $.ajaxSetup({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      });
      $.ajax({
          url: "{{url('/login')}}",
          type: 'POST',
          data: formData,
          contentType: false,
          cache: false,
          processData: false,
          beforeSend:function(){
            $("#login input").prop("disabled", true);
          },
          success:function(res){
            if(res === '1'){
              window.location.href="{{url('/admin/survey')}}";
            }
            else{
            $("#login input").prop("disabled", false);
            Swal.fire({ type: 'error', text: 'Invalid Email Or Password'});
            setTimeout(function(){
              window.location.href="{{url('/login')}}";
            }, 2000)
            }
          },
          error:function(error){
            $.each(error.responseJSON.errors,function(key,value) {
            $("#"+key+"_msg").html(value);
          });
          },
      });

    }

  }


});


});

</script>
</body>
</html>
