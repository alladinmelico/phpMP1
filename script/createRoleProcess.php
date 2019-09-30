<?php

include ("includes/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $strRole = $_POST['strRoleType'];
    
    $sql = "INSERT INTO tblRoleTypes (strRoleType) VALUES ('$strRole');";
    echo $sql;
    $result = mysqli_query( $conn,$sql);

    if ($result) {
        header("location: role.php?search=#");
    }
}
?>