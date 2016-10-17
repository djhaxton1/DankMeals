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
     *                      array of recipe pictures in $output["pictures"]
     */
    function getRecipeList(){
        $output = array();
        $output["ids"] = $this->getIDs();   //add ids to output array
        $output["titles"] = $this->getTitles(); //add titles to output array
        $output["pictures"] = $this->getPictures(); //add the recipe thumbnail pictures
        return $output;
    }

    /**
     * @return array    array of recipe ids
     */
    private function getIDs(){
        $query = "SELECT * FROM recipes ORDER BY id";
        $relevant = array("id");
        $result = $this->db->sendCommandParse($query, $relevant);   //retrieve id's
        return $result;
    }

    /**
     * @return array    array of recipe titles
     */
    function getTitles(){
        $query = "SELECT * FROM recipes ORDER BY id;";
        $relevant = array("title");
        $result = $this->db->sendCommandParse($query,$relevant);    //retrieve titles
        return $result;
<<<<<<< HEAD
    }

    private function getLength(){
        $query = "SELECT COUNT(*) FROM recipes";
        $relevant = array("COUNT(*)");
        $result = $this->db->sendCommandParse($query, $relevant);
        return $result[1];
=======
>>>>>>> 3d88ef9e52c6f9ce013f7452d4e6b3833ec1759a
    }

    /**
     * @return array    array of recipe thumbnail pictures
     */
    private function getPictures(){
        $query = "SELECT * FROM recipes ORDER BY id";
        $relevant = array("picture");
        $result = $this->db->sendCommandParse($query, $relevant);
        return $result;
    }
    /**
     * @param $id   the id of the recipe requested
     * @return array    associative array containing all relevant data for a single recipe entry
     *                  Data Currently Output:
     *                      title string in $output["title"]
     *                      array of ingredient strings in $output["ingredients"]
     *                      array of instruction strings in $output["instructions"]
     *                      string that contains the picture path in $output["picture"]
     */
    function getRecipe($id){
        $output = array();
        $output["title"] = $this->getTitle($id);
        //check if id is a valid recipe id
        if ($output["title"] == null){
            $output["error"] = -1;  //error code
            return $output;
        }else{
            $output["error"] = 0;   //no error
        }
        $output["ingredients"] = $this->getIngredients($id);
        $output["instructions"] = $this->getInstructions($id);
        $output["picture"] = $this->getPicture($id);
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
        return $result[0];
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
        for ($i = 0; $i < count($result); $i += 2){
            $output[$i / 2] = $result[$i] . " " . $result[$i + 1];
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
        return $result;
    }

    /**
     * @param $id   the id of the requested recipe
     * @return mixed    string containing the picture address
     */
    private function getPicture($id){
        $query = "SELECT * FROM recipes WHERE id=" . $id;
        $relevant = array("picture");
        $result = $this->db->sendCommandParse($query, $relevant);
        return $result[0];
    }



    function __destruct(){
        ob_start();
        $this->db = null;
        ob_end_clean();
    }
}
