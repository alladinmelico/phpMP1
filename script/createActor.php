<?php include('header.php');include('includes/navigation.php');require ("includes/config.php");

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
      $targetDir = "../pictures/profile";
      $targetFile = $targetDir.$_FILES['photo']['name'];
  
      if(move_uploaded_file($file_tmp_name, "$targetDir/$file_name")){
        echo "file uploaded succeeded";

        $lngActorID = $_POST['lngActorID'];
        $name= $_POST['strActorFullName'];
        $memo = $_POST['memActorNotes'];
        
        if($_POST['Submit'] == "ADD")
        {
            $sql = "INSERT INTO tblactors (strActorFullName,memActorNotes,picture) 
            VALUES ('$name','$memo','$file_name');";
        }
        elseif ($_POST['Submit'] == "EDIT")
        {
            $sql = "UPDATE tblactors SET strActorFullName='$name',memActorNotes='$memo',picture='$file_name' 
            WHERE lngActorID = $lngActorID;";
        }

        $result = mysqli_query( $conn,$sql);
    
        if ($result) {
            header("location: actor.php?search=#");
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

if(isset($_GET["lngActorID"]))
{
    $lngActorID = $_GET['lngActorID'];
    $result = mysqli_query($conn,"SELECT * FROM tblactors WHERE lngActorID = $lngActorID") ;
    $row = mysqli_fetch_array($result);
    $pic = $row[3];
    $strActorFullName = $row[1];
    $memActorNotes = $row[2];
    $process = "EDIT";
} else {
    $lngActorID = 0;
    $pic = "";
    $strActorFullName = "";
    $memActorNotes = "";
    $process = "ADD";
}
?>
 <h2 class="text-center" style="color:white;"><?php echo $process; ?> ACTOR</h2>
  <div class="d-flex justify-content-center" style="color:white;">

  <div class="form-group">
    <div class="d-flex justify-content-center" style="color:white;">
      <form method="POST" action="createActor.php" enctype="multipart/form-data">

      <input type="hidden" name="lngActorID" value="<?php echo $lngActorID;?>"><br>
      <label>Photo</label><br><p class="text-center">
        <?php if ($process === "EDIT") echo "<i>old</i>"?></p> 
          <img src="../pictures/profile/<?php echo $pic;?>" class="rounded mx-auto d-block" alt="" width = "200px"><br>
              <input type="file" id="profile-img" class="input-group-prepend" name="photo" id="profile-img" value="<?php echo $row[0];?>" required><br>
              <img src="" id="profile-img-tag" width="200px" class="rounded mx-auto d-block"/>
              <?php include ('includes/showPhoto.php');?>
    <label>Name</label>
        <input type="text" name="strActorFullName" class="form-control" value="<?php echo $strActorFullName ?>" required> <br>
    <label>Note</label>
        <input type="text" name="memActorNotes" class="form-control" value="<?php echo $memActorNotes; ?>" required> <br>
    <input type="submit" formaction="createActor.php" name="Submit" value="<?php echo $process ?>" class="btn btn-primary btn-lg btn-block"> <br>
      
      </div>
      </form>
  </div>