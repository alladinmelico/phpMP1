<?php include('header.php');
include ('includes/config.php');
include('includes/navigation.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lngProducerID = $_POST['lngProducerID'];
    $strProducerName = $_POST['strProducerName'];
    $hypContactEmailAddress = $_POST['hypContactEmailAddress'];

    $hypWebsite = $_POST['hypWebsite'];

    if ($_POST['submit'] == "ADD")
    {
        $sql = "INSERT INTO tblProducers (strProducerName,hypContactEmailAddress,hypWebsite)
        VALUES ('$strProducerName','$hypContactEmailAddress','$hypWebsite');";
    } else {
        $sql = "UPDATE tblProducers SET strProducerName='$strProducerName',
            hypContactEmailAddress='$hypContactEmailAddress',hypWebsite='$hypWebsite' WHERE lngProducerID =$lngProducerID;";
    }
    $result = mysqli_query( $conn,$sql);

    if ($result) {
        header("location: producer.php?search=#");
    }

}
if (isset($_GET['lngProducerID']))
{
    $lngProducerID = $_GET['lngProducerID'];
    $result = mysqli_query($conn,"SELECT * FROM tblProducers WHERE lngProducerID = $lngProducerID");
    $row = mysqli_fetch_array($result);
    $strProducerName = $row[1];
    $hypContactEmailAddress = $row[2];
    $hypWebsite = $row[3];
    $process = "EDIT";
} else {
    $lngProducerID = 0;
    $strProducerName = "";
    $hypContactEmailAddress = "";
    $hypWebsite = "";
    $process = "ADD";
}
?>

<h2 class="text-center" style="color:white;"><?php echo $process;?> PRODUCER</h2>
  <div class="d-flex justify-content-center" style="color:white;">

    <form method="POST" action="#">
      <input type="hidden"  class="form-control" name="lngProducerID" value="<?php echo $lngProducerID; ?>"><br>
        <label>Name</label>
            <input type="text" name="strProducerName" class="form-control" value="<?php echo $strProducerName; ?>" required> <br>
        <label>Email</label>
           <input type="email" name="hypContactEmailAddress" class="form-control" value="<?php echo $hypContactEmailAddress; ?>" required><br>
        <label>Website</label>
            <input type="url" name="hypWebsite" class="form-control" value="<?php echo $hypWebsite; ?>" required>
        <br><br>
        <input type="submit" formaction="#" name="submit" value="<?php echo $process;?>" class="btn btn-primary btn-lg btn-block"> <br>
    </div>
  </form>