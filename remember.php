<?php
// <!-- if the user  is not logged in and remember me cookie exits  -->
if (!isset($_SESSION['user_id']) && !empty($_COOKIE['rememberme']) ){
    // array_key_exists('user_id', $_SESSION);
    //     <!-- extract authenticators 1 and 2 from the cookie  -->
    list($authenticator1, $authenticator2) = explode(',', $_COOKIE['rememberme']);
    $authenticator2 = hex2bin($authenticator2);
    // echo '<pre>'; print_r($_SESSION); echo '</pre>';
    // echo '<pre>'; print_r($_COOKIE); echo '</pre>';
    $f2authenticator2 = hash('sha256', $authenticator2);

    //     <!-- look for authenticator1 in the rememberme table  -->
    $sql = "SELECT * FROM rememberme WHERE authenticator1 = '$authenticator1'";
    $result = mysqli_query($link, $sql);

    if (!$result){
        echo "<div class = 'alert alert-danger'>Error running the query!</div>";
        exit;
    } 

    $count = mysqli_num_rows($result);
    // echo $count;
    if ($count !== 1) {
        echo "<div class = 'alert alert-danger'>Remember Me process failed!</div>";
        exit;
    }
    
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    // echo $row;
    //     <!-- if authenticator2 does not match  -->
    if (!hash_equals($row['f2authenticator2'], $f2authenticator2)){
        echo "<div class = 'alert alert-danger'>hash_equals returned false!</div>";
        exit;
    }else{
        //             <!-- generate new authenticators  -->
        //             <!-- store them in cookie and rememberme table  -->
        //             <!-- log the user in and redirect to notes page  -->
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
        $userid = $row['user_id'];
        $expiration = date('Y-m-d H:i:s', time() + 1296000);

        // run query to store them in rememberme table
        $sql = "INSERT INTO rememberme (`authenticator1`, `f2authenticator2` , `user_id`, `expires`) VALUES ('$authenticator1', '$f2authenticator2', '$userid', '$expiration')";
        $result = mysqli_query($link, $sql);
        //if query unsuccessful 
        if (!$result){
            //print error     
            echo "<div class = 'alert alert-danger'>Error running the query!</div>";
            // echo "<div class = 'alert alert-danger'>".mysqli_error($link)."</div>";
            exit;
        }

        $_SESSION['user_id'] = $row['user_id']; 
        header("location:main.php");
    }
} 