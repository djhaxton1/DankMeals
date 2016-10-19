<?php
require 'database\database.php';
if(isset($_FILES['image'])){
		$errors= array();
		$file_name = $_FILES['image']['name'];
		$file_size =$_FILES['image']['size'];
		$file_tmp =$_FILES['image']['tmp_name'];
		$file_type=$_FILES['image']['type'];

		if($file_size > 2097152){
			 $errors[]='File size must be excately 2 MB';
		}

		if(empty($errors)==true){

			ob_start();
			$db = new database();
			ob_end_clean();
			$query = "SELECT last_insert_id();";
			$relevant = array("last_insert_id()");
			$db->sendCommand("INSERT INTO recipes values(null, null, 'dummy data', 'dummy pic');");
			$result = $db->sendCommandParse($query, $relevant);
			$id = $result[1];
			ob_start();
			$db = null;
			ob_end_clean();

			$dirpath = realpath(dirname(getcwd()));
			mkdir($dirpath . "/DankMeals/pics/rec" . $id);
			move_uploaded_file($file_tmp, $dirpath . "/DankMeals/pics/rec" . $id . "/rec" . $id . "_0.jpg");
		}else{
			 print_r($errors);
		}
 }
?>
