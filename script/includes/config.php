<?php
if (!isset($_SESSION)){
    session_start();
}
$db_host = "localhost";
$db_username = "";
$db_password = "";
$db_name = "db_mp1";
$_SESSION['db_name'] = "db_mp1";
if (isset($_SESSION["userName"]) AND isset($_SESSION['userPassword']) AND isset($_SESSION['db_name']))
{
    $db_username = $_SESSION['userName'];
    $db_password = $_SESSION['userPassword'];
    $db_name = $_SESSION['db_name'];
}   else{
    $db_username = "root";
    $db_password = "";
    $db_name = "db_mp1";
}
$conn = mysqli_connect($db_host,$db_username,$db_password) or die ();

mysqli_select_db($conn,$db_name) or die ("Could not select the Database $db_name!\n".mysqli_error());

?>