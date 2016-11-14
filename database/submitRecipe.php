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
	$recipe = array();
	
	/* Populate Arrays with information */
	$title = $_POST['title'];
	$ing_name   = $_POST['ingredient'];
	$ing_meas = $_POST['measurement'];
	$ins   = $_POST['instruction'];
	
	/* prepare Recipe for insertion into database */
	$recipe["title"]                  = $title;
	$recipe["parent_id"]              = NULL;
	$recipe["ingredient_name"]        = $ing_name;
	$recipe["instructions"]           = $ins;
	$recipe["ingredient_measurement"] = $ing_meas;
	for($i = 0; $i < count($recipe["ingredient_name"]); $i++){
		if(!$ing_meas[$i]){
			$recipe["ingredient_measurement"][$i] = "";
		}
	}
	$recipe["author"] 				  = 1;
	if(!file_exists($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name'])) {
		$recipe["picture"]            = 0;
	}else{
		$recipe["picture"]            = 1;
	}
	$id = $db->insertRecipe($recipe);
	$db = null; // Close the database
	
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
			if(DIRECTORY_SEPARATOR == '\\') {
				mkdir($dirpath . "\\pics\\rec" . $id);
				move_uploaded_file($file_tmp, $dirpath . "\\pics\\rec" . $id . "\\rec" . $id . "_0.jpg");
			} else {
				mkdir($dirpath . "/pics/rec" . $id);
				move_uploaded_file($file_tmp, $dirpath . "/pics/rec" . $id . "/rec" . $id . "_0.jpg");
			}
		} else {
			print_r($errors);
		}
	}
	header("Location:../recipePage.html?id=" . $id);
?>
