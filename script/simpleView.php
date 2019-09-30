<?php
include('header.php');
include('includes/navigation.php');
require('includes/config.php');

$lngFilmTitleID = $_GET['lngFilmTitleID'];

$sql = "CALL selectActorFilmProducer('$lngFilmTitleID')";

$result = mysqli_query($conn,$sql);

$row = mysqli_fetch_all($result,MYSQLI_ASSOC);

mysqli_close($conn);
?>


<div class="container-fluid mx-auto">
  <div class="row mx-auto">
    <div class="col-sm-auto bg-success">
    <h1 class="text-white">Film</h1>
        <table class="table text-white">
            <thead class="dark">
                <th>Title</th>
                <th>Story</th>
                <th>Duration</th>
                <th>Date</th>
            </thead>

            <tbody>
                <?php
                $title = "";
                $story = "";
                $duration = 0;
                $date = "";
                    foreach($row AS $data)
                    {
                        $title = $data['strFilmTitle'];
                        $story = $data['memFilmStory'];
                        $duration = $data['intFilmDuration'];
                        $date = $data['dtmFilmReleaseDate'];
                    }
                ?>
                <tr>
                            <td>
                                <?php echo $title; ?>
                            </td>
                            <td class="text-truncate d-block" style="width: 6rem;">
                                <?php echo $story; ?>
                            </td>
                            <td>
                                <?php echo $duration; ?>
                            </td>
                            <td>
                                <?php echo $date; ?>
                            </td>
                        </tr>
                
            </tbody>
        </table>
    </div>


    <div class="col-sm-auto bg-warning">
      <h1 class="text-white">Actors <a href="addRole.php?lngFilmTitleID=<?php echo $lngFilmTitleID; ?>">&#x2795</a></h1>
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


    <div class="col-sm-auto bg-secondary">
      <h1 class="text-white">Producers</h1>
        <table class="table text-white">
            <thead class="dark">
                <th>Name</th>
            </thead>

            <tbody>
                <?php
                $prodName = array();
                    foreach($row AS $data)
                    { 
                        $prodName[] = $data['strProducerName'];
                    }
                $uniquePname = array_unique($prodName);
                ?>
                <?php foreach($uniquePname AS $pName){?>
                 <tr>
                    <td>
                        <?php echo $pName; ?>
                    </td>
                </tr>
                <?php }?>
                
            </tbody>
        </table>
    </div>


    <div class="col-sm-auto bg-info">
    <h1 class="text-white">Genre</h1>
        <table class="table text-white">
            <thead class="dark">
                <th>Name</th>
            </thead>

            <tbody>
                <?php
                $genre = array();
                    foreach($row AS $data)
                    { 
                        $genre[] = $data['strGenre'];
                    }
                $uniqGenre = array_unique($genre);
                foreach ($uniqGenre AS $uGen){
                ?>

                <tr>
                    <td>
                        <?php echo $uGen;?>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>


  </div>
</div>


