<?php
session_start();
session_unset();
session_destroy();

if (isset($_COOKIE['remember_me'])) {
    setcookie("remember_me", "", time() - 3600, "/"); // Süti törlése

    $conn = connectToDB();
    $stmt = $conn->prepare("UPDATE Users SET remember_token = NULL WHERE remember_token = ?");
    $stmt->bind_param("s", $_COOKIE['remember_me']);
    $stmt->execute();
}

if (basename($_SERVER['SCRIPT_NAME']) === 'index.php') {
    header("Location: index.php");
} else {
    header("Location: ../../index.php");
}
exit();
?>