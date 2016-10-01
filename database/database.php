<?php
// Database File
// The PHP interface with our server
$server   = "141.219.196.115:3306";
$username = "tsp";
$password = "null";

// open an SSH session with the remote server
$db       = "tspdb";

// Create a Connection
$conn  = mysqli_connect("$server", "$username", "$password");

// Verify a Connection was made
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// Ask for all databases
$cmd = "show databases";

mysqli_query($conn, $cmd);
?>
