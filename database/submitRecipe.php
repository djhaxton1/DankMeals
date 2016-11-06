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
	$ing   = $_POST['ingredient'];
	$ins   = $_POST['instruction'];
	
	/* prepare Recipe for insertion into database */
	$recipe["title"]                  = $title;
	$recipe["parent_id"]              = NULL;
	$recipe["ingredient_name"]        = $ing;
	$recipe["instruction"]            = $ins;
	$recipe["ingredient_measurement"] = array(count($ing));
	
	$id = $db->insertRecipe($recipe);
	echo "ID is" + $id + "<br>";
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
			mkdir($dirpath . "/DankMeals/pics/rec" . $id);
			move_uploaded_file($file_tmp, $dirpath . "/DankMeals/pics/rec" . $id . "/rec" . $id . "_0.jpg");
		} else {
			print_r($errors);
		}
	}*/

?>
