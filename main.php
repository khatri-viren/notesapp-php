<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("location: index.php");
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
    <title>My Notes</title>
    <style>
        #container{
            margin-top: 100px;
        }

        #notePad, #allNotes, #done, .delete{
            display: none;
        }

        .buttons{
            margin-bottom: 20px;
        }

        textarea{
            width: 100%;
            max-width: 100%;
            font-size: 15px;
            line-height: 1.5em;
            border-left-width: 20px;
            border-color: #DEF5E5;
            padding: 10px;
        }

        .noteheader{
            border: 1px solid grey;
            border-radius: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            padding: 0 10px;
            width: 100%;
            background: linear-gradient(#FFFFFF, #ECEAE7);
        }

        .text{
            font-size: 20px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .timetext{
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
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
                    <a class="nav-link" href="profile.php">Profile <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Help</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
                <li class="nav-item active">
                    <a href="" class="nav-link">My Notes</a>
                </li>
            </ul>
            <!-- <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form> -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        Logged in as: <b><?php echo $_SESSION['username']?></b>
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
    <!-- Alert Message -->
    <div id="alert" class="alert alert-danger collapse">
        <a href="" class="close" data-dismiss="alert">&times;</a>
        <p id="alertContent"></p>
    </div>
        <div class="flex-row">
            <div class="d-flex justify-content-between buttons">
                <div class="left">
                    <button class="btn btn-info btn-lg" id="addNote">Add Note</button>
                    <button class="btn btn-info btn-lg" id="allNotes">All Notes</button>
                </div>
                <div class="right">
                    <button class="btn btn-info btn-lg" id="edit">Edit</button>
                    <button class="btn green btn-lg" id="done">Done</button>
                </div>
            </div>
        </div>
        <div id="notePad">
            <textarea cols="30" rows="10"></textarea>
        </div>
        <div id="notes" class="notes">
            <!-- Ajax call to a php file -->
        </div>
   </div>
 
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

    <script src="mynotes.js"></script>

</body>

</html>