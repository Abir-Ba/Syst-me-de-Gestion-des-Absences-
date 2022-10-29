<?php 
include 'db_cnx.php';
include 'main.php';
if ( isset($_SESSION['idUser']) && isset($_SESSION['userEmail'])) { 
    if (isset($_GET['id'])) {
    $cour = $cnx->prepare("SELECT g.nom,g.idGroupe,c.date,c.heurDebut,c.heurFin FROM cour c join Groupe g ON c.idGroupe = g.idGroupe WHERE c.idCour=?");
    $cour->execute([$_GET['id']]);
    $cour = $cour->fetch(PDO::FETCH_ASSOC);
    $etudiants = $cnx->prepare("SELECT * from Etudiant e WHERE e.idGroupe=? order by prenom");
    $etudiants->execute([$cour['idGroupe']]);
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cour</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>
<body>

    <div class="container pt-5 pb-5">
    <div class="row pb-5">
  <div class="col-4"><h4>Groupe : <?=$cour['nom']?></h4></div>
  <div class="col-4"><h4>Date : <?=$cour['date']?></h4></div>
  <div class="col-4"><h4>Heure : <?=$cour['heurDebut']?> - <?=$cour['heurFin']?> </h4></div>
  <!--<form class="d-flex" method="post" action="/" novalidate>
                    <input class="form-control me-2" type="search" placeholder="Search" name="search" aria-label="Search">
                    <button class="btn btn-outline-dark" type="submit">Search</button>
  </form>-->
</div>
<div class="row"><div class="col-6"><h1 class="pb-2 display-4">Liste des Etudiants</h1></div></div>

 <table class="table table-striped">
 <form action="" method="POST">
  
<!-- Modal -->
<div class="modal fade" id="groupeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Liste des Absences</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Envoyer la liste des absences
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" data-dismiss="modal" style="background-color: #F86A4A ; color:#fff;">Vérifier</button>
        <button class="btn" type="submit" name="terminer" style="background-color:#26C6D0; color:#fff;">Terminer</button>
      </div>
    </div>
  </div>
</div>
  <thead>
    <tr>
      <th scope="col">Nom</th>
      <th scope="col">Prenom</th>
      <th scope="col">Email</th>
      <th scope="col" class="text-end">Absent</th>
    </tr>
  </thead>
  <tbody>
  <?php 
  
  foreach ($etudiants as $etudiant): ?>
    <tr>
      <td><?=$etudiant['prenom']?></td>
      <td><?=$etudiant['nom']?></td>
      <td><?=$etudiant['email']?></td>
      <td class="text-end">
       <input type="checkbox" name="absentId[]" value="<?php echo $etudiant['idEtudiant']?>">
      </td>
    </tr>
    <?php endforeach; ?>
  </form>
  </tbody>
</table>


<!-- Button trigger modal -->
<button type="button" class="btn"  data-toggle="modal" data-target="#groupeModal" style="background-color:#26C6D0; color:#fff;">
  Terminer
</button>
</form> 
</div>

 </div>  
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> 
</body>
</html>
<?php 
 if (isset($_POST["terminer"])) {
  if ($etudiants->rowCount() - count($_POST["absentId"]) <= 3 ) {
    $date = $cour['date'];
    $courStatus = $cnx->prepare("UPDATE cour set status='remplacer' where idCour = ?");
    $courStatus ->execute([$_GET['id']]);
    echo "<script>";
  echo "document.location.replace('index.php')"; // redirection 
echo "</script>";
  }else{
  foreach ($_POST["absentId"] as $absentId) {
    $absent = $cnx->prepare("INSERT INTO absence(idEtudiant,idGroupe,idCour,status) VALUES(?,?,?,'nonJustifiée')") ;
    $absent->execute([ $absentId, $cour['idGroupe'], $_GET['id']]);
  }
  $courStatus = $cnx->prepare("UPDATE cour set status='terminer' where idCour = ?");
  $courStatus ->execute([$_GET['id']]);
  echo "<script>";
  echo "document.location.replace('index.php')"; // redirection 
echo "</script>";
}
}
    }
}else{
    header("Location: login.php");
}

?>