<?php

use function PHPSTORM_META\type;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//-----------------------------------------------------------------------------------
//--------------------Database connection functions----------------------------------
/**
 * Connect to the database.
 * Returns connection data.
 * @return mysqli|false the connection to the database
 */
function connectToDB()
{
    $conn = new mysqli('localhost', 'root', null, 'RPG_DB');
    if (!$conn) {
        echo "Connection failed.\n";
        die("Error in connection: " . $conn->connect_error);
    }
    return $conn;
}
//-----------------------------------------------------------------------------------
//--------------------Database management functions----------------------------------
/**
 * Check if the given data already exists in the database.
 * @param mysqli $conn the connection to the database
 * @param string $type the type of the data (username, email)
 * @param string $data the data to check (username, email)
 * @return bool true if the data does not exist, false otherwise
 */
function checkExistingData($conn, $type, $data)
{
    if ($type === 'username') {
        $sql = "SELECT username FROM Users";
        $result = $conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                if ($row['username'] === $data) {
                    return true;
                }
            }
        }
    } else if ($type === 'email') {
        $sql = "SELECT email FROM Users";
        $result = $conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                if ($row['email'] === $data) {
                    return true;
                }
            }
        }
    }
    return false;
}

/**
 * @param mysqli $conn the connection to the database
 * @param string $username the username of the user
 * @param string $password the password of the user
 * @return bool true if the password is correct, false otherwise
 */
function checkPsw($conn, $username, $password)
{
    $stmt = "SELECT password FROM Users WHERE username=?";
    $stmt = $conn->prepare($stmt);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
        $row = $result->fetch_assoc();
        $stmt->close();
        return password_verify($password, $row['password']);
    }
    die("Error in password check.\n");
}
/**
 * Checks if user is admin
 * @param string $username Username to be checked
 * @return bool|null
 */
function isAdmin($username)
{
    $conn = connectToDB();
    $stmt = $conn->prepare("SELECT * FROM Users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['status'] === 'admin';
    }
    return null;
}

/**
 * Insert data into the database.
 * @param $conn the connection to the database
 * @param $username the username of the user
 * @param $email the email of the user
 * @param $password the password of the user
 */
function insertUserData($conn, $username, $email, $password)
{
    $password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO Users (username, email, password, pfp, status) VALUES (?, ?, ?, '../img/pfp/blank.png', 'user')");
    $stmt->bind_param("sss", $username, $email, $password);
    if ($stmt->execute() === false) {
        die("Error in data insertion.\n" . $conn->error);
    }
    $stmt->close();
}

/**
 * Get the ID of the user.
 * @param mysqli $conn the connection to the database
 * @param string $username the username of the user
 */
function getUserData($conn, $username)
{
    $stmt = $conn->prepare("SELECT id, username, email, pfp, status FROM Users WHERE username = ?;");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row;
    }
}

/**
 * @param mysqli $conn the connection to the database
 * @param string $new_name the new username of the user
 * @param string $new_email the new email of the user
 * @return bool returns true if the data update was successful, false otherwise
 */
function updateUserData($conn, $new_name, $new_email)
{
    $user_data = getUserData($conn, $_SESSION['username']);
    if (!$new_name && !$new_email) {
        return false;
    }

    $updates = [];
    if ($new_name) {
        $updates[] = "username = '$new_name'";
    }
    if ($new_email) {
        $updates[] = "email = '$new_email'";
    }

    if (!empty($updates)) {
        $stmt = $conn->prepare("UPDATE Users SET username = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $new_name, $new_email, $user_data['id']);
        if ($stmt->execute() === TRUE) {
            $stmt->close();
            return true;
        }
    }
    die("User data update failed!\n");
}

/**
 * Upload profile picture.
 * @param list $user the user and its data
 * @param $file the file array from $_FILES
 * @param $target_dir the target directory to save the uploaded file
 * @return bool|string the path of the uploaded file if successful, false otherwise
 */
function uploadProfilePicture($user, $file, $target_dir = "../img/pfp/")
{
    $valid = true;
    $target_file = $target_dir . $user['username'] . "." . strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

    // MIME típus ellenőrzése
    $mime_type = mime_content_type($file["tmp_name"]);
    if (strpos($mime_type, 'image') === false) {
        error("File is not an image.");
        $valid = false;
    }

    // Fájlméret ellenőrzése
    if ($file["size"] > 5000000) {
        error("Sorry, your file is too large.");
        $valid = false;
    }

    // Engedélyezett típusok
    $allowed_types = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowed_types)) {
        error("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        $valid = false;
    }

    // Ha minden rendben van, fájl feltöltése
    if ($valid) {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return $target_file;
        } else {
            error("Sorry, there was an error uploading your file.");
            return false;
        }
    }

    return false;
}

