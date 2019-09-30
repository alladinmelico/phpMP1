<?php
include('header.php');
include('includes/navigation.php');
require('includes/config.php');

$lngFilmTitleID = $_GET['lngFilmTitleID'];

$sql = "CALL selectActorFilm('$lngFilmTitleID')";

$result = mysqli_query($conn,$sql);

$row = mysqli_fetch_all($result,MYSQLI_ASSOC);

mysqli_close($conn);
?>


<div class="container-fluid bg-white">
  <div class="row">
    <div class="col-3 bg-success">
        <table class="table text-white">
            <thead class="dark">
                <th>Name</th>
                <th>Character</th>
                <th>Description</th>
            </thead>

            <tbody>
                <?php 
                    foreach($row AS $data)
                    { ?>
                        <tr>
                            <td>
                                <?php echo $data['strActorFullName']; ?>
                            </td>
                            <td>
                                <?php echo $data['strCharacterName']; ?>
                            </td>
                            <td>
                                <?php echo $data['memCharaterDescription']; ?>
                            </td>
                        </tr>
                    <?php }
                ?>
                
            </tbody>
        </table>
    </div>
    <div class="col-sm-auto bg-warning">
      One of three columns
    </div>
    <div class="col-sm-auto bg-light">
      One of three columns
    </div>
    <div class="col-3 bg-info">
      One of three columns
    </div>
  </div>
</div>


