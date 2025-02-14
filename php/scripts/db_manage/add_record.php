<?php
include "../manager.php";
session_start();
$conn = connectToDB();

if (!isAdmin($_SESSION['username']))
    die('Not admin!');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_POST['action']) {
        case 'add-nation':
            $_SESSION['active_menu'] = 'nation-menu';
            $stmt = $conn->prepare('INSERT INTO Nations (name, description) VALUES (?, ?)');
            $stmt->bind_param("ss", $_POST['nation-name'], $_POST['nation-desc']);
            $stmt->execute();
            $stmt->close();
            break;
        case 'add-background':
            $_SESSION['active_menu'] = 'back-menu';
            $stmt = $conn->prepare('INSERT INTO Backgrounds (name, description) VALUES (?, ?)');
            $stmt->bind_param("ss", $_POST['background-name'], $_POST['background-desc']);
            $stmt->execute();
            $stmt->close();
            break;
        case 'add-path':
            $_SESSION['active_menu'] = 'path-menu';
            if ($_POST['type'] === 'path') {
                $stmt = $conn->prepare('INSERT INTO Paths (name, group_id,description) VALUES (?, ?, ?)');
                $stmt->bind_param("sss", $_POST['path-name'], $_POST['pathgroup'], $_POST['path-desc']);
                $stmt->execute();
                $stmt->close();
            } else {
                $stmt = $conn->prepare('INSERT INTO PathGroups (name, description) VALUES (?, ?)');
                $stmt->bind_param("ss", $_POST['path-name'], $_POST['path-desc']);
                $stmt->execute();
                $stmt->close();
            }
            break;
        case 'add-skill':
            $_SESSION['active_menu'] = 'skill-menu';
            $stmt = $conn->prepare('INSERT INTO Skills (name, description) VALUES (?, ?)');
            $stmt->bind_param("ss", $_POST['skill-name'], $_POST['skill-desc']);
            $stmt->execute();
            $stmt->close();
            break;
        case 'add-weapon':
            $_SESSION['active_menu'] = 'eq-inv-menu';
            $dice = $_POST['dice-num'] . $_POST['dice-type'];
            $stmt = $conn->prepare('INSERT INTO Weapons (name, type, dice, properties, description) VALUES (?, ?, ?, ?, ?)');
            $stmt->bind_param("sssss", $_POST['weapon-name'], $_POST['weapon-type'], $dice, $_POST['weapon-properties'], $_POST['weapon-desc']);
            $stmt->execute();
            $stmt->close();
            break;
        case 'add-armour':
            $_SESSION['active_menu'] = 'eq-inv-menu';
            $stmt = $conn->prepare('INSERT INTO Armour (name, value, dex_mod, description) VALUES (?, ?, ?, ?)');
            $stmt->bind_param("ssss", $_POST['armour-name'], $_POST['armour-value'], $_POST['armour-dexmod'], $_POST['armour-desc']);
            $stmt->execute();
            $stmt->close();
            break;
        case 'add-item':
            $_SESSION['active_menu'] = 'eq-inv-menu';
            $stmt = $conn->prepare('INSERT INTO Items (name, description) VALUES (?, ?)');
            $stmt->bind_param("ss", $_POST['item-name'], $_POST['item-desc']);
            $stmt->execute();
            $stmt->close();
            break;
    }
    header('Location: /php/admin.php');
    exit();
}
?>