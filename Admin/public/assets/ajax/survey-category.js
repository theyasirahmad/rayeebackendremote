var url = path;

fetchSurveyCategory()
fetchSurveySubCategory()
fetchCosting()
fetchSurvey()


$('#surveyCategory').on('submit',function(e) {
    $(".error_msg").html("");
    e.preventDefault();
    const formData = new FormData(this);
    $.ajaxSetup({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });
    $.ajax({
        url: url+'/admin/survey-category',
        type: 'POST',
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend:function(){
            $("#surveyCategory input").prop("disabled", true);
        },
        success:function(res){
        if(res === '1'){
        fetchSurveyCategory() 
        Swal.fire({ type: 'success', text: 'Category Added Successfully'});
        Close()  
        $("#surveyCategory input").prop("disabled", false);
        $("#surveyCategory")[0].reset();
        }
        else if(res === '2'){
        Swal.fire({ type: 'error', text: 'Category Already Exist'});   
        $("#surveyCategory input").prop("disabled", false);
        $("#surveyCategory")[0].reset();
        }
        else{
            $("#surveyCategory input").prop("disabled", false);
            Swal.fire({ type: 'error', text: 'Error while adding records'});
            $("#surveyCategory")[0].reset();
        }
        },
        error:function(error){
            $.each(error.responseJSON.errors,function(key,value) {
            $("#"+key+"_msg").html(value);
            });
            },
        });
  
  
  });


  $('#surveySubCategory').on('submit',function(e) {
    $(".error_msg").html("");
    e.preventDefault();
    const formData = new FormData(this);
    $.ajaxSetup({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });
    $.ajax({
        url: url+'/admin/survey-sub-category',
        type: 'POST',
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend:function(){
            $("#surveySubCategory input").prop("disabled", true);
        },
        success:function(res){
        if(res === '1'){
        fetchSurveySubCategory() 
        Swal.fire({ type: 'success', text: 'Sub Category Added Successfully'});
        Close()  
        $("#surveySubCategory input").prop("disabled", false);
        $("#surveySubCategory")[0].reset();
        }
        else if(res === '2'){
        Swal.fire({ type: 'error', text: 'Sub Category Already Exist'});   
        $("#surveySubCategory input").prop("disabled", false);
        $("#surveySubCategory")[0].reset();
        }
        else{
            $("#surveySubCategory input").prop("disabled", false);
            Swal.fire({ type: 'error', text: 'Error while adding records'});
            $("#surveySubCategory")[0].reset();
        }
        },
        error:function(error){
            $.each(error.responseJSON.errors,function(key,value) {
            $("#"+key+"_msg").html(value);
            });
            },
        });
  
  
  });



function fetchSurveyCategory(){
    // Fetch Survey Category Table
    $('#surveyCategoryTable').DataTable().destroy();
        var userTable = $('#surveyCategoryTable').DataTable({
          processing: true,
          serverSide: true,
          responsive: false,
          language: { 
              search: "",
              searchPlaceholder: "Search records"
         },
          ajax:{ 
              url: url+'/admin/survey-category'
           },
          columns: [
            { data: 'title', name: 'title' },
            { data: 'discription', name: 'discription' },
        ]
    
    });
    
    }


function fetchSurveySubCategory(){
    // Fetch Survey Sub Category Table
    $('#surveySubCategoryTable').DataTable().destroy();
    var userTable = $('#surveySubCategoryTable').DataTable({
    processing: true,
    serverSide: true,
    responsive: false,
    language: { 
        search: "",
        searchPlaceholder: "Search records"
    },
    ajax:{ 
        url: url+'/admin/survey-sub-category'
    },
    columns: [
        { data: 'title', name: 'title' },
        { data: 'mainCategory', name: 'mainCategory' },
    ]
        
    });
        
    }

$('#category').change(function(){

    var val = $(this).val();
    $.ajax({
        url: url+'/admin/survey/'+val,
        type: 'GET',
        beforeSend:function(){
            $("#surveySubCategory input").prop("disabled", true);
        },
        success:function(res){
        console.log(res)
        var item = '';
        $.each(res.data, function(k, v)
        {
          item += "<option value='"+v.id+"'>"+v.title+"</option>";
        });
        $('#subCategory').html(item);
        $("#surveySubCategory input").prop("disabled", false);
        },
        error:function(error){
            $.each(error.responseJSON.errors,function(key,value) {
            $("#"+key+"_msg").html(value);
            });
            },
        });

});


$('#surveyForm').on('submit',function(e) {
    $(".error_msg").html("");
    e.preventDefault();
    const formData = new FormData(this);
    $.ajaxSetup({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });
    $.ajax({
        url: url+'/admin/survey',
        type: 'POST',
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend:function(){
            $("#surveyForm input").prop("disabled", true);
        },
        success:function(res){
        if(res === '1'){
        fetchSurvey()
        Swal.fire({ type: 'success', text: 'Survey Added Successfully'});
        Close()  
        $("#surveyForm input").prop("disabled", false);
        $("#surveyForm")[0].reset();
        }
        else if(res === '2'){
        Swal.fire({ type: 'error', text: 'Survey Title Already Exist'});   
        $("#surveyForm input").prop("disabled", false);
        $("#surveyForm")[0].reset();
        }
        else{
            $("#surveyForm input").prop("disabled", false);
            Swal.fire({ type: 'error', text: 'Error while adding survey'});
            $("#surveyForm")[0].reset();
        }
        },
        error:function(error){
            $.each(error.responseJSON.errors,function(key,value) {
            $("#"+key+"_msg").html(value);
            });
            },
        });
  
  
  });


