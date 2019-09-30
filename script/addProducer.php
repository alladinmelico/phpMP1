<?php
include ('header.php');
include ("includes/config.php");

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    $pic = $_GET['pic'];
    $lngProducerID = $_GET['lngProducerID'];
    $lngFilmTitleID = $_GET['lngFilmTitleID'];

    $sql = "DELETE FROM tblfilmtitlesproducers WHERE lngFilmTitleID = '$lngFilmTitleID' AND lngProducerID = '$lngProducerID';";
    echo $sql;
    $result = mysqli_query( $conn,$sql);

    if ($result) {
        header("location: viewFilm.php?lngFilmTitleID=$lngFilmTitleID&filmPic=$pic");
    }

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pic = $_POST['pic'];
    $lngProducerID = $_POST['lngProducerID'];
    $lngFilmTitleID = $_POST['lngFilmTitleID'];
    
    echo $pic;
    $sql = "INSERT INTO tblfilmtitlesproducers(lngFilmTitleID,lngProducerID) VALUES ('$lngFilmTitleID','$lngProducerID');";
    echo $sql;
    $result = mysqli_query( $conn,$sql);

    if ($result) {
        header("location: viewFilm.php?lngFilmTitleID=$lngFilmTitleID&filmPic=$pic");
    }
}

?>