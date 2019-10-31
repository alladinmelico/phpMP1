<?php
if (!isset($_SESSION))
{
  session_start();
}

if (!(isset($_SESSION['isAdmin'])))
{
  header("location: login.php");
} else if ($_SESSION['isAdmin'] == false) {
  header("location: login.php");
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light " style="background: #11998e;
                background: -webkit-linear-gradient(to right, #11998e, #38ef7d);
                background: linear-gradient(to right, #11998e, #38ef7d);color:white;font-size:2em;">

    <a class="navbar-brand display-1" href="dashboard.php" style="font-size:1em;">
      <img src="../pictures\icons\dashboard.png" alt="" width=30> Dashboard
    </a>

  <div class="collapse navbar-collapse justify-content-center">
    <ul class="navbar-nav " >
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
          <img src="../pictures\icons\user-shape.png" alt="" width=30 > Actor</a>

            <div class="dropdown-menu"  style=" background: #11998e;
                background: -webkit-linear-gradient(to right, #11998e, #38ef7d);
                background: linear-gradient(to right, #11998e, #38ef7d);font-size:1em;">
              <a class="dropdown-item" href="actor.php?search=#" >
                <img src="../pictures\icons\man.png" alt="" width=30> Name</a>
              <a class="dropdown-item" href="role.php?search=#">
                <img src="../pictures\icons\group-profile-users.png" alt="" width=30> Roles</a>
            </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
        <img src="../pictures\icons\film-strip-with-two-photograms.png" alt="" width=30> Films</a>
          <div class="dropdown-menu"  style=" background: #11998e;
              background: -webkit-linear-gradient(to right, #11998e, #38ef7d);
              background: linear-gradient(to right, #11998e, #38ef7d);font-size:1em;">
            <a class="dropdown-item" href="film.php?search=#">
            <img src="../pictures\icons\font-symbol-of-letter-a.png" alt="" width=30> Titles</a>
            <a class="dropdown-item" href="producer.php?search=#">
            <img src="../pictures\icons\facetime-button.png" alt="" width=30> Producers</a>
            <a class="dropdown-item" href="genre.php?search=#">
            <img src="../pictures\icons\ticket.png" alt="" width=30> Genres</a>
            <a class="dropdown-item" href="certificate.php?search=#">
            <img src="../pictures\icons\certificate-shape.png" alt="" width=30> Certificates</a>
          </div>
      </li>
    </ul>
  </div>

  
    <a class="nav-link" href="login.php?"><img src="../pictures\icons\sign-out-option.png" alt="" width=30></a>
  
</nav>