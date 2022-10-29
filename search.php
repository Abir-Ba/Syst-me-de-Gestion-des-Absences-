<?php
session_start();

include 'db_cnx.php';

if ( isset($_SESSION['idUser']) && isset($_SESSION['userEmail'])) { 
   
     $table = [] ;
     $tableId = [];
                          
                    if(isset($_POST['input']))  
                     {   
                          $condition = '';  
                          $searchText = $_POST['input'];
                          $query = explode(" ", $searchText); 
                         
                          foreach($query as $text)  
                          {  
                            
                              if (!empty($text)){
                         
                               $condition .= "(nom LIKE '%$text%' OR prenom LIKE '%$text%') AND ";
                              }

                          }  
                          if (empty($condition)) { 
                            
                          }else{
                              
                          $condition = substr($condition, 0, -5);  
                          $sql_query = "SELECT * FROM Etudiant WHERE " . $condition;
                          
                          $result = $cnx->query($sql_query) ;
                        
                          if($result->rowCount() > 0)  
                          {  
                               while($row = $result->fetch(PDO::FETCH_ASSOC))  
                               {  
                               
                                  $table[] = [$row["prenom"],$row["nom"],$row["email"],$row["idGroupe"]];
                                  $tableId[] = $row["idEtudiant"];
                               }  
                          }
                          }
                          
                          $condition = '';
                          foreach($query as $text)  
                          {  
                              if (!empty($text)){
                               $condition .= "(nom LIKE '%$text%' OR prenom LIKE '%$text%') OR ";
                               }
                          }  
                          if (empty($condition)) {
                    
                            
                          }else{
                              $condition = substr($condition, 0, -4);  
                          $sql_query = "SELECT * FROM Etudiant WHERE " . $condition;  
                          $result = $cnx->query($sql_query);

                          if($result->rowCount() > 0)  
                          {  
                               while($row = $result->fetch(PDO::FETCH_ASSOC))  
                               {  
                                   
                                   if(  !in_array($row["idEtudiant"] , $tableId)){
                                        $table[] = [$row["prenom"],$row["nom"],$row["email"],$row["idGroupe"]];
                                        $tableId[] = $row["idEtudiant"];
                                  }
                                  
                               } 
                              
                          }  
                          }
                          
                           
                          
                         }
 
  if(count($table) == 0 ){
     echo '<h1 class="pb-2 display-4">Data not Found !</h1>';}
  else{ 
  for($i = 0;$i<count($table);$i++){
    $absenceJ = $cnx->prepare("SELECT COUNT(idEtudiant) as absenceJ From absence a join cour c ON
    a.idCour = c.idCour WHERE a.status = 'justifiée' and a.idEtudiant=? and c.idEnseignant=? ");
    $absenceJ->execute([$tableId[$i],$_SESSION['idUser']]);
    $absenceJ= $absenceJ->fetch(PDO::FETCH_ASSOC);

    $absencenJ = $cnx->prepare("SELECT COUNT(idEtudiant) as absencenJ From absence a join cour c ON
    a.idCour = c.idCour WHERE a.status = 'nonJustifiée' and a.idEtudiant=? and c.idEnseignant=? ");
    $absencenJ->execute([$tableId[$i],$_SESSION['idUser']]);
    $absencenJ= $absencenJ->fetch(PDO::FETCH_ASSOC);
    
    $totalcours = $cnx->prepare("SELECT COUNT(idCour) as total From Cour WHERE idGroupe=? and idEnseignant =? and status = 'terminer'");
    $totalcours->execute([$table[$i][3],$_SESSION['idUser']]);
    $totalcours = $totalcours->fetch(PDO::FETCH_ASSOC);
     echo ' <tr> <td>'.$table[$i][0].'</td>
     <td>'.$table[$i][1].'</td>
     <td>'.$table[$i][2].'</td>
     <td>'.$absenceJ['absenceJ'].'</td>
      <td>'.$absencenJ['absencenJ'].'</td>
      <td>'.$totalcours['total'].'</td>
   </tr>' 
   ;
  }
}

}else{
    header("Location: login.php");
}
?>