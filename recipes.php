<?php
  include './database/database.php';
  ob_start();
  $db = new database();
  ob_end_clean();
  $result = $db->sendCommandParse("SELECT * FROM recipes;", array("id", "title"));
  $returnString = "<table class='table'><thead><tr><th>Recipe ID</th><th>Title</th></tr></thead><tbody>";
  for($j = 1; $j < count($result) - 1; $j += 2) {
   $returnString .= "<tr><td>".$result[$j]."</td><td><a href='recipePage.html?id=" . ($j+1)/2 . "'>" .$result[$j+1]."</td></tr>";
 }

  $returnString .= "</tbody></table>";
  echo $returnString;
  ob_start();
  $db = null;
  ob_end_clean();
?>
