<?php include('header.php');
include ('includes/config.php');
include('includes/navigation.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $strGenre = $_POST['strGenre'];
  $lngGenreID = $_POST['lngGenreID'];
  
  if ($_POST['submit'] == "ADD")
  {
    $sql = "INSERT INTO tblFilmGenres(strGenre) VALUES ('$strGenre');";
  } else {
  $sql = "UPDATE tblFilmGenres SET strGenre ='$strGenre' WHERE lngGenreID = '$lngGenreID';";
  }
  $result = mysqli_query( $conn,$sql);

  if ($result) {
      header("location: genre.php?search=#");
  }
}

if (isset($_GET['lngGenreID']))
{ 
  $lngGenreID = $_GET['lngGenreID'];
  $result = mysqli_query($conn,"SELECT * FROM tblFilmGenres WHERE lngGenreID = $lngGenreID") ;
  $row = mysqli_fetch_array($result);
  $strGenre = $row[1];
  $process = "EDIT";
} else {
  $lngGenreID = 0;
  $strGenre = "";
  $process = "ADD";
}
?>

<h2 class="text-center" style="color:white;"><?php echo $process; ?> GENRE</h2>
  <div class="d-flex justify-content-center" style="color:white;">

    <form method="POST" action="#">
      <input type="hidden"  class="form-control" name="lngGenreID" value="<?php echo $lngGenreID; ?>"><br>
        <label>Name</label>
            <input type="text" name="strGenre" class="form-control" value="<?php echo $strGenre; ?>" required> <br>
        <br>
        <input type="submit" formaction="#" name="submit" value="<?php echo $process;?>" class="btn btn-primary btn-lg btn-block"> <br>
    </div>
  </form>