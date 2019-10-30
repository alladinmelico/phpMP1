<?php 
include('header.php');
session_start();
$_SESSION['db_name'] = "mysql";

//DONE: directing to login

if (isset($_SESSION['userName']) AND isset($_SESSION['userPassword']) AND (!isset($_SESSION['isAdmin']))){
  
    $conn = mysqli_connect("localhost",$_SESSION['userName'],$_SESSION['userPassword']) or die ("Could not connect!\n");

    mysqli_select_db($conn,"mysql") or die ("Could not select the Database mysql!\n".mysqli_error());


    $userName = mysqli_real_escape_string($conn,$_SESSION['userName']);
    $userPassword = mysqli_real_escape_string($conn,$_SESSION['userPassword']);
    
    if (($_SESSION['userName'] == "filmGuest") AND ($_SESSION['userPassword']) == "password"){
        header("location: login.php");
    } else
        {
          $_SESSION['db_name'] = "mysql";
            $sql = "SELECT * FROM USER ur
            WHERE ur.user = '$userName' AND ur.Password = PASSWORD('$userPassword')";


            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_array($result);

            // echo $sql;
            // echo $_SESSION['db_name'];

            $_SESSION['db_name'] = "db_mp1";

            if(($row[0] == NULL)){
                header("location: login.php");
                echo "no match";
            } else {
              $_SESSION['isAdmin'] = true;
            }
        }
} 
$_SESSION['db_name'] = "db_mp1";
include('includes/navigation.php');
?>



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


<?php
include ('includes/config.php');
$_SESSION['userName'] = "filmGuest";
$_SESSION['userPassword'] = "password";
$searchInput = "";
?>


<form action="#" method = "GET" class="container-fluid mx-auto" style="width: 40rem;margin-top:5rem;" >
    <div class = "input-group">
        <input type="text" name="searchInput" value="<?php echo $searchInput ?>" class = "form-control">
        <div class="input-group-append">
            <input type="submit" value="Search" class="btn btn-info" style=" background: #11998e;
                background: -webkit-linear-gradient(to right, #11998e, #38ef7d);
                background: linear-gradient(to right, #11998e, #38ef7d);">
        </div>
    </div>
</for>
<?php
if (($_SERVER["REQUEST_METHOD"] == "GET") AND isset($_GET['searchInput']))
{
    $strSearch = mysqli_real_escape_string($conn,$_GET['searchInput']);
} else {
    $strSearch = "";
}

$date = date('Y-m-d');
$newdate = strtotime ( '-10 year' , strtotime ( $date ) ) ;
$newdate = date ( 'Y-m-d' , $newdate );
$advDate = strtotime ( '+10 year' , strtotime ( $date ) ) ;
$advDate = date ( 'Y-m-d' , $advDate );

$sql = "call getAllFilms('$newdate','$advDate','$strSearch');";
$result = mysqli_query( $conn,$sql);

while ($row = mysqli_fetch_array($result))
{?>
    <tr style="color:white;" ">
        <td>
          <div class="container-fluid mx-auto " style="width: 40rem;margin-top:5rem;" >
        <div class="card mb-3 box shadow p-2 cardBg" style="max-width: 40rem; background-image: url('../pictures/bg/5c289afb9a157510e6893a57_29. Pale Cornflower Blue.jpg');" >
          <div class="row no-gutters ">
            <div class="col-md-4 ">
              <img src="../pictures/poster/<?php echo $row['picture']; ?>" class="card-img rounded-lg shadow p-2" alt="" style="margin-left:0.1rem;">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title font-weight-bold text-center mb-5"><?php echo $row['strFilmTitle'] ?>
                  <a href="viewFilm.php?lngFilmTitleID=<?php echo ($row['lngFilmTitleID']);?>&filmPic=<?php echo $row['picture']; ?>"
                     class="float-right "><img src="../pictures\icons\arrow-pointing-right-in-a-circle.png" alt="" width=50 class="rounded-circle shadow p-2"></a></h5>
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
                <strong><p><img src="../pictures\icons\time.png" alt="" width=20em style="margin-right:0.6em;">
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

</body>
</html>