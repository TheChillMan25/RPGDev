<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//-----------------------------------------------------------------------------------
//--------------------Database connection functions----------------------------------
/**
 * Connect to the database.
 * Returns connection data.
 * @return mysqli|false - the connection to the database
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
 * @param $conn - the connection to the database
 * @param $type - the type of the data (username, email)
 * @param $data - the data to check (username, email)
 * @return bool - true if the data does not exist, false otherwise
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
 * @param $conn - the connection to the database
 * @param $username - the username of the user
 * @param $password - the password of the user
 * @return bool - true if the password is correct, false otherwise
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
 * @param $conn - the connection to the database
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
 * @param $conn - the connection to the database
 * @param $username - the username of the user
 * @param $email - the email of the user
 * @param $password - the password of the user
 */
function insertUserData($conn, $username, $email, $password)
{
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO Users (username, email, password, pfp) VALUES ('$username', '$email', '$password', '../img/pfp/blank.png')";
    if ($conn->query($sql) === FALSE) {
        die("Error in user data insertion.\n" . $conn->error);
    }
}

/**
 * Get the ID of the user.
 * @param $conn - the connection to the database
 * @param $username - the username of the user
 */
function getUserData($conn, $username)
{
    $sql = "SELECT id, username, email, pfp FROM Users WHERE username='$username'";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        return $row;
    }
}

/**
 * @param $conn - the connection to the database
 * @param $new_name - the new username of the user
 * @param $new_email - the new email of the user
 * @param $new_psw - the new password of the user
 * @return bool - returns true if the data update was successful, false otherwise
 */
function updateUserData($conn, $new_name, $new_email)
{
    $user_data = getUserData($conn, $_SESSION['username']);
    if (!$new_name && !$new_email) {
        return false; // Return false if both are empty
    }

    $updates = [];
    if ($new_name) {
        $updates[] = "username = '$new_name'";
    }
    if ($new_email) {
        $updates[] = "email = '$new_email'";
    }

    if (!empty($updates)) {
        $sql = "UPDATE Users SET " . implode(', ', $updates) . " WHERE id = " . $user_data['id'];
        var_dump($sql);
        if ($conn->query($sql)) {
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
 * Change the user's password.
 * @param $conn - the connection to the database
 * @param $username - the username of the user
 * @param $current_password - the current password of the user
 * @param $new_password - the new password of the user
 * @return bool - true if the password was changed successfully, false otherwise
 */
function changePassword($conn, $username, $new_password)
{
    // Check if new password meets length requirement
    if (strlen($new_password) < 8) {
        error("New password must be at least 8 characters long.");
        return false;
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password in the database
    $sql = "UPDATE Users SET password = '$hashed_password' WHERE username = '$username'";
    if ($conn->query($sql)) {
        return true;
    } else {
        error("Failed to change password.");
        return false;
    }
}

/**
 * Upload profile picture.
 * @param list $user - the user and its data
 * @param $file - the file array from $_FILES
 * @param $target_dir - the target directory to save the uploaded file
 * @return mixed - the path of the uploaded file if successful, false otherwise
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
 * @param mysqli $conn - the connection to the database
 * @param int $user_id - the ID of the user
 * @return array - the list of characters
 */
function listCharacters($conn, $user_id)
{
    // SQL lekérdezés előkészítése a biztonság érdekében
    $sql = "SELECT * FROM CharacterData WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    // Paraméter hozzáadása
    $stmt->bind_param("i", $user_id);

    // Lekérdezés végrehajtása
    $stmt->execute();

    // Eredmények lekérése
    $result = $stmt->get_result();

    if ($result === false) {
        die("Error in character listing.\n" . $conn->error);
    }

    // Eredmények feldolgozása
    $characters = [];
    while ($row = $result->fetch_assoc()) {
        $characters[] = $row;
    }

    return $characters;
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
 * @param string $name - Name of the selection - applies to name and id property
 * @param int $max_value - Max value of options, also printed if no $value_list is provided
 * @param list $value_list - List of values to be printed as options
 * @param string $text - Text to be printed as the selection default value
 * @param bool $required - If the selection is required
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
            echo '<option class="string" value="' . strtolower($value_list[$i]) . '">' . $value_list[$i] . '</option>';
        }
    }
    echo '</select>';
}
/**
 * Create select with option groups
 * @param string $name - Name of the selection - applies to name and id property
 * @param list $list - Key - Value pairs, where $key is optgroup name, $value is the options for the optgroups
 * @param string $text - Text to be printed as the selection default value
 * @param bool $required - If the selection is required
 * @return void
 */
function createOptgroupSelect($name, $list, $text = "", $required = false)
{
    echo '<select name="' . $name . '" id="' . $name . '" style="width: auto;"' . ($required ? 'required' : '') . '>';
    echo '<option value="' . null . '">' . $text . '</option>';
    foreach ($list as $key => $value) {
        echo '<optgroup label="' . $key . '">';
        for ($i = 0; $i < count($value); $i++) {
            echo '<option value="' . strtolower($value[$i]) . '" style="text-align: left">' . $value[$i] . '</option>';
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