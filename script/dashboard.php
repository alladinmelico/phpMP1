<?php 
include('header.php');
require('includes/config.php');
include('includes/navigation.php');

if (isset($_SESSION['userName']) AND isset($_SESSION['userPassword'])){
    if (($_SESSION['userName'] == "filmGuest") AND ($_SESSION['userPassword']) == "password"){
        header("location: login.php");
    }
} else {
    header("location: login.php");
}
echo $_SESSION['userName'];
echo $_SESSION['userPassword'];
?>