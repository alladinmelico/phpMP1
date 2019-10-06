<?php include('header.php');
include ('includes/config.php');
include('includes/navigation.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["photo"])) { 
      $errors     = array();
      $maxsize    = 2097152;
      $acceptable = array(
          'application/pdf',
          'image/jpeg',
          'image/jpg',
          'image/gif',
          'image/png'
      );
      
    if(($_FILES['photo']['size'] >= $maxsize) || ($_FILES["photo"]["size"] == 0)) {
        $errors[] = 'File too large. File must be less than 2 megabytes.';
    }

    if((!in_array($_FILES['photo']['type'], $acceptable)) && (!empty($_FILES["photo"]["type"]))) {
        $errors[] = 'Invalid file type. Only PDF, JPG, GIF and PNG types are accepted.';
    }

    if(count($errors) === 0) {
      $file_name	 = $_FILES["photo"]["name"]; 
      $file_tmp_name = $_FILES["photo"]["tmp_name"];
      $targetDir = "../pictures/poster";
      $targetFile = $targetDir.$_FILES['photo']['name'];

      if(move_uploaded_file($file_tmp_name, "$targetDir/$file_name")){

        $lngFilmTitleID = $_POST['lngFilmTitleID'];
        $strFilmTitle = $_POST['strFilmTitle'];
        $memFilmStory = $_POST['memFilmStory'];
        $dtmFilmReleaseDate = $_POST['dtmFilmReleaseDate'];
        $intFilmDuration = $_POST['intFilmDuration'];
        $memFilmAdditionalInfo = $_POST['memFilmAdditionalInfo'];
        $lngGenreID = $_POST['lngGenreID'];
        $lngCertificateID = $_POST['lngCertificateID'];

        if ($_POST['submit'] == "ADD")
        {
            $sql = "INSERT INTO tblFilmTitles (strFilmTitle,memFilmStory,dtmFilmReleaseDate,intFilmDuration,memFilmAdditionalInfo,lngGenreID,lngCertificateID,picture)
            VALUES ('$strFilmTitle','$memFilmStory','$dtmFilmReleaseDate','$intFilmDuration','$memFilmAdditionalInfo','$lngGenreID','$lngCertificateID','$file_name');";
        } else {
            $sql = "UPDATE tblFilmTitles SET lngFilmTitleID = '$lngFilmTitleID',strFilmTitle='$strFilmTitle',memFilmStory='$memFilmStory',
            dtmFilmReleaseDate='$dtmFilmReleaseDate',intFilmDuration='$intFilmDuration',memFilmAdditionalInfo='$memFilmAdditionalInfo',lngGenreID='$lngGenreID',
            lngCertificateID='$lngCertificateID',picture='$file_name' WHERE lngFilmTitleID = '$lngFilmTitleID'";
        }
        $result = mysqli_query( $conn,$sql);

        if ($result) {
            header("location: film.php?search=#");
        }

      } else { 
        echo "File upload Failed";
        }
    } else {
        foreach($errors as $error) {
            echo '<script>alert("'.$error.'");</script>';
        }

        die(); //Ensure no more processing is done
    }
}
}

if (isset($_GET['lngFilmTitleID']))
{
    $lngFilmTitleID = $_GET['lngFilmTitleID'];
    $result = mysqli_query($conn,"SELECT * FROM tblFilmTitles WHERE lngFilmTitleID = $lngFilmTitleID") ;
    $row = mysqli_fetch_array($result);
    $strFilmTitle = $row[1];
    $memFilmStory = $row[2];
    $dtmFilmReleaseDate = $row[3];
    $intFilmDuration = $row[4];
    $memFilmAdditionalInfo = $row[5];
    $process = "EDIT";
} else {
    $lngCertificateID = 0;
    $strFilmTitle = "";
    $memFilmStory = "";
    $dtmFilmReleaseDate = "";
    $intFilmDuration = 0;
    $memFilmAdditionalInfo = "";
    $process = "ADD";
}
?>
<h2 class="text-center" style="color:white;"><?php echo $process;?> FILM</h2>
  <div class="d-flex justify-content-center" style="color:white;">

    <form method="POST" action="#" enctype="multipart/form-data">
      <input type="hidden"  class="form-control" name="lngFilmTitleID" value="<?php echo $row[0]; ?>"><br>
        <label>Photo</label><br><p class="text-center">
            <?php if($process == "EDIT") {echo "<i>old</i>";}?> </p> 
                <img src="../pictures/poster/<?php echo $row[8];?>" class="rounded mx-auto d-block" alt="" width = "200px"><br>
                    <input type="file" id="profile-img" class="input-group-prepend" name="photo" id="profile-img" value="<?php echo $row[0];?>" required><br>
                    <img src="" id="profile-img-tag" width="200px" class="rounded mx-auto d-block"/>
                    <?php include ('includes/showPhoto.php');?>
        <label>Title</label>
            <input type="text" name="strFilmTitle" class="form-control" value="<?php echo $strFilmTitle; ?>" required> <br>
        <label>Story</label>
           <textarea name="memFilmStory" id="" cols="30" rows="10" class="form-control" value="<?php echo $memFilmStory; ?>" required><?php echo $memFilmStory; ?></textarea> <br>
        <label>Date</label>
            <input type="date" name="dtmFilmReleaseDate" class="form-control" value="<?php echo $dtmFilmReleaseDate; ?>" required> <br>
        <label>Duration (minutes)</label>
            <input type="number" name="intFilmDuration" class="form-control" value="<?php echo $intFilmDuration; ?>" required> <br>
        <label>Additional Info</label>
            <input type="text" name="memFilmAdditionalInfo" class="form-control" value="<?php echo $memFilmAdditionalInfo; ?>" required> <br>
        <label>Genre</label>
            <?php 
                $resultCat = mysqli_query($conn,"SELECT * FROM tblFilmGenres;");
                $resultDefaultCat = mysqli_query($conn,"SELECT fg.strGenre,fg.lngGenreID FROM tblfilmgenres fg 
                    INNER JOIN tblFilmTitles ft ON ft.lngGenreID = fg.lngGenreID");
                $rowDefaultCategory = mysqli_fetch_assoc($resultDefaultCat)?>

                <select class="custom-select" name="lngGenreID" value="<?php echo $row[6];?>" required> ";
                <option name="strGenre" value="" required>Choose...</option>;
                
                <?php
                while($rowCategory = mysqli_fetch_assoc($resultCat))
                {?>
                    <tr>
                    <option value=""></option>
                    <td><option name="strGenre" value="<?php echo $rowCategory['lngGenreID'];?>" required><?php echo $rowCategory['strGenre'];?></option></td>
                    </tr>
            <?php }?>
            </select> <br>
        <label>Certificate</label>
            <?php 
                $resultCat = mysqli_query($conn,"SELECT * FROM tblFilmCertificates;");
                echo "<select class=\"custom-select\" name=\"lngCertificateID\" required> ";
                while($rowCategory = mysqli_fetch_assoc($resultCat))
                {?>
                    <tr>
                    <td><option name="strCertificate" value="<?php echo $rowCategory['lngCertificateID'];?>" required><?php echo $rowCategory['strCertificate'];?></option></td>
                    </tr>
            <?php }?>
        <input type="submit" formaction="#" name="submit" value="<?php echo $process; ?>" class="btn btn-primary btn-lg btn-block"> <br>
  </form>
 </div>