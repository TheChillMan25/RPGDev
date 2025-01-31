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

/**
 * Closes connection to the database.
 */
function closeConnection($conn)
{
    $conn->close();
}
//-----------------------------------------------------------------------------------
//--------------------Database management functions----------------------------------
/**
 * Check if the given data already exists in the database.
 * @param msqli $conn the connection to the database
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
    $sql = "SELECT password FROM Users WHERE username='$username'";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        return password_verify($password, $row['password']);
    }
    die("Error in password check.\n");
}
//12345678
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
    $stmt = $conn->prepare("INSERT INTO Users (username, email, password, pfp) VALUES (?, ?, ?, '../img/pfp/blank.png')");
    $stmt->bind_param("sss", $username, $email, $password);
    if ($stmt->execute() === false) {
        die("Error in data insertion.\n" . $conn->error);
    }

}

/**
 * Get the ID of the user.
 * @param mysqli $conn the connection to the database
 * @param string $username the username of the user
 */
function getUserData($conn, $username)
{
    $stmt = $conn->prepare("SELECT id, username, email, pfp FROM Users WHERE username = ?;");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
        $row = $result->fetch_assoc();
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
 * @return mixed the path of the uploaded file if successful, false otherwise
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

/**
 * List all characters of the user.
 * @param mysqli $conn the connection to the database
 * @param int $user_id the ID of the user
 * @return array the list of characters
 */
function listCharacters($conn, $user_id)
{
    $sql = "SELECT * FROM CharacterData WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        die("Error in character listing.\n" . $conn->error);
    }

    $characters = [];
    while ($row = $result->fetch_assoc()) {
        $characters[] = $row;
    }

    return $characters;
}

/**
 * Gets all character data of the given character id
 * @param mysqli $conn the connection to the database
 * @param int $character_id the ID of the character
 * @return array the character data
 */
function getCharacterData($conn, $character_id)
{
    $stmt = "SELECT * FROM CharacterData WHERE id = ?";
    $stmt = $conn->prepare($stmt);
    $stmt->bind_param("i", $character_id);
    if ($stmt->execute() !== TRUE) {
        die("Error in data retrieval.\n" . $conn->error);
    }
    return $stmt->get_result()->fetch_assoc();
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
    $stmt = "DELETE FROM CharacterData WHERE id = ?";
    $stmt = $conn->prepare($stmt);
    $stmt->bind_param("i", $id);

    if ($stmt->execute() !== TRUE) {
        die("Error in data deletion.\n" . $conn->error);
    }
}

/**
 * @param mysqli $conn the connection to the database
 * @param int $user_id the id of the user
 * @return bool number of characters the user have 
 */
function checkCharacterCount($conn, $user_id)
{
    $stmt = "SELECT COUNT(*) FROM CharacterData WHERE user_id = ?";
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
 * @return string the modifier
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
    } else if ('17' <= $value && $value <= '20') {
        return "+3";
    } else {
        throw new Exception("Invalid value for modifier calculation. VALUE: " . $value);
    }
}


function checkLogin()
{
    if (isset($_SESSION['loggedin'])) {
        return true;
    } else {
        return false;
    }
}

//----------------HTML functions-----------------//
/**
 * Creates $max_value amount of options for a selection
 * @param string $name Name of the selection applies to name and id property
 * @param int $max_value Max value of options, also printed if no $value_list is provided
 * @param list $value_list List of values to be printed as options
 * @param string $text Text to be printed as the selection default value
 * @param bool $required If the selection is required
 * @return void
 */
function createSelection($name, $max_value, $value_list = null, $text = "", $required = false)
{
    if (empty($value_list)) {
        echo '<select name="' . $name . '" id="' . $name . '" required>';
        for ($i = 0; $i <= $max_value; $i++) {
            echo '<option class="number" value="' . ($i == 0 ? null : $i) . '">' . $i . '</option>';
        }
    } else {
        echo '<select name="' . $name . '" id="' . $name . '" style="width: auto;" ' . ($required ? 'required' : '') . '>';
        echo '<option class="string" value="' . null . '">' . $text . '</option>';
        for ($i = 0; $i <= $max_value; $i++) {
            echo '<option class="string" value="' . $value_list[$i] . '">' . $value_list[$i] . '</option>';
        }
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

//----------------------Variables----------------------//

$knowledge_count = 0;
$knowledge = array(
    "Ősi Mágia",
    "Mitikus Lények",
    "Történelmi Események",
    "Fajok és Kultúrák",
    "Erdők és Vadonok",
    "Térképek",
    "Fejlett Technológia",
    "Hagyományok és Rítusok",
    "Szövetségek és Frakciók",
    "Rejtett Rejtvények"
);
$nations = ['Folyóköz', 'Magasföld', 'Holtág', 'Denn Karadenn', 'Cha Me Rén', 'Doma Altiora', 'Édd', 'Vadin', 'Monor', 'Rügysze', 'Kérgeláb', 'Kalapos', 'Au-1. Fenntartó', 'AU-2 Utód', 'Au-Cust. Örző', 'Abominus', 'Vámpír'];
$paths['Erő útja'] = ['Katona', 'Zsoldos', 'Dolgozó', 'Kovács'];
$paths['Ügyesség útja'] = ['Bérgyilkos', 'Tolvaj', 'Kézműves', 'Rúnavéső'];
$paths['Kitartás útja'] = ['Vadász', 'Őrző', 'Kereskedő', 'Gyűjtő'];
$paths['Ész útja'] = ['Szakács', 'Vegyész', 'Orvos', 'Feltaláló'];
$paths['Fortély útja'] = ['Zenész', 'Színész', 'Művész', 'Bűvész'];
$paths['Akaraterő útja'] = ['Pap', 'Inkvizítor', 'Gyógyító', 'Vezeklő'];

$armours = ['Ruha', 'Könnyű páncél', 'Közepes páncél', 'Sétáló erőd'];
$weapons = ["acél öklök", "buzogány", "csatabárd", "fejsze", "fokos", "hosszúkard", "íj", "kalapács", "karabély", "kard", "kézi ágyú", "kézi balliszta", "lándzsa", "ostor", "pálca", "pisztoly", "pöröly", "rapír", "szablya", "számszeríj", "tőr"];

?>