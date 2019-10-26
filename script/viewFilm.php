
<?php 
include('header.php');
include('includes/navigation.php');

$lngFilmTitleID = $_GET['lngFilmTitleID'];
$pic = $_GET['filmPic'];
require('includes/config.php');

$data = array();
$sql = "CALL selectFilm('$lngFilmTitleID');";
$sql .= "SELECT prod.lngProducerID, prod.strProducerName, ftp.lngFilmTitleID FROM tblProducers prod LEFT JOIN tblfilmtitlesproducers ftp ON ftp.lngProducerID = prod.lngProducerID 
          GROUP BY prod.lngProducerID HAVING (ftp.lngFilmTitleID <> '$lngFilmTitleID') OR (ftp.lngFilmTitleID IS NULL);";
$sql .= "SELECT * FROM tblActors;";
$sql .= "SELECT * FROM tblfilmgenres;";
$sql .= "SELECT * FROM tblfilmcertificates;";
$sql .= "CALL selectFilmProducers('$lngFilmTitleID');";
$sql .= "SELECT * FROM tblroletypes;";


if (mysqli_multi_query($conn,$sql)){
  do{
     if ($result=mysqli_store_result($conn)){
        $data[] = mysqli_fetch_all($result,MYSQLI_ASSOC);
     }
  }while (mysqli_next_result($conn));
}
mysqli_close($conn);

?>
<body>
<script type="text/javascript">
    if (<?php 
        if (isset($_GET['lngActorID']))
            { echo "true" ;}
             else echo "false";?>){
	$(document).ready(function(){
		$("#ModalAct").modal('show');
	})};
</script>

<style>
.content:before {
  content: "";
  position: fixed;
  top: -5%;
  left: -5%;
  right: 0;
  bottom: 0;
  z-index: -1;
  
  display: block;
  background-image: url("../pictures/poster/<?php echo $pic; ?>");
  background-size:cover;
  width: 110%;
  height: 110%;
  filter: brightness(10%);
}

