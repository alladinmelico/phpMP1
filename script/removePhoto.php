<?php
    include "includes/config.php";
    $results = mysqli_query($conn, "SELECT picture FROM tblactors WHERE lngActorID = " . $_GET['lngActorID']);
    $row = mysqli_fetch_array($results);
    unlink("../pictures/profile/". $row[0]);

    mysqli_free_result($results);
        mysqli_close( $conn );
?>