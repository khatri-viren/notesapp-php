// update username
$("#updateusernameform").submit(function(event){
    //     prevent default php processing
    event.preventDefault();
    //     collect user inputs 
    var datatopost = $(this).serializeArray();
    // console.log(datatopost);
    //     send them to signup.php using ajax 
    $.ajax({
        url: "updateusername.php",
        type: "POST",
        data: datatopost,
        //         ajax call successful: show error or success message
        success: function(data){
            if(data){
                $("#updateusernamemessage").html(data);
            }else{
                location.reload();
            }
        },
        //         ajax call fails: show ajax call error
        error: function(XMLHttpRequest, textStatus, errorThrown){
            $("#updateusernamemessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later</div>");
            // console.log(XMLHttpRequest);
            // console.log(textStatus);
            // console.log(errorThrown);
        }
    });
});


// update password
$("#updatepasswordform").submit(function(event){
    //     prevent default php processing
    event.preventDefault();
    //     collect user inputs 
    var datatopost = $(this).serializeArray();
    // console.log(datatopost);
    //     send them to signup.php using ajax 
    $.ajax({
        url: "updatepassword.php",
        type: "POST",
        data: datatopost,
        //         ajax call successful: show error or success message
        success: function(data){
            if(data){
                $("#updatepasswordmessage").html(data);
            }
        },
        //         ajax call fails: show ajax call error
        error: function(XMLHttpRequest, textStatus, errorThrown){
            $("#updatepasswordmessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later</div>");
            // console.log(XMLHttpRequest);
            // console.log(textStatus);
            // console.log(errorThrown);
        }
    });
});


// update email
$("#updateemailform").submit(function(event){
    //     prevent default php processing
    event.preventDefault();
    //     collect user inputs 
    var datatopost = $(this).serializeArray();
    // console.log(datatopost);
    //     send them to signup.php using ajax 
    $.ajax({
        url: "updateemail.php",
        type: "POST",
        data: datatopost,
        //         ajax call successful: show error or success message
        success: function(data){
            if(data){
                $("#updateemailmessage").html(data);
            }
        },
        //         ajax call fails: show ajax call error
        error: function(XMLHttpRequest, textStatus, errorThrown){
            $("#updateemailmessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later</div>");
            // console.log(XMLHttpRequest);
            // console.log(textStatus);
            // console.log(errorThrown);
        }
    });
});