<?php 
include 'db_cnx.php';
include 'main.php';
if ( isset($_SESSION['idUser']) && isset($_SESSION['userEmail'])) { 
    $cours = $cnx->prepare("SELECT g.nom,g.idGroupe,c.idCour,c.date,c.heurDebut,c.heurFin FROM cour c join Groupe g ON c.idGroupe = g.idGroupe WHERE idEnseignant=? AND status='pasEncore' order by date asc, heurDebut asc");
    $cours->execute([$_SESSION['idUser']]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>
<body>
  

    <div class="container pt-5 pb-5">
    <div class="row">
  <div class="col-6"><h1 class="pb-2 display-4">Cours</h1></div>
</div>
 <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col" hidden> </th>
      <th scope="col">Groupe</th>
      <th scope="col">Date</th>
      <th scope="col">Heure Début</th>
      <th scope="col">Heure Fin</th>
      <th scope="col" class="text-end">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($cours as $cour): ?>
    <tr>
      <td hidden><?=$cour['idGroupe']?> </td>
      <td><?=$cour['nom']?></td>
      <td><?=$cour['date']?></td>
      <td><?=$cour['heurDebut']?></td>
      <td><?=$cour['heurFin']?></td>
      <td class="text-end">
        <?php
        if ($cour['date'] <= date("Y-m-d")) {
      
        ?>
      <a href="viewCour.php?id=<?=$cour['idCour']?>" type="button" class="btn btn-small" style="background-color:#26C6D0; color:#fff;" ><i class="bi bi-eye"></i> View</a>
      <?php } ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
 </div>   
   
</body>
</html>
<?php 

}else{
    header("Location: login.php");
}

?>