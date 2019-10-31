<?php
if (!isset($_SESSION)){
    session_start();
}
$db_host = "localhost";
$db_username = "";
$db_password = "";
$db_name = "db_mp1";
$_SESSION['db_name'] = "db_mp1";
if (isset($_SESSION["userName"]) OR isset($_SESSION['userPassword']) OR isset($_SESSION['db_name']))
{
    $db_username = $_SESSION['userName'];
    $db_password = $_SESSION['userPassword'];
    $db_name = $_SESSION['db_name'];
}   
$conn = mysqli_connect($db_host,$db_username,$db_password) or die (header("location: login.php"));

mysqli_select_db($conn,$db_name) or die ("Could not select the Database $db_name!\n".mysqli_error());

?>