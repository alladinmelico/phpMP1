<?php include('header.php');
include ('includes/config.php');
include('includes/navigation.php');
$lngActorID = $_GET['lngActorID'];
$lngFilmTitleID = $_GET['lngFilmTitleID'];
$lngProducerID = $_GET['lngProducerID'];

setcookie("lngActorID",$lngActorID, time() + (180), "/");
setcookie("lngFilmTitleIDold", $lngFilmTitleID , time() + (180), "/");
setcookie("lngProducerIDold", $lngProducerID , time() + (180), "/");

$result = mysqli_query($conn,"SELECT * FROM production prod INNER JOIN tblfilmsactorroles far ON far.lngActorID = prod.lngActorID
     WHERE prod.lngActorID = $lngActorID AND prod.lngFilmTitleID = $lngFilmTitleID AND prod.lngProducerID = $lngProducerID;") ;
$row = mysqli_fetch_array($result);
?>
<!-- DONE FIX: Fix this mess!  @critical-->
 <h2 class="text-center" style="color:white;">EDIT PRODUCTION</h2>
  <div class="d-flex justify-content-center" style="color:white;">

    <form method="POST" action="editFilmProcess.php">
      <input type="text"  class="form-control" name="lngActorID" value="<?php echo $row[0]; ?>"><br>
      <label>Actor</label>
            <?php 
                $resultCat = mysqli_query($conn,"SELECT * FROM tblActors;");
                echo "<select class=\"custom-select\" name=\"lngActorID\" required> ";
                while($rowCategory = mysqli_fetch_assoc($resultCat))
                {?>
                    <tr>
                    <td><option name="lngActorID" value="<?php echo $rowCategory['lngActorID'];?>" required>
                    <?php echo $rowCategory['strActorFullName'];?>
                    </option></td>
                    </tr>
            <?php }?></select> <br>

        <label>Film</label>
            <?php 
                $resultCat = mysqli_query($conn,"SELECT * FROM tblFilmTitles;");
                echo "<select class=\"custom-select\" name=\"lngFilmTitleID\" required> ";
                while($rowCategory = mysqli_fetch_assoc($resultCat))
                {?>
                    <tr>
                    <td><option name="lngFilmTitleID" 
                        value="<?php echo $rowCategory['lngFilmTitleID'];?>" required>
                            <?php echo $rowCategory['strFilmTitle'];?>
                        </option>
                    </td>
                    </tr>
            <?php }?></select> <br>

        <label>Role</label>
            <?php 
                $resultRole = mysqli_query($conn,"SELECT * FROM tblRoleTypes;");
                echo "<select class=\"custom-select\" name=\"lngRoleTypeID\" required> ";
                while($rowRole = mysqli_fetch_assoc($resultRole))
                {?>
                    <tr>
                        <td><option name="lngRoleTypeID" value="<?php echo $rowRole['lngRoleTypeID'];?>" required><?php echo $rowRole['strRoleType'];?></option></td>
                    </tr>
            <?php }?></select> <br>
        <label>Character</label>
            <input type="text" name="strCharacterName" class="form-control" value="<?php echo $row['strCharacterName']; ?>" required><br>
        <label>Description</label>
            <input type="text" name="memCharaterDescription" class="form-control" value="<?php echo $row['memCharaterDescription']; ?>" required><br>
            
        <label>Producer</label>
            <?php 
                $resultRole = mysqli_query($conn,"SELECT * FROM tblProducers;");
                echo "<select class=\"custom-select\" name=\"lngProducerID\" required> ";
                while($rowRole = mysqli_fetch_assoc($resultRole))
                {?>
                    <tr>
                        <td><option name="lngProducerID" value="<?php echo $rowRole['lngProducerID'];?>" required><?php echo $rowRole['strProducerName'];?></option></td>
                    </tr>
            <?php }?></select> <br>
        <br>
        <input type="submit" formaction="editProductionProcess.php" name="Submit" value="EDIT" class="btn btn-primary btn-lg btn-block"> <br>
    </div>
  </form>
