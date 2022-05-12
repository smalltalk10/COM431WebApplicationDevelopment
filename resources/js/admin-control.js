//Script for ajax-admin-comment-crud.blade.php 

$(document).ready(function($) {

    fetchComments(); // function call to fetchComments

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //Function fetches only VALIDATED (approved) comments and populates them into the table
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
                    if(item.validated == 1){ //ensures only approved comments are displayed
                        $('tbody').append('<tr>\
                            <td><input type="checkbox" name="validated" id="validated' + item.id + '" value="' + item.selected + '"/></td>\
                            <td>' + item.id + '</td>\
                            <td>' + item.type + '</td>\
                            <td>' + item.comment + '</td>\
                            <td>' + item.author + '</td>\
                            <td>' + item.email + '</td>\
                            <td>' + item.effect + '</td>\
                            <td><button type="button" data-id="' + item.id + '" class="btn btn-primary edit btn-sm">Edit</button>\
                            <button type="button" data-id="' + item.id + '" class="btn btn-danger delete btn-sm">Delete</button></td>\
                            </tr>');    // 'Edit' and 'Delete' buttons appear to provide Admin control
                    }
                });
            },
            complete: function() {
                isChecked();
            }
        });
    }

    //Calls ajax comment bootstrap model when 'Add' button clicked
    $('#addNewComment').click(function(evt) {
        evt.preventDefault();
        $('#addEditCommentForm').trigger("reset");
        $('#ajaxCommentModel').html("Add Comment");
        $('#btn-add').show();
        $('#btn-save').hide();
        $('#ajax-comment-model').modal('show');
    });
    //Posts NEW comment data to controller when 'Save' button clicked or re-enter if invalid
    $('body').on('click', '#btn-add', function(event) {
        event.preventDefault();
        var type = $("#type").val();
        var comment = $("#comment").val();
        var author = $("#author").val();
        var email = $("#email").val();
        var effect = $("#effect").val();
        var validated = $("#validated").val();
        $("#btn-add").html('Please Wait...');
        $("#btn-add").attr("disabled", true);
        // ajax
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "save-comment",
            data: {
                type: type,
                comment: comment,
                author: author,
                email: email,
                effect: effect,
                validated: validated, //Unlike restricted view where validated forced to unapproved(0),
                                        //'Validated' can be specified by the Admin for new comments
            },
            success: function(res) {
                //console.log(res);
                if (res.status == 400) {
                    $('#msgList').html("");
                    $('#msgList').addClass('alert alert-danger');
                    $.each(res.errors, function(key, err_value) {
                        $('#msgList').append('<li>' + err_value + '</li>');
                    });
                    $('#btn-save').text('Save changes');
                } else {
                    $('#message').html("");
                    $('#message').addClass('alert alert-success');
                    $('#message').text(res.message);
                    fetchComments();
                }
            },
            complete: function() {
                $("#btn-add").html('Save');
                $("#btn-add").attr("disabled", false);
                $("#btn-add").hide();
                $('#ajax-comment-model').modal('hide');
                $('#message').fadeOut(5000);
            }
        });
    });

    //Retrieves specified comment information when 'Edit' button is clicked
    $('body').on('click', '.edit', function(evt) {
        evt.preventDefault();
        var id = $(this).data('id');
        // ajax
        $.ajax({
            type: "GET",
            url: "edit-comment/" + id,
            dataType: 'json',
            success: function(res) {
                console.dir(res);
                $('#ajaxCommentModel').html("Edit Comment");
                $('#btn-add').hide();
                $('#btn-save').show();
                $('#ajax-comment-model').modal('show');
                if (res.status == 404) {
                    $('#msgList').html("");
                    $('#msgList').addClass('alert alert-danger');
                    $('#msgList').text(res.message);
                } else {
                    // console.log(res.comment.xxx);
                    $('#type').val(res.comment.type);
                    $('#comment').val(res.comment.comment);
                    $('#author').val(res.comment.author);
                    $('#email').val(res.comment.email);
                    $('#effect').val(res.comment.effect);
                    $('#id').val(res.comment.id);
                }
            }
        });
    });

    //Puts UPDATED comment data to the controller after editing when 'Save Changes' button clicked or re-enter if invalid
    $('body').on('click', '#btn-save', function(event) {
        event.preventDefault();
        var id = $("#id").val();
        var type = $("#type").val();
        var comment = $("#comment").val();
        var author = $("#author").val();
        var email = $("#email").val();
        var effect = $("#effect").val();
        var validated = $("#validated").val();
        $("#btn-save").html('Please Wait...');
        $("#btn-save").attr("disabled", true);
        // ajax
        $.ajax({
            type: "PUT",
            dataType: 'json',
            url: "update-comment/" + id,
            data: {
                type: type,
                comment: comment,
                author: author,
                email: email,
                effect: effect,
                validated: validated,
            },
            success: function(res) {
                //console.log(res);
                if (res.status == 400) {
                    $('#msgList').html("");
                    $('#msgList').addClass('alert alert-danger');
                    $.each(res.errors, function(key, err_value) {
                        $('#msgList').append('<li>' + err_value + '</li>');
                    });
                    $('#btn-save').text('Save changes');
                } else {
                    $('#message').html("");
                    $('#message').addClass('alert alert-success');
                    $('#message').text(res.message);
                    fetchComments();
                }
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

    //Retrieves all selected comments
    $("#btnGet").click(function() {
        var message = "";
        //Loop through all checked CheckBoxes in GridView.
        $("#Table1 input[type=checkbox]:checked").each(function() {
            var row = $(this).closest("tr")[0];
            // message += row.cells[2].innerHTML;
            message += row.cells[3].innerHTML + " ";
            // message += " " + row.cells[4].innerHTML;
            // message += "\n-----------------------\n";
        });
        //Display selected Row data in Alert Box.
        $("#messageList").html(message);
        return false;
    });

    //Copies all selected comments to clickboard
    $("#copy").click(function() {
        $("#messageList").select();
        document.execCommand("copy");
        alert("Copied On clipboard");
    });

    function isChecked() {
        $("#Table1 input[type=checkbox]").each(function() {
            if ($(this).val() == 1) {
                $(this).prop("checked", true);
            } else {
                $(this).prop("checked", false);
            }
        });
    }
});