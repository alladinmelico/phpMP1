<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP WEB</title>
    <link rel="stylesheet" href="style/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
    <script type="text/javascript" src="DataTables/datatables.min.js"></script>
</head>

<?php
// include('script/header.php');

session_start();
if ($_SERVER["REQUEST_METHOD"]=="POST"){
  $_SESSION['userName'] = $_POST['userName'];
  $_SESSION['userPassword'] = $_POST['userPassword'];
  $_SESSION['db_name'] = "mysql";
  include('script/includes/config.php');
  
  // TODO: cookies

  if($_SESSION['userName'] AND $_SESSION['userPassword']){
    header("location: script/dashboard.php");
  }
} else{
  session_destroy();
}
?>

<body>
<div class="container d-flex h-100 ">
<div class="card content mx-auto text-white " style="width: 25rem;margin-top:7em;">
  <div class="card-body rounded-lg" style="background: rgb(17,153,142);
background: linear-gradient(342deg, rgba(17,153,142,1) 0%, rgba(33,163,94,1) 100%);">
    <h5 class="card-title justify-content-center">LOG IN</h5>

    <form action="#" method="POST">
        <label class="mt-4">Username</label>
        <input type="text" class="form-control" name="userName" value="" required>
        <label class="mt-4">Password</label>
        <input type="password" class="form-control" name="userPassword" value="">
        <div class="form-check form-check-inline mt-5">
            <input class="form-check-input" type="checkbox" name="rememberMe">
            <label class="form-check-label sm" for="inlineCheckbox1">Remember me</label>
        </div>
        <input type="submit" name="submit" class="btn btn-light text-info mx-auto form-control">
        <p class="text-center"><a href="../index.php" class="text-white font-weight-light"> continue as guest</a></p>
    </form>
  </div>
</div>
</div>
</body>