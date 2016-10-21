<?php
/* Connect to Database */
    include 'dbInterface.php';
    $db = new dbInterface();

	$rec_name = $_GET["name"];
	$ing = $_GET["ingredient"];
	//$ins = array()
	//$pic = file???
	
	echo "Recipe name is: " . $rec_name;
	echo "ingredients: " . $ing;

?>