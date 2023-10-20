<?php

session_start();
include("connection.php");

// get the user id
$user_id = $_SESSION['user_id'];

// run a query to delete empty notes
$sql = "DELETE FROM notes WHERE note=''";
$result = mysqli_query($link, $sql);
if (!$result) {
    echo "<div class='alert alert-warning'>An error occured!</div>";
    exit;
}

// run a query to look for notes corresponding to user id
$sql = "SELECT * FROM notes WHERE user_id ='$user_id' ORDER BY time DESC";

if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $note_id = $row['id'];
            $note = $row['note'];
            $time = $row['time'];
            $time = date("F d, Y h:i:s A", $time);
            echo "<div class='note row'>
            <div class='delete col-xs-5 col-sm-3'>
            <button class='btn-lg btn-danger' style='width:100%'>Delete</button>
            </div>
            <div class='noteheader' id='$note_id'>
            <div class='text'>$note</div>
            <div class='timetext'>$time</div>
            </div>
            </div>";
        }
    } else {
        echo  "<div class='alert alert-warning'>You haven't created any notes yet</div>";
    }
} else {
    echo "<div class='alert alert-warning'>An error occured!</div>";
    exit;
}


// shows notes or alert message
