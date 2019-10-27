<?php include ('header.php');?>
<body>
<script type="text/javascript">
    if (<?php if (isset($_POST['submit']))
        {echo "true";}
        else echo "false";?>)
    {
        $(document).ready(function()
            {
                $("#ModalCenter").modal('show');
            })
	};
</script>
<?php 
    
    include ('includes/config.php');
    include('includes/navigation.php');
    include ('includes/search.php');
    if (isset($_GET['search']))
    {
    $search = $_GET['search'];
    $result = mysqli_query( $conn,"SELECT * FROM tblactors WHERE strActorFullName LIKE '%". $search."%';" );
    $num_rows = mysqli_num_rows( $result );
    ?>
    
    <br>
    <div class="bs-example">
    <table width=375 class="table table-hover ">
        <thead style=" background: #11998e;
                background: -webkit-linear-gradient(to right, #11998e, #38ef7d);
                background: linear-gradient(to right, #11998e, #38ef7d);">
            <tr style="font-size:1em;">
            <th scope="col" class="text-center"></th>
            <th scope="col" class="text-center">#</th>
            <th scope="col" class="text-center"><img src="../pictures\icons\user-shape.png" alt="" width="40px"> Name</th>
            <th scope="col"class="text-center"><img src="../pictures\icons\text-file.png" alt="" width="40px"> Actor Notes</th>
            <th scope="col" class="text-center "><a href="createActor.php">
                <img src="../pictures\icons\plus-symbol-in-a-rounded-black-square.png" alt="" width="50px" class="rounded-circle bg-light"></a></th>
            <th scope="col"> </th>
            </tr>
        <thead class="table table-striped">
        <tbody>
    <?php
    
    while ($row = mysqli_fetch_array($result))
    { ?>
    <form action="#" method="POST">
    <tr style="color:white;">
        <input type="hidden" name="pic" value="<?php echo $row['picture'];?>">
        <input type="hidden" name="actName" value="<?php echo $row['strActorFullName'];?>">
        <input type="hidden" name="actID" value="<?php echo $row['lngActorID'];?>">
        <input type="hidden" name="search" value="">
        <td class="text-center"><img src="../pictures/profile/<?php echo $row['picture'];?>" alt="" width="80px"></td>
        <td class="text-center"><?php echo $row['lngActorID'];?></td>
        <td class="text-center">
            <a href="viewActor.php?lngActorId=<?php echo $row['lngActorID']?>&actorPicture=<?php echo $row['picture']?>">
                <?php echo $row['strActorFullName'];?>
            </a>
        </td>
        <td class="text-center"><?php echo $row['memActorNotes'];?></td>
        <td class="text-sm-center bg-warning">
            <a href='createActor.php?lngActorID=<?php echo ($row['lngActorID']);?>'>
            <button type="button" class="btn btn-warning" name="edit" value="EDIT">
                <img src="../pictures\icons\pencil.png" alt="" width=20;></button></a></td>
        <td class="text-sm-center bg-danger">
            <a href="actor.php">
                <button type="submit" class="btn btn-danger" name="submit" value="EDIT">
                    <img src="../pictures\icons\trash.png" alt="" width=20;></button>
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

<!-- MODALS -->

    <div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalCenterTitle">Are you sure you want to delete this?</h5>
                <a href="actor.php?search=">X</a>
                </button>
            </div>
            <div class="modal-body">
                <form action="deleteData.php" method="GET">
                <input type="hidden" name="lngActorID" value="<?php echo $_POST['actID'];?>">
                <h3 class="text-center"><?php echo $_POST['actName'];?></h3>
                <img src="../pictures/profile/<?php echo $_POST['pic'];?>" alt="" class="img-thumbnail mx-auto d-block" width=100>
            </div>
            <div class="modal-footer">
                    <a href="actor.php?search="><button type="button" class="btn btn-secondary">Close</button></a>
                    <button type="submit" class="btn btn-danger" name="delete"
                            value="Delete">Delete</button>
                </form>
            </div>
            </div>
        </div>
    </div>
</body>
</html>