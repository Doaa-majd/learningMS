$(document).ready(function () {

// Delete more than records in same time 

    $('#master').on('click', function(e) {
     if($(this).is(':checked',true))
     {
        $(".sub_chk").prop('checked', true);
     } else {
        $(".sub_chk").prop('checked',false);
     }
    });

    $('.delete_all').on('click', function() {
        var allVals = [];
        $(".sub_chk:checked").each(function() {
            allVals.push($(this).attr('data-id'));
        });

        if(allVals.length <=0)
        {
            Swal.fire({
                title: 'Select one row at least.',
                showClass: {
                  popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                  popup: 'animate__animated animate__fadeOutUp'
                }
              })
        }  else {
            Swal.fire({
                title: 'Are you sure you want to delete this rows?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.value) {
                    var join_selected_values = allVals.join(",");
                    $.ajax({
                        url: $(this).data('url'),
                        type: 'DELETE',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values+'&table='+$(this).data('table'),
                        success: function (data) {
                            if (data['success']) {
                                $(".sub_chk:checked").each(function() {
                                    $(this).parents("tr").remove();
                                });
                                Swal.fire(
                                    'Deleted!',
                                    'Your rows has been deleted.',
                                    'success'
                                  )
                            } else if (data['error']) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: data['error'],
                                    footer: '<a href>Why do I have this issue?</a>'
                                  })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong!',
                                    footer: '<a href>Why do I have this issue?</a>'
                                  })
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: data.responseText,
                                footer: '<a href>Why do I have this issue?</a>'
                              })
                        }
                    });
    
                  $.each(allVals, function( index, value ) {
                      $('table tr').filter("[data-row-id='" + value + "']").remove();
                  });
                }
              })
           
        }
    });
// End bulk delete

///////////////////


  $( ".lecture" ).click(function(e) {
      var id = $(this).attr('id');
    $( ".lecture-resourse-"+id).slideToggle( "slow");
  });

 //////////////////Create Course
 
///////////////////Delete course

$('.delete-course').on('click', function() {

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
            $.ajax({
                url: $(this).data('url'),
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (res) {
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                      )
                      window.location=res.url;

                },
                error: function (data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.responseText,
                        footer: '<a href>Why do I have this issue?</a>'
                      })
                }
            });
          
        }
      })
    
});
//////////////////
        var showChar = 400;  
        var dots = "....";
        var moretext = "Read more +";
        var lesstext = "Read less";


        $('.more').each(function() {
            var content = $(this).html();

            if(content.length > showChar) {

                var shownText = content.substr(0, showChar);
                var hidden = content.substr(showChar, content.length - showChar);

                var html = shownText + '<span class="moreellipses">' + dots+
                 '&nbsp;</span> <span class="morecontent"><span>' 
                 + hidden + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

                $(this).html(html);
            }

        });

        $(".morelink").click(function(){
            if($(this).hasClass("less")) {
                $(this).removeClass("less");
                $(this).html(moretext);
            } else {
                $(this).addClass("less");
                $(this).html(lesstext);
            }
            $(this).parent().prev().toggle(); // to remove dotswhen read more is clicked
            $(this).prev().toggle(); //to display hidden text
            return false;
        });
    

}); //end document ready
