<?php

session_start();
include 'db_cnx.php';

if ( isset($_POST['email']) && isset($_POST['password']) ) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
    header("Location: login.php?error=Email is required");
    }elseif (empty($password)) {
        header("Location: login.php?error=Password is required&email=$email");
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: login.php?error=Invalid Email Address");
      }else {

        $result = $cnx->prepare("SELECT * FROM Enseignant WHERE email=?");
        $result->execute([$email]);

        if ($result->rowCount() === 1) {

            $user = $result->fetch();
            
            $idUser = $user['idEnseignant'];
            $userPassword = $user['password'];
            $userEmail = $user['email'];
            $userFullName = $user['nom']." ".$user['prenom'];
          
            if ($email === $userEmail) {
                if(password_verify($password,$userPassword)){
                  $_SESSION['idUser'] = $idUser;
                  $_SESSION['userEmail'] = $userEmail;
                  $_SESSION['userFullName'] = $userFullName;
                  header("Location: index.php");

                }else{
                    header("Location: login.php?error=Incorect Password&email=$email");
                }
            }else{
                header("Location: login.php?error=Incorect Email&email=$email");
            }

        }else{
            header("Location: login.php?error=Incorect Email or Password&email=$email");
        }
    }
}
//Hashed Password
/*$hashed_password = password_hash('12345678',PASSWORD_DEFAULT);
echo $hashed_password;
$2y$10$RmhZEXVrKOWViffSH5ULMexJTZT7AgG1X4FzjLoYnaPHDOpS3PodS*/
?>

