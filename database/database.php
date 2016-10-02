<?php
/**
 * Class: Database
 * Purpose : An Interface with the MySQL Database used by
 */
class database {
	/* Private Data Members */
	private $conn;

	/**
	 * Instaintates an new connection to the database
	 */
	function __construct() {
		$server   = "141.219.196.115";
		$username =             "tsp";
		$password =            "null";
		$db       =           "tspdb";
		// Create a Connection
		$this->conn  = new mysqli($server, $username, $password, $db);

		// Verify a Connection was made
		if ($this->conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} else {
			echo ("Connected Successfully\n");
		}
		$cmd = "show databases";
		$result = mysqli_query($this->conn, $cmd);
		if ($result->num_rows > 0) {
			// output data of each row
			$i = 1;
			while($row = $result->fetch_assoc()) {
				echo "Database $i: " . $row["Database"] . "\n" ;
				$i = $i + 1;
			}
		} else {
			echo "0 results";
		}
		return $this->conn;
	}


	/**
	 * Closes the Connection to the database.
	 */
	/*function __destruct() {
		echo "Closing Connection to Database...";
		$this->conn->close();
		echo "Done\n";
	}*/
}

//$db = new database();
//$db = null;
?>
