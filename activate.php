<?php
    // <!-- the user is redirected to this file after clicking the activation link -->
    // <!-- signup link contains two get parameters: email and activation key -->
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
    <title>Account Activation</title>
    
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
                <h1>Account Activation</h1>
                <?php
                // <!-- if email or activation key is missing show an error  -->
                if (!isset($_GET['email']) || !isset($_GET['key'])) {
                    echo "<div class = 'alert alert-danger' >There was an error please click on the activation link you received by email.</div>";
                    exit;
                }
                // <!-- else -->
                //     <!-- store them in two variables -->
                $email = $_GET['email'];
                $key = $_GET['key'];
                //     <!-- prepare variables for the query -->
                $email = mysqli_real_escape_string($link, $email);
                $key = mysqli_real_escape_string($link, $key);
                //     <!-- run query: set activation field to "activated" for the provided email -->
                $sql = "UPDATE users SET activation='activated' WHERE (email='$email' AND activation='$key')";
                $result = mysqli_query($link, $sql);
                //     <!-- if query is successful, show success message and invite user to login -->
                if (mysqli_affected_rows($link) == 1) {
                    echo "<div class = 'alert alert-success'>Your account has been activated</div>";
                    echo "<a href = 'index.php' type='button' class='btn-lg btn-success'>Log in</a>";
                } else {
                    //     <!-- else -->
                    //         <!-- show error message -->
                    echo "<div class = 'alert alert-danger'>Your account could not be activated. Please try again later </div>";
                    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
                    exit;
                }

                ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>