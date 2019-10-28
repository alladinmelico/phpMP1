
<?php 
include('header.php');
include('includes/guestNav.php');

$lngFilmTitleID = $_GET['lngFilmTitleID'];
$pic = $_GET['filmPic'];
require('includes/config.php');

$data = array();
$sql = "CALL selectFilm('$lngFilmTitleID');";
$sql .= "SELECT prod.lngProducerID, prod.strProducerName, ftp.lngFilmTitleID FROM tblProducers prod LEFT JOIN tblfilmtitlesproducers ftp ON ftp.lngProducerID = prod.lngProducerID 
          GROUP BY prod.lngProducerID HAVING (ftp.lngFilmTitleID <> '$lngFilmTitleID') OR (ftp.lngFilmTitleID IS NULL);";
$sql .= "CALL selectFilmProducers('$lngFilmTitleID');";
$sql .= "call getFilmCertGenre('$lngFilmTitleID')";


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
        <h1 class="text-white h1 text-center"><?php echo $data[0][0]['strFilmTitle']?></h1>
            <img src="../pictures/poster/<?php echo ($pic);?>" class="border border-white img-fluid  rounded-lg" alt="">
        </div>

        <div class="container-fluid float-right" style="width: 60rem;margin-top: 1rem;color:white;">
          <div class="container-fluid float-left" style="width: 20rem;margin-top: 3rem;color:white;">
          <h3>Producer</h3>
              <table class="table table-dark table-hover">
                <tbody style="color:white;">
                  <?php $temp = array();
                     foreach ($data[2] AS $row)
                     {
                       array_push($temp,$row['strProducerName']);
                     } 
                     $genre = array_unique($temp,SORT_REGULAR);
                     function getProdID($strProd = "")
                        {
                          global $data;
                          foreach ($data AS $row)
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
                        </tr>
                     <?php }
                  ?>
                </tbody>
              </table>
            </div>
          <div class="container-fluid float-right" style="width: 20rem;margin-top: 3rem;color:white;">
          <h3>Certificate</h3>
              <table class="table table-dark table-hover">
                <tbody style="color:white;">
                  <?php $temp = array();
                     foreach ($data[3] AS $row)
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
            <h3>Genre</h3>
              <table class="table table-dark table-hover">
                <tbody style="color:white;">
                  <?php $genreTemp = array();
                     foreach ($data[3] AS $row)
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
          <h3>Cast</h3>
          <table class = "table table-bordered table-dark table-hover table-hover">
          <thead style=" background: #11998e;
                background: -webkit-linear-gradient(to right, #11998e, #38ef7d);
                background: linear-gradient(to right, #11998e, #38ef7d);">
            <th scope="col" class="text-center"></th>
            <th scope="col" class="text-center">Name</th>
            <th scope="col" class="text-center">Character</th>
            <th scope="col" class="text-center">Description</th>
          </thead>
          <tbody>
            <?php
            foreach ($data[0] AS $row)
            { ?>
              <tr style="color:white;" class="showTrashRow">
                <td  class="text-center"> <img src="../pictures/profile/<?php echo $row['actPic'];?>" alt="" width="80px"></td>
                <td class="text-center"><a href="guestActor.php?lngActorId=<?php echo $row['lngActorID'];?>&actorPicture=<?php echo $row['actPic'];?>" class="text-white">
                  <?php echo $row['strActorFullName']; ?></a></td>
                <td class = "text-center"><?php echo $row['strCharacterName']; ?></td>
                <td class = "text-center"><?php echo $row['memCharaterDescription']; ?></td>
              </tr>
            <?php }
              echo "</tbody>\n";
              echo "</table>\n";
            ?>
          </div>


          <div class="container-fluid float-right" style="width: 60rem;margin-top: 1rem;color:white;">
            <h3>Story</a>
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

</body>
</html>