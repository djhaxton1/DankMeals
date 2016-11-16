<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dank Meals</title>
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://apis.google.com/js/platform.js" async defer></script> <!-- Loads the Google interface -->

    <!-- Bootstrap Core CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/meals.css">

</head>

<body>

    <!-- Navigation -->
	<div id="navigation" class="container">
		<script>
			history.pushState('', '', '../');
			$.get("assets/nav.html", function(data) {
				$("#navigation").replaceWith(data);
			});
		</script>	
	</div>

	<br>

	<script src="assets/tile.js" type="text/javascript"></script>
	<div class="container">
		<?php
		/* Connect to Database */
		include 'dbInterface.php';
		$db        = new dbInterface();
		$recipes   = $db->getTitles();
		$ids	   = $db->getIDs();
		$occurance = array_fill(0, count($recipes), 0);

		$t = $_POST["ings"];
		$form_data['posted'] = var_dump($t);
		echo json_encode($form_data);
		/* Find occurances of substrings */
		/*for($j = 0; $j < count($recipes); $j++) {
			for($i = 0; $i < count($t); $i++) {
			
				$rec = strtolower($recipes[$j]);
				$inp = strtolower($t[$i]);
				$found = strpos($rec, $inp);
				
				/* If an occurance is found increment the priority *
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

		/* Create a table of possible results *
		echo "<h1 style='text-align:center'>Search Results:</h1>";
		for($i = 0; $i < count($recipes); $i++) {
			if($occurance[$i] != 0) {
				$rec = $db->getRecipe($ids[$i]);
				if($rec["picture"] == null)
					$rec["picture"] = "/imageError.png";
				echo"<div class='col-md-4 portfolio-item'><div id='tile'><a href='recipePage.html?id=" . $ids[$i] . "'><img src='pics" . $rec["picture"] . "'><div id='tile-title'><p>" . $rec["title"] . "</p></div></a></div></div>";
			}
		}
		echo "</ul>";*/
		?>
		
		<!-- Footer -->
		<div id="footer" class="container">
			<script>
				$.get("assets/foot.html", function(data) {
					$("#footer").replaceWith(data);
				});
			</script>
		</div>
	</div>		
	
</body>
</html>
