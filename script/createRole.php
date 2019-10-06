<?php include('header.php');
include ('includes/config.php');
include('includes/navigation.php');

if($_SERVER["REQUEST_METHOD"] == "POST")
{
  $strRoleType = $_POST['strRoleType'];
  $lngRoleTypeID = $_POST['lngRoleTypeID'];

  if ($_POST['submit'] == "ADD")
  {
    $sql = "INSERT INTO tblRoleTypes (strRoleType) VALUES ('$strRoleType');";
  } else {
    $sql = "UPDATE tblRoleTypes SET strRoleType ='$strRoleType' WHERE lngRoleTypeID = '$lngRoleTypeID';";
  }


  $result = mysqli_query( $conn,$sql);

  if ($result) {
      header("location: role.php?search=#");
  }
}
if (isset($_GET['lngRoleTypeID']))
{
  $lngRoleTypeID = $_GET['lngRoleTypeID'];
  $result = mysqli_query($conn,"SELECT * FROM tblRoleTypes WHERE lngRoleTypeID = $lngRoleTypeID") ;
  $row = mysqli_fetch_array($result);
  $strRoleType = $row[1];
  $process = "EDIT";
} else {
  $lngRoleTypeID = 0;
  $strRoleType = "";
  $process = "ADD";
}
?>
 <h2 class="text-center" style="color:white;"><?php echo $process?> ROLE</h2>
  <div class="d-flex justify-content-center" style="color:white;">

    <form method="POST" action="#">
      <input type="hidden"  class="form-control" name="lngRoleTypeID" value="<?php echo $lngRoleTypeID; ?>"><br>
        <label>Role</label>
            <input type="text" name="strRoleType" class="form-control" value="<?php echo $strRoleType; ?>" required> <br>
        <br>
        <input type="submit" formaction="#" name="submit" value="<?php echo $process ?>" class="btn btn-primary btn-lg btn-block"> <br>
    </div>
  </form>