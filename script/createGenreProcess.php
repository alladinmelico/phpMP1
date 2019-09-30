<?php

include ("includes/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $strGenre = $_POST['strGenre'];
    
    $sql = "INSERT INTO tblFilmGenres(strGenre) VALUES ('$strGenre');";
    echo $sql;
    $result = mysqli_query( $conn,$sql);

    if ($result) {
        header("location: genre.php?search=#");
    }
}
?>