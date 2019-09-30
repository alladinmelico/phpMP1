<?php
    include "includes/config.php";
    $result = mysqli_query($conn, "DELETE FROM tblFilmGenres WHERE lngGenreID = " . $_GET['lngGenreID']);

    mysqli_close( $conn );

    if ($result) {
        header("location: genre.php?search=#");
    }
?>