<!DOCTYPE html>
<html>
    <head>
		<?php
			include 'autocomplete.php';
		?>
	
        <title>Add Recipe - Dank Meals</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		
		<!-- On Click Script for ingredients-->
		<script>
		var index = 2;
		var ingredientCount = 0;
		function addIng(){
			document.getElementById('ingredients').insertAdjacentHTML('beforeend',
				createAutocompleteTextbox('ingredients' + (ingredientCount++)));
			index = index + 1;
			$('#ingredient_count').val(ingredientCount);
		}
		</script>
		
		<!-- On Click Script for instructions-->
		<script>
		var instructionCount = 1;
		function addIns(){
			document.getElementById('instructions').insertAdjacentHTML('beforeend', 
				'<input type="text" name="instruction' + (instructionCount++) + '" class="form-control">');
				
			$('#instruction_count').val(instructionCount);
		}
		</script>

		<!-- Bootstrap Core CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/meals.css">
		
		<!-- Loads the Google interface -->
		<script src="https://apis.google.com/js/platform.js" async defer></script>
		<meta name="google-signin-client_id" content="406057883070-d26boopl1m5dd1cbknjl2cj3c1jl4eas.apps.googleusercontent.com">
		
	</head>

    <body>
        
		<!-- Navigation -->
		<div id="navigation" class="container">
			<script>
				$.get("assets/nav.html", function(data) {
					$("#navigation").replaceWith(data);
				});
			</script>
		</div>
		
		<div class="container" style="padding-top: 80px">
			
			<!-- Page Content -->
			<div class="jumbotron">
				<h1>Do you have a dank meal to share?</h1> 
				<h2><i>Please insert your dankness below.</i></h2> 
				<br />
				
				<form action="database/submitRecipe.php" method="get" autocomplete="off">
					<div class="form-group">
					  <label for="rec_name">Recipe Name</label>
					  <input type="text" name="name" class="form-control">
					</div>
					
					<div class="form-group">
						<label for="ing">Ingredients</label>
						<input type="hidden" name="ingredient_count" id="ingredient_count" value='0'>
						<!-- This is where the added ingredient textboxes will go-->
						<div id="ingredients"></div>
						<script>addIng();</script>
						
						
						
						<!-- Plus button for Ingredients-->
						<button onclick="addIng()" type="button" class="btn btn-default" aria-label="Left Align">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						</button>
					</div>
					
					<div class="form-group">
						<label for="ing">Instructions</label>
						<input type="hidden" name="instruction_count" id="instruction_count" value="1">
						<input type="text" name="instruction0" class="form-control">
						<!-- This is where the added instruction textboxes will go-->
						<div id="instructions"></div>
						
						<!-- Plus button for Instructions-->
						<button onclick="addIns()" type="button" class="btn btn-default" aria-label="Left Align">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						</button>
					</div>
					
					<div class="form-group">
						<label class="custom-file">
						  <input type="file" id="file" name="picture" class="custom-file-input">
						  <span class="custom-file-control"></span>
						</label>
					</div>
					
					<button type="submit" class="btn btn-mybtn">Submit</button>
					
				</form>
				
				</p>
			</div> 
			
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
