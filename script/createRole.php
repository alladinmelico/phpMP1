<?php include('header.php');
include ('includes/config.php');
include('includes/navigation.php');
?>
 <h2 class="text-center" style="color:white;">CREATE PRODUCER</h2>
  <div class="d-flex justify-content-center" style="color:white;">

    <form method="POST" action="createRoleProcess.php">
        <label>Role</label>
            <input type="text" name="strRoleType" class="form-control" value="" required><br>
        <br>
        <input type="submit" formaction="createRoleProcess.php" name="Submit" value="CREATE" class="btn btn-primary btn-lg btn-block"> <br>
    </div>
  </form>