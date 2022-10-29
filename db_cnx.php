<?php 
$servername = "localhost";
$username = "root";
$password = ""; // Your Database Password
$dbname = "gestion_absences";


 
 try{
    $cnx = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 }catch(PDOException $e){
    echo "Connection failed : ".$e->getMessage();
 } 
?>