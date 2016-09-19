<?php
$conn=new SQLite3("database");
$conn->query("CREATE TABLE IF NOT EXISTS users(id INTEGER PRIMARY KEY AUTOINCREMENT,username text NOT NULL,password text NOT NULL, name text NOT NULL)");
$conn->query("INSERT INTO users (username, password, name) values('sarah', '1234', 'Sarah Clements')");


$resultSet = $conn->query("SELECT * FROM users");

while($row = $resultSet->fetchArray()){
	echo "$row[id] $row[username] $row[password] $row[name] <br>";
}
?>