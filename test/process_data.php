<?php
include('../php/scripts/manager.php');
$conn = connectToDB();
session_start();
if (!isset($_SESSION['health'])) {
    $_SESSION['health'] = 1;
}
$health = $_SESSION['health'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['health']++;
    header('Location: process_data.php');
    exit();
}
$data = getTableData($conn, 'Nations');
for ($i = 0; $i < sizeof($data); $i++) {
    echo $data[$i]['name'] . ' - ';
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
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .stat-slot {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .stat-slot h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .stat {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }

        .stat label {
            font-weight: bold;
        }

        .stat .value {
            font-weight: bold;
            color: #2c3e50;
        }
    </style>
</head>

<body>
    <div class="stat-slot">
        <h2>Character Stats</h2>
        <div class="stat">
            <label>Strength:</label>
            <div class="value">15</div>
        </div>
        <div class="stat">
            <label>Dexterity:</label>
            <div class="value">12</div>
        </div>
        <div class="stat">
            <label>Intelligence:</label>
            <div class="value">14</div>
        </div>
        <div class="stat">
            <label>Health:</label>
            <div class="value"><?php echo $health ?></div>
        </div>
    </div>
    <form action="process_data.php" method="post"><button type="submit">+</button></form>
</body>

</html>