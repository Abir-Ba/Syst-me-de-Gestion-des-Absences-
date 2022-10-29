<?php 
include 'db_cnx.php';
include 'main.php';

if ( isset($_SESSION['idUser']) && isset($_SESSION['userEmail'])) { 
    $query ='';
    $groupes = $cnx->prepare("SELECT distinct idGroupe from cour where idEnseignant =?");
    $groupes->execute([$_SESSION['idUser']]);
    foreach ($groupes as $key => $groupe) {
    $id = $groupe['idGroupe'];
    $query .= " SELECT * FROM Etudiant WHERE idGroupe = '$id' UNION";
    }
    $query = substr($query, 0, -5);  
    $query .= " ORDER BY prenom";
    $etudiants = $cnx->prepare($query);
    $etudiants->execute();

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
    <div class="row d-flex justify-content-center align-items-center">
  <div class="col-6"><h1 class="pb-2 display-4">Etudiants</h1></div>
  <div class="col-6">
<input type="text" class="form-control" id="search" autocomplete="off" placeholder="Search.."></div>
</div>

 <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Nom</th>
      <th scope="col">Prenom</th>
      <th scope="col">email</th>
      <th scope="col">absence Justifiée</th>
      <th scope="col">absence Non Justifiée</th>
      <th scope="col">Nb Cours</th>
    </tr>
  </thead>
  <tbody id="output">
  <?php foreach ($etudiants as $etudiant){
    $absenceJ = $cnx->prepare("SELECT COUNT(idEtudiant) as absenceJ From absence a join cour c ON
    a.idCour = c.idCour WHERE a.status = 'justifiée' and a.idEtudiant=? and c.idEnseignant=? ");
    $absenceJ->execute([$etudiant['idEtudiant'],$_SESSION['idUser']]);
    $absenceJ= $absenceJ->fetch(PDO::FETCH_ASSOC);

    $absencenJ = $cnx->prepare("SELECT COUNT(idEtudiant) as absencenJ From absence a join cour c ON
    a.idCour = c.idCour WHERE a.status = 'nonJustifiée' and a.idEtudiant=? and c.idEnseignant=? ");
    $absencenJ->execute([$etudiant['idEtudiant'],$_SESSION['idUser']]);
    $absencenJ= $absencenJ->fetch(PDO::FETCH_ASSOC);
    
    $totalcours = $cnx->prepare("SELECT COUNT(idCour) as total From cour WHERE idGroupe=? and idEnseignant=? and status = 'terminer'");
    $totalcours->execute([$etudiant['idGroupe'],$_SESSION['idUser']]);
    $totalcours = $totalcours->fetch(PDO::FETCH_ASSOC);
    ?>
    <tr>
      <td><?=$etudiant['prenom']?></td>
      <td><?=$etudiant['nom']?></td>
      <td><?=$etudiant['email']?></td>
      <td><?=$absenceJ['absenceJ']?></td>
      <td><?=$absencenJ['absencenJ']?></td>
      <td><?=$totalcours['total']?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
</div>
 </div>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
 <script type="text/javascript" >
  $(document).ready(function(){
    $("#search").keyup(function(){
      var input = $(this).val();
      if(input != ""){
      $.ajax({

        url:"search.php",
        method: "POST",
        data:{input:input},
        success:function(data){
          $("#output").html(data);
        }
      });
    }
    });
  });
</script>   
</body>
</html>
<?php 

}else{
    header("Location: login.php");
}

?>