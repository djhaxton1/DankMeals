<?php
	/* Connect to Database */
	include 'dbInterface.php';
	$db        = new dbInterface();
	$recipes   = $db->getTitles();
	$ids	   = $db->getIDs();
	//$ings	   = $db->getAllIngredients();
	$occurance = array_fill(0, count($recipes), 0);

	$t = $_POST["ings"];
	$form_data['posted'] = "";
	
	/* Find occurances of recipe names */
	for($j = 0; $j < count($recipes); $j++) {
		for($i = 0; $i < count($t); $i++) {
	
			$rec = strtolower($recipes[$j]);
			$inp = strtolower($t[$i]);
			$found = strpos($rec, $inp);
		
			/* If an occurance is found find the */
			if($found !== false) {
				$occurance[$j]++;
			}
		}
	}
	
	/* Find occurance of ingredients */
	for($j = 1; $j < count($ings); $j = $j + 2) {
		for($i = 0; $i < count($t); $i++) {
			$ing = strtolower($ings[$j]);
			$inp = strtolower($t[$i]);
			$found = strpos($ing, $inp);

			if($found !== false) {
				$title = $db->getTitle($occurance[$j-1]);
				for(int $k = 0; $k < count($recipes); $k++) {
					if(strcmp($title, $recipes[$k]) !== false) {
						$occurance[$k]++;
						break;
					}
				}
			}
		}
	}
	
	/*Sort Recipes based on Priority */
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
	$posts = 0; // number of recipes that will be displayed
	for($i = 0; $i < count($recipes); $i++) {
		if($occurance[$i] != 0) {
			$post++;
			$rec = $db->getRecipe($ids[$i]);
			if($rec["picture"] == null)
				$rec["picture"] = "/imageError.png";
			$form_data['posted'] .= "<div class='col-md-4 portfolio-item'><div id='tile'><a href='recipePage.html?id=" . $ids[$i] . "'><img src='pics" . $rec["picture"] . "'><div id='tile-title'><p>" . $rec["title"] . "</p></div></a></div></div>";
		}
	}

	if($posts == 0) {
		$form_data['posted'] .= "The Dankness is lacking ...<br>";
	}
	$form_data['posted'] .= "</ul>";
	echo json_encode($form_data);
?>
