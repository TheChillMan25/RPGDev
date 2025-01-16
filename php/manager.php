<?php
    //-----------------------------------------------------------------------------------
    //--------------------Database connection functions----------------------------------
    /**
     * Connect to the database.
     * Returns connection data.
     * @return MySQL\Connection|false - the connection to the database
     */
    function connectToDB(){
        $conn = new mysqli('localhost', 'root', null, 'RPG_DB');
        if(!$conn){
            echo "Connection failed.\n";
            die("Error in connection: " . $conn->connect_error);
        }
        return $conn;
    }

    /**
     * Closes connection to the database.
     */
    function closeConnection($conn){
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
    function checkExistingData($conn, $type, $data){
        if($type === 'username'){
            $sql = "SELECT username FROM Users";
            $result = $conn->query($sql);
            if($result){
                while($row = $result->fetch_assoc()){
                    if($row['username'] === $data){
                        return true;
                    }
                }
            }
        } 
        else if($type === 'email'){
            $sql = "SELECT email FROM Users";
            $result = $conn->query($sql);
            if($result){
                while($row = $result->fetch_assoc()){
                    if($row['email'] === $data){
                        return true;
                    }
                }
            }
        }
        else{
            return false;
        }
    }

    /**
     * @param $conn - the connection to the database
     * @param $username - the username of the user
     * @param $password - the password of the user
     * @return bool - true if the password is correct, false otherwise
     */
    function checkPsw($conn, $username, $password){
        $sql = "SELECT password FROM Users WHERE username='$username'";
        $result = $conn->query($sql);
        if($result){
            $row = $result->fetch_assoc();
            return password_verify($password, $row['password']);
        }
    }
    //12345678
    /**
     * Reset the ID counter of the database.
     * @param $conn - the connection to the database
     */
    function resetIDCounter($conn){
        $sql = 'ALTER TABLE Users AUTO_INCREMENT = 1;'; $result = $conn->query($sql);
        if($result) {
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
    function insertUserData($conn, $username, $email, $password){
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO Users (username, email, password, pfp) VALUES ('$username', '$email', '$password', '../img/pfp/blank.png')";
        if($conn->query($sql) === FALSE){
            die("Error in user data insertion.\n" . $conn->error);
        }
    }

    /**
     * Get the ID of the user.
     * @param $conn - the connection to the database
     * @param $username - the username of the user
    */
    function getUserData($conn, $username){
        $sql = "SELECT * FROM Users WHERE username='$username'";
        $result = $conn->query($sql);
        if($result){
            $row = $result->fetch_assoc();
            return $row;
        }
    }

    /**
     * Insert character data into the database.
     * @param $conn - the connection to the database
     * @param $name - the name of the character
     * @param $level - the level of the character
     * @param $race - the race of the character
     * @param $equipment - the equipment of the character
     * @param $knowledge - the knowledge of the character
     * @param $description - the description of the character
     * 
     */
    /* function insertCharacterData($conn, $name, $level, $race, $equipment, $knowledge, $description){
        $user_id = getUserID($conn, $_SESSION['username']);
        $sql = "INSERT INTO Characters (user_id, name, level, race, equipment, knowledge, description) VALUES ('$user_id', '$name', '$level', '$race', '$equipment', '$knowledge', '$description')";
        if($conn->query($sql) === FALSE){
            die("Error in character data insertion.\n" . $conn->error);
        }
    } */
?>