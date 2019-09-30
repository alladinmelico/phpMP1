<?php

include ("includes/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $strRoleType = $_POST['strRoleType'];
    $lngRoleTypeID = $_POST['lngRoleTypeID'];
    
    $sql = "UPDATE tblRoleTypes SET strRoleType ='$strRoleType' WHERE lngRoleTypeID = '$lngRoleTypeID';";
    echo $sql;
    $result = mysqli_query( $conn,$sql);

    if ($result) {
        header("location: role.php?search=#");
    }
}
?>