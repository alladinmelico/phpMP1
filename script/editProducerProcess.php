<?php

include ("includes/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lngProducerID = $_POST['lngProducerID'];
    $strProducerName = $_POST['strProducerName'];
    $hypContactEmailAddress = $_POST['hypContactEmailAddress'];
    $hypWebsite = $_POST['hypWebsite'];

    $sql = "UPDATE tblProducers SET strProducerName='$strProducerName',
        hypContactEmailAddress='$hypContactEmailAddress',hypWebsite='$hypWebsite' WHERE lngProducerID =$lngProducerID;";
    echo $sql;
    $result = mysqli_query( $conn,$sql);

    if ($result) {
        header("location: producer.php?search=#");
    }
}
?>