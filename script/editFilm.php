<?php
include('header.php');
include('includes/config.php');
include('includes/navigation.php');
$lngFilmTitleID = $_GET['lngFilmTitleID'];
$result = mysqli_query($conn,"SELECT * FROM tblFilmTitles WHERE lngFilmTitleID = $lngFilmTitleID") ;
$row = mysqli_fetch_array($result);
?>

 <h2 class="text-center" style="color:white;">EDIT FILM</h2>
  <div class="d-flex justify-content-center" style="color:white;">

    <form method="POST" action="editFilmProcess.php" enctype="multipart/form-data">
      <input type="text"  class="form-control" name="lngFilmTitleID" value="<?php echo $row[0]; ?>"><br>
        <label>Photo</label><br><p class="text-center">
            <i>old</i> </p> 
                <img src="../pictures/poster/<?php echo $row[8];?>" class="rounded mx-auto d-block" alt="" width = "200px"><br>
                    <input type="file" id="profile-img" class="input-group-prepend" name="photo" id="profile-img" value="<?php echo $row[0];?>" required><br>
                    <img src="" id="profile-img-tag" width="200px" class="rounded mx-auto d-block"/>
                    <?php include ('includes/showPhoto.php');?>
        <label>Title</label>
            <input type="text" name="strFilmTitle" class="form-control" value="<?php echo $row[1]; ?>" required> <br>
        <label>Story</label>
           <textarea name="memFilmStory" id="" cols="30" rows="10" class="form-control" value="<?php echo $row[2]; ?>" required><?php echo $row[2]; ?></textarea> <br>
        <label>Date</label>
            <input type="date" name="dtmFilmReleaseDate" class="form-control" value="<?php echo $row[3]; ?>" required> <br>
        <label>Duration (minutes)</label>
            <input type="number" name="intFilmDuration" class="form-control" value="<?php echo $row[4]; ?>" required> <br>
        <label>Additional Info</label>
            <input type="text" name="memFilmAdditionalInfo" class="form-control" value="<?php echo $row[5]; ?>" required> <br>
        <label>Genre</label>
            <?php 
                $resultCat = mysqli_query($conn,"SELECT * FROM tblFilmGenres;");
                $resultDefaultCat = mysqli_query($conn,"SELECT fg.strGenre,fg.lngGenreID FROM tblfilmgenres fg 
                    INNER JOIN tblFilmTitles ft ON ft.lngGenreID = fg.lngGenreID WHERE ft.lngFilmTitleID = $lngFilmTitleID");
                $rowDefaultCategory = mysqli_fetch_assoc($resultDefaultCat)?>

                <select class="custom-select" name="lngGenreID" value="<?php echo $row[6]; ?>" required> ";
                <option name="strGenre" value="<?php echo $rowDefaultCategory['lngGenreID'];?>" required><?php echo $rowDefaultCategory['strGenre'];?></option>;
                
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
                echo "<select class=\"custom-select\" name=\"lngCertificateID\" value=\"<?php echo $row[7]; ?>\" required> ";
                while($rowCategory = mysqli_fetch_assoc($resultCat))
                {?>
                    <tr>
                    <td><option name="strCertificate" value="<?php echo $rowCategory['lngCertificateID'];?>" required><?php echo $rowCategory['strCertificate'];?></option></td>
                    </tr>
            <?php }?>
        <br><br><br>
        <input type="hidden" name="sql" value="<?php echo $sql; ?>">
        <input type="submit" formaction="editFilmProcess.php" name="Submit" value="EDIT" class="btn btn-primary btn-lg btn-block"> <br>
  </form>
 </div>
</body>
</html>