function fetchSurvey(){
    // Fetch Survey Table
    $('#surveyTable').DataTable().destroy();
    var userTable = $('#surveyTable').DataTable({
    processing: true,
    serverSide: true,
    responsive: false,
    language: { 
        search: "",
        searchPlaceholder: "Search records"
    },
    ajax:{ 
        url: url+'/admin/survey'
    },
    columns: [
        { data: 'title', name: 'title' },
        { data: 'category', name: 'category' },
        { data: 'subCategory', name: 'subCategory' },
        { data: 'costing', name: 'costing' },
        { data: 'status', name: 'status' },
        // { data: 'discription', name: 'discription' },
        { data: 'action', name: 'action', orderable: false },
    ]
            
    });
            
}

$('#publishForm').on('submit',function(e) {
    $(".error_msg").html("");
    e.preventDefault();
    var getCity = JSON.parse(localStorage.getItem('cities'))
    if(getCity == null){
        swal('error','Please Add Cities Before Publish','error')
    }
    else{
    const formData = new FormData(this);
    formData.append('cities',JSON.stringify(getCity))
    $.ajaxSetup({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });
    $.ajax({
        url: url+'/admin/publish-survey',
        type: 'POST',
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend:function(){
            $("#publishForm input").prop("disabled", true);
        },
        success:function(res){
        if(res === '1'){
        fetchSurvey()
        $('#myModal').modal('hide');
        Swal.fire({ type: 'success', text: 'Survey Published'});
        $("#publishForm input").prop("disabled", false);
        $("#publishForm")[0].reset();    
        }
        else{
        Swal.fire({ type: 'error', text: 'Error while publishing survey'});
        $("#publishForm input").prop("disabled", false);
        $("#publishForm")[0].reset();
        }   
        },
        error:function(error){
            $.each(error.responseJSON.errors,function(key,value) {
            $("#"+key+"_msg").html(value);
            });
            },
        });
    }
  
  });

$(document).on('click','.publish',function(){
    var val = $(this).attr('data-id');
    var publish =$(this).attr('publish-data');
    if(publish === '0'){
        $('#survey').val(val);
        $('#myModal').modal('show');
    }
    else{
        $.ajaxSetup({
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        });
        $.ajax({
            url: url+'/admin/publish-survey/'+val,
            type: 'POST',
            success:function(res){
            if(res === '1'){
            fetchSurvey()
            Swal.fire({ type: 'success', text: 'Survey UnPublished'});
            }
            else{
            Swal.fire({ type: 'error', text: 'Error while updating record'});
            }   
            }
            });
    }
    
});

$('#costForm').on('submit',function(e) {
    $(".error_msg").html("");
    e.preventDefault();
    const formData = new FormData(this);
    $.ajaxSetup({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });
    $.ajax({
        url: url+'/admin/cost-post',
        type: 'POST',
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend:function(){
            $("#costForm input").prop("disabled", true);
        },
        success:function(res){
        if(res === '1'){
        fetchCosting() 
        Swal.fire({ type: 'success', text: 'Cost Added Successfully'});
        Close()  
        $("#costForm input").prop("disabled", false);
        $("#costForm")[0].reset();
        }
        else if(res === '2'){
        Swal.fire({ type: 'error', text: 'cost Title Already Exist'});   
        $("#costForm input").prop("disabled", false);
        $("#costForm")[0].reset();
        }
        else{
            $("#costForm input").prop("disabled", false);
            Swal.fire({ type: 'error', text: 'Error while adding records'});
            $("#costForm")[0].reset();
        }
        },
        error:function(error){
            $.each(error.responseJSON.errors,function(key,value) {
            $("#"+key+"_msg").html(value);
            });
            },
        });
  
  
  });


function fetchCosting(){
    // Fetch Cost Table
    $('#costTable').DataTable().destroy();
    var userTable = $('#costTable').DataTable({
    processing: true,
    serverSide: true,
    responsive: false,
    language: { 
        search: "",
        searchPlaceholder: "Search records"
    },
    ajax:{ 
        url: url+'/admin/cost'
    },
    columns: [
        { data: 'title', name: 'title' },
        { data: 'type', name: 'type' },
        { data: 'price', name: 'price' },
    ]
            
    });
            
}


$('#btnOpen').click(function(){
    Open()
});

$('#btnClose').click(function(){
    Close()   
});

function Open(){
    $('#btnOpen').css('display','none');
    $('#btnClose').css('display','block');
    $('#table').css('display','none');
    $('#form').slideToggle(1000);
}

function Close(){
    $('#btnClose').css('display','none');
    $('#btnOpen').css('display','block');
    $('#form').css('display','none');
    $('#table').slideToggle(1000); 
}