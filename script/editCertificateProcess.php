<?php

include ("includes/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $strCertificate = $_POST['strCertificate'];
    $lngCertificateID = $_POST['lngCertificateID'];
    
    $sql = "UPDATE tblFilmCertificates SET strCertificate ='$strCertificate' WHERE lngCertificateID = '$lngCertificateID';";
    echo $sql;
    $result = mysqli_query( $conn,$sql);

    if ($result) {
        header("location: certificate.php?search=#");
    }
}
?>