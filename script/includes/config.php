<?php
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$conn = mysqli_connect($db_host,$db_username,$db_password) or die ("Could not connect!\n");

$db_name = "db_mp1";

mysqli_select_db($conn,$db_name) or die ("Could not select the Database $db_name!\n".mysqli_error());

?>