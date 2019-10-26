
<?php 
include('header.php');
include('includes/guestNav.php');

$lngActorID = $_GET['lngActorId'];
$pic = $_GET['actorPicture'];
require('includes/config.php');


$sql = "CALL viewActor($lngActorID);";
$result = mysqli_query($conn,$sql);
$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
mysqli_close($conn);
?>
<body>

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
        <h1 class="text-white h1 text-center"><?php echo $data[0]['strActorFullName']?></h1>
            <img src="../pictures/profile/<?php echo $pic;?>" class="img-fluid" alt="">
        </div>

        <div class="container-fluid float-right" style="width: 60rem;margin-top: 1rem;color:white;">
        <div class="container-fluid float-right" style="width: 60rem;margin-top: 1rem;color:white;">
          <h3>Films</h3>
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
          </thead>
          <tbody>
       
          <?php
            foreach ($data AS $row)
            { ?> 
              <tr style="color:white;" class="showTrashRow">
                <td  class="text-center"> <img src="../pictures/poster/<?php echo $row['filmPicture'];?>" alt="" width="80px"></td>
                <td class="text-center"><a href="guestFilm.php?lngFilmTitleID=<?php echo $row['lngFilmTitleID'] ?>&filmPic=<?php echo $row['filmPicture'];?>?>" class="text-white">
                  <?php echo $row['strFilmTitle']; ?></a></td>
                <td class = "text-center">
                    <a href="viewActor.php?lngFilmTitleID=<?php echo $row['lngFilmTitleID'];?>&actorPicture=<?php echo $pic ?>&pic=<?php echo $row['filmPicture'];?>&lngActorId=<?php echo $lngActorID;?>&lngRoleTypeID=<?php echo $row['lngRoleTypeID'];?>" 
                    class="text-white"><?php echo $row['strCharacterName'];?></a>
                </td>
                <td class = "text-center"><?php echo $row['memCharaterDescription']; ?></td>
                <td class = "text-center"><?php echo $row['strRoleType']; ?></td>
                <td class = "text-center"><a class="text-white" href="producer.php?search=<?php echo $row['strProducerName'];?>"><?php echo $row['strProducerName'];?></a></td>
              </tr>
            <?php }
              echo "</tbody>\n";
              echo "</table>\n";
            ?> 
          </div>


          <div class="container-fluid float-right" style="width: 60rem;margin-top: 1rem;color:white;">
            <h3>Note</h3>
            <table class = "table table-bordered table-dark table-hover table-hover">
            <tbody>
              <?php
              $story = "";
              foreach ($data AS $row)
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
</body>
</html>