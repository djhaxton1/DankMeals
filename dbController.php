<?php
require 'database/dbInterface.php';

$dbInterface = new dbInterface();   //the dbInterface object used to access database

//determine which function has been called
switch ($_POST["function"]){
    case ("getRecipeList()"):
        echo json_encode($dbInterface->getRecipeList());
        break;
    case ("getRecipe()"):
        //check that id is composed of decimal digits
        if (! ctype_digit($_POST["argument"])){
           header("HTTP/1.1 404 Page Not Found");
            echo "Invalid id";
            die("Invalid ID passed in url");
        }

        $id = (int) $_POST["argument"];  //recipe id that is passed to the page
        $out = $dbInterface->getRecipe($id);
        //check if dbInterface returned an error code
        if($out["error"]){
            header("HTTP/1.1 404 Page Not Found");
            echo "No Recipe with that ID";
            die("Invalid ID passed in url");
        }
        echo json_encode($out);
        break;
    default:
        header("HTTP/1.1 400 Bad Request");
        echo "No such function";
		break;
	case ("getPageContent()"):
		
		break;
}