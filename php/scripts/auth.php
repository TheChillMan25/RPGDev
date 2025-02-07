<?php
include 'manager.php';
session_start();
$conn = connectToDB();

if (!isset($_SESSION['username']) && isset($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];

    $stmt = $conn->prepare("SELECT username FROM Users WHERE remember_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
    } else {
        setcookie("remember_me", "", time() - 3600, "/");
    }
}
?>