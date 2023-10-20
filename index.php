<?php 
    session_start();
    include("connection.php");

    // logout
    include("logout.php");

    //remember me
    include("remember.php");

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="loginpage.css">
    <title>Notes App</title>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Online Notes</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Help</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>
            <!-- <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form> -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="#loginmodal" data-toggle="modal" class="nav-link">Login</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Jumbotron  with sign up button -->
    <div class="jumbotron" id="myContainer">
        <h1>Online Notes App</h1>
        <p>Your Notes with you wherever you go</p>
        <p>Easy to use, protects all your notes!</p>
        <button type="button" class="btn btn-lg signup green" data-target="#signupmodal" data-toggle="modal">Sign Up</button>
    </div>


    <!-- Login form -->
    <form action="" method="post" id="loginform">
        <div class="modal" id="loginmodal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="myModalLabel">
                            Login:
                        </h4>
                        <button class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="loginmessage">
                            <!-- Login message from PHP file -->
                        </div>                  
                        <div class="form-group">
                            <label for="loginemail" class="sr-only">Email:</label>
                            <input type="email" id="loginemail" class="form-control" name="loginemail" placeholder="Email Address" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label for="loginpassword" class="sr-only">Password:</label>
                            <input type="password" id="loginpassword" class="form-control" name="loginpassword" placeholder="Choose a Password" maxlength="30">
                        </div>
                        <div class="checkbox d-flex justify-content-between">
                            <label >
                                <input type="checkbox" name="rememberme" id="rememberme">
                                Remember me
                            </label>
                            <a data-dismiss="modal" data-target="#forgotpasswordmodal" data-toggle="modal" style="cursor: pointer;">
                                Forgot Password?
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between flex-row">
                        <div class="leftside">
                            <button type="button" value="Register" class="btn btn-default" data-target="signupmodal" data-toggle="modal">
                                Register
                            </button>
                        </div>
                        <div class="rightside d-inline">
                            <input type="submit" class="btn green" name="login" value="Login">
                            <button type="button" value="Cancel" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <!-- sign up form -->
    <form action="" method="post" id="signupform">
        <div class="modal" id="signupmodal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="myModalLabel">
                            Sign up today and Start using our Online Notes App
                        </h4>
                        <button class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="signupmessage">
                            <!-- Sign Up message from PHP file -->
                        </div>
                        <div class="form-group">
                            <label for="username" class="sr-only">Username:</label>
                            <input type="text" id="username" class="form-control" name="username" placeholder="Username" maxlength="30">
                        </div>
                        <div class="form-group">
                            <label for="email" class="sr-only">Email:</label>
                            <input type="email" id="email" class="form-control" name="email" placeholder="Email Address" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label for="password" class="sr-only">Choose a Password:</label>
                            <input type="password" id="password" class="form-control" name="password" placeholder="Choose a Password" maxlength="30">
                        </div>
                        <div class="form-group">
                            <label for="password2" class="sr-only">Confirm Password:</label>
                            <input type="password" id="password2" class="form-control" name="password2" placeholder="Choose a Password" maxlength="30">
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn green" name="signup" value="Sign Up">
                        <button type="button" value="Cancel" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- forget password form -->
    <form action="" method="post" id="forgotpasswordform">
        <div class="modal" id="forgotpasswordmodal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="myModalLabel">
                            Forgot Password? Enter your email address:
                        </h4>
                        <button class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="forgotpasswordmessage">
                            <!-- Forgot Password message from PHP file -->
                        </div>                  
                        <div class="form-group">
                            <label for="forgotemail" class="sr-only">Email:</label>
                            <input type="email" id="forgotemail" class="form-control" name="forgotemail" placeholder="Email Address" maxlength="50">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between flex-row">
                        <div class="leftside">
                            <button type="button" value="Register" class="btn btn-default" data-target="signupmodal" data-toggle="modal">
                                Register
                            </button>
                        </div>
                        <div class="rightside d-inline">
                            <input type="submit" class="btn green" name="forgotpassword" value="Submit">
                            <button type="button" value="Cancel" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- footer -->
    <div class="footer">
        <div class="container">
            <p>Viren Khatri Copyright &copy; 2022-<?php $today = date("Y"); echo $today?></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="index.js"></script>

</body>

</html>