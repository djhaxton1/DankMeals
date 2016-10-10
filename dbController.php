<?php
require 'database/dbInterface.php';

$id = $_POST["argument"];   //recipe id that is passed to the page
if (gettype($id) != "integer"){
    header("HTTP/1.1 400 Bad Request");
    echo "Invalid ID";
    return;
}
$dbInterface = new dbInterface();   //the dbInterface object used to access database

//determine which function has been called
switch ($_POST["function"]){
    case ("getRecipeList()"):
        echo json_encode($dbInterface->getRecipeList());
        break;
    case ("getRecipe()"):
        echo json_encode($dbInterface->getRecipe($id));
        break;
    default:
        header("HTTP/1.1 400 Bad Request");
        echo "No such function";
}