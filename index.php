<?php
session_start();

if (isset($_SESSION['username'])) {
    header('Location: pages/menu.php');
    exit;
} else {
    header('Location: pages/login.php');
    exit;
}
?>
