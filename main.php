<?php 
session_start();
if ( isset($_SESSION['idUser']) && isset($_SESSION['userEmail'])) { 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/" style="color: #26C6D0;"><?=$_SESSION['userFullName'] ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php" style="color: black;">Cours</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="justifications.php" style="color: black;">Justifications</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="etudiants.php" style="color: black;">Etudiants</a>
                    </li>
                    
                </ul>
                </div>
                <a href="logout.php" class="btn " style="background-color: #F86A4A ; color:white ;">Logout</a>
        </div>
    </nav>
</body>
</html>
<?php 

}else{
    header("Location: login.php");
}

?>