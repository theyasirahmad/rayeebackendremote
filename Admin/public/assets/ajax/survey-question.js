var url = path;
// $('#surveyQuestionForm').on('submit',function(e) {
//     $(".error_msg").html("");
//     e.preventDefault();
//     const formData = new FormData(this);
//     $.ajaxSetup({
//         headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//     });
//     $.ajax({
//         url: url+'/admin/survey-question',
//         type: 'POST',
//         data: formData,
//         contentType: false,
//         cache: false,
//         processData: false,
//         beforeSend:function(){
//             $("#surveyQuestionForm input").prop("disabled", true);
//         },
//         success:function(res){
//         if(res == '1'){
//         Swal.fire({ type: 'success', text: 'Question Added Successfully'});
//         getAnswer()
//         $("#surveyQuestionForm input").prop("disabled", false);
//         reset()
//         }
//         else if(res == '2'){
//         Swal.fire({ type: 'error', text: 'Add atleast 1 answer for question'});
//         $("#surveyQuestionForm input").prop("disabled", false);
//         reset()    
//         }
//         else{
//         Swal.fire({ type: 'error', text: 'Error Adding Question'});
//         reset()
//         }
        
//         },
//         error:function(error){
//             $.each(error.responseJSON.errors,function(key,value) {
//             $("#"+key+"_msg").html(value);
//             });
//             },
//         });
  
  
// });

