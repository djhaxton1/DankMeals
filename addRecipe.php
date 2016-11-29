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
		var ing = 1;
		function addIng(){
			// TODO: Fix autocomplete
			/*document.getElementById('ingredients').insertAdjacentHTML('beforeend',
				createAutocompleteTextbox('ingredients[' + (ing) + ']'));
			ing = ing + 1;
			*/
			document.getElementById('ingredients').insertAdjacentHTML('beforeend',''
				+'<div id="row' + ing + '"><div class="col-lg-2"><input type="text" name="measurement[' + (ing) + ']" class="form-control"></div>'
				+'<div class="col-lg-8"><input type="text" name="ingredient[' + (ing) + ']" class="form-control" required></div>'
				+'<div class="col-lg-2"><button onclick="removeIng(this)" type="button" name="' + ing + '" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></button></div><br /><br />');

			$('#ingredient_count').val(ing);
			ing++
		}
		</script>
		
		<script>
			//stops the form from trying to submit when the user presses enter
			$(document).on("keypress", 'form', function (e) {
				var code = e.keyCode || e.which;
				if (code == 13) { //13 = enter button
					e.preventDefault();
					return false;
				}
			});
		</script>
		
		<!-- On Click Script for instructions-->
		<script>
		var ins = 1;
		function addIns(){
			document.getElementById('instructions').insertAdjacentHTML('beforeend', ''
				+ '<div id="insRow' + ins + '">'
				+ '<div class="col-lg-10"><input type="text" name="instruction[' + ins + ']" id="instruction[' + ins + ']" class="form-control" required></div>'
				+ '<div class="col-lg-2"><button onclick="removeIns(this)" type="button" class="btn btn-default" name="' + ins + '"><span class="glyphicon glyphicon-remove"></span></button></div>'
				+ '<br /><br /></div>');
				
				ins++
				
			$('#instruction_count').val(ins);
		}
		</script>
		
		<script>
		function removeIng(elem){
			var num = elem.name;
			var id = "row" + num;
			
			document.getElementById(id).remove();
			ing = ing - 1;
		}
		</script>
		
		<script>
		function removeIns(elem){
			var num = elem.name;
				
			if(ins > 1) {
				var id = "insRow" + num;
				document.getElementById(id).remove();
				ins = ins - 1;
			} else {
				id = "instruction[" + num + "]";
				document.getElementById(id).value = "";
			}
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
	<style>
		.glyphicon {
			z-index: 0;
		}
		
	</style>
        
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
				
				<form action="database/submitRecipe.php" method="POST" enctype=multipart/form-data>
					<div class="form-group">
					  <label for="rec_name">Recipe Name</label>
					  <input type="text" name="title" class="form-control">
					</div>
					
					<div class="form-group">
						<label for="ing">Ingredients</label><br />
						<i><span class="col-lg-2">Example: [1 pinch]</span> <span class="col-lg-8">[salt]<span></i><br />
						<div id="ingredients">
							<div id="row0">
								<div class="col-lg-2">
									<input type="text" name="measurement[0]" class="form-control">
								</div>
								<div class="col-lg-8">
									<input type="text" name="ingredient[0]" class="form-control" required>
								</div>
								<div class="col-lg-2">
									<button onclick="removeIng(this)" type="button" class="btn btn-default" name="0">
										<span class="glyphicon glyphicon-remove"></span>
									</button>
								</div>
								<br /><br />
							</div>
						</div>
												
						<!-- Plus button for Ingredients-->
						<button onclick="addIng()" type="button" class="btn btn-default" aria-label="Left Align" style="z-index: -6">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						</button>
					</div>
					
					<div class="form-group">
						<label for="ins">Instructions</label>
						<input type="hidden" name="instruction_count" id="instruction_count" value="1">
						<div id="instructions">
							<div id="insRow0"> 
								<div class="col-lg-10">
									<input type="text" id="instruction[0]" name="instruction[0]" class="form-control" required>
								</div>
								<div class="col-lg-2">
									<button onclick="removeIns(this)" type="button" class="btn btn-default" name="0">
										<span class="glyphicon glyphicon-remove"></span>
									</button>
								</div>
							</div>
							<br /><br />
						</div>
						
						<!-- Plus button for Instructions-->
						<button onclick="addIns()" type="button" class="btn btn-default" aria-label="Left Align">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						</button>
					</div>
					
					<div class="form-group">
						<label class="custom-file">
						  <input type="file" id="file" name="image" class="custom-file-input">
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
