<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli('localhost', 'root', '', 'RPG_DB');
if ($conn->query("USE RPG_DB"))
  echo "Using RPG_DB\n";

//---Create Tables---//

if (
  $conn->query("CREATE TABLE Items(
  id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(30),
  description VARCHAR (255)
  );"
  )
)
  echo "Created Items table\n";
else
  echo "Table Items creation failed " . $conn->error;

if (
  $conn->query("CREATE TABLE Weapons(
    id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30),
    dice VARCHAR(10),
    description VARCHAR (255),
    properties VARCHAR (100)
    );"
  )
)
  echo "Created Weapons table\n";
else
  echo "Table Weapons creation failed " . $conn->error;

if (
  $conn->query("CREATE TABLE Armour(
      id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(30),
      value INT(3),
      description VARCHAR (255),
      dex_mod INT(1));"
  )
)
  echo "Created Armour table\n";
else
  echo "Table Armour creation failed " . $conn->error;

if (
  $conn->query("CREATE TABLE Paths(
      id INT(2) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      group_id INT(2) UNSIGNED NOT NULL,
      name VARCHAR(30),
      description VARCHAR (255));"
  )
)
  echo "Created Paths table\n";
else
  echo "Table Paths creation failed " . $conn->error;

if (
  $conn->query("CREATE TABLE PathGroups(
id INT(2) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(30),
description VARCHAR (255));"
  )
)
  echo "Created PathGroups table\n";
else
  echo "Table PathGroups creation failed " . $conn->error;

if (
  $conn->query("CREATE TABLE Nations(
      id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(30),
      description VARCHAR (255));"
  )
)
  echo "Created Nations table\n";
else
  echo "Table Nations creation failed " . $conn->error;


if (
  $conn->query("CREATE TABLE Skills(
          id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        description VARCHAR(100)
        );"
  )
)
  echo "Created Skills table\n";
else
  echo "Table Skills creation failed " . $conn->error;

if (
  $conn->query("CREATE TABLE Backgrounds(
            id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          name VARCHAR(50) NOT NULL,
          description VARCHAR(100)
          );"
  )
)
  echo "Created Backgrounds table\n";
else
  echo "Table Backgrounds creation failed " . $conn->error;

if (
  $conn->query("CREATE TABLE Characters(
    id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED NOT NULL,
    name VARCHAR(30),
    nation_id INT(4) UNSIGNED,
    path_id INT(4) UNSIGNED,
    path_level INT(4) UNSIGNED,
    stats_id INT(4) UNSIGNED,
    skills_id INT(4) UNSIGNED,
    background_id INT(4) UNSIGNED,
    equipment_id INT(4) UNSIGNED,
    inventory_id INT(4) UNSIGNED
    );"
  )
)
  echo "Created Character table\n";
else
  echo "Table Character creation failed " . $conn->error;



if (
  $conn->query("CREATE TABLE Inventory(
      id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      character_id INT(5) UNSIGNED NOT NULL,
      item_1_id INT(4) UNSIGNED,
      item_2_id INT(4) UNSIGNED,
      item_3_id INT(4) UNSIGNED,
      item_4_id INT(4) UNSIGNED,
      item_5_id INT(4) UNSIGNED,
      item_6_id INT(4) UNSIGNED,
      item_7_id INT(4) UNSIGNED,
      item_8_id INT(4) UNSIGNED,
      item_9_id INT(4) UNSIGNED,
      item_10_id INT(4) UNSIGNED,
      FOREIGN KEY (character_id) REFERENCES Characters(id) ON DELETE CASCADE ON UPDATE CASCADE
      );"
  )
)
  echo "Created Inventory table\n";
else
  echo "Table Inventory creation failed " . $conn->error;

if (
  $conn->query("CREATE TABLE Equipment(
        id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      character_id INT(5) UNSIGNED NOT NULL,
      left_hand INT(4) UNSIGNED,
      right_hand INT(4) UNSIGNED,
      armour INT(4) UNSIGNED,
      FOREIGN KEY (character_id) REFERENCES Characters(id) ON DELETE CASCADE ON UPDATE CASCADE
      );"
  )
)
  echo "Created Equipment table\n";
else
  echo "Table Equipment creation failed " . $conn->error;

if (
  $conn->query("CREATE TABLE CharacterSkills(
          id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        character_id INT(5) UNSIGNED NOT NULL,
        skill_1_lvl INT(4) UNSIGNED,
        skill_2_lvl INT(4) UNSIGNED,
        skill_3_lvl INT(4) UNSIGNED,
        skill_4_lvl INT(4) UNSIGNED,
        skill_5_lvl INT(4) UNSIGNED,
        skill_6_lvl INT(4) UNSIGNED,
        skill_7_lvl INT(4) UNSIGNED,
        skill_8_lvl INT(4) UNSIGNED,
        skill_9_lvl INT(4) UNSIGNED,
        skill_10_lvl INT(4) UNSIGNED,
        FOREIGN KEY (character_id) REFERENCES `Characters`(id) ON DELETE CASCADE ON UPDATE CASCADE
        );"
  )
)
  echo "Created CharacterSkills table\n";
else
  echo "Table CharacterSkills creation failed " . $conn->error;


if (
  $conn->query("CREATE TABLE `Stats`(
        id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      character_id INT(5) UNSIGNED NOT NULL,
      max_health INT(4) UNSIGNED,
      max_sanity INT(4) UNSIGNED,
      health INT(4) UNSIGNED,
      sanity INT(4) UNSIGNED,
      strength INT(4) UNSIGNED,
      dexterity INT(4) UNSIGNED,
      endurance INT(4) UNSIGNED,
      intelligence INT(4) UNSIGNED,
      charisma INT(4) UNSIGNED,
      willpower INT(4) UNSIGNED,
      FOREIGN KEY (character_id) REFERENCES Characters(id) ON DELETE CASCADE ON UPDATE CASCADE
      );"
  )
)
  echo "Created Stats table\n";
else
  echo "Table Stats creation failed " . $conn->error;


//---Alter Tables---//
/* if (
  $conn->query(
    "ALTER TABLE Users ADD status VARCHAR(5);"
  )
)
  echo "Altered Users table\n";
else
  echo "Table Users alter failed " . $conn->error;

if (
  $conn->query(
    "UPDATE Users SET status='user' WHERE status IS NULL;"
  )
)
  echo "Updated Users table\n";
else
  echo "Table Users update failed " . $conn->error;

if (
  $conn->query(
    "ALTER TABLE Users ADD COLUMN remember_token VARCHAR(64) UNIQUE NULL;"
  )
)
  echo "Altered Users table\n";
else
  echo "Table Users alter failed " . $conn->error; */

$conn->close();
?>