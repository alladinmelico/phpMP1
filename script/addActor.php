<?php
include ('header.php');
include ("includes/config.php");

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    $pic = $_GET['pic'];
    $lngActorID = $_GET['lngActorID'];
    $lngFilmTitleID = $_GET['lngFilmTitleID'];

    $sql = "DELETE FROM tblfilmsactorroles WHERE lngFilmTitleID = '$lngFilmTitleID' AND lngActorID = '$lngActorID';";
    echo $sql;
    $result = mysqli_query( $conn,$sql);

    if ($result) {
        header("location: viewFilm.php?lngFilmTitleID=$lngFilmTitleID&filmPic=$pic");
    }

}

if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['submit']) == "EDIT")
{
    $pic = $_POST['pic'];
    $lngActorID = $_POST['lngActorID'];
    $strCharacterName = $_POST['strCharacterName'];
    $memCharaterDescription = $_POST['memCharaterDescription'];
    $lngRoleTypeID = $_POST['lngRoleTypeID'];
    $lngFilmTitleID = $_POST['lngFilmTitleID'];
    
    $sql = "UPDATE tblfilmsactorroles SET strCharacterName = '$strCharacterName', memCharaterDescription='$memCharaterDescription',
       lngActorID='$lngActorID', lngRoleTypeID='$lngRoleTypeID',lngFilmTitleID='$lngFilmTitleID'
       WHERE lngActorID='$lngActorID' AND lngFilmTitleID='$lngFilmTitleID';";
    echo $sql;
    $result = mysqli_query( $conn,$sql);

    if ($result) {
        header("location: viewFilm.php?lngFilmTitleID=$lngFilmTitleID&filmPic=$pic");
    }
}



if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['submit']) == "ADD")
{
    $pic = $_POST['pic'];
    $lngActorID = $_POST['lngActorID'];
    $strCharacterName = $_POST['strCharacterName'];
    $memCharaterDescription = $_POST['memCharaterDescription'];
    $lngRoleTypeID = $_POST['lngRoleTypeID'];
    $lngFilmTitleID = $_POST['lngFilmTitleID'];
    
    $sql = "INSERT INTO tblfilmsactorroles (strCharacterName,memCharaterDescription,lngActorID,lngRoleTypeID,lngFilmTitleID) 
    VALUES('$strCharacterName','$memCharaterDescription','$lngActorID','$lngRoleTypeID','$lngFilmTitleID');";
    echo $sql;
    $result = mysqli_query( $conn,$sql);

    if ($result) {
        header("location: viewFilm.php?lngFilmTitleID=$lngFilmTitleID&filmPic=$pic");
    }
}

?>