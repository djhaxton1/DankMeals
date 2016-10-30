<!DOCTYPE html>
<html>
    <head>
        <?php
			include "database/advancedSearchTag.php";
		?>
		
		<title>Advanced Search - Dank Meals</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		
		<!-- Bootstrap Core CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="bootstrap/css/meals.css">
		
		<script>
			var ingredientCount = 0;
			var ings = [];
			$(document).ready(function(){
				$("#ing_input").keyup(function(){
					if (event.keyCode == 13) { //13 = enter
						//$(this).hide(); 
						
						//turn into a button here
						var input = $("#ing_input").val();
						$("#ing_input").val("");
						ings.push(input);
						//input += (ingredientCount++);
						var text = "<button class='btn btn-primary' id='ing" + (ingredientCount++) + "' onclick='removeTag(this)'>" + input + "</button>" + " ";
						 $("#ing_list").append(text);
					}	
				});
			});
			/*function enterVal() {
				var text = document.getElementById("ing_input").value;
				window.alert(text);
			 //if(e.which === 13){
				
				//var text = document.getElementById("ing_input").elements[0].value;
				//ings[ingredientCount] = text;
				
				//window.alert(text);
				
				//document.getElementById('ing_list').insertAdjacentHTML('beforeend',
					//"<li>" + text + "</li>";
				
			 //}
			};*/
		</script>
		
		<script>
			//removes an ingredient from the list the user has entered
			//this function is called when the user clicks on one of the buttons
			$(document).ready(function(){
					function removeTag(elem){
						//TODO
						//remove from inglist array
						//remove from page
						
					};
				});
		
		</script>
		
		<script>
			//stops the form from trying to submit when the user presses enter
			$(document).on("keypress", 'form', function (e) {
				var code = e.keyCode || e.which;
				if (code == 13) {
					e.preventDefault();
					return false;
				}
			});
		</script>
		
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
			<div class="jumbotron" style="padding-bottom: 80px">
				<h1>Advanced Search</h1>
				<form action="database/getAdvSearchResults.php" method="get">
				
					<!--Text Box-->
					<label for="sel2">List ingredients you want to use. Separate by commas.</label>
					<input type="hidden" name="ingredient_count" id="ingredient_count" value='0' />
					<input type="text" class="form-control input-lg" id="ing_input" onKeyUp="enterVal()" autocomplete="off" />
				
					<br />
				
					<!-- Where to put the list of ingredients to search for -->
					<ul id="ing_list"></ul>
				
					<!--Select list Option-->
					<!-- -
					  <select multiple class="form-control" id="sel2">
						<!---
						Example of option
							<option>1</option>
						-->
						<!-- 
						<div id="ing_list"></div>
						
					  </select>  -->
					<br />
					<button type="submit" class="btn btn-mybtn" style="align-items:center">Search Ingredients</button>				
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
