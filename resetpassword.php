<?php
    session_start();
    include('connection.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Password Reset</title>
    
    <style>
            h1{
                color:purple;   
            }
            .contactForm{
                margin: 50px auto auto auto;
            }
        </style> 


</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-offset-1 col-sm-10 contactForm">
                <h1>Reset Password</h1>
                <div id="resultmessage"></div>
                <?php
                // <!-- if user id or reset key is missing show an error  -->
                if (!isset($_GET['user_id']) || !isset($_GET['key'])) {
                    echo "<div class = 'alert alert-danger' >There was an error please click on the link you received by email.</div>";
                    exit;
                }
                // <!-- else -->
                //     <!-- store them in two variables -->
                $user_id = $_GET['user_id'];
                $key = $_GET['key'];
                $time = time() - 86400;
                //     <!-- prepare variables for the query -->
                $user_id = mysqli_real_escape_string($link, $user_id);
                $key = mysqli_real_escape_string($link, $key);
                //     <!-- run query:  -->
                $sql = "SELECT user_id FROM forgotpassword WHERE resetkey = '$key' AND user_id = '$user_id' AND time > '$time' AND status='pending'";
                $result = mysqli_query($link, $sql);
                //     <!-- if query is successful, show success message  -->
                if (!$result){
                    echo "<div class = 'alert alert-danger'>Error running the query!</div>";
                    exit;
                }

                // if the combination does not exist 
                // show error message
                $count = mysqli_num_rows($result);
                if ($count !== 1){
                    echo "<div class = 'alert alert-danger'>Please try again(reset page)!</div>";
                    exit;
                }

                // print reset password form with hidden user id and key fields
                echo 
                "<form method='post' id='passwordreset'>
                <input type='hidden' name='key' value=$key>
                <input type='hidden' name='user_id' value=$user_id>
                <div class='form-group'>
                    <label for='password'>Enter your new password:</label>
                    <input type='password' name='password' id='password' placeholder='Enter Password' clss='form-control'>
                </div>
                <div class='form-group'>
                    <label for='password2'>Re-enter password:</label>
                    <input type='password' name='password2' id='password2' placeholder='Re-enter Password' clss='form-control'>
                </div>
                <input type='submit' name='resetpassword' class='btn btn-success btn-lg' value='Reset Password'>
                </form>";
                


                ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- script for ajax call to storeresetpassword.php which processes form data  -->
    <script>
        $("#passwordreset").submit(function(event){
    //     prevent default php processing
        event.preventDefault();
        //     collect user inputs 
        var datatopost = $(this).serializeArray();
        // console.log(datatopost);
        //     send them to signup.php using ajax 
        $.ajax({
            url: "storeresetpassword.php",
            type: "POST",
            data: datatopost,
            //         ajax call successful: show error or success message
            success: function(data){
                $("#resultmessage").html(data);
            },
            //         ajax call fails: show ajax call error
            error: function(XMLHttpRequest, textStatus, errorThrown, data){
                $("#resultmessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later</div>");
                // console.log(XMLHttpRequest);
                // console.log(textStatus);
                // console.log(errorThrown);
                // console.log(data);
            }
        });
    });



    </script>



</body>

</html>