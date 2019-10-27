
<?php 
include('header.php');
include('includes/navigation.php');

$lngActorID = $_GET['lngActorId'];
$pic = $_GET['actorPicture'];
require('includes/config.php');

$data = array();
$sql = "CALL selectActor('$lngActorID');";
$sql .= "SELECT lngFilmTitleID,strFilmTitle FROM tblFilmTitles;";
$sql .= "SELECT * FROM tblroletypes;";
$sql .= "SELECT * FROM tblActors WHERE lngActorID = $lngActorID;";


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
<?php 
$delRole = false;
$showRole = false;
if (isset($_GET['lngRoleTypeID']))
{ 
    $showRole = true;
} else if (isset($_GET['lngFilmTitleID']))
{
    $delRole = true ;
}
?>
<script type="text/javascript">
    if (<?php echo $delRole ? 'true':'false';?>)
    {
        $(document).ready(function(){
            $("#ModalDel").modal('show');
	})}
        else if(<?php echo $showRole  ? 'true':'false';;?>)
        {
            $(document).ready(function(){
                $("#ModalAct").modal('show');
        })}
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
  background-image: url("../pictures/bg/5c289afb9a15757764893a6b_39. Prelude.jpg");
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
        <h1 class="text-white h1 text-center"><?php echo $data[3][0]['strActorFullName'];?></h1>
            <img src="../pictures/profile/<?php echo $pic;?>" class="img-fluid" alt="">
        </div>

        <div class="container-fluid float-right" style="width: 60rem;margin-top: 1rem;color:white;">
        <div class="container-fluid float-right" style="width: 60rem;margin-top: 1rem;color:white;">
          <h3>Films <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalAct">
          
          <img src="../pictures\icons\plus-symbol-in-a-rounded-black-square.png" alt="" width="20px" class="rounded-circle bg-light"></button> </h3>
          <table class = "table table-bordered table-dark table-hover table-hover">
          <thead style=" background: #11998e;
                background: -webkit-linear-gradient(to right, #11998e, #38ef7d);
                background: linear-gradient(to right, #11998e, #38ef7d);">
            <th scope="col" class="text-center"></th>
            <th scope="col" class="text-center">Title</th>
            <th scope="col" class="text-center">Character</th>
            <th scope="col" class="text-center">Description</th>
            <th scope="col" class="text-center">Role</th>
            <th scope="col" class="text-center">Producer</th>
            <th scope="col" class="text-center"></th>
          </thead>
          <tbody>
            <?php
            foreach ($data[0] AS $row)
            { ?>
              <tr style="color:white;" class="showTrashRow">
                <td  class="text-center"> <img src="../pictures/poster/<?php echo $row['filmPicture'];?>" alt="" width="80px"></td>
                <td class="text-center"><a href="viewFilm.php?lngFilmTitleID=<?php echo $row['lngFilmTitleID'] ?>&filmPic=<?php echo $row['filmPicture'];?>?>" class="text-white">
                  <?php echo $row['strFilmTitle']; ?></a></td>
                <td class = "text-center">
                    <a href="viewActor.php?lngFilmTitleID=<?php echo $row['lngFilmTitleID'];?>&actorPicture=<?php echo $pic ?>&pic=<?php echo $row['filmPicture'];?>&lngActorId=<?php echo $lngActorID;?>&lngRoleTypeID=<?php echo $row['lngRoleTypeID'];?>" 
                    class="text-white"><?php echo $row['strCharacterName'];?></a>
                </td>
                <td class = "text-center"><?php echo $row['memCharaterDescription']; ?></td>
                <td class = "text-center"><?php echo $row['strRoleType']; ?></td>
                <td class = "text-center"><a class="text-white" href="producer.php?search=<?php echo $row['strProducerName'];?>"><?php echo $row['strProducerName'];?></a></td>
                <td class = "text-center bg-danger">
                    <a href="viewActor.php?lngActorId=<?php echo $row['lngActorID'];?>&actorPicture=<?php echo $pic ?>&strFilmTitle=<?php echo $row['strFilmTitle']; ?>&lngFilmTitleID=<?php echo $row['lngFilmTitleID'];?>&pic=<?php echo $row['filmPicture'];?>" 
                      class="btn-sm btn-danger"><img src="../pictures\icons\trash.png" alt="" width=20;></a>
                </td>
              </tr>
            <?php }
              echo "</tbody>\n";
              echo "</table>\n";
            ?>
          </div>


          <div class="container-fluid float-right" style="width: 60rem;margin-top: 1rem;color:white;">
            <h3>Note <a href="createActor.php?lngActorID=<?php echo $lngActorID; ?>"><button type="button" class="btn btn-info">
            <img src="../pictures\icons\edit-interface-sign.png" alt="" width="20px" class="rounded-circle bg-light"></button></a> </h3>
            <table class = "table table-bordered table-dark table-hover table-hover">
            <tbody>
              <?php
              $story = "";
              foreach ($data[3] AS $row)
              {
                $story = $row['memActorNotes'];
              } ?>
              <tr style="color:white;" class="showTrashRow">
                  <td class="text-justify font-weight-light p-3"><?php echo $story; ?></td>
              </tr>
            </tbody>
            </table>
          </div>  
  </div>


<!-- MODALS -->

<!-- Delete Confimation -->
<div class="modal fade" id="ModalDel" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalCenterTitle">Remove</h5>
                <a href="viewActor.php?lngActorId=<?php echo $lngActorID?>&actorPicture=<?php echo $pic ?>">X</a>
                </button>
            </div>
            <div class="modal-body">
                <?php 
                    $strActorName = $data[0][0]['strActorFullName'];
                    $strFilmTitle = $_GET['strFilmTitle'];
                ?>
                <form action="addActor.php" method="GET">
                <input type="hidden" name="lngActorID" value="<?php echo $_GET['lngActorId'];?>">
                <input type="hidden" name="lngFilmTitleID" value="<?php echo $_GET['lngFilmTitleID'];?>">
                <input type="hidden" name="pic" value="<?php echo $pic;?>">
                <input type = "hidden" name="viewActor" value="true"> 
                <h4 class="text-center">Are you sure you want remove <strong><?php echo $strActorName;?></strong> from <strong><?php echo $strFilmTitle;?>?</strong> </h4>
                <img src="../pictures/poster/<?php echo $_GET['pic'];?>" alt="" class="img-thumbnail mx-auto d-block" width=100>
            </div>
            <div class="modal-footer">
                <a href="viewActor.php?lngActorId=<?php echo $lngActorID?>&actorPicture=<?php echo $pic;?>"><button type="button" class="btn btn-secondary">Close</button></a>
                    <button type="submit" class="btn btn-danger" name="delete"
                            value="Delete">Remove</button>
                </form>
            </div>
            </div>
        </div>
    </div>

<!-- Actors -->
<?php
$strCharacterName = "";
$strRoleType = "Choose...";
$memCharaterDescription = "";
$strActorFullName = "Choose...";
$process = "ADD";

if (isset($_GET['lngRoleTypeID']))
{
  $lngActorID = $_GET['lngActorId'];
  foreach($data[0] AS $row)
  {
    if ($lngActorID == $row['lngActorID'])
    {
      $strCharacterName = $row['strCharacterName'];
      $strRoleType = $row['strRoleType'];
      $lngRoleTypeId = $row['lngRoleTypeID'];
      $memCharaterDescription = $row['memCharaterDescription'];
      $strActorFullName = $row['strActorFullName'];
      $strFilmTitle = $row['strFilmTitle'];
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
              <h5 class="modal-title" id="ModalCenterTitle">Films</h5>
              <a href="viewActor.php?lngActorId=<?php echo $lngActorID?>&actorPicture=<?php echo $pic ?>">X</a>
              </button>
          </div>
          <div class="modal-body">
              <form action="addActor.php" method="POST">
                    <input type="hidden" name="pic" value="<?php echo $pic; ?>">
                    <input type="hidden" name="lngActorID" value="<?php echo $lngActorID?>">
                    <input type="hidden" name="viewActor" value = "true ">
                    <label>Film</label>
                    <select class="custom-select" name="lngFilmTitleID" required>
                    <option name="lngFilmTitleID" value="<?php echo $lngFilmTitleID?>" required><?php echo $strFilmTitle;?></option>;
                    <?php foreach($data[1] AS $film)
                    {?>
                        <tr>
                            <td><option name="lngFilmTitleID" value="<?php echo $film['lngFilmTitleID']?>" required><?php echo $film['strFilmTitle'];?></option></td>
                        </tr>
                    <?php }?>
                    </select> <br>
                    <br>
                    <label>Role</label><br>
                    <select class="custom-select" name="lngRoleTypeID" required>
                    <option name="lngRoleTypeID" value="<?php echo $lngRoleTypeId?>" required><?php echo $strRoleType?></option>;
                    <?php foreach($data[2] AS $act)
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
            <a href="viewActor.php?lngActorId=<?php echo $lngActorID?>&actorPicture=<?php echo $pic ?>"
                    <button type="button" class="btn btn-secondary">Close</button></a>
                  <button type="submit" class="btn btn-primary" name="submit" value="<?php echo $process;?>"><?php echo $process;?></button>
              </form>
          </div>
          </div>
      </div>
    </div>

</body>
</html>