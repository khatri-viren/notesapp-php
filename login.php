<?php
// <!-- start session
// connect to the database -->
// <!-- start session -->
session_start();
// <!-- connect to the database -->
include('connection.php');

// filtering the data
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// check user inputs
// define error messages
$missingEmail = "<p>Please enter your email address</p>";
$missingPassword = "<p>Please enter your password</p>";
// get email and password
// store errors in errors variable
if (empty($_POST["loginemail"])) {
    $errors .= $missingEmail;
} else {
    $email = filter_var(
        $_POST["loginemail"],
        FILTER_SANITIZE_EMAIL
    );
}

if (empty($_POST["loginpassword"])) {
    $errors .= $missingPassword;
} else {
    $password = test_input($_POST["loginpassword"]);
}

// if there are any errors
if ($errors) {
    $resultMessage = "<div class = 'alert alert-danger'>$errors</div>";
    //     print error message
    echo $resultMessage;
    exit;
} 
// else: no errors  
//     prepare variables for the query 
$email = mysqli_real_escape_string($link, $email);
$password = mysqli_real_escape_string($link, $password);
$password = hash('sha256', $password);
//     run query: check combination of email and password exits 
$sql = "SELECT * from users WHERE (email='$email' AND password='$password' AND activation='activated')";
$result = mysqli_query($link, $sql);

if (!$result) {
    echo "<div class = 'alert alert-danger'>Error running the query!</div>";
    // echo "<div class = 'alert alert-danger'>".mysqli_error($link)."</div>";
    exit;
}

//     if email and password don't match print error 
$count = mysqli_num_rows($result);
if ($count !== 1) {
    echo "<div class = 'alert alert-danger'>Wrong Username or Password!</div>";
} else {
    //     else
    //         log the user in: set session variable 
    //         if remember me is not checked 
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['email'] = $row['email'];

    //         print success 
    if (isset($_POST['rememberme'])) {
        //else 
        //  create two variables $authenticator1 and $authenticator2 
        $authenticator1 = bin2hex(openssl_random_pseudo_bytes(10));
        $authenticator2 = openssl_random_pseudo_bytes(20);
        //store them in a cookie
        function f1($a, $b){
            $c = $a . "," . bin2hex($b);
            return $c;
        }

        $cookieValue = f1($authenticator1, $authenticator2);
        setcookie(
            "rememberme",
            $cookieValue,
            time() + 1296000
        );

        function f2($a){
            $a = hash('sha256', $a);
            return $a;
        }

        $f2authenticator2 = f2($authenticator2);
        $user_id = $_SESSION['user_id'];
        $expiration = date('Y-m-d H:i:s', time() + 1296000);

        // run query to store them in rememberme table
        $sql = "INSERT INTO rememberme (`authenticator1`, `f2authenticator2` , `user_id`, `expires`) VALUES ('$authenticator1', '$f2authenticator2', '$user_id', '$expiration')";
        $result = mysqli_query($link, $sql);
        //if query unsuccessful 
        if (!$result){
            //print error     
            echo "<div class = 'alert alert-danger'>Error running the query!</div>";
            // echo "<div class = 'alert alert-danger'>".mysqli_error($link)."</div>";
        } else{ 
            echo "success" ;
        }
    } else {
        echo "success";
    }
}

