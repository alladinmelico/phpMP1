<?php include('header.php');
include ('includes/config.php');
include('includes/navigation.php');
$lngRoleTypeID = $_GET['lngRoleTypeID'];
$result = mysqli_query($conn,"SELECT * FROM tblRoleTypes WHERE lngRoleTypeID = $lngRoleTypeID") ;
$row = mysqli_fetch_array($result);
?>

 <h2 class="text-center" style="color:white;">EDIT ROLE</h2>
  <div class="d-flex justify-content-center" style="color:white;">

    <form method="POST" action="editRoleProcess.php">
      <input type="text"  class="form-control" name="lngRoleTypeID" value="<?php echo $row[0]; ?>"><br>
        <label>Role</label>
            <input type="text" name="strRoleType" class="form-control" value="<?php echo $row[1]; ?>" required> <br>
        <br>
        <input type="submit" formaction="editRoleProcess.php" name="Submit" value="EDIT" class="btn btn-primary btn-lg btn-block"> <br>
    </div>
  </form>
