<?php include('header.php');include('includes/navigation.php');

?>
 <h2 class="text-center" style="color:white;">CREATE ACTOR</h2>
  <div class="d-flex justify-content-center" style="color:white;">

    <form method="POST" action="createActorProcess.php" enctype="multipart/form-data">
        <label>Photo</label><br>
            <input type="file" name="photo" id="profile-img">
                <img src="" id="profile-img-tag" width="200px" class="rounded mx-auto d-block"/>
                    <?php include ('includes/showPhoto.php');?>
        <label>Name</label>
            <input type="text" name="strActorFullName" class="form-control" value="" required> <br>
        <label>Note</label>
            <input type="text" name="memActorNotes" class="form-control" value="" required> <br>
        <input type="submit" formaction="createActorProcess.php" name="Submit" value="CREATE" class="btn btn-primary btn-lg btn-block"> <br>
    </div>
  </form>