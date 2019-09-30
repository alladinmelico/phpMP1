<?php
    include "includes/config.php";
    $result = mysqli_query($conn, "DELETE FROM tblFilmCertificates WHERE lngCertificateID = " . $_GET['lngCertificateID']);

    mysqli_close( $conn );

    if ($result) {
        header("location: certificate.php?search=#");
    }
?>