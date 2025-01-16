<?php

use function PHPSTORM_META\type;

include 'manager.php';

$conn = connectToDB();

$sql = "DELETE FROM Users";
if ($conn->query($sql) === TRUE) {
    echo "All data deleted from Users table.\n";
} else {
    echo "Data deletion failed.\n";
    die("Error in data deletion.\n" . $conn->error);
}
$conn->close();
?>