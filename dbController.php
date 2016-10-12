<?php
require 'database/dbInterface.php';

$dbInterface = new dbInterface();   //the dbInterface object used to access database

//determine which function has been called
switch ($_POST["function"]){
    case ("getRecipeList()"):
        echo json_encode($dbInterface->getRecipeList());
        break;
    case ("getRecipe()"):
        $id = (int) $_POST["argument"];   //recipe id that is passed to the page
        //TODO validate argument
        echo json_encode($dbInterface->getRecipe($id));
        break;
    default:
        header("HTTP/1.1 400 Bad Request");
        echo "No such function";
}