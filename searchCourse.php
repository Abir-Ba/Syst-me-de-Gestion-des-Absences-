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
                         
                               $condition .= "( status ='terminer' and (date LIKE '%$text%' OR nom LIKE '%$text%')) AND ";
                              }
                            
                          }  
                          if (empty($condition)) { 
                            
                          }else{
                              
                          $condition = substr($condition, 0, -5);  
                          $sql_query = "SELECT * FROM cour c JOIN Groupe g ON c.idGroupe = g.idGroupe WHERE " . $condition;
                        
                          $result = $cnx->query($sql_query) ;
                        
                          if($result->rowCount() > 0)  
                          {  
                               while($row = $result->fetch(PDO::FETCH_ASSOC))  
                               {  
                               
                                $table[] = [$row["nom"],$row["date"],$row["heurDebut"],$row["heurFin"],$row["idCour"]];
                                $tableId[] = $row["idCour"];
                               }  
                          }
                          }
                          
                          $condition = '';
                          foreach($query as $text)  
                          {  
                              if (!empty($text)){
                               $condition .= " ( status ='terminer' and (date LIKE '%$text%' OR nom LIKE '%$text%')) OR ";
                               }
                          }  
                          if (empty($condition)) {
                    
                            
                          }else{
                              $condition = substr($condition, 0, -4);  
                          $sql_query = "SELECT * FROM cour c JOIN Groupe g ON c.idGroupe = g.idGroupe WHERE " . $condition;  
                          $result = $cnx->query($sql_query);

                          if($result->rowCount() > 0)  
                          {  
                               while($row = $result->fetch(PDO::FETCH_ASSOC))  
                               {  
                                   
                                   if(  !in_array($row["idCour"] , $tableId)){
                                    $table[] = [$row["nom"],$row["date"],$row["heurDebut"],$row["heurFin"],$row["idCour"]];
                                    $tableId[] = $row["idCour"];
                                  }
                                  
                               } 
                              
                          }  
                          }
                          
                           
                          
                         }
 
  if(count($table) == 0 ){
     echo '<h1 class="pb-2 display-4">Data not Found !</h1>';}
  else{ 
  for($i = 0;$i<count($table);$i++){
     echo ' <tr> <td>'.$table[$i][0].'</td>
     <td>'.$table[$i][1].'</td>
     <td>'.$table[$i][2].'</td>
     <td>'.$table[$i][3].'</td>
     <td class="text-end">
     <a href="absents.php?id='.$table[$i][4].'" type="button" class="btn btn-small" style="background-color:#26C6D0; color:#fff;" ><i class="bi bi-eye"></i> View</a>
     </td>
   </tr>' 
   ;
  }
}

}else{
    header("Location: login.php");
}
?>