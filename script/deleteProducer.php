<?php
    include "includes/config.php";
    $result = mysqli_query($conn, "DELETE FROM tblProducers WHERE lngProducerID = " . $_GET['lngProducerID']);

    mysqli_close( $conn );

    if ($result) {
        header("location: ../index.php");
    }
?>