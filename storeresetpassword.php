<?php
session_start();
include('connection.php');

if (!isset($_POST['user_id']) || !isset($_POST['key'])) {
    echo "<div class = 'alert alert-danger' >There was an error please click on the link you received by email.</div>";
    exit;
}
// <!-- else -->
//     <!-- store them in two variables -->
$user_id = $_POST['user_id'];
$key = $_POST['key'];
$time = time() - 86400;
//     <!-- prepare variables for the query -->
$user_id = mysqli_real_escape_string($link, $user_id);
$key = mysqli_real_escape_string($link, $key);
//     <!-- run query:  -->
$sql = "SELECT user_id FROM forgotpassword WHERE resetkey = '$key' AND user_id = '$user_id' AND time > '$time' AND status = 'pending' ";
$result = mysqli_query($link, $sql);
// while ($row = $result->fetch_assoc()) {
//     echo $row['resetkey']."<br>";
// }
//     <!-- if query is successful, show success message  -->
if (!$result){
    echo "<div class = 'alert alert-danger'>Error running the query!</div>";
    exit;
}

// if the combination does not exist 
// show error message
$count = mysqli_num_rows($result);
// echo $count;
if ($count !== 1){
    echo "<div class = 'alert alert-danger'>Please try again(store page)!</div>";
    exit;
}

// define error messages
$missingPassword = "<p>Please enter a Password!</p>";
$invalidPassword = "<p>Your password should be at least 6 characters long and include one capital letter and one number!</p>";
$differentPassword = "<p>Passwords don\'t match!</p>";
$missingPassword2 = "<p>Please confirm your password!</p>";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// get passwords
if (empty($_POST["password"])) {
    $errors .= $missingPassword;
} elseif (
    !(strlen($_POST["password"]) > 6
        and preg_match('/[A-Z]/', $_POST["password"])
        and preg_match('/[0-9]/', $_POST["password"]))
) {
    $errors .= $invalidPassword;
} else {
    $password = test_input($_POST["password"]);
    if (empty($_POST["password2"])) {
        $errors .= $missingPassword2;
    } else {
        $password2 = test_input($_POST["password2"]);
        if ($password !== $password2) {
            $errors .= $differentPassword;
        }
    }
}

if ($errors) {
    $resultMessage = "<div class = 'alert alert-danger'>$errors</div>";
    echo $resultMessage;
    exit;
}


$password = mysqli_real_escape_string($link, $password);
$user_id = mysqli_real_escape_string($link, $user_id);
$password = hash('sha256', $password);

$sql = "UPDATE users SET password='$password' WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);
if (!$result){
    echo "<div class = 'alert alert-danger'>There was a problem storing the new password!</div>";
    // echo "<div class = 'alert alert-danger'>".mysqli_error($link)."</div>";
    exit;
}
// set the key status to used in the forgotpassword table to prevent the key from being used twice
$sql = "UPDATE forgotpassword SET status='used' WHERE resetkey='$key' AND user_id='$user_id'";
$result = mysqli_query($link, $sql);
if (!$result){
    echo "<div class = 'alert alert-danger'>There was a problem updating the status!</div>";
    // echo "<div class = 'alert alert-danger'>".mysqli_error($link)."</div>";
    exit;
}else{
    echo "<div class = 'alert alert-success'>Your password has been updated successfully!
    <a href='index.php'>Login</a></div>";

}


// this file receives: user_id, generated key to reset password, password1 and password2 
// this file then resets password for user_id if all checks are correct

// if userid or activation key is missing
// print error message
// store them in two variables
// define a time variable: now minus 24 hours
// prepare variables for the query 
// run query: check combination of userid and key exists and less than 24 hour old
// if combination does not exist
// print error message
// else 
// define error messages
// 