<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP WEB</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />

    <link rel="stylesheet" href="datePicker/css/bootstrap-datepicker.css">
    <script src="datePicker/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css" />
  </head>
<style>
.parallax {
    background-attachment: fixed;
    min-height: 500px;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    vertical-align: middle;
    background-position: 50% 15%;
}

.cardBg{
  background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    min-height: 100px;
    background-size: cover;
    vertical-align: middle;
    background-position: 50% 50%;
}

body{
  background-image: radial-gradient( circle farthest-corner at -4% -12.9%,  rgba(74,98,110,1) 0.3%, rgba(30,33,48,1) 90.2% );
}

</style>
<script type="text/javascript">
$('.toast').toast('show');
  $(function () {
  $('[data-toggle="popover"]').popover()
})
</script>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background: #11998e;
                background: -webkit-linear-gradient(to right, #11998e, #38ef7d);
                background: linear-gradient(to right, #11998e, #38ef7d);">
  
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <a class="navbar-brand" href="index.php" style="font-size:2rem;">
      <img src="pictures\icons\home.png" alt="" width=30>  Home
    </a>
  </div>

      <form action="script/globalSearch.php" style="width:20rem;" class="form-inline">
        <div class="input-group">
          <input type="search" placeholder="Search" name="search" value="" class="form-control">
          <div class="input-group-append">
            <input type="submit" value="SEARCH"  class="btn btn-outline-dark form-control" >
          </div>
        </div>
      </form>
    
    <a href="script/login.php" class="text-decoration-none text-dark" style="font-size:2rem;">
      <img src="pictures\icons\user-shape.png" alt="" width=30>   Login
    </a>
</nav>



<?php
include ('script/includes/config.php');
$_SESSION['userName'] = "filmGuest";
$_SESSION['userPassword'] = "password";
$pics = array();
$resultSlider = mysqli_query( $conn,"SELECT * FROM tblfilmtitles;" );
while ($rowSlider =  mysqli_fetch_array($resultSlider)){
  $pics[] = $rowSlider['picture'];
}?>

  <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" style = "height:500px;">
    <div class="carousel-inner">
      <div class="carousel-item active parallax" data-interval="750" style="background-image: url('pictures/poster/<?php echo $pics[0];?>');">
      </div>
        <?php $slideNum= 1;
        foreach ($pics as $pic){?>
            <div class="carousel-item parallax" data-interval="750" style="background-image: url('pictures/poster/<?php echo $pic;?>');">
            </div>
        <?php } ?>
    </div>

    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon " aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>

  
  <?php
include ('script/includes/indexFilter.php');
if (($_SERVER["REQUEST_METHOD"] == "GET") AND isset($_GET['searchInput']))
{
    $strSearch = mysqli_real_escape_string($conn,$_GET['searchInput']);
    $dtmBegin = date_format(new DateTime($_GET['dtmBegin']), "Y-m-d");
    $dtmEnd =  date_format(new DateTime($_GET['dtmEnd']), "Y-m-d");
} else {
    $strSearch = "";
    $dtmBegin = date("Y-m-d");
    $dtmEnd = date("Y-m-d");
}
$sql = "call getAllFilms('$dtmBegin','$dtmEnd','$strSearch');";
$result = mysqli_query( $conn,$sql);
while ($row = mysqli_fetch_array($result))
{?>
    <tr style="color:white;" ">
        <td>
          <div class="container-fluid mx-auto " style="width: 40rem;margin-top:5rem;" >
        <div class="card mb-3 box shadow p-2 cardBg" style="max-width: 40rem; background-image: url('pictures/bg/5c289afb9a157510e6893a57_29. Pale Cornflower Blue.jpg');" >
          <div class="row no-gutters ">
            <div class="col-md-4 ">
              <img src="pictures/poster/<?php echo $row['picture']; ?>" class="card-img rounded-lg shadow p-2" alt="" style="margin-left:0.1rem;">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title font-weight-bold text-center mb-5"><?php echo $row['strFilmTitle'] ?>
                  <a href="script/viewFilm.php?lngFilmTitleID=<?php echo ($row['lngFilmTitleID']);?>&filmPic=<?php echo $row['picture']; ?>"
                     class="float-right "><img src="pictures\icons\arrow-pointing-right-in-a-circle.png" alt="" width=50 class="rounded-circle shadow p-2"></a></h5>
                <p class="card-text"><strong>Cast: </strong><?php echo $row['actors']?></p>
                <p class="card-text"><strong>Genre:</strong><?php echo $row['genre']?></p>
                  <?php
                      $tempProds = explode("," ,$row['producers']);
                      $tempProdUniq = array_unique($tempProds);
                      $tempString = "";
                        foreach($tempProdUniq AS $tempProdData)
                        {
                          $tempString .= (", ". $tempProdData);
                        }
                        $tempString = substr($tempString, 1);
                   ?>
                <p class="card-text"><strong>Producers:</strong><?php echo $tempString;?></p>
                <strong><p><img src="pictures\icons\time.png" alt="" width=20em style="margin-right:0.6em;">
                  <?php echo intdiv($row['intFilmDuration'],60)?>hr 
                  <?php echo fmod($row['intFilmDuration'],60)?> mins</p></strong>
                <p class="card-text"><small class="text-muted">
                  <div class="text-truncate wrap bd-highlight" style="max-width: 55ch;">
                    <?php echo $row['memFilmStory']?>
                  </div>
                  <!-- <a href='script/editFilm.php?lngFilmTitleID="<?php echo ($row['lngFilmTitleID']);?>"'><i>read more</i></a> -->
                  <button type="button" class="btn btn-sm btn-info shadow p-2" data-toggle="popover" title="Film Story"
                   data-content="<?php echo $row['memFilmStory'];?>">read more</button>
                </small></p>
                
              </div>
            </div>
          </div>
        </div>
        </div>
      </td>
    </tr>
    <?php
    }
    echo "</tbody>\n";
    echo "</table>\n";
    mysqli_free_result($result);
    mysqli_close( $conn );
?>

<div class="position-relative w-100 d-flex flex-column p-4">
    <div class="toast ml-auto" role="alert" data-delay="100" data-autohide="false">
        <div class="toast-header">
            <strong class="mr-auto text-primary">Toast</strong>
            <small class="text-muted">3 mins ago</small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="toast-body">
            This is a simple toast, not working...
        </div>
    </div>
</div

</body>
</html>