function logout()
{
    session_unset();
    session_destroy();
    if (basename($_SERVER['SCRIPT_NAME']) === '../index.php') {
        header("Location: ../index.php");
    } else {
        header("Location: ../index.php");
    }
    exit();
}

function error($msg)
{
    $error_msg = "<span id='error_msg'>$msg</span>";
    echo $error_msg;
}


function checkLogin()
{
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        return true;
    } else {
        return false;
    }
}

//----------------RPG functions--------------------//
/**
 * List all characters of the user.
 * @param mysqli $conn the connection to the database
 * @param int $user_id the ID of the user
 * @return array the list of characters
 */
function listCharacters($conn, $user_id)
{
    $sql = "SELECT * FROM Characters WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        die("Error in character listing.\n" . $conn->error);
    }

    $characters = [];
    while ($row = $result->fetch_assoc()) {
        $characters[] = getCharacterData($conn, $row['id']);
    }

    return $characters;
}

/**
 * Gets all character data of the given character id
 * @param mysqli $conn the connection to the database
 * @param int $character_id the ID of the character
 * @return array|bool|null the character data
 */
function getCharacterData($conn, $character_id)
{
    $stmt = "SELECT * FROM Characters WHERE id = ?";
    $stmt = $conn->prepare($stmt);
    $stmt->bind_param("i", $character_id);
    if ($stmt->execute() !== TRUE) {
        die("Error in data retrieval.\n" . $conn->error);
    }
    $character = $stmt->get_result()->fetch_assoc();

    $stmt = "SELECT * FROM `Stats` WHERE id = ?";
    $stmt = $conn->prepare($stmt);
    $stmt->bind_param("i", $character['stats_id']);
    if ($stmt->execute() !== TRUE) {
        die("Error in data retrieval.\n" . $conn->error);
    }
    $stats = $stmt->get_result()->fetch_assoc();

    $stmt = "SELECT * FROM CharacterSkills WHERE id = ?";
    $stmt = $conn->prepare($stmt);
    $stmt->bind_param("i", $character['skills_id']);
    if ($stmt->execute() !== TRUE) {
        die("Error in data retrieval.\n" . $conn->error);
    }
    $skills = $stmt->get_result()->fetch_assoc();

    $stmt = "SELECT * FROM Equipment WHERE id = ?";
    $stmt = $conn->prepare($stmt);
    $stmt->bind_param("i", $character['equipment_id']);
    if ($stmt->execute() !== TRUE) {
        die("Error in data retrieval.\n" . $conn->error);
    }
    $equipment = $stmt->get_result()->fetch_assoc();

    $stmt = "SELECT * FROM Inventory WHERE id = ?";
    $stmt = $conn->prepare($stmt);
    $stmt->bind_param("i", $character['inventory_id']);
    if ($stmt->execute() !== TRUE) {
        die("Error in data retrieval.\n" . $conn->error);
    }
    $inventory = $stmt->get_result()->fetch_assoc();

    if (is_array($stats)) {
        foreach ($stats as $key => $value) {
            $character[$key] = $value;
        }
    }

    if (is_array($skills)) {
        foreach ($skills as $key => $value) {
            $character[$key] = $value;
        }
    }

    if (is_array($equipment)) {
        foreach ($equipment as $key => $value) {
            $character[$key] = $value;
        }
    }

    if (is_array($inventory)) {
        foreach ($inventory as $key => $value) {
            $character[$key] = $value;
        }
    }
    return $character;
}
/**
 * Get a record from a table by id
 * @param string $table Name of the table
 * @param int $id Id of the needed record
 * @return array|false|null
 */
function getRecord($table, $id)
{
    $conn = connectToDB();
    $stmt = $conn->prepare('SELECT * FROM ' . $table . ' WHERE id=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $stmt->close();
        $background = $result->fetch_assoc();
        return $background;
    }
}
/**
 * Get items and gear
 * @param string $table_name Name of the table the gear should be gotten from
 * @param int $id Id of the item
 */
