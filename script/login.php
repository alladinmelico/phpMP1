<?php
include('header.php');
?>

<body>
<div class="container d-flex h-100 ">
<div class="card content mx-auto text-white " style="width: 25rem;margin-top:7em;">
  <div class="card-body rounded-lg" style="background: rgb(17,153,142);
background: linear-gradient(342deg, rgba(17,153,142,1) 0%, rgba(33,163,94,1) 100%);">
    <h5 class="card-title justify-content-center">LOG IN</h5>

    <form action="">
        <label class="mt-4">Username</label>
        <input type="text" class="form-control" name="userName" required>
        <label class="mt-4">Password</label>
        <input type="password" class="form-control" name="userName" value="">
        <div class="form-check form-check-inline mt-5">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
            <label class="form-check-label sm" for="inlineCheckbox1">Remember me</label>
        </div>
        <input type="submit" name="submit" class="btn btn-light text-info mx-auto form-control">
        <p class="text-center"><a href="../index.php" class="text-white font-weight-light"> continue as guest</a></p>
    </form>
  </div>
</div>
</div>
</body>