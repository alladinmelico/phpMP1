<?php include('header.php');
include ('includes/config.php');
include('includes/navigation.php');
$lngGenreID = $_GET['lngGenreID'];
$result = mysqli_query($conn,"SELECT * FROM tblFilmGenres WHERE lngGenreID = $lngGenreID") ;
$row = mysqli_fetch_array($result);
?>

 <h2 class="text-center" style="color:white;">EDIT GENRE</h2>
  <div class="d-flex justify-content-center" style="color:white;">

    <form method="POST" action="editFilmProcess.php">
      <input type="text"  class="form-control" name="lngGenreID" value="<?php echo $row[0]; ?>"><br>
        <label>Name</label>
            <input type="text" name="strGenre" class="form-control" value="<?php echo $row[1]; ?>" required> <br>
        <br>
        <input type="submit" formaction="editGenreProcess.php" name="Submit" value="EDIT" class="btn btn-primary btn-lg btn-block"> <br>
    </div>
  </form>
