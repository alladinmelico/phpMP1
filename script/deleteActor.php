<?php
include ('removePhoto.php');
    include "includes/config.php";
    $result = mysqli_query($conn, "DELETE FROM tblactors WHERE lngActorID = " . $_GET['lngActorID']);

    mysqli_close( $conn );

    if ($results) {
        header("location: actor.php?search=#");
    }
?>