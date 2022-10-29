<?php 
session_start();
if ( !isset($_SESSION['idUser']) && !isset($_SESSION['userEmail']) ) {
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <form class="p-5 rounded shadow" action="auth.php" method="POST" style="width:32rem ;">
        <h1 class="text-center pb-2 display-4" style="color: #26CDd0 ;">LOGIN</h1>
        <div class="d-flex pb-2 justify-content-center align-items-center">
    <img src="login-image.svg" alt="" style="width: 15rem;">
    </div>
        <?php
        if (isset($_GET['error'])) {?>
        <div class="alert alert-danger" role="alert">
         <?=htmlspecialchars($_GET['error'])?>
        </div>
        <?php }  ?>
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" name="email" value="<?php if (isset($_GET['email']))echo(htmlspecialchars($_GET['email']))?>" class="form-control" id="exampleInputEmail1">
  </div>
  <div class="form-group pb-2">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
  </div>
  <button type="submit" class="btn" style="background-color: #26CDd0 ; color:white ; width:26rem;">Login</button>
</form>
    </div>
</body>
</html>
<?php
}else{
  header("Location: index.php");
}
// colors : orange : #F86A4A; blue: #26C6D0;
?>