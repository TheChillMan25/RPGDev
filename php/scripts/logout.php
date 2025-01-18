<?php
session_start();
session_unset();
session_destroy();
if(basename($_SERVER['SCRIPT_NAME']) === 'index.php') {
    header("Location: index.php");
} else {
    header("Location: ../../index.php");
}
exit();
?>