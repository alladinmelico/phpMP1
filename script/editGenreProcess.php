<?php

include ("includes/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $strGenre = $_POST['strGenre'];
    $lngGenreID = $_POST['lngGenreID'];
    
    $sql = "UPDATE tblFilmGenres SET strGenre ='$strGenre' WHERE lngGenreID = '$lngGenreID';";
    echo $sql;
    $result = mysqli_query( $conn,$sql);

    if ($result) {
        header("location: genre.php?search=#");
    }
}
?>