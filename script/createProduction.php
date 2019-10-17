<?php include('header.php');
include ('includes/config.php');
include('includes/navigation.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $strCharacterName = $_POST['strCharacterName'];
    $memCharaterDescription = $_POST['memCharaterDescription'];
    $lngActorID = $_POST['lngActorID'];
    $lngRoleTypeID = $_POST['lngRoleTypeID'];
    $lngFilmTitleID = $_POST['lngFilmTitleID'];
    $lngProducerID = $_POST['lngProducerID'];
    
    $sql = "INSERT INTO tblfilmsactorroles(strCharacterName,memCharaterDescription,lngActorID,lngRoleTypeID,lngFilmTitleID) 
        VALUES ('$strCharacterName','$memCharaterDescription','$lngActorID','$lngRoleTypeID','$lngFilmTitleID');";
        
    $result = mysqli_query( $conn,$sql);

    $sql = "INSERT INTO tblfilmtitlesproducers(lngFilmTitleID,lngProducerID) 
        VALUES ('$lngFilmTitleID','$lngProducerID');";
    $result = mysqli_query( $conn,$sql);

    if ($result) {
        header("location: production.php?search=#");
    }
}

?>
 <h2 class="text-center" style="color:white;">CREATE A PRODUCTION</h2>
  <div class="d-flex justify-content-center" style="color:white;">

    <form method="POST" action="#">
        <label>Actor</label>
            <?php 
                $resultCat = mysqli_query($conn,"SELECT * FROM tblActors;");
                echo "<select class=\"custom-select\" name=\"lngActorID\" required> ";
                while($rowCategory = mysqli_fetch_assoc($resultCat))
                {?>
                    <tr>
                    <td><option name="lngActorID" value="<?php echo $rowCategory['lngActorID'];?>" required><?php echo $rowCategory['strActorFullName'];?></option></td>
                    </tr>
            <?php }?></select> <br>

        <label>Film</label>
            <?php 
                $resultCat = mysqli_query($conn,"SELECT * FROM tblFilmTitles;");
                echo "<select class=\"custom-select\" name=\"lngFilmTitleID\" required> ";
                while($rowCategory = mysqli_fetch_assoc($resultCat))
                {?>
                    <tr>
                    <td><option name="lngFilmTitleID" value="<?php echo $rowCategory['lngFilmTitleID'];?>" required><?php echo $rowCategory['strFilmTitle'];?></option></td>
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
            <input type="text" name="strCharacterName" class="form-control" value="" required><br>
        <label>Description</label>
            <input type="text" name="memCharaterDescription" class="form-control" value="" required><br>
            
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
        <input type="submit" formaction="#" name="Submit" value="CREATE" class="btn btn-primary btn-lg btn-block"> <br>
    </div>
  </form>