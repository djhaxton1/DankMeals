<html>
  <body>
    <?php
    /* Connect to Database */
    include 'dbInterface.php';
    $db        = new dbInterface();
    $recipes   = $db->getTitles();
    $db = null;
    $occurance = array_fill(0, count($recipes), 0);
    
	$t = explode(" ", $_POST["search-terms"]);

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
			}
		}
	}

	/* Create a table of possible results */
	echo "<table style = \"width:100%\">";
	for($i = 0; $i < count($recipes); $i++) {
		if($occurance[$i] != 0) {
			echo"<tr><th>$occurance[$i]</th><th>$recipes[$i]</th></tr>";
		}
	}
	echo "</table>";
    ?>
  </body>
</html>
