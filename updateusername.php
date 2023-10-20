<?php

session_start();
include("connection.php");

// get userid 
$id = $_SESSION['user_id'];

// get username
$username = $_POST['username'];

// run query and update username

$sql = "UPDATE users SET username ='$username' WHERE user_id = '$id'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo "<div class='alert alert-danger'>There was an error storing the new username in the database</div>";
    
}
