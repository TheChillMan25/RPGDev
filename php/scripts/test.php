<?php

use function PHPSTORM_META\type;

include 'manager.php';

$conn = connectToDB();
/* if ($conn->query('DROP DATABASE RPG_DB'))
    ; */
/* $sql = "DELETE FROM Paths";
if ($conn->query($sql) === TRUE) {
    echo "All data deleted from Users table.\n";
} else {
    echo "Data deletion failed.\n";
    die("Error in data deletion.\n" . $conn->error);
}*/
/*
$list['Kenyér'] = ["Alma", "Körte", "Dió"];
$list['Tejföl'] = ["Alma", "Körte", "Dió"];
$list['Sajt'] = ["Alma", "Körte", "Dió"];

echo '<select name="" id="">';
foreach ($list as $k => $v) {
    echo '<optgroup label="'.$k.'">';
    echo '<option value="default">Choose</option>';
    for ($i = 0; $i < count($v); $i++) {
        echo '<option value="'.strtolower($v[$i]).'">'.$v[$i].'</option>';
    }
    echo "</optgroup>";
}
echo '</select>'; */

$conn->query('UPDATE Users SET status="admin" WHERE username="TheChillMan25"');
$conn->close();

?>