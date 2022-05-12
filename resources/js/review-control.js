//Script for ajax-review-comments.blade.php 

$(document).ready(function($) {

    fetchComments(); // function call to fetchComments

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //Function fetches only unvalidated(NOT-approved) comments and populates them into table to be approved or deleted
    function fetchComments() {
        // ajax
        $.ajax({
            type: "GET",
            url: "fetch-comments",
            dataType: 'json',
            success: function(res) {
                //console.log(res);
                $('tbody').html("");
                $.each(res.comments, function(key, item) {
                    if(item.validated == 0){ //ensures only NON-approved comments are displayed
                        $('tbody').append('<tr>\
                            \
                            <td>' + item.id + '</td>\
                            <td>' + item.type + '</td>\
                            <td>' + item.comment + '</td>\
                            <td>' + item.author + '</td>\
                            <td>' + item.email + '</td>\
                            <td>' + item.effect + '</td>\
                            <td><button type="button" data-id="' + item.id + '" class="btn btn-primary approve btn-sm">Approve</button>\
                            <button type="button" data-id="' + item.id + '" class="btn btn-danger delete btn-sm">Delete</button></td>\
                            </tr>');    // 'Approve' and 'Delete' buttons appear to provide Admin control
                    }
                });
            },
        });
    }
    
    //Puts APPROVED comment data to the controller when 'Approve' button clicked
    $('body').on('click', '.approve', function(event) {
        event.preventDefault();
        var id = $(this).data('id')
        var type = "";
        var comment = "";
        var author = ""; 
        var email = "";
        var effect = "";
        var currentRow=$(this).closest("tr");
        type = currentRow.find("td:eq(1)").text();
        comment = currentRow.find("td:eq(2)").text();
        author = currentRow.find("td:eq(3)").text(); 
        email = currentRow.find("td:eq(4)").text();
        effect = currentRow.find("td:eq(5)").text();
        // ajax
        $.ajax({
            type: "PUT",
            url: "update-comment/" + id,
            data: {
                type: type,
                comment: comment,
                author: author,
                email: email,
                effect: effect,
                validated: 1,
            },
            dataType: 'json',
            success: function(res) {
                console.log(res);
                    $('#message').html("");
                    $('#message').addClass('alert alert-success');
                    $('#message').text(res.message);
                    fetchComments();
            },
            complete: function() {
                $("#btn-save").html('Save changes');
                $("#btn-save").attr("disabled", false);
                $('#ajax-comment-model').modal('hide');
                $('#message').fadeOut(5000);
            }
        });
    });
    
    //Deletes specified comment when 'Delete' button is clicked
    $('body').on('click', '.delete', function(evt) {
        evt.preventDefault();
        if (confirm("Delete Comment?") == true) {
            var id = $(this).data('id');
            // ajax
            $.ajax({
                type: "DELETE",
                url: "delete-comment/" + id,
                dataType: 'json',
                success: function(res) {
                    // console.log(res);
                    if (res.status == 404) {
                        $('#message').addClass('alert alert-danger');
                        $('#message').text(res.message);
                    } else {
                        $('#message').html("");
                        $('#message').addClass('alert alert-success');
                        $('#message').text(res.message);
                    }
                    fetchComments();
                }
            });
        }
    });
});