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
	
	<div class="container">
		<?php
		/* Connect to Database */
		include 'dbInterface.php';
		$db        = new dbInterface();
		$recipes   = $db->getTitles();
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
		echo "<h2>Search Results:</h2><ul id='search-result'>";
		for($i = 0; $i < count($recipes); $i++) {
			if($occurance[$i] != 0) {
				echo"<li>$recipes[$i]</li>";
			}
		}
		echo "</ul>";
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
