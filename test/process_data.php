<?php
include('../php/scripts/manager.php');
$conn = connectToDB();
session_start();
if (!isset($_SESSION['health'])) {
    $_SESSION['health'] = 100;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amout = intval($_POST['amount']);
    if ($_POST['action'] == 'add') {
        $_SESSION['health'] += $_POST['amount'];
    } else if ($_POST['action'] == 'subtract') {
        $_SESSION['health'] -= $_POST['amount'];
    }
    header('process_data.php');
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPG Stat Slot</title>
    <style>
        body {
            background-color: #777;
        }

        #div {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 250px;
            height: 250px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #444;
            color: whitesmoke;
            font-size: xx-large;
        }
    </style>
</head>

<body style>
    <div id="div">
        <form action="process_data.php" method="post">
            <button type="submit" name="action" value="subtract">damage</button>
            <input type="number" name="amount" id="amount" value="0" min="0" style="width: 5rem">
            <button type="submit" name="action" value="add">heal</button>
        </form>
        <span><?php echo $_SESSION['health'] ?></span>
    </div>
</body>

</html>