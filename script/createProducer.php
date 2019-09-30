<?php include('header.php');
include ('includes/config.php');
include('includes/navigation.php');
?>
 <h2 class="text-center" style="color:white;">CREATE PRODUCER</h2>
  <div class="d-flex justify-content-center" style="color:white;">

    <form method="POST" action="createFilmProcess.php">
        <label>Name</label>
            <input type="text" name="strProducerName" class="form-control" value="" required> <br>
        <label>Email Address</label>
           <input type="email" name="hypContactEmailAddress" class="form-control" value="" required> <br>
        <label>Website</label>
            <input type="url" name="hypWebsite" class="form-control" value="" required> <br>
        <br>
        <input type="submit" formaction="createProducerProcess.php" name="Submit" value="CREATE" class="btn btn-primary btn-lg btn-block"> <br>
    </div>
  </form>