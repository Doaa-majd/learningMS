$('.lecture-complete').change(function() {
    var course_id = $(this).data('cid');
     var lecture_id = $(this).data('lid');

    if ($(this).prop('checked')) {
    
            $.ajax({
                    type: 'POST',
                    url: $(this).data('url'),
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        'lecture_id': lecture_id,
                        'course_id' :course_id,
                    },
                    success: function(data) {
                        $('.progress-title span').text(data.progress +'%');
                        $('.progress-bar').css('width', data.progress +'%');
                        $('.sr-only').text('Your Progress: ' +data.progress +'%');
                    },     
                       
                });

    }
    else {
        $.ajax({
        type: 'DELETE',
        url: $(this).data('url'),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
            'lecture_id': lecture_id,
            'course_id' :course_id,
        },
        success: function(data) {
            $('.progress-title span').text(data.progress +'%');
            $('.progress-bar').css('width', data.progress +'%');
            $('.sr-only').text('Your Progress: ' +data.progress +'%');
        },
         });
    }
});

// For Questions
// display question area
$('.add-question-btn').click(function(e){
    e.preventDefault();
    $('.add-question').slideToggle();
});

// add question
$(".ask").click(function(e){
    e.preventDefault();
    var question = $(".question-area").val();
    var course_id = $(this).data('cid');
    
            $.ajax({
                    type: 'POST',
                    url: $(this).data('url'),
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        'question': question,
                        'course_id' :course_id,
                    },
                    success: function(data) {
                        $(".question-area").val('');
                        $('.add-question').hide();
                        $(".list-questions").append(
                            `<div class="well">
                            <div class="media">                           
                                <div class="media-body">
                                    <h4 class="media-heading user-question">`+ data.user +`</h4>                               
                                    <p class="question-body-`+ data.question.id +`">`+ data.question.question +`</p>
                                    <div class="update-question-`+ data.question.id +` update-question">
                                        <textarea class="updated-question" rows="2" cols="70"> `+ data.question.question +` </textarea>
                                        <div>
                                            <a href="#" class="update-q" data-url="http://localhost:8000/question/update" data-qid="`+ data.question.id +`"> Update </a>
                                        </div>
                                    </div>
                                    
                                    <div class="question-action">
                                       <a href="#" class="edit-question" data-qid="`+ data.question.id +`"> Edit </a>
                                        <a href="#" class="delete-q" data-url="http://localhost:8000/question/delete" data-qid="`+ data.question.id +`">Delete</a>
                                    </div>
                                </div>
                            </div>                           
                        </div>`);
                    },     
                       
                }).fail(function (jqXHR, textStatus, error) {
                    alert(jqXHR.responseText);
                });
        
        
});

$(document).on( 'click', '.edit-question', function(e) {
    e.preventDefault();
   var qid = $(this).data('qid');
   $(".question-body-"+qid).hide();
   $(".update-question-"+qid).show();
   
});    

// for update question

$(document).on( 'click', '.update-q', function(e) {
    e.preventDefault();
    var question = $(".updated-question").val();
    var qid = $(this).data('qid');

    $.ajax({
        type: 'PUT',
        url: $(this).data('url'),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
            'question': question,
            'question_id' :qid,
        },
        success: function(data) {
            $(".question-body-"+data.question.id).text(data.question.question);
            $(".question-body-"+data.question.id).show();
            $(".update-question-"+data.question.id).hide();
        },
    }).fail(function (jqXHR, textStatus, error) {
        alert(jqXHR.responseText);
    });	
  
  
});

// for delete


$(document).on( 'click','.delete-q', function(e) {
    e.preventDefault();
    var qid = $(this).data('qid');

    $.ajax({
                    type: 'DELETE',
                    url: $(this).data('url'),
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        'question_id' :qid,
                    },
                    success: function() {
                    
                    },
                });
                $(this).parent().closest('.well').fadeOut();     
});  

/// for rating tab 
// add user rating

$(".star-rating.star-5 input").on('click', function(){

        var ratingNum = $(this).val();
        var course_id = $('.course-id').val();
       // alert(ratingNum);
      
            $.ajax({
                    type: 'POST',
                    url: $('.course-id').data('url'),
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        'rating_num': ratingNum,
                        'course_id' :course_id,
                    },
                    success: function(data) {
                        
                    },     
                       
                }).fail(function (jqXHR, textStatus, error) {
                    alert(jqXHR.responseText);
                });
        
        
});