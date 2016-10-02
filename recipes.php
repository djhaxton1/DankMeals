<?php
  include 'database/database.php';

  $getConnect = new database();
  $conn = $getConnect->__construct();
  $result = mysqli_query($conn, "select * from tspdb.recipes;");
  $returnString = '<table>';
  while ($row = $result->fetch_assoc()) {

   $returnString .= "<tr><td>".$row['id']."</td><td>".$row['title']."</td></tr>";
  }
  $returnString .= "</table>";
  echo $returnString;
  $conn->close();
 ?>
