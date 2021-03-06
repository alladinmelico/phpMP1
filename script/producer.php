<?php include ('header.php');
include('includes/navigation.php');?>
<body>
<?php 
    
    include ('includes/config.php');
    include ('includes/search.php');
    if (isset($_GET['search']))
    {
    $search = $_GET['search'];
    $result = mysqli_query( $conn,"SELECT * FROM tblProducers WHERE strProducerName LIKE '%". $search."%';" );
    $num_rows = mysqli_num_rows( $result ); ?>
    <br>
    <div class="bs-example">
    <table width=375 class="table table-hover ">
        <thead style=" background: #11998e;
                background: -webkit-linear-gradient(to right, #11998e, #38ef7d);
                background: linear-gradient(to right, #11998e, #38ef7d);">
            <tr style="font-size:1em;">
            <th scope="col" class="text-center">#</th>
            <th scope="col" class="text-center"><img src="../pictures\icons\facetime-button.png" alt="" width="40px">Name</th>
            <th scope="col"class="text-center"><img src="../pictures\icons\envelope.png" alt="" width="40px">Email</th>
            <th scope="col"class="text-center"><img src="../pictures\icons\earth-globe.png" alt="" width="40px">Website</th>
            <th scope="col" class="text-center "><a href="createProducer.php">
                <img src="../pictures\icons\plus-symbol-in-a-rounded-black-square.png" alt="" width="40px" class="rounded-circle bg-light"></a></th>
            <th scope="col"> </th>
            </tr>
        <thead class="table table-striped">
        <tbody>
    <?php
    while ($row = mysqli_fetch_array($result))
    { ?>
    <tr style="color:white;">
        <td class="text-center"><?php echo $row['lngProducerID'];?></td>
        <td class="text-center"><?php echo $row['strProducerName'];?></td>
        <td class="text-center"><?php echo $row['hypContactEmailAddress'];?></td>
        <td class="text-center"><?php echo $row['hypWebsite'];?></td>
        <td class="text-sm-left"><a href='createProducer.php?lngProducerID=<?php echo ($row['lngProducerID']);?>'>
            <button type="button" class="btn btn-warning"><img src="../pictures\icons\pencil.png" alt="" width=20;></button></a></td>
        <td class="text-sm-left"><a href='deleteData.php?lngProducerID=<?php echo ($row['lngProducerID']);?>'>
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