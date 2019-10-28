<?php 
include('header.php');
$_SESSION['db_name'] = "mysql";
require('includes/config.php');
//DONE: directing to login
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

            echo $sql;
            echo $_SESSION['db_name'];

            $_SESSION['db_name'] = "db_mp1";

            if(($row[0] == NULL)){
                header("location: login.php");
            }
        }
} 
$_SESSION['db_name'] = "db_mp1";
include('includes/navigation.php');
?>