$('.edit-question').click(function(){
    $(".question-text").text($(this).data('question'));
    $(".question_id").val($(this).data('id'));

});

$('.update-question').click(function(){

    var question = $(".question-text").val();
    var id = $(".question_id").val();
        $.ajax({
            type: 'PUT',
            url: $(this).data('url'),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                'question': question ,
                'id': id,
            },
            success: function() {
                $('#question').modal('hide');
                $('.question-body-'+id).html(question);
            },
        }).fail(function (jqXHR, textStatus, error) {
            alert(jqXHR.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: jqXHR.responseText,
                footer: '<a href>Why do I have this issue?</a>'
              })
        });	

});

$('.delete-question').click(function() {

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
                type: 'DELETE',
                url: $(this).data('url'),
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {},
                success: function() {
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                      )
                },
            });
            $(this).parent().closest('tr').fadeOut();     
        }
      })
   
});  
