<?php
	include './database/database.php';
	ob_start();
	$db = new database();
	ob_end_clean();
	$result = $db->sendCommandParse("SELECT * FROM recipes;", array("id", "title"));

	$returnString = "";
	$count = 1;
	for($j = 1; $j < count($result) - 1; $j += 2) {
		if($count%3 == 1) {
			$returnString .= '<div class="row">';
		}
			
		$returnString .= '<div class="col-md-4 portfolio-item"><a href="recipePage.html?id=' . ($j+1)/2 . '"><img class="img-responsive" src="http://placehold.it/700x400" alt=""></a><h3><a href="recipePage.html?id=' . ($j+1)/2 . '">' . $result[$j+1] . '</a></h3></div>';

		if($count%3 == 0) {
			$returnString .= '</div>';
		}

		$count += 1;
	}
	if($count%3 != 0) { $returnString .= '</div>'; }
	
	echo $returnString;
	ob_start();
	$db = null;
	ob_end_clean();
?>