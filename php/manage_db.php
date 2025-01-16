<?php
/* $host="localhost";
$user="root";
$password="";
$dbname="RPG_DB";

$conn = new mysqli($host, $user, $password, $dbname);
if (!$conn) {
  echo "An error occurred.\n";
  die("Error in connection: " . pg_last_error());
}
else {
  echo "Connected to the database.\n";
} */

/* $sql = "ALTER TABLE USERS ADD COLUMN pfp VARCHAR(255)";
if ($conn->query($sql) === TRUE) {
  echo "Column added successfully\n";
} else {
  echo "Error adding column: " . $conn->error;
} */
/*
$sql = "CREATE DATABASE RPG_DB";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully\n";
} else {
  echo "Error creating database: " . $conn->error;
}

if($conn->query("USE RPG_DB")){
  echo "Database changed successfully\n";
} else {
  echo "Error changing database: " . $conn->error;
}

$sql = "CREATE TABLE Users (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(30) NOT NULL,
  password VARCHAR(30) NOT NULL,
  email VARCHAR(50))";
if ($conn->query($sql) === TRUE) {
  echo "Table Users created successfully\n";
} else {
  echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE Characters (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT(6) UNSIGNED UNIQUE,
  name VARCHAR(30) NOT NULL,
  level INT(3) UNSIGNED NOT NULL,
  race VARCHAR(30) NOT NULL,
  equipment VARCHAR(255) NOT NULL,
  knowledge VARCHAR(255) NOT NULL,
  description VARCHAR(255) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES Users(id))";

if ($conn->query($sql) === TRUE) {
  echo "Table Characters created successfully\n";
} else {
  echo "Error creating table: " . $conn->error;
}

$sql = 'CREATE TABLE Character_stats (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  character_id INT(6) UNSIGNED UNIQUE,
  strength INT(3) UNSIGNED NOT NULL,
  dexterity INT(3) UNSIGNED NOT NULL,
  endurance INT(3) UNSIGNED NOT NULL,
  intelligence INT(3) UNSIGNED NOT NULL,
  charisma INT(3) UNSIGNED NOT NULL,
  willpower INT(3) UNSIGNED NOT NULL,
  FOREIGN KEY (character_id) REFERENCES Characters(id))';

if ($conn->query($sql) === TRUE) {
  echo "Table Stats created successfully\n";
} else {
  echo "Error creating table: " . $conn->error;
}

$conn->close(); */

function delete(){
  $conn = connectToDB();

$sql = "DELETE FROM Users";
if ($conn->query($sql) === TRUE) {
    echo "All data deleted from Users table.\n";
} else {
    echo "Data deletion failed.\n";
    die("Error in data deletion.\n" . $conn->error);
}
$conn->close();
}

//delete();
?>