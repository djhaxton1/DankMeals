<!DOCTYPE html>
<meta charset="UTF-8"> 
<html>
    <head>		
		<title>Advanced Search - Dank Meals</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		
		<!-- Bootstrap Core CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/meals.css">
		
		<!-- Add Tags on Enter -->
		<script>
			var ings = [];
			$(document).ready(function(){
				$("#ing_input").keyup(function(event){
					if (event.keyCode == 13) { //13 = enterd
						
						//turn into a button here
						var input = $("#ing_input").val();
						$("#ing_input").val("");
						ings.push(input);
						//input += (ingredientCount++);
						var text = "<div class='btn btn-warning' style='margin-top: 5px; margin-right: 5px' id='" + input + "' onclick='removeTag(this)'>" + input + " " + "<span class='glyphicon glyphicon-remove'></span></div>";
						 $("#ing_list").append(text);
						//TODO PHP Code here
					}	
				});
			});

		</script>
		
		<!-- Search for Recipes -->
		<script>
			$(document).ready(function() {
				$('form').submit(function(event) { //Trigger on form submit
					$('#searchresults').empty(); //Clear the messages first

					//Validate fields if required using jQuery

					var postForm = { //Fetch form data
						'ings'     : ings //Store name fields value
					};

					$.ajax({ //Process the form using $.ajax()
						type      : 'POST',        //Method type
						url       : 'database/getAdvSearchResults.php',
						data      : postForm,      //Forms name
						dataType  : 'json',
						success   : function(data) {
                        	$('#searchresults').append('<p>' + data.posted + '</p>');
						}
					});
					event.preventDefault(); //Prevent the default submit
				});
			});		
		</script>
		
		<script>
				function removeTag(elem){
					//$("#ing_list").append("text");
					var id = elem.id;
					$("ing_list").append(id);

					//remove from page
					//$(elem).hide();
					document.getElementById(id).remove();
				}
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
			<form method='post' name="searchform">
				<!--Text Box-->
				<!--label for="sel2">List ingredients you want to use. Separate by commas.</label-->
				<label for="sel2">List keywords you want to search for. Press enter after each keyword.</label>
				<!--input type="hidden" name="keywords" id="ingredient_count" value='0' /-->
				<input type="text" class="form-control input-lg" id="ing_input" autocomplete="off" />
			
				<br />
			
				<!-- Where to put the list of ingredients to search for -->
				<span id="ing_list" name="ingredients"></span>
				<br />
				<!--Select list Option-->

				<br />
				<input type="submit" class="btn btn-mybtn" style="align-items:center" value="Search Ingredients"/>				

		</form>

		<!-- Search Results -->
		<div id="searchresults" class="container">
			<label for="sel2">The Dankness is lacking...</label>
		<div>

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
