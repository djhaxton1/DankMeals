<?php
/**
 * Created by PhpStorm.
 * User: MichaelLay
 * Date: 10/3/2016
 * Time: 4:14 PM
 */
require 'database\database.php';

/**
 * @param $id        the integer id of the recipe requested
 * @return array     an array with three string elements where:
 *                   [1]   information from recipes table
 *                   [2]   information from ingredients table
 *                   [3]   information from instructions table
 *
 * Gathers all necessary data for a recipe from the database provided its id
 * and return it as an array of strings formatted as html tags
 */
function getRecipe($id){
    $output = array();
    $output[1] = getMain($id);
    $output[2] = getIngredients($id);
    $output[3] = getInstructions($id);
    return $output;
}

/**
 * @param $id           integer id of recipe
 * @return string       string that contains all relevant information as html tags
 * information retrieved   |  <h1> title </h1>
 *
 * Gathers all of the relevant information stored in the recipes table and
 * returns it as a string formatted as html tags
 */
function getMain($id){
    $db = new database();
    $query = "SELECT * FROM recipes WHERE id=" . $id;
    $relevant = array("title");
    $result = $db->sendCommandParse($query, $relevant);
    $db = null;
    $output = "<h1>" . $result[1] . "</h1>";
    return $output;
}

/**
 * @param $id           integer id of recipe
 * @return string       string that contains all relevant information as html tags
 * information retrieved   |  <ol><li> instruction_text </li></ol>
 *
 * Gathers all of the relevant information stored in the instructions table and
 * returns it as a string formatted as html tags
 */
function getInstructions($id){
    $db = new database();
    $query = "SELECT * FROM instructions WHERE rec_id=" . $id . " ORDER BY order_num";
    $relevant = array("instruction_text");
    $result = $db->sendCommandParse($query,$relevant);
    $db = null;
    $output = "<ol>";
    for ($i = 1; $i < count($result); $i++){
        $output .= "<li>" . $result[$i] . "</li>";
    }
    $output .= "</ol>";
    return $output;
}

/**
 * @param $id           integer id of recipe
 * @return string       string that contains all relevant information as html tags
 *information retrieved  |  <ul><li> measurement name </li></ul>
 *
 * Gathers all relevant information stored in the ingredients table and
 * return them as a string formatted as html tags
 */
function getIngredients($id){
    $db = new database();
    $query = "SELECT * FROM ingredients WHERE rec_id=" . $id . " ORDER BY order_num";
    $relevant = array("measurement", "name");
    $result = $db->sendCommandParse($query, $relevant);
    $db = null;
    $output = "<ul>";
    for ($i = 1; $i < count($result); $i += 2){
        $output .= "<li>" . $result[$i] . " " . $result[$i+1] . "</li>";
    }
    $output .= "</ul>";
    return $output;
}

//Example usage
//$result = getRecipe(1);
//echo $result[1] . "\n";
//echo $result[2] . "\n";
//echo $result[3];
