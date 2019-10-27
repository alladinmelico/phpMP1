<?php 
include('header.php');
require('includes/config.php');

if (isset($_SESSION['userName']) AND isset($_SESSION['userPassword'])){
    $userName = mysqli_real_escape_string($conn,$_SESSION['userName']);
    $userPassword = mysqli_real_escape_string($conn,$_SESSION['userPassword']);
    
    if (($_SESSION['userName'] == "filmGuest") AND ($_SESSION['userPassword']) == "password"){
        header("location: login.php");
    } else
        {
            $sql = "SELECT * FROM USER ur
            WHERE ur.user = '$userName' AND ur.Password = PASSWORD('$userPassword')";

            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_array($result);

            $_SESSION['db_name'] = "db_mp1";

            if(($row[0] == NULL)){
                header("location: login.php");
            }
        }
} 

include('includes/navigation.php');
?>