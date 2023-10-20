<?php 

$link = mysqli_connect('localhost', 'root', '', 'mynotest_onlinenotes');
if(mysqli_connect_error()){
    die("Error: unable to connect".mysqli_connect_error());
}

?>