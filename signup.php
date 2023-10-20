<?php
// <!-- start session -->
session_start();
// <!-- connect to the database -->
include('connection.php');

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

// <!-- check user inputs -->
//     <!-- define error messages -->
$missingUsername = "<p>Please enter a username!</p>";
$missingEmail = "<p>Please enter your email address!</p>";
$invalidEmail = "<p>Please enter a valid email address!</p>";
$missingPassword = "<p>Please enter a Password!</p>";
$invalidPassword = "<p>Your password should be at least 6 characters long and include one capital letter and one number!</p>";
$differentPassword = "<p>Passwords don\'t match!</p>";
$missingPassword2 = "<p>Please confirm your password!</p>";

// filtering the data
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
//     <!-- get username, email, passowrd, password2 -->
// get username
if (empty($_POST["username"])) {
    $errors .= $missingUsername;
} else {
    $username = test_input($_POST["username"]);
}

// get email
if (empty($_POST["email"])) {
    $errors .= $missingEmail;
} else {
    $email = filter_var($_POST["email"], 
    FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors .= $invalidEmail;
    }
}

// get password 
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
//     <!-- store errors in errors variable -->
//     <!-- if there are any error print error -->
if ($errors) {
    $resultMessage = "<div class = 'alert alert-danger'>$errors</div>";
    echo $resultMessage;
    exit;
}

// <!-- no errors -->
//     <!-- prepare variables for the queries -->
$username = mysqli_real_escape_string($link, $username);
$email = mysqli_real_escape_string($link, $email);
$password = mysqli_real_escape_string($link, $password);
// $password = md5($password);
$password = hash('sha256', $password);

//     <!-- if username exits in the users table print error -->
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($link, $sql);
if (!$result){
    echo "<div class = 'alert alert-danger'>Error running the query!</div>";
    // echo "<div class = 'alert alert-danger'>".mysqli_error($link)."</div>";
    exit;
}
$results = mysqli_num_rows($result);
if ($results){
    echo "<div class = 'alert alert-danger' >That username is already registered. Do you want to log in? </div>";
    exit;
}

//     <!-- else -->
//         <!-- if email exists in the users table print error -->
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($link, $sql); 
if (!$result){
    echo "<div class = 'alert alert-danger'>Error running the query!</div>";
    exit;
}
$results = mysqli_num_rows($result);
if ($results){
    echo "<div class = 'alert alert-danger'>That email is already registered. Do you want to log in? </div>";
    exit;
}

//         <!-- else -->
//             <!-- create  a unique activation code -->
$activationkey = bin2hex(openssl_random_pseudo_bytes(16));

//             <!-- insert user details and activation code in the users table -->
$sql = "INSERT INTO users (`username`, `email`, `password`, `activation`) VALUES ('$username', '$email', '$password', '$activationkey')";

$result = mysqli_query($link, $sql);
if (!$result){
    echo "<div class = 'alert alert-danger'>There was an error inserting the user details in the databse!</div>";
    exit;
}

// <!-- send the user an email with a link to activate.php with their email and activation code -->
$message = "Please click on this link to activate your account\n\n";
$projectRoot = "http://localhost/notesapp/";
$message .= $projectRoot . "activate.php?email=" . urlencode($email) . "&key=$activationkey";
// if(mail($email, 'Confirm your registration', $message , 'From:'.'developmentisland@gmail.com')){
//     echo "<div class = 'alert alert-success'>Thank you for registering! A confirmation email has been sent to $email.Please click on the activation link to activate your account.</div>";
// }

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);


//Server settings
// $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output

//Server settings
// $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'vsk102002@gmail.com';                     //SMTP username
$mail->Password   = 'mfvxmhbsnuudqibt';                               //SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

//Recipients
$mail->setFrom('vsk102002@gmail.com', 'Admin');
// $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
$mail->addAddress($email);               //Name is optional
// $mail->addReplyTo('info@example.com', 'Information');
// $mail->addCC('cc@example.com');
// $mail->addBCC('bcc@example.com');

//Attachments
// $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

//Content
$mail->isHTML(true);                                  //Set email format to HTML
$mail->Subject = 'Confirm your Registration';
$mail->Body    =$message;
// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if($mail->send()){
    echo "<div class = 'alert alert-success'>Thank you for registering! A confirmation email has been sent to $email.Please click on the activation link to activate your account.</div>";
}else{
    echo "<div class = 'alert alert-danger'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
}

    
?>
