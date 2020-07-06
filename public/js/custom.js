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
            alert("Please select row.");
        }  else {
            var check = confirm("Are you sure you want to delete this row?");
            if(check == true){
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
                            alert(data['success']);
                        } else if (data['error']) {
                            alert(data['error']);
                        } else {
                            alert('Whoops Something went wrong!!');
                        }
                    },
                    error: function (data) {
                        alert(data.responseText);
                    }
                });

              $.each(allVals, function( index, value ) {
                  $('table tr').filter("[data-row-id='" + value + "']").remove();
              });
            }
        }
    });
// End bulk delete

///////////////////

$( "#filter-btn" ).click(function(e) {
    $( ".filter" ).slideToggle( "slow", function(){

    });
  });

  $( ".lecture" ).click(function(e) {
      var id = $(this).attr('id');
    $( ".lecture-resourse-"+id).slideToggle( "slow");
  });

 //////////////////Create Course
 
///////////////////Delete course

$('.delete-course').on('click', function() {

        var check = confirm("Are you sure you want to delete this row?");
        if(check == true){
           
            $.ajax({
                url: $(this).data('url'),
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (res) {
                    window.location=res.url;
                },
                error: function (data) {
                    alert(data.responseText);
                }
            });

        }
    
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
