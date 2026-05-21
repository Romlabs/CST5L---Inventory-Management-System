<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);

session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>
