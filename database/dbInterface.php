<?php

/**
 * Class: dbInterface
 * Purpose: To allow common database queries to be answered easily
 * and to decrease the number of database calls necessary
 * elsewhere in code.
 */
include 'database.php';
class dbInterface{
    private $db;    //the database object to perform queries on

    //constructor that instantiates a database object
    function __construct(){
        ob_start();
        $this->db = new database();
        ob_end_clean();
    }

    /**
     * @return array    an associative array containing basic data for all recipes where each index is a single entry
     *                  Data Currently Output:
     *                      array of recipe ids in $output["ids"]
     *                      array of recipe titles in $output["titles"]
     *                      integer that is the number of recipe entries in $output["length"]
     */
    function getRecipeList(){
        $output = array();
        $output["ids"] = $this->getIDs();   //add ids to output array
        $output["titles"] = $this->getTitles(); //add titles to output array
        $output["length"] = $this->getLength(); //add the number of recipe entries
        return $output;
    }

    /**
     * @return array    array of recipe ids
     */
    private function getIDs(){
        $query = "SELECT * FROM recipes ORDER BY id";
        $relevant = array("id");
        $result = $this->db->sendCommandParse($query, $relevant);   //retrieve id's
        $ids = array();     //array for output
        //create an array of the ids
        for ($i = 1; $i < count($result); $i++){
            $ids[$i] = $result[$i];
        }
        return $ids;
    }

    /**
     * @return array    array of recipe titles
     */
    private function getTitles(){
        $query = "SELECT * FROM recipes ORDER BY id";
        $relevant = array("title");
        $result = $this->db->sendCommandParse($query,$relevant);    //retrieve titles
        $titles = array();    //array for output
        //create an array of the titles
        for ($i = 1; $i < count($result); $i++){
            $titles[$i] = $result[$i];
        }
        return $titles;
    }

    private function getLength(){
        $query = "SELECT COUNT(*) FROM recipes";
        $relevant = array("COUNT(*)");
        $result = $this->db->sendCommandParse($query, $relevant);
        return $result[1];
    }
    /**
     * @param $id   the id of the recipe requested
     * @return array    associative array containing all relevant data for a single recipe entry
     *                  Data Currently Output:
     *                      title string in $output["title"]
     *                      array of ingredient strings in $output["ingredients"]
     *                      array of instruction strings in $output["instructions"]
     */
    function getRecipe($id){
        //TODO validate id

        $output = array();
        $output["title"] = $this->getTitle($id);
        $output["ingredients"] = $this->getIngredients($id);
        $output["instructions"] = $this->getInstructions($id);
        return $output;
    }

    /**
     * @param $id   the id of the recipe requested
     * @return mixed    the title of that recipe
     */
    private function getTitle($id){
        $query = "SELECT * FROM recipes WHERE id=" . $id;
        $relevant = array("title");
        $result = $this->db->sendCommandParse($query, $relevant); //retrieve title
        $output = $result[1];   //output
        return $output;
    }

    /**
     * @param $id   the id of the requested recipe
     * @return array    array containing the ingredients associated with that recipe
     */
    private function getIngredients($id){
        $query = "SELECT * FROM ingredients WHERE rec_id=" . $id . " ORDER BY order_num";
        $relevant = array("measurement", "name");
        $result = $this->db->sendCommandParse($query, $relevant);
        $output = array(); //array for output
        //create array of ingredients
        for ($i = 1; $i < count($result); $i += 2){
            $output[$i / 2 + 1] = $result[$i] . " " . $result[$i + 1];
        }
        return $output;
    }

    /**
     * @param $id   the id of the requested recipe
     * @return array    array containing the instructions associated with that recipe
     */
    private function getInstructions($id){
        $query = "SELECT * FROM instructions WHERE rec_id=" . $id . " ORDER BY order_num";
        $relevant = array("instruction_text");
        $result = $this->db->sendCommandParse($query, $relevant);
        $output = array();  //array for output
        //create array of instructions
        for ($i = 1; $i < count($result); $i++){
            $output[$i] = $result[$i];
        }
        return $output;
    }



    function __destruct(){
        ob_start();
        $this->db = null;
        ob_end_clean();
    }
}

