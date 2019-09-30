<?php

include ("includes/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $strCharacterName = $_POST['strCharacterName'];
    $memCharaterDescription = $_POST['memCharaterDescription'];
    $lngActorID = $_POST['lngActorID'];
    $lngRoleTypeID = $_POST['lngRoleTypeID'];
    $lngFilmTitleID = $_POST['lngFilmTitleID'];
    $lngProducerID = $_POST['lngProducerID'];
    
    $sql = "INSERT INTO tblfilmsactorroles(strCharacterName,memCharaterDescription,lngActorID,lngRoleTypeID,lngFilmTitleID) 
        VALUES ('$strCharacterName','$memCharaterDescription','$lngActorID','$lngRoleTypeID','$lngFilmTitleID');";
    echo $sql;
    $result = mysqli_query( $conn,$sql);

    $sql = "INSERT INTO tblfilmtitlesproducers(lngFilmTitleID,lngProducerID) 
        VALUES ('$lngFilmTitleID','$lngProducerID');";
    echo $sql;
    $result = mysqli_query( $conn,$sql);

    if ($result) {
        header("location: production.php?search=#");
    }
}
?>