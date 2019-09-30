<?php include('header.php');
include ('includes/config.php');
include('includes/navigation.php');
?>
 <h2 class="text-center" style="color:white;">CREATE FILM</h2>
  <div class="d-flex justify-content-center" style="color:white;">

    <form method="POST" action="createFilmProcess.php" enctype="multipart/form-data">
        <label>Photo</label><br>
                <input type="file" name="photo" id="profile-img">
                    <img src="" id="profile-img-tag" width="200px" class="rounded mx-auto d-block"/>
                        <?php include ('includes/showPhoto.php');?>
        <label>Title</label>
            <input type="text" name="strFilmTitle" class="form-control" value="" required> <br>
        <label>Story</label>
           <textarea name="strFilmStory" id="" cols="30" rows="10" class="form-control" required></textarea> <br>
        <label>Date</label>
            <input type="date" name="dtmReleaseDate" class="form-control" value="" required> <br>
        <label>Duration (minutes)</label>
        <!--DONE TODO:separate hr and mins-->
            <input type="number" name="intFilmDuration" class="form-control" value="" required> <br>
        <label>Additional Info</label>
            <input type="text" name="memFilmAdditionalInfo" class="form-control" value="" required> <br>
        <label>Genre</label>
        <?php 
            $resultCat = mysqli_query($conn,"SELECT * FROM tblFilmGenres;");
            echo "<select class=\"custom-select\" name=\"lngGenreID\" required> ";
            while($rowCategory = mysqli_fetch_assoc($resultCat))
            {?>
                <tr>
                <td><option name="strGenre" value="<?php echo $rowCategory['lngGenreID'];?>" required> <?php echo $rowCategory['strGenre'];?> </option></td>
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
        <br><br>
        <input type="submit" formaction="createFilmProcess.php" name="Submit" value="CREATE" class="btn btn-primary btn-lg btn-block"> <br>
    </div>
  </form>