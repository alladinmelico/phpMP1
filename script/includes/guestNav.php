<?php
$placeHolder = "Search";
if (isset($_GET['search'])){
    $searchInput = $_GET['search'];
    $placeHolder = $_GET['search'];
    if ($searchInput == ""){
      $placeHolder = "Search";
    }
} else {
    $searchInput = "";
    $placeHolder = "Search";
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background: #11998e;
                background: -webkit-linear-gradient(to right, #11998e, #38ef7d);
                background: linear-gradient(to right, #11998e, #38ef7d);">
  
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <a class="navbar-brand" href="../index.php" style="font-size:2rem;">
      <img src="../pictures\icons\home.png" alt="" width=30>  Home
    </a>
  </div>

      <form action="globalSearch.php" style="width:20rem;" class="form-inline">
        <div class="input-group mt-3">
          <input type="search" placeholder="<?php echo $placeHolder;?>" name="search" value="" class="form-control">
          <div class="input-group-append">
            <input type="submit" value="SEARCH"  class="btn btn-outline-dark form-control" >
          </div>
        </div>
      </form>
    
    <a href="login.php" class="text-decoration-none text-dark" style="font-size:2rem;">
      <img src="../pictures\icons\user-shape.png" alt="" width=30>   Login
    </a>
</nav>
