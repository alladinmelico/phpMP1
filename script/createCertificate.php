<?php include('header.php');
include ('includes/config.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $strCertificate = $_POST['strCertificate'];
  $lngCertificateID = $_POST['lngCertificateID'];
  
  if($_POST['submit'] == "ADD")
  {
    $sql = "INSERT INTO tblFilmCertificates(strCertificate) VALUES ('$strCertificate');";
  } else {
    $sql = "UPDATE tblFilmCertificates SET strCertificate ='$strCertificate' WHERE lngCertificateID = '$lngCertificateID';";
  }
  
  $result = mysqli_query( $conn,$sql);

  if ($result) {
      header("location: certificate.php?search=#");
  }
}

if (isset($_GET['lngCertificateID']))
{
  $lngCertificateID = $_GET['lngCertificateID'];
  $result = mysqli_query($conn,"SELECT * FROM tblFilmCertificates WHERE lngCertificateID = $lngCertificateID") ;
  $row = mysqli_fetch_array($result);
  $strCertificate = $row[1];
  $process = "EDIT";
} else {
  $lngCertificateID = 0;
  $strCertificate = "";
  $process = "ADD";
}
?>
<?php include('includes/navigation.php');?>
 <h2 class="text-center" style="color:white;"><?Php echo $process;?> CERTIFICATE</h2>
  <div class="d-flex justify-content-center" style="color:white;">

    <form method="POST" action="#">
      <input type="hidden"  class="form-control" name="lngCertificateID" value="<?php echo $lngCertificateID; ?>"><br>
        <label>Certificate</label>
            <input type="text" name="strCertificate" class="form-control" value="<?php echo $strCertificate; ?>" required> <br>
            <br>
        <input type="submit" formaction="#" name="submit" value="<?php echo  $process;?>" class="btn btn-primary btn-lg btn-block"> <br>
    </div>
  </form>