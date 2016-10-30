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
	/*
	 * make sure users do not try to navigate to the
	 * autocompleteSearce.php page manually
	 */
	 
	if (!isset($_GET['query']) || !isset($_GET['id'])) {
		echo "You cannot visit this page manually";
		exit();
	}
	
	include "dbInterface.php";
	$interface = new dbInterface();
	
	$query = $_GET['query'];
	//TODO make this safe!  (you can just find replace characters that may be dangerous " ' ! - / \ 
	
	//$spChar = array('"', '\'', '!', '-', '/', '\\');
	//$query = str_replate($spChar, '', $query);
	
	$id = $_GET['id'];
	$matches = $interface->getIngredientAutocomplete($query);
	
	$index = 0;
	foreach ($matches as $m ) {
		echo "<div id='autocompleteDivSelection$id$index' class='autocompleteDropdown' onMouseEnter='$(this).addClass(\"autocompleteDropdownHover\")' onMouseLeave='$(this).removeClass(\"autocompleteDropdownHover\")' onClick='$(\"#$id\").val(\"$m\")'>$m</div>";
		$index++;
	}
?>