$('#surveyQuestionForm').on('submit',function(e) {
    $(".error_msg").html("");
    e.preventDefault();
    var val = $('#sur_type').val();
    const formData = new FormData(this);
    if(val == 'grid'){

        var check = JSON.parse(localStorage.getItem('gridQuestion'));
        var question = localStorage.getItem('question');
        question == null ? question = [] : question = JSON.parse(question);

        if(check === null){
            Swal.fire({ type: 'error', text: 'Add atleast 1 Grid Question and Answer'});
        }
        else{
        const data = {
            survey : $('#sur_survey').val(),
            type : $('#sur_type').val(),
            question : $('#sur_question').val(),
            status : $('#sur_status').val(),
            answer : check
        }
        const questionData = localStorage.setItem('question',JSON.stringify(question.concat(data)));
        if(questionData === undefined){
            localStorage.removeItem('gridQuestion')
            var html = '';
            const submitData = JSON.parse(localStorage.getItem('question'));
            $.each(submitData,function(k,v){
                html += '<tr style="background-color:#000; color:#fff">';
                html += '<td>'+v.question+'</td><td>'+v.type+'</td>';
                html += '</tr>';
                $.each(v.answer, function(i,d){
                    html += '<tr class="text-center">';
                    html += '<td colspan="2" style="background-color:#eae8e8;" class="text-center">Grid Question : '+d.question+'</td>';
                    html += '</tr>';
                    $.each(d.answer, function(x,y){
                        html += '<tr>';
                        html += '<td colspan="2">'+y+'</td>';
                        html += '</tr>';
                    })
                })
            });
            $('#gridTable').html(html);
           $('#gridTableDiv').show(1000)
        }
        else{
            Swal.fire({ type: 'error', text: 'Error while adding question'});
        }
        
    }

    }
    else{

        $.ajaxSetup({
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        });
        $.ajax({
            url: url+'/admin/surveyQuestion',
            type: 'POST',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend:function(){
                $("#surveyQuestionForm input").prop("disabled", true);
            },
            success:function(res){
            if(res.msg == 1){
            Swal.fire({ type: 'success', text: 'Question Added Successfully'});
            getAnswer()
            getQuestion()
            $("#surveyQuestionForm input").prop("disabled", false);
            reset()
            }
            else if(res.msg == 2){
            Swal.fire({ type: 'error', text: 'Add atleast 1 answer for question'});
            $("#surveyQuestionForm input").prop("disabled", false);
            reset()    
            }
            else{
            Swal.fire({ type: 'error', text: 'Error Adding Question'});
            $("#surveyQuestionForm input").prop("disabled", false);
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

$('#questionEditForm').on('submit',function(e) {
    $(".error_msg").html("");
    e.preventDefault();
    const formData = new FormData(this);
    $.ajaxSetup({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });
    $.ajax({
        url: url+'/admin/temp-question-edit',
        type: 'POST',
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend:function(){
            $("#questionEditForm input").prop("disabled", true);
        },
        success:function(res){
            if(res.msg == 1){
            $("#questionEditForm input").prop("disabled", false);
            $('#myModal').modal('hide');
            getQuestion()
        }
        },
        error:function(error){
            $.each(error.responseJSON.errors,function(key,value) {
            $("#"+key+"_msgg").html(value);
            });
            },
        });
  
  
});

$('#submitSurveyQuestion').click(function(){

    $.ajax({
        url: url+'/admin/submit-question',
        type: 'GET',
        success:function(res){
        if(res.msg === 1){
            Swal.fire({ type: 'success', text: 'Question Added Successfully'});  
            setTimeout(function(){
                window.location.href = url+"/admin/survey";
            },2000)
        }
        
        }
        });


})

$('#submitSurveyGridQuestion').click(function(){
    $.ajax({
        url: url+'/admin/grid-question-submit',
        type: 'POST',
        data: {data:JSON.parse(localStorage.getItem('question')), '_token': $('meta[name="csrf-token"]').attr('content')},
        beforeSend:function(){
            $("#surveyQuestionForm input").prop("disabled", true);
        },
        success:function(res){
            if(res == 1){
                $("#surveyQuestionForm input").prop("disabled", false);
                $('#gridTable').html('');
                $('#gridTableDiv').hide(1000)
                localStorage.removeItem('question')
                Swal.fire({ type: 'success', text: 'Question Added Successfully'});
                localStorage.clear();
            }
            else{
                Swal.fire({ type: 'error', text: 'Error while Adding Question.'});
            }
        
        },
        error:function(error){
            $.each(error.responseJSON.errors,function(key,value) {
            $("#"+key+"_msg").html(value);
            });
            },
        });

})





$('#answerSubmit').click(function(){

    var content = $('#answerTypeContent').val();
    var type = $('#answerType').val();
    var none = $('input[name="none"]:checked').val() == undefined ? null : $('input[name="none"]:checked').val()
    var exit = $('input[name="exit"]:checked').val() == undefined ? null : $('input[name="exit"]:checked').val()
    if(type !== null){
        if(type == 'radio' || type == 'checkbox' || type == 'image' || type == 'link'){
            if(content === ''){
            $("#answerContent_msg").html('Content is required');
            }
            else{
                $("#answerContent_msg").html('');
                $("#answerType_msg").html('');
                ajax(type,content,none,exit,$('#imageUpload').is(':checked'))
            }
        }
        else{
            $("#answerContent_msg").html('');
            $("#answerType_msg").html('');
            ajax(type)
        }
    }
    else{ 
    $("#answerType_msg").html('Answer type is required');
    }

});

function ajax(type,content = null,none,exit,imageupload = null){
    var data = new FormData();
    data.append('isImageUpload',$('#imageUpload').is(':checked'))
    imageupload ? data.append('answerImageUpload', $('#imageAnswerUpload').prop('files')[0]) : null;
    if(type == 'image'){
        data.append('type',type);
        data.append('content', $('#answerTypeContent').prop('files')[0]);
    }
    else{
        data.append('content',content);
        data.append('type',type);
        data.append('none',none);
        data.append('exit',exit);
    }
    $.ajaxSetup({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });
    $.ajax({
        url: url+'/admin/survey-answer',
        type: 'POST',
        contentType: false,
        processData: false,
        data: data,
        beforeSend:function(){
            $(".dis").prop("disabled", true);
        },
        success:function(res){
        if(res.msg === 1){
            getAnswer()
            $(".dis").prop("disabled", false);
        }
        else{
            console.log('error')
        }
        
        },
        error:function(error){
            $.each(error.responseJSON.errors,function(key,value) {
            $("#"+key+"_msg").html(value);
            });
            },
        });
}

function getAnswer(){
    $.ajax({
        url: url+'/admin/get-answer',
        type: 'GET',
        success:function(res){
        if(res.msg === 1){
        var item = '';

        $.each(res.data, function(k, v)
        {
          item += "<tr>";
          item += "<td>" +v.type+ "</td>";
          item += "<td>" +v.content+ "</td>";
          item += "<td><a href='javascript:void(0)' value='"+k+"' class='delItem'>Delete Answer</a></td>";
          item += "</tr>";
        });

        $('#answerTable').html(item);
        $('#answerTableDiv').show(1000);
        }
        
        }
        });
}

function getQuestion(){
    $.ajax({
        url: url+'/admin/get-question',
        type: 'GET',
        success:function(res){
            var item = '';
            var count = 1;
            var head = 0;
            if(res.msg === 1){
                $.each(res.data, function(k, v){
                    var status = v.status == 1 ? 'Active' : 'Inactive'
                    item += "<tr style='background-color:#e5e5e5; color:#000'>";
                    item += "<td>"+count+"</td>"
                    item += "<td>"+v.question+"</td>";
                    item += "<td>"+v.type+"</td>";
                    item += "<td>"+v.content+"</td>";
                    item += "<td>"+status+"</td>";
                    item += "<td>";
                    item += "<Button type='button' class='btn btnSm btn-success edit' data-id='"+k+"'>Edit</Button> | "
                    item += "<Button type='button' class='btn btnSm btn-danger delete' data-id='"+k+"'>Delete</Button> | "
                    item += "<Button type='button' class='btn btnSm btn-primary showw' data-id='"+k+"'>Show Answer</Button>";
                    item += "</td>";
                    item += "</tr>";
                    $.each(v.answer, function(i,d){
                    head === i ? item += "<tr style='display:none' class='table text-center "+k+"'><th colspan='3'>Answer Type</th><th colspan='3'>Answer Content</th></tr>" : '';
                    item += "<tr style='display:none' class='text-center "+k+"'>";
                    item += "<td colspan='3'>"+d.type+"</td>";
                    item += "<td colspan='3'>"+d.content+"</td>";
                    // item += "<td colspan='2'>";
                    // item += "<Button type='button' class='btn btnSm btn-danger deleteAns' data-id='"+k+"' data-action='"+i+"'>Delete</Button>"
                    // item += "</td>";
                    item += "</tr>";
                })
                count++
                });
                $('#questionTbl').html(item);
                $('#questionDiv').show(1000);
            }
        }
    });
}

$(document).on('click', '.showw', function(){
    var val = $(this).attr('data-id')
    var a = $(this).html();
    $('.'+val).toggle(300)
    if(a === 'Show Answer'){
        $(this).html('Hide Answer')
    }
    else{
        $(this).html('Show Answer')
    }
})

$(document).on('click', '.edit', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        url: url+'/admin/edit-temp-question/'+id,
        type: 'GET',
        success:function(res){
        if(res.msg == 1){
            $('#editQuestion').val(res.data.question);
            $("#"+res.data.type).attr("selected", "selected");
            $("#status"+res.data.status).attr("selected", "selected");
            $('#questionID').val(res.id);
            $('#myModal').modal('show',{
                backdrop: 'static',
                keyboard: false
            });
        }
        }
        });
})

$(document).on('click', '.deleteAns', function(){
    var main = $(this).attr('data-id');
    var sub = $(this).attr('data-action');
    $.ajax({
        url: url+'/admin/delete-temp-question-answer/'+main+'/'+sub,
        type: 'GET',
        success:function(res){
        if(res.msg == 1){
            getQuestion() 
        }
        }
        });
})

$(document).on('click', '.delete', function(){
    var id = $(this).attr('data-id');
    $.ajax({
        url: url+'/admin/delete-temp-question/'+id,
        type: 'GET',
        success:function(res){
        if(res.msg == 1){
            getQuestion() 
        }
        }
        });
})

$(document).on('click', '.delItem', function(){

    var val = $(this).attr('value');
    $.ajax({
      url:url+'/admin/delete-answer/'+val,
      type:'get',
      success:function(res){
        if(res.msg === 1){
            getAnswer();
        }
      }
    });
  
  });


$('.type').change(function(){
    var val = $(this).val();
    if(val == 'image' || val == 'audio' || val == 'video'){
        $('.typeContent').attr('type','file');
        $('.typeLabel').html('Select File');
        if(val == 'image'){
            $('.typeContent').attr('accept','image/*');
        }
        else if(val == 'audio'){
            $('.typeContent').attr('accept','audio/*');
        }
        else if(val == 'video'){
            $('.typeContent').attr('accept','video/mp4,video/*');
        }
        else if(val == 'grid'){

        }
        else{
            $('.typeContent').removeAttr('accept');
            
        }
        $('.typeFile').show(1000);
    }
    else if(val == 'same'){
        $('.typeContent').attr('type','text');
        $('.typeContent').attr('placeholder','Question Here ?')
        $('.typeLabel').html('Add Question');
        $('.typeFile').show(1000);
    }
    else if(val == 'rating'){
        $('.typeContent').attr('type','number');
        $('.typeContent').attr('placeholder','Rating')
        $('.typeContent').attr('max',1)
        $('.typeContent').attr('min',5)
        $('.typeLabel').html('Rating');
        $('.typeFile').show(1000);
        $('.typeContent').removeAttr('accept');
    }
    else{
        $('.typeFile').hide(1000);
    }

    if(val !== 'grid'){
        $('#simpleAnswer').show(1000);
        $('#gridAnswer').hide(1000);
    }
    else{
        $('#simpleAnswer').hide(1000);
        $('#gridAnswer').show(1000);
    }
});

$('#answerType').change(function(){
    var val = $(this).val();
    if(val == 'radio' || val == 'checkbox' || val == 'link'){
        var label = ''
        if(val == 'radio'){
            label = 'Radio Button Value'
            $('#exitDiv').show(1000)
            $('#noneDiv').hide(1000)
            $('#imageCheckBox').show(500)
            $('#noneDiv').attr('checked',false)
        }
        else if(val == 'checkbox'){
            label = 'Checkbox Value'
            $('#noneDiv').show(1000)
            $('#exitDiv').hide(1000)
            $('#imageCheckBox').show(500)
            $('#exitDiv').attr('checked',false)
        }
        else if(val == 'link'){
            label = 'URL'
            $('#imageCheckBox').hide(500)
        }
        if(val == 'link'){
            $('#answerTypeContent').attr('type','url'); 
            $('#answerTypeContent').attr('placeholder','http://example.com') 
            $('#answertypeLabel').html(label);
            $('#answerTypeInput').show(1000);
            $('#answerTypeContent').removeAttr('accept');
            $('#exitDiv').hide(1000)
            $('#noneDiv').hide(1000)
            $('#exitDiv').attr('checked',false)
            $('#noneDiv').attr('checked',false)
            $('#imageUpload').attr('checked',false)
            $('#imageCheckBox').hide(500)
            $('#imageBox').hide(500)
        }
        else{
        $('#answerTypeContent').attr('type','text');
        $('#answerTypeContent').attr('placeholder',label)
        $('#answertypeLabel').html(label);
        $('#answerTypeInput').show(1000);
        $('#answerTypeContent').removeAttr('accept');
        // $('#imageCheckBox').hide(500)
        }
    }
    else if(val == 'image'){
        $('#answerTypeContent').attr('type','file');
        $('#answertypeLabel').html('Select Image');
        $('#answerTypeContent').attr('accept','image/*');
        $('#answerTypeInput').show(1000);
        $('#imageCheckBox').hide(500)
        $('#imageUpload').attr('checked',false)
        $('#imageBox').hide(500)
    }
    else{
        $('#answerTypeInput').hide(1000); 
        $('#answerTypeContent').val('');
        $('#imageCheckBox').hide(500)
        $('#imageUpload').attr('checked',false)
        $('#imageBox').hide(500)
    }
});

$('#imageUpload').change(function(){
    var val = $('#imageUpload').is(':checked'); 
    if(val){
        $('#imageBox').show(500)
    }
    else{
        $('#imageBox').hide(500)
    }
})

$('#gridAnswerAdd').click(function(){

    var ansType = $('#gridAnswerType').val();
    var num = $('#gridTotalContent').val();
    var que = $('#gridQuestion').val();
    if(que === ''){
        alert('Please add a question.')
    }
    else if(ansType === null){
        alert(ansType)
    }
    else if(num === ''){
        alert(num.length)
    }
    else{
        if(num < 1 || num > 5){
            alert('maximum number of answer is five.');
        }
        else{
            
           $('#gridAnswerType').prop('disabled',true);
           $('#gridTotalContent').attr('disabled',true);
           $('#gridQuestion').attr('disabled',true);
           $('#gridAnswerAdd').attr('disabled',true);
           var html = '';
           for (let i = 1; i <= num; i++) {
               
                html += "<div class='row' id='btn"+i+"'>";
                html += "<div class='col-md-10'> <input type='text' class='form-control gridAnswerValue' placeholder='Enter Answer "+i+"' /></div>";
                html += "<div class='col-md-2'> <Button type='button' class='btn btnSm btn-danger gridAnswerValueBtn' data-id='btn"+i+"' >Delete</Button></div>";
                html += "</div>";
               
           }
           html +="<div class='row' style=' margin-top:20px;'>";
           html +="<div class='col-md-4'><Button type='button' class='btn btn-success' id='resetGridQuestionSection'>Reset</Button></div>";
           html +="<div class='col-md-8 pull-left'><Button type='button' class='btn btn-primary' id='submitGridQuestionSection'>Add Q/A</Button></div>";
           html +="</div>";
           $('#gridAnswerOptions').html(html);
           $('#gridAnswerOptions').show(1000)

        }
    }


});

$(document).on('click', '.gridAnswerValueBtn', function(){
    var del = $(this).attr('data-id');
    $('#'+del).remove();
})

$(document).on('click', '#resetGridQuestionSection', function(){
    $('#gridAnswerOptions').hide(1000)
    $('#gridAnswerOptions').html('');
    $('#gridAnswerType').prop('disabled',false);
    $('#gridTotalContent').attr('disabled',false);
    $('#gridQuestion').attr('disabled',false);
    $('#gridAnswerAdd').attr('disabled',false);

})

$(document).on('click', '#submitGridQuestionSection', function(){
    
    var check = localStorage.getItem('gridQuestion');
    check == null ? check = [] : check = JSON.parse(check);

    var arr = {
        question: $('#gridQuestion').val(),
        ansType: $('#gridAnswerType').val(),
        answer: []
    }
    var val = $('.gridAnswerValue').val();
    if(val === ""){
        Swal.fire({ type: 'error', text: 'Answer is required'});  
    }
    else{
    $('.gridAnswerValue').each(function(){
        var value = $(this).val();
        if(value !== ''){
            arr.answer.push(value);
            
        }
    });

    const data = localStorage.setItem('gridQuestion', JSON.stringify(check.concat(arr)))
    
    $('#gridAnswerOptions').hide(1000)
    $('#gridAnswerOptions').html('');
    $('#gridAnswerType').prop('disabled',false);
    $('#gridTotalContent').attr('disabled',false);
    $('#gridQuestion').attr('disabled',false);
    $('#gridAnswerAdd').attr('disabled',false);
}
    
    
})

// var a = JSON.parse(localStorage.getItem('gridQuestion'))
// $.each(a, function(k,v){
//     console.log(v.question+'<br>')
//     $.each(v.answer, function(x,y){
//         console.log(y+'<br>')
//     })
// })

function reset(){
    $('#type').prop('selectedIndex',0);  
    $('#status').prop('selectedIndex',0);   
    $('#question').val('');
    $('typefile').hide(1000);
    $('#typefile').val('');
}