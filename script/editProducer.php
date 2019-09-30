<?php include('header.php');
include ('includes/config.php');
$lngProducerID = $_GET['lngProducerID'];
include('includes/navigation.php');
$result = mysqli_query($conn,"SELECT * FROM tblProducers WHERE lngProducerID = $lngProducerID") ;
$row = mysqli_fetch_array($result);
?>

 <h2 class="text-center" style="color:white;">EDIT PRODUCER</h2>
  <div class="d-flex justify-content-center" style="color:white;">

    <form method="POST" action="editProducerProcess.php">
      <input type="text"  class="form-control" name="lngProducerID" value="<?php echo $row[0]; ?>"><br>
        <label>Name</label>
            <input type="text" name="strProducerName" class="form-control" value="<?php echo $row[1]; ?>" required> <br>
        <label>Email</label>
           <input type="email" name="hypContactEmailAddress" class="form-control" value="<?php echo $row[2]; ?>" required><br>
        <label>Website</label>
            <input type="url" name="hypWebsite" class="form-control" value="<?php echo $row[3]; ?>" required>
        <br><br>
        <input type="submit" formaction="editProducerProcess.php" name="Submit" value="EDIT" class="btn btn-primary btn-lg btn-block"> <br>
    </div>
  </form>
