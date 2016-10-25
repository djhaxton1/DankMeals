<?php
/** 
 * Author : Dustin Haxton
 * Purpose:
 * Collects data from the addRecipe.html Page. Processes that data and sends
 *	SQL Commands to the Server to save the recipe
 * Data:
 * $rec = Recipe name.
 * $ing = array of ingredients
 * $ins = array of instructions
 * $pic = picture of the recipe
 */

	/* Connect to Database */
    include 'dbInterface.php';
    $db = new dbInterface();
	$rec = $_GET["name"];
	$ing = array();
	$ins = array();
	
	/* Decode the URL */
	foreach (explode("&", $_SERVER['QUERY_STRING']) as $tmp_arr_param) {
		$split_param = explode("=", $tmp_arr_param);
		
		/* Is the parameter an ingredient? */
		if ($split_param[0] == "ingredient") {
		    $ing[] = urldecode($split_param[1]);
		}
		
		/* Is the parameter an instruction? */
		if ($split_param[0] == "instruction") {
			$ing[] = urldecode($split_param[1]);
		}
	}
	
	for($i = 0; $i < count($ing); $i++) {
		echo "$ing[$i]<br>";
	}
	
	for($i = 0; $i < count($ins); $i++) {
		echo "$ins[$i]<br>";
	}

?>
