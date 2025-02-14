<?php
include "../manager.php";
session_start();
$conn = connectToDB();

if (!isAdmin($_SESSION['username']))
    die('Not admin!');

var_dump($_POST);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_POST['action']) {
        case 'delete-nation':
            $_SESSION['NATION_ID'] = 0;
            $stmt = $conn->prepare('DELETE FROM Nations WHERE id=?');
            $stmt->bind_param('s', $_POST['id']);
            $stmt->execute();
            $stmt->close();
            break;
        case 'delete-background':
            $_SESSION['BACKGROUND_ID'] = 0;
            $stmt = $conn->prepare('DELETE FROM Backgrounds WHERE id=?');
            $stmt->bind_param('s', $_POST['id']);
            $stmt->execute();
            $stmt->close();
            break;
        case 'delete-path':
            $_SESSION['PATH_ID'] = 0;
            $stmt = $conn->prepare('DELETE FROM Paths WHERE id=?');
            $stmt->bind_param('s', $_POST['id']);
            $stmt->execute();
            $stmt->close();
            break;
        case 'delete-pathgroup':
            $_SESSION['PATHGROUP_ID'] = 0;
            $stmt = $conn->prepare('DELETE FROM PathGroups WHERE id=?');
            $stmt->bind_param('s', $_POST['id']);
            $stmt->execute();
            $stmt->close();
            break;
        case 'delete-skill':
            $_SESSION['SKILL_ID'] = 0;
            $stmt = $conn->prepare('DELETE FROM Skills WHERE id=?');
            $stmt->bind_param('s', $_POST['id']);
            $stmt->execute();
            $stmt->close();
            break;
        case 'delete-weapon':
            $_SESSION['WEAPON_ID'] = 0;
            $stmt = $conn->prepare('DELETE FROM Weapons WHERE id=?');
            $stmt->bind_param('s', $_POST['id']);
            $stmt->execute();
            $stmt->close();
            break;
        case 'delete-armour':
            $_SESSION['ARMOUR_ID'] = 0;
            $stmt = $conn->prepare('DELETE FROM Armour WHERE id=?');
            $stmt->bind_param('s', $_POST['id']);
            $stmt->execute();
            $stmt->close();
            break;
        case 'delete-item':
            $_SESSION['ITEM_ID'] = 0;
            $stmt = $conn->prepare('DELETE FROM Items WHERE id=?');
            $stmt->bind_param('s', $_POST['id']);
            $stmt->execute();
            $stmt->close();
            break;
    }
    header('Location: /php/admin.php');
    exit();
}
?>