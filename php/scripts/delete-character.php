<?php
include 'manager.php';
session_start();
if (checkLogin()) {
    $conn = connectToDB();
    if ($_SERVER['REQUEST_METHOD'] === 'post' && isset($_POST['character_id'])) {
        deleteCharacter($conn, $_POST['character_id']);
        header('Location: ../profile.php');
        exit();
    }
} else {
    header('../login.php');
    exit();
}
