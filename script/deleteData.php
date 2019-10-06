<?php 

require ("includes/config.php");

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    $location = "";
    $result;
    if (isset($_GET['lngActorID']))
    {
        require ('removePhoto.php');
        $result = mysqli_query($conn, "DELETE FROM tblactors WHERE lngActorID = " . $_GET['lngActorID']);
        echo "DELETE FROM tblactors WHERE lngActorID = " . $_GET['lngActorID'];
        $location = "actor.php?search=#";
        mysqli_close( $conn );
    }
    elseif (isset($_GET['lngRoleTypeID']))
    {
        $result = mysqli_query($conn, "DELETE FROM tblRoleTypes WHERE lngRoleTypeID = " . $_GET['lngRoleTypeID']);
        mysqli_close( $conn );
        $location = "role.php?search=#";
    }
    elseif (isset( $_GET['lngCertificateID']))
    {
        $result = mysqli_query($conn, "DELETE FROM tblFilmCertificates WHERE lngCertificateID = " . $_GET['lngCertificateID']);
        mysqli_close( $conn );
        $location = "certificate.php?search=#";
    }
    elseif(isset($_GET['lngGenreID']))
    {
        $result = mysqli_query($conn, "DELETE FROM tblFilmGenres WHERE lngGenreID = " . $_GET['lngGenreID']);
        mysqli_close( $conn );
        $location = "genre.php?search=#";
    }
    elseif(isset($_GET['lngProducerID']))
    {
        $result = mysqli_query($conn, "DELETE FROM tblfilmtitlesproducers WHERE lngProducerID = " . $_GET['lngProducerID']);
        $result = mysqli_query($conn, "DELETE FROM tblProducers WHERE lngProducerID = " . $_GET['lngProducerID']);
        mysqli_close( $conn );
        $location = "producer.php?search=#";
    }
    elseif($_GET['lngFilmTitleID'])
    {
        $result = mysqli_query($conn, "DELETE FROM tblfilmsactorroles WHERE lngFilmTitleID = " . $_GET['lngFilmTitleID']);
        $result = mysqli_query($conn, "DELETE FROM tblFilmTitles WHERE lngFilmTitleID = " . $_GET['lngFilmTitleID']);
        mysqli_close( $conn );
        $location = "film.php?search=#";
    }


    if ($result) {
        header("location: $location");
    }
}

?>