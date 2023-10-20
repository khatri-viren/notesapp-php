<?php
// <!-- start session  -->
session_start();
// <!-- connect to the database  -->
include("connection.php");

use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php';



// <!-- check user inputs  -->
//     <!-- define error messages  -->
$missingEmail = "<p>Please enter your email address!</p>";
$invalidEmail = "<p>Please enter a valid email address!</p>";

//     <!-- get email  -->
if (empty($_POST["forgotemail"])) {
    $errors .= $missingEmail;
} else {
    $email = filter_var($_POST["forgotemail"], 
    FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors .= $invalidEmail;
    }
}

//     <!-- tf there are any errors  -->
//         <!-- print error message  -->
if ($errors) {
    $resultMessage = "<div class = 'alert alert-danger'>$errors</div>";
    echo $resultMessage;
    exit;
}

//     <!-- else: no errors -->
//         <!-- prepare variabels for the query -->
$email = mysqli_real_escape_string($link, $email);

//         <!-- run query to check if the email exists in the user table  -->
//         <!-- if the email does not exist  -->
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($link, $sql); 
if (!$result){
    echo "<div class = 'alert alert-danger'>Error running the query!</div>";
    exit;
}
//             <!-- print error message  -->
$count = mysqli_num_rows($result);
if ($count != 1){
    echo "<div class = 'alert alert-danger'>That email does not exist on our database!</div>";
    exit;
}

//             <!-- get the user id  -->
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$user_id = $row['user_id'];
//             <!-- create a unique activation code  -->
$key = bin2hex(openssl_random_pseudo_bytes(16));
$time = time();
$status = 'pending';
//             <!-- insert user details and activation code in the forgorpassword table  -->
$sql = "INSERT INTO forgotpassword (`user_id`,`resetkey`,`time`,`status`) VALUES ('$user_id','$key','$time','$status')";
$result = mysqli_query($link, $sql); 
if (!$result){
    echo "<div class = 'alert alert-danger'>Error running the query!</div>";
    exit;
}

//             <!-- send email with link to resetpassword.php with user id and activation code  -->
$message = "Please click on this link to reset your password\n\n";
$projectRoot = "http://localhost/notesapp/";
$message .= $projectRoot . "resetpassword.php?user_id=$user_id&key=$key";

$mail = new PHPMailer(true);


$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'your username';                     //SMTP username
$mail->Password   = 'your password';                               //SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
$mail->Port       = 465;     
$mail->setFrom('vsk102002@gmail.com', 'Admin');
$mail->addAddress($email);               //Name is optional
$mail->isHTML(true);                                  //Set email format to HTML
$mail->Subject = 'Reset your Password';
$mail->Body    = $message;


if($mail->send()){
    //             <!-- if email sent successfully  -->
    //                 <!-- print success message  -->
    echo "<div class = 'alert alert-success'>An email has been sent to the provided address.</div>";
}else{
    echo "<div class = 'alert alert-danger'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
}



?>