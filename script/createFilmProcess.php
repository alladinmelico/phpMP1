<?php

include ("includes/config.php");

echo "<pre>"; 
print_r($_FILES); 
echo "</pre>"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) { 

        $file_name	 = $_FILES["photo"]["name"]; 
            $file_type	 = $_FILES["photo"]["type"]; 
            $file_size	 = $_FILES["photo"]["size"]; 
            $file_tmp_name = $_FILES["photo"]["tmp_name"]; 
            $file_error = $_FILES["photo"]["error"]; 
            
            $targetDir = "../pictures/poster";
            $targetFile = $targetDir.$_FILES['photo']['name'];
            
            if($file_size > 2097152){
               $errors[]='File size must be lower than 2 MB';
            }
            
            if (move_uploaded_file($file_tmp_name, "$targetDir/$file_name")) {
                echo "file uploaded succeeded";
              } else { 
                echo "file upload failed";
              }
         }
    $strFilmTitles = $_POST['strFilmTitle'];
    $memFilmStory = $_POST['strFilmStory'];
    $dtmFilmReleaseDate = $_POST['dtmReleaseDate'];
    $intFilmDuration = $_POST['intFilmDuration'];
    $memFilmAdditionalInfo =$_POST['memFilmAdditionalInfo'];
    $lngGenreID =$_POST['lngGenreID'];
    $lngCertificateID = $_POST['lngCertificateID'];
    
    $sql = "INSERT INTO tblFilmTitles (strFilmTitle,memFilmStory,dtmFilmReleaseDate,intFilmDuration,memFilmAdditionalInfo,lngGenreID,lngCertificateID,picture)
                VALUES ('$strFilmTitles','$memFilmStory','$dtmFilmReleaseDate','$intFilmDuration','$memFilmAdditionalInfo','$lngGenreID','$lngCertificateID','$file_name');";
    echo $sql;
    $result = mysqli_query( $conn,$sql);

    if ($result) {
        header("location: film.php?search=#");
    }
}
?>