.popBg{
  background-image: linear-gradient(to top, #cfd9df 0%, #e2ebf0 100%);
}
.content {
  overflow: auto;
  position: relative;
}

// useless after this point, example

.content p {
  margin: 15px;
  background: rgba(255, 255, 255, 0.3);
  padding: 5px;
  box-shadow: 0 0 5px gray;
}

.showTrash {
  display: none;
}

.showTrashRow:hover .showTrash {
  display: block;
}

</style>

    <div class="content font-weight-light">
        <div class="container-fluid float-left " style="width: 20rem;margin-top: 3rem;margin-left:3 rem;position:fixed;">
            <img src="../pictures/poster/<?php echo ($pic);?>" class="border border-white img-fluid  rounded-lg" alt="">
        </div>

        <div class="container-fluid float-right" style="width: 60rem;margin-top: 1rem;color:white;">
          <div class="container-fluid float-left" style="width: 20rem;margin-top: 3rem;color:white;">
          <h3>Producer  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalCenter">
            <img src="../pictures\icons\plus-symbol-in-a-rounded-black-square.png" alt="" width="20px" class="rounded-circle bg-light"></button></h3>
              <table class="table table-dark table-hover">
                <tbody style="color:white;">
                  <?php $temp = array();
                     foreach ($data[5] AS $row)
                     {
                       array_push($temp,$row['strProducerName']);
                     } 
                     $genre = array_unique($temp,SORT_REGULAR);
                     function getProdID($strProd = "")
                        {
                          global $data;
                          foreach ($data[5] AS $row)
                          {
                            if ($row['strProducerName'] == $strProd)
                            {
                              return $row['lngProducerID'];
                            }
                          }
                        }
                     foreach ($genre AS $element){ ?>
                        <tr class="showTrashRow">
                          <td class="text-left"><?php echo $element;?></td>
                          <td>
                              <div class="showTrash">
                                <a href="addProducer.php?lngProducerID=<?php echo getProdID($element);?>&lngFilmTitleID=<?php echo $lngFilmTitleID;?>&pic=<?php echo $pic;?>" 
                                  class="btn-sm btn-danger">X</a></div>
                          </td>
                        </tr>
                     <?php }
                  ?>
                </tbody>
              </table>
            </div>
          <div class="container-fluid float-right" style="width: 20rem;margin-top: 3rem;color:white;">
          <h3>Certificate  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalCert">
            <img src="../pictures\icons\cog-wheel-silhouette.png" alt="" width="20px"></button></h3>
              <table class="table table-dark table-hover">
                <tbody style="color:white;">
                  <?php $temp = array();
                     foreach ($data[0] AS $row)
                     {
                       array_push($temp,$row['strCertificate']);
                     } 
                     $cert = array_unique($temp,SORT_REGULAR);
                     foreach ($cert AS $element){ ?>
                        <tr>
                          <td class="text-center"><?php echo $element; ?></td>
                        </tr>
                     <?php }
                  ?>
                </tbody>
              </table>
          </div>
          <div class="container-fluid float-none" style="width: 20rem;margin-top: 3rem;color:white;">
            <h3>Genre  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalGenre">
            <img src="../pictures\icons\cog-wheel-silhouette.png" alt="" width="20px"></button></h3>
              <table class="table table-dark table-hover">
                <tbody style="color:white;">
                  <?php $genreTemp = array();
                     foreach ($data[0] AS $row)
                     {
                       array_push($genreTemp,$row['strGenre']);
                     } 
                     $genre = array_unique($genreTemp,SORT_REGULAR);
                     foreach ($genre AS $gen){ ?>
                        <tr>
                          <td class="text-center"><?php echo $gen; ?></td>
                        </tr>
                     <?php }
                  ?>
                </tbody>
              </table>
          </div>
          </div>

        <div class="container-fluid float-right" style="width: 60rem;margin-top: 1rem;color:white;">
          <h3>Cast <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalAct">
          <img src="../pictures\icons\plus-symbol-in-a-rounded-black-square.png" alt="" width="20px" class="rounded-circle bg-light"></button> </h3>
          <table class = "table table-bordered table-dark table-hover table-hover">
          <thead style=" background: #11998e;
                background: -webkit-linear-gradient(to right, #11998e, #38ef7d);
                background: linear-gradient(to right, #11998e, #38ef7d);">
            <th scope="col" class="text-center"></th>
            <th scope="col" class="text-center">Name</th>
            <th scope="col" class="text-center">Character</th>
            <th scope="col" class="text-center">Description</th>
            <th scope="col" class="text-center"></th>
          </thead>
          <tbody>
            <?php
            foreach ($data[0] AS $row)
            { ?>
              <tr style="color:white;" class="showTrashRow">
                <td  class="text-center"> <img src="../pictures/profile/<?php echo $row['actPic'];?>" alt="" width="80px"></td>
                <td class="text-center"><a href="viewFilm.php?lngFilmTitleID=<?php echo $lngFilmTitleID ?>&filmPic=<?php echo $pic; ?>&lngActorID=<?php echo $row['lngActorID'] ?>" class="text-white">
                  <?php echo $row['strActorFullName']; ?></a></td>
                <td class = "text-center"><?php echo $row['strCharacterName']; ?></td>
                <td class = "text-center"><?php echo $row['memCharaterDescription']; ?></td>
                <td class = "text-center">
                  <div class="showTrash">
                    <a href="addActor.php?lngActorID=<?php echo $row['lngActorID'];?>&lngFilmTitleID=<?php echo $lngFilmTitleID;?>&pic=<?php echo $pic;?>" 
                      class="btn-sm btn-danger">X</a>
                  </div>
                </td>
              </tr>
            <?php }
              echo "</tbody>\n";
              echo "</table>\n";
            ?>
          </div>


          <div class="container-fluid float-right" style="width: 60rem;margin-top: 1rem;color:white;">
            <h3>Story <a href="createFilm.php?lngFilmTitleID=<?php echo $lngFilmTitleID; ?>"><button type="button" class="btn btn-info">
              <img src="../pictures\icons\edit-interface-sign.png" alt="" width="20px" class="rounded-circle bg-light"></button></a>
            </h3>
            <table class = "table table-bordered table-dark table-hover table-hover">
            <tbody>
              <?php
              $story = "";
              foreach ($data[0] AS $row)
              {
                $story = $row['memFilmStory'];
              } ?>
              <tr style="color:white;" class="showTrashRow">
                  <td class="text-justify font-weight-light p-3"><p>&emsp;&emsp;&emsp;<?php echo $story; ?></p></td>
              </tr>
            </tbody>
            </table>
          </div>  
  </div>


<!-- MODALS -->
<!-- Producer -->
    <div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
          <div class="modal-header text-white bg-info">
              <h5 class="modal-title" id="ModalCenterTitle">Choose the Producer you want to add</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form action="addProducer.php" method="POST">
              <label>Producer</label>
                    <input type="hidden" name="pic" value="<?php echo $pic; ?>">
                    <input type="hidden" name="lngFilmTitleID" value="<?php echo $lngFilmTitleID?>">
                    <select class="custom-select" name="lngProducerID" required>
                    <option name="strGenre" value="" required>Choose...</option>;
                    <?php foreach($data[1] AS $prod)
                    {?>
                        <tr>
                            <td><option name="lngProducerID" value="<?php echo $prod['lngProducerID'];?>" required><?php echo $prod['strProducerName'];?></option></td>
                        </tr>
                <?php }?>
                </select> <br>
                <br>
              </div>
          <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="Submit" value="CREATE">Add</button>
              </form>
          </div>
          </div>
      </div>
    </div>


<!-- Genre -->
<div class="modal fade" id="ModalGenre" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
          <div class="modal-header text-white bg-info">
              <h5 class="modal-title" id="ModalCenterTitle">Please select the Genre</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form action="addGenre.php" method="POST">
              <label>Genre </label>
                    <input type="hidden" name="pic" value="<?php echo $pic; ?>">
                    <input type="hidden" name="lngFilmTitleID" value="<?php echo $lngFilmTitleID?>">
                    <select class="custom-select" name="lngGenreID" required>
                    <option name="lngGenreID" value="" required>Choose...</option>;
                    <?php foreach($data[3] AS $gen)
                    {?>
                        <tr>
                            <td><option name="lngGenreID" value="<?php echo $gen['lngGenreID'];?>" required><?php echo $gen['strGenre'];?></option></td>
                        </tr>
                <?php }?>
                </select> <br>
                <br>
              </div>
          <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="Submit" value="CREATE">Edit</button>
              </form>
          </div>
          </div>
      </div>
    </div>


<!-- Certificate -->
<div class="modal fade" id="ModalCert" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
          <div class="modal-header text-white bg-info">
              <h5 class="modal-title" id="ModalCenterTitle">Please select the Genre</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form action="addCertificate.php" method="POST">
              <label>Genre </label>
                    <input type="hidden" name="pic" value="<?php echo $pic; ?>">
                    <input type="hidden" name="lngFilmTitleID" value="<?php echo $lngFilmTitleID?>">
                    <select class="custom-select" name="lngCertificateID" required>
                    <option name="lngCertificateID" value="" required>Choose...</option>;
                    <?php foreach($data[4] AS $cert)
                    {?>
                        <tr>
                            <td><option name="lngCertificateID" value="<?php echo $cert['lngCertificateID']?>" required><?php echo $cert['strCertificate'];?></option></td>
                        </tr>
                <?php }?>
                </select> <br>
                <br>
              </div>
          <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="Submit" value="CREATE">Edit</button>
              </form>
          </div>
          </div>
      </div>
    </div>


<!-- Actors -->
<?php 
if (isset($_GET['lngActorID']))
{
  $lngActorID = $_GET['lngActorID'];
  foreach($data[0] AS $row)
  {
    if ($lngActorID == $row['lngActorID'])
    {
      echo $row['lngActorID'];
      $strCharacterName = $row['strCharacterName'];
      $strRoleType = $row['strRoleType'];
      $lngRoleTypeId = $row['lngRoleTypeID'];
      $memCharaterDescription = $row['memCharaterDescription'];
      $strActorFullName = $row['strActorFullName'];
      $process = "EDIT";
    }
  }
} else{
  $strCharacterName = "";
  $strRoleType = "Choose...";
  $memCharaterDescription = "";
  $strActorFullName = "Choose...";
  $process = "ADD";
}
?>
<div class="modal fade" id="ModalAct" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
          <div class="modal-header text-white bg-info">
              <h5 class="modal-title" id="ModalCenterTitle">Actors</h5>
              <a href="viewFilm.php?lngFilmTitleID=<?php echo $lngFilmTitleID;?>&filmPic=<?php echo $pic; ?>">X</a>
              </button>
          </div>
          <div class="modal-body">
              <form action="addActor.php" method="POST">
                    <input type="hidden" name="pic" value="<?php echo $pic; ?>">
                    <input type="hidden" name="lngFilmTitleID" value="<?php echo $lngFilmTitleID?>">
                    <label>Actor</label>
                    <select class="custom-select" name="lngActorID" required>
                    <option name="lngActorID" value="<?php echo $lngActorID ?>" required><?php echo $strActorFullName ?></option>;
                    <?php foreach($data[2] AS $act)
                    {?>
                        <tr>
                            <td><option name="lngActorID" value="<?php echo $act['lngActorID']?>" required><?php echo $act['strActorFullName'];?></option></td>
                        </tr>
                    <?php }?>
                    </select> <br>
                    <br>
                    <label>Role</label><br>
                    <select class="custom-select" name="lngRoleTypeID" required>
                    <option name="lngRoleTypeID" value="<?php echo $lngRoleTypeId?>" required><?php echo $strRoleType?></option>;
                    <?php foreach($data[6] AS $act)
                    {?>
                        <tr>
                            <td><option name="lngRoleTypeID" value="<?php echo $act['lngRoleTypeID']?>" required><?php echo $act['strRoleType'];?></option></td>
                        </tr>
                    <?php }?>
                    </select> <br>
                    <br>
                    <label>Character</label><br>
                    <input type="text" name="strCharacterName" value="<?php echo $strCharacterName?>"><br><br>
                    <label>Description</label>
                    <textarea name="memCharaterDescription" cols="30" rows="10" class="form-control" value="<?php echo $memCharaterDescription?>" required><?php echo $memCharaterDescription?></textarea> <br>
              </div>
          <div class="modal-footer">
                  <a href="viewFilm.php?lngFilmTitleID=<?php echo $lngFilmTitleID;?>&filmPic=<?php echo $pic;?>">
                    <button type="button" class="btn btn-secondary">Close</button></a>
                  <button type="submit" class="btn btn-primary" name="submit" value="<?php echo $process;?>"><?php echo $process;?></button>
              </form>
          </div>
          </div>
      </div>
    </div>

</body>
</html>