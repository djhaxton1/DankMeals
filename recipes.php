<?php
  include './database/database.php';
  $db = new database();
  $result = $db->sendCommandParse("SELECT * FROM recipes;", array("id", "title"));
  $returnString = "<table class='table'><thead><tr><th>Recipe ID</th><th>Title</th></tr></thead><tbody>";
  for($j = 1; $j < count($result) - 1; $j += 2) {
   $returnString .= "<tr><td>".$result[$j]."</td><td>".$result[$j+1]."</td></tr>";
 }

  $returnString .= "</tbody></table>";
  echo $returnString;
  $db = null;
?>
