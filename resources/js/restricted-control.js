//Script for ajax-restricted-comment-crud.blade.php 

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
                            <td>\
                            </td>\
                            </tr>');    // 'Edit' and 'Delete' buttons are removed as restricted controls
                    }
                });
            },
            complete: function() {
                isChecked();
            }
        });
    }

    // Sorts comments by order of 'ID' when selected
    $('#btnID').click(function(evt) {
        fetchComments();
    })

    // Sorts comments by order of 'Type' when selected
    $('#btnType').click(function(evt) {
        // ajax
        $.ajax({
            type: "GET",
            url: "fetch-comments-by-type", //Makes call to controller to orderBy type
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
                            <td>\
                            </td>\
                            </tr>');    // 'Edit' and 'Delete' buttons are removed as restricted controls
                    }
                });
            },
            complete: function() {
                isChecked();
            }
        });
    })

    
    //Calls ajax comment bootstrap model when 'Suggest Comment' button clicked
    $('#suggestNewComment').click(function(evt) {
        evt.preventDefault();
        $('#addEditCommentForm').trigger("reset");
        $('#ajaxCommentModel').html("Add Comment");
        $('#btn-add').show();
        $('#btn-save').hide();
        $('#ajax-comment-model').modal('show');
    });

    //Posts new SUGGESTED comment data to controller when 'Save' button clicked or re-enter if invalid
    $('body').on('click', '#btn-add', function(event) {
        event.preventDefault();
        var type = $("#type").val();
        var comment = $("#comment").val();
        var author = $("#author").val();
        var email = $("#email").val();
        var effect = $("#effect").val();
        $("#btn-add").html('Please Wait...');
        $("#btn-add").attr("disabled", true);
        // ajax
        $.ajax({
            type: "POST",
            url: "save-comment",
            data: {
                type: type,
                comment: comment,
                author: author,
                email: email,
                effect: effect,
                validated: 0, //'Validated' forced to unapproved(0) as suggested comment can only be approved(1) when reviewed by admin  
            },
            dataType: 'json',
            success: function(res) {
                console.log(res);
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