function getGear($table_name, $id)
{
    $conn = connectToDB();
    $stmt = $conn->prepare('SELECT * FROM ' . $table_name . ' WHERE id=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
        return $item;
    }
    return ["name" => "-", "description" => "-", "dice" => "-", "properties" => "-", "value" => "0", "dex_mod" => "0", "type" => ""];
}
/**
 * Extracts dice data into an array
 * @param string $dice
 * @return array{dice_num: float|int|string, dice_type: float|int|string|array{dice_num: string, dice_type: string}}
 */
function getWeaponDiceData($dice)
{
    $dice_num = '';
    $dice_type = '';
    $type = false;
    for ($i = 0; $i < strlen($dice); $i++) {
        if ($dice[$i] === 'd')
            $type = true;
        if ($dice[$i] !== 'd' && $type !== true) {
            $dice_num .= $dice[$i];
        } else {
            $dice_type .= $dice[$i];
        }
    }
    return ['dice_num' => $dice_num, 'dice_type' => $dice_type];
}

/**
 * Delete character of given id
 * @param mysqli $conn the connection to the database
 * @param int $character_id the ID of the character
 * @return void
 */
function deleteCharacter($conn, $character_id)
{
    $id = $character_id;
    $stmt = "DELETE FROM Characters WHERE id = ?";
    $stmt = $conn->prepare($stmt);
    $stmt->bind_param("i", $id);

    if ($stmt->execute() !== TRUE) {
        die("Error in data deletion.\n" . $conn->error);
    }
}

/**
 * Checks if user has space for another character
 * @param mysqli $conn the connection to the database
 * @param int $user_id the id of the user
 * @return void 
 */
function checkCharacterCount($conn, $user_id)
{
    $stmt = "SELECT COUNT(*) FROM Characters WHERE user_id = ?";
    $stmt = $conn->prepare($stmt);
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute() !== TRUE) {
        throw new Exception("Error finding character count: {$conn->error}");
    }
    if ($stmt->get_result()->fetch_row()[0] >= 9) {
        header("Location: profile.php");
        exit();
    }
}

/**
 * Claculates modifier based on the given value
 * @param string $value the value to calculate the modifier from
 * @throws \Exception if the value is invalid
 * @return int|string the modifier
 */
function calculateModifier($value)
{
    if ('1' <= $value && $value <= '4') {
        return "-3";
    } else if ('5' <= $value && $value <= '6') {
        return "-2";
    } else if ('7' <= $value && $value <= '8') {
        return "-1";
    } else if ('9' <= $value && $value <= '12') {
        return "+0";
    } else if ('13' <= $value && $value <= '14') {
        return "+1";
    } else if ('15' <= $value && $value <= '16') {
        return "+2";
    } else if ('17' <= $value) {
        return "+3";
    } else {
        throw new Exception("Invalid value for modifier calculation. VALUE: " . $value);
    }
}
/**
 * Returns $table
 * @param $conn the connection to the database
 * @param $table the table the data is returned (Nations, Weapons, etc)
 * @return array|null the whole table in an associate array, null otherwise
 */
function getTableData($table)
{
    $conn = connectToDB();
    $sql = "SELECT * FROM " . $table;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    return null;
}

//----------------HTML functions-----------------//

/**
 * Summary of createStatSelect
 * @param string $name Name of the selection
 * @param int $min Minimum number to start
 * @param int $max Maximum number to stop
 * @param bool $required If true, the select block will be required
 * @return void
 */
function createStatSelect($name, $min = 1, $max = 6, $required = false)
{
    echo '<select name="' . $name . '" id="' . $name . '" ' . ($required ? 'required' : '') . '>';
    for ($i = $min; $i <= $max; $i++) {
        echo '<option class="number" value="' . $i . '">' . $i . '</option>';
    }
    echo '</select>';
}
/**
 * Create Select from a list
 * @param string $name Name of the selection
 * @param array|list $list List with the values
 * @param array|list $values Values for the elements of the $list
 * @param bool $required If true, the select block will be required
 * @param string $text Text to print as title of the select
 * @oaran string $text_value Value of the $text element
 * @return void
 */
function createListSelect($name, $list, $values, $required = false, $text = '', $text_value = null)
{
    echo '<select name="' . $name . '" id="' . $name . '" style="width: auto;" ' . ($required ? 'required' : '') . '>';
    echo '<option class="string" value="' . $text_value . '">' . ucfirst($text) . '</option>';
    for ($i = 0; $i < sizeof($list); $i++) {
        if ($list[$i] !== $text) {
            echo '<option class="string" value="' . $values[$i] . '">' . ucfirst($list[$i]) . '</option>';
        }
    }
    echo '</select>';
}