<?php
    include "includes/config.php";
    $result = mysqli_query($conn, "DELETE FROM tblRoleTypes WHERE lngRoleTypeID = " . $_GET['lngRoleTypeID']);

    mysqli_close( $conn );

    if ($result) {
        header("location: role.php?search=#");
    }
?>