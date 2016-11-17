<?php
	/* Connect to Database */
	include 'dbInterface.php';
	$db        = new dbInterface();
	$recipes   = $db->getTitles();
	$ids	   = $db->getIDs();
	$occurance = array_fill(0, count($recipes), 0);

	$t = $_POST["ings"];
	$form_data['posted'] = "";
	
	/* Find occurances of substrings */
	for($j = 0; $j < count($recipes); $j++) {
		for($i = 0; $i < count($t); $i++) {
	
			$rec = strtolower($recipes[$j]);
			$inp = strtolower($t[$i]);
			$found = strpos($rec, $inp);
		
			/* If an occurance is found increment the priority */
			if($found !== false) {
				$occurance[$j]++;
			}
		}
	}

	for($i = 0; $i < count($recipes); $i++) {
		for($j = $i + 1; $j < count($recipes); $j++) {
			if($occurance[$i] < $occurance[$j]) {
				$temp = $occurance[$i];
				$occurance[$i] = $occurance[$j];
				$occurance[$j] = $temp;
			
				$temp = $recipes[$i];
				$recipes[$i] = $recipes[$j];
				$recipes[$j] = $temp;
			
				$temp = $ids[$i];
				$ids[$i] = $ids[$j];
				$ids[$j] = $temp;
			}
		}
	}

	/* Create a table of possible results */
	$form_data['posted'] .= "<h1 style='text-align:center'>Search Results:</h1>";
	for($i = 0; $i < count($recipes); $i++) {
		if($occurance[$i] != 0) {
			$rec = $db->getRecipe($ids[$i]);
			if($rec["picture"] == null)
				$rec["picture"] = "/imageError.png";
			$form_data['posted'] .= "<div class='col-md-4 portfolio-item'><div id='tile'><a href='recipePage.html?id=" . $ids[$i] . "'><img src='pics" . $rec["picture"] . "'><div id='tile-title'><p>" . $rec["title"] . "</p></div></a></div></div>";
		}
	}
	$form_data['posted'] .= "</ul>";
	echo json_encode($form_data);
?>
