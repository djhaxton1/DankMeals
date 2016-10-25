<style>
	.autocompleteDropdown {
		width: 100%;
	}
	
	.autocompleteDropdownHover {
		background-color:#66f;
		cursor: hand;
	}
</style>
<?php
	if (!isset($_GET['query']) || !isset($_GET['id'])) {
		echo "You cannot visit this page manually";
		exit();
	}
	
	include "dbInterface.php";
	$interface = new dbInterface();
	
	//TODO make this safe!  (you can just find replace characters that may be dangerous " ' ! - / \ 
	$query = $_GET['query'];
	$id = $_GET['id'];
	$matches = $interface->getIngredientAutocomplete($query);
	
	$index = 0;
	foreach ($matches as $m ) {
		echo "<div id='autocompleteDivSelection$id$index' class='autocompleteDropdown' onMouseEnter='$(this).addClass(\"autocompleteDropdownHover\")' onMouseLeave='$(this).removeClass(\"autocompleteDropdownHover\")' onClick='$(\"#$id\").val(\"$m\")'>$m</div>";
		$index++;
	}
?>