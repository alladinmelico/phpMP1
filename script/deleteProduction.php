<?php
    include "includes/config.php";
    $result = mysqli_query($conn, "DELETE FROM tblfilmsactorroles
         WHERE lngFilmTitleID = " . $_GET['lngFilmTitleID']);
    $result = mysqli_query($conn, "DELETE FROM tblfilmtitlesproducers
    WHERE lngFilmTitleId = " . $_GET['lngFilmTitleID']);

    mysqli_close( $conn );

    if ($result) {
        header("location: production.php?search=#");
    }
?>