$(function(){
    //define variables 
    var activeNote = 0;
    var editMode = false;
    // load notes on page load : ajax call to loadnotes.php
    $.ajax({
        url: "loadnotes.php",
        success: function(data){
            $('#notes').html(data);
            clickonNote();
            clickonDelete();
        },
        error: function(){
            $('#alertContent').text("There was an error with the AJAX call!");
            $('#alert').fadeIn();
        }
    });
    // creating a new note: ajax call to createnote.php
    $('#addNote').click(function(){
        $.ajax({
            url: "createnote.php",
            success: function(data){
                if(data == 'error'){
                    $('#alertContent').text("There was an issue inserting the new note in the database!");
                    $('#alert').fadeIn();
                }else{
                    // update activeNote to the id of the new note
                    activeNote = data;
                    $("textarea").val("");
                    // show hide element
                    showHide(["#notePad", "#allNotes"], ["#notes", "#addNote", "#edit", "#done"]);
                    $("textarea").focus();
                }
            },
            error: function(){
                $('#alertContent').text("There was an error with the AJAX call!");
                $('#alert').fadeIn();
            }

        });
    });

    // click on all notes button
    $("#allNotes").click(function(){
        $.ajax({
            url: "loadnotes.php",
            success: function(data){
                $('#notes').html(data);
                showHide(["#addNote", "#edit", "#notes"], ["#allNotes", "#notePad"]);
                clickonNote();
                clickonDelete();
            },
            error: function(){
                $('#alertContent').text("There was an error with the AJAX call!");
                $('#alert').fadeIn();
            }
        });
    });


    // typing note: ajax call to updatenote.php
    $("textarea").keyup(function(){
        // ajax call to update the task of id activenote
        $.ajax({
            url: "updatenote.php",
            type: "POST",
            // we need to send the current note content with its id to the php file
            data: {note: $(this).val(), id: activeNote},
            success: function(data){
                if(data == 'error'){
                    $('#alertContent').text("There was an updating the note in the database!");
                    $('#alert').fadeIn();
                }
            },
            error: function(){
                $('#alertContent').text("There was an error with the AJAX call!");
                $('#alert').fadeIn();
            }
        });
    });


    // click on the done button after editing: load notes again
    $("#done").click(function(){
        editMode = false;
        $(".noteheader").removeClass("col-xs-7 col-sm-9");
        showHide(["#edit"], ["#done", ".delete"]);
    });


    // click on edit: go to the edit mode (show delete buttons)
    $("#edit").click(function(){
        editMode = true;
        // reduce the width of notes
        $(".noteheader").addClass("col-xs-7 col-sm-9");
        showHide(["#done", ".delete"], [this]);
    });
    
    // functions
    // click on a note
    function clickonNote(){
        $(".noteheader").click(function(){
            if(!editMode){
                // update activenote variable to id of note
                activeNote = $(this).attr('id');
                // fill text area
                $("textarea").val($(this).find('.text').text());
                // show hide elements
                showHide(["#notePad", "#allNotes"], ["#notes" , "#addNote", "#edit", "#done"]);
                $("textarea").focus();
            }
        });

    }

    // click on delete
    function clickonDelete(){
        $(".delete").click(function(){
            var deleteButton = $(this);
            $.ajax({
                url: "deletenote.php",
                type: "POST",
                // we need to send the id of teh note to be deleted
                data: {id:deleteButton.next().attr("id")},
                success: function(data){
                    if(data == 'error'){
                        $('#alertContent').text("There was an deleting the note from the database!");
                        $('#alert').fadeIn();
                    }else{
                        // remove containing div
                        deleteButton.parent().remove();
                    }
                },
                error: function(){
                    $('#alertContent').text("There was an error with the AJAX call!");
                    $('#alert').fadeIn();
                }
            });
        });
    }



    // show hide function
    function showHide(array1, array2){
        for(i=0; i<array1.length; i++){
            $(array1[i]).show();
        }
        for(i=0; i<array2.length; i++){
            $(array2[i]).hide();
        }
    }
});