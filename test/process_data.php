<?php
if (isset($_POST['data'])) {
    $received_data = $_POST['data'];
    echo 'Adat fogadva: ' . $received_data;
}
?>
