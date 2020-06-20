$(document).ready(function () {


    $('#master').on('click', function(e) {
     if($(this).is(':checked',true))
     {
        $(".sub_chk").prop('checked', true);
     } else {
        $(".sub_chk").prop('checked',false);
     }
    });

    $('.delete_all').on('click', function(e) {


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
                    data: 'ids='+join_selected_values,
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

});
