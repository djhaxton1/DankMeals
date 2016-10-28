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
     * @return array    array of recipe titles
     */
    function getTitles(){
        $query = "SELECT * FROM recipes ORDER BY id;";
        $relevant = array("title");
        $result = $this->db->sendCommandParse($query,$relevant);    //retrieve titles
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
     * @param $data     an associative array that contains information in the following format
     *                      data["title"]: the name of the recipe as a string
     *                      data["parent_id"]: the id of the parent recipe as an integer  |  NUll if no parent
     *                      data["ingredient_measurement"]: an array of ingredient measurement strings in the order they appear
     *                      data["ingredient_name"]: an array of ingredient name strings in the order they appear
     *                      data["instructions"]: an array of instruction text strings in the order they appear
     *
     * @return int     ID of the newly added recipe in the recipes table
     *
     * Inserts a new recipe and its associated instructions and ingredients
     *     Note:  this function assumes that a correctly formatted directory will be built for the picture file
     */
    function insertRecipe($data){
        //TODO validate argument
        if (gettype($data["parent_id"]) !== "integer" && $data["parent_id"] != "NULL"){
            die("Invalid parent Id passed in data['parent_id']. This should be an integer.");
        }
        if (gettype($data["title"]) !== "string"){
            die("Invalid title passed in data['title']. This should be a string.");
        }
        if (gettype($data["ingredient_measurement"]) !== "array" || gettype($data["ingredient_measurement"][0]) != "string"){
            die("Invalid measurement passed in data['ingredient_measurement']. This should be an array of strings.");
        }
        if (gettype($data["ingredient_name"]) !== "array" || gettype($data["ingredient_name"][0]) !== "string"){
            die("Invalid name passed in data['ingredient_name']. This should be an array of strings.");
        }
        if (gettype($data["instructions"]) !== "array" || gettype($data["instructions"][0]) !== "string"){
            die("Invalid instruction passed in data['instruction']. This should be an array of strings.");
        }
        $id = -1;
        //insert main recipe entry
        $query = "INSERT INTO recipes (parent_id, title, picture) VALUES (" . $data["parent_id"] . ", '" . $data["title"] . "', NULL)";
        $this->db->sendCommand($query);
        $id = $this->db->getLastID();   //find the id of the newly inserted recipe
        //insert the assumed path to the picture file
        $directory = "/rec" . $id ."/rec" . $id . "_0.jpg";
        $query = "UPDATE recipes SET picture='" . $directory . "' WHERE id=" . $id;
        $this->db->sendCommand($query);
        //insert ingredients to ingredients table
        for ($i = 0; $i < count($data["ingredient_measurement"]); $i++){
            $query = "INSERT INTO ingredients (rec_id, order_num, measurement, name) VALUES (" .
                $id . ", " . ($i+1) . ", '" . $data["ingredient_measurement"][$i] . "', '" . $data["ingredient_name"][$i] . "')";
            $this->db->sendCommand($query);
        }
        //insert instructions to instructions table
        for ($i = 0; $i < count($data["instructions"]); $i++){
            $query = "INSERT INTO instructions (rec_id, order_num, instruction_text) VALUES (" . $id . ", " .
                ($i+1) . ", '" . $data["instructions"][$i] . "')";
            $this->db->sendCommand($query);
        }
        return $id; //the id of the new entry in the recipes table
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

	/**Search our database for an ingredient that starts with $text
	* Return an array of results that match this pattern
	*/
	function getIngredientAutocomplete($text) {
		
		$query = "SELECT * FROM ingredients WHERE name LIKE '$text%' ORDER BY name ASC LIMIT 10";

		$matches = array();
		if ($text == "") { return $matches; }
		
		$result = $this->db->sendCommand($query);
		while ($row = mysqli_fetch_array($result)) {
			$matches[] = $row['name'];
		}
		
		return $matches;
	}

    function __destruct(){
        ob_start();
        $this->db = null;
        ob_end_clean();
    }
}

$k = new dbInterface();
$recipe = array();
$recipe["parent_id"] = "NULL";
$recipe["title"] = "Chicken Piccata";
$temp = array("4", "3 tablespoons", "1 1/2 tablespoons", "Additional", "2 tablespoons", "1/3 cup", "1/4 cup", "1/4 cup", "1/4 cups", "1/4 cups");
$recipe["ingredient_measurement"] = $temp;
$temp = array("skinless boneless chicken breast", "butter room temperature", "all purpose flour", "all purpose flour", "olive oil", "dry white wine", "fresh lemon juice", "canned low-salt chicken broth", "drained capers", "chopped fresh parsley");
$recipe["ingredient_name"] = $temp;
$temp = array("Place chicken between 2 large sheets of plastic wrap. Using meat pounder or rolling pin, lightly pound chicken to 1/4-inch thickness. Sprinkle chicken with salt and pepper. Mix 1 tablespoon butter and 1 1/2 tablespoons flour in small bowl until smooth. Place additional flour in shallow baking dish. Dip chicken into flour to coat; shake off excess.", "Heat 1 tablespoon oil in each of 2 heavy large skillets. Add 2 chicken breasts to each skillet and cook until golden and cooked through, about 3 minutes per side. Transfer chicken to platter; tent with foil to keep warm.", "Bring wine, lemon juice and broth to boil in 1 skillet over medium-high heat. Whisk in butter-flour mixture and boil until sauce thickens slightly, about 2 minutes. Stir in capers, parsley and remaining 2 tablespoons butter. Season sauce to taste with salt and pepper. Pour sauce over chicken and serve.");
$recipe["instructions"] = $temp;
$k->insertRecipe($recipe);


