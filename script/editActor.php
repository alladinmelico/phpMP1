<?php include('header.php');
include ("includes/config.php");
include('includes/navigation.php');
$lngActorID = $_GET['lngActorID'];
?>
<body>
  <h2 class="text-center" style="color:white;">EDIT ACTOR</h2>
  <?php
      $result = mysqli_query($conn,"SELECT * FROM tblactors WHERE lngActorID = $lngActorID") ;
      $row = mysqli_fetch_array($result);
    ?>
  <div class="form-group">
    <div class="d-flex justify-content-center" style="color:white;">
      <form method="POST" action="editActorProcess.php" enctype="multipart/form-data">
      <input type="text"  class="form-control" name="lngActorID" value="<?php echo $row[0]; ?>"><br>
      <label>Photo</label><br><p class="text-center">
        <i>old</i> </p> 
          <img src="../pictures/profile/<?php echo $row[3];?>" class="rounded mx-auto d-block" alt="" width = "200px"><br>
              <input type="file" id="profile-img" class="input-group-prepend" name="photo" id="profile-img" value="<?php echo $row[0];?>" required><br>
              <img src="" id="profile-img-tag" width="200px" class="rounded mx-auto d-block"/>
              <?php include ('includes/showPhoto.php');?>
          <label>Name</label>
              <input type="text" name="strActorFullName" class="form-control" value="<?php echo $row[1] ?>" required> <br>
          <label>Note</label>
              <input type="text" name="memActorNotes" class="form-control" value="<?php echo $row[2] ?>" required> <br>
          <input type="submit" formaction="editActorProcess.php" name="Submit" value="EDIT" class="btn btn-primary btn-lg btn-block"> <br>
      </div>
      </form>
  </div>
  
</body>
</html>