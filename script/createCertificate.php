<?php include('header.php');
include ('includes/config.php');
include('includes/navigation.php');

?>
 <h2 class="text-center" style="color:white;">CREATE CERTIFICATE</h2>
  <div class="d-flex justify-content-center" style="color:white;">

    <form method="POST" action="createCertficateProcess.php">
        <label>Certificate</label>
            <input type="text" name="strCertificate" class="form-control" value="" required><br>
        <br>
        <input type="submit" formaction="createCertificateProcess.php" name="Submit" value="CREATE" class="btn btn-primary btn-lg btn-block"> <br>
    </div>
  </form>