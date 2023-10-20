<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("location: index.php");
}
include('connection.php');

$user_id = $_SESSION['user_id'];

//get username and email
$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);

$count = mysqli_num_rows($result);

if($count == 1){
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC); 
    $username = $row['username'];
    $email = $row['email']; 
}else{
    echo "There was an error retrieving the username and email from the database";   
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="loginpage.css">
    <title>Profile</title>
    <style>
        #container {
            margin-top: 100px;
        }

        #allNotes,
        #done {
            display: none;
        }

        .buttons {
            margin-bottom: 10px;
        }

        textarea {
            width: 100%;
            max-width: 100%;
            font-size: 15px;
            line-height: 1.5em;
            border-left-width: 20px;
            border-color: #DEF5E5;
            padding: 10px;
        }

        tr {
            cursor: pointer;
        }
    </style>
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
                <li class="nav-item">
                    <a class="nav-link active" href="profile.php">Profile <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Help</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
                <li class="nav-item">
                    <a href="main.php" class="nav-link">My Notes</a>
                </li>
            </ul>
            <!-- <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form> -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        Logged in as: <b><?php echo $username;?> </b>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?logout=1" class="nav-link">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Container -->
    <div class="container" id="container">
          <div class="row">
              <div class="col-md-offset-3 col-md-6">

                  <h2>General Account Settings:</h2>
                  <div class="table-responsive">
                      <table class="table table-hover table-condensed table-bordered">
                          <tr data-target="#updateusername" data-toggle="modal">
                              <td>Username</td>
                              <td><?php echo $username; ?></td>
                          </tr>
                          <tr data-target="#updateemail" data-toggle="modal">
                              <td>Email</td>
                              <td><?php echo $email ?></td>
                          </tr>
                          <tr data-target="#updatepassword" data-toggle="modal">
                              <td>Password</td>
                              <td>hidden</td>
                          </tr>
                      </table>
                  
                  </div>
              
              </div>
          </div>
      </div>
    <!--Update username-->
    <form method="post" id="updateusernameform">
        <div class="modal" id="updateusername" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="myModalLabel">
                            Edit Username:
                        </h4>
                        <button class="close" data-dismiss="modal">
                            &times;
                        </button>
                    </div>
                    <div class="modal-body">

                        <!--update username message from PHP file-->
                        <div id="updateusernamemessage"></div>


                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input class="form-control" type="text" name="username" id="username" maxlength="30" value="<?php echo $username; ?>">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input class="btn green" name="updateusername" type="submit" value="Submit">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--Update email-->
    <form method="post" id="updateemailform">
        <div class="modal" id="updateemail" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="myModalLabel">
                            Enter new email:
                        </h4>
                        <button class="close" data-dismiss="modal">
                            &times;
                        </button>
                    </div>
                    <div class="modal-body">

                        <!--Update email message from PHP file-->
                        <div id="updateemailmessage"></div>


                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input class="form-control" type="email" name="email" id="email" maxlength="50" value="<?php echo $email ?>">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input class="btn green" name="updateusername" type="submit" value="Submit">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--Update password-->
    <form method="post" id="updatepasswordform">
        <div class="modal" id="updatepassword" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="myModalLabel">
                            Enter Current and New password:
                        </h4>
                        <button class="close" data-dismiss="modal">
                            &times;
                        </button>
                    </div>
                    <div class="modal-body">

                        <!--Update password message from PHP file-->
                        <div id="updatepasswordmessage"></div>


                        <div class="form-group">
                            <label for="currentpassword" class="sr-only">Your Current Password:</label>
                            <input class="form-control" type="password" name="currentpassword" id="currentpassword" maxlength="30" placeholder="Your Current Password">
                        </div>
                        <div class="form-group">
                            <label for="password" class="sr-only">Choose a password:</label>
                            <input class="form-control" type="password" name="password" id="password" maxlength="30" placeholder="Choose a password">
                        </div>
                        <div class="form-group">
                            <label for="password2" class="sr-only">Confirm password:</label>
                            <input class="form-control" type="password" name="password2" id="password2" maxlength="30" placeholder="Confirm password">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input class="btn green" name="updateusername" type="submit" value="Submit">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- footer -->
    <div class="footer">
        <div class="container1">
            <p>Viren Khatri Copyright &copy; 2022-<?php $today = date("Y");
                                                    echo $today ?></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="profile.js"></script>
</body>

</html>