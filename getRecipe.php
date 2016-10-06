<?php
/**
 * Created by PhpStorm.
 * User: MichaelLay
 * Date: 10/3/2016
 * Time: 4:14 PM
 */
require 'database\database.php';

$id = $_POST["argument"];

//determine which function has been called
switch ($_POST["function"]){
    case "getTitle()":
        echo getTitle($id);
        break;
    case "getIngredients()":
        echo getIngredients($id);
        break;
    case "getInstructions":
        echo getInstructions($id);
        break;
    default:
        echo "Error: no such function!";
}


/**
 * @param $id           integer id of recipe
 * @return string       string that contains all relevant information as html tags
 * information retrieved   |  title
 *
 * Returns the title of a recipe entry given its id
 */
function getTitle($id){
    ob_start();
    $db = new database();
    ob_end_clean();
    $query = "SELECT * FROM recipes WHERE id=" . $id;
    $relevant = array("title");
    $result = $db->sendCommandParse($query, $relevant);
    ob_start();
    $db = null;
    ob_end_clean();
    $output = $result[1];
    return $output;
}

/**
 * @param $id           integer id of recipe
 * @return string       string that contains all relevant information as html tags
 * information retrieved   |  <li> instruction_text </li>
 *
 * Gathers all of the relevant information stored in the instructions table and
 * returns it as a string formatted as html tags
 */
function getInstructions($id){
    ob_start();
    $db = new database();
    ob_end_clean();
    $query = "SELECT * FROM instructions WHERE rec_id=" . $id . " ORDER BY order_num";
    $relevant = array("instruction_text");
    $result = $db->sendCommandParse($query,$relevant);
    ob_start();
    $db = null;
    ob_end_clean();
    $output = "";
    for ($i = 1; $i < count($result); $i++){
        $output .= "<li>" . $result[$i] . "</li>";
    }
    return $output;
}

/**
 * @param $id           integer id of recipe
 * @return string       string that contains all relevant information as html tags
 *information retrieved  |  <li> measurement name </li>
 *
 * Gathers all relevant information stored in the ingredients table and
 * return them as a string formatted as html tags
 */
function getIngredients($id){
    ob_start();
    $db = new database();
    ob_end_clean();
    $query = "SELECT * FROM ingredients WHERE rec_id=" . $id . " ORDER BY order_num";
    $relevant = array("measurement", "name");
    $result = $db->sendCommandParse($query, $relevant);
    ob_start();
    $db = null;
    ob_end_clean();
    $output = "";
    for ($i = 1; $i < count($result); $i += 2){
        $output .= "<li>" . $result[$i] . " " . $result[$i+1] . "</li>";
    }
    return $output;
}

//Example usage
//echo getTitle(1) . "\n";
//echo getIngredients(1) . "\n";
//echo getInstructions(1);
