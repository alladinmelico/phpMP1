<?php
if (isset($_GET['search'])){
    $searchInput = $_GET['search'];
} else {
    $searchInput = "";
}
?>
<ul class="nav border-bottom nav-fill" style="background: #11998e;
                background: -webkit-linear-gradient(to right, #11998e, #38ef7d);
                background: linear-gradient(to right, #11998e, #38ef7d);">
  <li class="nav-item"  style="margin-top:1em;">
    <a href="../index.php" class="nav-link" style="color:white;font-size:1.75em;"><img src="../pictures\icons\home.png" alt="" width=40> Home</a>
  </li>
  <li class="nav-item mr-1"  style="margin-top:1em;">
    <form action="globalSearch.php">
      <input type="text" name="search" value="<?php echo $searchInput;?>">
      <input type="submit" value="SEARCH"  class="btn btn-info" style=" background: #11998e;
      background: -webkit-linear-gradient(to right, #11998e, #38ef7d);
      background: linear-gradient(to right, #11998e, #38ef7d);">
    </form>
  </li>
  <li class="nav-item"  style="margin-top:1em;">
  <a href="login.php" class="nav-link" style="color:white;font-size:1.75em;"><img src="../pictures\icons\user-shape.png" alt="" width=40>Login</a>
  </li>
</ul>
