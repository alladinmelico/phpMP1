<?php include('header.php');
include ('includes/config.php');
include('includes/navigation.php');
$lngCertificateID = $_GET['lngCertificateID'];
$result = mysqli_query($conn,"SELECT * FROM tblFilmCertificates WHERE lngCertificateID = $lngCertificateID") ;
$row = mysqli_fetch_array($result);
?>

 <h2 class="text-center" style="color:white;">EDIT CERTIFICATE</h2>
  <div class="d-flex justify-content-center" style="color:white;">

    <form method="POST" action="editCertificateProcess.php">
      <input type="text"  class="form-control" name="lngCertificateID" value="<?php echo $row[0]; ?>"><br>
        <label>Certificate</label>
            <input type="text" name="strCertificate" class="form-control" value="<?php echo $row[1]; ?>" required> <br>
            <br>
        <input type="submit" formaction="editCertificateProcess.php" name="Submit" value="EDIT" class="btn btn-primary btn-lg btn-block"> <br>
    </div>
  </form>
