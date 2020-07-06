$(document).ready(function () {

    // To add new section 
    $(".add-section").click(function(e){
        var name = $(".section-name").val();
        var course_id = $(".course_id").val();
        
                $.ajax({
                        type: 'POST',
                        url: $(this).data('url'),
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {
                            'name': name,
                            'course_id' :course_id,
                        },
                        success: function(data) {
                            $('#addsection').modal('hide');
                            $(".section-container").append(
                                `<section class="section">
                                    <div class="action-section">
                                    <a href="#" class="edit-section" data-name="`+ data.section.name +`" id="`+ data.section.id +`"><i class="far fa-edit"></i></a>
                                    <a href="#" class="delete-section" data-url="admin/sections/section/`+ data.section.id +`" id="`+ data.section.id +`"><i class="fas fa-times"></i></a>
                                    </div>
                                    <div class="section-title">
                                        <h4> `+ data.section.name +` </h4>
                                    </div>
                                    <div class="add-lecture"><a href="#" data-toggle="modal" data-target="#addlecture" data-sid="`+ data.section.id +`" class="add-lecture-modal"><i class="fas fa-plus"></i> Lecture</a></div>
                                </section>`);
                        },     
                           
                    }).fail(function (jqXHR, textStatus, error) {
                        alert(jqXHR.responseText);
                    });
    		
			
    });

    //To show edit button and title on modal (edit and create in same modal)
    $(document).on( 'click', '.edit-section', function() {

         $(".section-name").val($(this).data('name'));
         $(".course_id").val($(this).attr('id'));
        $(".save").hide();
        $(".edit").show();
		
    });    

    $(document).on( 'click', '.add-section-modal', function() {

        $(".section-name").val('');
        $(".course_id").val($(this).attr('id'));

       $(".save").show();
       $(".edit").hide();
    });
    
    //update
    $(document).on( 'click', '.update-section', function() {
        var name = $(".section-name").val();
        var section_id = $(".course_id").val();

        $.ajax({
            type: 'PUT',
            url: $(this).data('url'),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                'name': name,
                'section_id':section_id,
            },
            success: function() {
                $('#addsection').modal('hide');
                $('.section-title').find('h4').html(name);
            },
        }).fail(function (jqXHR, textStatus, error) {
            alert(jqXHR.responseText);
        });	
      
      
    });


    $(document).on( 'click','.delete-section', function() {

        $.ajax({
                        type: 'DELETE',
                        url: $(this).data('url'),
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {},
                        success: function() {
                        
                        },
                    });
                    $(this).parent().parent().fadeOut();     
    });  
   ///////////////////////////// for Lectures

   function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $('#video64').attr('value', e.target.result);
  
      }
      
      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }
  
  $("#customFile").change(function() {
    readURL(this);
    });

    ///////////////////////////// for Modal window
    $(document).on( 'click', '.edit-lecture-modal', function() {

        $(".lecture-name").val($(this).data('name'));
        $(".section_id").val($(this).data('lid')); //put lecture id in section id input to use it in update lecture
       $(".store-lecture").hide();
       $(".edit-lecture").show();
       
   });    

   $(document).on( 'click', '.add-lecture-modal', function() {

       $(".lecture-name").val('');
       $("#video64").val('');
       $(".section_id").val($(this).data('sid'));

      $(".store-lecture").show();
      $(".edit-lecture").hide();
   });


   $(document).on( 'click', '.store-lecture', function() {
    var name = $(".lecture-name").val();
    var course_id = $(".course_id").val();
    var section_id =  $(".section_id").val();
    var video64 = $("#video64").val();

        $.ajax({
            type: 'POST',
            url: $(this).data('url'),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                'name': name,
                'course_id':course_id,
                'section_id': section_id,
                'video':video64,
            },
            success: function(data) {
                $('#addlecture').modal('hide');
                $(".all-lectures-"+section_id).append(
                    `<div class="lecture" id="`+ data.lecture.id+`">
                <div class="lecture-title-`+ data.lecture.id+`">`+ data.lecture.name+`
                    <div class="action-lecture">
                        <a href="#" data-toggle="modal" data-target="#addlecture" data-sid="{{$section->id}}" data-lid="{{$lecture->id}}" data-name="{{$lecture->name}}" class="edit-lecture-modal"><i class="far fa-edit"></i></a>
                        <a href="#"><i class="fas fa-times"></i></a>
                    </div>
                </div>
                <div class="lecture-resourse-`+ data.lecture.id+` lecture-items mt-3">
                    <div class="video-`+ data.lecture.id+` float-left">
                        <a href="#">`+ data.lecture.video+` </a>
                    </div>
                    <div class="file float-right">
                        <a href="#">`+ data.lecture.file+` </a>
                    </div>
                </div>
            </div>`);
            },
        }).fail(function (jqXHR, textStatus, error) {
            alert(jqXHR.responseText);
        });	

});

//update lecture
$(document).on( 'click', '.edit-lecture', function() {
    var name = $(".lecture-name").val();
    var lecture_id =  $(".section_id").val();
    var video64 = $("#video64").val();

    $.ajax({
        type: 'PUT',
        url: $(this).data('url'),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
            'name': name,
            'lecture_id':lecture_id,
            'video':video64,
        },
        success: function(data) {
            $('#addlecture').modal('hide');
            $('.lecture-title-'+data.lecture.id).html(data.lecture.name);
            $('.video-'+data.lecture.id).find('a').text(data.lecture.video);
        },
    }).fail(function (jqXHR, textStatus, error) {
        alert(jqXHR.responseText);
    });	
  
});
// for Delete

$(document).on( 'click','.delete-lecture', function() {

    $.ajax({
        type: 'DELETE',
        url: $(this).data('url'),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {},
        success: function() {
        
        },
    });
    $(this).parent().parent().parent().fadeOut();     
});  


});