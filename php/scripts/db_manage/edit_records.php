<?php
include "../manager.php";
session_start();
$conn = connectToDB();

if (!isAdmin($_SESSION['username']))
    die('Not admin!');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    switch ($_POST["action"]) {
        case "edit-nation":
            $stmt = $conn->prepare("UPDATE Nations SET name=?, description=? WHERE id=?");
            $stmt->bind_param("ssi", $_POST['nation_edit_name'], $_POST['nation_edit_desc'], $_POST['id']);
            $stmt->execute();
            $stmt->close();
            break;
        case 'edit-background':
            $stmt = $conn->prepare("UPDATE Backgrounds SET name=?, description=? WHERE id=?");
            $stmt->bind_param("ssi", $_POST['edit-background-name'], $_POST['edit-background-desc'], $_POST['id']);
            $stmt->execute();
            $stmt->close();
            break;
        case 'edit-path':
            $stmt = $conn->prepare("UPDATE Paths SET name=?, description=?, group_id=? WHERE id=?");
            $stmt->bind_param("ssii", $_POST['edit-path-name'], $_POST['edit-path-desc'], $_POST['edit-path-pathgroup'], $_POST['id']);
            $stmt->execute();
            $stmt->close();
            break;
        case 'edit-pathgroup':
            $stmt = $conn->prepare("UPDATE PathGroups SET name=?, description=? WHERE id=?");
            $stmt->bind_param("ssi", $_POST['edit-group-name'], $_POST['edit-group-desc'], $_POST['id']);
            $stmt->execute();
            $stmt->close();
            break;
        case 'edit-skill':
            $stmt = $conn->prepare("UPDATE Skills SET name=?, description=? WHERE id=?");
            $stmt->bind_param("ssi", $_POST['skill_edit_name'], $_POST['skill_edit_desc'], $_POST['id']);
            $stmt->execute();
            $stmt->close();
            break;
        case 'edit-weapon':
            $dice = $_POST['edit_dice_num'] . $_POST['edit-dice-type'];
            $stmt = $conn->prepare("UPDATE Weapons SET name=?, type=?, dice=?, description=?, properties=? WHERE id=?");
            $stmt->bind_param("sssssi", $_POST['weapon_edit_name'], $_POST['weapon_edit_type'], $dice, $_POST['weapon_edit_desc'], $_POST['weapon_edit_properties'], $_POST['id']);
            $stmt->execute();
            $stmt->close();
            break;
        case 'edit-armour':
            $stmt = $conn->prepare("UPDATE Armour SET name=?, value=?, dex_mod=?, description=? WHERE id=?");
            $stmt->bind_param("siisi", $_POST['armour_edit_name'], $_POST['armour_edit_value'], $_POST['armour_edit_dexmod'], $_POST['armour_edit_desc'], $_POST['id']);
            $stmt->execute();
            $stmt->close();
            break;
        case 'edit-item':
            $stmt = $conn->prepare("UPDATE Items SET name=?, description=? WHERE id=?");
            $stmt->bind_param("ssi", $_POST['item_edit_name'], $_POST['item_edit_desc'], $_POST['id']);
            $stmt->execute();
            $stmt->close();
            break;
    }
    header('Location: /php/admin.php');
    exit();
}
?>