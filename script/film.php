<?php include ('header.php');
include('includes/navigation.php');?>
<body>
<?php 
    // DONE TODO: Add pictures to CRUD
    include ('includes/config.php');
    include ('includes/search.php');
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
        <thead style=" background: #11998e;
                background: -webkit-linear-gradient(to right, #11998e, #38ef7d);
                background: linear-gradient(to right, #11998e, #38ef7d);">
            <tr style="font-size:1em;">
            <th scope="col" class="text-center"></th>
            <th scope="col" class="text-center">#</th>
            <th scope="col" class="text-center"><img src="../pictures\icons\film-strip-with-two-photograms.png" alt="" width="40px">Title</th>
            <th scope="col"class="text-center"><img src="../pictures\icons\home.png" alt="" width="40px">Story</th>
            <th scope="col"class="text-center"><img src="../pictures\icons\calendar-page-empty.png" alt="" width="40px">Release Date</th>
            <th scope="col"class="text-center"><img src="../pictures\icons\time.png" alt="" width="40px">Film Duration</th>
            <th scope="col"class="text-center"><img src="../pictures\icons\information-button.png" alt="" width="40px">Additional Info</th>
            <th scope="col"class="text-center"><img src="../pictures\icons\ticket.png" alt="" width="40px">Genre</th>
            <th scope="col"class="text-center"><img src="../pictures\icons\certificate-shape.png" alt="" width="40px">Certificate</th>
            <th scope="col" class="text-center "><a href="createFilm.php">
                <img src="../pictures\icons\plus-symbol-in-a-rounded-black-square.png" alt="" width="40px" class="rounded-circle bg-light"></a></th>
            <th scope="col"> </th>
            </tr>
        <thead class="table table-striped">
        <tbody>
    <?php
    while ($row = mysqli_fetch_array($result))
    { ?>
    <tr style="color:white;">
        <td class="text-center"><img src="../pictures/poster/<?php echo $row['picture'];?>" alt="" width="80px"></td>
        <td class="text-center"><?php echo $row['lngFilmTitleID'];?></td>
        <td class="text-center"><?php echo $row['strFilmTitle'];?></td>
        <td class="d-inline-block text-truncate" style="max-width: 150px;"><?php echo $row['memFilmStory'];?></td>
        <td class="text-center"><?php echo $row['dtmFilmReleaseDate'];?></td>
        <td class="text-center"><?php echo $row['intFilmDuration'];?></td>
        <td class="d-inline-block text-truncate" style="max-width: 150px;"><?php echo $row['memFilmAdditionalInfo'];?></td>
        <td class="text-center"><?php echo $row['strGenre'];?></td>
        <td class="text-center"><?php echo $row['strCertificate'];?></td>
        <td class="text-sm-left"><a href='editFilm.php?lngFilmTitleID="<?php echo ($row['lngFilmTitleID']);?>"'>
            <button type="button" class="btn btn-warning"><img src="../pictures\icons\pencil.png" alt="" width=20;></button></a></td>
        <td class="text-sm-left"><a href='deleteFilm.php?lngFilmTitleID="<?php echo ($row['lngFilmTitleID']);?>"'>
            <button type="button" class="btn btn-danger"><img src="../pictures\icons\trash.png" alt="" width=20;></button></a></td>
    </tr>
    <?php
    }
    echo "</tbody>\n";
    echo "</table>\n";
    mysqli_free_result($result);
    mysqli_close( $conn );
    }
?>

</body>
</html>