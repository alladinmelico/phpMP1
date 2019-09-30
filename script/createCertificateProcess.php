<?php

include ("includes/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $strCertificate = $_POST['strCertificate'];
    
    $sql = "INSERT INTO tblFilmCertificates(strCertificate) VALUES ('$strCertificate');";
    echo $sql;
    $result = mysqli_query( $conn,$sql);

    if ($result) {
        header("location: certificate.php?search=#");
    }
}
?>