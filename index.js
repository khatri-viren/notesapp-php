// Ajax call for the sign up form
// once the form is submitted 
$("#signupform").submit(function(event){
    //     prevent default php processing
    event.preventDefault();
    //     collect user inputs 
    var datatopost = $(this).serializeArray();
    // console.log(datatopost);
    //     send them to signup.php using ajax 
    $.ajax({
        url: "signup.php",
        type: "POST",
        data: datatopost,
        //         ajax call successful: show error or success message
        success: function(data){
            if(data){
                $("#signupmessage").html(data);
            }
        },
        //         ajax call fails: show ajax call error
        error: function(XMLHttpRequest, textStatus, errorThrown){
            $("#signupmessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later</div>");
            // console.log(XMLHttpRequest);
            // console.log(textStatus);
            // console.log(errorThrown);
        }
    });
});

// ajax call for the login form
// once the form is submitted
$("#loginform").submit(function(event){
    //     prevent default php processing
    event.preventDefault();
    //     collect user inputs 
    var datatopost = $(this).serializeArray();
    // console.log(datatopost);
    //     send them to signup.php using ajax 
    $.ajax({
        url: "login.php",
        type: "POST",
        data: datatopost,
        //         ajax call successful: show error or success message
        success: function(data){
            // console.log(data);
            if(data == "success"){
                window.location = "main.php";
            }else{
                $("#loginmessage").html(data);
            }
        },
        //         ajax call fails: show ajax call error
        error: function(XMLHttpRequest, textStatus, errorThrown, data){
            $("#loginmessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later</div>");
            // console.log(XMLHttpRequest);
            // console.log(textStatus);
            // console.log(errorThrown);
            // console.log(data);
        }
    });
});


//     presevent default php processing
//     collect user inputs 
//     send then to login.php using ajax
//         ajax call successful
//             if php files returns "success": redirect the user to notes page
//             otherwise show error message
//         ajax call fails: show ajax call error


// ajax call for the forgot password form
// once the form is submitted
//     prevent default php processing
//     collect user inputs
//     send them to login.php using ajax
//         ajax call successful: show error or success message
//         ajax call fail:   show ajax call error
$("#forgotpasswordform").submit(function(event){
    //     prevent default php processing
    event.preventDefault();
    //     collect user inputs 
    var datatopost = $(this).serializeArray();
    console.log(datatopost);
    //     send them to signup.php using ajax 
    $.ajax({
        url: "forgot-password.php",
        type: "POST",
        data: datatopost,
        //         ajax call successful: show error or success message
        success: function(data){
            $("#forgotpasswordmessage").html(data);
        },
        //         ajax call fails: show ajax call error
        error: function(XMLHttpRequest, textStatus, errorThrown, data){
            $("#forgotpasswordmessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later</div>");
            // console.log(XMLHttpRequest);
            // console.log(textStatus);
            // console.log(errorThrown);
            // console.log(data);
        }
    });
});