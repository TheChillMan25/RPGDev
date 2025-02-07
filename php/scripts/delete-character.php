<?php
include 'manager.php';
session_start();
if (checkLogin()) {
    $conn = connectToDB();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        deleteCharacter($conn, $_POST['id']);
        header('Location: ../profile.php');
    }
} else {
    header('../login.php');
    exit();
}
?>