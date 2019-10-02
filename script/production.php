<?php include ('header.php');
include('includes/navigation.php');?>
<body>
<script type="text/javascript">
    if (<?php 
        if (isset($_GET['lngFilmTitleID']))
            { echo "true" ;}
             else echo "false";?>){
	$(document).ready(function(){
		$("#ModalCenter").modal('show');
	})};
</script>
<?php 
    
    include ('includes/config.php');
    include ('includes/search.php');
    if (isset($_GET['search']))
    {
    $search = $_GET['search'];
    // $result = mysqli_query( $conn,"SELECT * FROM production WHERE 
    //     strFilmTitle LIKE '%". $search."%' OR strActorFullName LIKE '%". $search."%' OR strProducerName LIKE '%". $search."%';" );
    $result = mysqli_query( $conn,"CALL viewAllFilms;");
    $num_rows = mysqli_num_rows( $result ); ?>
    <br>
    <div class="bs-example">
    <table width=375 class="table table-hover ">
        <thead style=" background: #11998e;
                background: -webkit-linear-gradient(to right, #11998e, #38ef7d);
                background: linear-gradient(to right, #11998e, #38ef7d);">
            <tr style="font-size:1em;">
            <th scope="col" class="text-center"><img src="../pictures\icons\user-shape.png" alt="" width="40px">Actor</th>
            <th scope="col" class="text-center"><img src="../pictures\icons\film-strip-with-two-photograms.png" alt="" width="40px">Film Title</th>
            <th scope="col" class="text-center"><img src="../pictures\icons\facetime-button.png" alt="" width="40px">Producer</th>
            <th scope="col" class="text-center "><a href="createProduction.php">
                <img src="../pictures\icons\plus-symbol-in-a-rounded-black-square.png" alt="" width="40px" class="rounded-circle bg-light"></a></th>
            <th scope="col"> </th>
            </tr>
        <thead class="table table-striped">
        <tbody>
    <?php
    while ($row = mysqli_fetch_array($result))
    { ?>
    <tr style="color:white;">
        <form action="#" method="GET">
        <input type="hidden" name="strFilmTitle" value="<?php echo $row['strFilmTitle'];?>">
        <input type="hidden" name="lngFilmTitleID" value="<?php echo $row['lngFilmTitleID'];?>">
        <input type="hidden" name="search" value="">
        <td class="text-center"><?php echo $row['actors'];?></td>
        <td class="text-center"><?php echo $row['strFilmTitle'];?></td>
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
        <td class="text-center"><?php echo $tempString;?></td>
        <td class="text-sm-left">
            <a href='viewFilm.php?filmPic=<?php echo ($row['picture']);?>&lngFilmTitleID=<?php echo ($row['lngFilmTitleID']);?>'>
                <button type="button" class="btn btn-warning"><img src="../pictures\icons\pencil.png" alt="" width=20;></button></a></td>
        <td class="text-sm-left">
            <button type="submit" class="btn btn-danger"><img src="../pictures\icons\trash.png" alt="" width=20;></button></a></td>
    </tr>
    </form>
    <?php
    }
    echo "</tbody>\n";
    echo "</table>\n";
    mysqli_free_result($result);
    mysqli_close( $conn );
    }
?>

<div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header bg-danger" style="color:white;">
                <h5 class="modal-title" id="ModalCenterTitle">Are you sure you want to delete this?</h5>
                <a href="production.php?search=" style="color:white;">X</a>
                </button>
            </div>
            <div class="modal-body ">
                <form action="deleteProduction.php" method="GET">
                <input type="hidden" name="lngFilmTitleID" value="<?php echo $_GET['lngFilmTitleID'];?>">
                <h3 class="text-center"><?php echo $_GET['strFilmTitle'];?></h3><br><br>
                <p><i><strong>Note:</strong> All actors, producers, certificate, and genre
                will no longer be associated to the film. If you wish to delete those information,
                 it needs to be done individually...</i></p>
            </div>
            <div class="modal-footer">
                    <a href="production.php?search="><button type="button" class="btn btn-secondary">Close</button></a>
                    <button type="submit" class="btn btn-danger" name="delete"
                            value="Delete">Delete</button>
                </form>
            </div>
            </div>
        </div>
    </div>

</body>
</html>