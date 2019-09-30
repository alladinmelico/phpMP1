<?php

include ("includes/config.php");
if ((!isset($_COOKIE['lngActorIDold'])) && !isset($_COOKIE['lngFilmTitleIDold']) && !isset($_COOKIE['lngProducerIDold'])) {
    echo "Cookies were is not set!";
} else {
    $lngActorIDold = $_COOKIE['lngActorIDold'];
    $lngFilmTitleIDold = $_COOKIE['lngFilmTitleIDold'];
    $lngProducerIDold = $_COOKIE['lngProducerIDold'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $strCharacterName = $_POST['strCharacterName'];
    $memCharaterDescription = $_POST['memCharaterDescription'];
    $lngActorID = $_POST['lngActorID'];
    $lngRoleTypeID = $_POST['lngRoleTypeID'];
    $lngFilmTitleID = $_POST['lngFilmTitleID'];
    $lngProducerID = $_POST['lngProducerID'];
    
    $sql = "UPDATE tblfilmsactorroles SET strCharacterName='$strCharacterName',memCharaterDescription='$memCharaterDescription',
        lngActorID='$lngActorID',lngRoleTypeID='$lngRoleTypeID',lngFilmTitleID='$lngFilmTitleID'
        WHERE lngActorID=$lngActorIDold AND lngFilmTitleID=$lngFilmTitleIDold;";
    echo $sql;
    $result = mysqli_query( $conn,$sql);

    $sql = "UPDATE tblfilmtitlesproducers SET lngFilmTitleID='$lngFilmTitleID', lngProducerID='$lngProducerID' 
    WHERE lngProducerID=$lngProducerIDold AND lngFilmTitleID=$lngFilmTitleIDold;";
    echo $sql;
    $result = mysqli_query( $conn,$sql);

    if ($result) {
        header("location: production.php?search=#");
    }
}
?>