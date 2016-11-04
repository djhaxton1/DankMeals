<?php
/** 
 * Author : Dustin Haxton
 * Purpose:
 * Collects data from the addRecipe.html Page. Processes 
 * that data and sends SQL Commands to the Server to save the recipe
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
	$recipe = array();
	$title;
	$par_id;
	$ing = array();
	$ins = array();
	
	/* Decode the URL */
	foreach (explode("&", $_SERVER['QUERY_STRING']) as $tmp_arr_param) {
		$split_param = explode("=", $tmp_arr_param);
		
		/* Is the parameter a title */
		if ($split_param[0] == "title") {
			$title = $split_param[1];
		}
		
		/* Is the parameter an ingredient? */
		if ($split_param[0] == "ingredient") {
		    $ing[] = urldecode($split_param[1]);
		}
		
		/* Is the parameter an instruction? */
		if ($split_param[0] == "instruction") {
			$ins[] = urldecode($split_param[1]);
		}
	}
	
	echo "<br>$title<br><br>";
	$recipe["title"]           = $title;
	$recipe["parent_id"]       = NULL;
	$recipe["ingredient_name"] = $ing;
	$recipe["instruction"]     = $ins;
	$recipe[["ingredient_measurement"] = array();
	
	$id = $db->insertRecipe($recipe);
	$db = null;
	
	if(isset($_FILES['image'])) {
		$errors    = array();
		$file_name = $_FILES['image']['name'];
		$file_size = $_FILES['image']['size'];
		$file_tmp  = $_FILES['image']['tmp_name'];
		$file_type = $_FILES['image']['type'];

		if($file_size > 2097152) {
			 $errors[] = 'File size must be less than 2 MB';
		}

		if(empty($errors) == true) {

			$dirpath = realpath(dirname(getcwd()));
			mkdir($dirpath . "/DankMeals/pics/rec" . $id);
			move_uploaded_file($file_tmp, $dirpath . "/DankMeals/pics/rec" . $id . "/rec" . $id . "_0.jpg");
		} else {
			print_r($errors);
		}
	}

?>
