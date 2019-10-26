<?php
include('includes/guestNav.php');
include('header.php')
?>

<ul class="nav nav-tabs mt-5" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active text-info" id="actor-tab" data-toggle="tab" href="#actor" role="tab" aria-controls="actor" aria-selected="true">Actor</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-info" id="film-tab" data-toggle="tab" href="#film" role="tab" aria-controls="film" aria-selected="false">Film</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-info" id="producer-tab" data-toggle="tab" href="#producer" role="tab" aria-controls="producer" aria-selected="false">Producer</a>
  </li>
</ul>


<div class="tab-content bg-white text-info" id="myTabContent">
  <div class="tab-pane fade show active" id="actor" role="tabpanel" aria-labelledby="actor-tab">
        <?php 
                
                include ('includes/config.php');
                if (isset($_GET['search']))
                {
                $search = $_GET['search'];
                $result = mysqli_query( $conn,"SELECT * FROM tblactors WHERE strActorFullName LIKE '%". $search."%';" );
                $num_rows = mysqli_num_rows( $result ); ?>
                
                <br>
                <div class="bs-example">
                <table width=375 class="table table-hover ">
                    <thead>
                        <th scope="col" class="text-center"></th>
                        <th scope="col" class="text-center"><img src="../pictures\icons\user-shape.png" alt="" width="20px"> Name</th>
                        <th scope="col"class="text-center"><img src="../pictures\icons\text-file.png" alt="" width="20px"> Actor Notes</th>
                        </tr>
                    <thead class="table table-striped">
                    <tbody>
                <?php
                
                while ($row = mysqli_fetch_array($result))
                { ?>
                <form action="#" method="POST">
                <tr class="text-dark">
                    <input type="hidden" name="pic" value="<?php echo $row['picture'];?>">
                    <input type="hidden" name="actName" value="<?php echo $row['strActorFullName'];?>">
                    <input type="hidden" name="actID" value="<?php echo $row['lngActorID'];?>">
                    <input type="hidden" name="search" value="">
                    <td class="text-center"><img src="../pictures/profile/<?php echo $row['picture'];?>" alt="" width="80px"></td>
                    <td class="text-center">
                        <a href="guestActor.php?lngActorId=<?php echo $row['lngActorID']?>&actorPicture=<?php echo $row['picture']?>">
                            <?php echo $row['strActorFullName'];?>
                        </a>
                    </td>
                    <td class="text-center"><?php echo $row['memActorNotes'];?></td>
                    </a>
                    </td>
                    </form>
                </tr>
                <?php
                }
                echo "</tbody>\n";
                echo "</table>\n";
                mysqli_free_result($result);
                mysqli_close( $conn );
                }
                ?>
            </div>
  </div>

  <div class="tab-pane fade bg-white text-info" id="film" role="tabpanel" aria-labelledby="film-tab">
    <?php 
            include ('includes/config.php');
            if (isset($_GET['search']))
            {
            $search = $_GET['search'];
            $result = mysqli_query( $conn,"SELECT * FROM tblFilmTitles film INNER JOIN tblFilmGenres genre
                on film.lngGenreID = genre.lngGenreID INNER JOIN tblFilmCertificates certi on certi.lngCertificateID = film.lngCertificateID
                    WHERE film.strFilmTitle LIKE '%". $search."%';" );
            $num_rows = mysqli_num_rows( $result ); ?>
            <br>
            <div class="bs-example">
            <table width=375 class="table table-hover ">
                <thead >
                    <tr style="font-size:1em;">
                    <th scope="col" class="text-center"></th>
                    <th scope="col" class="text-center"><img src="../pictures\icons\film-strip-with-two-photograms.png" alt="" width="20px">  Title</th>
                    <th scope="col"class="text-center"><img src="../pictures\icons\home.png" alt="" width="20px">  Story</th>
                    <th scope="col"class="text-center"><img src="../pictures\icons\calendar-page-empty.png" alt="" width="20px">  Date</th>
                    <th scope="col"class="text-center"><img src="../pictures\icons\time.png" alt="" width="20px">  Duration</th>
                    <th scope="col"class="text-center"><img src="../pictures\icons\information-button.png" alt="" width="20px">  Info</th>
                    <th scope="col"class="text-center"><img src="../pictures\icons\ticket.png" alt="" width="20px">  Genre</th>
                    <th scope="col"class="text-center"><img src="../pictures\icons\certificate-shape.png" alt="" width="20px">  Certificate</th>
                    </tr>
                <thead class="table table-striped">
                <tbody>
            <?php
            while ($row = mysqli_fetch_array($result))
            { ?>
            <tr>
                <td class="text-center"><img src="../pictures/poster/<?php echo $row['picture'];?>" alt="" width="80px"></td>
                <td class="text-center">
                    <a href="guestFilm.php?lngFilmTitleID=<?php echo $row['lngFilmTitleID'];?>&filmPic=<?php echo $row['picture'];?>"><?php echo $row['strFilmTitle'];?></a>
                </td>
                <td class="d-inline-block text-truncate" style="max-width: 150px;"><?php echo $row['memFilmStory'];?></td>
                <td class="text-center"><?php echo $row['dtmFilmReleaseDate'];?></td>
                <td class="text-center"><?php echo $row['intFilmDuration'];?></td>
                <td class="d-inline-block text-truncate" style="max-width: 150px;"><?php echo $row['memFilmAdditionalInfo'];?></td>
                <td class="text-center"><?php echo $row['strGenre'];?></td>
                <td class="text-center"><?php echo $row['strCertificate'];?></td></tr>
            <?php
            }
            echo "</tbody>\n";
            echo "</table>\n";
            mysqli_free_result($result);
            mysqli_close( $conn );
            }
            ?>
        </div>
  </div>


  <div class="tab-pane fade bg-white text-info" id="producer" role="tabpanel" aria-labelledby="producer-tab">
        <?php 
            include ('includes/config.php');
            if (isset($_GET['search']))
            {
            $search = $_GET['search'];
            $result = mysqli_query( $conn,"SELECT * FROM tblProducers WHERE strProducerName LIKE '%". $search."%';" );
            $num_rows = mysqli_num_rows( $result ); ?>
            <br>
            <div class="bs-example">
            <table width=375 class="table table-hover ">
                <thead>
                    <tr style="font-size:1em;">
                    <th scope="col" class="text-center"><img src="../pictures\icons\facetime-button.png" alt="" width="20px">  Name</th>
                    <th scope="col"class="text-center"><img src="../pictures\icons\envelope.png" alt="" width="20px">  Email</th>
                    <th scope="col"class="text-center"><img src="../pictures\icons\earth-globe.png" alt="" width="20px">  Website</th>
                    </tr>
                <thead class="table table-striped">
                <tbody>
            <?php
            while ($row = mysqli_fetch_array($result))
            { ?>
            <tr>
                <td class="text-center"><?php echo $row['strProducerName'];?></td>
                <td class="text-center"><?php echo $row['hypContactEmailAddress'];?></td>
                <td class="text-center"><?php echo $row['hypWebsite'];?></td>
                </tr>
            <?php
            }
            echo "</tbody>\n";
            echo "</table>\n";
            mysqli_free_result($result);
            mysqli_close( $conn );
            }
        ?>
  </div>
</div>