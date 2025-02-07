<?php
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
 * Reset the ID counter of the database.
 * @param $conn the connection to the database
 */
function resetIDCounter($conn)
{
    $sql = 'ALTER TABLE Users AUTO_INCREMENT = 1;';
    $result = $conn->query($sql);
    if ($result) {
        echo "Resetted id counter.\n";
    } else {
        echo "ID counter reset failed: " . $conn->error . "\n";
    }
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

function updateSession($username)
{
    $_SESSION['username'] = $username;
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
 * Get character path
 * @param mysqli $conn 
 * @param int $path_id Id of path to get.
 * @return string|bool|null
 */
function getPath($conn, $path_id)
{
    $stmt = $conn->prepare("SELECT name, description FROM Paths WHERE id=?");
    $stmt->bind_param("i", $path_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $path = $result->fetch_assoc();
        $stmt->close();
        return $path['name'];
    } else {
        return null;
    }
}

/**
 * Get character nation
 * @param mysqli $conn
 * @param int $nation_id Id of nation to get
 * @return string|bool|null
 */
function getCharacterNation($conn, $nation_id)
{
    $stmt = $conn->prepare("SELECT name, description FROM Nations WHERE id=?");
    $stmt->bind_param("i", $nation_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $nation = $result->fetch_assoc();
        $stmt->close();
        return $nation['name'];
    } else {
        return null;
    }
}
/**
 * Get character background
 * @param mysqli $conn
 * @param int $background_id Id of background wished to be gotten
 * @return array|bool|null
 */
function getCharacterBackground($conn, $background_id)
{
    $stmt = $conn->prepare('SELECT name, description FROM Backgrounds WHERE id=?');
    $stmt->bind_param('i', $background_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $stmt->close();
        $background = $result->fetch_assoc();
        return $background;
    }
}

/**
 * Lits all skills from table Skills
 * @param mixed $conn
 * @return array|null
 */
function getSkills($conn)
{
    $result = $conn->query('SELECT name, description FROM Skills');
    while ($row = $result->fetch_assoc()) {
        $skills[] = $row;
    }
    return $skills;

}
/**
 * Get items and gear
 * @param mysqli $conn
 * @param string $table_name Name of the table the gear should be gotten from
 * @param int $id Id of the item
 */
function getGear($conn, $table_name, $id)
{
    if ($table_name === "Armour") {
        $stmt = $conn->prepare('SELECT name, description, value, dex_mod FROM ' . $table_name . ' WHERE id=?');
    } else if ($table_name === "Weapons") {
        $stmt = $conn->prepare('SELECT name, description, dice, properties FROM ' . $table_name . ' WHERE id=?');
    } else {
        $stmt = $conn->prepare('SELECT name, description FROM ' . $table_name . ' WHERE id=?');
    }
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
        return $item;
    }
    return ["name" => "-", "description" => "-", "dice" => "-", "properties" => "-", "value" => "0", "dex_mod" => "0"];
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
function getTableData($conn, $table)
{
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
 * @param bool $required If true, the select block will be required
 * @param string $text Test to print as title of the select
 * @return void
 */
function createListSelect($name, $list, $required = false, $text = '')
{
    echo '<select name="' . $name . '" id="' . $name . '" style="width: auto;" ' . ($required ? 'required' : '') . '>';
    echo '<option class="string" value="' . null . '">' . $text . '</option>';
    for ($i = 0; $i < sizeof($list); $i++) {
        echo '<option class="string" value="' . $list[$i] . '">' . ucfirst($list[$i]) . '</option>';
    }
    echo '</select>';
}

/**
 * Create select with option groups
 * @param string $name Name of the selection applies to name and id property
 * @param list $list Key Value pairs, where $key is optgroup name, $value is the options for the optgroups
 * @param string $text Text to be printed as the selection default value
 * @param bool $required If the selection is required
 * @return void
 */
function createOptgroupSelect($name, $list, $text = "", $required = false)
{
    echo '<select name="' . $name . '" id="' . $name . '" style="width: auto;"' . ($required ? 'required' : '') . '>';
    echo '<option value="' . null . '">' . $text . '</option>';
    foreach ($list as $key => $value) {
        echo '<optgroup label="' . $key . '">';
        for ($i = 0; $i < count($value); $i++) {
            echo '<option value="' . $value[$i] . '" style="text-align: left">' . $value[$i] . '</option>';
        }
        echo '</optgroup>';
    }
    echo '</select>';
}
?>