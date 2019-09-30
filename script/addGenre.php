<?php
include ('header.php');
include ("includes/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pic = $_POST['pic'];
    $lngGenreID = $_POST['lngGenreID'];
    $lngFilmTitleID = $_POST['lngFilmTitleID'];
    
    $sql = "UPDATE tblfilmtitles SET lngGenreID = '$lngGenreID' WHERE lngFilmTitleID = '$lngFilmTitleID';";
    echo $sql;
    $result = mysqli_query( $conn,$sql);

    if ($result) {
        header("location: viewFilm.php?lngFilmTitleID=$lngFilmTitleID&filmPic=$pic");
    }
}

?>