<?php
session_start();
$db_host = "localhost";
$db_username = "";
$db_password = "";

if (isset($_SESSION["userName"]))
{
    $db_username = $_SESSION['userName'];
    $db_password = $_SESSION['userPassword'];
} else 
{
    $db_username = "filmGuest";
    $db_password = "password";
}
$conn = mysqli_connect($db_host,$db_username,$db_password) or die ("Could not connect!\n");

$db_name = "db_mp1";

mysqli_select_db($conn,$db_name) or die ("Could not select the Database $db_name!\n".mysqli_error());

?>