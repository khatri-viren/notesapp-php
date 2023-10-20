<?php
//start session and connect
session_start();
include ('connection.php');
use PHPMailer\PHPMailer\PHPMailer;


//get user_id and new email sent through Ajax
$user_id = $_SESSION['user_id'];
$newemail = $_POST['email'];

//check if new email exists
$sql = "SELECT * FROM users WHERE email='$newemail'";
$result = mysqli_query($link, $sql);
$count = $count = mysqli_num_rows($result);
if($count>0){
    echo "<div class='alert alert-danger'>There is already as user registered with that email! Please choose another one!</div>"; exit;
}


//get the current email
$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);

$count = mysqli_num_rows($result);

if($count == 1){
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC); 
    $email = $row['email']; 
}else{
    echo "<div class='alert alert-danger'>There was an error retrieving the email from the database</div>";exit;   
}

//create a unique activation code
$activationKey = bin2hex(openssl_random_pseudo_bytes(16));

//insert new activation code in the users table
$sql = "UPDATE users SET activation2='$activationKey' WHERE user_id = '$user_id'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo "<div class='alert alert-danger'>There was an error inserting the user details in the database.</div>";exit;
}else{
    //send email with link to activatenewemail.php with current email, new email and activation code
    $message = "Please click on this link prove that you own this email:\n\n";
$message .= "http://localhost/notesapp/activatenewemail.php?email=" . urlencode($email) . "&newemail=" . urlencode($newemail) . "&key=$activationKey";

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'vsk102002@gmail.com';
$mail->Password   = 'mfvxmhbsnuudqibt';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Port = 465;
$mail->setFrom('vsk102002@gmail.com', 'Admin');

$mail->addAddress($newemail); 
$mail->isHTML(true);
$mail->Subject = 'Email Update for you Online Notes App';
$mail->Body = $message;


if($mail->send()){
    echo "<div class = 'alert alert-success'>Thank you for registering! A confirmation email has been sent to $newemail.Please click on the activation link to activate your account.</div>";
}else{
    echo "<div class = 'alert alert-danger'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
}    
}


?>