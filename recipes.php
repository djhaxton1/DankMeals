<?php
  include './database/database.php';

  $db = new database();
  $result = $db->sendCommandParse("SELECT * FROM recipes;", array("id", "title"));
  $returnString = '<table>';
  
  for($j = 0; $j < count($result); $j++) {
    $returnString .= "<tr><td>".$result[$j]."</td><td>".$result[$j+1]."</td></tr>";
  }
  
  $returnString .= "</table>";
  echo $returnString;
  $db = null;
?>
